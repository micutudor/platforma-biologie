<?php

  require_once 'Config.php';

  class User
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($fName, $lName, $EMail, $Refferal, $Pass, $ExamType)
      {
          $Pass = hash('sha256', $Pass);

          do {
              $Code = generateRandomString(6);
          } while (!$this->isCodeUnique($Code));

          $CMD = $this->db->prepare("SELECT * FROM `users` WHERE `EMail` = :EMail");
          $CMD->bindParam(':EMail', $EMail);

          $CMD->execute();

          if($CMD->rowcount())
              return false;

          $CMD = $this->db->prepare("INSERT INTO `users` (`Code`, `fName`, `lName`, `EMail`, `Refferal`, `Password`, `ExamType`) VALUES (:Code, :fName, :lName, :EMail, :Refferal, :Pass, :ExamType)");
          $CMD->bindParam(':Code', $Code);
          $CMD->bindParam(':fName', $fName);
          $CMD->bindParam(':lName', $lName);
          $CMD->bindParam(':EMail', $EMail);
          $CMD->bindParam(':Refferal', $Refferal);
          $CMD->bindParam(':Pass', $Pass);
          $CMD->bindParam(':ExamType', $ExamType);

          $CMD->execute();

          return true;
      }

      public function login($EMail, $Pass)
      {
          $Pass = hash('sha256', $Pass);

          $CMD = $this->db->prepare("SELECT ID FROM `users` WHERE `EMail` = :EMail AND `Password` = :Pass");
          $CMD->bindParam(':EMail', $EMail);
          $CMD->bindParam(':Pass', $Pass);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          if ($result)
              return $result['ID'];

          return 0;
      }

      public function update($ID, $fName, $lName, $EMail, $ExamType)
      {
          $CMD = $this->db->prepare("UPDATE `users` SET `fName` = :fName, `lName` = :lName, `EMail` = :EMail, `ExamType` = :ExamType WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':fName', $fName);
          $CMD->bindParam(':lName', $lName);
          $CMD->bindParam(':EMail', $EMail);
          $CMD->bindParam(':ExamType', $ExamType);

          $CMD->execute();
      }

      public function updatePass($ID, $Pass)
      {
          $Pass = hash('sha256', $Pass);

          $CMD = $this->db->prepare("UPDATE `users` SET `Password` = :Pass WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Pass', $Pass);

          $CMD->execute();
      }

      public function exist($ID)
      {
          $CMD = $this->db->prepare("SELECT EMail FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          if ($CMD->rowcount())
              return true;

          return false;
      }

      public function isAdmin($ID)
      {
          $CMD = $this->db->prepare("SELECT Admin FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          if ($result['Admin'] == 1)
              return true;

          return false;
      }

      public function isCodeUnique($Code)
      {
          $CMD = $this->db->prepare("SELECT Code FROM `users` WHERE `Code` = :Code");
          $CMD->bindParam(':Code', $Code);

          $CMD->execute();

          if ($CMD->rowcount())
              return false;

          return true;
      }

      public function giveXP($ID, $XP)
      {
          $CMD = $this->db->prepare("UPDATE `users` SET `XP` = XP + :XP WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':XP', $XP);

          $CMD->execute();

          /* Update user's level */
          $userXP = $this->getXP($ID);
          $userLevel = $this->getLevel($ID);
          $requiredXP = ($userLevel + 1) * LEVEL_POINT;

          if ($userXP > $requiredXP)
          {
              $this->setLevel($ID, $userLevel + 1);
              $this->giveXP($ID, -1 * $requiredXP);
          }
      }

      public function giveCoins($ID, $Coins)
      {
          $CMD = $this->db->prepare("UPDATE `users` SET `Coins` = Coins + :Coins WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Coins', $Coins);

          $CMD->execute();
      }

      public function giveTrophy($ID)
      {
          $CMD = $this->db->prepare("UPDATE `users` SET `Trophies` = Trophies + 1 WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();
      }

      public function setLevel($ID, $Level, $giveCoins = true)
      {
          $CMD = $this->db->prepare("UPDATE `users` SET `Level` = :Level WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Level', $Level);

          if ($giveCoins)
          {
              $Refferal = $this->getRefferal($ID);

              $this->giveCoins($ID, 1);

              if (!is_null($Refferal))
              {
                  $RefferalID = $this->getIDByCode($Refferal);
                  $this->giveCoins($RefferalID, 1);
                  $this->giveXP($RefferalID, (30 / 100) * ($Level * LEVEL_POINT));
              }
          }

          $CMD->execute();
      }

      public function getIDByCode($Code)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `users` WHERE `Code` = :Code");
          $CMD->bindParam(':Code', $Code);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['ID'];
      }

      public function getCode($ID)
      {
          $CMD = $this->db->prepare("SELECT Code FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Code'];
      }

      public function getRefferal($ID)
      {
          $CMD = $this->db->prepare("SELECT Refferal FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Refferal'];
      }

      public function getXP($ID)
      {
          $CMD = $this->db->prepare("SELECT XP FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['XP'];
      }

      public function getCoins($ID)
      {
          $CMD = $this->db->prepare("SELECT Coins FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Coins'];
      }

      public function getLevel($ID)
      {
          $CMD = $this->db->prepare("SELECT Level FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Level'];
      }

      public function getAllQuizzes($ID)
      {
          $CMD = $this->db->prepare("SELECT Challenge FROM `quizzes` WHERE Solver = :Solver AND Challenge IS NOT NULL ORDER BY ID DESC");
          $CMD->bindParam(':Solver', $ID);
          $CMD->execute();

          return $CMD;
      }

      public function getFriends($Code)
      {
          $CMD = $this->db->prepare("SELECT * FROM `users` WHERE Refferal = :Code ORDER BY Level, XP, Trophies DESC");
          $CMD->bindParam(':Code', $Code);

          $CMD->execute();

          return $CMD;
      }

      public function getTrophies($ID)
      {
          $CMD = $this->db->prepare("SELECT Trophies FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Trophies'];
      }

      public function getAll($order_by)
      {
          if ($order_by == 'Level')
              $CMD = $this->db->prepare("SELECT * FROM `users` ORDER BY Level, XP DESC");
          else
              $CMD = $this->db->prepare("SELECT * FROM `users` ORDER BY Trophies DESC");

          $CMD->execute();

          return $CMD;
      }

      public function getPassHash($ID)
      {
          $CMD = $this->db->prepare("SELECT Password FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Password'];
      }

      public function getFName($ID)
      {
          $CMD = $this->db->prepare("SELECT fName FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['fName'];
      }

      public function getLName($ID)
      {
          $CMD = $this->db->prepare("SELECT lName FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['lName'];
      }

      public function getEMail($ID)
      {
          $CMD = $this->db->prepare("SELECT EMail FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['EMail'];
      }

      public function getExamType($ID)
      {
          $CMD = $this->db->prepare("SELECT ExamType FROM `users` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['ExamType'];
      }

      public function getLeaderboardRank($ID)
      {
          $usersData = $this->getAll('XP');

          $i = 0;
          foreach ($usersData as $userData)
          {
              $i ++;

              if ($userData['ID'] == $ID)
                  return $i;
          }
      }

      public function getAcceptedChallenges($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `challenges-invites` WHERE `invitedUser` = :ID AND `Status` = 1 ORDER BY ID DESC");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return $CMD;
      }

      public function getQuestionProgress($ID, $Question)
      {
          $CMD = $this->db->prepare("SELECT correctAnswers FROM `progress` WHERE `User` = :ID AND `Question` = :Question");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Question', $Question);

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['correctAnswers'];
      }

      public function deleteProgress($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `progress` WHERE `User` = :User");
          $CMD->bindParam(':User', $ID);

          $CMD->execute();

          return true;
      }

      public function getQuizzesGrades($ID)
      {
          $CMD = $this->db->prepare("SELECT Result FROM `quizzes` WHERE Solver = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return $CMD;
      }

      public function getQuizzesTimes($ID)
      {
          $CMD = $this->db->prepare("SELECT STime FROM `quizzes` WHERE Solver = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return $CMD;
      }

      public function countQuizzes($ID)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `quizzes` WHERE `Solver` = :User");
          $CMD->bindParam(":User", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countQuizzesWithMinGrade($ID, $Grade)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `quizzes` WHERE `Solver` = :User AND `Result` >= :Grade");
          $CMD->bindParam(":User", $ID);
          $CMD->bindParam(":Grade", $Grade);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countFriends($ID)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `friendships` WHERE (`userA` = :User OR `userB` = :user) AND `Status` = 1");
          $CMD->bindParam(":User", $ID);
          $CMD->bindParam(":user", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countChallenges($ID)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `quizzes` WHERE `Challenge` IS NOT NULL AND Solver = :User");
          $CMD->bindParam(":User", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countWonChallenges($ID)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `challenges` WHERE `Winner` = :User");
          $CMD->bindParam(":User", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countCorrectAnswers($ID, $Chapter)
      {
          $CMD = $this->db->prepare("SELECT correctAnswers FROM `progress` WHERE `User` = :User AND `questionChapter` = :Chapter");
          $CMD->bindParam(":User", $ID);
          $CMD->bindParam(":Chapter", $Chapter);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countFixedInfos($ID, $Chapter)
      {
          $CMD = $this->db->prepare("SELECT correctAnswers FROM `progress` WHERE (`User` = :User AND `questionChapter` = :Chapter) AND `correctAnswers` >= 3");
          $CMD->bindParam(":User", $ID);
          $CMD->bindParam(":Chapter", $Chapter);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countAllCorrectAnswers($ID)
      {
          $CMD = $this->db->prepare("SELECT correctAnswers FROM `progress` WHERE `User` = :User");
          $CMD->bindParam(":User", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countAllFixedInfos($ID)
      {
          $CMD = $this->db->prepare("SELECT correctAnswers FROM `progress` WHERE `User` = :User AND `correctAnswers` >= 3");
          $CMD->bindParam(":User", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }

      public function countUnseenMessages($ID)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `messages` WHERE `Receiver` = :User AND `Status` = 0");
          $CMD->bindParam(":User", $ID);

          $CMD->execute();

          return $CMD->rowcount();
      }
  }

?>

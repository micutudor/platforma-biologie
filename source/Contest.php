<?php

  require_once 'Config.php';

  class Contest
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($Name, $Description, $Category, $StartAt, $Length, $Prize)
      {
          $CMD = $this->db->prepare("INSERT INTO `contests` (`Name`, `Description`, `Category`, `SDateTime`, `Length`, `Prize`) VALUES (:Name, :Description, :Category, :SDateTime, :Length, :Prize)");
          $CMD->bindParam(':Name', $Name);
          $CMD->bindParam(':Description', $Description);
          $CMD->bindParam(':Category', $Category);
          $CMD->bindParam(':SDateTime', $StartAt);
          $CMD->bindParam(':Length', $Length);
          $CMD->bindParam(':Prize', $Prize);

          $CMD->execute();

          $CMD = $this->db->prepare("SELECT ID FROM `contests` ORDER BY ID DESC LIMIT 1");
          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['ID'];
      }

      public function update($ID, $Name, $Description, $Category, $StartAt, $Length, $Prize)
      {
          $CMD = $this->db->prepare("UPDATE `contests` SET `Name` = :Name, `Description` = :Description, `Category` = :Category, `SDateTime` = :SDateTime, `Length` = :Length, `Prize` = :Prize WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Name', $Name);
          $CMD->bindParam(':Description', $Description);
          $CMD->bindParam(':Category', $Category);
          $CMD->bindParam(':SDateTime', $StartAt);
          $CMD->bindParam(':Length', $Length);
          $CMD->bindParam(':Prize', $Prize);

          $CMD->execute();

          return true;
      }

      public function delete($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `contests` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return true;
      }

      public function hasUserParticipated($User, $ID)
      {
          $CMD = $this->db->prepare("SELECT Contest FROM `quizzes` WHERE `Contest` = :ID AND `Solver` = :User");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':User', $User);

          $CMD->execute();

          if ($CMD->rowcount())
              return true;

          return false;
      }

      public function exist($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `contests` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          if ($CMD->rowcount() == 0)
              return false;

          return true;
      }

      public function setStatus($ID, $Status)
      {
          $CMD = $this->db->prepare("UPDATE `contests` SET `Status` = :Status WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Status', $Status);

          $CMD->execute();
      }

      public function setWinner($ID, $Winner)
      {
          $CMD = $this->db->prepare("UPDATE `contests` SET `Winner` = :Winner WHERE `ID` = :Contest");
          $CMD->bindParam(':Contest', $ID);
          $CMD->bindParam(':Winner', $Winner);

          $CMD->execute();
      }

      public function getQuestions($ID)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `questions` WHERE Contest = :Contest");
          $CMD->bindParam(':Contest', $ID);

          $CMD->execute();

          return $CMD;
      }

      public function getLeaderboard($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `quizzes` WHERE `Contest` = :Contest ORDER BY Result DESC, STime ASC");
          $CMD->bindParam(':Contest', $ID);

          $CMD->execute();

          return $CMD;
      }

      public function getWinner($ID)
      {
          $CMD = $this->db->prepare("SELECT Winner FROM `contests` WHERE `ID` = :ID LIMIT 1");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Winner'];
      }

      public function getLength($ID)
      {
          $CMD = $this->db->prepare("SELECT Length FROM `contests` WHERE `ID` = :ID LIMIT 1");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Length'];
      }

      public function getLeader($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `quizzes` WHERE `Contest` = :Contest ORDER BY Result DESC, STime ASC LIMIT 1");
          $CMD->bindParam(':Contest', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Solver'];
      }

      public function getAll()
      {
          $CMD = $this->db->prepare("SELECT * FROM `contests` ORDER BY ID DESC");
          $CMD->execute();

          return $CMD;
      }

      public function getAllActive()
      {
          $CMD = $this->db->prepare("SELECT * FROM `contests` WHERE `Status` = 0 OR `Status` = 1 ORDER BY ID DESC");
          $CMD->execute();

          return $CMD;
      }

      public function getCategoryAll($Category)
      {
          $CMD = $this->db->prepare("SELECT * FROM `contests` WHERE `Category` = :Category ORDER BY ID DESC");
          $CMD->bindParam(':Category', $Category);

          $CMD->execute();

          return $CMD;
      }

      public function getData($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `contests` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result;
      }
  }

?>

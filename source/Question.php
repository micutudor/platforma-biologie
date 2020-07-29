<?php

  require_once 'Config.php';

  class Question
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function view($ID, $status = "WAITING_ANSWER", $userAnswer = "NOTHING")
      {
          ?>
            <div class="card">
              <div class="card-body">
                <h4 class="card-title text-center"><?= $this->getText($ID) ?></h4>
              </div>
            </div>

            <br>
          <?php

          $qType = $this->getType($ID);

          if ($status == "FEEDBACK")
              $qRightAnswer = $this->getRightAns($ID);

          if ($qType == 1) { ?>
              <div class="list-group">
                <a href="process.php?target=question&action=answer&answer=A" class="list-group-item list-group-item-action <?php if ($status == 'FEEDBACK') echo 'disabled'; ?>">
                  <?php
                    if ($status == "FEEDBACK")
                    {
                        if ($userAnswer == "A")
                            echo '<span class="badge badge-danger">Răspunsul tău:</span> &nbsp;';
                        else if ($qRightAnswer == 1)
                            echo '<span class="badge badge-success">Răspunsul corect:</span> &nbsp;';
                    }
                  ?>
                  A. <?= $this->getAnswer($ID, 'A') ?>
                </a>
                <a href="process.php?target=question&action=answer&answer=B" class="list-group-item list-group-item-action <?php if ($status == 'FEEDBACK') echo 'disabled'; ?>">
                  <?php
                    if ($status == "FEEDBACK")
                    {
                        if ($userAnswer == "B")
                            echo '<span class="badge badge-danger">Răspunsul tău:</span> &nbsp;';
                        else if ($qRightAnswer == 2)
                            echo '<span class="badge badge-success">Răspunsul corect:</span> &nbsp;';
                    }
                  ?>
                  B. <?= $this->getAnswer($ID, 'B') ?>
                </a>
                <a href="process.php?target=question&action=answer&answer=C" class="list-group-item list-group-item-action <?php if ($status == 'FEEDBACK') echo 'disabled'; ?>">
                  <?php
                    if ($status == "FEEDBACK")
                    {
                        if ($userAnswer == "C")
                            echo '<span class="badge badge-danger">Răspunsul tău:</span> &nbsp;';
                        else if ($qRightAnswer == 3)
                            echo '<span class="badge badge-success">Răspunsul corect:</span> &nbsp;';
                    }
                  ?>
                  C. <?= $this->getAnswer($ID, 'C') ?>
                </a>
                <a href="process.php?target=question&action=answer&answer=D" class="list-group-item list-group-item-action <?php if ($status == 'FEEDBACK') echo 'disabled'; ?>">
                  <?php
                    if ($status == "FEEDBACK")
                    {
                        if ($userAnswer == "D")
                            echo '<span class="badge badge-danger">Răspunsul tău:</span> &nbsp;';
                        else if ($qRightAnswer == 4)
                            echo '<span class="badge badge-success">Răspunsul corect:</span> &nbsp;';
                    }
                  ?>
                  D. <?= $this->getAnswer($ID, 'D') ?>
                </a>
              </div>
          <?php
          } else if ($qType == 2) { ?>
              <div class="list-group">
                <a href="process.php?target=question&action=answer&answer=A" class="list-group-item list-group-item-action <?php if ($status == 'FEEDBACK') echo 'disabled'; ?>">
                  <?php
                    if ($status == "FEEDBACK")
                    {
                        if ($userAnswer == "A")
                            echo '<span class="badge badge-danger">Răspunsul tău:</span> &nbsp;';
                        else if ($qRightAnswer == 1)
                            echo '<span class="badge badge-success">Răspunsul corect:</span> &nbsp;';
                    }
                  ?>
                  Adevărat
                </a>
                <a href="process.php?target=question&action=answer&answer=F" class="list-group-item list-group-item-action <?php if ($status == 'FEEDBACK') echo 'disabled'; ?>">
                  <?php
                    if ($status == "FEEDBACK")
                    {
                        if ($userAnswer == "F")
                            echo '<span class="badge badge-danger">Răspunsul tău:</span> &nbsp;';
                        else if ($qRightAnswer == 2)
                            echo '<span class="badge badge-success">Răspunsul corect:</span> &nbsp;';
                    }
                  ?>
                  Fals
                </a>
              </div>
          <?php
          } else { ?>
              <?php if ($status == "FEEDBACK") { ?>
                <div class="form-group">
                  <label for="inpAns">Răspunsul tău</label>
                  <input type="text" class="form-control form-control-alternative is-invalid" id="inpAns" value="<?= $userAnswer ?>" disabled>
                </div>
              <?php } else { ?>
                <form action="process.php?target=question&action=answer" method="post">
                  <input type="text" class="form-control" name="tyAns" placeholder="Răspunsul tău"><br>
                  <button type="submit" class="btn btn-success btn-block">Răspunde</button>
                </form>
              <?php } ?>
          <?php
          }
      }

      public function answer($questionID, $questionType, $userAnswer)
      {
          if ($questionType == 3)
          {
              $questionRightAnswer = $this->getAnswer($questionID, 'A');

              if ($userAnswer == $questionRightAnswer)
                  return true;

              return false;
          }
          else
          {
              $questionRightAnswer = $this->getRightAns($questionID);

              if ($questionType == 1)
                  $answers = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4);
              else if ($questionType == 2)
                  $answers = array('A' => 1, 'F' => 2);

              if ($answers[$userAnswer] == $questionRightAnswer)
                  return true;

              return false;
          }
      }

      public function create($Question, $Type, $Chapter, $Contest, $answerA, $answerB, $answerC, $answerD, $rightAnswer, $answerEx)
      {
          if ($Contest != 0)
              $Blocked = 1;
          else
              $Blocked = 0;

          $CMD = $this->db->prepare("INSERT INTO `questions` (`Question`, `Type`, `Chapter`, `Contest`, `Blocked`, `answerA`, `answerB`, `answerC`, `answerD`, `rightAnswer`, `answerEx`)
                                                      VALUES (:Question, :Type, :Chapter, :Contest, :Blocked, :ansA, :ansB, :ansC, :ansD, :rightAns, :ansEx)");
          $CMD->bindParam(':Question', $Question);
          $CMD->bindParam(':Type', $Type);
          $CMD->bindParam(':Chapter', $Chapter);
          $CMD->bindParam(':Contest', $Contest);
          $CMD->bindParam(':Blocked', $Blocked);
          $CMD->bindParam(':ansA', $answerA);
          $CMD->bindParam(':ansB', $answerB);
          $CMD->bindParam(':ansC', $answerC);
          $CMD->bindParam(':ansD', $answerD);
          $CMD->bindParam(':rightAns', $rightAnswer);
          $CMD->bindParam(':ansEx', $answerEx);

          $CMD->execute();

          return true;
      }

      public function update($ID, $Question, $Chapter, $Contest, $answerA, $answerB, $answerC, $answerD, $rightAnswer, $answerEx)
      {
          if ($Contest != 0)
              $Blocked = 1;
          else
              $Blocked = 0;

          $CMD = $this->db->prepare("UPDATE `questions` SET `Question` = :Question, `Chapter` = :Chapter, `Contest` = :Contest, `Blocked` = :Blocked, `answerA` = :ansA,
                                                            `answerB` = :ansB, `answerC` = :ansC, `answerD` = :ansD, `rightAnswer` = :rightAns, `answerEx` = :ansEx
                                                        WHERE ID = :ID");

          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Question', $Question);
          $CMD->bindParam(':Chapter', $Chapter);
          $CMD->bindParam(':Contest', $Contest);
          $CMD->bindParam(':Blocked', $Blocked);
          $CMD->bindParam(':ansA', $answerA);
          $CMD->bindParam(':ansB', $answerB);
          $CMD->bindParam(':ansC', $answerC);
          $CMD->bindParam(':ansD', $answerD);
          $CMD->bindParam(':rightAns', $rightAnswer);
          $CMD->bindParam(':ansEx', $answerEx);

          $CMD->execute();

          return true;
      }

      public function delete($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `questions` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return true;
      }

      public function getText($ID)
      {
          $CMD = $this->db->prepare("SELECT Question FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Question'];
      }

      public function getChapter($ID)
      {
          $CMD = $this->db->prepare("SELECT Chapter FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Chapter'];
      }

      public function getContest($ID)
      {
          $CMD = $this->db->prepare("SELECT Contest FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Contest'];
      }

      public function getType($ID)
      {
          $CMD = $this->db->prepare("SELECT Type FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Type'];
      }

      public function getAnswer($ID, $Answer)
      {
          $CMD = $this->db->prepare("SELECT answerA, answerB, answerC, answerD FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          switch ($Answer)
          {
              case 'A':
              {
                  return $result['answerA'];
              }

              case 'B':
              {
                  return $result['answerB'];
              }

              case 'C':
              {
                  return $result['answerC'];
              }

              case 'D':
              {
                  return $result['answerD'];
              }
          }
      }

      public function getRightAns($ID)
      {
          $CMD = $this->db->prepare("SELECT rightAnswer FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['rightAnswer'];
      }

      public function getAnsEx($ID)
      {
          $CMD = $this->db->prepare("SELECT answerEx FROM `questions` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['answerEx'];
      }

      public function getChapterAll($Chapter, $isTraining = false)
      {
          if ($isTraining)
              $CMD = $this->db->prepare("SELECT * FROM `questions` WHERE Chapter = :Chapter AND Blocked = 0 AND Contest = 0");
          else
              $CMD = $this->db->prepare("SELECT * FROM `questions` WHERE Chapter = :Chapter");

          $CMD->bindParam(':Chapter', $Chapter);

          $CMD->execute();

          return $CMD;
      }

      public function getAll()
      {
          $CMD = $this->db->prepare("SELECT * FROM `questions`");
          $CMD->execute();

          return $CMD;
      }

      public function getCategoryAll($Category)
      {
          $CMD = $this->db->prepare("SELECT * FROM `questions` WHERE Chapter IN (SELECT ID FROM `chapters` WHERE Category = :Category) AND `Blocked` = 0");
          $CMD->bindParam(':Category', $Category);

          $CMD->execute();

          return $CMD;
      }

      public function unblockQuestions($Contest)
      {
          $CMD = $this->db->prepare("UPDATE `questions` SET `Blocked` = 0 WHERE `Contest` = :Contest");
          $CMD->bindParam(':Contest', $Contest);

          $CMD->execute();
      }
  }

?>

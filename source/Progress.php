<?php

  require_once 'Config.php';

  class Progress
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($User, $Question, $questionChapter)
      {
          $CMD = $this->db->prepare("INSERT INTO `progress` (`User`, `Question`, `questionChapter`, `correctAnswers`) VALUES (:User, :Question, :questionChapter, '1')");
          $CMD->bindParam(':User', $User);
          $CMD->bindParam(':Question', $Question);
          $CMD->bindParam(':questionChapter', $questionChapter);

          $CMD->execute();
      }

      public function increase($User, $Question)
      {
          $CMD = $this->db->prepare("UPDATE `progress` SET `correctAnswers` = correctAnswers + 1 WHERE User = :User AND Question = :Question");
          $CMD->bindParam(':User', $User);
          $CMD->bindParam(':Question', $Question);

          $CMD->execute();
      }

      public function exist($User, $Question)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `progress` WHERE `User` = :User AND `Question` = :Question");
          $CMD->bindParam(':User', $User);
          $CMD->bindParam(':Question', $Question);

          $CMD->execute();

          if ($CMD->rowcount())
              return true;

          return false;
      }
  }

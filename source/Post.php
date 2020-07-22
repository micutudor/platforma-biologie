<?php

  require_once 'Config.php';

  class Post
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($CreatedBy, $Lesson, $Text)
      {
          $CMD = $this->db->prepare("INSERT INTO `posts` (`CreatedBy`, `Lesson`, `Text`) VALUES (:CreatedBy, :Lesson, :Txt)");
          $CMD->bindParam(':CreatedBy', $CreatedBy);
          $CMD->bindParam(':Lesson', $Lesson);
          $CMD->bindParam(':Txt', $Text);

          $CMD->execute();

          $CMD = $this->db->prepare("SELECT ID FROM `posts` WHERE CreatedBy = :CreatedBy ORDER BY ID DESC LIMIT 1");
          $CMD->bindParam(':CreatedBy', $CreatedBy);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['ID'];
      }

      public function delete($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `posts` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return true;
      }

      public function exist($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `posts` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          if ($CMD->rowcount() == 0)
              return false;

          return true;
      }

      public function isAwardGiven($ID)
      {
          $CMD = $this->db->prepare("SELECT BestReply FROM `posts` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          if ($result['BestReply'] == 0)
              return false;

          return true;
      }

      public function setAwardedReply($ID, $Reply)
      {
          $CMD = $this->db->prepare("UPDATE `posts` SET BestReply = :Reply WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Reply', $Reply);

          $CMD->execute();
      }

      public function getLesson($ID)
      {
          $CMD = $this->db->prepare("SELECT Lesson FROM `posts` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Lesson'];
      }

      public function getCreator($ID)
      {
          $CMD = $this->db->prepare("SELECT CreatedBy FROM `posts` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['CreatedBy'];
      }

      public function getReplies($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `replies` WHERE `Post` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return $CMD;
      }
  }

?>

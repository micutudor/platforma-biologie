<?php

  require_once 'Config.php';

  class Lesson
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($Title, $Chapter, $Content)
      {
          $CMD = $this->db->prepare("INSERT INTO `lessons` (`Title`, `Chapter`, `Content`) VALUES (:Title, :Chapter, :Content)");
          $CMD->bindParam(':Title', $Title);
          $CMD->bindParam(':Chapter', $Chapter);
          $CMD->bindParam(':Content', $Content);

          $CMD->execute();

          return true;
      }

      public function exist($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `lessons` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          if ($CMD->rowcount() == 0)
              return false;

          return true;
      }

      public function update($ID, $Title, $Chapter, $Content)
      {
          $CMD = $this->db->prepare("UPDATE `lessons` SET `Title` = :Title, `Chapter` = :Chapter, `Content` = :Content WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Title', $Title);
          $CMD->bindParam(':Chapter', $Chapter);
          $CMD->bindParam(':Content', $Content);

          $CMD->execute();

          return true;
      }

      public function delete($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `lessons` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return true;
      }

      public function getTitle($ID)
      {
          $CMD = $this->db->prepare("SELECT Title FROM `lessons` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Title'];
      }

      public function getContent($ID)
      {
          $CMD = $this->db->prepare("SELECT Content FROM `lessons` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Content'];
      }

      public function getChapter($ID)
      {
          $CMD = $this->db->prepare("SELECT Chapter FROM `lessons` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Chapter'];
      }

      public function getAll()
      {
          $CMD = $this->db->prepare("SELECT * FROM `lessons`");
          $CMD->execute();

          return $CMD;
      }

      public function getPosts($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `posts` WHERE `Lesson` = :ID");
          $CMD->bindParam(':ID', $ID);
          
          $CMD->execute();

          return $CMD;
      }

      public function getChapterAll($Chapter)
      {
          $CMD = $this->db->prepare("SELECT * FROM `lessons` WHERE `Chapter` = :Chapter");
          $CMD->bindParam(':Chapter', $Chapter);

          $CMD->execute();

          return $CMD;
      }
  }

?>

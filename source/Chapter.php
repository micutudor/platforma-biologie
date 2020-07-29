<?php

  require_once 'Config.php';

  class Chapter
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($Title, $Description, $Level, $Category)
      {
          $CMD = $this->db->prepare("INSERT INTO `chapters` (`Title`, `Description`, `Category`) VALUES (:Title, :Description, :Category)");
          $CMD->bindParam(':Title', $Title);
          $CMD->bindParam(':Description', $Description);
          $CMD->bindParam(':Level', $Level);
          $CMD->bindParam(':Category', $Category);

          $CMD->execute();

          return true;
      }

      public function update($ID, $Title, $Description, $Level, $Category)
      {
          $CMD = $this->db->prepare("UPDATE `chapters` SET `Title` = :Title, `Description` = :Description, `Level` = :Level, `Category` = :Category WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);
          $CMD->bindParam(':Title', $Title);
          $CMD->bindParam(':Description', $Description);
          $CMD->bindParam(':Level', $Level);
          $CMD->bindParam(':Category', $Category);

          $CMD->execute();

          return true;
      }

      public function delete($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `chapters` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return true;
      }

      public function getTitle($ID)
      {
          $CMD = $this->db->prepare("SELECT Title FROM `chapters` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Title'];
      }

      public function getCategory($ID)
      {
          $CMD = $this->db->prepare("SELECT Category FROM `chapters` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Category'];
      }

      public function getLevel($ID)
      {
          $CMD = $this->db->prepare("SELECT Level FROM `chapters` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Level'];
      }

      public function getDescription($ID)
      {
          $CMD = $this->db->prepare("SELECT Description FROM `chapters` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Description'];
      }

      public function getAll()
      {
          $CMD = $this->db->prepare("SELECT * FROM `chapters`");
          $CMD->execute();

          return $CMD;
      }

      public function getCategoryAll($Category)
      {
          $CMD = $this->db->prepare("SELECT * FROM `chapters` WHERE Category = :Category");
          $CMD->bindParam(':Category', $Category);

          $CMD->execute();

          return $CMD;
      }

      public function countLessons($Chapter)
      {
          $CMD = $this->db->prepare("SELECT COUNT(ID) as count FROM `lessons` WHERE Chapter = :Chapter");
          $CMD->bindParam(':Chapter', $Chapter);
          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['count'];
      }

      public function countQuestions($Chapter)
      {
          $CMD = $this->db->prepare("SELECT COUNT(ID) as count FROM `questions` WHERE Chapter = :Chapter AND Contest = 0");
          $CMD->bindParam(':Chapter', $Chapter);
          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['count'];
      }
  }

?>

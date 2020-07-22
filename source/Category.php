<?php

  require_once 'Config.php';

  class Category
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function getAll()
      {
          $CMD = $this->db->prepare("SELECT * FROM `categories`");
          $CMD->execute();

          return $CMD;
      }

      public function getTitle($ID)
      {
          $CMD = $this->db->prepare("SELECT Title FROM `categories` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Title'];
      }

      public function getColor($ID)
      {
          $CMD = $this->db->prepare("SELECT Color FROM `categories` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Color'];
      }
  }

?>

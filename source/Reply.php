<?php

  require_once 'Config.php';

  class Reply
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function create($CreatedBy, $Post, $Text)
      {
          $CMD = $this->db->prepare("INSERT INTO `replies` (`CreatedBy`, `Post`, `Text`) VALUES (:CreatedBy, :Post, :Txt)");
          $CMD->bindParam(':CreatedBy', $CreatedBy);
          $CMD->bindParam(':Post', $Post);
          $CMD->bindParam(':Txt', $Text);

          $CMD->execute();

          $CMD = $this->db->prepare("SELECT ID FROM `replies` WHERE CreatedBy = :CreatedBy ORDER BY ID DESC LIMIT 1");
          $CMD->bindParam(':CreatedBy', $CreatedBy);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['ID'];
      }

      public function exist($ID)
      {
          $CMD = $this->db->prepare("SELECT * FROM `replies` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          if ($CMD->rowcount() == 0)
              return false;

          return true;
      }

      public function delete($ID)
      {
          $CMD = $this->db->prepare("DELETE FROM `replies` WHERE ID = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          return true;
      }

      public function getPost($ID)
      {
          $CMD = $this->db->prepare("SELECT Post FROM `replies` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Post'];
      }

      public function getCreator($ID)
      {
          $CMD = $this->db->prepare("SELECT CreatedBy FROM `replies` WHERE `ID` = :ID");
          $CMD->bindParam(':ID', $ID);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['CreatedBy'];
      }
  }

?>

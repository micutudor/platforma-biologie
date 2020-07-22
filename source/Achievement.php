<?php

  require_once 'Config.php';

  class Achievement
  {
      private $db;

      public function __construct()
      {
          $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }

      public function unlock($UnlockedBy, $Achievement)
      {
          $CMD = $this->db->prepare("INSERT INTO `achievements` (`UnlockedBy`, `Achievement`) VALUES (:UnlockedBy, :Achievement)");
          $CMD->bindParam(':UnlockedBy', $UnlockedBy);
          $CMD->bindParam(':Achievement', $Achievement);

          $CMD->execute();
      }

      public function claim($UnlockedBy, $Achievement)
      {
          $CMD = $this->db->prepare("UPDATE `achievements` SET `Claimed` = 1 WHERE `UnlockedBy` = :UnlockedBy AND `Achievement` = :Achievement");
          $CMD->bindParam(':UnlockedBy', $UnlockedBy);
          $CMD->bindParam(':Achievement', $Achievement);

          $CMD->execute();
      }

      public function hasUserUnlocked($User, $Achievement)
      {
          $CMD = $this->db->prepare("SELECT ID FROM `achievements` WHERE `UnlockedBy` = :UnlockedBy AND `Achievement` = :Achievement");
          $CMD->bindParam(':UnlockedBy', $User);
          $CMD->bindParam(':Achievement', $Achievement);

          $CMD->execute();

          if ($CMD->rowcount())
              return true;

          return false;
      }

      public function hasUserClaimed($User, $Achievement)
      {
          $CMD = $this->db->prepare("SELECT Claimed FROM `achievements` WHERE `UnlockedBy` = :UnlockedBy AND `Achievement` = :Achievement");
          $CMD->bindParam(':UnlockedBy', $User);
          $CMD->bindParam(':Achievement', $Achievement);

          $CMD->execute();

          $result = $CMD->fetch(PDO::FETCH_ASSOC);

          return $result['Claimed'];
      }
  }

<?php

require_once 'Config.php';
require_once 'utils.php';

class Challenge
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function create($CreatedBy)
    {
    	do {
            $Code = generateRandomString(6);
        } while (!$this->isCodeUnique($Code));

        $ExpireAt = new DateTime();
        $ExpireAt->add(new DateInterval("PT24H"));

        $CMD = $this->db->prepare("INSERT INTO `challenges` (`Code`, `CreatedBy`, `ExpireAt`) VALUES (:Code, :CreatedBy, :ExpireAt)");
        $CMD->bindParam(':Code', $Code);
        $CMD->bindParam(':CreatedBy', $CreatedBy);
        $CMD->bindParam(':ExpireAt', $ExpireAt->format('Y-m-d H:i:s'));

        $CMD->execute();

        return $Code;
    }

    public function exist($Code)
    {
        $CMD = $this->db->prepare("SELECT Code FROM `challenges` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        if ($CMD->rowcount())
            return true;

        return false;
    }

    public function isCodeUnique($Code)
    {
        $CMD = $this->db->prepare("SELECT Code FROM `challenges` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        if ($CMD->rowcount())
            return false;

        return true;
    }

    public function hasUserParticipated($Code, $User)
    {
        $CMD = $this->db->prepare("SELECT Challenge FROM `quizzes` WHERE `Challenge` = :Code AND `Solver` = :User");
        $CMD->bindParam(':Code', $Code);
        $CMD->bindParam(':User', $User);

        $CMD->execute();

        if ($CMD->rowcount())
            return true;

        return false;
    }

    public function setStatus($Code, $Status)
    {
      	$CMD = $this->db->prepare("UPDATE `challenges` SET `Status` = :Status WHERE `Code` = :Code");
      	$CMD->bindParam(':Code', $Code);
      	$CMD->bindParam(':Status', $Status);

      	$CMD->execute();
    }

    public function setWinner($Code, $WinnerID)
    {
      	$CMD = $this->db->prepare("UPDATE `challenges` SET `Winner` = :Winner WHERE `Code` = :Code");
      	$CMD->bindParam(':Code', $Code);
      	$CMD->bindParam(':Winner', $WinnerID);

      	$CMD->execute();
    }

    public function getLeaderboard($Code)
    {
    	  $CMD = $this->db->prepare("SELECT * FROM `quizzes` WHERE `Challenge` = :Code ORDER BY Result DESC, STime ASC");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        return $CMD;
    }

    public function getLeader($Code)
    {
    	  $CMD = $this->db->prepare("SELECT * FROM `quizzes` WHERE `Challenge` = :Code ORDER BY Result DESC, STime ASC LIMIT 1");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Solver'];
    }

    public function getActiveChallenges()
    {
    	  $CMD = $this->db->prepare("SELECT * FROM `challenges` WHERE `Status` = 0");
        $CMD->execute();

        return $CMD;
    }

    public function getWinner($Code)
    {
    	  $CMD = $this->db->prepare("SELECT Winner FROM `challenges` WHERE `Code` = :Code LIMIT 1");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Winner'];
    }

    public function getQuestions($Code)
    {
    	  $CMD = $this->db->prepare("SELECT Questions FROM `quizzes` WHERE `Challenge` = :Code LIMIT 1");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Questions'];
    }

    public function getStatus($Code)
    {
        $CMD = $this->db->prepare("SELECT Status FROM `challenges` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Status'];
    }

    public function getExpireTime($Code)
    {
        $CMD = $this->db->prepare("SELECT ExpireAt FROM `challenges` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['ExpireAt'];
    }

    public function getCreator($Code)
    {
        $CMD = $this->db->prepare("SELECT CreatedBy FROM `challenges` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['CreatedBy'];
    }

    public function countParticipants($Code)
    {
    	$CMD = $this->db->prepare("SELECT * FROM `quizzes` WHERE `Challenge` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        return $CMD->rowcount();
    }

}

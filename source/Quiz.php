<?php

require_once 'Config.php';
require_once 'utils.php';

class Quiz
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function create($Solver, $STime, $Questions, $Result)
    {
        do {
            $Code = generateRandomString(6);
        } while (!$this->isCodeUnique($Code));

        $CMD = $this->db->prepare("INSERT INTO `quizzes` (`Code`, `Solver`, `STime`, `Questions`, `Result`) VALUES (:Code, :Solver, :STime, :Questions, :Result)");
        $CMD->bindParam(':Code', $Code);
        $CMD->bindParam(':Solver', $Solver);
        $CMD->bindParam(':STime', $STime);
        $CMD->bindParam(':Questions', $Questions);
        $CMD->bindParam(':Result', $Result);

        $CMD->execute();

        return $Code;
    }

    public function isCodeUnique($Code)
    {
        $CMD = $this->db->prepare("SELECT Code FROM `quizzes` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        if ($CMD->rowcount())
            return false;

        return true;
    }

    public function hasChallenge($Code)
    {
        $CMD = $this->db->prepare("SELECT Challenge FROM `quizzes` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        if (is_null($result['Challenge']))
            return false;

        return true;
    }

    public function setContestByCode($Code, $Contest)
    {
        $CMD = $this->db->prepare("UPDATE `quizzes` SET Contest = :Contest WHERE Code = :Code");
        $CMD->bindParam(':Contest', $Contest);
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();
    }

    public function setChallengeByCode($Code, $Challenge)
    {
        $CMD = $this->db->prepare("UPDATE `quizzes` SET Challenge = :Challenge WHERE Code = :Code");
        $CMD->bindParam(':Challenge', $Challenge);
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();
    }

    public function getSolverByCode($Code)
    {
        $CMD = $this->db->prepare("SELECT Solver FROM `quizzes` WHERE `Code` = :Code");
        $CMD->bindParam(':Code', $Code);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Solver'];
    }

    public function getStartTime($ID)
    {
        $CMD = $this->db->prepare("SELECT StartedAt FROM `quizzes` WHERE `ID` = :ID");
        $CMD->bindParam(':ID', $ID);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['StartedAt'];
    }

    public function getFinishTime($ID)
    {
        $CMD = $this->db->prepare("SELECT FinishedAt FROM `quizzes` WHERE `ID` = :ID");
        $CMD->bindParam(':ID', $ID);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['FinishedAt'];
    }

    public function getQuestions($ID)
    {
        $CMD = $this->db->prepare("SELECT Questions FROM `quizzes` WHERE `ID` = :ID");
        $CMD->bindParam(':ID', $ID);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Questions'];
    }

    public function getResult($ID)
    {
        $CMD = $this->db->prepare("SELECT Result FROM `quizzes` WHERE `ID` = :ID");
        $CMD->bindParam(':ID', $ID);

        $CMD->execute();

        $result = $CMD->fetch(PDO::FETCH_ASSOC);

        return $result['Result'];
    }
}

?>

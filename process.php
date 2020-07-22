<?php

  session_start();

  require_once 'source/User.php';
  require_once 'source/Chapter.php';
  require_once 'source/Lesson.php';
  require_once 'source/Question.php';
  require_once 'source/Progress.php';
  require_once 'source/Quiz.php';
  require_once 'source/Achievement.php';
  require_once 'source/Challenge.php';
  require_once 'source/Category.php';
  require_once 'source/Post.php';
  require_once 'source/Reply.php';
  require_once 'source/Contest.php';

  if (!isset($_GET['action']) || !isset($_GET['target']))
  {
      $target = 'error';
      $action = 'show';
  }
  else
  {
      $target = $_GET['target'];
      $action = $_GET['action'];
  }

  switch ($target)
  {
      case 'user':
      {
          switch ($action)
          {
              case 'sign-up':
              {
                  if (isset($_POST['registerBtn']))
                  {

                      if ($_POST['tyPass'] == $_POST['retyPass'])
                      {
                          $user = new User();

                          if (strlen($_POST['tyFName']) == 0 || strlen($_POST['tyLName']) == 0 || strlen($_POST['tyEMail']) == 0 || strlen($_POST['tyPass']) == 0 || strlen($_POST['retyPass']) == 0)
                          {
                              $_SESSION['Error'] = "Toate câmpurile sunt obligatorii!";
                              header('Location: index.php?error=true');
                              die('redirect');
                          }

                          if (strlen($_POST['tyRefferal']) > 0 && $user->isCodeUnique($_POST['tyRefferal']))
                          {
                              $_SESSION['Error'] = "Cod invalid!";
                              header('Location: index.php?error=true');
                              die('redirect');
                          }

                          if ($user->create($_POST['tyFName'], $_POST['tyLName'], $_POST['tyEMail'], $_POST['tyRefferal'], $_POST['tyPass'], $_POST['selExamType']))
                              header('Location: log-in.php?success=true');
                          else
                          {
                              $_SESSION['Error'] = "Adresă de poștă electronică în uz!";
                              header('Location: index.php?error=true');
                          }
                      }
                      else
                      {
                          $_SESSION['Error'] = "Parolele introduse nu se potrivesc!";
                          header('Location: index.php?error=true');
                      }
                  }

                  break;
              }

              case 'log-in':
              {
                  if (isset($_POST['loginBtn']))
                  {
                      $user = new User();

                      if ($ID = $user->login($_POST['tyEMail'], $_POST['tyPass']))
                      {
                          $_SESSION['LoggedIn'] = true;
                          $_SESSION['ID'] = $ID;

                          header('Location: index.php');
                      }
                      else
                          header('Location: log-in.php?error=true');
                  }

                  break;
              }

              case 'update':
              {
                  if ($_SESSION['ID'] == $_GET['target_id'])
                  {
                      $user = new User();
                      $user->update($_GET['target_id'], $_POST['tyFName'], $_POST['tyLName'], $_POST['tyEMail'], $_POST['selExamType']);

                      $achievement = new Achievement();

                      if (!$achievement->hasUserUnlocked($_SESSION['ID'], 2)) {
                          $achievement->unlock($_SESSION['ID'], 2);
                      }

                      $_SESSION['Success'] = "Informații actualizate cu succes!";
                      header('Location: settings.php');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'change-password':
              {
                  if ($_SESSION['ID'] == $_GET['target_id'])
                  {
                      $user = new User();

                      if (hash('sha256', $_POST['tyPass']) == $user->getPassHash($_SESSION['ID']))
                      {
                          if ($_POST['tyNPass'] == $_POST['retyNPass'])
                          {
                              $user->updatePass($_GET['target_id'], $_POST['tyNPass']);
                              $_SESSION['Success'] = "Parola contului a fost schimbată cu succes!";
                          }
                          else
                              $_SESSION['Error'] = "Parolele introduse nu se potrivesc!";
                      }
                      else
                          $_SESSION['Error'] = "Parola introdusă nu se potrivește cu cea aleasă la înregistrare!";

                      header('Location: settings.php?page=change-password');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'search':
              {
                  if ($_SESSION['LoggedIn'])
                  {
                      if (strlen($_POST['tySearch']) >= 3)
                          header('Location: community.php?page=people&search_q='.$_POST['tySearch']);
                      else
                      {
                          $_SESSION['Error'] = "Căutarea ta trebuie să conțină minim 3 caractere!";
                          header('Location: community.php?page=people');
                      }
                  }
                  else
                      header('Location: error.php');
              }

              default:
              {
                  // 404
              }
          }

          break;
      }

      case 'chapter':
      {
          switch ($action)
          {
              case 'create':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $chapter = new Chapter();
                      $chapter->create($_POST['tyTitle'], $_POST['tyDescription'], $_POST['tyLevel'], $_POST['selCategory']);

                      $_SESSION['Success'] = "Capitol creat cu succes!";
                      header('Location: chapters.php?success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'edit':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $chapter = new Chapter();
                      $chapter->update($_GET['target_id'], $_POST['tyTitle'], $_POST['tyDescription'], $_POST['tyLevel'], $_POST['selCategory']);

                      $_SESSION['Success'] = "Capitol modificat cu succes!";
                      header('Location: chapters.php?success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'delete':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $chapter = new Chapter();
                      $chapter->delete($_GET['target_id']);

                      $_SESSION['Success'] = "Capitol șters cu succes!";
                      header('Location: chapters.php?success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              default:
              {

              }
          }

          break;
      }

      case 'lesson':
      {
          switch ($action)
          {
              case 'create':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $lesson = new Lesson();
                      $lesson->create($_POST['tyTitle'], $_POST['selChapter'], $_POST['tyContent']);

                      $_SESSION['Success'] = "Lecție creată cu succes!";
                      header('Location: chapters.php?chapter='.$_POST['selChapter'].'&success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'edit':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $lesson = new Lesson();
                      $lesson->update($_GET['target_id'], $_POST['tyTitle'], $_POST['selChapter'], $_POST['tyContent']);

                      $_SESSION['Success'] = "Lecție modificată cu succes!";
                      header('Location: lesson.php?lesson='.$_GET['target_id'].'&success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'delete':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $lesson = new Lesson();

                      $lessonChapter = $lesson->getChapter($_GET['target_id']);
                      $lesson->delete($_GET['target_id']);

                      $_SESSION['Success'] = "Lecție ștearsă cu succes!";
                      header('Location: chapters.php?chapter='.$lessonChapter.'&success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }
          }

          break;
      }

      case 'question':
      {
          switch ($action)
          {
              case 'create':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $question = new Question();

                      if ($_GET['type'] == 1)
                          $question->create($_POST['tyQuestion'], $_GET['type'], $_POST['selChapter'], $_POST['selContest'], $_POST['tyAnsA'], $_POST['tyAnsB'], $_POST['tyAnsC'], $_POST['tyAnsD'], $_POST['selRightAns'], $_POST['tyAnsEx']);
                      else if ($_GET['type'] == 2)
                          $question->create($_POST['tyQuestion'], $_GET['type'], $_POST['selChapter'], $_POST['selContest'], null, null, null, null, $_POST['selRightAns'], $_POST['tyAnsEx']);
                      else
                          $question->create($_POST['tyQuestion'], $_GET['type'], $_POST['selChapter'], $_POST['selContest'], $_POST['tyAns'], null, null, null, 0, $_POST['tyAnsEx']);

                      $_SESSION['Success'] = "Întrebare adăugată cu succes!";
                      header('Location: chapters.php?chapter='.$_POST['selChapter'].'&success=true');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'edit':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $question = new Question();

                      $qType = $question->getType($_GET['target_id']);

                      if ($qType == 1)
                          $question->update($_GET['target_id'], $_POST['tyQuestion'], $_POST['selChapter'], $_POST['selContest'], $_POST['tyAnsA'], $_POST['tyAnsB'], $_POST['tyAnsC'], $_POST['tyAnsD'], $_POST['selRightAns'], $_POST['tyAnsEx']);
                      else if ($qType == 2)
                          $question->update($_GET['target_id'], $_POST['tyQuestion'], $_POST['selChapter'], $_POST['selContest'], null, null, null, null, $_POST['selRightAns'], $_POST['tyAnsEx']);
                      else
                          $question->update($_GET['target_id'], $_POST['tyQuestion'], $_POST['selChapter'], $_POST['selContest'], $_POST['tyAns'], null, null, null, 0, $_POST['tyAnsEx']);

                      $_SESSION['Success'] = "Întrebare modificată cu succes!";
                      header('Location: question.php?question='.$_GET['target_id']);
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'delete':
              {
                  $user = new User();

                  if ($user->isAdmin($_SESSION['ID']))
                  {
                      $question = new Question();
                      $questionChapter = $question->getChapter($_GET['target_id']);

                      $question->delete($_GET['target_id']);

                      $_SESSION['Success'] = "Întrebare ștearsă cu succes!";
                      header('Location: chapters.php?chapter='.$questionChapter);
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'answer':
              {
                  $question = new Question();

                  if (!isset($_SESSION['doingNow']))
                      header('Location: error.php');

                  if ($_SESSION['doingNow'] == "EXAM")
                  {
                      $questionID = $_SESSION['qQuestions'][$_SESSION['qProgress']];

                      if ($_SESSION['inContest'] == false) {
                          if (STATUS == "DEV") $qLength = 5; else $qLength = 20;
                      } else $qLength = $_SESSION['contestLength'];
                  }
                  else if ($_SESSION['doingNow'] == "TRAINING")
                  {
                      $questionID = $_SESSION['tQuestions'][$_SESSION['tProgress']];

                      $chapter = new Chapter();
                      $tLength = $chapter->countQuestions($_SESSION['tChapter']);
                  }
                  else
                      header('Location: error.php');

                  $questionType = $question->getType($questionID);

                  if ($questionType == 1 || $questionType == 2)
                      if (isset($_GET['answer']))
                          $userAnswer = $_GET['answer'];
                      else
                          header('Location: error.php');
                  else
                      $userAnswer = $_POST['tyAns'];

                  if ($question->answer($questionID, $questionType, $userAnswer))
                  {
                      if ($_SESSION['doingNow'] == "EXAM")
                      {
                          $_SESSION['qGAns'] ++;

                          $_SESSION['qProgress'] ++;

                          if ($_SESSION['qProgress'] == $qLength)
                              $_SESSION['doingNow'] = "FINISH_EXAM";
                      }
                      else if ($_SESSION['doingNow'] == "TRAINING")
                      {
                          $_SESSION['tGAns'] ++;

                          /* Update question progress */
                          $progress = new Progress();

                          if ($progress->exist($_SESSION['ID'], $questionID))
                              $progress->increase($_SESSION['ID'], $questionID);
                          else
                              $progress->create($_SESSION['ID'], $questionID, $_SESSION['tChapter']);

                          $user = new User();

                          /* Give XP for the answer */
                          if ($user->getQuestionProgress($_SESSION['ID'], $_SESSION['tChapter'][$_SESSION['tChapter']]) < 3)
                              $user->giveXP($_SESSION['ID'], 1);
                          else
                              $user->giveXP($_SESSION['ID'], 2);

                          /* Give achievements */
                          $achievement = new Achievement();

                          $cPerentage = floor(
                            ($user->countCorrectAnswers($_SESSION['ID'], $_SESSION['tChapter']) / $chapter->countQuestions($_SESSION['tChapter'])) * 50
                          + ($user->countFixedInfos($_SESSION['ID'], $_SESSION['tChapter']) / $chapter->countQuestions($_SESSION['tChapter']) * 50)
                          );

                          if ($cPerentage == 100)
                          {
                              $user->giveXP($_SESSION['ID'], 200);

                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 3)) {
                                  $achievement->unlock($_SESSION['ID'], 3);
                              }

                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 20))
                              {
                                  $chaptersData = $chapter->getAll();

                                  $sPercentage = 0;
                                  $c = 0;

                                  foreach ($chaptersData as $chapterData)
                                  {
                                      $c ++;

                                      $gaPercentage = $user->countCorrectAnswers($_SESSION['ID'], $_SESSION['tChapter'])
                                                      / $chapter->countQuestions($_SESSION['tChapter']) * 50;

                                      $fiPercentage = $user->countFixedInfos($_SESSION['ID'], $_SESSION['tChapter'])
                                                      / $chapter->countQuestions($_SESSION['tChapter']) * 50;

                                      $sPercentage += floor($gaPercentage + $fiPercentage);
                                  }

                                  $gPercentage = floor(($sPercentage / ($c * 100)) * 100);

                                  if ($gPercentage == 100)
                                      $achievement->unlock($_SESSION['ID'], 20);
                              }
                          }

                          if (!$achievement->hasUserUnlocked($_SESSION['ID'], 4)) {
                              $achievement->unlock($_SESSION['ID'], 4);
                          }

                          /* User good answers achievements */
                          $userCA = $user->countAllCorrectAnswers($_SESSION['ID']);

                          if ($userCA == 50)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 5))
                                  $achievement->unlock($_SESSION['ID'], 5);
                          }
                          else if ($userCA == 100)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 6))
                                  $achievement->unlock($_SESSION['ID'], 6);
                          }

                          /* User fixed infos achievements */
                          $userFI = $user->countAllFixedInfos($_SESSION['ID']);

                          if ($userFI == 1)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 7))
                                  $achievement->unlock($_SESSION['ID'], 7);
                          }
                          else if ($userFI == 50)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 8))
                                  $achievement->unlock($_SESSION['ID'], 8);
                          }
                          else if ($userFI == 100)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 9))
                                  $achievement->unlock($_SESSION['ID'], 9);
                          }

                          $_SESSION['tProgress'] ++;

                          if ($_SESSION['tProgress'] == $tLength)
                              $_SESSION['doingNow'] = "FINISH_TRAINING";
                      }
                  }
                  else
                  {
                      if ($_SESSION['doingNow'] == "EXAM")
                      {
                          $_SESSION['qWAns'] ++;

                          $_SESSION['qProgress'] ++;

                          if ($_SESSION['qProgress'] == $qLength)
                              $_SESSION['doingNow'] = "FINISH_EXAM";
                      }
                      else if ($_SESSION['doingNow'] == "TRAINING")
                      {
                          $_SESSION['tWAns'] ++;

                          $_SESSION['doingNow'] = "TRAINING_ANSWER_FEEDBACK";
                          $_SESSION['userAns'] = $userAnswer;
                      }
                  }

                  if ($_SESSION['doingNow'] == "EXAM")
                      header('Location: quiz.php');
                  else if ($_SESSION['doingNow'] == "TRAINING" || $_SESSION['doingNow'] == "TRAINING_ANSWER_FEEDBACK"
                    || $_SESSION['doingNow'] == "FINISH_TRAINING")
                      header('Location: training.php');
                  else if ($_SESSION['doingNow'] == "FINISH_EXAM")
                  {
                      $qResult = $_SESSION['qGAns'] * 0.5;

                      $now = new DateTime();

                      $user = new User();

                      /* Give XP by result */
                      if ($qResult >= 6 && $qResult < 8)
                          $user->giveXP($_SESSION['ID'], 56);
                      else if ($qResult >= 8 && $qResult < 10)
                          $user->giveXP($_SESSION['ID'], 100);
                      else if ($qResult == 10)
                          $user->giveXP($_SESSION['ID'], 184);

                      /* Give user achievements */
                      $achievement = new Achievement();

                      if (!$achievement->hasUserUnlocked($_SESSION['ID'], 16)) {
                          if ($user->countQuizzesWithMinGrade($_SESSION['ID'], 6) == 35) {
                              $achievement->unlock($_SESSION['ID'], 16);
                          }
                      }

                      if (!$achievement->hasUserUnlocked($_SESSION['ID'], 17)) {
                          if ($user->countQuizzesWithMinGrade($_SESSION['ID'], 8) == 35) {
                              $achievement->unlock($_SESSION['ID'], 17);
                          }
                      }

                      if (!$achievement->hasUserUnlocked($_SESSION['ID'], 18)) {
                          if ($user->countQuizzesWithMinGrade($_SESSION['ID'], 10) == 15) {
                              $achievement->unlock($_SESSION['ID'], 18);
                          }
                      }

                      /* Save quiz */
                      $Questions = $_SESSION['qQuestions'][0];

                      for ($q = 1; $q < $qLength; $q ++)
                          $Questions = $Questions.'|'.$_SESSION['qQuestions'][$q];

                      $_SESSION['qSTime'] = new DateTime();
                      $_SESSION['qSTime'] = $now->diff($_SESSION['qStartedAt']);

                      $quiz = new Quiz();
                      $qCode = $quiz->create($_SESSION['ID'], $_SESSION['qSTime']->s, $Questions, $qResult);

                      if (!$_SESSION['inChallenge'])
                      {
                          if (!$_SESSION['inContest'])
                              setcookie("lastQuiz", $qCode, time() + 180);
                          else
                          {
                              $quiz->setContestByCode($qCode, $_SESSION['ContestID']);
                          }
                      }
                      else {
                          $quiz->setChallengeByCode($qCode, $_SESSION['ChallengeID']);

                          $userChallengesCount = $user->countChallenges($_SESSION['ID']);

                          if ($userChallengesCount == 1)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 10))
                                  $achievement->unlock($_SESSION['ID'], 10);
                          }
                          else if ($userChallengesCount == 25)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 11))
                                  $achievement->unlock($_SESSION['ID'], 11);
                          }
                          else if ($userChallengesCount == 50)
                          {
                              if (!$achievement->hasUserUnlocked($_SESSION['ID'], 12))
                                  $achievement->unlock($_SESSION['ID'], 12);
                          }
                      }

                      header('Location: quiz.php');
                  }

                  break;
              }
          }

          break;
      }

      case 'quiz':
      {
          switch ($action)
          {
              case 'finish':
              {
                  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
                      header('Location: error.php');

                  if (!isset($_SESSION['doingNow']) || $_SESSION['doingNow'] != "EXAM")
                      header('Location: error.php');

                  $_SESSION['doingNow'] = "FINISH_EXAM";

                  if (STATUS == "DEV") $qLength = 5; else $qLength = 20;

                  $qResult = $_SESSION['qGAns'] * 0.5;

                  $now = new DateTime();

                  $user = new User();

                  /* Give XP by result */
                  if ($qResult >= 6 && $qResult < 8)
                      $user->giveXP($_SESSION['ID'], 56);
                  else if ($qResult >= 8 && $qResult < 10)
                      $user->giveXP($_SESSION['ID'], 100);
                  else if ($qResult == 10)
                      $user->giveXP($_SESSION['ID'], 184);

                  /* Give user achievements */
                  $achievement = new Achievement();

                  if (!$achievement->hasUserUnlocked($_SESSION['ID'], 16)) {
                      if ($user->countQuizzesWithMinGrade($_SESSION['ID'], 6) == 35) {
                          $achievement->unlock($_SESSION['ID'], 16);
                      }
                  }

                  if (!$achievement->hasUserUnlocked($_SESSION['ID'], 17)) {
                      if ($user->countQuizzesWithMinGrade($_SESSION['ID'], 8) == 35) {
                          $achievement->unlock($_SESSION['ID'], 17);
                      }
                  }

                  if (!$achievement->hasUserUnlocked($_SESSION['ID'], 18)) {
                      if ($user->countQuizzesWithMinGrade($_SESSION['ID'], 10) == 15) {
                          $achievement->unlock($_SESSION['ID'], 18);
                      }
                  }

                  /* Save quiz */
                  $Questions = $_SESSION['qQuestions'][0];

                  for ($q = 1; $q < $qLength; $q ++)
                      $Questions = $Questions.'|'.$_SESSION['qQuestions'][$q];

                  $_SESSION['qSTime'] = new DateTime();
                  $_SESSION['qSTime'] = $now->diff($_SESSION['qStartedAt']);

                  $quiz = new Quiz();
                  $qCode = $quiz->create($_SESSION['ID'], $_SESSION['qSTime']->s, $Questions, $qResult);

                  if (!$_SESSION['inChallenge'])
                  {
                      if (!$_SESSION['inContest'])
                          setcookie("lastQuiz", $qCode, time() + 180);
                      else
                      {
                          $quiz->setContestByCode($qCode, $_SESSION['ContestID']);
                      }
                  }
                  else {
                      $quiz->setChallengeByCode($qCode, $_SESSION['ChallengeID']);

                      $userChallengesCount = $user->countChallenges($_SESSION['ID']);

                      if ($userChallengesCount == 1)
                      {
                          if (!$achievement->hasUserUnlocked($_SESSION['ID'], 10))
                              $achievement->unlock($_SESSION['ID'], 10);
                      }
                      else if ($userChallengesCount == 25)
                      {
                          if (!$achievement->hasUserUnlocked($_SESSION['ID'], 11))
                              $achievement->unlock($_SESSION['ID'], 11);
                      }
                      else if ($userChallengesCount == 50)
                      {
                          if (!$achievement->hasUserUnlocked($_SESSION['ID'], 12))
                              $achievement->unlock($_SESSION['ID'], 12);
                      }
                  }

                  header('Location: quiz.php');
              }

              break;
          }

          break;
      }

      case 'challenge':
      {
          switch ($action)
          {
              case 'start':
              {
                  if (!isset($_SESSION['LoggedIn']))
                      header('Location: error.php');

                  if (isset($_COOKIE["lastQuiz"]))
                  {
                      $lastQuiz = $_COOKIE["lastQuiz"];

                      $quiz = new Quiz();

                      if ($quiz->hasChallenge($lastQuiz))
                          header('Location: error.php');

                      if ($_SESSION['ID'] == $quiz->getSolverByCode($lastQuiz))
                      {
                          $challenge = new Challenge();

                          $chlgCode = $challenge->create($_SESSION['ID']);

                          $quiz->setChallengeByCode($lastQuiz, $chlgCode);

                          $dest = 'challenges.php?challenge='.$chlgCode;
                          header('Location: '.$dest);
                      }
                      else
                          header('Location: error.php');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'join':
              {
                  $challenge = new Challenge();

                  if (strlen($_POST['tyInvite']) != 6)
                      header('Location: error.php');

                  if ($challenge->getStatus($_POST['tyInvite']))
                  {
                      $_SESSION['Error'] = "Provocare inexistentă!";
                      header('Location: challenges.php');
                  }

                  if ($challenge->exist($_POST['tyInvite']))
                  {
                      if (!$challenge->hasUserParticipated($_POST['tyInvite'], $_SESSION['ID']))
                      {
                          $_SESSION['inChallenge'] = true;
                          $_SESSION['ChallengeID'] = $_POST['tyInvite'];

                          header('Location: quiz.php?start');
                      }
                      else
                          header('Location: challenges.php?challenge='.$_POST['tyInvite']);
                  }
                  else
                  {
                      $_SESSION['Error'] = "Provocare inexistentă!";
                      header('Location: challenges.php');
                  }

                  break;
              }
          }

          break;
      }

      case 'achievement':
      {
          switch ($action)
          {
              case 'achieve':
              {
                  $achievement = new Achievement();

                  if (!$achievement->hasUserClaimed($_SESSION['ID'], $_GET['target_id']))
                  {
                      $achievement->claim($_SESSION['ID'], $_GET['target_id']);

                      $user = new User();
                      $user->giveXP($_SESSION['ID'], 400);
                      $user->giveCoins($_SESSION['ID'], 1);

                      $_SESSION['Success'] = "Bonus revendicat cu succes!";
                      header("Location: achievements.php");
                  }
                  else
                      header("Location: error.php");

                  break;
              }
          }

          break;
      }

      case 'product':
      {
          switch ($action)
          {
              case 'buy':
              {
                  $user = new User();

                  $userCoins = $user->getCoins($_SESSION['ID']);

                  switch ($_GET['target_id'])
                  {
                      case '1X_LEVEL_UP':
                      {
                          if ($userCoins >= 10)
                          {
                              $userLevel = $user->getLevel($_SESSION['ID']);

                              $user->setLevel($_SESSION['ID'], $userLevel + 1, false);
                              $user->giveCoins($_SESSION['ID'], -5);
                          }
                          else
                              header('Location: coins.php#shop');

                          break;
                      }

                      case '2X_LEVEL_UP':
                      {
                          if ($userCoins >= 15)
                          {
                              $userLevel = $user->getLevel($_SESSION['ID']);

                              $user->setLevel($_SESSION['ID'], $userLevel + 2, false);
                              $user->giveCoins($_SESSION['ID'], -8);
                          }
                          else
                              header('Location: coins.php#shop');

                          break;
                      }

                      default: header('Location: error.php');
                  }

                  $_SESSION['Success'] = "Achiziție realizată cu succes!";
                  header('Location: coins.php');

                  break;
              }

              default: header('Location: error.php');
          }

          break;
      }

      case 'post':
      {
          switch ($action)
          {
              case 'create':
              {
                  $user = new User();

                  if ($user->getCoins($_SESSION['ID']) == 0)
                      header('Location: error.php');

                  if ($_SESSION['LoggedIn'])
                  {
                      $post = new Post();

                      $lesson = new Lesson();

                      if (!$lesson->exist($_GET['lesson']))
                          header('Location: error.php');

                      $text = htmlspecialchars($_POST['tyText'], ENT_QUOTES, 'UTF-8');

                      if (strlen($text) == 0)
                      {
                          $_SESSION['Error'] = "Discuția trebuie să aibă conținut!";
                          header('Location: lesson.php?lesson='.$_POST['lesson'].'#questions');
                      }

                      if (strlen($text) > 240)
                      {
                          $_SESSION['Error'] = "Conținutul întrebării nu trebuie să depășească 240 de caractere!";
                          header('Location: lesson.php?lesson='.$_POST['lesson'].'#questions');
                      }

                      $postID = $post->create($_SESSION['ID'], $_POST['lesson'], $text);

                      $user->giveCoins($_SESSION['ID'], -1);

                      header('Location: lesson.php?lesson='.$_POST['lesson'].'#p'.$postID);
                  }

                  break;
              }

              case 'delete':
              {
                  $user = new User();

                  if ($_SESSION['LoggedIn'])
                  {
                      $post = new Post();

                      if ($user->isAdmin($_SESSION['ID']))
                      {
                          $redirect = 'lesson.php?lesson='.$post->getLesson($_GET['target_id']).'#questions';
                          $post->delete($_GET['target_id']);

                          header('Location: '.$redirect);
                      }
                      else
                          header('Location: error.php');
                  }
                  else
                      header('Location: error.php');

                  break;
              }
          }

          break;
      }

      case 'reply':
      {
          switch ($action)
          {
              case 'create':
              {
                  if ($_SESSION['LoggedIn'])
                  {
                      $post = new Post();

                      if ($post->exist($_GET['target_id']))
                      {
                          $reply = new Reply();

                          $text = htmlspecialchars($_POST['tyText'], ENT_QUOTES, 'UTF-8');

                          $postLesson = $post->getLesson($_GET['target_id']);

                          if (strlen($text) == 0)
                          {
                              $_SESSION['Error'] = "Scrie și tu ceva acolo :)";
                              header('Location: lesson.php?lesson='.$postLesson.'#questions');
                          }

                          if (strlen($text) > 240)
                          {
                              $_SESSION['Error'] = "Răspunsul tău nu trebuie să depășească 240 de caractere!";
                              header('Location: lesson.php?lesson='.$postLesson.'#questions');
                          }

                          $replyID = $reply->create($_SESSION['ID'], $_GET['target_id'], $text);

                          header('Location: lesson.php?lesson='.$postLesson.'#r'.$replyID);
                      }
                      else
                          header("Location: error.php");
                  }
                  else
                      header("Location: error.php");

                  break;
              }

              case 'delete':
              {
                  $user = new User();

                  if ($_SESSION['LoggedIn'])
                  {
                      $reply = new Reply();

                      if ($user->isAdmin($_SESSION['ID']))
                      {
                          $post = new Post();
                          $redirect = 'lesson.php?lesson='.$post->getLesson($reply->getPost($_GET['target_id'])).'#questions';
                          $reply->delete($_GET['target_id']);

                          header('Location: '.$redirect);
                      }
                      else
                          header('Location: error.php');
                  }
                  else
                      header('Location: error.php');

                  break;
              }

              case 'award':
              {
                  $user = new User();

                  if ($_SESSION['LoggedIn'])
                  {
                      $reply = new Reply();

                      if (!$reply->exist($_GET['target_id']))
                          header('Location: error.php');

                      $replyAuthor = $reply->getCreator($_GET['target_id']);

                      if ($_SESSION['ID'] != $replyAuthor)
                      {
                          $post = new Post();

                          $replyPost = $reply->getPost($_GET['target_id']);

                          if ($_SESSION['ID'] == $post->getCreator($replyPost))
                          {
                               if ($post->isAwardGiven($lessonPost['ID']))
                                   header('Location: error.php');

                               $user->giveCoins($replyAuthor, 1);
                               $post->setAwardedReply($replyPost, $_GET['target_id']);

                               header('Location: lesson.php?lesson='.$post->getLesson($replyPost));
                          }
                          else
                              header('Location: error.php');
                      }
                      else
                          header('Location: error.php');
                  }
                  else
                      header('Location: error.php');

                  break;
              }
          }

          break;
      }

      case 'contest':
      {
          switch ($action)
          {
              case 'create':
              {
                  $user = new User();

                  if (!$_SESSION['LoggedIn'])
                      header('Location: error.php');

                  if (!$user->isAdmin($_SESSION['ID']))
                      header('Location: error.php');

                  $contest = new Contest();

                  $startAt = new DateTime($_POST['tyDate'].' '.$_POST['tyHour']);

                  $contestID = $contest->create($_POST['tyName'], $_POST['tyDescription'], $_POST['selCategory'], $startAt->format('Y-m-d H:i:s'), $_POST['tyTime'], $_POST['tyPrize']);
                  header('Location: contests.php?contest='.$contestID);

                  break;
              }

              case 'edit':
              {
                  $user = new User();

                  if (!$_SESSION['LoggedIn'])
                      header('Location: error.php');

                  if (!$user->isAdmin($_SESSION['ID']))
                      header('Location: error.php');

                  $contest = new Contest();

                  if (!$contest->exist($_GET['target_id']))
                      header('Location: error.php');

                  $startAt = new DateTime($_POST['tyDate'].' '.$_POST['tyHour']);

                  $contest->update($_GET['target_id'], $_POST['tyName'], $_POST['tyDescription'], $_POST['selCategory'], $startAt->format('Y-m-d H:i:s'), $_POST['tyTime'], $_POST['tyPrize']);
                  header('Location: contests.php?contest='.$_GET['target_id']);

                  break;
              }

              case 'delete':
              {
                  $user = new User();

                  if (!$_SESSION['LoggedIn'])
                      header('Location: error.php');

                  if (!$user->isAdmin($_SESSION['ID']))
                      header('Location: error.php');

                  $contest = new Contest();

                  if (!$contest->exist($_GET['target_id']))
                      header('Location: error.php');

                  $contestID = $contest->delete($_GET['target_id']);
                  header('Location: contests.php');

                  break;
              }

              case 'join':
              {
                  if (!$_SESSION['LoggedIn'])
                  {
                      header('Location: error.php');
                      die('redirect');
                  }

                  $contest = new Contest();

                  if (!$contest->exist($_GET['target_id']))
                  {
                      header('Location: error.php');
                      die('redirect');
                  }

                  $contestData = $contest->getData($_GET['target_id']);

                  if ($contestData['Status'] != 1)
                  {
                      header('Location: error.php');
                      die('redirect');
                  }

                  $now = new DateTime();
                  $contestStartedAt = new DateTime($contestData['SDateTime']);

                  if ($now >= $contestStartedAt->modify('+3 minutes'))
                  {
                      header('Location: error.php');
                      die('redirect');
                  }

                  if ($contest->hasUserParticipated($_SESSION['ID'], $_GET['target_id']))
                  {
                      header('Location: error.php');
                      die('redirect');
                  }

                  $_SESSION['inContest'] = true;
                  $_SESSION['ContestID'] = $_GET['target_id'];
                  header('Location: quiz.php?start');
              }
          }

          break;
      }

  }

?>

<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/Chapter.php';
  require_once 'source/Question.php';
  require_once 'source/Challenge.php';
  require_once 'source/Contest.php';
  require_once 'source/User.php';

  if (!isset($_SESSION['LoggedIn']) && !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $user = new User();

  $view = new View();

  $chapter = new Chapter();
  $question = new Question();

  if (isset($_GET['start']))
  {
      $_SESSION['doingNow'] = "EXAM";

      $_SESSION['qProgress'] = 0;
      $_SESSION['qGAns'] = 0;
      $_SESSION['qWAns'] = 0;

      $_SESSION['qStartedAt'] = new DateTime();
      $_SESSION['qFinishAt'] = new DateTime();

      $_SESSION['qQuestions'] = array();

      if (isset($_SESSION['inChallenge']) && $_SESSION['inChallenge'] == true)
      {
          $_SESSION['qFinishAt']->modify('+25 minutes');

          $challenge = new Challenge();
          $questions = $challenge->getQuestions($_SESSION['ChallengeID']);

          $qID = strtok($questions, "|");

          $q = 0;
          while ($qID !== false)
          {
              $_SESSION['qQuestions'][$q ++] = $qID;
              $qID = strtok("|");
          }
      }
      else if (isset($_SESSION['inContest']) && $_SESSION['inContest'] == true)
      {
          $contest = new Contest();
          $questionsData = $contest->getQuestions($_SESSION['ContestID']);

          $_SESSION['qFinishAt']->modify('+'.$contest->getLength($_SESSION['ContestID']).' minutes');

          $q = 0;
          foreach($questionsData as $questionData)
              $_SESSION['qQuestions'][$q ++] = $questionData['ID'];

          $_SESSION['contestLength'] = $q;

          shuffle($_SESSION['qQuestions']);
      }
      else
      {
          $_SESSION['qFinishAt']->modify('+25 minutes');

          $questionsData = $question->getCategoryAll($user->getExamType($_SESSION['ID']));

          $q = 0;
          foreach($questionsData as $questionData)
              $_SESSION['qQuestions'][$q ++] = $questionData['ID'];

          shuffle($_SESSION['qQuestions']);
      }
  }

  if (isset($_SESSION['doingNow']) && $_SESSION['doingNow'] == "EXAM")
      $cQuestion = $_SESSION['qQuestions'][$_SESSION['qProgress']];

  $view->header("quiz", "Simulare examen");

?>

</head>

<body>

  <?= $view->navbar("quiz", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <?php if (!isset($_GET['before'])) { ?>
        <?php if ($_SESSION['doingNow'] == "EXAM") { ?>
           <?php if (isset($_SESSION['inContest']) && $_SESSION['inContest'] == true) { ?>
                 <div class="row">
                   <div class="col-lg-6">
                     <h5 id="remainTime"><i class="fa fa-clock mr-2"></i></h5>
                   </div>
                   <div class="col-lg-6">
                     <h5 style="text-align: right">
                       <i class="fa fa-check-circle mr-2"></i><?= $_SESSION['qGAns'] ?>&nbsp;&nbsp;<i class="fa fa-times-circle mr-2"></i><?= $_SESSION['qWAns'] ?>&nbsp;&nbsp;<i class="fa fa-list mr-2"></i><?= $_SESSION['contestLength'] - $_SESSION['qProgress'] ?>
                     </h5>
                   </div>
                 </div>
           <?php } else { ?>
                    <div class="row">
                      <div class="col-lg-6">
                        <h5 id="remainTime"><i class="fa fa-clock mr-2"></i></h5>
                      </div>
                      <div class="col-lg-6">
                        <h5 style="text-align: right">
                          <i class="fa fa-check-circle ml-2 mr-2"></i><?= $_SESSION['qGAns'] ?>&nbsp;&nbsp;<i class="fa fa-times-circle mr-2"></i><?= $_SESSION['qWAns'] ?>&nbsp;&nbsp;<i class="fa fa-list mr-2"></i><?= 20 - $_SESSION['qProgress'] ?>
                        </h5>
                      </div>
                    </div>

           <?php } $question->view($cQuestion) ?>

           <input type="hidden" id="finishTime" value="<?= $_SESSION['qFinishAt']->format('Y-m-d H:i:s') ?>">

           <script>
              var now = new Date();

              var fAt = document.getElementById('finishTime').value;
              var finishAt = new Date(fAt);

              var remainSeconds = Math.floor((finishAt.getTime() - now.getTime()) / 1000);

              setTimeout(tick, 1000);
              updateClock();

              function updateClock()
              {
                  var minutes = Math.floor(remainSeconds / 60);
                  var seconds = remainSeconds % 60;

                  document.getElementById('remainTime').innerHTML = '<i class="fa fa-clock mr-2"></i>' + minutes + ':' + seconds;
              }

              function tick()
              {
                  remainSeconds --;

                  if (remainSeconds > 0)
                  {
                      updateClock();
                      setTimeout(tick, 1000);
                  }
                  else
                  {
                      window.location.replace("process.php?target=quiz&action=finish");
                  }
              }
            </script>

          <br>

        <?php } else if ($_SESSION['doingNow'] == "FINISH_EXAM") { ?>
            <div class="row">
              <div class="col-lg-6">
                <div class="card border-light">
                  <div class="card-header">
                    Felicitări!
                  </div>
                  <div class="card-body">
                    <p class="card-text">
                      Ai reușit să răspunzi la toate întrebările din simulare la timp!
                    </p>
                    <?php if (isset($_SESSION['inChallenge']) && $_SESSION['inChallenge'] == true) { ?>
                              <?php
                                $joinedChallenges = $user->countChallenges($_SESSION['ID']);

                                $achievement = new Achievement();

                                if (!$achievement->hasUserUnlocked($_SESSION['ID'], 10)) {
                                    $achievement->unlock($_SESSION['ID'], 10);
                                }

                                if ($joinedChallenges == 10)
                                {
                                    if (!$achievement->hasUserUnlocked($_SESSION['ID'], 11)) {
                                        $achievement->unlock($_SESSION['ID'], 11);
                                    }
                                }
                                else if ($joinedChallenges == 50)
                                {
                                    if (!$achievement->hasUserUnlocked($_SESSION['ID'], 12)) {
                                        $achievement->unlock($_SESSION['ID'], 12);
                                    }
                                }
                              ?>

                              <p class="card-text">
                                Dorești să vezi clasamentul provocării?
                              </p>
                              <a href="challenges.php?challenge=<?= $_SESSION['ChallengeID'] ?>" class="card-link btn btn-success btn-sm">Da</a>
                              <a href="quiz.php?start" class="card-link btn btn-success btn-sm">Nu</a>
                    <?php } else if (isset($_SESSION['inContest']) && $_SESSION['inContest'] == true) { ?>
                              <p class="card-text">
                                Dorești să vezi clasamentul concursului?
                              </p>
                              <a href="contests.php?contest=<?= $_SESSION['ContestID'] ?>" class="card-link btn btn-success btn-sm">Da</a>
                              <a href="quiz.php?start" class="card-link btn btn-success btn-sm">Nu</a>
                    <?php } else { ?>
                              <p class="card-text">
                                Dorești să îți provoci prietenii să rezolve același test?
                              </p>
                              <a href="process.php?target=challenge&action=start" class="card-link btn btn-success btn-sm">Da</a>
                              <a href="quiz.php?before" class="card-link btn btn-success btn-sm">Nu</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="card border-light mb-3" style="max-width: 20rem;">
                  <div class="card-header">
                    Notă finală
                  </div>
                  <div class="card-body">
                    <h2 class="card-title"><?= $_SESSION['qGAns'] * 0.5 ?></h5>
                    <p><?= $_SESSION['qGAns'] ?> răspunsuri bune.<br></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                  <div class="card border-light mb-3" style="max-width: 20rem;">
                    <div class="card-header">
                      Timp
                    </div>
                    <div class="card-body">
                      <h2 class="card-title"><?= $_SESSION['qSTime']->i ?> minute</h5>
                      <p>și <?= $_SESSION['qSTime']->s ?> secunde.<br></p>
                    </div>
                  </div>
              </div>
            </div>

            <br><br><br><br><br>

            <?php
                  $_SESSION['inChallenge'] = false;
                  $_SESSION['ChallengeID'] = -1;
                  $_SESSION['inContest'] = false;
                  $_SESSION['ContestID'] = -1;
                  $_SESSION['doingNow'] = 'NOTHING';
            ?>
        <?php } ?>
    <?php } else { ?>
            <h3>Simulare examen</h3>

            <p>Ești pe cale să simulezi un examen. Simularea constă în:</p>

            <?php
                  $userCategory = $user->getExamType($_SESSION['ID']);
                  if ($userCategory == 1) $categoryTitle = 'Anatomie și genetică umană'; else $categoryTitle = 'Biologie vegetală și animală';
            ?>

            <ul>
              <li>20 întrebări din <?= $categoryTitle ?> a câte 0,5 puncte fiecare.</li>
              <li>Timp de rezolvare: 25 de minute. În cazul în care timpul este depășit, simularea este oprită, luându-se în considerare doar răspunsurile date.</li>
              <li>Întrebările sunt din toate capitolele, așa că îți recomandăm să le parcurgi complet înainte de a porni o simulare.</li>
            </ul>

            <a href="quiz.php?start" class="btn btn-success">
              <span class="fa fa-play mr-2"></span>Start!
            </a>

            <p></p>

            <h5>Statistici ale simulărilor tale anterioare</h5>

            <?php $solvedQuizzes = $user->countQuizzes($_SESSION['ID']) ?>

            <div class="row">
              <div class="col-lg-4">
                <div class="card border-light mb-3" style="max-width: 20rem;">
                  <div class="card-header">
                    Simulări totale
                  </div>
                  <div class="card-body">
                    <h1 class="card-title"><?= $solvedQuizzes ?></h5>
                  </div>
                </div>
              </div>
              <?php
                $Grades = $user->getQuizzesGrades($_SESSION['ID']);

                $i = 0;
                $avgGrade = 0;

                foreach ($Grades as $Grade)
                {
                    $avgGrade += $Grade['Result'];
                    $i ++;
                }

                if ($i == 0)
                    $result = "Nu există!";
                else
                    $result = round($avgGrade / $i, 2);
              ?>
              <div class="col-lg-4">
                <div class="card border-light mb-3" style="max-width: 20rem;">
                  <div class="card-header">
                    Notă medie
                  </div>
                  <div class="card-body">
                    <h1 class="card-title"><?= $result ?></h5>
                  </div>
                </div>
              </div>
              <?php
                $STimes = $user->getQuizzesTimes($_SESSION['ID']);

                $i = 0;
                $avgSTime = 0;

                foreach ($STimes as $STime)
                {
                    $avgSTime += $STime['STime'];
                    $i ++;
                }

                if ($i == 0)
                    $result = "Nu există!";
                else
                    $result = round(($avgSTime / 60) / $i, 2);
              ?>
              <div class="col-lg-4">
                <div class="card border-light mb-3" style="max-width: 20rem;">
                  <div class="card-header">
                    Timp mediu
                  </div>
                  <div class="card-body">
                    <h1 class="card-title"><?= $result ?> <?php if ($result != "Nu există!") echo 'minute'; ?></h5>
                  </div>
                </div>
              </div>
            </div>
    <?php } ?>
  </div>

  <?= $view->footer("quiz"); ?>

</body>

</html>

<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/Chapter.php';
  require_once 'source/Question.php';
  require_once 'source/User.php';

  if (!isset($_SESSION['LoggedIn']) && !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $user = new User();

  $view = new View();

  $chapter = new Chapter();
  $question = new Question();

  if ($user->getLevel($_SESSION['ID']) < $chapter->getLevel($_GET['chapter']) && !$user->isAdmin($_SESSION['ID']))
      header('Location: chapters.php?chapter='.$lessonChapter);

  if (isset($_GET['chapter']))
  {
      $_SESSION['doingNow'] = "TRAINING";
      $_SESSION['tChapter'] = $_GET['chapter'];

      $_SESSION['tProgress'] = 0;
      $_SESSION['tGAns'] = 0;
      $_SESSION['tWAns'] = 0;

      $_SESSION['tQuestions'] = array();
      $questionsData = $question->getChapterAll($_SESSION['tChapter'], true);

      $q = 0;
      foreach($questionsData as $questionData){
          $_SESSION['tQuestions'][$q ++] = $questionData['ID'];}

      shuffle($_SESSION['tQuestions']);
  }
  else if (isset($_GET['next']) && $_SESSION['doingNow'] != "TRAINING")
  {

      $_SESSION['tProgress'] ++;

      if ($_SESSION['tProgress'] == $chapter->countQuestions($_SESSION['tChapter']))
          $_SESSION['doingNow'] = "FINISH_TRAINING";
      else
      {
          $_SESSION['doingNow'] = "TRAINING";
      }
  }

  if (isset($_SESSION['doingNow']) && ($_SESSION['doingNow'] == "TRAINING" || $_SESSION['doingNow'] == "TRAINING_ANSWER_FEEDBACK"))
      $cQuestion = $_SESSION['tQuestions'][$_SESSION['tProgress']];

  $view->header("training", "Antrenament din ".$chapter->getTitle($_SESSION['tChapter']));

?>
</head>

<body>

  <?= $view->navbar("training", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <ol class="breadcrumb">
      <?php $chapterCategory = $chapter->getCategory($_GET['chapter']); ?>
      <li class="breadcrumb-item">
        <a href="chapters.php">
          <?php if ($chapterCategory == 1) echo 'Anatomie și genetică umană'; else echo 'Biologie vegetală și animală'; ?>
        </a>
      </li>
      <li class="breadcrumb-item"><a href="chapters.php?chapter=<?= $_SESSION['tChapter'] ?>"><?= $chapter->getTitle($_SESSION['tChapter']) ?></a></li>
      <li class="breadcrumb-item">Antrenament</li>
    </ol>

    <br>

    <?php if ($_SESSION['doingNow'] != "FINISH_TRAINING") { ?>
      <h5 style="text-align: right"><i class="fa fa-check-circle mr-2"></i><?= $_SESSION['tGAns'] ?>&nbsp;&nbsp;<i class="fa fa-times-circle mr-2"></i><?= $_SESSION['tWAns'] ?>&nbsp;&nbsp;<i class="fa fa-list mr-2"></i><?= $chapter->countQuestions($_SESSION['tChapter']) - $_SESSION['tProgress'] ?>
      </h5>
    <?php } ?>

    <?php if ($_SESSION['doingNow'] == "TRAINING") {
              $question->view($cQuestion);
          } else if ($_SESSION['doingNow'] == "TRAINING_ANSWER_FEEDBACK") {
              ?>
                <div class="alert alert-dismissible alert-danger">
                  <strong>Răspuns greșit!</strong>
                  <?php if ($question->getType($cQuestion) == 3) echo "Răspunsul corect este: ".$question->getAnswer($cQuestion, 'A'); ?>
                </div>
              <?php

              $question->view($cQuestion, "FEEDBACK", $_SESSION['userAns']);

              ?>
                <br>

                <div class="alert alert-dismissible alert-success">
                  <strong>Explicație:</strong> <?= $question->getAnsEx($cQuestion) ?>
                </div>

                <a href="training.php?next" class="btn btn-success btn-block">Continuă</a>
              <?php
          } else if ($_SESSION['doingNow'] == "FINISH_TRAINING") { ?>
              <div class="row">
                <div class="col-lg-6">
                  <div class="card border-light">
                    <div class="card-header">
                      Felicitări!
                    </div>
                    <div class="card-body">
                      <p class="card-text">
                        Ai răspuns la toate întrebările din capitolul „<?= $chapter->getTitle($_SESSION['tChapter']) ?>”!
                      </p>
                      <p class="card-text">
                        Dorești să reiei toate întrebările din acest capitol?
                      </p>
                      <a href="training.php?chapter=<?= $_SESSION['tChapter'] ?>" class="card-link btn btn-success btn-sm">Da</a>
                      <a href="chapters.php?chapter=<?= $_SESSION['tChapter'] ?>" class="card-link btn btn-success btn-sm">Nu</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="card border-light mb-3" style="max-width: 20rem;">
                    <div class="card-header">
                      Răspunsuri corecte
                    </div>
                    <div class="card-body">
                      <h2 class="card-title"><?= $_SESSION['tGAns'] ?></h5>
                      <p>din <?= $_SESSION['tGAns'] + $_SESSION['tWAns'] ?>.<br></p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                    <div class="card border-light mb-3" style="max-width: 20rem;">
                      <div class="card-header">
                        Noțiuni fixate
                      </div>
                      <div class="card-body">
                        <h2 class="card-title"><?= $user->countFixedInfos($_SESSION['ID'], $_SESSION['tChapter']) ?></h5>
                        <p>din <?= $chapter->countQuestions($_SESSION['tChapter']) ?>.<br></p>
                      </div>
                    </div>
                </div>
              </div>

              <?php $_SESSION['doingNow'] = 'NOTHING'; ?>
    <?php } ?>
  </div>

  <?= $view->footer("training"); ?>

</body>

</html>

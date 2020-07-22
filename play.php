<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  require_once 'source/User.php';

  $user = new User();

  if ($user->getExamType($_SESSION['ID']) == 1)
  {
      $_SESSION['isPlaying'] = "AGU_GAME";
      $GAME_NAME = "Gusturi buclucașe";
  }
  else
  {
      $_SESSION['isPlaying'] = "BVA_GAME";
      $GAME_NAME = "Animal planet";
  }

  $view = new View();

  $view->header("game", $GAME_NAME);

?>

</head>

<body>

  <?= $view->navbar("game", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <div id="story">
      <h3><?= $GAME_NAME ?></h3>
      <?php require_once 'games/'.$_SESSION['isPlaying'].'/story.html' ?>
      <button class="btn btn-success" onclick="startGame()"><i class="fa fa-gamepad mr-2"></i>Start</button>
    </div>
    <div id="game">
      <h6 class="text-right" id="bar"><span class="fa fa-clock mr-1"></span>3:00<span class="fa fa-star-half ml-2"></span>0<span class="fa fa-heart ml-2 mr-1"></span>3</h5>
      <?php require_once 'games/'.$_SESSION['isPlaying'].'/game.php' ?>
    </div>
    <div id="finish">
      <h1 class="text-center">Final de joc!</h1>
      <h5 class="text-center" id="finalScore"></h5>

      <br>

      <center>
        <button class="btn btn-success" onclick="replayGame()"><i class="fa fa-gamepad mr-2"></i>Joc nou</button>
      </center>

      <br><br><br><br><br><br>
    </div>
  </div>

  <script>
    document.getElementById('game').style.display = 'none';
    document.getElementById('finish').style.display = 'none';
  </script>

  <br>

  <script>
    var Points = 0;
    var Lifes = 3;
    var Time;
    var product;
    var rightAnswer;

    function updateBar()
    {
        document.getElementById('bar').innerHTML = '<span class="fa fa-clock mr-1"></span>' + Math.floor(Time / 60) + ':' + (Time % 60) + '<span class="fa fa-star-half ml-2"></span>'
                                                    + Points + '<span class="fa fa-heart ml-2 mr-1"></span>' + Lifes;
    }

    function answer(taste)
    {
        if (taste == rightAnswer)
            Points ++;
        else
            Lifes --;

        if (Lifes > 0)
        {
            updateBar();
            generateLevel();
        }
        else
            finishGame();
    }

    function startGame()
    {
        document.getElementById('story').style.display = 'none';
        document.getElementById('game').style.display = 'block';
        generateLevel();

        Time = 180;
        setTimeout(tick, 1000);
    }

    function tick()
    {
        Time --;

        if (Time > 0)
        {
            updateBar();
            setTimeout(tick, 1000);
        }
        else
            finishGame();
    }

    function replayGame()
    {
        Points = 0;
        Lifes = 3;
        updateBar();
        startGame();
    }

    function finishGame()
    {
        document.getElementById('finalScore').innerHTML = '<span class="fa fa-star-half"></span>' + Points;
        document.getElementById('game').style.display = 'none';
        document.getElementById('finish').style.display = 'block';
    }
  </script>

  <?= $view->footer("game"); ?>

</body>

<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/Config.php';
  require_once 'source/View.php';
  require_once 'source/User.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  $user = new User();

  $view->header("coins", "Viruși");

  $userCoins = $user->getCoins($_SESSION['ID']);
?>
</head>

<body>

  <?= $view->navbar("coins", $_SESSION['ID']); ?>

  <div class="container">

    <br>

    <p>În acest moment deții <?= $userCoins ?><span class="fa fa-viruses ml-1"></span></p>

    <h3>Ce sunt virușii?</h3>
    <p>Virușii reprezintă moneda virtuală a <?= PROJECT_NAME ?>; cu aceștia poți să cumperi diverse avantaje din <a href="#store"><span class="fas fa-store mr-1"></span>Magazin</a>.</p>

    <br>

    <h3>Când primesc viruși?</h3>
    <ul>
      <li><p>când avansezi un nivel (1<span class="fa fa-viruses ml-1"></span>)</p></li>
      <li><p>când primești coroniță (1<span class="fa fa-viruses ml-1"></span>)</p></li>
      <li><p>când deblochezi o realizare (1<span class="fa fa-viruses ml-1"></span>)</p></li>
    </ul>

    <br>

    <div id="store">
      <h3><span class="fas fa-store mr-2"></span>Magazin</h3>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Produs</th>
            <th scope="col">Cumpără</th>
          </tr>
        </thead>
        <tbody>
          <tr class="table">
            <th scope="row">1.</th>
            <td>1x Level Up</td>
            <td>
              <a href="process.php?target=product&action=buy&target_id=1X_LEVEL_UP" class="btn btn-success <?php if ($userCoins < 10) echo 'disabled'?>">
                5<span class="fa fa-viruses ml-1"></span>
              </a>
            </td>
          </tr>
          <tr class="table">
            <th scope="row">2.</th>
            <td>2x Level Up</td>
            <td>
              <a href="process.php?target=product&action=buy&target_id=2X_LEVEL_UP" class="btn btn-success <?php if ($userCoins < 15) echo 'disabled'?>">
                8<span class="fa fa-viruses ml-1"></span>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <br>

  <?= $view->footer("coins"); ?>

</body>

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

  $view->header("level", "Nivel");

  $userLevel = $user->getLevel($_SESSION['ID']);
  $userXP = $user->getXP($_SESSION['ID']);

  $requiredXP = ($userLevel + 1) * LEVEL_POINT;

?>
</head>

<body>

  <?= $view->navbar("level", $_SESSION['ID']); ?>

  <div class="container">
    <div class="progress-wrapper">
      <div class="progress-info">
        <div class="progress-label">
          <span>Nivel <?= $userLevel ?></span>
        </div>
        <?php $percentage = ($userXP / $requiredXP) * 100; ?>
        <div class="progress-percentage">
          <span><?= round($percentage, 2) ?>%</span>
        </div>
      </div>
      <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percentage ?>%;"></div>
      </div>
    </div>

    <br>

    <p>În acest moment deții <?= $userXP ?> XP. Mai ai nevoie de <?= $requiredXP - $userXP ?> XP pentru a avansa la nivelul <?= $userLevel + 1 ?>.</p>

    <h3>Ce sunt nivelele?</h3>
    <p>Fiecare capitol are un <b>nivel</b> minim pentru a fi accesat. Pentru a putea avansa în nivel trebuie să strângi un număr de puncte XP necesar.</p>
    <p>De altfel poți să cumperi level up din <a href="coins.php#store"><span class="fas fa-store mr-1"></span>Magazin</a> folosind <i>Viruși</i>.</p>

    <br>

    <h3>Ce sunt punctele XP?</h3>
    <p><b>Punctele XP</b> sau <b>punctele de experiență</b> sunt niște puncte ce sunt acordate în urma unor acțiuni pe care le faci pe <?=PROJECT_NAME?></p>
    <p>Punctele XP sunt folosite pentru a putea avansa în nivel, dar și în alcătuirea clasamentului.</p>

    <br>

    <h3>Când primești puncte XP?</h3>

    <ul>
      <li><p>când răspunzi corect la o întrebare din mediul de pregătire (un punct XP)</p></li>
      <li><p>când răspunzi corect la o întrebare din mediul de pregătire, al cărei răspuns este catalogat ca <i>noțiune fixată</i> (2 puncte XP)</p></li>
      <li><p>când răspunzi corect la un chestionar (56 puncte XP pentru note între 6 și 7.99, 100 pentru note între 8 și 9.99 și 184 pentru 10)</p></li>
      <li><p>când atingi procentajul de 100% la un capitol (200 puncte XP)</p></li>
      <li><p>când deblochezi o realizare (400 puncte XP)</p></li>
      <li><p>când câștigi o provocare (140 puncte XP)</p></li>
    </ul>
  </div>

  <br>

  <?= $view->footer("level"); ?>

</body>

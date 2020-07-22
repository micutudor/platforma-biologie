<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/Config.php';
  require_once 'source/View.php';
  require_once 'source/User.php';

  $view = new View();

  $user = new User();

  $view->header("error", "404");
?>
</head>

<body>

  <?= $view->navbar("error", $_SESSION['ID']); ?>

  <br>

  <div class="container">
      <h3>Pagină inexistentă | EROARE 404</h3>

      <br>

      <p>Du-te înapoi pe <a href="index.php">pagina principală</a></p>
  </div>

  <br>

  <?= $view->footer("error"); ?>

</body>

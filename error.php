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

  <?= $view->navbar("error"); ?>

  <br>

  <div class="container">
      <h3>Pagină inexistentă | EROARE 404</h3>

      <br>

      <p>Du-te înapoi pe <a href="index.php">pagina principală</a>.</p>
      <p>Sau poți aștepta 5 secunde până când vei fi redirecționat automat.</p>

      <script>

        setTimeout(redirect, 5000);

        function redirect()
        {
            window.location.replace("index.php");
        }
      </script>
      <br><br><br><br><br><br><br>
  </div>

  <br>

  <?= $view->footer("error"); ?>

</body>

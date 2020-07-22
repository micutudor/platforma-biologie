<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/Config.php';
  require_once 'source/View.php';

  $view = new View();

  $view->header("about-us", "Despre noi");

?>
</head>

<body>

  <?= $view->navbar("about-us"); ?>

  <div class="container">
    
  </div>

  <br>

  <?= $view->footer("about-us"); ?>

</body>

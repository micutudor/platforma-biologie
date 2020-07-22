<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/User.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  if (!isset($_GET['page']))
     $page = 'general';
  else
     $page = $_GET['page'];

  $user = new User();

  $view->header("settings", "Setări");

?>
</head>

<body>

  <?= $view->navbar("settings", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <h3><span class="fa fa-cog mr-2"></span>Setări</h3>

    <?php
        if (isset($_SESSION['Success']) && !is_null($_SESSION['Success'])) { ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Yabadabadoo!</strong> <?= $_SESSION['Success'] ?>
          </div>

    <?php
          $_SESSION['Success'] = null; } ?>

    <?php
          if (isset($_SESSION['Error']) && !is_null($_SESSION['Error'])) { ?>
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?= $_SESSION['Error'] ?>
            </div>

          <?php
            $_SESSION['Error'] = null; } ?>

    <form action="process.php?target=user&action=update&target_id=<?= $_SESSION['ID'] ?>" method="post">
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="tyFName">Prenume</label>
            <input type="text" class="form-control" name="tyFName" value="<?= $user->getFName($_SESSION['ID']); ?>">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="tyLName">Nume</label>
            <input type="text" class="form-control" name="tyLName" value="<?= $user->getLName($_SESSION['ID']); ?>">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="tyEMail">Poștă electronică</label>
        <input type="text" class="form-control" name="tyEMail" value="<?= $user->getEMail($_SESSION['ID']); ?>">
      </div>
      <div class="form-group">
        <label for="selExamType">Tip bacalaureat:</label>
        <select id="selExamType" class="form-control" name="selExamType">
          <?php $ExamType = $user->getExamType($_SESSION['ID']); ?>
          <option value="1" <?php if ($ExamType == 1) echo 'selected'; ?>>Anatomie și genetică umană</option>
          <option value="2" <?php if ($ExamType == 2) echo 'selected'; ?>>Biologie vegetală și animală</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Salvează</button>
    </form>

    <br>

    <h5>Schimbă-ți parola</h5>

    <form action="process.php?target=user&action=change-password&target_id=<?= $_SESSION['ID'] ?>" method="post">
      <div class="form-group">
        <label for="tyPass">Parolă curentă</label>
        <input type="password" class="form-control" name="tyPass">
      </div>
      <div class="form-group">
        <label for="tyNPass">Parolă nouă</label>
        <input type="password" class="form-control" name="tyNPass">
      </div>
      <div class="form-group">
        <label for="retyNPass">Confirmă parola nouă</label>
        <input type="password" class="form-control" name="retyNPass">
      </div>
      <button type="submit" class="btn btn-success">Salvează</button>
    </form>
  </div>

  <?= $view->footer("settings"); ?>

</body>

</html>

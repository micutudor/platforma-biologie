<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';

  if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'])
      header('Location: chapters.php');

  $view = new View();

  $view->header("log-in", "Log in");

?>
</head>

<body>

  <?= $view->navbar("log-in"); ?>

  <center>
    <br>

    <h3><span class="fa fa-sign-in-alt mr-2"></span>Intră în cont</h3>

    <br>

    <form action="process.php?target=user&action=log-in" method="post">
      <div class="col-lg-6">
        <?php if (isset($_GET['error']) && $_GET['error']) { ?>
                  <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Oops.. </strong> Adresă de poștă electronică/Parolă greșită!
                  </div>

                  <br>
        <?php } else if (isset($_GET['success']) && $_GET['success']) { ?>
                  <div class="alert alert-dismissible alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Yabadabadoo.. </strong> Contul tău a fost creat cu succes, te rugăm să te autentifici!
                  </div>

                  <br>
        <?php } ?>

        <input type="email" class="form-control" name="tyEMail" placeholder="Poștă electronică"><br>
        <input type="password" class="form-control" name="tyPass" placeholder="Parolă"><br>
        <button type="submit" class="btn btn-success btn-lg btn-block" name="loginBtn">Intră în cont</button>
      </div>
    </form>
  </center>

  <br><br><br><br>

  <?= $view->footer("log-in"); ?>

</body>

</html>

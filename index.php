<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';

  if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'])
      header('Location: chapters.php');

  $view = new View();

  $view->header("index", "Bun venit!");

?>
</head>

<body>

  <?= $view->navbar("index"); ?>

  <div class="container">
    <br>

    <div class="row">
      <div class="col-lg-5">
        <?php if (isset($_GET['error']) && $_GET['error']) {?>
          <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Oops.. </strong> <?= $_SESSION['Error'] ?>
          </div>

          <br>
        <?php } ?>
        <h3><span class="fa fa-user-plus mr-2"></span>Înscrie-te</h3>
        <p>Este gratis și așa va rămâne.</p>
        <form action="process.php?target=user&action=sign-up" method="post">
          <input type="text" class="form-control" name="tyFName" placeholder="Prenume"><br>
          <input type="text" class="form-control" name="tyLName" placeholder="Nume"><br>
          <input type="email" class="form-control" name="tyEMail" placeholder="Poștă electronică"><br>
          <input type="password" class="form-control" name="tyPass" placeholder="Parolă"><br>
          <input type="password" class="form-control" name="retyPass" placeholder="Confirmă parolă"><br>
          <div class="form-group">
            <label for="selExamType">Tip bacalaureat:</label>
            <select id="selExamType" class="form-control" name="selExamType">
              <option value="1" selected>Anatomie și genetică umană</option>
              <option value="2">Biologie vegetală și animală</option>
            </select>
          </div>
          <div class="form-group">
            <label for="selExamType">Te-a adus un prieten?</label>
            <input type="text" class="form-control" name="tyRefferal" placeholder="Cod prieten">
          </div>
          <button type="submit" class="btn btn-success btn-lg btn-block" name="registerBtn">Înscrie-te</button>
        </form>
      </div>
      <div class="col-lg-6 offset-md-1">
        <h3>Bacalaureat la biologie?</h3>
        <p>Pregătește-te și ia cu succes bacalaureatul la Biologie.</p>

        <br>

        <!-- https://techforluddites.com/replacing-list-bullets-with-images-using-css/ -->
        <style>
          ul.bulletless {
            list-style-type: none;
            padding: 0;
            margin: 0;
          }

          li.challenge {
            background: url('assets/challenge.png') no-repeat left top;
            height: 64px;
            padding-left: 96px;
            padding-top: 16px;
            margin-bottom: 48px;
          }

          li.trophee {
            background: url('assets/tropheebullet.png') no-repeat left top;
            height: 64px;
            padding-left: 96px;
            padding-top: 16px;
            margin-bottom: 48px;
          }

          li.community {
            background: url('assets/community.png') no-repeat left top;
            height: 64px;
            padding-left: 96px;
            padding-top: 16px;
            margin-bottom: 48px;
          }
        </style>

        <ul class="bulletless">
          <li class="challenge"><h5>Invită-ți prietenii la suuuper provocări.</h5></li>
          <li class="trophee"><h5>Câștigă trofee îndeplinind misiunile.</h5></li>
          <li class="community"><h5>Fă parte dintr-o comunitate unită.</h5></li>
        </ul>
      </div>
    </div>
  </div>

  <?= $view->footer("index"); ?>

</body>

</html>

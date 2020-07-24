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

  $view->header("refferal", "Invită-ți prietenii");
?>
</head>

<body>

  <?= $view->navbar("refferal", $_SESSION['ID']); ?>

  <br>

  <div class="container">
      <h3><?= $user->getCode($_SESSION['ID']) ?></h3>
      <p>Folosește codul de mai sus pentru a îți invita prietenii.</p>

      <br>

      <h3>De ce?</h3>
      <ul>
        <li><p>Fiindcă poți să îi inviți la provocări și să vedeți cine este cel mai bun la Biologie!</p></li>
        <li><p>La fiecare avansare în nivel a lui primești 1<span class="fa fa-viruses ml-1"></span> și 30% din XP-ul consumat.</p></li>
      </ul>

      <br>

      <h5><span class="fa fa-user-friends mr-2"></span>Prieteni invitați</h5>

      <?php $friendsData = $user->getFriends($user->getCode($_SESSION['ID'])); ?>

       <script> var i = 1; </script>

      <table id="friendsTable" class="table table-hover">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Prieten</th>
          <th scope="col">Nivel</th>
          <th scope="col">XP</th>
          <th scope="col">Trofee</th>
        </thead>
        <tbody>
          <?php foreach ($friendsData as $friendData) { ?>
                        <tr class="table">
                          <th scope="row"><script> document.write(i ++); </script></td>
                          <td><?= $user->getFName($friendData['ID']).' '.$user->getLName($friendData['ID']) ?></td>
                          <td><?= $user->getLevel($friendData['ID']) ?></td>
                          <td><?= $user->getXP($friendData['ID']) ?></td>
                          <td><?= $user->getTrophies($friendData['ID']) ?></td>
                        </tr>
          <?php } ?>
        </tbody>
      </table>

      <script>
          if (i == 1)
          {
              document.getElementById('friendsTable').style.display = 'none';
              document.write('0 prieteni invitați');
          }
      </script>
  </div>

  <br>

  <?= $view->footer("refferal"); ?>

</body>

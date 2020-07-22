<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/User.php';
  require_once 'source/Quiz.php';
  require_once 'source/Challenge.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  $user = new User();

  if (isset($_GET['challenge']))
    $view->header("challenges", "Provocarea #".$_GET['challenge']);
  else
    $view->header("challenges", "Provocările mele");

  $challenge = new Challenge();

?>
</head>

<body>

  <?= $view->navbar("challenges", $_SESSION['ID']); ?>

  <br>

  <?php if (!isset($_GET['challenge'])) { ?>
          <div class="container">
            <h3><span class="fa fa-bolt mr-2"></span>Provocările mele</h3>

            <br>

            <h5>Participă la o provocare</h5>
            <form action="process.php?target=challenge&action=join" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cod invitație" aria-label="Cod invitație" name="tyInvite" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-success" type="submit">Participă</button>
                </div>
              </div>
            </form>

            <br>

            <?php $userQuizzes = $user->getAllQuizzes($_SESSION['ID']); ?>

            <?php $fi = 0;
                  $finishedChallenges = array();

                  $at = 0;
                  $activeChallenges = array(); ?>

            <?php foreach ($userQuizzes as $userQuiz) {
                      if ($challenge->getStatus($userQuiz['Challenge']))
                          $finishedChallenges[$fi ++] = $userQuiz['Challenge'];
                      else
                          $activeChallenges[$at ++] = $userQuiz['Challenge'];
                  }
            ?>

            <h5>În desfășurare</h5>

            <?php if ($at == 0) { ?>
                      <p>Nu există!</p>
            <?php }
                  else
                  {
                      ?>

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Expiră în</th>
                            <th scope="col">Vezi</th>
                          </tr>
                        </thead>

                        <tbody>

                        <?php

                        for ($i = 0; $i < $at; $i ++)
                        {
                            ?>
                            <tr>
                              <td><?= $activeChallenges[$i] ?></td>
                              <?php
                                $now = new DateTime();
                                $expireAt = new DateTime($challenge->getExpireTime($activeChallenges[$i]));

                                $expireIn = $expireAt->diff($now);
                              ?>
                              <td><?= $expireIn->h ?> ore</td>
                              <td><a href="challenges.php?challenge=<?= $activeChallenges[$i] ?>" class="btn btn-success btn-sm">Mai multe</a></td>
                            </tr>
                            <?php
                        }

                        ?>

                        </tbody>
                      </table>

                        <?php
                  }
            ?>

            <br>

            <h5>Încheiate</h5>

            <?php if ($fi == 0) { ?>
                      <p>Nu există!</p>
            <?php }
                  else
                  {
                      ?>

                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Expirat acum</th>
                            <th scope="col">Vezi</th>
                          </tr>
                        </thead>

                        <tbody>

                        <?php

                        for ($i = 0; $i < $fi; $i ++)
                        {
                            ?>
                            <tr>
                              <td><?= $finishedChallenges[$i] ?></td>
                              <?php
                                $now = new DateTime();
                                $expiredAt = new DateTime($challenge->getExpireTime($finishedChallenges[$i]));

                                $sinceExpired = $now->diff($expiredAt);
                              ?>
                              <td><?= $sinceExpired->d ?> zile</td>
                              <td><a href="challenges.php?challenge=<?= $finishedChallenges[$i] ?>" class="btn btn-success btn-sm">Mai multe</a></td>
                            </tr>
                            <?php
                        }

                        ?>

                        </tbody>
                      </table>

                        <?php
                  }
            ?>
          </div>
  <?php } else { ?>
          <div class="container">
            <?php if (!$challenge->exist($_GET['challenge'])) header('Location: error.php'); ?>
            <ol class="breadcrumb">
              <?php $challengeStatus = $challenge->getStatus($_GET['challenge']); ?>
              <li class="breadcrumb-item"><a href="challenges.php">Provocări <?php if ($challengeStatus) echo 'încheiate'; else echo "în desfășurare"; ?></a></li>
              <li class="breadcrumb-item">Provocarea #<?= $_GET['challenge'] ?></li>
            </ol>

            <br>

            <?php if ($challengeStatus == 0) { ?>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="card border-light mb-3" style="max-width: 20rem;">
                            <div class="card-header">
                              Cod invitație
                            </div>
                            <div class="card-body">
                              <h2 class="card-title"><?= $_GET['challenge'] ?></h2>
                              <p>trimite-l la prieteni.<br></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="card border-light mb-3" style="max-width: 20rem;">
                            <div class="card-header">
                              Inițiator
                            </div>
                            <div class="card-body">
                              <?php $challengeCreator = $challenge->getCreator($_GET['challenge']) ?>
                              <h2 class="card-title"><?= $user->getFName($challengeCreator).' '.$user->getLName($challengeCreator) ?></h2>
                              <p>e vinovatul.<br></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="card border-light mb-3" style="max-width: 20rem;">
                            <div class="card-header">
                              Expiră în
                            </div>
                            <div class="card-body">
                              <?php
                                $now = new DateTime();
                                $expireAt = new DateTime($challenge->getExpireTime($_GET['challenge']));

                                $expireIn = $expireAt->diff($now);
                              ?>
                              <h2 class="card-title"><?= $expireIn->h ?> ore</h2>
                              <p>și <?= $expireIn->i ?> minute.<br></p>
                            </div>
                          </div>
                        </div>
                      </div>
            <?php } else { ?>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="card border-light mb-3" style="max-width: 20rem;">
                            <div class="card-header">
                              Câștigător
                            </div>
                            <div class="card-body">
                              <?php $challengeWinner = $challenge->getWinner($_GET['challenge']) ?>
                              <h2 class="card-title">
                                <?php
                                  if ($challengeWinner != 0)
                                      echo $user->getFName($challengeWinner).' '.$user->getLName($challengeWinner);
                                  else
                                      echo "Nimeni";
                                ?>
                              </h2>
                              <p>locul 1 numai 1.<br></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="card border-light mb-3" style="max-width: 20rem;">
                            <div class="card-header">
                              Inițiator
                            </div>
                            <div class="card-body">
                              <?php $challengeCreator = $challenge->getCreator($_GET['challenge']) ?>
                              <h2 class="card-title"><?= $user->getFName($challengeCreator).' '.$user->getLName($challengeCreator) ?></h2>
                              <p>e vinovatul.<br></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="card border-light mb-3" style="max-width: 20rem;">
                            <div class="card-header">
                              Expirat acum
                            </div>
                            <div class="card-body">
                              <?php
                                $now = new DateTime();
                                $expiredAt = new DateTime($challenge->getExpireTime($_GET['challenge']));

                                $sinceExpired = $now->diff($expiredAt);
                              ?>
                              <h2 class="card-title"><?= $sinceExpired->d ?> zile</h2>
                              <p>și nopți.<br></p>
                            </div>
                          </div>
                        </div>
                      </div>
            <?php } ?>

            <br>

            <h5>Clasament</h5>
            <?php $chParticipants = $challenge->getLeaderboard($_GET['challenge']); ?>

            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Participant</th>
                  <th scope="col">Notă</th>
                  <th scope="col">Timp</th>
                </tr>
              </thead>
              <?php $Winner = $challenge->getWinner($_GET['challenge']); ?>

              <tbody>
            <?php $p = 1;
                  foreach ($chParticipants as $chParticipant) { ?>
                      <tr <?php if ($chParticipant['Solver'] == $Winner) echo 'class="table-warning"'; ?> >
                        <th scope="row"><?php echo $p ++; ?></th>
                        <td>
                          <?php if ($chParticipant['Solver'] == $Winner) echo '<span class="badge badge-warning mr-2">Câștigător</span>'; ?>
                          <?= $user->getFName($chParticipant['Solver']).' '.$user->getLName($chParticipant['Solver']) ?>
                        </td>
                        <td><?= $chParticipant['Result'] ?></td>
                        <td><?= $chParticipant['STime'] ?> secunde</td>
                      </tr>
            <?php } ?>
              </tbody>
            </table>

          </div>
  <?php } ?>

  <?= $view->footer("challenges"); ?>

</body>

</html>

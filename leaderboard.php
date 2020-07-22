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

  $view->header("leaderboard", "Top 10");
?>
</head>

<body>

  <?= $view->navbar("leaderboard", $_SESSION['ID']); ?>

  <br>

  <div class="container">
      <h3><span class="fa fa-fire mr-2"></span>Top 10</h3>

      <div class="nav-wrapper">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
          <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fa fa-star mr-2"></i>Nivel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fa fa-trophy mr-2"></i>Trofee</a>
          </li>
        </ul>
      </div>
      <div class="card shadow">
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="fa fa-crown mr-2"></i>Geniu</th>
                    <th scope="col"><i class="fa fa-star mr-2"></i>Nivel</th>
                    <th scope="col"><i class="fa fa-star-half mr-2"></i>XP</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                  $usersData = $user->getAll('Level');

                  $i = 0;
                  foreach ($usersData as $userData)
                  {
                ?>
                      <tr class="table<?php if ($userData['ID'] == $_SESSION['ID']) echo '-active'; ?>">
                        <th scope="row"><?= ++ $i ?></th>
                        <td><?= $userData['fName'].' '.$userData['lName'] ?></td>
                        <td><?= $userData['Level'] ?></td>
                        <td><?= $userData['XP'] ?></td>
                      </tr>
                <?php
                      if ($i == 10 && !$user->isAdmin($_SESSION['ID']))
                          break;
                  }
                ?>

                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
              <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col"><i class="fa fa-crown mr-2"></i>Geniu</th>
                      <th scope="col"><i class="fa fa-trophy mr-2"></i>Trofee</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                    $usersData = $user->getAll('Trophies');

                    $i = 0;
                    foreach ($usersData as $userData)
                    {
                  ?>
                        <tr class="table<?php if ($userData['ID'] == $_SESSION['ID']) echo '-active'; ?>">
                          <th scope="row"><?= ++ $i ?></th>
                          <td><?= $userData['fName'].' '.$userData['lName'] ?></td>
                          <td><?= $userData['Trophies'] ?></td>
                        </tr>
                  <?php
                        if ($i == 10 && !$user->isAdmin($_SESSION['ID']))
                            break;
                    }
                  ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <?= $view->footer("leaderboard"); ?>

</body>

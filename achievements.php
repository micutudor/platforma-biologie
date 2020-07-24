<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/User.php';
  require_once 'source/Achievement.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  $user = new User();

  $achievement = new Achievement();

  $view->header("achievements", "Realizările mele");
?>
</head>

<body>

  <?= $view->navbar("achievements", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <h3><span class="fa fa-award mr-3"></span>Realizările mele</h3>

    <?php
        if (isset($_SESSION['Success']) && !is_null($_SESSION['Success'])) { ?>
          <br>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Yabadabadoo!</strong> <?= $_SESSION['Success'] ?>
          </div>

    <?php
          $_SESSION['Success'] = null; } ?>

    <br>
    <!-- Achievement #1 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Trofeul Calității</h5>
            <p class="card-text">Trofeu oferit din partea casei :)</p>

            <div class="progress-info">
      <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 1)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
      <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
      <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 1)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 1)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=1" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>
                      400 XP + 1<span class="fa fa-viruses ml-1"></span>
                    </a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Achievement #2 -->

    <br>

    <!-- Achievement #3 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">doctor Ciomu</h5>
            <p class="card-text">Realizează 100% la un capitol.</p>
            <div class="progress-info">
      <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 3)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
      <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
      <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 3)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 3)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=3" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #4 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">În oceanul Pacific</h5>
            <p class="card-text">Răspunde corect la o întrebare.</p>
            <div class="progress-info">
            <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 4)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 4)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 4)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=4" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $questionsCA = $user->countAllCorrectAnswers($_SESSION['ID']) ?>

    <!-- Achievement #5 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Ăla care face temele la colegi</h5>
            <p class="card-text">Răspunde corect la 50 de întrebări.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $questionsCA ?> din 50</span>
              </div>
              <div class="progress-percentage">
                <span><?= $questionsCA * 2 ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $questionsCA * 2 ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>


            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 5)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 5)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=5" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #6 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Ăla de la care copiază toată clasa</h5>
            <p class="card-text">Răspunde corect la 100 de întrebări.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $questionsCA ?> din 100</span>
              </div>
              <div class="progress-percentage">
                <span><?= $questionsCA ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $questionsCA ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 6)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 6)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=6" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #7 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Învățăcel</h5>
            <p class="card-text">Fixează o noțiune de teorie.</p>
            <div class="progress-info">
            <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 7)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 7)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 7)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=7" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $questionsFI = $user->countAllFixedInfos($_SESSION['ID']) ?>

    <!-- Achievement #8 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Fănikă</h5>
            <p class="card-text">Fixează-ți 50 de noțiuni teoretice.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $questionsFI ?> din 50</span>
              </div>
              <div class="progress-percentage">
                <span><?= $questionsFI * 2 ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $questionsFI * 2?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 8)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 8)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=8" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #9 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">MANUal</h5>
            <p class="card-text">Fixează-ți 100 de noțiuni teoretice.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $questionsFI ?> din 100</span>
              </div>
              <div class="progress-percentage">
                <span><?= $questionsFI ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $questionsFI ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 9)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 9)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=9" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #10 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Ce face chestia asta?</h5>
            <p class="card-text">Participă la o provocare.</p>
            <div class="progress-info">
            <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 10)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 10)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 10)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=10" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $userChallengesCount = $user->countChallenges($_SESSION['ID']) ?>

    <!-- Achievement #11 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Dependent în devenire</h5>
            <p class="card-text">Participă la 10 provocări.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $userChallengesCount ?> din 10</span>
              </div>
              <div class="progress-percentage">
                <span><?= $userChallengesCount * 10 ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $userChallengesCount * 10 ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 11)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 11)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=11" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #12 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Fost jucător de Farmville</h5>
            <p class="card-text">Participă la 50 de provocări.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $userChallengesCount ?> din 50</span>
              </div>
              <div class="progress-percentage">
                <span><?= $userChallengesCount * 2 ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $userChallengesCount * 2 ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 12)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 12)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=12" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #13 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Liga mică</h5>
            <p class="card-text">Câștigă o provocare la care participi.</p>
            <div class="progress-info">
            <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 13)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 13)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 13)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=13" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $wonChs = $user->countWonChallenges($_SESSION['ID']) ?>

    <!-- Achievement #14 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Zeu pe uliță</h5>
            <p class="card-text">Câștigă 5 provocări la care participi.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $wonChs ?> din 5</span>
              </div>
              <div class="progress-percentage">
                <span><?= $wonChs * 20 ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $wonChs * 20 ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>


            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 14)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 14)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=14" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #15 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Campion pe sate</h5>
            <p class="card-text">Câștigă 25 de provocări la care participi.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $wonChs ?> din 25</span>
              </div>
              <div class="progress-percentage">
                <span><?= $wonChs * 4 ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $wonChs * 4 ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 15)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 15)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=15" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $qwg_6 = $user->countQuizzesWithMinGrade($_SESSION['ID'], 6); ?>

    <!-- Achievement #16 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Trăiesc periculos</h5>
            <p class="card-text">Obține minim nota 6 la 35 chestionare.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $qwg_6 ?> din 35</span>
              </div>
              <?php $percentage = $qwg_6 / 35 * 100; ?>
              <div class="progress-percentage">
                <span><?= $percentage ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 16)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 16)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=16" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $qwg_8 = $user->countQuizzesWithMinGrade($_SESSION['ID'], 8); ?>

    <!-- Achievement #17 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Student la Iași sau Clug</h5>
            <p class="card-text">Obține minim nota 8 la 25 chestionare.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $qwg_8 ?> din 15</span>
              </div>
              <?php $percentage = $qwg_8 / 25 * 100; ?>
              <div class="progress-percentage">
                <span><?= $percentage ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 17)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 17)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=17" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <?php $qwg_10 = $user->countQuizzesWithMinGrade($_SESSION['ID'], 10); ?>

    <!-- Achievement #18 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Geniu cu parfum de București</h5>
            <p class="card-text">Obține nota 10 la 15 chestionare.</p>
            <div class="progress-info">
              <div class="progress-label">
                <span><?= $qwg_10 ?> din 15</span>
              </div>
              <?php $percentage = $qwg_10 / 15 * 100; ?>
              <div class="progress-percentage">
                <span><?= $percentage ?>%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 18)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 18)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=18" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #19 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Am creierul TDI</h5>
            <p class="card-text">Câștigă un concurs</p>
            <div class="progress-info">
            <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 19)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 19)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 19)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=1" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Achievement #20 -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <img src="assets/trophee.png" style="border-radius: 50%; width:240px; height:144px;">
          </div>
          <div class="col-lg-9">
            <h5 class="card-title">Dr. House</h5>
            <p class="card-text">100% la toate capitolele</p>
            <div class="progress-info">
            <?php if ($achievement->hasUserUnlocked($_SESSION['ID'], 20)) { ?>
              <div class="progress-percentage">
                <span>100%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <?php } else { ?>
              <div class="progress-percentage">
                <span>0%</span>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <?php } ?>

            <br>

            <?php if (!$achievement->hasUserUnlocked($_SESSION['ID'], 20)) { ?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-lock mr-2"></span>Blocată</a>
            <?php } else if ($achievement->hasUserClaimed($_SESSION['ID'], 20)){?>
                    <a href="" class="card-link btn btn-success btn disabled"><span class="fa fa-unlock mr-2"></span>Revendicat</a>
            <?php } else { ?>
                    <a href="process.php?target=achievement&action=achieve&target_id=20" class="card-link btn btn-success btn"><span class="fa fa-gift mr-2"></span><span class="fa fa-gift mr-2"></span>400 XP + 1<span class="fa fa-viruses ml-1"></span></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?= $view->footer("achievements"); ?>

</body>

</html>

<?php

  require_once 'Config.php';
  require_once 'User.php';

  class View
  {
      public function header($page, $title)
      {
          ?>

          <title><?=$title?> | <?=PROJECT_NAME?></title>

          <link rel="icon" href="assets/fav.png">

          <meta charset="UTF-8">

          <!-- Fonts -->
          <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

          <!-- Icons -->
          <link href="css/nucleo-icons.css" rel="stylesheet">
          <link href="css/fontawesome.css" rel="stylesheet">

          <!-- Theme CSS -->
          <link type="text/css" href="css/argon-design-system.min.css" rel="stylesheet">

          <?php
            if ($page == 'chapters' || $page == 'lesson') {
          ?>
                <script src="https://cdn.tiny.cloud/1/wb26kj3m6drenx3jz5jbx6mdyrxleo3jpu54ty9nre3hrcox/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

                <script type="text/javascript">
                  tinymce.init({
                    selector: '#lessonContent',
                    plugins: [
                      "advlist autolink link lists charmap preview hr anchor pagebreak",
                      "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking",
                      "save table contextmenu directionality emoticons paste textcolor"
                    ]
                  });
                </script>
          <?php
            }
          ?>

          <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
          <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
          <meta name="viewport" content="width=device-width" />
          <?php
      }

      public function navbar($page, $userID = 0)
      {
          $user = new User();

          ?>
          <nav id="siteNavbar" class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container">
              <a href="index.php">
                <img src="assets/logo.png" width="120" height="46">
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <?php if ($page == 'index' || $page == 'log-in') { ?>
                      <div class="collapse navbar-collapse" id="navbarColor02">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item <?php if ($page == 'log-in') echo 'active'; ?>">
                            <a class="nav-link" href="log-in.php"><span class="fa fa-sign-in-alt mr-2"></span>Intră în cont</a>
                          </li>
                        </ul>
                      </div>
              <?php } else if ($page != 'error' && $page != 'about-us'){ ?>
                      <div class="collapse navbar-collapse" id="navbarColor02">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item <?php if ($page == 'chapters' || $page == 'lesson' || $page == 'training' || $page == 'questions' || $page == 'formulas' || $page == 'constants') echo 'active' ?> dropdown">
                            <a class="nav-link nav-link-icon dropdown-toggle" id="learningDropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-book-reader mr-2"></i>Mediu de învățare</a>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="learningDropdown">
                              <a class="dropdown-item <?php if ($page == 'chapters' || $page == 'lesson' || $page == 'training' || $page == 'questions') echo 'active' ?> " href="chapters.php">
                                <span class="fa fa-book mr-2"></span>Capitole
                              </a>
                              <a class="dropdown-item <?php if ($page == 'formulas') echo 'active' ?> " href="formulas.php">
                                <i class="fas fa-calculator mr-2"></i>Formule
                              </a>
                              <a class="dropdown-item <?php if ($page == 'constants') echo 'active' ?> " href="constants.php">
                                <span class="fa fa-square-root-alt mr-2"></span>Constante
                              </a>
                            </div>
                          </li>
                          <li class="nav-item <?php if ($page == 'quiz') echo 'active' ?>">
                            <a class="nav-link nav-link-icon" href="quiz.php?before"><i class="fa fa-play mr-2"></i>Simulare examen</a>
                          </li>
                          <li class="nav-item <?php if ($page == 'game') echo 'active' ?>">
                            <a class="nav-link nav-link-icon" href="play.php"><i class="fa fa-gamepad mr-2"></i>Joc</a>
                          </li>
                          <li class="nav-item <?php if ($page == 'contests') echo 'active' ?>">
                            <a class="nav-link nav-link-icon" href="contests.php"><i class="fa fa-trophy mr-2"></i>Concursuri</a>
                          </li>
                          <li class="nav-item <?php if ($page == 'leaderboard') echo 'active' ?>">
                            <a class="nav-link nav-link-icon" href="leaderboard.php"><i class="fa fa-fire mr-2"></i>Top 10</a>
                          </li>
                          <li class="nav-item <?php if ($page == 'settings' || $page == 'refferal' || $page == 'challenges' || $page == 'achievements' || $page == 'xp') echo 'active' ?> dropdown">
                            <a class="nav-link nav-link-icon dropdown-toggle" id="userDropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="ni ni-circle-08"></i>
                                <span class="nav-link-inner--text">
                                  Salut, <?= $user->getFName($userID) ?>!
                                </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                              <a class="dropdown-item <?php if ($page == 'level') echo 'active' ?> " href="level.php"><span class="fa fa-star mr-2"></span>Nivel <?= $user->getLevel($userID) ?> <span class="badge badge-success"><?= $user->getXP($userID) ?> XP</span></a>
                              <a class="dropdown-item <?php if ($page == 'coins') echo 'active' ?> " href="coins.php"><?= $user->getCoins($userID) ?><i class="fas fa-viruses ml-2"></i></a>
                              <a class="dropdown-item <?php if ($page == 'challenges') echo 'active' ?> " href="challenges.php"><span class="fa fa-bolt mr-2"></span>Provocări</a>
                              <a class="dropdown-item <?php if ($page == 'achievements') echo 'active' ?> " href="achievements.php"><span class="fas fa-award mr-2"></span>Realizări</a>
                              <a class="dropdown-item <?php if ($page == 'refferal') echo 'active' ?> " href="refferal.php"><span class="fa fa-share-square mr-2"></span>Invită-ți prietenii</a>
                              <a class="dropdown-item <?php if ($page == 'settings') echo 'active' ?> " href="settings.php"><span class="fa fa-cog mr-2"></span>Setări</a>
                              <a class="dropdown-item" href="log-out.php"><span class="fas fa-sign-out-alt mr-2"></span>Deconectează-te</a>
                            </div>
                          </li>
                        </ul>
                      </div>
              <?php } ?>

            </div>
          </nav>
          <?php
      }

      public function footer($page)
      {
          ?>
          <!-- Core -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="https://unpkg.com/@popperjs/core@2.4.2/dist/umd/popper.min.js"></script>

          <!-- Theme JS -->
          <script src="js/argon-design-system.min.js"></script>

          <br>

          <footer class="footer">
            <div class="container">
              <div class="row">
                <div class="col-lg-4 mb-1">
                  <h5><?= PROJECT_NAME ?></h5>
                  <a href="about-us.php">despre proiect</a><br>
                  <a href="mailto:tudor.micubd@gmail.com">contactează-ne</a><br>
                  <p>(c) 2020 tudor m feat. andrei gh</p>
                </div>
                <div class="col-lg-4 mb-2">
                  <h5>Legal</h5>
                  <a href="docs/terms.docx">termeni și condiții</a><br>
                  <a href="docs/privacy.docx">privacy</a><br>
                  <a href="docs/cookies.docx">cookies</a>
                </div>
                <div class="col-lg-4 mb-1">
                  <h5>Ne găsești pe:</h5>
                  <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-square"></i> facebook</a><br>
                  <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i> twitter</a><br>
                  <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i> instagram</a>
                </div>
              </div>
            </div>
          </footer>
          <?php
      }
  }

?>

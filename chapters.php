<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/Chapter.php';
  require_once 'source/Lesson.php';
  require_once 'source/Question.php';
  require_once 'source/User.php';
  require_once 'source/Contest.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  $user = new User();

  $chapter = new Chapter();
  $lesson = new Lesson();
  $question = new Question();

  if (!isset($_GET['chapter']))
  {
      $view->header("chapters", "Capitole");

      if (!isset($_POST['viewCategory']))
          $viewCategory = $user->getExamType($_SESSION['ID']);
      else
          $viewCategory = $_POST['viewCategory'];
  }
  else
      $view->header("chapters", $chapter->getTitle($_GET['chapter']));

?>
</head>

<body>

  <?= $view->navbar("chapters", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <?php if (!isset($_GET['chapter'])) { ?>
      <?php
        if ($user->isAdmin($_SESSION['ID'])) {
        ?>
          <div class="row">
            <div class="col-lg-6">
              <form action="chapters.php" method="post">
                <div class="form-group">
                  <label for="selExamType">Arată capitole din:</label>
                  <div class="input-group mb-3">
                    <select id="selExamType" class="form-control" name="viewCategory">
                      <option value="1" <?php if ($viewCategory == 1) echo 'selected'; ?> >Anatomie și genetică umană</option>
                      <option value="2" <?php if ($viewCategory == 2) echo 'selected'; ?> >Biologie vegetală și animală</option>
                    </select>
                    <div class="input-group-append">
                      <button class="btn btn-success" type="submit"><span class="fa fa-binoculars mr-2"></span>Arată</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="btnCreateChapter">Alte opțiuni:</label><br>
                <button type="button" class="btn btn-success" id="btnCreateChapter" data-toggle="modal" data-target="#createChapter">
                  <span class="fa fa-plus-square mr-2"></span>Creează capitol
                </button>
              </div>
            </div>
          </div>

          <br>
      <?php
        }
      ?>

      <h3>
        <span class="fa fa-book mr-2"></span>Capitole din <?php if ($viewCategory == 1) echo 'Anatomie și genetică umană'; else echo 'Biologie vegetală și animală'; ?>
      </h3>

    <?php } else { ?>
      <?php
          $chapterTitle = $chapter->getTitle($_GET['chapter']);
          $chapterCategory = $chapter->getCategory($_GET['chapter']);
      ?>

      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="chapters.php">
              <?php if ($chapterCategory == 1) echo 'Anatomie și genetică umană'; else echo 'Biologie vegetală și animală'; ?>
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?= $chapterTitle ?></li>
        </ol>
      </nav>

      <br>

      <h3><?= $chapterTitle ?></h3>

      <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editChapter">
          <span class="fa fa-edit"></span> Modifică
        </button>

        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteChapter">
          <span class="fa fa-trash"></span> Șterge
        </button>
      <?php } ?>

    <?php } ?>

    <br>

    <?php if (isset($_GET['success']) && $_GET['success'] && !is_null($_SESSION['Success'])) { ?>
          <br>

          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Yabadabadoo!</strong> <?= $_SESSION['Success'] ?>
          </div>
    <?php } $_SESSION['Success'] = null; ?>

    <?php if (!isset($_GET['chapter'])) { ?>
        <div class="row">
            <?php
                $row_count = 0;

                $chaptersData = $chapter->getCategoryAll($viewCategory);

                foreach ($chaptersData as $chapterData)
                {
            ?>
                  <div class="col-lg-4">
                    <div class="card border-light mb-3" style="max-width: 20rem;">
                      <div class="card-header">
                        <div class="row">
                          <div class="col text-left">
                            <a href="chapters.php?chapter=<?= $chapterData['ID'] ?>"><?= $chapterData['Title'] ?></a>
                          </div>
                          <div class="col text-right">
                             <span class="badge badge-success"><i class="fa fa-star mr-2"></i><?= $chapterData['Level'] ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                          <div class="card-text"><?= $chapterData['Description'] ?></div>
                          <div class="progress-info">
                            <?php
                              $chapterQuestionsCount = $chapter->countQuestions($chapterData['ID']);
                              if ($chapterQuestionsCount == 0) $chapterQuestionsCount = 1;

                              $percentageCA = ($user->countCorrectAnswers($_SESSION['ID'], $chapterData['ID']) / $chapterQuestionsCount) * 50;
                              $percentageFI = ($user->countFixedInfos($_SESSION['ID'], $chapterData['ID']) / $chapterQuestionsCount) * 50;
                              $percentage = floor($percentageCA + $percentageFI);
                            ?>
                            <div class="progress-percentage">
                              <span><?= $percentage ?>%</span>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentage ?>%;">
                            </div>
                          </div>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <a href="chapters.php?chapter=<?= $chapterData['ID'] ?>"><span class="fa fa-book-open mr-2"></span>Vezi cuprins lecții</a>
                            </li>
                            <li class="list-group-item"><a href="chapters.php?chapter=<?= $chapterData['ID'] ?>&a"><span class="ni ni-user-run mr-2"></span>Antrenează-te</a></li>
                          </ul>
                      </div>
                    </div>
                  </div>

                  <?php $row_count ++; if ($row_count == 3) { $row_count = 0; echo '</div><br><div class="row">'; } ?>

            <?php
                }
            ?>
        </div>
    <?php } else { ?>
        <?php if ($user->getLevel($_SESSION['ID']) < $chapter->getLevel($_GET['chapter']) && !$user->isAdmin($_SESSION['ID'])) { ?>
                <p class="pb-5">Nu ai nivelul necesar pentru a putea accesa acest capitol!</p>
                <br><br><br><br>
        <?php } else { ?>
                <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link mb-sm-3 mb-md-0 <?php if (!isset($_GET['a'])) echo 'active'; ?>" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                      <i class="ni ni-books mr-2"></i>Lecții
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link mb-sm-3 mb-md-0 <?php if (isset($_GET['a'])) echo 'active'; ?>" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                      <i class="ni ni-user-run mr-2"></i>Antrenează-te
                      </a>
                    </li>
                    <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                      <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                          <i class="fa fa-question mr-2"></i>Toate întrebările
                        </a>
                      </li>
                    <?php } ?>
                  </ul>
                </div>
                <div class="card shadow">
                  <div class="card-body">
                      <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade <?php if (!isset($_GET['a'])) echo 'show active'; ?>" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                              <p class="description">Au fost găsite <?= $chapter->countLessons($_GET['chapter']) ?> lecții din capitolul <?= $chapterTitle ?>.</p>

                              <?php
                                $lessonsData = $lesson->getChapterAll($_GET['chapter']);

                                foreach ($lessonsData as $lessonData)
                                {
                              ?>
                                    <a href="lesson.php?lesson=<?= $lessonData['ID'] ?>">
                                      <i class="ni ni-single-copy-04 mr-2"></i><?= $lessonData['Title'] ?>
                                    </a>

                                    <br>
                              <?php
                                }
                              ?>

                              <br>

                              <br>

                              <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#createLesson">
                                  <span class="fa fa-plus-square"></span> Creează lecție
                                </button>
                              <?php } ?>
                          </div>
                          <div class="tab-pane fade <?php if (isset($_GET['a'])) echo 'show active'; ?>" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                            <p class="description">Antrenează-te răspunzând la întrebări din capitolul <?= $chapterTitle ?>.</p>
                            <p class="description">Răspunsuri corecte</p>
                            <div class="progress-info">
                              <?php $percentage = ($user->countCorrectAnswers($_SESSION['ID'], $_GET['chapter']) / $chapter->countQuestions($_GET['chapter'])) * 100; ?>
                              <div class="progress-percentage">
                                <span><?= $percentage ?>%</span>
                              </div>
                            </div>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentage ?>%;">
                              </div>
                            </div>
                            <br>
                            <p class="description">Noțiuni fixate</p>
                            <div class="progress-info">
                              <?php $percentage = ($user->countFixedInfos($_SESSION['ID'], $_GET['chapter']) / $chapter->countQuestions($_GET['chapter'])) * 100; ?>
                              <div class="progress-percentage">
                                <span><?= $percentage ?>%</span>
                              </div>
                            </div>
                            <div class="progress">
                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentage ?>%;">
                              </div>
                            </div>
                            <br>
                            <a href="training.php?chapter=<?= $_GET['chapter'] ?>" class="card-link">
                              <button type="button" class="btn btn-success"><span class="fa fa-play mr-2"></span>Start!</button>
                            </a>
                          </div>
                          <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <p class="description">
                              Au fost găsite <?= $chapter->countQuestions($_GET['chapter']) ?> întrebări din capitolul <?= $chapterTitle ?>.
                            </p>

                            <?php
                              $questionsData = $question->getChapterAll($_GET['chapter']);

                              foreach ($questionsData as $questionData)
                              {
                            ?>
                                  <a href="question.php?question=<?= $questionData['ID'] ?>">
                                    <i class="fa fa-question mr-2"></i><?= $questionData['Question'] ?>
                                  </a>
                                  <?php
                                    if ($questionData['Blocked'] == 1) echo '<span class="badge badge-danger">Concurs</span>';
                                  ?>

                                  <br>
                            <?php
                              }
                            ?>

                            <br>

                            <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#createQuestion">
                                <span class="fa fa-plus-square"></span> Creează întrebare
                              </button>
                            <?php } ?>
                          </div>
                      </div>
                  </div>
                </div>
        <?php } ?>
    <?php } ?>
  </div>

  <!-- Modals -->
  <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
    <div class="modal fade" id="createChapter" tabindex="-1" role="dialog" aria-hidden="true">
      <form action="process.php?target=chapter&action=create" method="post">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><span class="fa fa-plus-square mr-2"></span>Creează capitol</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" name="tyTitle" placeholder="Titlu"><br>
              <textarea name="tyDescription" class="form-control" placeholder="Descriere"></textarea><br>
              <input type="text" class="form-control" name="tyLevel" placeholder="Nivel necesar"><br>
              <div class="form-group">
                <label for="selCategory">Categorie</label>
                <select id="selCategory" class="form-control" name="selCategory">
                  <option value="1" <?php if ($viewCategory == 1) echo 'selected'; ?> >Anatomie și genetică umană</option>
                  <option value="2" <?php if ($viewCategory == 2) echo 'selected'; ?> >Biologie vegetală și animală</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
              <button type="submit" class="btn btn-success"><span class="fa fa-plus-square mr-2"></span>Creează</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <?php if (isset($_GET['chapter'])) { ?>
      <div class="modal fade" id="editChapter" tabindex="-1" role="dialog" aria-hidden="true">
        <form action="process.php?target=chapter&action=edit&target_id=<?= $_GET['chapter'] ?>" method="post">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-edit mr-2"></span>Modifică capitolul „<?= $chapter->getTitle($_GET['chapter']) ?>”</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="tyTitle">Titlu</label>
                  <input type="text" class="form-control" name="tyTitle" value="<?= $chapter->getTitle($_GET['chapter']) ?>">
                </div>
                <div class="form-group">
                  <label for="tyDescription">Descriere</label>
                  <textarea class="form-control" name="tyDescription"><?= $chapter->getDescription($_GET['chapter']) ?></textarea>
                </div>
                <div class="form-group">
                  <label for="tyLevel">Nivel necesar</label>
                  <input type="text" class="form-control" name="tyLevel" value="<?= $chapter->getLevel($_GET['chapter']) ?>">
                </div>
                <div class="form-group">
                  <label for="selCategory">Categorie</label>
                  <select id="selCategory" class="form-control" name="selCategory">
                    <option value="1" <?php if ($chapterCategory == 1) echo 'selected'; ?> >Anatomie și genetică umană</option>
                    <option value="2" <?php if ($chapterCategory == 2) echo 'selected'; ?> >Biologie vegetală și animală</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                <button type="submit" class="btn btn-primary"><span class="fa fa-edit mr-2"></span>Modifică</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal fade" id="deleteChapter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><span class="fa fa-trash mr-2"></span>Șterge capitolul „<?= $chapter->getTitle($_GET['chapter']) ?>”</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Ești sigur că dorești să ștergi capitolul „<?= $chapter->getTitle($_GET['chapter']) ?>”?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
              <a href="process.php?target=chapter&action=delete&target_id=<?= $_GET['chapter'] ?>">
                <button type="button" class="btn btn-danger"><span class="fa fa-trash mr-2"></span>Șterge</button>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="createLesson" tabindex="-1" role="dialog" aria-hidden="true">
        <form action="process.php?target=lesson&action=create" method="post">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-plus-square mr-2"></span>Creează lecție</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input class="form-control" name="tyTitle" placeholder="Titlu"><br>
                <div class="form-group">
                  <label for="selChapter">Capitol</label>
                  <select class="custom-select" name="selChapter" autocomplete="off">
                    <?php
                      $chaptersData = $chapter->getAll();

                      foreach ($chaptersData as $chapterData)
                      {
                    ?>
                          <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $_GET['chapter']) echo 'selected'; ?>>
                            <?= $chapterData['Title'] ?>
                          </option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="tyContent">Conținut</label>
                  <textarea id="lessonContent" name="tyContent"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                <button type="submit" class="btn btn-success"><span class="fa fa-plus-square mr-2"></span>Creează</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal fade" id="createQuestion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><span class="fa fa-plus-square mr-2"></span>Creează întrebare</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-question-text" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-question-text-1-tab" data-toggle="tab" href="#tabs-question-text-1" role="tab" aria-controls="tabs-question-text-1" aria-selected="true">Varianta corectă</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link mb-sm-3 mb-md-0" id="tabs-question-text-2-tab" data-toggle="tab" href="#tabs-question-text-2" role="tab" aria-controls="tabs-question-text-2" aria-selected="false">Adevărat/Fals</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link mb-sm-3 mb-md-0" id="tabs-question-text-3-tab" data-toggle="tab" href="#tabs-question-text-3" role="tab" aria-controls="tabs-question-text-3" aria-selected="false">Completează afirmația</a>
                  </li>
                </ul>
              </div>
              <div class="card shadow">
                <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tabs-question-text-1" role="tabpanel" aria-labelledby="tabs-question-text-1-tab">
                      <form action="process.php?target=question&action=create&type=1" method="post">
                        <input class="form-control" name="tyQuestion" placeholder="Întrebare"><br>
                        <div class="form-group">
                          <label for="selChapter">Capitol</label>
                          <select class="form-control" name="selChapter" autocomplete="off">
                            <?php
                              $chaptersData = $chapter->getAll();

                              foreach ($chaptersData as $chapterData)
                              {
                            ?>
                                  <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $_GET['chapter']) echo 'selected'; ?>>
                                    <?= $chapterData['Title'] ?>
                                  </option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="selContest">Concurs</label>
                          <select id="selContest" class="form-control" name="selContest" autocomplete="off">
                            <option value="0" selected>Niciunul</option>
                            <?php
                              $contest = new Contest();

                              $contestsData = $contest->getAll();
                              foreach ($contestsData as $contestData)
                              {
                                  if ($contestData['Status'] != 0)
                                      continue;
                            ?>
                                  <option value ="<?= $contestData['ID'] ?>" >
                                    <?= $contestData['Name'] ?>
                                  </option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tyAnsA">Răspuns A</label>
                          <textarea class="form-control" name="tyAnsA" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <div class="form-group">
                          <label for="tyAnsB">Răspuns B</label>
                          <textarea class="form-control" name="tyAnsB" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <div class="form-group">
                          <label for="tyAnsC">Răspuns C</label>
                          <textarea class="form-control" name="tyAnsC" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <div class="form-group">
                          <label for="tyAnsD">Răspuns D</label>
                          <textarea class="form-control" name="tyAnsD" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <div class="form-group">
                          <label for="selRightAns">Răspuns corect</label>
                          <select class="form-control" name="selRightAns" autocomplete="off">
                            <option value="1" selected>Răspuns A</option>
                            <option value="2">Răspuns B</option>
                            <option value="3">Răspuns C</option>
                            <option value="4">Răspuns D</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tyAnsEx">Explicație</label>
                          <textarea class="form-control" name="tyAnsEx" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><span class="fa fa-plus-square mr-2"></span>Creează</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="tabs-question-text-2" role="tabpanel" aria-labelledby="tabs-question-text-2-tab">
                      <form action="process.php?target=question&action=create&type=2" method="post">
                        <input class="form-control" name="tyQuestion" placeholder="Întrebare"><br>
                        <div class="form-group">
                          <label for="selChapter">Capitol</label>
                          <select class="form-control" name="selChapter" autocomplete="off">
                            <?php
                              $chaptersData = $chapter->getAll();

                              foreach ($chaptersData as $chapterData)
                              {
                            ?>
                                  <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $_GET['chapter']) echo 'selected'; ?>>
                                    <?= $chapterData['Title'] ?>
                                  </option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="selContest">Concurs</label>
                          <select id="selContest" class="form-control" name="selContest" autocomplete="off">
                            <option value="0" selected>Niciunul</option>
                            <?php
                              $contest = new Contest();

                              $contestsData = $contest->getAll();
                              foreach ($contestsData as $contestData)
                              {
                                  if ($contestData['Status'] != 0)
                                      continue;
                            ?>
                                  <option value ="<?= $contestData['ID'] ?>" >
                                    <?= $contestData['Name'] ?>
                                  </option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="selRightAns">Răspuns corect</label>
                          <select class="form-control" name="selRightAns" autocomplete="off">
                            <option value="1" selected>Adevărat</option>
                            <option value="2">Fals</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tyAnsEx">Explicație</label>
                          <textarea class="form-control" name="tyAnsEx" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><span class="fa fa-plus-square mr-2"></span>Creează</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="tabs-question-text-3" role="tabpanel" aria-labelledby="tabs-question-text-3-tab">
                      <form action="process.php?target=question&action=create&type=3" method="post">
                        <input class="form-control" name="tyQuestion" placeholder="Întrebare"><br>
                        <div class="form-group">
                          <label for="selChapter">Capitol</label>
                          <select class="form-control" name="selChapter" autocomplete="off">
                            <?php
                              $chaptersData = $chapter->getAll();

                              foreach ($chaptersData as $chapterData)
                              {
                            ?>
                                  <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $_GET['chapter']) echo 'selected'; ?>>
                                    <?= $chapterData['Title'] ?>
                                  </option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="selContest">Concurs</label>
                          <select id="selContest" class="form-control" name="selContest" autocomplete="off">
                            <option value="0" selected>Niciunul</option>
                            <?php
                              $contest = new Contest();

                              $contestsData = $contest->getAll();
                              foreach ($contestsData as $contestData)
                              {
                                  if ($contestData['Status'] != 0)
                                      continue;
                            ?>
                                  <option value ="<?= $contestData['ID'] ?>" >
                                    <?= $contestData['Name'] ?>
                                  </option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tyAns">Răspuns</label>
                          <input class="form-control" name="tyAns" placeholder="Bla, bla, bla..">
                        </div>
                        <div class="form-group">
                          <label for="tyAnsEx">Explicație</label>
                          <textarea class="form-control" name="tyAnsEx" placeholder="Bla, bla, bla.."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><span class="fa fa-plus-square mr-2"></span>Creează</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php } ?>

  <?= $view->footer("chapters"); ?>

</body>

</html>

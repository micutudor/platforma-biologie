<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/Chapter.php';
  require_once 'source/Question.php';
  require_once 'source/Contest.php';
  require_once 'source/User.php';

  if (!isset($_SESSION['LoggedIn']) && !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $user = new User();

  if (!isset($_GET['question']) || !$user->isAdmin($_SESSION['ID']))
      header('Location: error.php');

  $view = new View();

  $chapter = new Chapter();
  $question = new Question();

  $view->header("question", $question->getText($_GET['question']));

?>
</head>

<body>

  <?= $view->navbar("question", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <ol class="breadcrumb">
      <?php $questionChapter = $question->getChapter($_GET['question']); ?>
      <li class="breadcrumb-item"><a href="chapters.php">Capitole</a></li>
      <li class="breadcrumb-item"><a href="chapters.php?chapter=<?= $questionChapter ?>"><?= $chapter->getTitle($questionChapter) ?></a></li>
      <li class="breadcrumb-item active">(Întrebare) <?= $question->getText($_GET['question']) ?></li>
    </ol>

    <?php if (!is_null($_SESSION['Success'])) { ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Yabadabadoo!</strong> <?= $_SESSION['Success'] ?>
          </div>
          <br>
    <?php } $_SESSION['Success'] = null; ?>

    <br>

    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-center"><?= $question->getText($_GET['question']) ?></h4>
        <div class="text-center">
          <button type="button" class="card-link btn btn-primary btn-sm" data-toggle="modal" data-target="#editQuestion">
            <span class="fa fa-edit mr-2"></span>Modifică
          </button>
          <button type="button" class="card-link btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteQuestion">
            <span class="fa fa-trash mr-2"></span>Șterge
          </button>
        </div>
      </div>
    </div>

    <?php
        $rightAnsBadge = '<span class="badge badge-success"><span class="fa fa-check mr-2"></span>răspunsul corect</span>';
    ?>

    <?php if ($question->getType($_GET['question']) == 1) { ?>
      <br>

      <?php
          $rightAns = chr($question->getRightAns($_GET['question']) + 64);
      ?>

      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action disabled">
          A. <?= $question->getAnswer($_GET['question'], 'A') ?>
          <?php if ($rightAns == 'A') echo $rightAnsBadge; ?>
        </a>
        <a href="#" class="list-group-item list-group-item-action disabled">
          B. <?= $question->getAnswer($_GET['question'], 'B') ?>
          <?php if ($rightAns == 'B') echo $rightAnsBadge; ?>
        </a>
        <a href="#" class="list-group-item list-group-item-action disabled">
          C. <?= $question->getAnswer($_GET['question'], 'C') ?>
          <?php if ($rightAns == 'C') echo $rightAnsBadge; ?>
        </a>
        <a href="#" class="list-group-item list-group-item-action disabled">
          D. <?= $question->getAnswer($_GET['question'], 'D') ?>
          <?php if ($rightAns == 'D') echo $rightAnsBadge; ?>
        </a>
      </div>

      <br>

    <?php } else if ($question->getType($_GET['question']) == 2) { ?>
      <br>

      <?php
          $rightAns = $question->getRightAns($_GET['question']);
      ?>

      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action disabled">
          Adevărat
          <?php if ($rightAns == 1) echo $rightAnsBadge; ?>
        </a>
        <a href="#" class="list-group-item list-group-item-action disabled">
          Fals
          <?php if ($rightAns == 2) echo $rightAnsBadge; ?>
        </a>
      </div>

      <br>

    <?php } else { ?>
      <br>

      <input type="text" class="form-control" value="<?= $question->getAnswer($_GET['question'], 'A') ?>" disabled>

      <br>
    <?php } ?>

    <div class="alert alert-dismissible alert-success">
      <strong>Explicație:</strong> <?= $question->getAnsEx($_GET['question']) ?>
    </div>

  </div>

  <?php if ($question->getType($_GET['question']) == 1) { ?>
    <div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-hidden="true">
      <form action="process.php?target=question&action=edit&target_id=<?= $_GET['question'] ?>" method="post">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modifică întrebarea „<?= $question->getText($_GET['question']) ?>”.</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input class="form-control" name="tyQuestion" value="<?= $question->getText($_GET['question']) ?>"><br>
              <div class="form-group">
                <label for="selChapter">Capitol</label>
                <select class="custom-select" name="selChapter" autocomplete="off">
                  <?php
                    $chaptersData = $chapter->getAll();

                    foreach ($chaptersData as $chapterData)
                    {
                  ?>
                        <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $question->getChapter($_GET['question'])) echo 'selected'; ?>>
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
                        <option value ="<?= $contestData['ID'] ?>" <?php if ($question->getContest($_GET['question']) == $contestData['ID']) echo 'selected'; ?>>
                          <?= $contestData['Name'] ?>
                        </option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tyAnsA">Răspuns A</label>
                <textarea class="form-control" name="tyAnsA"><?= $question->getAnswer($_GET['question'], 'A'); ?></textarea>
              </div>
              <div class="form-group">
                <label for="tyAnsB">Răspuns B</label>
                <textarea class="form-control" name="tyAnsB"><?= $question->getAnswer($_GET['question'], 'B'); ?></textarea>
              </div>
              <div class="form-group">
                <label for="tyAnsC">Răspuns C</label>
                <textarea class="form-control" name="tyAnsC"><?= $question->getAnswer($_GET['question'], 'C'); ?></textarea>
              </div>
              <div class="form-group">
                <label for="tyAnsD">Răspuns D</label>
                <textarea class="form-control" name="tyAnsD"><?= $question->getAnswer($_GET['question'], 'D'); ?></textarea>
              </div>
              <div class="form-group">
                <label for="selRightAns">Răspuns corect</label>
                <select class="custom-select" name="selRightAns" autocomplete="off">
                  <option value="1" <?php if ($rightAns == 'A') echo 'selected' ?>>Răspuns A</option>
                  <option value="2" <?php if ($rightAns == 'B') echo 'selected' ?>>Răspuns B</option>
                  <option value="3" <?php if ($rightAns == 'C') echo 'selected' ?>>Răspuns C</option>
                  <option value="4" <?php if ($rightAns == 'D') echo 'selected' ?>>Răspuns D</option>
                </select>
              </div>
              <div class="form-group">
                <label for="tyAnsEx">Explicație</label>
                <textarea class="form-control" name="tyAnsEx"><?= $question->getAnsEx($_GET['question']) ?></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
              <button type="submit" class="btn btn-primary">Modifică</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php } else if ($question->getType($_GET['question']) == 2) { ?>
    <div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-hidden="true">
      <form action="process.php?target=question&action=edit&target_id=<?= $_GET['question'] ?>" method="post">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modifică întrebarea „<?= $question->getText($_GET['question']) ?>”.</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input class="form-control" name="tyQuestion" value="<?= $question->getText($_GET['question']) ?>"><br>
              <div class="form-group">
                <label for="selChapter">Capitol</label>
                <select class="custom-select" name="selChapter" autocomplete="off">
                  <?php
                    $chaptersData = $chapter->getAll();

                    foreach ($chaptersData as $chapterData)
                    {
                  ?>
                        <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $question->getChapter($_GET['question'])) echo 'selected'; ?>>
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
                        <option value ="<?= $contestData['ID'] ?>" <?php if ($question->getContest($_GET['question']) == $contestData['ID']) echo 'selected'; ?>>
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
                  <option value="1" <?php if ($question->getRightAns($_GET['question']) == 1) echo 'selected' ?> >Adevărat</option>
                  <option value="2" <?php if ($question->getRightAns($_GET['question']) == 2) echo 'selected' ?> >Fals</option>
                </select>
              </div>
              <div class="form-group">
                <label for="tyAnsEx">Explicație</label>
                <textarea class="form-control" name="tyAnsEx"><?= $question->getAnsEx($_GET['question']) ?></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
              <button type="submit" class="btn btn-primary">Modifică</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php } else { ?>
    <div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-hidden="true">
      <form action="process.php?target=question&action=edit&target_id=<?= $_GET['question'] ?>" method="post">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modifică întrebarea „<?= $question->getText($_GET['question']) ?>”.</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input class="form-control" name="tyQuestion" value="<?= $question->getText($_GET['question']) ?>"><br>
              <div class="form-group">
                <label for="selChapter">Capitol</label>
                <select class="custom-select" name="selChapter" autocomplete="off">
                  <?php
                    $chaptersData = $chapter->getAll();

                    foreach ($chaptersData as $chapterData)
                    {
                  ?>
                        <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $question->getChapter($_GET['question'])) echo 'selected'; ?>>
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
                        <option value ="<?= $contestData['ID'] ?>" <?php if ($question->getContest($_GET['question']) == $contestData['ID']) echo 'selected'; ?>>
                          <?= $contestData['Name'] ?>
                        </option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tyAns">Răspuns</label>
                <input class="form-control" name="tyAns" value="<?= $question->getAnswer($_GET['question'], 'A') ?>">
              </div>
              <div class="form-group">
                <label for="tyAnsEx">Explicație</label>
                <textarea class="form-control" name="tyAnsEx"><?= $question->getAnsEx($_GET['question']) ?></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
              <button type="submit" class="btn btn-primary">Modifică</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php } ?>

  <div class="modal fade" id="deleteQuestion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Șterge „<?= $question->getText($_GET['question']) ?>”</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Ești sigur că dorești să ștergi întrebarea „<?= $question->getText($_GET['question']) ?>”?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
          <a href="process.php?target=question&action=delete&target_id=<?= $_GET['question'] ?>">
            <button type="button" class="btn btn-primary">Șterge</button>
          </a>
        </div>
      </div>
    </div>
  </div>

  <?= $view->footer("question"); ?>

</body>

</html>

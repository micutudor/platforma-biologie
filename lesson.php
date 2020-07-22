<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/View.php';
  require_once 'source/Chapter.php';
  require_once 'source/Lesson.php';
  require_once 'source/User.php';
  require_once 'source/Post.php';

  if (!isset($_SESSION['LoggedIn']) && !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  if (!isset($_GET['lesson']))
      header('Location: error.php');

  $view = new View();

  $user = new User();

  $chapter = new Chapter();
  $lesson = new Lesson();

  if (!$lesson->exist($_GET['lesson']))
      header('Location: error.php');

  $lessonChapter = $lesson->getChapter($_GET['lesson']);

  if ($user->getLevel($_SESSION['ID']) < $chapter->getLevel($lessonChapter) && !$user->isAdmin($_SESSION['ID']))
      header('Location: chapters.php?chapter='.$lessonChapter);

  $view->header("lesson", $lesson->getTitle($_GET['lesson']));

?>
</head>

<body>

  <?= $view->navbar("lesson", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="chapters.php">Capitole</a></li>
      <li class="breadcrumb-item"><a href="chapters.php?chapter=<?= $lessonChapter ?>"><?= $chapter->getTitle($lessonChapter) ?></a></li>
      <li class="breadcrumb-item active"><?= $lesson->getTitle($_GET['lesson']) ?></li>
    </ol>

    <br>

    <?php if (isset($_GET['success']) && $_GET['success'] && !is_null($_SESSION['Success'])) { ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Yabadabadoo!</strong> <?= $_SESSION['Success'] ?>
          </div>

          <br>
    <?php } $_SESSION['Success'] = null; ?>

    <div class="row">
      <div class="col-lg-9">
        <h3>

        <?= $lesson->getTitle($_GET['lesson']) ?>

        <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editLesson">
                  <span class="fa fa-edit mr-2"></span>Modifică
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteLesson">
                  <span class="fa fa-trash mr-2"></span>Șterge
                </button>
        <?php } ?>

        </h3>

        <br>

        <p><?= $lesson->getContent($_GET['lesson']) ?></p>
      </div>
      <div class="col-lg-3">
        <h5><?= $chapter->getTitle($lessonChapter) ?></h5>
        <div class="list-group">
          <?php
            $lessonsData = $lesson->getChapterAll($lessonChapter);

            $i = 1;
            foreach ($lessonsData as $lessonData)
            {
          ?>
                <a href="lesson.php?lesson=<?= $lessonData['ID'] ?>" class="list-group-item list-group-item-action
                  <?php if ($lessonData['ID'] == $_GET['lesson']) echo 'active' ?>">
                  <?= $i ++.'. '.$lessonData['Title'] ?>
                </a>
          <?php
            }
          ?>
        </div>
      </div>
    </div>

    <br>

    <div id="questions">
      <h5>Întrebări</h5>

      <?php
            if (isset($_SESSION['Error']) && !is_null($_SESSION['Error'])) { ?>
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['Error'] ?>
              </div>

            <?php
              $_SESSION['Error'] = null; } ?>

      <form action="process.php?target=post&action=create" method="post">
        <textarea class="form-control" name="tyText" placeholder="Întrebarea ta"></textarea><br>
        <input type="hidden" name="lesson" value="<?= $_GET['lesson'] ?>">
        <button type="submit" class="btn btn-success float-right" <?php if ($user->getCoins($_SESSION['ID']) < 1) echo 'disabled'; ?> >
          <span class="fa fa-paper-plane mr-2"></span>Întreabă <span class="badge badge-secondary">1<i class="fas fa-viruses ml-2"></i></span>
        </button>
      </form>

      <br>

      <br>

      <br>

      <?php
          $lessonPosts = $lesson->getPosts($_GET['lesson']);
          foreach ($lessonPosts as $lessonPost) {
      ?>
              <div class="card" id="p<?= $postReply['ID'] ?>">
                <div class="card-body">
                  <h6 class="card-subtitle mb-2 text-muted"><?= $user->getFName($lessonPost['CreatedBy']) ?> întreabă</h6>
                  <p class="card-text"><?= $lessonPost['Text'] ?></p>
                  <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                    <a href="process.php?target=post&action=delete&target_id=<?= $lessonPost['ID'] ?>" class="card-link btn btn-sm btn-danger">
                      <span class="fa fa-trash mr-2"></span>Șterge
                    </a>
                  <?php } ?>
                  <a href="" class="card-link float-right btn btn-success" data-toggle="modal" data-target="#answer<?= $lessonPost['ID'] ?>">
                    <span class="fa fa-reply mr-2"></span>Răspunde
                  </a>
                </div>
              </div>

              <br>

              <div class="row">
                <div class="col offset-md-2">
              <?php
                  $post = new Post();

                  $postReplies = $post->getReplies($lessonPost['ID']);
                  foreach($postReplies as $postReply) {
              ?>
                      <div class="card <?php if ($postReply['ID'] == $lessonPost['BestReply']) echo 'text-white bg-warning mb-3' ?>" id="r<?= $postReply['ID'] ?>">
                        <div class="card-body">
                          <?php if ($postReply['ID'] == $lessonPost['BestReply']) { ?>
                            <h6 class="card-subtitle mb-2"><i class="fas fa-crown mr-1"></i><?= $user->getFName($postReply['CreatedBy']) ?> dă un răspuns de geniu:</h6>
                          <?php } else { ?>
                            <h6 class="card-subtitle mb-2 text-muted"><?= $user->getFName($postReply['CreatedBy']) ?> răspunde:</h6>
                          <?php } ?>
                          <p class="card-text"><?= $postReply['Text'] ?></p>
                          <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                            <a href="process.php?target=reply&action=delete&target_id=<?= $postReply['ID'] ?>" class="card-link btn btn-sm btn-danger">
                              <span class="fa fa-trash mr-2"></span>Șterge
                            </a>
                          <?php } ?>
                          <?php if ($_SESSION['ID'] == $lessonPost['CreatedBy'] && $_SESSION['ID'] != $postReply['CreatedBy'] && !$post->isAwardGiven($lessonPost['ID'])) { ?>
                            <a href="process.php?target=reply&action=award&target_id=<?= $postReply['ID'] ?>" class="card-link btn btn-sm btn-warning">
                            <i class="fas fa-crown mr-2"></i>Dă-i coroana
                            </a>
                          <?php } ?>
                        </div>
                      </div>

                      <br>
            <?php } ?>
                </div>
              </div>

              <div class="modal fade" id="answer<?= $lessonPost['ID'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <form action="process.php?target=reply&action=create&target_id=<?= $lessonPost['ID'] ?>" method="post">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Răspunde lui <?= $user->getFName($lessonPost['CreatedBy']) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="answerText">Răspuns</label>
                          <textarea id="answerText" name="tyText" class="form-control" placeholder="Răspunsul tău"></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                        <button type="submit" class="btn btn-success">Răspunde</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
    <?php } ?>
    </div>

  </div>

  <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
    <div class="modal fade" id="editLesson" tabindex="-1" role="dialog" aria-hidden="true">
      <form action="process.php?target=lesson&action=edit&target_id=<?= $_GET['lesson'] ?>" method="post">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><span class="fa fa-edit mr-2"></span><span class="fa fa-edit mr-2"></span>Modifică „<?= $lesson->getTitle($_GET['lesson']) ?>”</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="tyTitle">Titlu</label>
                <input type="text" class="form-control" name="tyTitle" value="<?= $lesson->getTitle($_GET['lesson']) ?>">
              </div>
              <div class="form-group">
                <label for="selChapter">Capitol</label>
                <select class="custom-select" name="selChapter" autocomplete="off">
                  <?php
                    $chaptersData = $chapter->getAll();

                    foreach ($chaptersData as $chapterData)
                    {
                  ?>
                        <option value="<?= $chapterData['ID'] ?>" <?php if ($chapterData['ID'] == $lessonChapter) echo 'selected'; ?>>
                          <?= $chapterData['Title'] ?>
                        </option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tyContent">Conținut</label>
                <textarea id="lessonContent" name="tyContent"><?= $lesson->getContent($_GET['lesson']) ?></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
              <button type="submit" class="btn btn-primary"><span class="fa fa-edit mr-2"></span><span class="fa fa-edit mr-2"></span>Modifică</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="modal fade" id="deleteLesson" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><span class="fa fa-trash mr-2"></span>Șterge „<?= $lesson->getTitle($_GET['lesson']) ?>”</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Ești sigur că dorești să ștergi lecția „<?= $lesson->getTitle($_GET['lesson']) ?>”?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
            <a href="process.php?target=lesson&action=delete&target_id=<?= $_GET['lesson'] ?>">
              <button type="button" class="btn btn-primary"><span class="fa fa-trash mr-2"></span>Șterge</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?= $view->footer("lesson"); ?>

</body>

</html>

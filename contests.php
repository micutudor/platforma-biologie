<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/Config.php';
  require_once 'source/View.php';
  require_once 'source/User.php';
  require_once 'source/Contest.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  $user = new User();
  $contest = new Contest();

  $view->header("contests", "Concursuri");

?>
</head>

<body>

  <?= $view->navbar("contests", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <?php if (!isset($_GET['contest'])) { ?>
              <h3><span class="fa fa-trophy mr-2"></span>Concursuri</h3>
              <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                        Opțiuni (administrator): <a href="" class="btn btn-success" data-toggle="modal" data-target="#createContest">
                                                 <span class="fa fa-plus-square mr-2"></span>Creează concurs
                                                 </a>
                        <?php $contestsData = $contest->getAll(); ?>
              <?php } else {
                         $contestsData = $contest->getCategoryAll($user->getExamType($_SESSION['ID']));
                    }
              ?>

              <br>

              <br>

              <table class="table table-hover">
                <thead>
                  <th scope="col">Concurs</th>
                  <th scope="col">Status</th>
                  <?php if ($user->isAdmin($_SESSION['ID'])) echo '<th scope="col">Categorie</th>'; ?>
                  <th scope="col">Mai mult</th>
                </thead>

                <tbody>
                  <?php
                      foreach ($contestsData as $contestData) {
                  ?>
                        <tr>
                          <td><?= $contestData['Name'] ?></td>
                          <td>
                              <?php if ($contestData['Status'] == 0)
                                       echo '<span class="badge badge-warning">În curând</span>';
                                    else if ($contestData['Status'] == 1)
                                       echo '<span class="badge badge-danger">În desfășurare</span>';
                                    else
                                       echo '<span class="badge badge-success">Încheiat</span>';
                              ?>
                          </td>
                          <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                                    <td>
                                      <?php if ($contestData['Category'] == 1) echo 'AGU'; else echo 'BVA'; ?>
                                    </td>
                          <?php } ?>
                          <td><a href="?contest=<?= $contestData['ID'] ?>" class="btn btn-success">Mai mult</td>
                        </tr>
                <?php } ?>
                </tbody>
              </table>

              <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                        <div class="modal fade" id="createContest" tabindex="-1" role="dialog" aria-hidden="true">
                          <form action="process.php?target=contest&action=create" method="post">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title"><span class="fa fa-plus-square mr-2"></span>Creează concurs</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <input type="text" class="form-control" name="tyName" placeholder="Denumire"><br>
                                  <textarea class="form-control" name="tyDescription" placeholder="Descriere"></textarea><br>
                                  <div class="form-group">
                                    <label for="selCategory">Categorie</label>
                                    <select id="selCategory" class="form-control" name="selCategory">
                                      <option value="1" selected>Anatomie și genetică umană</option>
                                      <option value="2">Biologie vegetală și animală</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="inpDate">Dată</label>
                                    <input type="date" id="inpDate" class="form-control" name="tyDate">
                                  </div>
                                  <div class="form-group">
                                    <label for="inpHour">Oră</label>
                                    <input type="time" id="inpHour" class="form-control" name="tyHour">
                                  </div>
                                  <div class="form-group">
                                    <label for="inpTime">Durată</label>
                                    <div class="input-group">
                                      <input type="text" id="inpTime" class="form-control" name="tyTime" aria-describedby="inpTimeAddon">
                                      <div class="input-group-append">
                                        <span class="input-group-text" id="inpTimeAddon">minute</span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inpPrize">Răsplată</label>
                                    <div class="input-group">
                                      <input type="text" id="inpPrize" class="form-control" name="tyPrize" aria-describedby="inpPrizeAddon">
                                      <div class="input-group-append">
                                        <span class="input-group-text" id="inpPrizeAddon"><i class="fa fa-viruses"></i></span>
                                      </div>
                                    </div>
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
              <?php } ?>
    <?php } else {
              if (!$contest->exist($_GET['contest']))
                  header('Location: error.php');

              $contestData = $contest->getData($_GET['contest']);
    ?>
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="contests.php">Concursuri</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?= $contestData['Name'] ?></li>
                </ol>
              </nav>

              <br>

              <?php
                if ($contestData['Status'] == 0)
                {
              ?>
                    <h5><?= $contestData['Name'] ?></h5>
                    <p><?= $contestData['Description'] ?></p>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Are loc pe
                          </div>
                          <div class="card-body">
                            <?php $startAt = new DateTime($contestData['SDateTime']); ?>
                            <h2 class="card-title"><?= $startAt->format('Y-m-d') ?></h2>
                            <p>ora <?= $startAt->format('H:i') ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Durată
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $contestData['Length'] ?></h2>
                            <p>minute</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Recompensă
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $contestData['Prize'] ?><span class="fa fa-viruses ml-2"></h2>
                            <p>și un trofeu :-)</p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                              <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#editContest">
                                <span class="fa fa-edit mr-2"></span>Modifică
                              </button>
                              <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteContest">
                                <span class="fa fa-minus-square mr-2"></span>Șterge
                              </button>
                    <?php } ?>

                    <?php if ($user->isAdmin($_SESSION['ID'])) { ?>
                              <div class="modal fade" id="editContest" tabindex="-1" role="dialog" aria-hidden="true">
                                <form action="process.php?target=contest&action=edit&target_id=<?= $contestData['ID'] ?>" method="post">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Modifică concursul „<?= $contestData['Name'] ?>”</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="text" class="form-control" name="tyName" placeholder="Denumire" value="<?= $contestData['Name'] ?>"><br>
                                        <textarea class="form-control" name="tyDescription" placeholder="Descriere"><?= $contestData['Description'] ?></textarea><br>
                                        <div class="form-group">
                                          <label for="selCategory">Categorie</label>
                                          <select id="selCategory" class="form-control" name="selCategory">
                                            <option value="1" <?php if ($contestData['Category'] == 1) echo 'selected' ?> >Anatomie și genetică umană</option>
                                            <option value="2" <?php if ($contestData['Category'] == 2) echo 'selected' ?> >Biologie vegetală și animală</option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label for="inpDate">Dată</label>
                                          <input type="date" id="inpDate" class="form-control" value="<?= $startAt->format('Y-m-d') ?>" name="tyDate">
                                        </div>
                                        <div class="form-group">
                                          <label for="inpHour">Oră</label>
                                          <input type="time" id="inpHour" class="form-control" value="<?= $startAt->format('H:i') ?>" name="tyHour">
                                        </div>
                                        <div class="form-group">
                                          <label for="inpTime">Durată</label>
                                          <div class="input-group">
                                            <input type="text" id="inpTime" class="form-control" name="tyTime" value="<?= $contestData['Length'] ?>" aria-describedby="inpTimeAddon">
                                            <div class="input-group-append">
                                              <span class="input-group-text" id="inpTimeAddon">minute</span>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="inpPrize">Răsplată</label>
                                          <div class="input-group">
                                            <input type="text" id="inpPrize" class="form-control" name="tyPrize" value="<?= $contestData['Prize'] ?>" aria-describedby="inpPrizeAddon">
                                            <div class="input-group-append">
                                              <span class="input-group-text" id="inpPrizeAddon"><i class="fa fa-viruses"></i></span>
                                            </div>
                                          </div>
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

                              <div class="modal fade" id="deleteLesson" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Șterge „<?= $contestData['Name'] ?>”</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Ești sigur că dorești să ștergi concursul „<?= $contestData['Length'] ?>”?
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                                      <a href="process.php?target=contest&action=delete&target_id=<?= $_GET['contest'] ?>">
                                        <button type="button" class="btn btn-primary">Șterge</button>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                    <?php } ?>
              <?php
                } else if ($contestData['Status'] == 1) { ?>

                    <h5><?= $contestData['Name'] ?></h5>
                    <p><?= $contestData['Description'] ?></p>

                    <div class="row">
                      <div class="col-lg-4">
                        <?php
                          $now = new DateTime();
                          $contestStartedAt = new DateTime($contestData['SDateTime']);

                          if ($now >= $contestStartedAt->modify('+3 minutes'))
                          {
                        ?>
                              <div class="card border-light mb-3" style="max-width: 20rem;">
                                <div class="card-header">
                                  Participă
                                </div>
                                <div class="card-body">
                                  <div class="card-title">
                                    <a href="" class="btn btn-success disabled">Participă</a>
                                  </div>
                                  <p>Înscrierile au fost închise!</p>
                                </div>
                              </div>
                        <?php
                          } else {
                        ?>
                              <div class="card border-light mb-3" style="max-width: 20rem;">
                                <div class="card-header">
                                  Participă
                                </div>
                                <div class="card-body">
                                  <div class="card-title">
                                    <a href="process.php?target=contest&action=join&target_id=<?= $_GET['contest'] ?>" class="btn btn-success">Participă</a>
                                  </div>
                                  <p>și alătură-te distracției</p>
                                </div>
                              </div>
                        <?php
                          }
                        ?>
                      </div>
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Durată
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $contestData['Length'] ?></h2>
                            <p>minute</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Recompensă
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $contestData['Prize'] ?><span class="fa fa-viruses ml-2"></h2>
                            <p>și un trofeu :-)</p>
                          </div>
                        </div>
                      </div>
                    </div>

              <?php
                } else if ($contestData['Status'] == 2) {
              ?>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Câștigător
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $user->getFName($contestData['Winner']).' '.$user->getLName($contestData['Winner']) ?></h2>
                            <p>e locul 1 numai 1</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Durată
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $contestData['Length'] ?></h2>
                            <p>minute</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="card border-light mb-3" style="max-width: 20rem;">
                          <div class="card-header">
                            Recompensă
                          </div>
                          <div class="card-body">
                            <h2 class="card-title"><?= $contestData['Prize'] ?><span class="fa fa-viruses ml-2"></h2>
                            <p>și un trofeu :-)</p>
                          </div>
                        </div>
                      </div>
                    </div>
              <?php
                }
              ?>

              <?php
                if ($contestData['Status'] != 0) {
              ?>
                    <br>

                    <h5>Clasament <?php if ($contestData['Status'] == 1) echo '(provizoriu)'; ?></h5>
                    <?php $ctParticipants = $contest->getLeaderboard($_GET['contest']); ?>

                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Participant</th>
                          <th scope="col">Notă</th>
                          <th scope="col">Timp</th>
                        </tr>
                      </thead>


                      <?php if ($contestData['Status'] == 2) $Winner = $contest->getWinner($_GET['contest']); ?>

                      <tbody>
                    <?php $p = 1;
                          foreach ($ctParticipants as $ctParticipant) { ?>
                              <tr <?php if (isset($Winner) && $ctParticipant['Solver'] == $Winner) echo 'class="table-warning"'; ?> >
                                <th scope="row"><?php echo $p ++; ?></th>
                                <td>
                                  <?php if (isset($Winner) && $ctParticipant['Solver'] == $Winner) echo '<span class="badge badge-warning mr-2">Câștigător</span>'; ?>
                                  <?= $user->getFName($ctParticipant['Solver']).' '.$user->getLName($ctParticipant['Solver']) ?>
                                </td>
                                <td><?= $ctParticipant['Result'] ?></td>
                                <td><?= $ctParticipant['STime'] ?> secunde</td>
                              </tr>
                    <?php } ?>
                      </tbody>
                    </table>
              <?php
                }
              ?>
    <?php } ?>
  </div>

  <br>

  <?= $view->footer("contests"); ?>

</body>

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

  $view->header("formulas", "Formule");

?>
</head>

<body>

  <?= $view->navbar("formulas", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <h3><i class="fas fa-calculator mr-2"></i>Formule</h3>

    <br>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-3">
          <h5 class="card-header"><a href="#sistemul-circulator"><span class="fa fa-heartbeat mr-2"></span>Sistemul circulator</a></h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#volemia">Volumul sângelui în organism (volemia)</a></li>
            <li class="list-group-item"><a href="#v-h2o-sange">Volumul de apă din sânge</a></li>
            <li class="list-group-item"><a href="#debitul-cardiac">Debitul cardiac</a></li>
            <li class="list-group-item"><a href="#ciclul-cardiac">Ciclul cardiac</a></li>
          </ul>
          <div class="card-footer"></div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card mb-3">
          <h5 class="card-header"><a href="#sistemul-excretor"><span class="fa fa-poop mr-2"></span>Sistemul excretor</h5></a>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#debitul-sangvin-renal">Debitul sangvin renal</a></li>
            <li class="list-group-item"><a href="#cant-h2o-urina">Cantitatea de apă din urină</a></li>
          </ul>
          <div class="card-footer"></div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card mb-3">
          <h5 class="card-header"><a href="#sistemul-respirator"><span class="fa fa-lungs mr-2"></span>Sistemul respirator</a></h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="#capacitatea-vitala">Capacitatea vitală</a></li>
            <li class="list-group-item"><a href="#capacitatea-pulmonara-totala">Capacitatea pulmonară totală</a></li>
            <li class="list-group-item"><a href="#debit-ventilator">Debit ventilator</a></li>
          </ul>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>

    <br>

    <br>

    <div id="sistemul-circulator">
      <h4><span class="fa fa-heartbeat mr-2"></span>Sistemul circulator</a></h4>

      <br>

      <ol>
        <li>
          <div id="volemia">
            <h5>Volumul sângelui în organism (volemia)</h5>

            <p>Reprezintă 8% din greutatea individului.</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpManWeight">Greautatea individului</label>
                  <div class="input-group">
                    <input type="text" id="inpManWeight" class="form-control" oninput="calculateBloodV()" aria-describedby="weightAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="weightAddon">kg</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateBloodV() {
                      var weight = document.getElementById('inpManWeight').value;
                      document.getElementById('viewBloodV').value = 8 / 100 * weight;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewBloodV">Volumul sângelui în organism</label>
                  <div class="input-group">
                    <input type="text" id="viewBloodV" class="form-control" aria-describedby="bloodVAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="bloodVAddon">L</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div id="v-h2o-sange">
            <h5>Volumul de apă din sânge</h5>

            <p>Sângele conține 55% plasmă, care este un lichid gălbui și transparent. Aceasta conține 90% apă și 10% reziduu uscat.</p>
            <p>Restul de 45% din sânge este reprezentat de elementele figurate, care sunt de 3 tipuri: globule roșii, globule albe și trombocite.</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpBloodV">Volumul de sânge</label>
                  <div class="input-group">
                    <input type="text" id="inpBloodV" class="form-control" oninput="calculateH2OV()" aria-describedby="bloodVAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="bloodVAddon">L</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateH2OV() {
                      var bloodV = document.getElementById('inpBloodV').value;
                      document.getElementById('viewH2OV').value = (90 / 100) * (55 / 100 * bloodV);
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewH2OV">Volumul de apă</label>
                  <div class="input-group">
                    <input type="text" id="viewH2OV" class="form-control" aria-describedby="H2OVAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="H2OVAddon">L</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div id="debitul-cardiac">
            <h5>Debitul cardiac</h5>

            <p><i>Debitul cardiac</i> reprezintă volumul de sânge pompat de inimă în 60 de secunde.</p>
            <p><i>Frecvența cardiacă</i> reprezintă numărul de bătai pe minut.</p>
            <p><i>Debitul sistolic</i> reprezintă volumul de sânge expulzat de ventricule la o contracție.</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpFC">Frecvența cardiacă</label>
                  <div class="input-group">
                    <input type="text" id="inpFC" class="form-control" oninput="calculateDC()" aria-describedby="fcAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="fcAddon">bătăi pe minut</span>
                    </div>
                  </div>
                </div>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpDS">Debitul sistolic</label>
                  <div class="input-group">
                    <input type="text" id="inpDS" class="form-control" oninput="calculateDC()" aria-describedby="dsAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="dsAddon">ml</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateDC() {
                      var fc = document.getElementById('inpFC').value;
                      var ds = document.getElementById('inpDS').value;
                      document.getElementById('viewDC').value = fc * ds;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewDC">Volumul de apă</label>
                  <div class="input-group">
                    <input type="text" id="viewDC" class="form-control" aria-describedby="dcAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="dcAddon">ml/minut</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div id="ciclul-cardiac">
            <h5>Ciclul cardiac</h5>

            <p>este notat CC.</p>
            <p><i>S</i> reprezintă sistola sau contracția inimii.</p>
            <p><i>D</i> reprezintă diastola sau relaxarea inimii.</p>
            <p>CC = S + D = 0,4s + 0,4s = 0,8s</p>

            <p><i>Ciclul cardiac</i> presupune:</p>
            <ul>
              <li><p>CA (ciclul atrial) = SA + DA = 0,1s + 0,7s = 0,8s</p></li>
              <li><p>CV (ciclul ventricular) = SV + DV = 0,3s + 0,5s = 0,8s</p></li>
            </ul>
          </div>
        </li>
      </ol>
    </div>

    <br>

    <div id="sistemul-excretor">
      <h4><span class="fa fa-poop mr-2"></span>Sistemul excretor</h4></a>
      <ol>
        <li>
          <div id="debitul-sangvin-renal">
            <h5>Debitul sangvin renal</h5>

            <p>În condiții bazale, <i>debitul sangvin renal</i> reprezintă 20% din debitul cardiac de repaus.</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpDCR">Debitul cardiac de repaus</label>
                  <div class="input-group">
                    <input type="text" id="inpDCR" class="form-control" oninput="calculateDSR()" aria-describedby="DCRAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="DCRAddon">ml/minut</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateDSR() {
                      var dcr = document.getElementById('inpDCR').value;
                      document.getElementById('viewDSR').value = dcr / 5;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewDSR">Debitul sangvin renal</label>
                  <div class="input-group">
                    <input type="text" id="viewDSR" class="form-control" aria-describedby="DSRAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="DSRAddon">ml/min</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div id="cant-h2o-urina">
            <h5>Cantitatea de apă din urină</h5>

            <p>În mod normal, urina conține 95% apă și 5% diverși componenți, printre care se numără și substanțe minerale și substanțe organice.</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpCU">Cantitate urină</label>
                  <div class="input-group">
                    <input type="text" id="inpCU" class="form-control" oninput="calculateH2OU()" aria-describedby="CUAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="CUAddon">ml</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateH2OU() {
                      var cu = document.getElementById('inpCU').value;
                      document.getElementById('viewH2OU').value = 95 / 100 * cu;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewH2OU">Debitul sangvin renal</label>
                  <div class="input-group">
                    <input type="text" id="viewH2OU" class="form-control" aria-describedby="H2OUAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="H2OUAddon">ml</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ol>
    </div>

    <br>

    <div id="sistemul-respirator">
      <h4><span class="fa fa-lungs mr-2"></span>Sistemul respirator</h4>

      <br>

      <ol>
        <li>
          <div id="capacitatea-vitala">
            <h5>Capacitatea vitală</h5>

            <p>este notată CV.</p>
            <p><i>VC (volumul curent)</i> reprezintă volumul de aer introdus și eliminat într-o respirație normală.</p>
            <p><i>VIR (volum inspirator de rezervă)</i> reprezintă volumul de aer introdus suplimentar în plămâni printr-o inspirație forțată doar după o inspirație normală.</p>
            <p><i>VER (volum expirator de rezervă)</i> reprezintă volumul de aer eliminat din plămâni printr-o expirație forțață.</p>

            <p>CV = VC + VIR + VER</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpVC">Volumul curent</label>
                  <div class="input-group">
                    <input type="text" id="inpVC" class="form-control" oninput="calculateCV()" aria-describedby="vcAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="vcAddon">ml</span>
                    </div>
                  </div>
                </div>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpVIR">Volumul inspirator de rezervă</label>
                  <div class="input-group">
                    <input type="text" id="inpVIR" class="form-control" oninput="calculateCV()" aria-describedby="virAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="virAddon">ml</span>
                    </div>
                  </div>
                </div>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpVER">Volumul expirator de rezervă</label>
                  <div class="input-group">
                    <input type="text" id="inpVER" class="form-control" oninput="calculateCV()" aria-describedby="verAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="verAddon">ml</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateCV() {
                      var vc = +document.getElementById('inpVC').value;
                      var vir = +document.getElementById('inpVIR').value;
                      var ver = +document.getElementById('inpVER').value;
                      document.getElementById('viewCV').value = vir + ver + vc;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewCV">Capacitatea vitală</label>
                  <div class="input-group">
                    <input type="text" id="viewCV" class="form-control" aria-describedby="cvAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="cvAddon">ml</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div id="capacitatea-pulmonara-totala">
            <h5>Capacitatea pulmonară totală</h5>

            <p>este notată CPT.</p>
            <p><i>VR (volum rezidual)</i> este volumul de aer care rămâne în plămâni chiar după o expirație forțată.</p>
            <p><i>CV este capacitatea vitală.</i></p>

            <p>CPT = CV + VR</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpCV">Capacitatea vitală</label>
                  <div class="input-group">
                    <input type="text" id="inpCV" class="form-control" oninput="calculateCPT()" aria-describedby="cvAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="cvAddon">ml</span>
                    </div>
                  </div>
                </div>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpVR">Volumul rezidual</label>
                  <div class="input-group">
                    <input type="text" id="inpVR" class="form-control" oninput="calculateCPT()" aria-describedby="vrAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="vrAddon">ml</span>
                    </div>
                  </div>
                </div>
                <script>
                  function calculateCPT() {
                      var cv = +document.getElementById('inpCV').value;
                      var vr = +document.getElementById('inpVR').value;
                      document.getElementById('viewCPT').value = cv + vr;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewCPT">Capacitatea pulmonară totală</label>
                  <div class="input-group">
                    <input type="text" id="viewCPT" class="form-control" aria-describedby="cptAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="cptAddon">ml</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div id="debit-ventilator">
            <h5>Debit ventilator</h5>

            <p>este notat DV.</p>
            <p><i>VC (volumul curent)</i> reprezintă volumul de aer introdus și eliminat într-o respirație normală.</p>
            <p><i>FR (frecvența respiratorie)</i> este la femei 18 respirații/min și la bărbați 16 respirații/min.</p>

            <p>DV = VC * FR</p>

            <div class="card border-secondary mb-3">
              <div class="card-header"><i class="fas fa-calculator mr-2"></i>Calculator</div>
              <div class="card-body">
                <div class="form-group" style="max-width: 30rem;">
                  <label for="inpvc">Volumul curent</label>
                  <div class="input-group">
                    <input type="text" id="inpvc" class="form-control" oninput="calculateDV()" aria-describedby="vcAddon">
                    <div class="input-group-append">
                      <span class="input-group-text" id="vcAddon">ml</span>
                    </div>
                  </div>
                </div>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="selFR">Frecvența respiratorie</label>
                  <select class="form-control" id="selFR" oninput="calculateDV()">
                    <option value="18" selected>Femeie</option>
                    <option value="16">Bărbat</option>
                  </select>
                </div>
                <script>
                  function calculateDV() {
                      var vc = +document.getElementById('inpvc').value;
                      var fr = +document.getElementById('selFR').value;
                      document.getElementById('viewDV').value = vc * fr;
                  }
                </script>
                <div class="form-group" style="max-width: 30rem;">
                  <label for="viewDV">Debit ventilator</label>
                  <div class="input-group">
                    <input type="text" id="viewDV" class="form-control" aria-describedby="dvAddon" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text" id="dvAddon">ml</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ol>
    </div>
  </div>

  <br>

  <?= $view->footer("formulas"); ?>

</body>

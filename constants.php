<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/Config.php';
  require_once 'source/View.php';

  if (!isset($_SESSION['LoggedIn']) || !$_SESSION['LoggedIn'])
      header('Location: log-in.php');

  $view = new View();

  $view->header("constants", "Constante");
?>
</head>

<body>

  <?= $view->navbar("constants", $_SESSION['ID']); ?>

  <br>

  <div class="container">
    <h3><i class="fa fa-square-root-alt mr-2"></i>Constante</h3>

    <br>

    <table class="table table-hover">
      <thead>
        <th scope="col"><span class="fa fa-square-root-alt mr-2"></span>Constantă</th>
        <th scope="col"><span class="fa fa-equals mr-2"></span>Valoare</th>
      </thead>
      <tbody>
        <tr>
            <td>Frecventa cardiacã</td>
            <td>70-75 bãtai/min</td>
        </tr>
        <tr>
            <td>Debitul cardiac de repaus</td>
            <td>5L/min</td>
        </tr>
        <tr>
            <td>Presiunea arterialã maximã</td>
            <td>120 mmHg</td>
        </tr>

        <tr>
            <td>Presiunea arterialã minimã</td>
            <td>80 mmHg</td>
        </tr>

        <tr>
            <td>Numãrul de hematii (femei)</td>
            <td>4,5 milioane/mm<sup>3</sup></td>
        </tr>


        <tr>
            <td>Numãrul de hematii (bãrbati)</td>
            <td>5 milioane/mm<sup>3</sup></td>
        </tr>

        <tr>
            <td>pH-ul sangvin</td>
            <td>7,4</td>
        </tr>

        <tr>
            <td>Timp de coagulare a sângelui (adult)</td>
            <td>3-5 minute</td>
        </tr>

        <tr>
            <td>Timp de coagulare a sângelui (copil)</td>
            <td>8-12 minute</td>
        </tr>

        <tr>
            <td>Debitul sangvin renal</td>
            <td>1200 mL/min (420mL/100g tesut/min)</td>
        </tr>

        <tr>
            <td>Presiunea din capilarele glomerulare</td>
            <td>60 mmHg</td>
        </tr>

        <tr>
            <td>Presiunea din capsula Bowman</td>
            <td>18 mmHg</td>
        </tr>

        <tr>
            <td>Presiunea coloid-osmoticã a proteinelor din capsula Bowman</td>
            <td>0 mmHg</td>
        </tr>

        <tr>
            <td>Volumul curent</td>
            <td>500 mL</td>
        </tr>

        <tr>
            <td>Volumul inspirator de rezervã</td>
            <td>1500 mL</td>
        </tr>

        <tr>
            <td>Volumul expirator de rezervã</td>
            <td>1500 mL</td>
        </tr>

        <tr>
            <td>Volumul rezidual</td>
            <td>1500 mL</td>
        </tr>

        <tr>
            <td>Acetonã, albuminaã glucozã din urinã</td>
            <td>absente</td>
        </tr>

        <tr>
            <td>Ureea din urinã</td>
            <td>15-35 g/zi</td>
        </tr>

        <tr>
            <td>Magneziul din urinã</td>
            <td>100-200 mg/zi</td>
        </tr>

        <tr>
            <td>Calciul din urinã</td>
            <td>150-250 mg/zi</td>
        </tr>

        <tr>
            <td>Clorul din urinã</td>
            <td>6-9 g/zi</td>
        </tr>

        <tr>
            <td>Potasiul din urinã</td>
            <td>2-3 g/zi</td>
        </tr>

        <tr>
            <td>pH-ul din urinã</td>
            <td>5-7</td>
        </tr>
      </tbody>
    </table>
  </div>

  <br>

  <?= $view->footer("constants"); ?>

</body>

<!DOCTYPE html>
<html>

<head>
<?php

  session_start();

  require_once 'source/Config.php';
  require_once 'source/View.php';

  $view = new View();

  $view->header("about-us", "Despre noi");

?>
</head>

<body>

  <?= $view->navbar("about-us"); ?>

  <br>

  <div class="container">
    <h1>Despre proiect</h1>

    <ul>
      <li><p><?= PROJECT_NAME ?> a fost lansat pe 1 mai 2020 reușind în scurt timp să atragă peste 600 de utilizatori.</p></li>
      <li><p>înregistrarea cât și utilizarea platformei este gratuită și așa va rămâne.</p></li>
      <li><p>prin funcționalitățile dezvoltate încercăm să facem învățatul mai distractiv prin promovarea competiției.</p></li>
    </ul>

    <br>

    <h4>Apariții în presă</h4>

    <ul>
      <li>
        <p>
          <a href="https://ziare.com/scoala/bacalaureat/doi-liceeni-au-creat-o-platforma-gratuita-dedicata-celor-care-dau-bacalaureatul-la-biologie-1609837" target="_blank">
            Doi liceeni au creat o platforma gratuita dedicata celor care dau Bacalaureatul la Biologie
          </a>
        </p>
      </li>
      <li>
        <p>
          <a href="https://start-up.ro/bacalaureat-biologie-doi-elevi-din-barlad-au-facut-un-site-de-pregatire-online/" target="_blank">
            Bacalaureat Biologie: doi elevi din Bârlad au făcut un site de pregătire online
          </a>
        </p>
      </li>
    </ul>

    <br>

    <h4>Reușite</h4>

    <ul>
      <li><p>locul 2 la InfoEducație 2020, faza Online, secțiunea Educațional.</p></li>
      <li>more soon..</li>
    </ul>

    <br>

    <h4>Echipă</h4>

    <ul>
      <li><p><a href="https://www.facebook.com/tud777r/" target="_blank">Tudor Micu</a></p></li>
      <li><p><a href="https://www.facebook.com/adrian.gherghescu.14" target="_blank">Andrei Gherghescu</a></p></li>
    </ul>

  </div>

  <br>

  <?= $view->footer("about-us"); ?>

</body>

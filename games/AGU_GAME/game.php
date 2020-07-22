<h4 class="text-center" id="productHeader"></h4>

<br>

<div class="row">
  <div class="col-lg-6">
    <div class="card mb-3">
      <img id="answerAImg" class="mx-auto" style="height: 320px; width: 164px; display: block;" src="" alt="AnswerA">
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn-success btn-block" onclick="answer(0)">A</a>
      </div>
    </div>
    <div class="card mb-3">
      <img id="answerCImg" class="mx-auto" style="height: 320px; width: 164px; display: block;" src="" alt="AnswerC">
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn-success btn-block" onclick="answer(2)">C</a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card mb-3">
      <img id="answerBImg" class="mx-auto" style="height: 320px; width: 164px; display: block;" src="" alt="AnswerB">
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn-success btn-block" onclick="answer(1)">B</a>
      </div>
    </div>
    <div class="card mb-3">
      <img id="answerDImg" class="mx-auto" style="height: 320px; width: 164px; display: block;" src="" alt="AnswerD">
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn btn-success btn-block" onclick="answer(3)">D</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="games/AGU_GAME/data.js"></script>
<script type="text/javascript" src="js/utils.js"></script>

<script>
  function generateLevel()
  {
      product = Math.floor(Math.random() * products.length);
      shuffle(tastes);

      for (var i = 0; i < 4; i ++)
          if (tastes[i][0] == products[product][1])
             rightAnswer = i;

      viewLevel();
  }

  function viewLevel()
  {
      document.getElementById('productHeader').innerHTML = products[product][0];

      document.getElementById('answerAImg').src = tastes[0][1];
      document.getElementById('answerBImg').src = tastes[1][1];
      document.getElementById('answerCImg').src = tastes[2][1];
      document.getElementById('answerDImg').src = tastes[3][1];
  }

</script>

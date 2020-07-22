<h4 class="text-center" id="animalHeader"></h4>

<br>

<div class="row">
  <div class="col-lg-6">
    <div class="card mb-3">
      <ul class="list-group list-group-flush">
        <li id="answerARegn" class="list-group-item"></li>
        <li id="answerAClasa" class="list-group-item"></li>
        <li id="answerAZona" class="list-group-item"></li>
        <li id="answerAViata" class="list-group-item"></li>
        <li id="answerAHrana" class="list-group-item"></li>
      </ul>
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn-success btn-block" onclick="answer(0)">A</a>
      </div>
    </div>
    <div class="card mb-3">
      <ul class="list-group list-group-flush">
        <li id="answerCRegn" class="list-group-item"></li>
        <li id="answerCClasa" class="list-group-item"></li>
        <li id="answerCZona" class="list-group-item"></li>
        <li id="answerCViata" class="list-group-item"></li>
        <li id="answerCHrana" class="list-group-item"></li>
      </ul>
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn-success btn-block" onclick="answer(2)">C</a>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card mb-3">
      <ul class="list-group list-group-flush">
        <li id="answerBRegn" class="list-group-item"></li>
        <li id="answerBClasa" class="list-group-item"></li>
        <li id="answerBZona" class="list-group-item"></li>
        <li id="answerBViata" class="list-group-item"></li>
        <li id="answerBHrana" class="list-group-item"></li>
      </ul>
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn-success btn-block" onclick="answer(1)">B</a>
      </div>
    </div>
    <div class="card mb-3">
      <ul class="list-group list-group-flush">
        <li id="answerDRegn" class="list-group-item"></li>
        <li id="answerDClasa" class="list-group-item"></li>
        <li id="answerDZona" class="list-group-item"></li>
        <li id="answerDViata" class="list-group-item"></li>
        <li id="answerDHrana" class="list-group-item"></li>
      </ul>
      <div class="card-body">
        <a href="#siteNavbar" class="card-link btn btn btn-success btn-block" onclick="answer(3)">D</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="games/BVA_GAME/data.js"></script>
<script type="text/javascript" src="js/utils.js"></script>

<script>
  var options = [];

  function is_unique(poz)
  {
      for (var i = 0; i < poz; i ++)
          if (options[i] == options[poz])
              return false;

      return true;
  }

  function generateLevel()
  {
      options[0] = animal = Math.floor(Math.random() * animals.length);

      do {
        options[1] = Math.floor(Math.random() * animals.length);
      } while(!is_unique(1));

      do {
        options[2] = Math.floor(Math.random() * animals.length);
      } while(!is_unique(2));

      do {
        options[3] = Math.floor(Math.random() * animals.length);
      } while(!is_unique(3));

      shuffle(options);

      for (var i = 0; i < 4; i ++)
          if (options[i] == animal)
             rightAnswer = i;

      viewLevel();
  }

  function viewLevel()
  {
      document.getElementById('animalHeader').innerHTML = animals[animal][0];

      document.getElementById('answerARegn').innerHTML = '<span class="fa fa-paw mr-2"></span>' + animals[options[0]][REGN];
      document.getElementById('answerAClasa').innerHTML = '<span class="fa fa-users mr-2"></span>' + animals[options[0]][CLASA];
      document.getElementById('answerAZona').innerHTML = '<span class="fa fa-map-marked-alt mr-2"></span>' + animals[options[0]][ZONA];
      document.getElementById('answerAViata').innerHTML = '<span class="fa fa-heartbeat mr-2"></span>' + animals[options[0]][VIATA];
      document.getElementById('answerAHrana').innerHTML = '<span class="fa fa-utensils mr-2"></span>' + animals[options[0]][HRANA];

      document.getElementById('answerBRegn').innerHTML = '<span class="fa fa-paw mr-2"></span>' + animals[options[1]][REGN];
      document.getElementById('answerBClasa').innerHTML = '<span class="fa fa-users mr-2"></span>' + animals[options[1]][CLASA];
      document.getElementById('answerBZona').innerHTML = '<span class="fa fa-map-marked-alt mr-2"></span>' + animals[options[1]][ZONA];
      document.getElementById('answerBViata').innerHTML = '<span class="fa fa-heartbeat mr-2"></span>' + animals[options[1]][VIATA];
      document.getElementById('answerBHrana').innerHTML = '<span class="fa fa-utensils mr-2"></span>' + animals[options[1]][HRANA];

      document.getElementById('answerCRegn').innerHTML = '<span class="fa fa-paw mr-2"></span>' + animals[options[2]][REGN];
      document.getElementById('answerCClasa').innerHTML = '<span class="fa fa-users mr-2"></span>' + animals[options[2]][CLASA];
      document.getElementById('answerCZona').innerHTML = '<span class="fa fa-map-marked-alt mr-2"></span>' + animals[options[2]][ZONA];
      document.getElementById('answerCViata').innerHTML = '<span class="fa fa-heartbeat mr-2"></span>' + animals[options[2]][VIATA];
      document.getElementById('answerCHrana').innerHTML = '<span class="fa fa-utensils mr-2"></span>' + animals[options[2]][HRANA];

      document.getElementById('answerDRegn').innerHTML = '<span class="fa fa-paw mr-2"></span>' + animals[options[3]][REGN];
      document.getElementById('answerDClasa').innerHTML = '<span class="fa fa-users mr-2"></span>' + animals[options[3]][CLASA];
      document.getElementById('answerDZona').innerHTML = '<span class="fa fa-map-marked-alt mr-2"></span>' + animals[options[3]][ZONA];
      document.getElementById('answerDViata').innerHTML = '<span class="fa fa-heartbeat mr-2"></span>' + animals[options[3]][VIATA];
      document.getElementById('answerDHrana').innerHTML = '<span class="fa fa-utensils mr-2"></span>' + animals[options[3]][HRANA];
  }

</script>

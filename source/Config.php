<?php

  # Project's info
  define("PROJECT_NAME", "biologie-pe.net");
  define("STATUS", "DEV");

  define("LEVEL_POINT", "1200");

  # MySQL Database
  if (STATUS == "DEV")
  {
      define('DB_HOST', 'localhost');
      define('DB_USER', 'root');
      define('DB_PASS', '');
      define('DB_NAME', 'lectiibiologie');
  }
  else
  {
      define('DB_HOST', '188.241.222.252');
      define('DB_USER', 'inorogo1_user');
      define('DB_PASS', 'TXK1{.*iIAYP');
      define('DB_NAME', 'inorogo1_infoed');
  }

?>

<?php

  include('config.php');
  include('classes/database.php');

  $conection = new Conection(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);

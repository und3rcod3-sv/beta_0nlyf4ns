<?php

  include('config.php');
  include('classes/database.php');

  $conection = new Conection(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
  $conection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

  $tabla_users = "CREATE TABLE `users`(
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nickname` VARCHAR(50) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

  if (!$conection->consulta('SELECT * FROM `users`')) {
    $conection->consulta($tabla_users);
  }
  

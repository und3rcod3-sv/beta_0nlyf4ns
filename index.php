<?php

    // Agregar variables globales al inicio de cada archivo, "SI SE UTILIZAN"
    global $conection;

    // Agregar todo lo importante por aqui
    require('./core/conection.php');

    var_dump($conection->query('SELECT * FROM USERS'));

    // EJEMPLO DE COMO CREAR DATOS POR EL MOMENTO

    $sql = 'SELECT `nickname` from `users` WHERE `nickname` = "crisanto"';
    $user = $conection->filas($sql);

    if ($user === 0) {
      $array = [
        'nickname' => 'crisanto',
        'email' => 'crisanto@example.com',
        'password' => password_hash('password', PASSWORD_DEFAULT)
      ];
      $table = 'users';

      $conection->insertar($table, $array);
    } else {

      var_dump($conection->asociativo($sql));
    }

    $template = "home";
    $theme = 'default';

    // Add template
    include('./template/' . $theme . '/' . $template . '.php');

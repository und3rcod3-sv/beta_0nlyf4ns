<?php

    // Agregar todo lo importante por aqui
    require('./core/conection.php');


    $template = "home";
    $theme = 'default';

    // Add template
    include('./template/' . $theme . '/' . $template . '.php');

<?php

  /**
   *
   */
  class Conection extends PDO
  {
    public $con;

    function __construct($db_host, $db_name, $db_user, $db_password)
    {
      $dns = sprintf('mysql:dbname=%s;host=%s', $db_name, $db_host);
      $this->con = parent::__construct($dns, $db_user, $db_password);
    }
  }

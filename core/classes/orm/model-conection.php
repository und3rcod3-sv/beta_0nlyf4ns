<?php

  /**
   *
   */
  class ModelConection extends PDO
  {

    function __construct()
    {
      $dns = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);
      try {
        parent::__construct($dns, DB_USER, DB_PASSWORD);
      } catch (PDOException $e) {
        die($e);
      }
    }
  }

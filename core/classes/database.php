<?php
  /**
   *  Aun me falta terminar, hay muchas cosas que por el momento pensare como solucionar.
   */
  class Conection extends PDO
  {
    // private $con;
    function __construct($db_host, $db_name, $db_user, $db_password)
    {
      $dns = sprintf('mysql:host=%s;dbname=%s', $db_host, $db_name);
      try {
        parent::__construct($dns, $db_user, $db_password);
      } catch (PDOException $e) {
        $error = sprintf('<b>Error: $s </b><br/>', $e->getMessage());
        die($error);
      }
    }

    /**
    *
    * @param $string, contiene una consulta normal
    * @return PDOStatement, devuelve falso en caso de error.
    */
    public function consulta($sql)
    {
      $sql = htmlentities(addslashes($sql));
      return $this->query($sql);
    }

    /**
    *
    * @param { $tabla: hace referencia a la tabla de la base de datos, $array: [ columna => $valor, ... ]}
    * @return bool
    */
    public function insertar($tabla,$array){
      $m = 0;

      foreach ($array as $key => $value) {
        $llaves[$m] = trim($key);
        $llaves2[$m] = ":" . trim($key);
        $valores[$m] = trim($value);
        $m++;
      }

      $sentencia = $this->prepare("INSERT IGNORE INTO ".$tabla." (".implode(',',$llaves).") VALUES (".implode(',',$llaves2).")");
      $n=0;

      foreach ($array as $key => $value) {
        @$sentencia->bindParam(trim($llaves2[$n]),trim(array_merge($valores)[$n]));
        $n++;
      }
      $result = $sentencia->execute();
      return $result;
    }

    /**
    *
    * @param { $tabla: hace referencia a la tabla de la base de datos, $array: [ columna => $valor, ... ], $id: ID del dato}
    * @return bool
    */
    public function actualizar($tabla,$array,$id){

      $m = 0;

      foreach ($array as $key => $value) {
        $llaves[$m] = trim($key);
        $llaves2[$m] = ":" . trim($key);
        $valores[$m] = trim($value);
        $update[$m] = trim($key)."=:".trim($key);
        $m++;

      }

      $sql = "UPDATE  " . $tabla . " SET ".implode(',',$update)." WHERE id=:id";
      $sentencia = $this->prepare($sql);
      $n=0;
      foreach ($array as $key => $value) {
        @$sentencia->bindParam(trim($llaves2[$n]),trim(array_merge($valores)[$n]));
        $n++;
      }
      $sentencia->bindParam(":id",$id);
      $result = $sentencia->execute();
      return $result;
    }

    /**
    * NO OLVIDAD EL ID
    * @param { $tabla: hace referencia a la tabla de la base de datos, $array: [ columna => $valor, ... ], $id: ID del dato}
    * @return bool
    */
    public function borrar($tabla,$id){

    }

    /**
    *
    * @param $sql, consulta normal
    * @return int numero de filas
    */
    public function filas($sql){
      $con = $this->prepare($sql);
      $con->execute();
      return $con->rowCount();
    }

    /**
    *
    * @param $sql, consulta normal
    * @return array los datos encontrados
    */
    public function asociativo($sql){
      $con = $this->prepare($sql);
      $con->execute();
      return $con->fetch(PDO::FETCH_ASSOC);
    }

    /**
    *
    * @param $sql, consulta normal
    * @return matriz de datos
    */
    public function asociativo_total($sql){
      $con = $this->prepare($sql);
      $con->execute();
      return $con->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    *
    * @param $consulta, consulta normal
    * @return
    */
    public function consulta_preparada($consulta){
      $sql = $this->prepare($consulta);
      return $sql->execute();
    }

  }

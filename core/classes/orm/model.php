<?php

  include 'model-conection.php';
  /**
   *
   */
  class Model extends ModelConection
  {
    public $table;
    public $sql;
    public $select, $delete, $update;
    public $bind_value = array();

    function __construct($table)
    {
      $this->table = $table;
      parent::__construct();
    }

    /**
    *
    * @param void
    * @return PDOStatement
    */
    public function query()
    {
      if (count($this->bind_value) > 0) {
        $stm = $this->prepare($this->sql);
        foreach ($this->bind_value as $key => $value) {
          $stm->bindValue(sprintf(':%s', $key), $value);
        }
        $stm->execute();
        return $stm;
      } else{
        return parent::query($this->sql());
      }

    }

    /**
    * Escape SQL sentence
    * @param void
    * @return void
    */
    public function sql()
    {
      $this->sql = htmlentities(addslashes($this->sql));
      return;
    }

    /**
    * Selecciona todo de la tabla
    * @param void
    * @return PDOStatement
    */
    public function all()
    {
      $this->sql = sprintf('SELECT * FROM `%s`', $this->table);
      return $this->query();
    }

    /**
    * Selecciona ciertas columnas de una tabla
    * @param $item = array ('column1', 'column2', 'column3', ...)
    * @return
    */
    public function select($item = array())
    {
      $item = implode(',', $this->backtick($item));
      $this->sql = sprintf('SELECT %s FROM `%s`', $item, $this->table);
      return $this;
    }

    /**
    *
    * @param { $column: columna de la tabla, $separator: =, <>, <, >}
    * @return $this
    */
    public function where($column, $value, $separator = "")
    {
      if (empty($separator)) {
        $separator = '=';
      }
      if (!empty($this->bind_value)) {
        $where = sprintf(' `%s` %s :%s', $column, $separator, $column);
      } else {
        $where = sprintf(' WHERE `%s` %s :%s', $column, $separator, $column);
      }
      $this->sql = $this->sql . $where;
      $this->bind_value[$column] = $value;
      return $this;
    }

    public function and()
    {
      $this->sql = $this->sql . ' AND';
      return $this;
    }

    public function or()
    {
      $this->sql = $this->sql . ' OR';
      return $this;
    }


    /**
    *
    * @param $items = array('column' => 'value')
    * @return
    */
    public function insert($items = array())
    {
      $columns = [];
      $values = [];
      foreach ($items as $key => $value) {
        array_push($columns, $this->backtick($key));
        array_push($values, sprintf(':%s', $key));
        $this->bind_value[$key] = $value;
      }
      // $this->bind_value = $items;
      $this->sql = sprintf('INSERT INTO `%s` (%s) VALUES (%s)', $this->table, implode(', ', $columns), implode(', ', $values));
      return $this;
    }

    /**
    * De momento solo pasar id a este metodo
    * @param $where integer
    * @return
    */
    public function delete($where)
    {
      if (is_numeric($where)) {
        $this->bind_value['id'] = $where;
        $this->sql = sprintf('DELETE FROM `%s` WHERE `id` = :id', $this->table);
        return $this;
      }
    }

    /**
    * De momento solo actualizar pasando id en el parametro where
    * @param $items = array('column', 'value') $where = integer
    * @return bool
    */
    public function update($items = array(), $where)
    {
      if (is_array($items) && count($items) > 0 && is_numeric($where)) {
        $set = [];
        $values = [];
        foreach ($items as $key => $value) {
          array_push($set, sprintf('%s = ?', $key));
          array_push($values, $value);
        }
        $this->sql = sprintf('UPDATE `%s` SET %s WHERE `id` = ?', $this->table, implode(';', $set));
        $stm = $this->prepare($this->sql);
        return $stm->execute(array_merge($values,[$where]));
      }
    }

    /**
    * Agrega comilla invertidas a un dato string
    * @param String||Array
    * @return String||Array
    */
    public function backtick($data)
    {
      if (is_array($data)) {
        foreach ($data as $key => $value) {
          $data[$key] = sprintf('`%s`', $value);
        }
      } else {
        $data = sprintf('`%s`', $data);
      }
      return $data;
    }



  }

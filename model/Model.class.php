<?php
  class Model extends MyObject {
    protected static $sql_querries=array();

    private function __construct() { }

    public static function addSQLquerry($key, $value){
      static::$sql_querries[$key]=$value;
    }


  }
 ?>

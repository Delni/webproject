<?php
  class Model extends MyObject {
    protected static $sql_querries=array();

    private function __construct() { }

    public static function addSQLquerry($key, $value){
      static::$sql_querries[$key]=$value;
    }

    public static function exec_sql($sql_querry,$params){
      $sql_req=DatabasePDO::getCurrentPDO()->prepare(static::$sql_querries[$sql_querry]);
      $sql_req->execute($params);
      return $sql_req->fetch(DatabasePDO::FETCH_OBJ);
    }


  }
 ?>

<?php
  class DatabasePDO extends PDO {
    protected static $uniqueInstance = NULL;
    protected static $dbname = '6nimmt';
    protected static $user = 'root';
    protected static $pass = 'root';

    // Singleton design pattern
    public static function getCurrentPDO(){
        if(is_null(self::$uniqueInstance)){
          try {
            static::$uniqueInstance = new PDO('mysql:host=localhost;dbname='.static::$dbname, static::$user, static::$pass);
          } catch (Exception $e) {
            die('Error while connecting to MySQL.');
          }
        }
        return static::$uniqueInstance;
    }
  }
 ?>

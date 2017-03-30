<?php
  class DatabasePDO extends PDO {

    /**
    *   Extension of PHP's PDO class, allowing the application of a singleton pattern
    *
    *   Variables :
    *     @uniqueInstance     (object DatabasePDO)    -> for the singleton pattern
    *     @dbname             (string)                -> configure the PDO statment connection
    *     @user               (string)                -> configure the PDO statment connection
    *     @pass               (string)                -> configure the PDO statment connection
    *
    **/


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

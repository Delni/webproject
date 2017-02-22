<?php
  class Request extends MyObject {
    protected static $uniqueInstance = NULL;

    // Construct with Singleton design pattern
    private function __construct() {}

    public static function getCurrentRequest(){
        if(is_null(self::$uniqueInstance)){
          static::$uniqueInstance = new static();
        }
        return static::$uniqueInstance;
    }

    public function getControllerName(){
      if(isset($_GET['controller'])){
        return $_GET['controller'];
      } elseif (isset($_POST['controller'])){
        return $_POST['controller'];
      } else {
        return 'Anonymous';
      }
    }

    public function getActionName(){
      if(isset($_GET['action'])){
        return $_GET['action'];
      } elseif (isset($_POST['action'])){
        return $_POST['action'];
      } else {
        return 'defaultAction';
      }
    }
  }

// $__REQUEST = new Request();

?>

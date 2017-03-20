<?php
  class Dispatcher extends MyObject {
    protected static $uniqueInstance = NULL;

    public static function getCurrentDispatcher(){
      if(is_null(self::$uniqueInstance)){
        static::$uniqueInstance = new static();
      }
      return static::$uniqueInstance;
    }

    public static function dispatch($request){
      if($request->getControllerName()=='Anonymous'){
        if(isset($_SESSION['user'])){
          $request->write('controller','User');
        }
      }

      $controllerName = $request->getControllerName();
      $controllerClass = ucfirst($controllerName) . 'Controller';

      if($controllerClass == 'UserController'){
        if(!isset($_SESSION['user'])){
          $controllerClass == 'AnonymousController';
        }
      }

      if(!class_exists($controllerClass))
        throw new Exception("$controllerName does not exist");
      return new $controllerClass($request);
    }
  }
 ?>

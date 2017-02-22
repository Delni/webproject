<?php
  class Dispatcher extends MyObject {

    public function __construct() { }

    public static function dispatch($request){
      $controller = $request->getControllerName();
      $controllerClass = ucfirst($controller) . 'Controller';
      if(!class_exists($controllerClass))
        throw new Exception("$controller does not exist");
      return new $controllerClass($request);
    }
  }
 ?>

<?php
  class View extends MyObject {
    protected $controller;
    protected $args=array();

    public function __construct($controller) {
      $this->controller = $controller;
    }

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public static function setArg($key,$value){
      $args[$key] = $value;
    }
  }
 ?>

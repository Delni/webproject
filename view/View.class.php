<?php
  class View extends MyObject {
    protected $user;
    protected $controller;
    protected $args=array();

    public function __construct($controller) {
      if(isset($_SESSION['user']))
        $this->user = unserialize($_SESSION['user']);
      $this->controller = $controller;
    }

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function setArg($key,$value){
      $this->args[$key] = $value;
    }
  }
 ?>

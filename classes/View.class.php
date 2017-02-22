<?php
  class View extends MyObject {
    private $controller;

    public function __construct($controller) {
      $this->controller = $controller;
    }

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }
  }
 ?>

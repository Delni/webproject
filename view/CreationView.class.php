<?php
  class CreationView extends View{
    protected $user;

    public function render($controller){
      $this->user = unserialize($_SESSION['user']);
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/createTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }
  }
 ?>

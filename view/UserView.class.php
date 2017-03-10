<?php
  class UserView extends View {
    protected $user;

    public function render($controller){
      $this->user = new User('tmp');
      $this->user = $_SESSION['user'];
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/userTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function get_flag(){
      $flag=$this->user->getX('PAYS');
      echo "<img src=\"css/img/flags/flags_iso/24/".$flag.".png\" alt=\"".$flag."\">";
    }
  }
 ?>

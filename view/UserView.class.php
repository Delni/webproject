<?php
  class UserView extends View {

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/userTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function get_flag(){
      $flag=$this->user->getX('PAYS');
      if($flag=="easter-egg"){
        echo '<img src="css/img/parrot.gif" alt="Yolo">
              <audio id="nyan" autoplay loop>
                <source src="css/sounds/star.mp3" type="audio/mpeg">
              </audio>
              <script type="text/javascript">
                var vid = document.getElementById("nyan");
                vid.volume = 0.42;
              </script>';
      } else {
        echo "<img src=\"css/img/flags/flags_iso/24/".$flag.".png\" alt=\"".$flag."\">";
      }
    }
  }
 ?>

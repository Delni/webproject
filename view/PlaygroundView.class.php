<?php
  class PlaygroundView extends View {

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/PlaygroundTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function print_log(){
      $i=0;
      while(isset($this->args['log'.$i])){
        echo $this->args['log'.$i];
        $i++;
      }
    }
  }
 ?>

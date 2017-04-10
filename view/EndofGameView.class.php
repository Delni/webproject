<?php
  class EndofGameView extends View {

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/winningTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function showFinalScores(){
      echo $this->args['winning_table'];
    }
  }
?>

<?php
  class GameListView extends View{

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/gameListTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }
  }
 ?>

<?php
  class ConnectionView extends View {

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/connectionTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }
  }
 ?>

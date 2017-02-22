<?php
  class AnonymousController extends Controller {

    public function defaultAction($args) {
      $view = new AnonymousView($this);
      $view->render($this);
    }

    public function inscription(){
      $view = new InscriptionView($this);
      $view->render($this);
    }
  }
?>

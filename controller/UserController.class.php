<?php
  class UserController extends Controller {

    public function defaultAction($request) {
      $view = new UserView($this);
      $view->render($this);
    }

    public function get_user(){
      return $this->user;
    }

    public function editProfile($request){
      echo "Edite ".unserialize($_SESSION['user'])->get_id();
    }

    public function logout($request){
      SessionStop();
      header('Location: index.php');
    }
  }

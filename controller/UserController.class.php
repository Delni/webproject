<?php
  class UserController extends Controller {
    protected $user;

    public function defaultAction($request) {
      $view = new UserView($this);
      $view->render($this);
    }

    public function get_user(){
      return $this->user;
    }

    public function editProfile($request){
      echo "Edite ".$this->user->get_id();
    }

    public function logout($request){
      SessionStop();
      header('Location: index.php');
    }
  }

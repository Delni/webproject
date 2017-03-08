<?php
  class UserController extends Controller {
    protected $user;

    public function defaultAction($request) {
      $this->user=new User($request->read('user'));
      $view = new UserView($this);
      $view->render($this);
    }

    public function get_user(){
      return $this->user;
    }
  }
 ?>

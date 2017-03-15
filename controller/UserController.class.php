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
      $view = new EditeView($this);
      $view->render($this);
    }

    public function logout($request){
      SessionStop();
      header('Location: index.php');
    }

    public function creation($request){
      $view = new CreationView($this);
      $view->render($this);
    }

    public function totalWipeOut($reques){
      $sql_req="DELETE FROM `joueur` WHERE `joueur`.`Pseudo` = '". unserialize($_SESSION['user'])->get_id() ."'";
      DatabasePDO::getCurrentPDO()->query($sql_req);
      SessionStop();
      header('Location: index.php');
    }
  }

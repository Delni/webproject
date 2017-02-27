<?php
  class AnonymousController extends Controller {

    public function __construct($request) {
      parent::__construct($request);
      if(isset($_POST["inscLogin"])){
        //$this->validateInscription($request);
      }
    }

    public function defaultAction($args) {
      $view = new AnonymousView($this);
      $view->render($this);
    }

    public function inscription(){
      $view = new InscriptionView($this);
      $view->render($this);
    }

    public function validateInscription($args) {
      $login = $args->read('inscLogin');
      if(User::isLoginUsed($login)) {
        $view = new View($this,'inscription');
        $view->setArg('inscErrorText','This login is already used');
        $view->render();
      } else {
        $password = $args->read('inscPassword');
        $nom = $args->read('nom');
        $prenom = $args->read('prenom');
        $mail = $args->read('mail');
        $user = User::create($login, $password,$mail,$nom,$prenom);
        if(!isset($user)) {
          $view = new View($this,'inscription');
          $view->setArg('inscErrorText', 'Cannot complete inscription');
          $view->render();
        } else {
          $newRequest = new Request();
          $newRequest->write('controller','user');
          $newRequest->write('user',$user->id());
          Dispatcher::getCurrentDispatcher()->dispatch($newRequest);
        }
      }
    }
  }
?>

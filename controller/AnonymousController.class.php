<?php
  class AnonymousController extends Controller {

    public function __construct($request) {
      parent::__construct($request);

    }

    public function execute() {
      if(isset($_POST["inscLogin"])){
         $this->validateInscription($this->local_request);
      } else {
          parent::execute();
      }
    }

    public function defaultAction($request) {
      $view = new AnonymousView($this);
      $view->render($this);
    }

    public function inscription($request){
      $view = new InscriptionView($this);
      $view->render($this);
    }

    public function validateInscription($args) {
      $login = $args->read('inscLogin');
      if(User::isLoginUsed($login)) {
        $view = new View($this,'inscription');
        $view->setArg('inscErrorText','This login is already used');
        $view->render($this);
      } else {
        $password = $args->read('inscPassword');
        $nom = $args->read('inscName');
        $prenom = $args->read('inscFirstName');
        $mail = $args->read('inscMail');
        $user = User::create($login, $password,$mail,$nom,$prenom);
        if(!isset($user)) {
          $view = new View($this,'inscription');
          $view->setArg('inscErrorText', 'Cannot complete inscription');
          $view->render($this);
        } else {
          $newRequest = new Request();
          $newRequest->write('controller','user');
          $newRequest->write('user',$user->id());
          $contoller = Dispatcher::getCurrentDispatcher()->dispatch($newRequest);
          $contoller->execute();
        }
      }
    }
  }
?>

<?php
  class AnonymousController extends Controller {

    public function __construct($request) {
      parent::__construct($request);

    }

    public function execute() {
      if(isset($_POST["inscLogin"])){
         $this->validateInscription($this->local_request);
      } elseif (isset($_POST["conLogin"])) {
        $this->validateConnection($this->local_request);
      } elseif (isset($_POST["recoPsw"])) {
        $this->validateRecovery($this->local_request);
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

    public function connection($request){
      $view = new ConnectionView($this);
      $view->render($this);
    }

    public function getIDsBack($request){
      $view = new RecoverView($request);
      $view->render($this);
    }

    public function validateInscription($args) {
      $login = $args->read('inscLogin');
      if(User::isLoginUsed($login)) {
        $view = new InscriptionView($this);
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
          SessionStart();
          $_SESSION['user']=serialize($user);
          $newRequest = new Request();
          $newRequest->write('controller','user');
          $newRequest->write('user',$user->get_id());
          $contoller = Dispatcher::getCurrentDispatcher()->dispatch($newRequest);
          $contoller->execute();
        }
      }
    }

    public function validateConnection($args) {
      $login = $args->read('conLogin');
      $password= $args->read('conPassword');
      if(User::isLoginUsed($login)){
        // That means that the login exist in the table.
        $user= new User($login);
        //$user->set_id($login);
        if($user->getX('MDP')==$password){
          SessionStart();
          $_SESSION['user']=serialize($user);
          $newRequest = new Request();
          $newRequest->write('controller','user');
          $newRequest->write('user',$user->get_id());
          $contoller = Dispatcher::getCurrentDispatcher()->dispatch($newRequest);
          $contoller->execute();
        } else {
          $view = new ConnectionView($this);
          $view->setArg('conErrorText','Your login and your password didn\'t match.');
          $view->render($this);
        }
      } else {
        $view = new ConnectionView($this);
        $view->setArg('conErrorText','Unknown login');
        $view->render($this);
      }
    }

    public function mdpGenerator(){
      $res = "";
      $aleat1=0;
      $aleat2=0;
      for ($i=0;$i<7;$i++){
        $aleat1 = rand(0,2);
        if($aleat1 ==0){
          $aleat2= rand(0,9);
          $res=$res.$aleat2;
        }
        if($aleat1==1){
          $aleat2=rand(65,90);
          $res=$res.chr($aleat2);
        }
        if($aleat1==2){
          $aleat2=rand(97,122);
          $res=$res.chr($aleat2);
        }
      }
      return ($res);
    }

    public function validateRecovery($args){
      $email=$args->read('recoPsw');
      if(User::eMailexist($email)){
        //TODO: send a e-mail
        $view = new ConnectionView($this);
        $view->setArg('RecoverText','Un e-mail avec vos identifiants a été envoyé !');
        $view->render($this);
      } else {
        $view = new ConnectionView($this);
        $view->setArg('conErrorText','E-mail inconnu');
        $view->render($this);
      }
    }
  }
?>

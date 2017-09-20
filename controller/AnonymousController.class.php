<?php
  class AnonymousController extends Controller {

    /**
    *
    *   The Default Controller. Only to create a count or connect
    *
    *   Functions:
    *     @execute                (void)      -> Define the action to execute depending on the $_POST Variable
    *     @defaultAction          (void)      -> Render the default view
    *     @inscription            (void)      -> Render the inscription view
    *     @inscription            (void)      -> Render the inscription view
    *     @getIDsBack             (void)      -> Render the recovery view
    *     @validateInscription    (void)      -> Handle the inscription. If correct, start a UserController, if not display errors messages.
    *     @validateConnection     (void)      -> Handle the connection. If correct, start a UserController, if not display errors messages.
    *     @validateRecovery       (void)      -> Handle the recovery. If correct, send a mail and reset password, if not display errors messages.
    *     @mdpGenerator           (string)    -> Create a new random password (numbers+letters)
    *
    *
    **/

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
      }
      else {
        $password = $args->read('inscPassword');
        $nom = $args->read('inscName');
        $prenom = $args->read('inscFirstName');
        $mail = $args->read('inscMail');
        $user = User::create($login, $password,$mail,$nom,$prenom);
        $this->creationMailing($login, $mail);
        if(!isset($user)) {
          $view = new View($this,'inscription');
          $view->setArg('inscErrorText', 'Cannot complete inscription');
          $view->render($this);
        }
        else {
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
        if($user->getX('MDP')==$password){
          SessionStart();
          $_SESSION['user']=serialize($user);
          $newRequest = new Request();
          $newRequest->write('controller','user');
          $newRequest->write('user',$user->get_id());
          $contoller = Dispatcher::getCurrentDispatcher()->dispatch($newRequest);
          $contoller->execute();
        }
        else {
          $view = new ConnectionView($this);
          $view->setArg('conErrorText','Your login and your password didn\'t match.');
          $view->render($this);
        }
      }
      else {
        $view = new ConnectionView($this);
        $view->setArg('conErrorText','Unknown login');
        $view->render($this);
      }
    }

    public function mdpGenerator(){
      $aleat_Password = "";
      $aleatCase=0;
      $aleatChar=0;
      for ($i=0;$i<7;$i++){
        $aleatCase = rand(0,2);
        switch ($aleatCase) {
          case 0:
            // Case 0 : Number
            $aleatChar= rand(0,9);
            $aleat_Password=$aleat_Password.$aleatChar;
            break;

          case 1:
            // Case 1 : letter
            $aleatChar=rand(65,90);
            $aleat_Password=$aleat_Password.chr($aleatChar);
            break;

          case 2:
            // Case 2 : Capital Letter
            $aleatChar=rand(97,122);
            $aleat_Password=$aleat_Password.chr($aleatChar);
            break;

          default:
            //Default : Case 0
            $aleatChar= rand(0,9);
            $aleat_Password=$aleat_Password.$aleatChar;
            break;
        }
      }
      return ($aleat_Password);
    }

public function creationMailing($login, $email){
  date_default_timezone_set ('Europe/Paris');
  if(User::eMailexist($email)){
    $view = new ConnectionView($this);
    $mdp = $this->mdpGenerator();
    $destinataire = $email;
    require "/PHPMailer/class.phpmailer.php";
    require '/PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPmailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host='smtp.gmail.com';
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "6nimmt.projet.web@gmail.com";
    $mail->Password = "PHPMAILERCESTNUL";
    $mail->From='6nimmt.projet.web@gmail.com';
    $mail->FromName='6nimmt Contact';
    $mail->AddAddress($destinataire);
    $mail->AddReplyTo('6nimmt.projet.web@gmail.com');
    $mail->CharSet = 'UTF-8';
    $mail->Subject='Vos identifiants -- 6nimmt';
    $mail->Body='<html>';
    $mail->Body.='    <head>';
    $mail->Body.='      <meta charset="utf-8">';
    $mail->Body.='<style>body{color: #3A405A}</style>';
    $mail->Body.='    </head>';
    $mail->Body.='      <body><h2>Création d\'un compte</h2>';
    $mail->Body.='      <p>Vous avez créé un compte sur notre site 6 qui ramasse sous le pseudo '.$login.'.</p>';
    $mail->Body.='      <p>Si vous n\'êtes pas à l\'origine de cette action, répondez à ce mail, nous traiterons votre demande au plus vite!</p>';
    $mail->Body.='  </body>';
    $mail->Body.='</html>';
    $mail->MsgHTML($mail->Body);
    $mail->Send();
  }
}

    public function validateRecovery($args){
      date_default_timezone_set ('Europe/Paris');
      $email=$args->read('recoPsw');
      if(User::eMailexist($email)){
        $view = new ConnectionView($this);
        $mdp = $this->mdpGenerator();
        $destinataire = $email;
        require "/PHPMailer/class.phpmailer.php";
        require '/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPmailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host='smtp.gmail.com';
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->Username = "6nimmt.projet.web@gmail.com";
        $mail->Password = "PHPMAILERCESTNUL";
        $mail->From='6nimmt.projet.web@gmail.com';
        $mail->FromName='6nimmt Contact';
        $mail->AddAddress($destinataire);
        $mail->AddReplyTo('6nimmt.projet.web@gmail.com');
        $mail->CharSet = 'UTF-8';
        $mail->Subject='Vos identifiants -- 6nimmt';
        $mail->Body='<html>';
        $mail->Body.='    <head>';
        $mail->Body.='      <meta charset="utf-8">';
        $mail->Body.='<style>body{color: #3A405A}</style>';
        $mail->Body.='    </head>';
        $mail->Body.='      <body><h2>Mot de passe oublié</h2>';
        $mail->Body.='      <p>Vous avez fait une demande de réactualisation de mot de passe sur notre site 6 qui ramasse.</p>';
        $mail->Body.='      <p>Si vous n\'êtes pas à l\'origine de cette action, répondez à ce mail, nous traiterons votre demande au plus vite!</p>';
        $mail->Body.='      <table>';
        $mail->Body.='        <thead>';
        $mail->Body.='          <th>Nouveau mot de passe</th>';
        $mail->Body.='        </thead>';
        $mail->Body.='        <tbody>';
        $mail->Body.='          <tr>';
        $mail->Body.='            <td>'.$mdp.'</td>';
        $mail->Body.='          </tr>';
        $mail->Body.='        </tbody>';
        $mail->Body.='';
        $mail->Body.='      </table>';
        $mail->Body.='  </body>';
        $mail->Body.='</html>';
        $mail->MsgHTML($mail->Body);
        if($mail->Send()){
          $view = new ConnectionView($this);
          $data=User::exec_sql('USER_UPDATE_PASSWORD_BY_MAIL',array(
            ':mdp'=>$mdp,
            'mail'=>$destinataire
          ));
          $view->setArg('RecoverText','Un e-mail avec vos identifiants a été envoyé !');
        }
        else{
          $view = new ConnectionView($this);
          $view->setArg('conErrorText','Une erreur a été détectée, veuillez reessayer ! Problème depuis la migration du serveur');
        }
        var_dump($mail);
        $mail->SmtpClose();
        unset($mail);
        $view->render($this);
      }
      else {
        $view = new ConnectionView($this);
        $view->setArg('conErrorText','E-mail inconnu');
        $view->render($this);
      }
    }
  }
?>

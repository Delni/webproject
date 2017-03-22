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
      date_default_timezone_set ('Europe/Paris');
      $email=$args->read('recoPsw');
      if(User::eMailexist($email)){
        //TODO: send a e-mail
        $view = new ConnectionView($this);
        $mdp = $this->mdpGenerator();
        $destinataire = $email;
        /*
        // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
        $expediteur = 'adrien.handjani@yahoo.fr';
        $objet = "Changement de MdP - 6 qui ramasse !";
        $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
        $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
        $message = '<div style="width: 100%; text-align: center; font-weight: bold">Un Bonjour de Developpez.com !</div>';        $succes = mail($destinataire,$objet,$message,$headers);
        */
        require "/PHPMailer/class.phpmailer.php";
        require '/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPmailer();
        $mail->IsSMTP();
        $mail->SMTPAuth   = false;
        $mail->IsHTML(true);
        $mail->Host='smtp.free.fr';
        $mail->From='adrien.handjani@minesdedouai.fr';
        $mail->FromName='6nimmt Contact';
        $mail->AddAddress($destinataire);
        $mail->AddReplyTo('adrien.handjani@minesdedouai.fr');
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
        /*
        $mail = new PHPMailer();
        $mail->Host = 'smtp.free.fr';
        $mail->SMTPAuth   = false;
        $mail->Port = 25; // Par défaut

        // Expéditeur
        $mail->From='adrien.handjani@yahoo.fr';
        // Destinataire
        $mail->AddAddress($destinataire, 'Nom Prénom');
        // Objet
        $mail->Subject = 'Objet du message';

        // Votre message
        $mail->MsgHTML('Contenu du message en HTML');
        */
        if($mail->Send()){
          $view = new ConnectionView($this);
          $sql_req=DatabasePDO::getCurrentPDO()->prepare('UPDATE joueur SET MdP = :mdp WHERE Email="'.$destinataire.'"');
          $sql_req->bindParam(':mdp',$mdp);
          $sql_req->execute();
        }
        else{
          $view = new ConnectionView($this);
          $view->setArg('conErrorText','Une erreur a été détectée, veuillez reessayer');
        }
        $mail->SmtpClose();
        unset($mail);
        /*while($succes==FALSE){
        $view = new ConnectionView($this);
        $view->setArg('conErrorText','E-mail inconnu');
        $view->render($this);
      }*/
        $view->setArg('RecoverText','Un e-mail avec vos identifiants a été envoyé !');
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

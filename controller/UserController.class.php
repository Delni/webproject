<?php
  class UserController extends Controller {

    public function defaultAction($request) {
      $view = new UserView($this);
      $view->render($this);
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

    public function createGame($request){
      if ($request->read('crName')!=NULL) {
        $nom_plat=$request->read('crName');
        $mdp_prive=$request->read('crPass');
        User::createGame($nom_plat,$mdp_prive,unserialize($_SESSION['user'])->get_id());
        $view= new PlaygroundView($this);
        $view->setArg('log0','<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
        $view->setArg('log1','<div class="row text-center"><p>Créée par '.unserialize($_SESSION['user'])->get_id().'<p></div><hr>');
        if ($mdp_prive!=NULL) {
          $view->setArg('log2','<div class="row"><p class="log"><em class="underline">Nom : </em>'. $nom_plat.',<br> <em class="underline">Mot de passe :</em> '. $mdp_prive.'</p></div><hr>');
        } else {
          $view->setArg('log2','<div class="row"><p class="log"><em class="underline">Nom :</em> '. $nom_plat.', ne nécessite pas de mot de passe</p></div><hr>');
        }

        $view->setArg('log3','<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div>
        <div class="row"><p class="log"> En attente de joueurs...(1/10)</div><hr>');
        $view->render($this);
      } else {
        $view = new CreationView($this);
        $view->setArg('crErrorText','Erreur sur la création de la partie');
        $view->render($this);
      }
    }

    public function totalWipeOut($reques){
      $sql_req="DELETE FROM `joueur` WHERE `joueur`.`Pseudo` = '". unserialize($_SESSION['user'])->get_id() ."'";
      DatabasePDO::getCurrentPDO()->query($sql_req);
      SessionStop();
      header('Location: index.php');
    }
  }

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
        $id_plat=User::createGame($nom_plat,$mdp_prive,unserialize($_SESSION['user'])->get_id());
        if($id_plat!=NULL){
          $view= new PlaygroundView($this);
          $view->setIdPlat($id_plat);
          $view->setLog($id_plat,'<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
          $view->setLog($id_plat,'<div class="row text-center"><p>Créée par '.unserialize($_SESSION['user'])->get_id().'<p></div><hr>');

          if ($mdp_prive!=NULL) {
            $view->setLog($id_plat,'<div class="row"><p class="log"><em class="underline">Nom : </em>'. $nom_plat.',<br> <em class="underline">Mot de passe :</em> '. $mdp_prive.'</p></div><hr>');
          } else {
            $view->setLog($id_plat,'<div class="row"><p class="log"><em class="underline">Nom :</em> '. $nom_plat.', ne nécessite pas de mot de passe</p></div><hr>');
          }
          $sql_req="SELECT COUNT(PSEUDO)AS nb_joueurs FROM jouer WHERE id_plat='".$id_plat."'";
          $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
          $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
          $view->setLog($id_plat,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row"><p class="log"> En attente de joueurs...</div><hr>');
          $view->render($this);
        } else {
          $view = new CreationView($this);
          $view->setArg('crErrorText','Erreur sur la création de la partie');
          $view->render($this,$id_plat);
        }
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

    public function updateProfile($request){
      $nom=$request->read('name');
      $prenom=$request->read('fname');
      $mail=$request->read('email');
      $pays=$request->read('pays');
      User::updateProfile($nom,$prenom,$mail,$pays,unserialize($_SESSION['user'])->get_id());
      Header('Location:index.php');
    }

    public function updatePassWord($request){
      $lpassword=$request->read('lPass');
      $npassword=$request->read('nPass');
      unserialize($_SESSION['user'])->updatePassWord($lpassword, $npassword);
      Header('Location:index.php');
    }

    public function showGame($request){
      $view = new GameListView($this);
      $view->render($this);
    }

    public function joinGame($request){
      $id_plat=$request->read('id_plat');
      $psw = $request->read('psw_plat');
      $psw= (isset($psw)?$psw:'');
      if(isset($id_plat)){
        if (Game::userIsallowed(unserialize($_SESSION['user'])->get_id(),$id_plat)) {
          if(Game::psw_entrence($psw,$id_plat)){
            $view= new PlaygroundView($this);
            $view->setIdPlat($id_plat);
            $view->setOwnController($this);
            $view->render($this);
          } else {
            $view = new UserView($this);
            $view->setArg('joinErrorText','Impossible de se connecter à la partie : mot de passe incorrect.');
            $view->render($this);
          }
        } else {
          $view = new UserView($this);
          $view->setArg('joinErrorText','Impossible de se connecter à la partie (partie en cours ou remplie).');
          $view->render($this);
        }
      } else {
        $view = new UserView($this);
        $view->setArg('joinErrorText','Une erreur a été rencontrée.');
        $view->render($this);
      }
    }

    public function distributeCards($request){
      $array=User::distributeCards($request->read('id'));
      $view= new PlaygroundView($this);
      $view->setIdPlat($request->read('id'));
      $view->render($this);

    }
  }

<?php
  class UserController extends Controller {

    public function defaultAction($request) {
      $view = new UserView($this);
      $view->render($this);
    }

    public function editProfile($request){
      $view = new EditeView($this);
      $args = unserialize($_SESSION['user'])->getAllInfo()[0];
      $view->setArgs('Prenom',$args->Prenom);
      $view->setArgs('Nom',$args->Nom);
      $view->setArgs('MdP',$args->MdP);
      $view->setArgs('Email',$args->Email);
      $view->setArgs('Pays',$args->Pays);
      $view->setArgs('IdP',$args->IdP);
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
          Game::setLog($id_plat,'<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
          Game::setLog($id_plat,'<div class="row text-center"><p>Créée par '.unserialize($_SESSION['user'])->get_id().'<p></div><hr>');

          if ($mdp_prive!=NULL) {
            Game::setLog($id_plat,'<div class="row"><p class="log col-sm-11"><em class="underline">Nom : </em>'. $nom_plat.',<br> <em class="underline">Mot de passe :</em> '. $mdp_prive.'</p></div><hr>');
          } else {
            Game::setLog($id_plat,'<div class="row"><p class="log col-sm-11"><em class="underline">Nom :</em> '. $nom_plat.', ne nécessite pas de mot de passe</p></div><hr>');
          }
          $data = User::exec_sql('USER_GET_nbJOUEURS',array(
            ':id_plat'=> $id_plat
          ));
          Game::setLog($id_plat,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row"><p class="log col-sm-11"> En attente de joueurs...</p></div><hr>');
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

    public function totalWipeOut($request){
      User::exec_sql('USER_DELETE',array(
        ':login'=> unserialize($_SESSION['user'])->get_id()
      ));
      SessionStop();
      header('Location: index.php');
    }

    public function updateProfile($request){
      $nom=$request->read('name');
      $prenom=$request->read('fname');
      $mail=$request->read('email');
      $pays=$request->read('pays');
      $img=$request->read('InputFile');
      User::updateProfile($nom,$prenom,$mail,$pays,$img,unserialize($_SESSION['user'])->get_id());

      $view = new EditeView($this);
      $args = unserialize($_SESSION['user'])->getAllInfo()[0];
      $view->setArgs('Prenom',$args->Prenom);
      $view->setArgs('Nom',$args->Nom);
      $view->setArgs('MdP',$args->MdP);
      $view->setArgs('Email',$args->Email);
      $view->setArgs('Pays',$args->Pays);
      $view->setArgs('IdP',$args->IdP);
      $view->setArgs('UpdateInfo',true);
      $view->render($this);
    }

    public function updatePassWord($request){
      $lpassword=$request->read('lPass');
      $npassword=$request->read('nPass');
      $isDone=unserialize($_SESSION['user'])->updatePassWord($lpassword, $npassword);

      $view = new EditeView($this);
      $args = unserialize($_SESSION['user'])->getAllInfo()[0];
      $view->setArgs('Prenom',$args->Prenom);
      $view->setArgs('Nom',$args->Nom);
      $view->setArgs('MdP',$args->MdP);
      $view->setArgs('Email',$args->Email);
      $view->setArgs('Pays',$args->Pays);
      $view->setArgs('IdP',$args->IdP);
    $view->setArgs('UpdatePass',$isDone);
      $view->render($this);
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
            if(Game::estCommence($id_plat)==0){
              $pseudo=unserialize($_SESSION['user'])->get_id();
              $array=User::playgame($id_plat,$pseudo);
              $view->setListeCartes($array);
              $array_pile=Game::lesPiles($id_plat);
              $view->setPileCartes($array_pile);
              $selected_card=$request->read('id_card');
              if(isset($selected_card)){
                $view->setSelectedCard($request->read('id_card'));
                // TODO : 1 must be changed into $id_plat when set :
                // The button which activates joinGame to select a card must add
                // the id_plat to the request
                var_dump($id_plat);
                $pseudo = Game::getIdMain($id_plat,unserialize($_SESSION['user'])->get_id());
                var_dump(unserialize($_SESSION['user'])->get_id());
                User::selectCard($request->read('id_card'),$pseudo);
              }
            }
            $view->render($this);
          }
          else {
            $view = new UserView($this);
            $view->setArg('joinErrorText','Impossible de se connecter à la partie : mot de passe incorrect.');
            $view->render($this);
          }
        }
        else {
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
      Game::distributeCards($request->read('id'));
      $pseudo=unserialize($_SESSION['user'])->get_id();
      $id_plat=$request->read('id');
      $view= new PlaygroundView($this);
      $view->setIdPlat($request->read('id'));
      $array=User::playgame($id_plat,$pseudo);
      $view->setListeCartes($array);
      $array_pile=Game::lesPiles($id_plat);
      $view->setPileCartes($array_pile);
      $view->render($this);
    }

    // TODO : game in itself

   public static function playCard($request){
      $id_plat=($request->read('id_plat'));
      $all=true;
      // TODO By FrontEnd : allSelectedCards
      // Gotta return all the selected cards
      $array_selected_cards=Game::allSelectedCards($id_plat);
      $nb_joueurs = User::exec_sql('USER_GET_nbJOUEURS',array(
                ':id_plat'=>$id_plat
              ));
      $i=0;
      while($i<$nb_joueurs && $all){
        if($array_selected_cards[$i]==-1){
          $all=false;
        }
      }
      if($all){
        //$array_selected_cards=Game::triCroissant($array);
        // TODO TEST : getIdPlayers
        // Returns array with Id of Players according to sorted $array
        $array_id_players = Game::getIdPlayers($array_selected_cards,$id_plat, $nb_joueurs, $array);
        // TODO TEST : getPilesId($id_plat)
        $array_id_pile = Game::getPilesId($id_plat);
        $maxOfPiles=[];
        for ($k=0;$k<4;$k++){
          $array_cards_pile=[];
          // TODO TEST : getCardsOfPile
          $array_cards_pile = Game::getCardsOfPile($array_id_pile[$k]);
          // TODO TEST : numberOfCardsInPile
          $numberInPile = Game::numberOfCardsInPile($array_id_pile[$k]);
          // TODO TEST : max_list($id_plat)
          $maxOfPiles[$k]= Game::max_list($array_cards_pile, $nbOfCards);
        }
        for ($l=0;$l<4;$l++){
          // TODO TEST : indexOfClosest
          // Returns the number of the pile where the card is to be added
          $index_closest = Game::indexOfClosest($array_selected_cards[$l],$maxOfPile,4-$l);
          // TODO TEST : relatedIndex
          // Returns the index of the pile where the card is to be added
          // According to $maxOfPile and not according to SQL
          $index_tab = Game::relatedIndex($maxOfPile, $index_closest, 4-$l);
          // TODO quasi TEST : addCardToPile
          // Beware : this function has to take care of the number of Cards
          // In each pile, and update scores if necessary
          $numberInAimedPile = Game::numberOfCardsInPile($index_closest);
          Game::addCardToPile($array_selected_cards[$l],$index_closest,$numberInAimedPile, $id_plat, $array_id_players[$l]);
          // TODO TEST : SuppressCardsHand
          // Erase card with value $array[$l] and selectedCard
          Game::suppressCardsHand($array_selected_cards[$l],$id_plat, $array_id_players[$l]);
          $maxOfPiles=User::suppr($maxOfPiles, $maxOfPiles[$index_tab]);
        }
        // TODO : make sure there's still cards in hands to end the game if necessary
      }
    }

    public static function playCard($request){
      $id_plat=$request->read('id_plat');
      $all=true;
      $array=User::allSelectedCards($id_plat));
      $nb_joueurs = User::exec_sql('USER_GET_nbJOUEURS',array(
                ':id_plat'=>$id_plat
              ));
      $i=0;
      while($i<$nb_joueurs && $all){
        if($array[$i]==-1){
          $all=false;
        }
      }
      if($all){

      }

    }

  }

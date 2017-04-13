<?php
  class UserController extends Controller {

    /**
    *
    *   UserController handles every actions a connected user can do.
    *
    *   Functions:
    *     @defaultAction      (void)    -> Solely renders the default UserView
    *     @editProfile        (void)    -> Renders a form to modify User's info
    *     @logout             (void)    -> Stops the session (cf config.php) and head to the main page (no action)
    *     @Creation           (void)    -> Renders a view in order to create a new game
    *     @createGame         (void)    -> Creates the new game. If ok, goes to PlaygroundView, if not displays errors
    *     @totalWipeOut       (void)    -> Deletes an account, and then stops the session
    *     @updateProfile      (void)    -> Renders the editProfileView, with an OK/not-OK display
    *     @updatePassWord     (void)    -> Same idea for the password
    *     @showGame           (void)    -> Displays all the games currently on the server
    *     @joinGame           (void)    -> Looks if the user can join a particular game. If so, shows the playground, if not shows errors
    *     @distributeCards    (void)    -> Randomizes the hands and distributes Cards. Set view args to display cards
    *     @playCard           (void)    -> Selects a card. If each player has done so, plays the round. If not, waits. If a card is already selected, doesn't move
    *
    **/

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
        if($nom_plat=='NyanCat'){
          header('Location: http://www.nyan.cat/original');
          return 0;
        }
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
          Game::setLog($id_plat,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row text-center"><p class="log col-sm-11"> En attente de joueurs...</p></div><hr>');
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

    public function parties($resquest){
      $view = new GameListCurrentView($this);
      $view->render($this);
    }

    public function story(){
      $view = new StoryView($this);
      $view->render($this);
    }

    public function stats(){
      $view = new StatView($this);
      $view->render($this);
    }

    public function joinGame($request){
      $id_plat=$request->read('id_plat');
      $psw = $request->read('psw_plat');
      $psw= (isset($psw)?$psw:'');
      if(isset($id_plat)){
        if (Game::userIsallowed(unserialize($_SESSION['user'])->get_id(),$id_plat)) {
          if(Game::psw_entrance($psw,$id_plat)){
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
                $pseudo = Game::getIdMain($id_plat,unserialize($_SESSION['user'])->get_id());
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

    public function playCard($request){
       $id_plat=($request->read('id_plat'));
       $all=true;
       $id_selected=($request->read('id_card'));
       $pseudo=unserialize($_SESSION['user'])->get_id();
       // Gotta return all the selected cards
       $id_pre_selected = User::exec_sql('USER_GET_SELECTED',array(
                 ':id_plat'=>$id_plat,
                 ':pseudo'=>$pseudo
       ));
       // TODO
       // TODO
       // TODO
       // TODO
       // TODO
       // TODO il faut inscrire dans la request la string entrer dans le chp caché du code!!!
       // TODO
       // TODO
       // TODO
       // TODO
       // TODO
       $codeWritten = ($request->read('KonamiString'));
       var_dump($codeWritten);
       $resultatCode = Game::activateKonamiCode($pseudo,$id_plat,$codeWritten);
       $existing = Game::searchKonamiCode($id_plat);
       if($resultatCode==1){
         // TODO
         // TODO DOIT AFFICHER UN MSG POUR DIRE QUE LE CODE EST FAUX (msg moqueur?)
         // TODO
         $view= new PlaygroundView($this);
         $view->setIdPlat($id_plat);
         $view->setOwnController($this);
         $pseudo=unserialize($_SESSION['user'])->get_id();
         $array=User::playgame($id_plat,$pseudo);
         $view->setListeCartes($array);
         $array_pile=Game::lesPiles($id_plat);
         $view->setPileCartes($array_pile);
         $view->render($this);
       }
       else if($existing=-1){
         if(!empty($id_pre_selected)){
           if($id_pre_selected->Id_Selected_Card==-1){
             User::selectCard(unserialize($_SESSION['user'])->get_id(), $id_plat, $id_selected);
             Game::suppressCardsHand($id_selected,$id_plat,$pseudo);
             $i=0;
             $array_selected_cards=Game::allSelectedCards($id_plat);
             $numb_joueurs = User::exec_sql('USER_GET_nbJOUEURS',array(
                       ':id_plat'=>$id_plat
                     ));
             while($i<$numb_joueurs->nb_joueurs && $all){
               if($array_selected_cards[$i][0]==-1){
                 $all=false;
               }
               $i++;
             }
             if($all){
               // Returns array with Id of Players according to sortedArray
               $array_id_players = Game::getIdPlayers($array_selected_cards,$id_plat, $numb_joueurs->nb_joueurs);
               $array_id_pile = Game::getPilesId($id_plat);
               $maxOfPile=[];
               for ($k=0;$k<4;$k++){
                 $array_cards_pile=[];
                 $array_cards_pile = Game::getCardsOfPile($array_id_pile[$k]);
                 $numberInPile = Game::numberOfCardsInPile($array_id_pile[$k]);
                 $maxOfPile[$k]=$array_cards_pile[count($array_cards_pile)-1];
               }
               //Game::minimizePiles($array_id_pile)
               $nb_joueurs=Game::getNbJoueurs($id_plat);
               for ($l=0;$l<$nb_joueurs->nb_joueurs;$l++){
                 // Returns the number of the pile where the card is to be added
                 $index_closest = Game::indexOfClosest($array_selected_cards[$l][0],$maxOfPile, $id_plat, $array_id_pile);
                 if($index_closest==-1){
                   $index_closest=Game::minimizePiles($array_id_pile, $id_plat, $pseudo);
                   $index_tab = Game::relatedIndex($array_selected_cards[$l][0],$maxOfPile,4-$l);
                   Game::deletePilePleine($index_closest,$id_selected);
                   Game::resetSelected($id_plat, $array_id_players[$l]);
                   $maxOfPiles=User::suppr($maxOfPile, $maxOfPile[$index_tab]);
                 }
                 else{
                   // Returns the index of the pile where the card is to be added
                   // According to $maxOfPile and not according to SQL
                   $index_tab = Game::relatedIndex($array_selected_cards[$l][0],$maxOfPile,4-$l);
                   // Beware : this function has to take care of the number of Cards
                   // In each pile, and update scores if necessary
                   $numberInAimedPile = Game::numberOfCardsInPile($index_closest);
                   Game::addCardToPile($array_selected_cards[$l],$index_closest,$numberInAimedPile, $id_plat, $array_id_players[$l]);
                   // Erase card with value $array[$l] and selectedCard
                   Game::resetSelected($id_plat, $array_id_players[$l]);
                   $maxOfPiles=User::suppr($maxOfPile, $maxOfPile[$index_tab]);
                 }
               }
               // Game::showScores($id_plat);
               //TODO : this test must be done before all ! If not, game try to reach unexisting objects and crash
               $numberInHand=Game::numberInHand($pseudo,$id_plat);
               if($numberInHand==0){
                 // TODO TEST addHistorique
                 Game::addHistorique($id_plat,$array_id_players, $numb_joueurs->nb_joueurs);
                 // TODO showFinalScores ou TEMPLATE
                 $winnerTable=Game::showFinalScores($id_plat);
                 // TODO TEST deleteAll
                 Game::deleteAll($id_plat,$array_id_pile, $array_id_players, $numb_joueurs->nb_joueurs);
                 //TODO Template win
                 $view= new EndofGameView($this);
                 $view->setArg('winning_table',$winnerTable);
                 $view->render($this);
               }
               else{
                 // TODO : handle the multi-select case
                 $view= new PlaygroundView($this);
                 $view->setIdPlat($id_plat);
                 $view->setOwnController($this);
                 $pseudo=unserialize($_SESSION['user'])->get_id();
                 $array=User::playgame($id_plat,$pseudo);
                 $view->setListeCartes($array);
                 $array_pile=Game::lesPiles($id_plat);
                 $view->setPileCartes($array_pile);
                 $view->render($this);
               }
             }
             else {
               $view= new PlaygroundView($this);
               $view->setIdPlat($id_plat);
               $view->setOwnController($this);
               $pseudo=unserialize($_SESSION['user'])->get_id();
               $array=User::playgame($id_plat,$pseudo);
               $view->setListeCartes($array);
               $array_pile=Game::lesPiles($id_plat);
               $view->setPileCartes($array_pile);
               $view->render($this);
             }
           }
         }
         else{
           //winnerTable has to be defined thx to historique and not score here, cause scores have been deleted
           $view= new EndofGameView($this);
           if(isset($winnerTable)) {
             $view->setArg('winning_table',$winnerTable);
           }
           $view->render($this);
         }
       }
       else{
         $Sudo = Game::getSudo($id_plat);
         if($pseudo==$sudo){
           // TODO
           // TODO AFFICHER LE TEMPLATE DE WIN CHEATER
           // TODO
         }
         else{
           // TODO
           // TODO AFFICHER LE TEMPLATE DE LOSE CAR CHEATER
           // TODO
         }
       }
     }

    // TODO :
    // Almost DONE Fin de la partie
    // DONE Historique
    // Javascript

  }

<?php
  class Game extends Model{

    /**
    *
    *   Game model is used to handle every action which are necessary for the game
    *
    *   Functions:
    *   @psw_entrance         (boolean)     -> Checks if the game has a password. If so, verifies if the given password is OK.
    *   @setLog               (void)        -> ???
    *   @lesPiles             (array)       -> Returns an array containing the Id of every pile of the given game .
    *   @getNbJoueurs         (int)         -> Returns the number of players for the giving game .
    *   @distributeCards      (array)       -> Distributes cards in hands, in piles, sets scores for every player. Also returns array of array : array[x][0] = Player's Pseudo // array[x][1] = his cards in hand.
    *   @estCommence          (int)         -> Returns -1 if the game isn't started yet, 0 if it has started and 1 if it is finished.
    *   @userIsallowed        (boolean)     -> Returns true if the player is allowed to connect to this game, false if not.
    *   @getIdMain            (string)      -> Returns given player's hand id.
    *   @allSelectedCards     (array)       -> Returns array filled with every player of the given game's card that has been selected.
    *   @getIdPlayers         (array)       -> Returns array filled with every player of the given game's id.
    *   @getPilesId           (array)       -> Returns array filled with every pile of the given game's id.
    *   @getCardsOfPile       (array)       -> Returns array filled with every pile of the given game's cards.
    *   @numberOfCardsInPile  (int)         -> Returns the number of cards in the given pile.
    *   @max_list             (int)         -> Returns max of the given list.
    *   @minimizePiles        (int)         -> Returns id of the pile whose cards' sum of weight is the lowest
    *   @deletePilePleine     (void)        -> Replace cards in given pile by the given card (first deleting previous cards, then adding the new one).
    *   @indexOfClosest       (int)         -> Returns id of the pile where the selected card is supposed to go  (returns -1 if the card's value is lower than any pile's last card's value).
    *   @relatedIndex         (int)         -> Returns index of the given pile within the array.
    *   @addCardToPile        (void)        -> Adds every selected cardto the pile it's supposed to go. Takes care of : weither or not the pile if full (5 cards), weither or not the scores have to be changed (and does so if necessary).
    *   @suppressCardsHand    (void)        -> Deletes the selected card in each player's hand.
    *   @resetSelected        (void)        -> Resets selected card value in SQL to -1.
    *   @numeroInHand         (string)      -> Returns "Id_Carte x" with x being the place of the given selected card in the hand of the given player.
    *   @numberInHand         (int)         -> Returns the number of card in the hand of a given player for a given game.
    *   @showScores           (void)        -> ???
    *   @getScore             (string)      -> Returns the score of the given player according to the given game.
    *   @getWinner            (string)      -> Returns the winner of the given game.
    *   @getScoreWinner       (string)      -> Returns the winner of the given game's score.
    *   @getNomPlat           (string)      -> Returns the name of the game.
    *   @addHistorique        (void)        -> Adds the given game to the SQL table "historique" for every player in this game.
    *   @showFinalScores      (string)      -> Give the table whith every and each final score
    *   @deleteEtreDans       (void)        -> Deletes every lignes in SQL table "etre_dans" related to the piles' id in the given array (assuming there are 4).
    *   @deletePile           (void)        -> Deletes every lignes in SQL table "piles" related to the piles' id in the given array (assuming there are 4).
    *   @deleteMain           (void)        -> Deletes every lignes in SQL table "main" related to the given game and players' id in the given array.
    *   @deleteJouer          (void)        -> Deletes every lignes in SQL table "jouer" related to the given game and players' id in the given array.
    *   @deleteScore          (void)        -> Deletes every lignes in SQL table "score" related to the given game and players' id in the given array.
    *   @deletePlateau        (void)        -> Deletes the given game from SQL table "plateau.
    *   @deleteAll            (void)        -> Uses all 6 previous deleting functions to delete a game.
    **/

    public static function psw_entrance($psw,$id_plat){
      $data=static::exec_sql('GAME_GET_PASSWORD',array(
        ':id_plat' => $id_plat
      ));
      if($data->Prive==NULL){
        return true;
      } else {
        return ($psw==$data->Prive);
      }
    }

    public static function setLog($id_plat,$html_content){
      static::exec_sql('GAME_SET_LOG',array(
        ':id_plat' => $id_plat,
        ':html_content' => $html_content
      ));
    }

    public static function lesPiles($id_plat){
      $array=array();
      $sql_req=static::exec_sql_noFetch('GAME_GET_PILE',array(
        ':id_plat' => $id_plat
      ));
      for($i=0;$i<4;$i++){
        $res=$sql_req->fetch(DatabasePDO::FETCH_OBJ);
        $aux=intval($res->Id_Pile);
        $sql_carte_pile=static::exec_sql_noFetch('GAME_SELECT_CARD_IN_PILE',array(
          ':id_pile' => $aux
        ));
        $res_carte_pile=$sql_carte_pile->fetch(DatabasePDO::FETCH_OBJ);
        $k=0;
        $array_aux=[];
        while(!empty($res_carte_pile) && $k<5){
          $array_aux[$k]=$res_carte_pile->Id_Carte;
          $k++;
          $res_carte_pile=$sql_carte_pile->fetch(DatabasePDO::FETCH_OBJ);
        }
        $array[$i]=$array_aux;
      }
      return($array);
    }

    public static function getNbJoueurs($id_plat){
      $count_j=static::exec_sql('USER_GET_nbJOUEURS',array(
        ':id_plat'=>$id_plat
      ));
      return($count_j);
    }

    public static function distributeCards($id_plat){
    $data=static::exec_sql('USER_START_GAME',array(
      ':id_plat'=>$id_plat
    ));
    $card_array = Array();
    for ($i=1;$i<105;$i++){
      $card_array[$i-1]=$i;;
      }
    $count_j=static::getNbJoueurs($id_plat);
    $res_sql=static::exec_sql_noFetch('GAME_GET_PSEUDO',array(
      ':id_plat' => $id_plat
    ));
    $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
    $compteur=0;
    $k=0;
    $compt_num_j=0;
    $res_array=Array();
    for ($ligne=0; $ligne<$count_j->nb_joueurs; $ligne++) {
        $res_array[$ligne][0]='';
        $res_array[$ligne][1]=Array();
    }
    $testIf=static::exec_sql('GAME_GET_MAIN_TEST',array(
      ':id_plat' => $id_plat,
      ':pseudo'  => $data->Pseudo
    ));
    if(!$testIf){
      while(($data!=null)&&($compteur<104)){
        static::exec_sql('USER_SET_HAND',array(
          ':pseudo' =>$data->Pseudo,
          ':id_plat'=>$id_plat
        ));
        static::exec_sql('USER_SET_SCORE',array(
          ':pseudo' =>$data->Pseudo,
          ':id_plat'=>$id_plat
        ));
        $newarray=Array();
        for($k=0;$k<10;$k++){
          $aleat = User::aleat($card_array);
          $newarray[$k]=$aleat;
          $card_array = User::suppr($card_array,$aleat);
          $compteur++;
          $sql_main=DataBasePDO::getCurrentPDO()->prepare('UPDATE main SET Id_Carte'.($k+1).' = "'.$aleat.'" WHERE Pseudo =:pseudo AND Id_Plat =:id_plat');
          $sql_main->execute(array(
            ':pseudo'  => $data->Pseudo,
            ':id_plat' => $id_plat
          ));
        }
          $res_array[$compt_num_j][0]=$data->Pseudo;
          $res_array[$compt_num_j][1]=$newarray;
          $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
          $compt_num_j++;
        }

        //SQL TO REFACTOR
        $sql_id_pile=static::exec_sql_noFetch('GAME_GET_PILE',array(
          ':id_plat' => $id_plat
        ));
        for($k=0;$k<4;$k++){
          $id_pile = $sql_id_pile->fetch(DatabasePDO::FETCH_OBJ);
          $aleat = User::aleat($card_array);
          $newarray[$k]=$aleat;
          $card_array = User::suppr($card_array,$aleat);
          static::exec_sql('GAME_SET_PILE',array(
            ':id_pile' => $id_pile->Id_Pile,
            ':num' => $aleat
          ));
        }
        return($res_array);
      }
    }

    public static function estCommence($id_plat){
      $res=static::exec_sql('GAME_GET_STATUS',array(
        ':id_plat' => $id_plat
      ));
      return ($res->estCommence);
    }

    public static function userIsallowed($login,$id_plat){
      $data=static::exec_sql('GAME_IS_OPEN',array(
        ':id_plat' => $id_plat
      ));
      $data2=static::exec_sql('GAME_GET_PSEUDO_FROM_PSEUDO&PLAT',array(
        ':pseudo' => $login,
        ':id_plat'=> $id_plat
      ));
      if(!empty($data2)){
        return true;
      }
      else{
        if($data->estCommence==-1){
          if($data->nb_joueurs<10){
            static::exec_sql('GAME_INSERT_NEW_PLAYER',array(
              ':plat' => $id_plat,
              ':joueur' => $login
            ));
            static::setLog($id_plat,'<div class="row"><p class="log">'.$login.' a rejoint la partie !</p></div><hr>');
            return(true);
          }
        }
      else {
        return(false);
        }
      }
    }

    public static function getIdMain($id_plat, $pseudo){
        $res=static::exec_sql('GAME_GET_HAND_ID',array(
          ':pseudo' => $pseudo,
          ':id_plat'=> $id_plat
        ));
        return($res->Id_Main);
    }

    public static function allSelectedCards($id_plat){
      $sql=static::exec_sql_noFetch('GAME_GET_SELECTED_CARDS',array(
        ':id_plat' => $id_plat
      ));
      return $sql->fetchAll(DatabasePDO::FETCH_NUM);

    }

    public static function getIdPlayers($sortedArray,$id_plat, $nb_joueurs){
      $res=[];
      for ($i=0;$i<$nb_joueurs;$i++){
        $res_sql=static::exec_sql('GAME_GET_PSEUDO_FROM_HAND',array(
          ':id_plat' => $id_plat,
          ':selected'=> $sortedArray[$i][0]
        ));
        $res[$i]=$res_sql->Pseudo;
      }
      return($res);
    }

    //
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    // TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO
    //

    public static function getPilesId($id_plat){
      $res=[];
      $sql=static::exec_sql_noFetch('GAME_GET_PILE',array(
        ':id_plat' => $id_plat
      ));
      $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
      if(!empty($res_req)){
        $res[0]=$res_req->Id_Pile;

        for ($i=1;$i<4;$i++){
          $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
          $res[$i]=$res_req->Id_Pile;
        }
      }
      else{
        $res=-1;
      }
      return($res);
    }

    public static function getCardsOfPile($id_pile){
      $res=[];
      $sql=static::exec_sql_noFetch('GAME_SELECT_CARD_IN_PILE',array(
        ':id_pile' => $id_pile
      ));
      $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
      $i=0;
      while(!empty($res_req)){
        $res[$i]=$res_req->Id_Carte;
        $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
        $i++;
      }
      return($res);
    }

    public static function numberOfCardsInPile($id_pile){
      $res=0;
      $res_req=static::exec_sql('GAME_GET_NB_CARDS',array(
        ':id_pile' => $id_pile
      ));
      $res=$res_req->nb;
      return ($res);
    }

    public static function max_list($array, $nbOfCards){
      $res=0;
      for($i=0;$i<$nbOfCards;$i++){
        if($array[$i]>$res){
          $res=$array[$i];
        }
      }
      return ($res);
    }

    public static function minimizePiles($array_id_pile, $id_plat, $pseudo){
      $somme=150;
      $res=0;
      for ($i=0;$i<4;$i++){
        $res_req=static::exec_sql('GAME_GET_PILE_WEIGHT',array(
          ':id_pile' => $array_id_pile[$i]
        ));
        $aux=$res_req->Poids;
        if($aux<$somme){
          $somme=$aux;
          $res=$array_id_pile[$i];
        }
      }
      $prec_score = static::exec_sql('USER_GET_SCORE',array(
        ':pseudo' => $pseudo,
        ':id_plat'=> $id_plat
      ));
      $new = $somme+ $prec_score->Val_Score;
      static::setLog($id_plat,'<div class="row"><p class="log">'.$pseudo.' vient de se prendre <span class="badge">'.$somme.'</span> points dans la vue!</p></div><hr>');
      $sql_score = static::exec_sql('USER_UPDATE_SCORE', array(
        ':score'  => $new,
        ':id_plat'=> $id_plat,
        ':pseudo' => $pseudo
      ));
      // static::showScores($id_plat); //-> Not readable
      return($res);
    }

    public static function deletePilePleine($index_closest, $id_card){
      static::exec_sql('GAME_EMPTY_PILE', array(
        ':id_pile' => $index_closest
      ));
      $sql_add_pile = static::exec_sql('GAME_FILL_PILE', array(
        ':id_pile' => $index_closest,
        ':id_card' => $id_card
      ));
    }

    public static function indexOfClosest($selectedCard, $tabMaxPile,$id_plat, $array_id_pile){
      $aux=-1;
      $last=1500;
      for($i=0;$i<4;$i++){
        if($selectedCard>$tabMaxPile[$i]){
          $diff=$selectedCard-($tabMaxPile[$i]);
          if($diff<$last){
            $aux=$tabMaxPile[$i];
            $last=$diff;
          }
        }
      }
      if($aux==-1){
        $res=-1;
      }
      else{
        $res_req = static::exec_sql('GAME_SELECT_PILE', array(
          ':id_card' => $aux,
          ':id_plat' => $id_plat
        ));
        $res=$res_req->Id_Pile;
      }
      return($res);
    }

    public static function relatedIndex($selectedCard, $tabMaxPile, $taille){
      $res=0;
      $last=150;
      for($i=0;$i<$taille;$i++){
        if($selectedCard>$tabMaxPile[$i]){
          $diff=$selectedCard-$tabMaxPile[$i];
          if($diff<$last){
            $res=$i;
            $last=$diff;
          }
        }
      }
      return($res);
    }

    public static function addCardToPile($selectedCard, $indexPile, $numberInPile, $id_plat, $pseudo){
      if($numberInPile<5){
        static::exec_sql('GAME_FILL_PILE', array(
          ':id_pile' => $indexPile,
          ':id_card' => $selectedCard[0]
        ));
      }
      else{
        $somme=0;
        $array_cards_pile=[];
        $numberInPile=0;
        $array_cards_pile = Game::getCardsOfPile($indexPile);
        $numberInPile = Game::numberOfCardsInPile($indexPile);
        $sql_delete_piles = static::exec_sql('GAME_EMPTY_PILE', array(
          ':id_pile' => $indexPile
        ));
        static::exec_sql('GAME_FILL_PILE', array(
          ':id_pile' => $indexPile,
          ':id_card' => $selectedCard[0]
        ));
        for($i=0;$i<$numberInPile;$i++){
          $res_req = static::exec_sql('GAME_GET_CARD_WEIGHT', array(
            ':id_card' => $array_cards_pile[$i]
          ));
          $somme+=$res_req->Poids;
        }
        $prec_score = static::exec_sql('USER_GET_SCORE', array(
          ':pseudo' => $pseudo,
          ':id_plat'=> $id_plat
        ));
        $new = $somme+ $prec_score->Val_Score;
        static::exec_sql('USER_UPDATE_SCORE', array(
          ':score'  => $new,
          ':id_plat'=> $id_plat,
          ':pseudo' => $pseudo
        ));
        static::setLog($id_plat,'<div class="row"><p class="log">'.$pseudo.' vient de se prendre <span class="badge">'.$somme.'</span> points dans la vue!</p></div><hr>');
        // static::showScores($id_plat);
      }
    }

    //SQL REFACTOR mystery
    public static function suppressCardsHand($selectedCard, $id_plat,$pseudo){
      $sql_delete_selected='UPDATE main SET Id_Selected_Card = -1 WHERE Id_Plat = '.$id_plat.' AND Pseudo ='.$pseudo.'';
      $sql_delete_selected=DatabasePDO::getCurrentPDO()->query($sql_delete_selected);
      $numeroInHand=Game::numeroInHand($id_plat, $selectedCard);
      $numberInHand=static::numberInHand($pseudo,$id_plat);
      $sql_delete_card='UPDATE main SET '.$numeroInHand.' = NULL WHERE Id_Plat = '.$id_plat.' AND Pseudo ="'.$pseudo.'"';
      $sql_delete_card=DatabasePDO::getCurrentPDO()->query($sql_delete_card);
      $number_rest= $numberInHand-1;
      $sql_number_hand='UPDATE main SET Nb_Carte_Main = '.$number_rest.' WHERE Id_Plat = '.$id_plat.' AND Pseudo ="'.$pseudo.'"';
      $sql_number_hand=DatabasePDO::getCurrentPDO()->query($sql_number_hand);
    }

    public static function resetSelected($id_plat,$pseudo){
      $sql_delete_card='UPDATE main SET Id_Selected_Card = -1 WHERE Id_Plat = '.$id_plat.' AND Pseudo ="'.$pseudo.'"';
      $sql_delete_card=DatabasePDO::getCurrentPDO()->query($sql_delete_card);
    }

    public static function numeroInHand($id_plat, $selectedCard){
      $sql_req=static::exec_sql_noFetch('USER_GET_HAND',array(
        ':id_plat' => $id_plat,
        ':selected' => $selectedCard
      ));
      $res=$sql_req->fetch(DatabasePDO::FETCH_ASSOC);
      unset($res['Id_Main']);
      unset($res['Id_plat']);
      $i=1;
      $find=false;
      $numeroInHand=-1;
      while($i<11 && !$find){
        if($selectedCard==$res['Id_Carte'.$i]){
          $numeroInHand=$i;
          $find=true;
        }
        $i++;
        //$numeroInHand=array_search($res['Id_Carte'.$i],$res);
        }
      return 'Id_Carte'.$numeroInHand;
    }

    public static function numberInHand($pseudo,$id_plat){
      $sql_req=static::exec_sql_noFetch('USER_GET_HAND_BY_PSEUDO',array(
        ':id_plat' => $id_plat,
        ':pseudo' => $pseudo
      ));
      $res=$sql_req->fetch(DatabasePDO::FETCH_ASSOC);
      unset($res['Id_Main']);
      unset($res['Id_Plat']);
      unset($res['Pseudo']);
      unset($res['Nb_Carte_main']);
      unset($res['Id_Selected_Card']);
      $i=0;
      foreach ($res as $card) {
        $i= ($card==NULL)? $i:$i+1;
      }
      return $i;
    }

    public static function showScores($id_plat){
      $sql=static::exec_sql_noFetch('USER_SHOW_SCORE',array(
        ':id_plat' => $id_plat
      ));
      $res=$sql->fetchAll(DatabasePDO::FETCH_NUM);
      $html_content ='<div class="row">
        <div class="col-md-offset-1 col-md-10">
        <p>
          <table class="table">
            <thead>
              <th>Classement</th>
              <th>Joueur</th>
              <th>Score</th>
            </thead>
            <tbody>';
      for($i=0;$i<count($res);$i++){
        $html_content=$html_content.'<tr>
          <td>'.($i+1).'</td>
          <td>'.$res[$i][0].'</td>
          <td class="text-center"><span  class="badge">'.$res[$i][1].'</span></td>
        </tr>';
      }
      $html_content=$html_content.'</tbody>
          </table>
        </p>
        </div>
      </div>
      <hr>';
      static::setLog($id_plat, $html_content);
    }

    public static function getScore($pseudo, $id_plat){
      $sql_get_score=static::exec_sql_noFetch('USER_GET_SCORE',array(
        ':pseudo' => $pseudo,
        ':id_plat'=> $id_plat
      ));
      $res=$sql_get_score->fetch(DatabasePDO::FETCH_NUM);
      return($res[0]);
    }

    public static function getWinner($id_plat,$array_id_players, $nb_joueurs){
      $res=250;
      for($i=0;$i<$nb_joueurs;$i++){
        $score=Game::getScore($array_id_players[$i],$id_plat);
        if($score<$res){
          $res=$score;
        }
      }
      return($res);
    }

    public static function getScoreWinner($id_plat,$array_id_players, $nb_joueurs){
      $aux=250;
      $res='';
      for($i=0;$i<$nb_joueurs;$i++){
        $score=Game::getScore($array_id_players[$i], $id_plat);
        if($score<$aux){
          $aux=$score;
          $res=$array_id_players[$i];
        }
      }
      return($res);
    }

    public static function getNomPlat($id_plat){
      $res = static::exec_sql('GAME_GET_NAME', array(
        ':id_plat' => $id_plat
      ));
      return($res->Nom);
    }

    public static function addHistorique($id_plat,$array_id_players, $nb_joueurs){
      $score_winner = Game::getWinner($id_plat,$array_id_players,$nb_joueurs);
      $id_winner = Game::getScoreWinner($id_plat,$array_id_players, $nb_joueurs);
      $nom_plat = Game::getNomPlat($id_plat);
      for($i=0;$i<$nb_joueurs;$i++){
        $current_id = $array_id_players[$i];
        $ratio=Game::exec_sql('USER_GET_RATIO',array(
          ':pseudo' => $current_id
        ));
        if($current_id==$id_winner){
          Game::exec_sql('USER_SET_RATIO',array(
            ':defaites' => $ratio->Perdues,
            ':victoires' => $ratio->Gagnees +1,
            ':pseudo' => $current_id
          ));
        } else {
          Game::exec_sql('USER_SET_RATIO',array(
            ':defaites' => $ratio->Perdues +1,
            ':victoires' => $ratio->Gagnees,
            ':pseudo' => $current_id
          ));
        }
        $current_score=Game::getScore($current_id,$id_plat);
        $sql_req=Game::exec_sql('GAME_ADD_HISTORIQUE',array(
          ':pseudo' => $current_id,
          ':score' => $current_score,
          ':nom' => $nom_plat,
          ':nom_gagnant' => $id_winner,
          ':score_gagnant' => $score_winner
        ));
      }
    }

    public static function showFinalScores($id_plat){
      $sql=static::exec_sql_noFetch('USER_SHOW_SCORE',array(
        ':id_plat' => $id_plat
      ));
      $res=$sql->fetchAll(DatabasePDO::FETCH_NUM);
      $html_content='';
      for($i=0;$i<count($res);$i++){
        $html_content=$html_content.'<tr>
          <td>'.($i+1).'</td>
          <td>'.$res[$i][0].'</td>
          <td class="text-center"><span  class="badge">'.$res[$i][1].'</span></td>
        </tr>';
      }
      return $html_content;
    }

    public static function deleteEtreDans($array_id_pile){
      for($i=0;$i<4;$i++){
        static::exec_sql('GAME_EMPTY_PILE', array(
          ':id_pile' => $array_id_pile[$i]
        ));
      }
    }

    public static function deletePile($array_id_pile){
      for($i=0;$i<4;$i++){
        static::exec_sql('GAME_DELETE_PILE', array(
          ':id_pile' => $array_id_pile[$i]
        ));
      }
    }

    public static function deleteMain($id_plat, $array_id_players, $nb_joueurs){
      for($k=0;$k<$nb_joueurs;$k++){
        static::exec_sql('GAME_DELETE_HAND', array(
          ':id_plat' => $id_plat,
          ':pseudo'  => $array_id_players[$k]
        ));
      }
    }

    public static function deleteJouer($id_plat, $array_id_players, $nb_joueurs){
      for($k=0;$k<$nb_joueurs;$k++){
        static::exec_sql('GAME_EMPTY_PLAT', array(
          ':id_plat' => $id_plat,
          ':pseudo'  => $array_id_players[$k]
        ));
      }
    }

    public static function deleteScore($id_plat, $array_id_players, $nb_joueurs){
      for($k=0;$k<$nb_joueurs;$k++){
        static::exec_sql('GAME_DELETE_SCORE', array(
          ':id_plat' => $id_plat,
          ':pseudo'  => $array_id_players[$k]
        ));
      }
    }

    public static function deleteLog($id_plat){
      static::exec_sql('GAME_DELETE_LOG', array(
        ':id_plat' => $id_plat
      ));
    }

    public static function deletePlateau($id_plat){
      static::exec_sql('CLOSE_GAME', array(
        ':id_plat' => $id_plat
      ));
    }

    public static function deleteAll($id_plat, $array_id_pile, $array_id_players, $nb_joueurs){
      Game::deleteEtreDans($array_id_pile);
      Game::deletePile($array_id_pile);
      Game::deleteMain($id_plat, $array_id_players, $nb_joueurs);
      Game::deleteJouer($id_plat, $array_id_players, $nb_joueurs);
      Game::deleteScore($id_plat, $array_id_players, $nb_joueurs);
      Game::deleteLog($id_plat);
      Game::deletePlateau($id_plat);
    }

  }
    require_once('sql/Game.sql.php');
 ?>

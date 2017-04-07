<?php
  class Game extends Model{

    /**
    *
    *   UserController handle every actions a connected user can do.
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
    *   @showFinalScores      (???)         -> TODO OR ERASE FOR FRONTEND DEV.
    *   @deleteEtreDans       (void)        -> Deletes every lignes in SQL table "etre_dans" related to the piles' id in the given array (assuming there are 4).
    *   @deletePile           (void)        -> Deletes every lignes in SQL table "piles" related to the piles' id in the given array (assuming there are 4).
    *   @deleteMain           (void)        -> Deletes every lignes in SQL table "main" related to the given game and players' id in the given array.
    *   @deleteJouer          (void)        -> Deletes every lignes in SQL table "jouer" related to the given game and players' id in the given array.
    *   @deleteScore          (void)        -> Deletes every lignes in SQL table "score" related to the given game and players' id in the given array.
    *   @deletePlateau        (void)        -> Deletes the given game from SQL table "plateau.
    *   @deleteAll            (void)        -> Uses all 6 previous deleting functions to delete a game.
    **/

     public static function psw_entrance($psw,$id_plat){
      $sql='SELECT Prive FROM Plateau WHERE id_plat="'.$id_plat.'"';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql);
      $data= $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      if($data->Prive==NULL){
        return true;
      } else {
        return ($psw==$data->Prive);
      }
    }

    public static function setLog($id_plat,$html_content){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO log(Id_plat, html) VALUES (:id,:html_content)');
      $sql_req->bindParam(':id',$id_plat);
      $sql_req->bindParam(':html_content',$html_content);
      $sql_req->execute();
    }

    public static function lesPiles($id_plat){
      $array;
      $sql_req='SELECT Id_Pile FROM PILE WHERE id_plat="'.$id_plat.'"';
      $sql_req=DatabasePDO::getCurrentPDO()->prepare($sql_req);
      $sql_req->execute();
      for($i=0;$i<4;$i++){
        $res=$sql_req->fetch(DatabasePDO::FETCH_OBJ);
        $aux=intval($res->Id_Pile);
        $sql_carte_pile='SELECT Id_Carte FROM etre_dans WHERE id_pile='.$aux.'';
        $sql_carte_pile=DatabasePDO::getCurrentPDO()->prepare($sql_carte_pile);
        $sql_carte_pile->execute();
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
    $count_j=static::exec_sql('USER_GET_nbJOUEURS',array(
      ':id_plat'=>$id_plat
    ));
    $sql_req='SELECT Pseudo FROM Jouer WHERE id_plat="'.$id_plat.'"';
    $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
    $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
    $compteur=0;
    $k=0;
    $compt_num_j=0;
    $res_array=Array();
    for ($ligne=0; $ligne<$count_j->nb_joueurs; $ligne++) {
        $res_array[$ligne][0]='';
        $res_array[$ligne][1]=Array();
    }
    $sql_test="SELECT Id_Main FROM MAIN WHERE id_plat='".$id_plat."' AND Pseudo='".$data->Pseudo."'";
    $res_sql_test=DataBasePDO::getCurrentPDO()->query($sql_test);
    $testIf=$res_sql_test->fetch(DataBasePDO::FETCH_OBJ);
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
          $sql_main=DataBasePDO::getCurrentPDO()->prepare('UPDATE main SET Id_Carte'.($k+1).' = "'.$aleat.'" WHERE Pseudo = "'.$data->Pseudo.'" AND Id_Plat =  "'.$id_plat.'"');
          $sql_main->execute();
        }
          $res_array[$compt_num_j][0]=$data->Pseudo;
          $res_array[$compt_num_j][1]=$newarray;
          $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
          $compt_num_j++;
        }

        //SQL TO REFACTOR
        $sql_id_pile='SELECT Id_Pile FROM PILE WHERE Id_Plat ="'.$id_plat.'"';
        $sql_id_pile=DatabasePDO::getCurrentPDO()->query($sql_id_pile);
        for($k=0;$k<4;$k++){
          $id_pile = $sql_id_pile->fetch(DatabasePDO::FETCH_OBJ);
          $aleat = User::aleat($card_array);
          $newarray[$k]=$aleat;
          $card_array = User::suppr($card_array,$aleat);
          $sql_pile_carte = 'INSERT INTO etre_dans VALUES ('.$id_pile->Id_Pile.','.$aleat.')';
          DatabasePDO::getCurrentPDO()->query($sql_pile_carte);
        }
      return($res_array);
    }
  }

    // SQL TO REFACTOR
      public static function estCommence($id_plat){
        $sql_req='SELECT estCommence FROM Plateau WHERE id_plat="'.$id_plat.'"';
        $sql_req=DatabasePDO::getCurrentPDO()->prepare($sql_req);
        $sql_req->execute();
        $res=$sql_req->fetch(DatabasePDO::FETCH_OBJ);
        return ($res->estCommence);
      }

    public static function userIsallowed($login,$id_plat){
      $sql="SELECT COUNT(PSEUDO)as nb_joueurs, estCommence FROM jouer LEFT JOIN Plateau USING (Id_plat) WHERE id_plat='".$id_plat."'";
      $sql2="SELECT PSEUDO FROM jouer WHERE pseudo='".$login."' AND id_plat='".$id_plat."'";
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql);
      $data= $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      $res_sql2=DatabasePDO::getCurrentPDO()->query($sql2);
      $data2= $res_sql2->fetch(DatabasePDO::FETCH_OBJ);
      if(!empty($data2)){
        return true;
      }
      else{
        if($data->estCommence==-1){
          if($data->nb_joueurs<10){
            $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO `jouer`(`ID_PLAT`,`PSEUDO`,`SCORE`) VALUES (:plat,:joueur,0)');
            $sql_req->bindParam(':plat',$id_plat);
            $sql_req->bindParam(':joueur',$login);
            $sql_req->execute();
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
        $sql="SELECT Id_Main FROM MAIN WHERE pseudo='".$pseudo."' AND id_plat='".$id_plat."'";
        $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
        $sql->execute();
        $res=$sql->fetch(DatabasePDO::FETCH_OBJ);
        return($res->Id_Main);
    }

    public static function allSelectedCards($id_plat){
      $sql_req='SELECT `Id_Selected_Card` FROM Main WHERE Id_Plat=:id_plat';
      $sql=DatabasePDO::getCurrentPDO()->prepare($sql_req);
      $sql->bindParam(':id_plat',$id_plat);
      $sql->execute();
      return $sql->fetchAll(DatabasePDO::FETCH_NUM);

    }

    public static function getIdPlayers($sortedArray,$id_plat, $nb_joueurs){
      $res=[];
      for ($i=0;$i<$nb_joueurs;$i++){
        $sql="SELECT Pseudo FROM MAIN WHERE id_plat='".$id_plat."' AND Id_Selected_Card='".$sortedArray[$i][0]."'";
        $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
        $sql->execute();
        $res_sql=$sql->fetch(DatabasePDO::FETCH_OBJ);
        $res[$i]=$res_sql->Pseudo;
      }
      return($res);
    }

    public static function getPilesId($id_plat){
      $res=[];
      $sql="SELECT Id_Pile FROM Pile WHERE id_plat='".$id_plat."'";
      $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
      $sql->execute();
      for ($i=0;$i<4;$i++){
        $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
        $res[$i]=$res_req->Id_Pile;
      }
      return($res);
    }

    public static function getCardsOfPile($id_pile){
      $res=[];
      $sql="SELECT Id_Carte FROM etre_dans WHERE id_pile='".$id_pile."'";
      $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
      $sql->execute();
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
      $sql="SELECT COUNT(Id_Carte) as nb FROM etre_dans WHERE id_pile='".$id_pile."'";
      $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
      $sql->execute();
      $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
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
        $sql_somme_poids="SELECT SUM(Poids) as Poids FROM Carte LEFT JOIN etre_dans ON Carte.Id_Carte = etre_dans.Id_Carte WHERE id_pile='.$array_id_pile[$i].'";
        $sql_somme_poids=DatabasePDO::getCurrentPDO()->prepare($sql_somme_poids);
        $sql_somme_poids->execute();
        $res_req=$sql_somme_poids->fetch(DatabasePDO::FETCH_OBJ);
        $aux=$res_req->Poids;
        if($aux<$somme){
          $somme=$aux;
          $res=$array_id_pile[$i];
        }
      }
      $sql_get_score='SELECT Val_Score FROM SCORE WHERE Pseudo = "'.$pseudo.'" AND Id_Plat ='.$id_plat;
      $sql_get_score=DatabasePDO::getCurrentPDO()->prepare($sql_get_score);
      $sql_get_score->execute();
      $prec_score = $sql_get_score->fetch(DatabasePDO::FETCH_OBJ);
      $new = $somme+ $prec_score->Val_Score;
      $sql_score='UPDATE score SET Val_Score = '.$new.' WHERE Id_Plat = '.$id_plat.' AND Pseudo ="'.$pseudo.'"';
      static::setLog($id_plat,'<div class="row"><p class="log">'.$pseudo.' vient de se prendre <span class="badge">'.$somme.'</span> points dans la vue!</p></div><hr>');
      $sql_score=DatabasePDO::getCurrentPDO()->query($sql_score);
      static::showScores($id_plat);
      return($res);
    }

    public static function deletePilePleine($index_closest, $id_card){
      $sql_delete_pile='DELETE FROM `etre_dans` WHERE Id_Pile='.$index_closest.'';
      $sql_delete_pile=DatabasePDO::getCurrentPDO()->query($sql_delete_pile);
      $sql_add_pile='INSERT INTO etre_dans (`Id_Pile`, `Id_Carte`) VALUES ('.$index_closest.', '.$id_card.')';
      $sql_add_pile=DatabasePDO::getCurrentPDO()->query($sql_add_pile);
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
        $sql='SELECT etre_dans.Id_Pile FROM etre_dans LEFT JOIN Pile ON etre_dans.Id_Pile=Pile.Id_Pile WHERE id_carte='.$aux.' AND Id_Plat='.$id_plat;
        $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
        $sql->execute();
        $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
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
        $sql='INSERT INTO `etre_dans` (`Id_Pile`, `Id_Carte`) VALUES ('.$indexPile.', '.$selectedCard[0].')';
        $sql=DatabasePDO::getCurrentPDO()->query($sql);
      }
      else{
        $somme=0;
        $array_cards_pile=[];
        $numberInPile=0;
        $array_cards_pile = Game::getCardsOfPile($indexPile);
        $numberInPile = Game::numberOfCardsInPile($indexPile);
        $sql_delete_piles='DELETE FROM `etre_dans` WHERE Id_Pile='.$indexPile.'';
        $sql_delete_piles=DatabasePDO::getCurrentPDO()->query($sql_delete_piles);
        $sql='INSERT INTO `etre_dans` (`Id_Pile`, `Id_Carte`) VALUES ('.$indexPile.', '.$selectedCard[0].')';
        $sql=DatabasePDO::getCurrentPDO()->query($sql);
        for($i=0;$i<$numberInPile;$i++){
          $sql='SELECT Poids FROM Carte WHERE Id_Carte='.$array_cards_pile[$i];
          $sql=DatabasePDO::getCurrentPDO()->query($sql);
          $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
          $somme+=$res_req->Poids;
        }
        $sql_get_score='SELECT Val_Score FROM SCORE WHERE Pseudo = "'.$pseudo.'" AND Id_Plat ='.$id_plat;
        $sql_get_score=DatabasePDO::getCurrentPDO()->prepare($sql_get_score);
        $sql_get_score->execute();
        $prec_score = $sql_get_score->fetch(DatabasePDO::FETCH_OBJ);
        $new = $somme+ $prec_score->Val_Score;
        $sql_score='UPDATE score SET Val_Score = '.$new.' WHERE Id_Plat = '.$id_plat.' AND Pseudo ="'.$pseudo.'"';
        static::setLog($id_plat,'<div class="row"><p class="log">'.$pseudo.' vient de se prendre <span class="badge">'.$somme.'</span> points dans la vue!</p></div><hr>');
        static::showScores($id_plat);
        $sql_score=DatabasePDO::getCurrentPDO()->query($sql_score);
      }
    }

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
      $sql_req=DatabasePDO::getCurrentPDO()->prepare('SELECT * FROM main WHERE Id_Plat=:id_plat && Id_Selected_Card=:selected');
      $sql_req->execute(array(
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
      $sql_req=DatabasePDO::getCurrentPDO()->prepare('SELECT * FROM main WHERE Id_Plat=:id_plat && Pseudo=:pseudo');
      $sql_req->execute(array(
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
      $sql=DatabasePDO::getCurrentPDO()->prepare('SELECT Pseudo, Val_Score FROM Score WHERE Id_plat=:id_plat ORDER BY Val_score');
      $sql->execute(array(
        ':id_plat' => $id_plat
      ));
      $res=$sql->fetchAll(DatabasePDO::FETCH_NUM);
      $html_content ='<div class="row">
        <div class="col-md-offset-1 col-md-10">
        <p class=log">Fin du tour !</p>
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
      //TODO : display point in a table
      static::setLog($id_plat, $html_content);
    }

    public static function getScore($pseudo, $id_plat){
      $sql_get_score=DatabasePDO::getCurrentPDO()->prepare('SELECT Val_Score FROM SCORE WHERE Pseudo=:pseudo AND Id_Plat=:id_plat');
      $sql_get_score->execute(array(
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
      $sql_get_nom='SELECT Nom FROM Plateau WHERE Id_Plat = '.$id_plat;
      $sql_get_nom=DatabasePDO::getCurrentPDO()->prepare($sql_get_nom);
      $sql_get_nom->execute();
      $res=$sql_get_nom->fetch(DatabasePDO::FETCH_OBJ);
      return($res->Nom);
    }

    public static function addHistorique($id_plat,$array_id_players, $nb_joueurs){
      $id_winner = Game::getWinner($id_plat,$array_id_players,$nb_joueurs);
      $score_winner = Game::getScoreWinner($id_plat,$array_id_players, $nb_joueurs);
      $nom_plat = Game::getNomPlat($id_plat);
      for($i=0;$i<$nb_joueurs;$i++){
        $current_id = $array_id_players[$i];
        $current_score=Game::getScore($current_id,$id_plat);
        var_dump($current_score);
        var_dump($nom_plat);
        var_dump($id_winner);
        var_dump($score_winner);
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
      // TODO
    }

    public static function deleteEtreDans($array_id_pile){
      for($i=0;$i<4;$i++){
        $sql_delete_etre_dans='DELETE FROM `etre_dans` WHERE Id_Pile='.$array_id_pile[$i].'';
        $sql_delete_etre_dans=DatabasePDO::getCurrentPDO()->query($sql_delete_etre_dans);
      }
    }

    public static function deletePile($array_id_pile){
      for($i=0;$i<4;$i++){
        $sql_delete_pile='DELETE FROM `Pile` WHERE Id_Pile='.$array_id_pile[$i].'';
        $sql_delete_pile=DatabasePDO::getCurrentPDO()->query($sql_delete_pile);
      }
    }

    public static function deleteMain($id_plat, $array_id_players, $nb_joueurs){
      for($k=0;$k<$nb_joueurs;$k++){
        $sql_delete_main='DELETE FROM `Main` WHERE Id_Plat='.$id_plat.' AND Pseudo = "'.$array_id_players[$k][0].'"';
        $sql_delete_main=DatabasePDO::getCurrentPDO()->query($sql_delete_main);
      }
    }

    public static function deleteJouer($id_plat, $array_id_players, $nb_joueurs){
      for($k=0;$k<$nb_joueurs;$k++){
        $sql_delete_jouer='DELETE FROM `Jouer` WHERE Id_Plat='.$id_plat.' AND Pseudo = "'.$array_id_players[$k][0].'"';
        $sql_delete_jouer=DatabasePDO::getCurrentPDO()->query($sql_delete_jouer);
      }
    }

    public static function deleteScore($id_plat, $array_id_players, $nb_joueurs){
      for($k=0;$k<$nb_joueurs;$k++){
        $sql_delete_score='DELETE FROM `Score` WHERE Id_Plat='.$id_plat.' AND Pseudo = "'.$array_id_players[$k][0].'"';
        $sql_delete_score=DatabasePDO::getCurrentPDO()->query($sql_delete_score);
      }
    }

    public static function deletePlateau($id_plat){
      $sql_delete_plateau='DELETE FROM `Plateau` WHERE Id_Plat='.$id_plat;
      $sql_delete_plateau=DatabasePDO::getCurrentPDO()->query($sql_delete_plateau);
    }

    public static function deleteAll($id_plat, $array_id_pile, $array_id_players, $nb_joueurs){
      Game::deleteEtreDans($array_id_pile);
      Game::deletePile($array_id_pile);
      Game::deleteMain($id_plat, $array_id_players, $nb_joueurs);
      Game::deleteJouer($id_plat, $array_id_players, $nb_joueurs);
      Game::deleteScore($id_plat, $array_id_players, $nb_joueurs);
      Game::deletePlateau($id_plat);
    }

  }
    require_once('sql/Game.sql.php');
 ?>

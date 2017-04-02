<?php
  class Game extends Model{

    public static function psw_entrence($psw,$id_plat){
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
        $sql_carte_pile='SELECT Id_Carte FROM etre_dans WHERE id_pile="'.$res->Id_Pile.'"';
        $sql_carte_pile=DatabasePDO::getCurrentPDO()->prepare($sql_carte_pile);
        $sql_carte_pile->execute();
        $res_carte_pile=$sql_carte_pile->fetch(DatabasePDO::FETCH_OBJ);
        $k=0;
        $array_aux;
        while(!empty($res_carte_pile) && $k<5){
          $array_aux[$k]=$res_carte_pile->Id_Carte;
          $k++;
          $res_carte_pile=$sql_carte_pile->fetch(DatabasePDO::FETCH_OBJ);
        }
        $array[$i]=$array_aux;
      }
      return($array);
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
        $res_sql_id_pile=DatabasePDO::getCurrentPDO()->query($sql_id_pile);
        for($k=0;$k<4;$k++){
          $id_pile = $res_sql_id_pile->fetch(DatabasePDO::FETCH_OBJ);
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
            static::setLog($id_plat,'<div class="row"><p class="log">'.$login.' a rejoins la partie !</p></div><hr>');
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

    public static function triCroissant($tab, $taille){
        for($i=0;$i<$taille;$i++){
          $k=0;
          for($j=1;$j<$taille;$j++){
            if($tab[$k]>$tab[$j]){
              for($diff=0;$diff<$j-$k;$diff++){
                $tmp=$tab[$k+$diff];
                $tab[$k+$diff]=$tab[$k+$diff+1];
                $tab[$k+$diff+1]=$tmp;
              }
            }
          }
        }
        return($tab);
      }

      // TODO by FrontEnd
      // Because SQL should sort it by itself

    public static function allSelectedCards($id_plat){

    }

    public static function getIdPlayers($sortedArray,$id_plat, $nb_joueurs){
      $res=[];
      for ($i=0;$i<$nb_joueurs;$i++){
        $sql="SELECT Pseudo FROM MAIN WHERE id_plat='".$id_plat."' AND Id_Selected_Card='".$sortedArray[$i]."'";
        var_dump($sql);
        $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
        $sql->execute();
        $res_sql=$sql->fetch(DatabasePDO::FETCH_OBJ);
        var_dump($res_sql);
        $res[$i]=$res_sql->Pseudo;
        var_dump($res[$i]);
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
      while(!empty($res_req)){
        $res[$i]=$res_req->Id_Carte;
        $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
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

    public static function indexOfClosest($selectedCard, $tabMaxPile, $taille){
      $aux=0;
      $last=150;
      for($i=0;$i<$taille;$i++){
        if($selectedCard>$tabMaxPile[$i]){
          $diff=$selectedCard-$tabMaxPile[$i];
          if($diff<$last){
            $aux=$tabMaxPile[$i];
            $last=$diff;
          }
        }
      }
      $sql="SELECT Id_Pile FROM etre_dans WHERE id_carte='".$aux."'";
      $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
      $sql->execute();
      $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
      $res=$res_req->Id_Pile;
      return($res);
    }

    public static function relatedIndex($maxOfPile, $index_closest,$taille){
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
        $sql='INSERT INTO `etre_dans` (`Id_Pile`, `Id_Carte`) VALUES ('.$indexPile.', '.$selectedCard.')';
        $sql=DatabasePDO::getCurrentPDO()->query($sql);
      }
      else{
        $somme=0;
        $array_cards_pile=[];
        $numberInPile=0;
        $array_cards_pile = $this::getCardsOfPile($indexPile);
        $numberInPile = $this::numberOfCardsInPile($indexPile);
        $sql="SELECT Poids FROM Carte WHERE id_carte='".$array_cards_pile[$i]."'";
        $sql=DatabasePDO::getCurrentPDO()->prepare($sql);
        $sql->execute();
        // TODO : Delete cards in pile
        // And add the new first card in pile
        for($i=0;$i<$numberInPile;$i++){
          $res_req=$sql->fetch(DatabasePDO::FETCH_OBJ);
          $somme+=$res_req->Poids;
        }
        $sql_score='UPDATE score SET Val_Score = '.$somme.' WHERE Id_Plat = '.$id_plat.' AND Pseudo ='.$pseudo.'';
        $sql_score=DatabasePDO::getCurrentPDO()->query($sql_score);
      }
    }

    public static function suppressCardsHand($selectedCard, $id_plat,$pseudo){
      $sql_delete_selected='UPDATE main SET Id_Selected_Card = -1 WHERE Id_Plat = '.$id_plat.' AND Pseudo ='.$pseudo.'';
      $sql_delete_selected=DatabasePDO::getCurrentPDO()->query($sql_delete_selected);
      // TODO TEST : numeroInHand
      $numeroInHand=$this::numeroInHand($selectedCard);
      // TODO TEST : numberInHand
      $numberInHand=$this::numberInHand($pseudo,$id_plat);
      $sql_delete_card='UPDATE main SET Id_Carte'.$numeroInHand.' = -1 WHERE Id_Plat = '.$id_plat.' AND Pseudo ='.$pseudo.'';
      $sql_delete_card=DatabasePDO::getCurrentPDO()->query($sql_delete_card);
      $number_rest= $numberInHand-1;
      $sql_number_hand='UPDATE main SET Nb_Carte_Main = '.$number_rest.' WHERE Id_Plat = '.$id_plat.' AND Pseudo ='.$pseudo.'';
      $sql_number_hand=DatabasePDO::getCurrentPDO()->query($sql_number_hand);
    }

  }
    require_once('sql/Game.sql.php');
 ?>

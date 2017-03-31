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
        if($data->estCommence=-1){
          if($data->nb_joueurs<10){
            $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO `jouer`(`ID_PLAT`,`PSEUDO`,`SCORE`) VALUES (:plat,:joueur,0)');
            $sql_req->bindParam(':plat',$id_plat);
            $sql_req->bindParam(':joueur',$login);
            $sql_req->execute();
            return(true);
          }
        }
      else {
        return(false);
        }
      }
    }
  }
    require_once('sql/Game.sql.php');
 ?>

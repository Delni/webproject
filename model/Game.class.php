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

    public static function userIsallowed($login,$id_plat){
      $sql="SELECT COUNT(PSEUDO)as nb_joueurs, estCommencee FROM jouer LEFT JOIN Plateau USING Id_plat WHERE id_plat='".$id_plat."'";
      $sql2="SELECT PSEUDO FROM jouer WHERE pseudo='".$login."' AND id_plat='".$id_plat."'";
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql);
      $data= $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      $res_sql2=DatabasePDO::getCurrentPDO()->query($sql2);
      $data2= $res_sql2->fetch(DatabasePDO::FETCH_OBJ);
      if($data->nb_joueurs<10){
        
      } else {

      }
    }
  }
 ?>

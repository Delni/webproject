<?php
  class User extends Model {
    protected $local_login;

    public function __construct($login) {
      $this->local_login=$login;
    }

    public static function isLoginUsed($login){
      $sql_req='SELECT PSEUDO FROM joueur WHERE PSEUDO=\'' . $login . '\'';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      return !empty($data);
    }

    public static function eMailexist($email){
      $sql_req='SELECT Email FROM joueur WHERE Email=\'' . $email . '\'';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      return !empty($data);
    }

    public static function create($login, $password,$mail,$nom,$prenom){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare("INSERT INTO `joueur` (`PSEUDO`,`MDP`, `NOM`, `PRENOM`, `EMAIL`, `DATE_CREATION`,`PERDUES`,`GAGNEES`) VALUES (:login,:psw,:name,:fname,:mail,:today,0,0)");
      $login = strreplace("'","\'",$login);
      $sql_req->bindParam(':login',$login);
      $sql_req->bindParam(':psw',$password);
      $sql_req->bindParam(':name',$nom);
      $sql_req->bindParam(':fname',$prenom);
      $sql_req->bindParam(':mail',$mail);
      $today=date("Y-m-d");
      $sql_req->bindParam(':today',$today);
      //Execute full request
      $sql_req->execute();
      //return User object
      return new static($login);
    }

    public static function createGame($nom_plat,$mdp_prive,$login){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO plateau(Nom, Createur, Prive) VALUES (:nom_plat,:createur,:mdp_prive)');
      $sql_req->bindParam(':nom_plat',$nom_plat);
      $sql_req->bindParam(':createur',$login);
      $sql_req->bindParam(':mdp_prive',$mdp_prive);
      $sql_req->execute();
      // Get the last id :
      $sql_req='SELECT Id_plat FROM plateau ORDER BY Id_plat DESC';
      $res_sql=DataBasePDO::getCurrentPDO()->query($sql_req);
      $res = $res_sql->fetch(DataBasePDO::FETCH_OBJ);
      $id_plat=$res->Id_plat;
      //Add createur into joueur
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO jouer(Id_Plat,Pseudo) VALUES (:id_plat,:login)');
      $sql_req->bindParam(':id_plat',$id_plat);
      $sql_req->bindParam(':login',$login);
      $sql_req->execute();
      //Create Piles from this ID
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO pile(Id_plat) VALUES (:id_plat),(:id_plat),(:id_plat),(:id_plat)');
      $sql_req->bindParam(':id_plat',$id_plat);
      $sql_req->execute();
      //return current game's ID
      return $id_plat;
    }

    //TODO : add image into updating
    public static function updateProfile($nom, $prenom,$mail, $pays, $id){
      $sql_req=DatabasePDO::getCurrentPDO()->prepare('UPDATE joueur SET Nom = :nom WHERE Pseudo="'.$id.'"');
      $sql_req->bindParam(':nom',$nom);
      $sql_req->execute();
      $sql_req=DatabasePDO::getCurrentPDO()->prepare('UPDATE joueur SET Prenom = :prenom WHERE Pseudo="'.$id.'"');
      $sql_req->bindParam(':prenom',$prenom);
      $sql_req->execute();
      if($mail!= NULL){
        $sql_req=DatabasePDO::getCurrentPDO()->prepare('UPDATE joueur SET Email = :mail WHERE Pseudo="'.$id.'"');
        $sql_req->bindParam(':mail',$mail);
        $sql_req->execute();
      }
      if($pays!= NULL){
        $sql_req=DatabasePDO::getCurrentPDO()->prepare('UPDATE joueur SET Pays = :pays WHERE Pseudo="'.$id.'"');
        $sql_req->bindParam(':pays',$pays);
        $sql_req->execute();
      }
    }

    public function updatePassWord($lastpw, $newpw){
      if($this->getX('MdP')==$lastpw){
        $sql_req=DatabasePDO::getCurrentPDO()->prepare('UPDATE joueur SET MdP = :mdp WHERE Pseudo="'.$this->get_id().'"');
        $sql_req->bindParam(':mdp',$newpw);
        $sql_req->execute();
        return(true);
      }
      return(false);
    }

    public function getX($var){
      $sql_req='SELECT '. $var . ' FROM joueur WHERE PSEUDO=\'' . $this->local_login . '\'';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      return $data->$var;
    }

    public function getAllInfo(){
      $sql_req='SELECT * FROM joueur WHERE PSEUDO=\'' . $this->local_login . '\'';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetchAll(DatabasePDO::FETCH_OBJ);
      return $data;
    }

    public function set_id($str){
      $this->local_login=$str;
    }
    public function get_id(){
      return $this->local_login;
    }

    public function getRatio(){
      $victoires=(int) $this->getX('GAGNEES');
      $defaites=(int) $this->getX('PERDUES');
      $bouclage=($victoires==0 || $defaites==0)?false:true;
      while ($bouclage){
        $bouclage = false;
        if ($victoires%9 == 0 && $defaites%9==0 && !$bouclage){
          $victoires=$victoires/9;
          $defaites=$defaites/9;
          $bouclage = true;
        }
        elseif ($victoires%8 == 0 && $defaites%8==0 && !$bouclage) {
          $victoires=$victoires/8;
          $defaites=$defaites/8;
          $bouclage = true;
        }
        elseif ($victoires%7 == 0 && $defaites%7==0 && !$bouclage) {
          $victoires=$victoires/7;
          $defaites=$defaites/7;
          $bouclage = true;
        }
        elseif ($victoires%6 == 0 && $defaites%6==0 && !$bouclage) {
          $victoires=$victoires/6;
          $defaites=$defaites/6;
          $bouclage = true;
        }
        elseif ($victoires%5 == 0 && $defaites%5==0 && !$bouclage) {
          $victoires=$victoires/5;
          $defaites=$defaites/5;
          $bouclage = true;
        }
        elseif ($victoires%4 == 0 && $defaites%4==0 && !$bouclage) {
          $victoires=$victoires/4;
          $defaites=$defaites/4;
          $bouclage = true;
        }
        elseif ($victoires%3 == 0 && $defaites%3==0 && !$bouclage) {
          $victoires=$victoires/3;
          $defaites=$defaites/3;
          $bouclage = true;
        }
        elseif ($victoires%2 == 0 && $defaites%2==0 && !$bouclage) {
          $victoires=$victoires/2;
          $defaites=$defaites/2;
          $bouclage = true;
        }
      }
      return $victoires." : ".$defaites;
    }

    public function getRidOfComas($str){

    }


    public function distributeCards($id_plat){
    $sql_req=DataBasePDO::getCurrentPDO()->prepare('UPDATE plateau SET estCommence = 0 WHERE Id_Plat = "'.$this->$id_plat.'"');
    $sql_req->execute();
    $card_array = Array();
    for ($i=1;$i<105;$i++){
      $card_array[$i-1]=$i;;
      }
    $sql_count="SELECT COUNT(PSEUDO)as nb_joueurs FROM jouer WHERE id_plat='".$this->$id_plat."'";
    $res_count=DatabasePDO::getCurrentPDO()->query($sql_count);
    $count_j= $res_count->fetch(DatabasePDO::FETCH_OBJ);
    $sql_req='SELECT Pseudo FROM Jouer WHERE id_plat="'.$id_plat.'"';
    $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
    $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
    $compteur=0;
    $k=0;
    $compt_num_j=0;
    $res_array=Array();
    while(!(empty($data))&&$compteur<104){
      $newarray=Array();
      for($k=0;$k<10;$k++){
        $aleat = aleat($card_array);
        $newarray[$k]=$aleat;
        $card_array = suppr($card_array,$aleat);
        $compteur++;
        $sql_main=DataBasePDO::getCurrentPDO()->prepare('UPDATE main SET Id_Carte"'.$k.'" = "'.$aleat.'" WHERE Pseudo = "'.$data->Pseudo.'" AND Id_Plat =  "'.$id_plat.'"');
        $sql_main->execute();
      }
      $res_array[$compt_num_j][0]=$data->Pseudo;
      $res_array[$compt_num_j][1]=$newarray;
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
    }
    return($res_array);
  }

  public function aleat($array){
    $max=count($array);
    return ($array[rand(0,$max-1)]);
  }

  public function position($array,$element){
    $i=0;
    $pos = -1;
    while($pos==-1 && $i<count($array)-1){
      if($array[$i]==$element){
        $pos=$i;
      }
    }
    return ($pos);
  }

  public function suppr($array, $element){
    $edge = position($array,$element);
    $res=array();
    for($i=0;$i<$edge;$i++){
      array_push($res,$array[$i]);
    }
    for($k=$edge+1;$k<count($array)-1;$k++){
      array_push($res,$array[$k]);
    }
  }
}
 ?>

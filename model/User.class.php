<?php
  class User extends Model {
    protected $local_login;

    public function __construct($login) {
      $this->local_login=$login;
    }

    public static function isLoginUsed($login){
      $data = static::exec_sql('USER_LOGIN_USED',array(':login' => $login));
      return !empty($data);
    }

    public static function eMailexist($email){
      $data=static::exec_sql('USER_EMAIL_EXIST',array(':email' => $email));
      return !empty($data);
    }

    public static function create($login, $password,$mail,$nom,$prenom){
      $today=date("Y-m-d");
      $data = static::exec_sql('USER_CREATE_ACCOUNT', array(
        ':login'=>$login,
        ':psw'  =>$password,
        ':name' =>$nom,
        ':fname'=>$prenom,
        ':mail' =>$mail,
        ':today'=>$today));
      //return User object
      return new static($login);
    }

    public static function createGame($nom_plat,$mdp_prive,$login){
      $data = static::exec_sql('USER_CREATE_GAME',array(
        ':nom_plat' =>$nom_plat,
        ':createur' =>$login,
        ':mdp_prive'=>$mdp_prive));
      // Get the last id :
      $data = static::exec_sql('USER_GET_ID_PLATEAU',array());
      $id_plat=$data->Id_plat;
      //Add createur into joueur
      $data = static::exec_sql('USER_LINK_PLAYER_PLAYGROUND',array(
        ':id_plat'=>$id_plat,
        ':login'  =>$login));
      //Create Piles from this ID
      $data=static::exec_sql('USER_LINK_PILE_PLAYGROUND',array(
        ':id_plat' => $id_plat));
      //return current game's ID
      return $id_plat;
    }

    //TODO : add image into updating
    public static function updateProfile($nom, $prenom,$mail, $pays, $id){
      $data=static::exec_sql('USER_UPDATE_NAME',array(
        ':nom'=>$nom,
        ':id' =>$id
      ));
      $data=static::exec_sql('USER_UPDATE_FNAME',array(
        ':prenom'=>$prenom,
        ':id' =>$id
      ));
      if($mail!= NULL){
        $data=static::exec_sql('USER_UPDATE_EMAIL',array(
          ':mail'=>$mail,
          ':id' =>$id
        ));
      }
      if($pays!= NULL){
        $data=static::exec_sql('USER_UPDATE_COUNTRY',array(
          ':pays'=>$pays,
          ':id' =>$id
        ));
      }
    }

    public function updatePassWord($lastpw, $newpw){
      if($this->getX('MdP')==$lastpw){
        $data=static::exec_sql('USER_UPDATE_COUNTRY',array(
          ':mdp'=>$newpw,
          ':id'  =>$this->get_id()
        ));
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
      $sql_req=DatabasePDO::getCurrentPDO()->prepare('SELECT * FROM joueur WHERE Pseudo=:login');
      $sql_req->execute(array(
        ':login'=>$this->local_login
      ));
      return $sql_req->fetchAll(DatabasePDO::FETCH_OBJ);
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


      public static function aleat($array){
        $max=count($array);
        return ($array[rand(0,$max-1)]);
      }

      public static function position($array,$element){
        $i=0;
        $pos = -1;
        while($pos==-1 && $i<count($array)-1){
          if($array[$i]==$element){
            $pos=$i;
          }
        $i++;
        }
        return ($pos);
      }

      public static function suppr($array, $element){
        $edge = User::position($array,$element);
        $res=array();
        for($i=0;$i<$edge;$i++){
          array_push($res,$array[$i]);
        }
        for($k=$edge+1;$k<count($array);$k++){
          array_push($res,$array[$k]);
        }
        return($res);
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

  // SQL TO REFACTOR
    public static function playgame($id_plat, $pseudo){
      $array=[];
      for ($i=1;$i<11;$i++){
        $sql_req='SELECT Id_Carte'.$i.' AS Id_Carte FROM Main WHERE id_plat="'.$id_plat.'" AND Pseudo = "'.$pseudo.'"';
        $sql_req=DatabasePDO::getCurrentPDO()->prepare($sql_req);
        $sql_req->execute();
        $res=$sql_req->fetch(DatabasePDO::FETCH_OBJ);
        $array[$i]= $res->Id_Carte;
      }
      return ($array);
    }
  }

  require_once('sql/User.sql.php');
 ?>

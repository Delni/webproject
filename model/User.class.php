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
      $sql_req=DataBasePDO::getCurrentPDO()->prepare("INSERT INTO `joueur` (`PSEUDO`,`MDP`, `NOM`, `PRENOM`, `EMAIL`, `DATE_CREATION`,`PERDUES`,`GAGNEES`) VALUES (:login,:psw,:name,:fname,:mail,:today,0,0)");
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
          ':pays'=>$pays,
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

  }
  require_once('sql/User.sql.php');
 ?>

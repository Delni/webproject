<?php
  class User extends Model {

    /**
    *
    *   User model is used to handle every action which are necessary for the user
    *
    *   Functions:


    *    ,ad8888ba,
    *   d8"'    `"8b                ,d       ,d
    *  d8'                          88       88
    *  88              ,adPPYba,  MM88MMM  MM88MMM  ,adPPYba,  8b,dPPYba,  ,adPPYba,
    *  88      88888  a8P_____88    88       88    a8P_____88  88P'   "Y8  I8[    ""
    *  Y8,        88  8PP"""""""    88       88    8PP"""""""  88           `"Y8ba,
    *   Y8a.    .a88  "8b,   ,aa    88,      88,   "8b,   ,aa  88          aa    ]8I
    *    `"Y88888P"    `"Ybbd8"'    "Y888    "Y888  `"Ybbd8"'  88          `"YbbdP"'


    *   @getX                 (string)      -> Returns string according to the given variable.
    *   @getAllInfo           (Object)      -> Retunrs all info related to a player.
    *   @get_id               (int)         -> Returns variable local_login.


    *    ad88888ba
    *  d8"     "8b                ,d       ,d
    *  Y8,                        88       88
    *  `Y8aaaaa,     ,adPPYba,  MM88MMM  MM88MMM  ,adPPYba,  8b,dPPYba,
    *    `"""""8b,  a8P_____88    88       88    a8P_____88  88P'   "Y8
    *          `8b  8PP"""""""    88       88    8PP"""""""  88
    *  Y8a     a8P  "8b,   ,aa    88,      88,   "8b,   ,aa  88
    *   "Y88888P"    `"Ybbd8"'    "Y888    "Y888  `"Ybbd8"'  88

    *   @set_id               (array)       -> Sets the variable local_id.


    * 8888888888888888
    *        88                           ,d
    *        88                           88
    *        88   ,adPPYba,  ,adPPYba,  MM88MMM  ,adPPYba,  8b,dPPYba,  ,adPPYba,
    *        88  a8P_____88  I8[    ""    88    a8P_____88  88P'   "Y8  I8[    ""
    *        88  8PP"""""""   `"Y8ba,     88    8PP"""""""  88           `"Y8ba,
    *        88  "8b,   ,aa  aa    ]8I    88,   "8b,   ,aa  88          aa    ]8I
    *        88   `"Ybbd8"'  `"YbbdP"'    "Y888  `"Ybbd8"'  88          `"YbbdP"'


    *   @isLoginUsed          (boolean)     -> Checks wether or not the login is already used.
    *   @eMailexist           (boolean)     -> Checks wether or not the SQL table has the given mail.


    *   88b           d88  88
    *   888b         d888  ""
    *   88`8b       d8'88
    *   88 `8b     d8' 88  88  ,adPPYba,   ,adPPYba,
    *   88  `8b   d8'  88  88  I8[    ""  a8"     ""
    *   88   `8b d8'   88  88   `"Y8ba,   8b
    *   88    `888'    88  88  aa    ]8I  "8a,   ,aa
    *   88     `8'     88  88  `"YbbdP"'   `"Ybbd8"'


    *   @getRatio             (string)      -> Returns a string giving the numbers of victories and defeats.
    *   @aleat                (int)         -> Returns a random integer in the given array of integers.
    *   @position             (int)         -> Returns the position of a given element in the given array.
    *   @suppr                (array)       -> Suppresses the given element in the given array.
    *   @replace              (array)       -> Replaces the given element in the given array by the other given element.


    *   88888888ba                              ad88  88  88
    *   88      "8b                            d8"    ""  88
    *   88      ,8P                            88         88
    *   88aaaaaa8P'  8b,dPPYba,   ,adPPYba,  MM88MMM  88  88   ,adPPYba,
    *   88""""""'    88P'   "Y8  a8"     "8a   88     88  88  a8P_____88
    *   88           88          8b       d8   88     88  88  8PP"""""""
    *   88           88          "8a,   ,a8"   88     88  88  "8b,   ,aa
    *   88           88           `"YbbdP"'    88     88  88   `"Ybbd8"'


    *   @create               (Object User) -> Creates the account in the SQL table "Joueur".
    *   @updateProfile        (void)        -> Updates the profile in SQL table.
    *   @updatePassWord       (boolean)     -> Updates the password in SQL table.


    *   88888888ba   88
    *   88      "8b  88
    *   88      ,8P  88
    *   88aaaaaa8P'  88  ,adPPYYba,  8b       d8
    *   88""""""'    88  ""     `Y8  `8b     d8'
    *   88           88  ,adPPPPP88   `8b   d8'
    *   88           88  88,    ,88    `8b,d8'
    *   88           88  `"8bbdP"Y8      Y88'
    *                                    d8'
    *                                   d8'


    *   @createGame           (int)         -> Creates the game with all the parameters the user gave, adding the creator to this new game's player. It also creates the piles for this game.
    *   @playgame             (array)       -> Returns array with all the cards in the hand of the given player in the given game.
    *   @selectCard           (void)        -> Updates SQL table according to the card that has been selected.
    **/

    protected $local_login;

    public function __construct($login) {
      $this->local_login=$login;
    }

    /*
    *    ,ad8888ba,
    *   d8"'    `"8b                ,d       ,d
    *  d8'                          88       88
    *  88              ,adPPYba,  MM88MMM  MM88MMM  ,adPPYba,  8b,dPPYba,  ,adPPYba,
    *  88      88888  a8P_____88    88       88    a8P_____88  88P'   "Y8  I8[    ""
    *  Y8,        88  8PP"""""""    88       88    8PP"""""""  88           `"Y8ba,
    *   Y8a.    .a88  "8b,   ,aa    88,      88,   "8b,   ,aa  88          aa    ]8I
    *    `"Y88888P"    `"Ybbd8"'    "Y888    "Y888  `"Ybbd8"'  88          `"YbbdP"'
    */

    public function getX($var){
      $sql_req='SELECT '. $var . ' FROM joueur WHERE PSEUDO="' . $this->local_login . '"';
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

    public function get_id(){
      return $this->local_login;
    }

    /*
    *    ad88888ba
    *  d8"     "8b                ,d       ,d
    *  Y8,                        88       88
    *  `Y8aaaaa,     ,adPPYba,  MM88MMM  MM88MMM  ,adPPYba,  8b,dPPYba,
    *    `"""""8b,  a8P_____88    88       88    a8P_____88  88P'   "Y8
    *          `8b  8PP"""""""    88       88    8PP"""""""  88
    *  Y8a     a8P  "8b,   ,aa    88,      88,   "8b,   ,aa  88
    *   "Y88888P"    `"Ybbd8"'    "Y888    "Y888  `"Ybbd8"'  88
    */

    public function set_id($str){
      $this->local_login=$str;
    }

    /*
    * 8888888888888888
    *        88                           ,d
    *        88                           88
    *        88   ,adPPYba,  ,adPPYba,  MM88MMM  ,adPPYba,  8b,dPPYba,  ,adPPYba,
    *        88  a8P_____88  I8[    ""    88    a8P_____88  88P'   "Y8  I8[    ""
    *        88  8PP"""""""   `"Y8ba,     88    8PP"""""""  88           `"Y8ba,
    *        88  "8b,   ,aa  aa    ]8I    88,   "8b,   ,aa  88          aa    ]8I
    *        88   `"Ybbd8"'  `"YbbdP"'    "Y888  `"Ybbd8"'  88          `"YbbdP"'
    */

    public static function isLoginUsed($login){
      $data = static::exec_sql('USER_LOGIN_USED',array(':login' => $login));
      return !empty($data);
    }

    public static function eMailexist($email){
      $data=static::exec_sql('USER_EMAIL_EXIST',array(':email' => $email));
      return !empty($data);
    }

    /*
    *   88b           d88  88
    *   888b         d888  ""
    *   88`8b       d8'88
    *   88 `8b     d8' 88  88  ,adPPYba,   ,adPPYba,
    *   88  `8b   d8'  88  88  I8[    ""  a8"     ""
    *   88   `8b d8'   88  88   `"Y8ba,   8b
    *   88    `888'    88  88  aa    ]8I  "8a,   ,aa
    *   88     `8'     88  88  `"YbbdP"'   `"Ybbd8"'
    */

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

    public static function replace($array, $element, $elementtoAdd){
      $edge = User::position($array,$element);
      $res=array();
      for($i=0;$i<$edge;$i++){
        array_push($res,$array[$i]);
      }
      $res[$edge]=$elementtoAdd;
      for($k=$edge+1;$k<count($array);$k++){
        array_push($res,$array[$k]);
      }
      return($res);
    }

    /*
    *   88888888ba                              ad88  88  88
    *   88      "8b                            d8"    ""  88
    *   88      ,8P                            88         88
    *   88aaaaaa8P'  8b,dPPYba,   ,adPPYba,  MM88MMM  88  88   ,adPPYba,
    *   88""""""'    88P'   "Y8  a8"     "8a   88     88  88  a8P_____88
    *   88           88          8b       d8   88     88  88  8PP"""""""
    *   88           88          "8a,   ,a8"   88     88  88  "8b,   ,aa
    *   88           88           `"YbbdP"'    88     88  88   `"Ybbd8"'
    */

    public static function create($login, $password,$mail,$nom,$prenom){
      $today=date("Y-m-d");
      $data = static::exec_sql('USER_CREATE_ACCOUNT', array(
        ':login'=>$login,
        ':psw'  =>$password,
        ':name' =>$nom,
        ':fname'=>$prenom,
        ':mail' =>$mail,
        ':today'=>$today));
      return new static($login);
    }

    public static function updateProfile($nom, $prenom,$mail, $pays, $img, $id){
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
      if($img!=NULL){
        $data=static::exec_sql('USER_UPDATE_IMAGE',array(
          ':img'=>$img,
          ':id'=>$id
        ));
      }
    }

    public function updatePassWord($lastpw, $newpw){
      if($this->getX('MdP')==$lastpw){
        $data=static::exec_sql('USER_UPDATE_PASSWORD_BY_ID',array(
          ':mdp'=>$newpw,
          ':id'  =>$this->get_id()
        ));
        return(true);
      }
      return(false);
    }

    /*
    *   88888888ba   88
    *   88      "8b  88
    *   88      ,8P  88
    *   88aaaaaa8P'  88  ,adPPYYba,  8b       d8
    *   88""""""'    88  ""     `Y8  `8b     d8'
    *   88           88  ,adPPPPP88   `8b   d8'
    *   88           88  88,    ,88    `8b,d8'
    *   88           88  `"8bbdP"Y8      Y88'
    *                                    d8'
    *                                   d8'
    */

    public static function createGame($nom_plat,$mdp_prive,$login){
      $data = static::exec_sql('USER_CREATE_GAME',array(
        ':nom_plat' =>$nom_plat,
        ':createur' =>$login,
        ':mdp_prive'=>$mdp_prive));
      $data = static::exec_sql('USER_GET_ID_PLATEAU',array());
      $id_plat=$data->Id_plat;
      $data = static::exec_sql('USER_LINK_PLAYER_PLAYGROUND',array(
        ':id_plat'=>$id_plat,
        ':login'  =>$login));
      $data=static::exec_sql('USER_LINK_PILE_PLAYGROUND',array(
        ':id_plat' => $id_plat));
      return $id_plat;
    }

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

    public static function selectCard($pseudo, $id_plat, $id_selected){
      $sql_select_card= "UPDATE Main SET Id_Selected_Card = '".$id_selected."' WHERE Id_plat='".$id_plat."' AND Pseudo='".$pseudo."'";
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_select_card);
    }
  }
  require_once('sql/User.sql.php');
 ?>

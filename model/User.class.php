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

    public static function create($login, $password,$mail,$nom,$prenom){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO `joueur` (`PSEUDO`,`DATE_CREATION`, `NOM`, `PRENOM`, `MAIL`, `MDP`) VALUES (:login,:today,:name,:fname,:mail,:psw)');
      $sql_req->bindParam(':login',$login);
      $today=date("Y-m-d");
      $sql_req->bindParam(':today',$today);
      $sql_req->bindParam(':name',$nom);
      $sql_req->bindParam(':fname',$prenom);
      $sql_req->bindParam(':mail',$mail);
      $sql_req->bindParam(':psw',$password);
      //Execute full request
      $sql_req->execute();
      //return User object
      return new static($login);
    }

    public function getX($var){
      $sql_req='SELECT '. $var . ' FROM joueur WHERE PSEUDO=\'' . $this->local_login . '\'';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      return $data->$var;
    }

    public function set_id($str){
      $this->local_login=$str;
    }
    public function get_id(){
      return $this->local_login;
    }

  }
 ?>

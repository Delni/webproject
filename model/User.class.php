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
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO `joueur` (`PSEUDO`,`MDP`, `NOM`, `PRENOM`, `EMAIL`, `DATE_CREATION`,`PERDUES`,`GAGNEES`) VALUES (:login,:psw,:name,:fname,:mail,:today,0,0)');
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

  }
 ?>

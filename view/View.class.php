<?php
  class View extends MyObject {
    protected $user;
    protected $controller;
    protected $args=array();

    public function __construct($controller) {
      if(isset($_SESSION['user']))
        $this->user = unserialize($_SESSION['user']);
      $this->controller = $controller;
    }

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function setArg($key,$value){
      $this->args[$key] = $value;
    }

    public function getGameList($id=NULL, $hist=false){
      if ($id==NULL) {
        $sql_req='SELECT nom, createur, COUNT(Pseudo)AS nb_joueurs FROM Plateau LEFT JOIN jouer ON Plateau.Id_plat=jouer.Id_Plat GROUP BY plateau.Id_plat ORDER BY plateau.Id_plat';
      } elseif($hist==true) {
        $sql_req='';
      } else {
        $sql_req='SELECT nom, createur, nb_joueurs FROM Plateau
                  LEFT JOIN jouer ON Plateau.Id_plat=jouer.Id_Plat
                  LEFT JOIN (SELECT plateau.Id_plat, COUNT(Pseudo) AS nb_joueurs FROM Plateau LEFT JOIN jouer ON Plateau.Id_plat=jouer.Id_Plat GROUP BY plateau.Id_plat ORDER BY plateau.Id_plat) AS subTB ON Plateau.Id_plat=subTB.Id_Plat
                  WHERE Pseudo="'. $id .'" GROUP BY plateau.Id_plat ORDER BY plateau.Id_plat';
      }

      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      while(!empty($data)) {
        echo '
          <tr>
            <th scope="row">'. $data->nom .'</th>
            <td>'. $data->createur .'</td>
            <td>'. $data->nb_joueurs.'/10</td>
            <td><a class="btn btn-success pull-right">Rejoindre</a></td>
          </tr>';
        $data = $res_sql->fetch(PDO::FETCH_OBJ);
      }
    }
  }
 ?>

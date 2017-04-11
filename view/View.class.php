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
        $sql_req='SELECT plateau.id_plat, nom as Nom, createur, prive, COUNT(Pseudo)AS nb_joueurs
                  FROM Plateau LEFT JOIN jouer ON Plateau.Id_plat=jouer.Id_Plat
                  GROUP BY plateau.Id_plat ORDER BY plateau.Id_plat';
      } elseif($hist) {
        $sql_req='SELECT Nom, Score, Score_Gagnant, Nom_Gagnant FROM `historique` WHERE Pseudo="'.$id.'"';
      } else {
        $sql_req='SELECT plateau.id_plat, nom as Nom, createur, prive, nb_joueurs FROM Plateau
                  LEFT JOIN jouer ON Plateau.Id_plat=jouer.Id_Plat
                  LEFT JOIN (SELECT plateau.Id_plat, COUNT(Pseudo) AS nb_joueurs FROM Plateau LEFT JOIN jouer ON Plateau.Id_plat=jouer.Id_Plat GROUP BY plateau.Id_plat ORDER BY plateau.Id_plat) AS subTB ON Plateau.Id_plat=subTB.Id_Plat
                  WHERE Pseudo="'. $id .'" GROUP BY plateau.Id_plat ORDER BY plateau.Id_plat';
      }
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);

      //$fourth_col = ($hist)? '' : '<td><div class="row"><a class="btn btn-success">Rejoindre</a><input class="form-control" type="password" placeholder="MdP" disabled="" /></div></td>';
      while(!empty($data)) {
        if($hist){
          $status=($data->Nom_Gagnant == $id)? '<span class="label label-success">Victoire !</span>': '<span class="label label-warning">Défaite...</span>';
        } else {
          $placeholder=($data->prive==NULL)?'Pas de mot de passe':'Entrez le mot de passe';
          $isPrivate=($data->prive==NULL)?'disabled="true"':'required';
          $status =$data->createur;
        }
        $third_col = ($hist) ? '<td>'. $data->Score.'</td>' : '<td>'. $data->nb_joueurs.'/10</td>' ;
        $fourth_col = ($hist)? '<td>'.$data->Nom_Gagnant.'</td>' : '
        <td>
          <form class="form-horizontal" method="post" action="index.php?action=joinGame">
            <div class="col-lg-12">
              <div class="input-group">
                <input type="password" id="psw_plat" name="psw_plat" class="form-control mdp-ctrl" placeholder="'.$placeholder.'" '. $isPrivate .'>
                <input type="text" class="id_plat_input" name="id_plat" id="id_plat" value="'.$data->id_plat.'" />
                <span class="input-group-btn">
                  <input type="submit" class="btn btn-success" value="Rejoindre">
                </span>
              </div>
            </div>
          </form>
        </td>';
        $fith_col = ($hist)? '<td>'.$data->Score_Gagnant.'</td>' : '';
        echo '
          <tr>
            <th scope="row">'. $data->Nom .'</th>
            <td>'. $status .'</td>'.
            $third_col . $fourth_col.$fith_col.'
          </tr>';
        $data = $res_sql->fetch(PDO::FETCH_OBJ);
      }
    }
  }
 ?>

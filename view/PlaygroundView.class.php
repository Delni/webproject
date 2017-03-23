<?php
  class PlaygroundView extends View {
    protected $id_plat;
    public $own_controller;

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/PlaygroundTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function setOwnController($controller){
      $this->own_controller=$controller;
    }

    public function setIdPlat($id){
      $this->id_plat=$id;
    }

    public function getIdPlat(){
      return $this->id_plat;
    }

    public function print_log(){
      $sql_req='SELECT html FROM log WHERE id_plat="'.$this->id_plat.'"';
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      while(!empty($data)) {
        echo $data->html;
        $data = $res_sql->fetch(PDO::FETCH_OBJ);
      }
    }

    public function lauchGame(){
      $sql_req='SELECT Createur, estCommence, COUNT(pseudo)AS nb_joueurs FROM Plateau LEFT JOIN jouer USING (Id_plat) WHERE id_plat='.$this->id_plat;
      $res_sql=DatabasePDO::getCurrentPDO()->query($sql_req);
      $data = $res_sql->fetch(DatabasePDO::FETCH_OBJ);
      if((unserialize($_SESSION['user'])->get_id()==$data->Createur) && ($data->estCommence==-1)){
        echo '<div class="row text-center"><a type="button" class="btn btn-success" href="index.php?action=distributeCards&id='.$this->id_plat.'" >Lancer le jeu ('.$data->nb_joueurs.'/10 joueurs)</a></div><hr>';
      } else {
        echo '<div class="row text-center">La partie est commencée</div><hr>';
      }
    }

    public function setLog($id_plat,$html_content){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO log(Id_plat, html) VALUES (:id,:html_content)');
      $sql_req->bindParam(':id',$id_plat);
      $sql_req->bindParam(':html_content',$html_content);
      $sql_req->execute();
    }
  }
 ?>

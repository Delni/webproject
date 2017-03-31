<?php
  class PlaygroundView extends View {
    protected $id_plat;
    protected $own_controller;
    protected $liste_cartes;
    protected $selected_card=NULL;
    protected $pile_cartes=NULL;

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/PlaygroundTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function setOwnController($controller){
      $this->own_controller=$controller;
    }

    public function getOwnController(){
      return $this->own_controller;
    }

    public function setPileCartes($array){
      $this->pile_cartes=$array;
    }

    public function getPileCartes(){
      return $this->pile_cartes;
    }

    public function setSelectedCard($int){
      $this->selected_card=$int;
    }

    public function getSelectedCard(){
      return $this->selected_card;
    }

    public function setListeCartes($array){
      $this->liste_cartes=$array;
    }

    public function getListeCartes(){
      return $this->liste_cartes;
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
      if ($data->estCommence==-1) {
        if((unserialize($_SESSION['user'])->get_id()==$data->Createur)){
          echo '<div class="row text-center"><a type="button" class="btn btn-success" href="index.php?action=distributeCards&id='.$this->id_plat.'" >Lancer le jeu ('.$data->nb_joueurs.'/10 joueurs)</a></div><hr>';
        }
      } else {
        echo '<div class="row"><p class="log">La partie est commencée </p></div><hr>';
      }
    }

    public function setLog($id_plat,$html_content){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO log(Id_plat, html) VALUES (:id,:html_content)');
      $sql_req->bindParam(':id',$id_plat);
      $sql_req->bindParam(':html_content',$html_content);
      $sql_req->execute();
    }

    public function showCard($num_dans_main){
      $num_card=$this->getListeCartes()[$num_dans_main];
      $offset=$this->spriteOffset($num_card);
      if ($num_card!=NULL) {
        echo '<a class="card__choosen" href="index.php?action=joinGame&id_plat='.$this->getIdPlat().'&id_card='.$num_card.'"><div class="card__content" id="card'.$num_card.'" style="background-position: '.$offset['X'].'px '.$offset['Y'].'px"></div></a>';
      }
    }

    public function spriteOffset($num){
      $X_offset = ($num >=100) ? -86*($num%100-1) : -86*($num%10-1);
      $Y_offset = ($num%10==0) ? -133.5*(int)($num/10-1) : -133.5*(int)($num/10);
      return array(
        "X"=>$X_offset,
        "Y"=>$Y_offset
      );
    }

  }
 ?>

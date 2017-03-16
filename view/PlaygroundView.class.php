<?php
  class PlaygroundView extends View {
    protected $id_plat;

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/PlaygroundTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function setIdPlat($id){
      $this->id_plat=$id;
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

    public function setLog($id_plat,$html_content){
      $sql_req=DataBasePDO::getCurrentPDO()->prepare('INSERT INTO log(Id_plat, html) VALUES (:id,:html_content)');
      $sql_req->bindParam(':id',$id_plat);
      $sql_req->bindParam(':html_content',$html_content);

      $sql_req->execute();
    }
  }
 ?>
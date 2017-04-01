<?php
  class EditeView extends View {
    protected $user_data=array();

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/editProfileTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function setArgs($key,$value){
        $this->user_data[$key]=$value;
        // var_dump($this->user_data);
    }

    public function input_fname(){
      if(isset($this->user_data['Prenom'])){
        echo '<input class="form-control" type= "text " name="fname" id= "fname " value= "' . $this->user_data['Prenom'] .'" placeholder= "Prénom ">' ;
      }
      else {
        echo '<input class= "form-control " type= "text " name="fname" id= "fname " placeholder= "Prénom ">';
      }
    }

    public function input_name(){
      if(isset($this->user_data['Nom'])){
        echo '<input class= "form-control " type= "text "name="name" id= "name " value= "' . $this->user_data['Nom'] .'" placeholder= "Nom ">' ;
      }
      else {
        echo '<input class= "form-control " type= "text " name="name" id= "name " placeholder= "Nom ">';
      }
    }

    public function input_email(){
      if(isset($this->user_data['Email'])){
        echo '<input type= "email " class= "form-control " name="email" id= "email " value=  "' .  $this->user_data['Email'] .'" placeholder= "best.in.ISIC@mines-douai.fr ">' ;
      }
      else {
        echo '<input type= "email " class= "form-control " name="email" id= "email " placeholder= "best.in.ISIC@mines-douai.fr ">';
      }
    }

    public function isUpdate($status){
      if(isset($this->user_data['Update'.$status])){
        if($this->user_data['Update'.$status]==true){
          echo '<i class="fa fa-check fa-2x" style="color : #29b136"></i>';
        } else {
          echo '<i class="fa fa-times fa-2x" style="color : #9F2D2D"></i>';
        }
      }

    }

  }
 ?>

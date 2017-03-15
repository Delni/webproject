<?php
  class EditeView extends View {
    protected $user_data;

    public function render($controller){
      $this->user_data=$this->user->getAllInfo();
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/editProfileTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
      // var_dump($this->user_data);
    }

    public function input_fname(){
      if(isset($this->user_data['0']->Prenom)){
        echo "<input class=\"form-control\" type=\"text\" id=\"fname\" value=\"" . $this->user_data['0']->Prenom ."\" placeholder=\"Prénom\">" ;
      } else {
        echo "<input class=\"form-control\" type=\"text\" id=\"fname\" placeholder=\"Prénom\">";
      }
    }

    public function input_name(){
      if(isset($this->user_data['0']->Nom)){
        echo "<input class=\"form-control\" type=\"text\" id=\"name\" value=\"" . $this->user_data['0']->Nom ."\" placeholder=\"Nom\">" ;
      } else {
        echo "<input class=\"form-control\" type=\"text\" id=\"name\" placeholder=\"Nom\">";
      }
    }

    public function input_email(){
      if(isset($this->user_data['0']->Email)){
        echo "<input type=\"email\" class=\"form-control\" id=\"email\" value=\"" . $this->user_data['0']->Email ."\"  placeholder=\"best.in.ISIC@mines-douai.fr\">" ;
      } else {
        echo "<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"best.in.ISIC@mines-douai.fr\">";
      }
    }

  }
 ?>

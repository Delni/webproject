<?php
  class EndofGameView extends View {

    public function render($controller){
      include __ROOT_DIR.'/templates/headTemplate.php';
      include __ROOT_DIR.'/templates/menuTemplate.php';
      include __ROOT_DIR.'/templates/winningTemplate.php';
      include __ROOT_DIR.'/templates/footTemplate.php';
    }

    public function showFinalScores(){
      if(isset($this->args['winning_table'])){
        $html_content = '<p>
          <table class="table">
            <thead>
              <th>Classement</th>
              <th>Joueur</th>
              <th>Score</th>
            </thead>
            <tbody>'.
            $this->args['winning_table']
            .'</tbody>
          </table>
        </p>';
      } else {
        $html_content = '
        <div class="alert alert-warning alert-dismissible"><strong>Erreur</strong>, cette partie n\'existe (déjà) <strong>plus</strong>!</div>';
      }
      echo $html_content;
    }
  }
?>

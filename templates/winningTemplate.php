<div class="jumbotron row playground" style="overflow-x : hidden">
  <div class="row text-center">
    <h2>Fin de la partie !</h2>
  </div>
  <div class="row">
    <div class="col-md-offset-1 col-md-10">
      <p>
        <table class="table">
          <thead>
            <th>Classement</th>
            <th>Joueur</th>
            <th>Score</th>
          </thead>
          <tbody>
            <?php $this->showFinalScores(); ?>
          </tbody>
        </table>
      </p>
    </div>
  </div>
  <div class="row text-center">
    <a href="index.php?action=creation" class="btn btn-primary">Revanche !</a>
    <a href="index.php" class="btn btn-warning">Retour</a>
  </div>
</div>

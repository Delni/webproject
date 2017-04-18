<div class="jumbotron row playground" style="overflow-x : hidden">
  <div class="row text-center">
    <h1>Fin de la partie !</h1>
  </div>
  <div class="row">
    <div class="col-md-offset-1 col-md-10">
            <?php $this->showFinalScores(); ?>
    </div>
  </div>
  <div class="row text-center">
    <audio id="audio" autoplay>
      <source src="css/sounds/victorytheme.m4a" type="audio/mpeg">
    </audio>
    <script type="text/javascript">
      var vid = document.getElementById("audio");
      vid.volume = 0.1;
    </script>
    <a href="index.php?action=creation" class="btn btn-primary">Revanche !</a>
    <a href="index.php" class="btn btn-warning">Retour</a>
  </div>
</div>

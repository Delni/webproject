<div class="jumbotron" style="max-height:650px; overflow-x: hidden">
  <div class="text-center">
    <h1>Vos Statistiques !</h1>
  </div>
  <div class="col-md-offset-1 col-md-10 row">
    <div class="row">
      <p class="col-sm-2 underline">Ratio :</p>
      <p class="col-sm-2 text-center"><?php echo $this->user->getRatio(); ?></p>
    </div>
    <div class="row">
      <p class="col-sm-2 underline">Victoires :</p>
      <p class="col-sm-2 text-center"><?php echo $this->user->getX('GAGNEES'); ?></p>
    </div>
    <div class="row">
      <p class="col-sm-2 underline">Défaites :</p>
      <p class="col-sm-2 text-center"><?php echo $this->user->getX('PERDUES'); ?></p>
    </div>
    <div class="text-center">
      <a href="index.php?action=creation" class="btn btn-primary">Aller chercher une victoire</a>
      <a href="index.php" class="btn btn-warning">Retour</a>
    </div>
  </div>
</div>

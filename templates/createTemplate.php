<div class="well col-sm-offset-1 col-sm-10 edit">
  <h2>Créer une partie</h2>
  <form class="form-horizontal" method="post">
    <h3>Créateur : <?php echo $this->user->get_id(); ?></h3>
    <div class="text-left form-group">
      <div class="checkbox col-sm-offset-1">
        <label>
          <input type="checkbox" id="make_private" name="make_private" value="">
          Rendre la partie privée avec un mot de passe
        </label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="cPass">Mot de passe</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="cPass" placeholder="Entrer un mot de passe" disabled="disabled">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-4">
        <a href="#" type="submit" class="btn btn-primary">Créer une partie</a>
      </div>
    </div>
  </form>
</div>

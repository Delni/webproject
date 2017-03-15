<div class="well col-sm-offset-1 col-sm-10 edit">
  <h2>Créer une partie</h2>
  <form class="form-horizontal" action="index.php?action=createGame" method="post">
    <h3 class="text-left col-sm-offset-1">Créateur : <?php echo $this->user->get_id(); ?></h3>
    <div class="form-group row">
      <label class="col-sm-2 control-label col-sm-offset-1" for="cPass">Nom du plateau de jeu</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="crName" name="crName" placeholder="Entrer un nom" >
      </div>
    </div>
    <div class="text-left form-group row">
      <div class="checkbox col-sm-offset-2">
        <label>
          <input type="checkbox" id="make_private" name="make_private" value="">
          Rendre la partie privée avec un mot de passe
        </label>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-offset-1 col-sm-2 control-label" for="cPass">Mot de passe</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="crPass" name="crPass" placeholder="Entrer un mot de passe" disabled="disabled">
        <script type="text/javascript">
          $('#make_private').on('change',function(event){
            if(event.target.checked){;
              $('#crPass')[0].disabled=false;
            } else {
              $('#crPass')[0].disabled=true;
            }
          });
        </script>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-offset-4 col-sm-4">
        <input class="btn btn-primary" type="submit" value="Créer une partie" />
      </div>
    </div>
  </form>
</div>

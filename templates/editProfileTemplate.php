<div class="well col-sm-offset-1 col-sm-10 edit">
  <h2>Informations personnelles</h2>
  <form class="form-horizontal" enctype="multipart/form-data" method="post" action="index.php?action=updateProfile">
    <div class="form-group">
      <label class="col-md-2 control-label" for="fname">Prénom</label>
      <div class="col-md-3">
        <?php $this->input_fname(); ?>
      </div>
      <label for="email" class="col-md-2 control-label">E-Mail</label>
      <div class="col-md-3">
        <?php $this->input_email(); ?>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-md-2 control-label">Nom</label>
      <div class="col-md-3">
        <?php $this->input_name(); ?>
      </div>
      <label for="pays" class="col-md-2 control-label">Pays</label>
      <div class="col-md-3">
        <select id="pays" class="form-control col-md-2" name="pays">
          <option value="">-- Default --</option>
          <option value="de">Allemagne</option>
          <option value="au">Australie</option>
          <option value="be">Belgique</option>
          <option value="br">Brésil</option>
          <option value="ca">Canada</option>
          <option value="cl">Chili</option>
          <option value="cn">Chine</option>
          <option value="_Scotland">Ecosse</option>
          <option value="es">Espagne</option>
          <option value="fi">Finlande</option>
          <option value="fr">France</option>
          <option value="gb">Grande-Bretagne</option>
          <option value="it">Italie</option>
          <option value="ir">Iran</option>
          <option value="ie">Irlande</option>
          <option value="jp">Japon</option>
          <option value="no">Norvège</option>
          <option value="se">Suède</option>
          <option value="ch">Suisse</option>
          <option value="cz">République Tchèque</option>
          <option value="easter-egg">Yolo</option>
        </select>
      </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-3 col-md-2 control-label" for="InputFile">Image de profil</label>
      <div class="col-md-3">
          <select id="InputFile" class="form-control col-md-2" name="InputFile">
            <option value="">-- Default --</option>
            <option value="1"> Flower </option>
            <option value="2"> Creeper </option>
            <option value="3"> Invader </option>
            <option value="4"> Target </option>
            <option value="5"> Grenade </option>
            <option value="6"> Canvas </option>
            <option value="7"> Coin </option>
            <option value="8"> Smiling </option>
            <option value="9"> Picasso </option>
            <option value="10"> OneUp </option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-4 col-md-4">
        <?php $this->isUpdate('Info'); ?>
        <input type="submit" class="btn btn-input-primary" value="Enregistrer les modifications"/>
        <a href="index.php" class="btn btn-warning">Retour</a>
      </div>
    </div>
  </form>
  <h2>Modifier le mot de passe</h2>
  <form class="form-horizontal" method="post" action="index.php?action=updatePassWord">
    <div class="form-group">
      <label class="col-md-2 control-label" for="lPass">Mot de passe</label>
      <div class="col-md-3">
        <input type="password" class="form-control" name="lPass" placeholder="Mot de passe actuel">
      </div>
      <label class="col-md-offset-1 col-md-2 control-label" for="nPass">Nouveau mot de passe</label>
      <div class="col-md-3">
        <input type="password" class="form-control" name="nPass" placeholder="Entrer un nouveau mot de passe">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-4 col-md-4">
        <?php $this->isUpdate('Pass'); ?>
        <input type="submit" class="btn btn-input-primary" value="Enregistrer les modifications"/>
        <a href="index.php" class="btn btn-warning">Retour</a>
      </div>
    </div>
  </form>
  <form action="index.html" method="post">
    <fieldset class="deleteForm">
      <h2>Supprimer son compte</h2>
      <label class="col-md-8 control-label" for="delete">Supprimer toutes les informations relatives à votre compte ?</label>
      <div class="col-md-2">
        <a type="submit" class="btn btn-danger btn-md" href="#" data-toggle="modal" data-target="#PopupDeparture"><strong>Oui, tout supprimer <i class="fa fa-trash"></i></strong></a>
      </div>
    </fieldset>
  </form>
</div>

<div class="modal fade" id="PopupDeparture" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fermer</span></button>
        <h3 class="modal-title" id="myModalLabel">Supprimer son compte</h3>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img src="css/img/sad-kid-reaction-gif.gif" alt="Sad Kid">
          <h3>Tu veux vraiment partir?</h3>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary pull-left" data-dismiss="modal" data-toggle="modal" data-target="#PopupDeparture2">Et oui...</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Non je reste ;)</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="PopupDeparture2" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fermer</span></button>
        <h3 class="modal-title" id="myModalLabel">Supprimer son compte</h3>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img src="css/img/noLuc.gif" alt="No Luc">
          <h3>Tu es <strong>vraiment</strong> certain que c'est ce que tu veux?</h3>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary pull-left" data-dismiss="modal" data-toggle="modal" data-target="#PopupDeparture3">Oui s'il te plaît!</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Ok c'était une blague ;)</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="PopupDeparture3" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fermer</span></button>
        <h3 class="modal-title" id="myModalLabel">Supprimer son compte</h3>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img src="css/img/chat_potte.gif" alt="Chat Potte">
          <h3>Donc tu ne veux pas rester ?</h3>
        </div>
      </div>
      <div class="modal-footer">
        <a href="index?action=totalWipeOut" class="btn btn-danger pull-right" >Non je me barre</a>
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Bon aller...</button>
      </div>
    </div>
  </div>
</div>

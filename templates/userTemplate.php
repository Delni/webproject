<div>
  <div class="head_user">
    <span class="user-icon__mask"></span>
    <div class="user-icon">
      <i class="fa fa-user-o"></i>
    </div>
    <div class="user-pseudo">
      <p>Bonjour <?php echo $this->user->get_id(); ?> ! <a class="hasinfo" href="index.php?action=editProfile"><i class="fa fa-pencil"></i><span class="infobulle">Editer votre profil</span></a></p>
    </div>
    <div class="user-pseudo__subtitle">
      <p><?php echo $this->user->getX('PRENOM')." ".$this->user->getX('NOM'); ?> <?php $this->get_flag(); ?></p>
    </div>
  </div>
  <div class="jumbotron user-board">
    <ul class="nav nav-tabs nav-justified">
      <li role="presentation" class="active"><a href="#parties" data-toggle="tab">Parties En Cours</a></li>
      <li role="presentation"><a href="#hist" data-toggle="tab">Historique des parties</a></li>
      <li role="presentation"><a href="#stats" data-toggle="tab">Statistiques</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="parties">
        <h1>
          Parties en cours
          <a href="index.php?action=creation" class="btn btn-primary btn-lg pull-right" id="create">Créer une partie</a>
        </h1>
        <?php $this->error_handler_popup('warning','joinErrorText'); ?>
        <table class="table">
          <thead>
            <tr>
             <th>Nom Partie</th>
             <th>Créateur</th>
             <th>Joueurs</th>
             <th class="text-center">Action</th>
           </tr>
         </thead>
         <tbody>
           <?php $this->getGameList($this->user->get_id()); ?>
         </tbody>
       </table>
     </div>

     <div class="tab-pane" id="hist">
       <h1>Historique </h1>
       <table class="table table-hover text-center">
         <thead>
           <tr>
             <th class="text-center">Nom Partie</th>
             <th class="text-center">Status</th>
             <th class="text-center">Votre Score</th>
             <th class="text-center">Vainqueur</th>
             <th class="text-center">Score vainqueur</th>
           </tr>
         </thead>
         <tbody>
           <?php $this->getGameList($this->user->get_id(),true); ?>
         </tbody>
       </table>
     </div>
     <div class="tab-pane" id="stats">
       <h1>Statistiques </h1>
       <p>
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
      </div>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#tabs').tab();
    });
</script>
  </div>
</div>

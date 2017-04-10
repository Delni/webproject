<div class="jumbotron" style="max-height:650px;">
  <div class="text-center">
    <h1>Parties en cours sur le serveur</h1>
  </div>
  <div class="col-lg-offset-1 col-lg-10">
    <table class="table">
      <thead>
        <tr>
          <th>Nom Partie</th>
          <th>Créateur</th>
          <th>Joueurs</th>
          <th class="text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $this->getGameList(); ?>
      </tbody>
    </table>
  </div>
</div>

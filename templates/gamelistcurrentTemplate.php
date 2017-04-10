<div class="jumbotron" style="max-height:650px;">
  <div class="text-center">
    <h2>Vos parties en cours sur le serveur</h2>
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
        <?php $this->getGameList(unserialize($_SESSION['user'])->get_id()); ?>
      </tbody>
    </table>
  </div>
</div>

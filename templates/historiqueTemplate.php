<div class="jumbotron" style="max-height:650px;overflow-x : hidden">
  <div class="text-center">
    <h1>Historique de vos parties</h1>
  </div>
  <div class="row">
    <div class="col-md-offset-1 col-md-10">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-center">Nom Partie</th>
            <th class="text-center">Status</th>
            <th class="text-center">Votre Score</th>
            <th class="text-center">Vainqueur</th>
            <th class="text-center">Score vainqueur</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php $this->getGameList($this->user->get_id(),true); ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

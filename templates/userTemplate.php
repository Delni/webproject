<div>
  <span class="user-icon__mask"></span>
  <div class="user-icon">
      <i class="fa fa-user-o"></i>
  </div>
  <div class="user-pseudo">
    <p>Bonjour Delni ! <a href="#"><i class="fa fa-pencil"></i></a></p>
  </div>
  <div class="user-pseudo__subtitle">
    <p>Nicolas Delauney <img src="css/img/flags/flags_iso/24/fr.png" alt="fra"></p>
  </div>
  <div class="jumbotron">
    <ul class="nav nav-tabs nav-justified">
      <li role="presentation" class="active"><a href="#stats">Statistiques</a></li>
      <li role="presentation"><a href="#hist">Historique des parties</a></li>
      <li role="presentation"><a href="#parties">Parties En Cours</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="stats">
        <h1>Statistiques </h1>
        <p>Ratio : <br>Victoires : <br>Défaites :</p>
      </div>
      <div class="tab-pane" id="hist">
        <h1>Historique </h1>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nom Partie</th>
              <th>Vainqueur</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="parties">
      <h1>Parties en cours </h1>
      <table class="table">
        <thead>
          <tr>
           <th>#</th>
           <th>Nom Partie</th>
           <th>Créateur</th>
           <th>Joueurs</th>
         </tr>
       </thead>
       <tbody>
         <tr>
           <th scope="row">1</th>
           <td>Test</td>
           <td>BlazDark</td>
           <td>2/10</td>
         </tr>
       </tbody>
     </table>
    </div>

    </div>

    <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#tabs').tab();
    });
</script>
  </div>
</div>

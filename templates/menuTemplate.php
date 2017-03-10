<style media="screen">
  .navbar{
    background-color: rgba(70, 75, 99, 0.5);
    box-shadow: 5px 0px 10px black;
    border : none;
  }
  .navbar-brand{
    padding-top: 0.35em;
  }
  .menu__img{
    width: 2em;
  }

</style>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <img class="menu__img" src="css/img/favicon.png" alt="Logo">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
        <li class="active"><a href="#">Accueil <span class="sr-only">(current)</span></a></li>
        <li><a href="#jeux">Jeux</a></li>
        <li><a href="#">Créer une partie</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li role="presentation" class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->user->get_id(); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="fa fa-user-circle-o fa-fw"></i> Mon Profil</a></li>
            <li><a href="#"><i class="fa fa-cog fa-fw"></i> Mes données</a></li>
            <li><a href="#"><i class="fa fa-gamepad fa-fw"></i> Mes parties</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="index.php?action=logou"><i class="fa fa-power-off fa-fw"></i> Déconnexion</a></li>
          </ul>
        </li>
        <li><a href="#" data-toggle="modal" data-target="#PopupHelp"><i class="fa fa-question-circle"></i></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="modal fade" id="PopupHelp" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fermer</span></button>
        <h4 class="modal-title" id="myModalLabel">6 qui ramasse ! - Aide</h4>
      </div>
      <div class="modal-body">
        <h3>Kézako ?</h3>
        <div>Le jeu 6 qui ramasse provient du jeu <i>6 nimmt!</i>, jeu de cartes d'origine allemande.
        Le but de ce jeu est de finir la partie avec le <strong>moins</strong> de points possibles!</div>
        <h3>Les cartes</h3>
        <div>Chaque carte possède un numéro, et un poids. Ici, respectivement de 11 et de 5.</div>
        <div class="" style="text-align:center">
          <img src="css/img/cards_ex.jpg" alt="carte exemple">
        </div>
        <h3>Déroulement d'une partie</h3>
        <div>Chaque joueur commence la partie avec 10 cartes dans sa main. Le plateau se divise en 4 piles.
        Chacun leur tour, les joueurs vont choisir une carte à poser sur le plateau. Une fois toutes les cartes
      choisies, celles-ci sont dévoilées. La carte avec le <strong>numéro</strong> le plus bas est placée en première.</div>
        <h3>Placement des cartes</h3>
        <div>Chaque carte est posée sur la pile dont la dernière carte est directement inférieure. Si la carte du joueur est inférieure à toutes
        les cartes présentes, il prend la pile de poids le plus faible et pose sa carte à la place.<br>
        <div  style="text-align:center"><strong>Attention ! Si votre carte est la 6ème de la pile, vous ramassez !</strong></div></div>


      </div>
      <div class="modal-footer">
        <div class="" style="text-align:center">
          Pour plus d'information, <a target="_blank" href="https://fr.wikipedia.org/wiki/6_qui_prend_!">cliquez ici</a> pour vous diriger vers la page wikipédia du 6nimmt!<br>
        </div>
        <p></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

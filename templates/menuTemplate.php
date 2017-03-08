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
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li role="presentation" class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->user->get_id(); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="fa fa-user-circle-o fa-fw"></i> Mon Profil</a></li>
            <li><a href="#"><i class="fa fa-cog fa-fw"></i> Mes données</a></li>
            <li><a href="#"><i class="fa fa-gamepad fa-fw"></i> Mes parties</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="index.php"><i class="fa fa-power-off fa-fw"></i> Déconnexion</a></li>
          </ul>
        </li>
        <li><a href="#" ><i class="fa fa-question-circle"></i></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

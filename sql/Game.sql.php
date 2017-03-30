<?php

  Game::addSQLquerry('USER_LOGIN_USED',
    'SELECT PSEUDO FROM joueur WHERE PSEUDO=:login');


  Game::addSQLquerry('USER_EMAIL_EXIST',
    'SELECT Email FROM joueur WHERE Email=:email');

  Game::addSQLquerry('USER_CREATE_ACCOUNT',
    'INSERT INTO `joueur` (`PSEUDO`,`MDP`, `NOM`, `PRENOM`, `EMAIL`, `DATE_CREATION`,`PERDUES`,`GAGNEES`)
    VALUES (:login,:psw,:name,:fname,:mail,:today,0,0)');

  Game::addSQLquerry('USER_CREATE_GAME',
    'INSERT INTO plateau(Nom, Createur, Prive) VALUES (:nom_plat,:createur,:mdp_prive)');

  Game::addSQLquerry('USER_GET_ID_PLATEAU',
    'SELECT Id_plat FROM plateau ORDER BY Id_plat DESC');

  Game::addSQLquerry('USER_LINK_PLAYER_PLAYGROUND',
    'INSERT INTO jouer(Id_Plat,Pseudo) VALUES (:id_plat,:login)');

  Game::addSQLquerry('USER_LINK_PILE_PLAYGROUND',
    'INSERT INTO pile(Id_plat) VALUES (:id_plat),(:id_plat),(:id_plat),(:id_plat)');

  Game::addSQLquerry('USER_UPDATE_NAME',
    'UPDATE joueur SET Nom = :nom WHERE Pseudo=:id');

  Game::addSQLquerry('USER_UPDATE_FNAME',
    'UPDATE joueur SET Prenom = :prenom WHERE Pseudo=:id');

  Game::addSQLquerry('USER_UPDATE_EMAIL',
    'UPDATE joueur SET Email = :mail WHERE Pseudo=:id');

  Game::addSQLquerry('USER_UPDATE_COUNTRY',
    'UPDATE joueur SET Pays = :pays WHERE Pseudo=:id');

  Game::addSQLquerry('USER_UPDATE_PASSWORD_BY_ID',
    'UPDATE joueur SET MdP = :mdp WHERE Pseudo=:id');

  Game::addSQLquerry('USER_UPDATE_PASSWORD_BY_MAIL',
    'UPDATE joueur SET MdP = :mdp WHERE email=:mail');

  Game::addSQLquerry('USER_ALL_INFO',
    'SELECT * FROM joueur WHERE Pseudo=:login');

    //Not working properly, see Game->getX()
  Game::addSQLquerry('USER_CUSTOM_QUERRY',
    'SELECT :custom_field FROM joueur WHERE pseudo=:login');

  Game::addSQLquerry('USER_START_GAME',
    'UPDATE plateau SET estCommence = 0 WHERE Id_Plat = :id_plat');

  Game::addSQLquerry('USER_GET_nbJOUEURS',
    'SELECT COUNT(PSEUDO)as nb_joueurs FROM jouer WHERE id_plat=:id_plat');

  Game::addSQLquerry('USER_SET_HAND',
    'INSERT INTO `main` (`Pseudo`, `Id_Plat`, `Nb_Carte_Main`) VALUES (:pseudo, :id_plat, 10)');

  Game::addSQLquerry('USER_DELETE',
    'DELETE FROM `joueur` WHERE `joueur`.`Pseudo` = :login');
 ?>
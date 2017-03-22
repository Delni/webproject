<?php

  User::addSQLquerry('USER_LOGIN_USED',
    'SELECT PSEUDO FROM joueur WHERE PSEUDO=:login');


  User::addSQLquerry('USER_EMAIL_EXIST',
    'SELECT Email FROM joueur WHERE Email=:email');

  User::addSQLquerry('USER_CREATE_ACCOUNT',
    'INSERT INTO `joueur` (`PSEUDO`,`MDP`, `NOM`, `PRENOM`, `EMAIL`, `DATE_CREATION`,`PERDUES`,`GAGNEES`)
    VALUES (:login,:psw,:name,:fname,:mail,:today,0,0)');

  User::addSQLquerry('USER_CREATE_GAME',
    'INSERT INTO plateau(Nom, Createur, Prive) VALUES (:nom_plat,:createur,:mdp_prive)');

  User::addSQLquerry('USER_GET_ID_PLATEAU',
    'SELECT Id_plat FROM plateau ORDER BY Id_plat DESC');

  User::addSQLquerry('USER_LINK_PLAYER_PLAYGROUND',
    'INSERT INTO jouer(Id_Plat,Pseudo) VALUES (:id_plat,:login)');

  User::addSQLquerry('USER_LINK_PILE_PLAYGROUND',
    'INSERT INTO pile(Id_plat) VALUES (:id_plat),(:id_plat),(:id_plat),(:id_plat)');

  User::addSQLquerry('USER_UPDATE_NAME',
    'UPDATE joueur SET Nom = :nom WHERE Pseudo=:id');

  User::addSQLquerry('USER_UPDATE_FNAME',
    'UPDATE joueur SET Prenom = :prenom WHERE Pseudo=:id');

  User::addSQLquerry('USER_UPDATE_EMAIL',
    'UPDATE joueur SET Email = :mail WHERE Pseudo=:id');

  User::addSQLquerry('USER_UPDATE_COUNTRY',
    'UPDATE joueur SET Pays = :pays WHERE Pseudo=:id');

  User::addSQLquerry('USER_UPDATE_PASSWORD',
    'UPDATE joueur SET MdP = :mdp WHERE Pseudo=:id');

  User::addSQLquerry('USER_CUSTOM_QUERRY',
    'SELECT :custom_field FROM joueur WHERE pseudo=:login');
 ?>

<?php
  Game::addSQLquerry('USER_START_GAME',
    'UPDATE plateau SET estCommence = 0 WHERE Id_Plat = :id_plat');

  Game::addSQLquerry('GAME_GET_PASSWORD',
    'SELECT Prive FROM Plateau WHERE id_plat=:id_plat');

  Game::addSQLquerry('GAME_SET_LOG',
    'INSERT INTO log(Id_plat, html) VALUES (:id_plat,:html_content)');

  Game::addSQLquerry('GAME_SELECT_CARD_IN_PILE',
    'SELECT Id_Carte FROM etre_dans WHERE id_pile=:id_pile');

  Game::addSQLquerry('USER_GET_nbJOUEURS',
    'SELECT COUNT(PSEUDO)as nb_joueurs FROM jouer WHERE id_plat=:id_plat');

  Game::addSQLquerry('USER_SET_HAND',
    'INSERT INTO `main` (`Pseudo`, `Id_Plat`, `Nb_Carte_Main`) VALUES (:pseudo, :id_plat, 10)');

  Game::addSQLquerry('USER_SET_SCORE',
    'INSERT INTO `score` (`Pseudo`, `Id_Plat`, `Val_Score`) VALUES (:pseudo, :id_plat, 0)');

  Game::addSQLquerry('USER_DELETE',
    'DELETE FROM `joueur` WHERE `joueur`.`Pseudo` = :login');
 ?>

<?php
  Game::addSQLquerry('USER_START_GAME',
    'UPDATE plateau SET estCommence = 0 WHERE Id_Plat = :id_plat');

  Game::addSQLquerry('GAME_GET_PASSWORD',
    'SELECT Prive FROM Plateau WHERE id_plat=:id_plat');

  Game::addSQLquerry('GAME_SET_LOG',
    'INSERT INTO log(Id_plat, html) VALUES (:id_plat,:html_content)');

  Game::addSQLquerry('GAME_GET_PILE',
    'SELECT Id_Pile FROM PILE WHERE id_plat=:id_plat');

  Game::addSQLquerry('GAME_SET_PILE',
    'INSERT INTO etre_dans VALUES (:id_pile,:num)');

  Game::addSQLquerry('GAME_SELECT_CARD_IN_PILE',
    'SELECT Id_Carte FROM etre_dans WHERE id_pile=:id_pile');

  Game::addSQLquerry('GAME_GET_PSEUDO',
    'SELECT Pseudo FROM Jouer WHERE id_plat=:id_plat');

  Game::addSQLquerry('GAME_GET_MAIN_TEST',
    'SELECT Id_Main FROM MAIN WHERE id_plat=:id_plat AND Pseudo=:pseudo');

  Game::addSQLquerry('GAME_GET_STATUS',
    'SELECT estCommence FROM Plateau WHERE id_plat=:id_plat');

  Game::addSQLquerry('GAME_IS_OPEN',
    'SELECT COUNT(PSEUDO)as nb_joueurs, estCommence FROM jouer LEFT JOIN Plateau USING (Id_plat) WHERE id_plat=:id_plat');

  Game::addSQLquerry('GAME_GET_PSEUDO_FROM_PSEUDO&PLAT',
    'SELECT PSEUDO FROM jouer WHERE pseudo=:pseudo AND id_plat=:id_plat');

  Game::addSQLquerry('GAME_INSERT_NEW_PLAYER',
    'INSERT INTO `jouer`(`ID_PLAT`,`PSEUDO`,`SCORE`) VALUES (:plat,:joueur,0)');

  Game::addSQLquerry('GAME_GET_HAND_ID',
    'SELECT Id_Main FROM MAIN WHERE pseudo=:pseudo AND id_plat=:id_plat');

  Game::addSQLquerry('GAME_GET_SELECTED_CARDS',
    'SELECT `Id_Selected_Card` FROM Main WHERE Id_Plat=:id_plat ORDER BY Id_Selected_Card');

  Game::addSQLquerry('GAME_GET_PSEUDO_FROM_HAND',
    'SELECT Pseudo FROM MAIN WHERE id_plat=:id_plat AND Id_Selected_Card=:selected');

  Game::addSQLquerry('GAME_ADD_HISTORIQUE',
    'INSERT INTO historique(Pseudo, Score, Nom, Nom_Gagnant, Score_Gagnant) VALUES (:pseudo, :score, :nom, :nom_gagnant, :score_gagnant)');

  Game::addSQLquerry('USER_GET_nbJOUEURS',
    'SELECT COUNT(PSEUDO)as nb_joueurs FROM jouer WHERE id_plat=:id_plat');

  Game::addSQLquerry('USER_SET_HAND',
    'INSERT INTO `main` (`Pseudo`, `Id_Plat`, `Nb_Carte_Main`) VALUES (:pseudo, :id_plat, 10)');

  Game::addSQLquerry('USER_SET_SCORE',
    'INSERT INTO `score` (`Pseudo`, `Id_Plat`, `Val_Score`) VALUES (:pseudo, :id_plat, 0)');

  Game::addSQLquerry('USER_GET_RATIO',
    'SELECT Perdues, Gagnees FROM joueur WHERE Pseudo=:pseudo');

  Game::addSQLquerry('USER_SET_RATIO',
    'UPDATE joueur SET Perdues=:defaites, Gagnees=:victoires WHERE Pseudo=:pseudo');

  Game::addSQLquerry('USER_DELETE',
    'DELETE FROM `joueur` WHERE `joueur`.`Pseudo` = :login');
 ?>

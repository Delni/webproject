CREATE DATABASE `6nimmt`  DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE `6nimmt`;

CREATE TABLE Joueur (
Pseudo varchar(25) NOT NULL,
MdP varchar(50) NOT NULL,
Nom varchar(50) NOT NULL,
Prenom varchar(50) NOT NULL,
Email varchar(50),
Date_Creation DATE,
Pays varchar(50),
IdP varchar(250),
Perdues int,
Gagnees int,
PRIMARY KEY (Pseudo)
);

CREATE TABLE Log(
  Id int AUTO_INCREMENT,
  Id_Plat int,
  Html TEXT,
  PRIMARY KEY (Id),
  CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat)
);

CREATE TABLE Carte (
Id_Carte int,
Poids int,
PRIMARY KEY (Id_Carte)
);

CREATE TABLE Pile (
Id_Pile int NOT NULL AUTO_INCREMENT,
Id_Plat int,
PRIMARY KEY (Id_Pile)
-- Foreign Key for Id_Plat is at the very end, because Plateau has not been created yet!
);

CREATE TABLE Etre_dans(
  Id_Pile int,
  Id_Carte int,
  PRIMARY KEY (Id_Pile,Id_Carte),
  CONSTRAINT Fk_Id_Pile FOREIGN KEY (Id_Pile) REFERENCES Pile(Id_Pile),
  CONSTRAINT Fk_Id_Carte FOREIGN KEY (Id_Carte) REFERENCES Carte(Id_Carte)
);

CREATE TABLE Plateau (
Id_Plat int NOT NULL AUTO_INCREMENT,
Nom varchar(50),
Createur varchar(50),
Prive varchar(50),
estCommence int DEFAULT -1,
PRIMARY KEY (Id_Plat),
CONSTRAINT Fk_Createur FOREIGN KEY (Createur) REFERENCES Joueur(Pseudo)
);

CREATE TABLE Jouer(
 Id_Plat int,
 Pseudo varchar(50),
 Score int DEFAULT 0,
 PRIMARY KEY(Id_Plat, Pseudo),
 CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
 CONSTRAINT Fk_Pseudo FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
);

CREATE TABLE Historique(
  Id_Historique int NOT NULL AUTO_INCREMENT,
  Pseudo varchar(50),
  Score int,
  Nom varchar(50),
  PRIMARY KEY (Id_Historique),
  CONSTRAINT Fk_Pseudo FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
);

CREATE TABLE appartenir_(
  Id_Main int,
  Pseudo varchar(50),
  PRIMARY KEY(Id_Main, Pseudo)
);

CREATE TABLE Main (
Id_Main int NOT NULL AUTO_INCREMENT,
Pseudo varchar(50),
Id_Plat int,
Id_Carte1 int,
Id_Carte2 int,
Id_Carte3 int,
Id_Carte4 int,
Id_Carte5 int,
Id_Carte6 int,
Id_Carte7 int,
Id_Carte8 int,
Id_Carte9 int,
Id_Carte10 int,
Id_Selected_Card int DEFAULT -1,
Nb_Carte_main int DEFAULT -1,
PRIMARY KEY (Id_Main),
CONSTRAINT Fk_Id_Carte1 FOREIGN KEY (ID_Carte1) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte2 FOREIGN KEY (ID_Carte2) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte3 FOREIGN KEY (ID_Carte3) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte4 FOREIGN KEY (ID_Carte4) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte5 FOREIGN KEY (ID_Carte5) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte6 FOREIGN KEY (ID_Carte6) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte7 FOREIGN KEY (ID_Carte7) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte8 FOREIGN KEY (ID_Carte8) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte9 FOREIGN KEY (ID_Carte9) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Carte10 FOREIGN KEY (ID_Carte10) REFERENCES Carte(Id_Carte),
CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
CONSTRAINT Fk_Pseudo FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
);

CREATE TABLE Score(
  Id_Score int NOT NULL AUTO_INCREMENT,
  Pseudo varchar(50),
  Id_plat int,
  Val_score int,
  PRIMARY KEY (Id_Score),
  CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
  CONSTRAINT Fk_Pseudo FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
);

ALTER TABLE Pile ADD CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat);


--  ad88888ba        db        88b           d88 88888888ba  88          88888888888 ad88888ba
-- d8"     "8b      d88b       888b         d888 88      "8b 88          88         d8"     "8b
-- Y8,             d8'`8b      88`8b       d8'88 88      ,8P 88          88         Y8,
-- `Y8aaaaa,      d8'  `8b     88 `8b     d8' 88 88aaaaaa8P' 88          88aaaaa    `Y8aaaaa,
--   `"""""8b,   d8YaaaaY8b    88  `8b   d8'  88 88""""""'   88          88"""""      `"""""8b,
--         `8b  d8""""""""8b   88   `8b d8'   88 88          88          88                 `8b
-- Y8a     a8P d8'        `8b  88    `888'    88 88          88          88         Y8a     a8P
--  "Y88888P" d8'          `8b 88     `8'     88 88          88888888888 88888888888 "Y88888P"

USE `6nimmt`;

INSERT INTO Joueur VALUES ('SeigneurSith', 'JeSuisTonPère', 'Vador', 'Dark', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Plombierdu59', 'ItsME', 'Super', 'Mario', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('HiaHIA', 'Hyrule=IRule', 'Kokiri', 'Link', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('ChasseuseDePrimesGalactique', 'ZeroSuit', 'Aran', 'Samus', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('PilleusedeTombes', 'SeinsCubiques', 'Croft', 'Lara', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Hérissondu59', 'ChaosControl', 'TheHedgehog', 'Sonic', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('PrincessePlage', 'BowsersGirl', 'Peach', 'Princess', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('PilleurdeFranchise', 'RemplacelesBoobs', 'Drake', 'Nathan', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('PèreFondateur', 'PuckMan', 'Man', 'Pack', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('MaîtreVert', 'AlEnversJeParle', 'Yoda', 'Maître', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('TazmaniedeSony', 'SnoobNaughtyDog', 'Bandicoot', 'Crash', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('GrosPoings', 'RayCharles', 'Man', 'Ray', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('IronMan', 'TheBest', 'Stark', 'Tony', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('CaptainAmerica', 'LoveBucky', 'Roger', 'Steve', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Batman', 'RIPPapaMaman', 'Wayne', 'Bruce', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Superman', 'KriptoPhobe', 'Kent', 'Clark', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Blondie', 'Camstresse!!', 'Delory', 'Valentine', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('DelaLune', 'PetiteChieuse', 'LaCroix', 'Claire', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Delni', 'Maniac', 'Delauney', 'Nicolas', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('BlazDark', 'Gamer4Life', 'Handjani', 'Adrien', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Lambassadrice', 'CougarTown', 'Amidala', 'Padmé', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Jedu-Bid', 'Nooo', 'Skywalker', 'Luke', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('SourisElectrique', 'OndineMaChose', 'Kachu', 'Pi', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('LaLégendeVivante', 'Red', 'Red', 'Red', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('LEmodesCarte', 'AmedesCarte', 'Muto', 'Yugi', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('FilloteA', 'CheVaisEnvahirLaPologne!', 'Kerchove', 'Alice', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('LHommeFemme', 'MaisJe****Des*****', 'Coignet', 'Anthony', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('FilloteB', 'NimporteQuoi!', 'Le Mentec', 'Solène', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('ArchéologueDesAztèques', 'FouetEtChapeau', 'Jones', 'Indiana', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('SorcieralaCicatrice', 'RIPHermioneLove', 'Potter', 'Harry', NULL, NULL, NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('User', 'User', 'Nyme', 'Ano', NULL, NULL, NULL, NULL,0,0);


INSERT INTO Carte VALUES (1, 1);
INSERT INTO Carte VALUES (2, 1);
INSERT INTO Carte VALUES (3, 1);
INSERT INTO Carte VALUES (4, 1);
INSERT INTO Carte VALUES (5, 2);
INSERT INTO Carte VALUES (6, 1);
INSERT INTO Carte VALUES (7, 1);
INSERT INTO Carte VALUES (8, 1);
INSERT INTO Carte VALUES (9, 1);
INSERT INTO Carte VALUES (10, 3);
INSERT INTO Carte VALUES (11, 5);
INSERT INTO Carte VALUES (12, 1);
INSERT INTO Carte VALUES (13, 1);
INSERT INTO Carte VALUES (14, 1);
INSERT INTO Carte VALUES (15, 2);
INSERT INTO Carte VALUES (16, 1);
INSERT INTO Carte VALUES (17, 1);
INSERT INTO Carte VALUES (18, 1);
INSERT INTO Carte VALUES (19, 1);
INSERT INTO Carte VALUES (20, 3);
INSERT INTO Carte VALUES (21, 1);
INSERT INTO Carte VALUES (22, 5);
INSERT INTO Carte VALUES (23, 1);
INSERT INTO Carte VALUES (24, 1);
INSERT INTO Carte VALUES (25, 2);
INSERT INTO Carte VALUES (26, 1);
INSERT INTO Carte VALUES (27, 1);
INSERT INTO Carte VALUES (28, 1);
INSERT INTO Carte VALUES (29, 1);
INSERT INTO Carte VALUES (30, 3);
INSERT INTO Carte VALUES (31, 1);
INSERT INTO Carte VALUES (32, 1);
INSERT INTO Carte VALUES (33, 5);
INSERT INTO Carte VALUES (34, 1);
INSERT INTO Carte VALUES (35, 2);
INSERT INTO Carte VALUES (36, 1);
INSERT INTO Carte VALUES (37, 1);
INSERT INTO Carte VALUES (38, 1);
INSERT INTO Carte VALUES (39, 1);
INSERT INTO Carte VALUES (40, 3);
INSERT INTO Carte VALUES (41, 1);
INSERT INTO Carte VALUES (42, 1);
INSERT INTO Carte VALUES (43, 1);
INSERT INTO Carte VALUES (44, 5);
INSERT INTO Carte VALUES (45, 2);
INSERT INTO Carte VALUES (46, 1);
INSERT INTO Carte VALUES (47, 1);
INSERT INTO Carte VALUES (48, 1);
INSERT INTO Carte VALUES (49, 1);
INSERT INTO Carte VALUES (50, 3);
INSERT INTO Carte VALUES (51, 1);
INSERT INTO Carte VALUES (52, 1);
INSERT INTO Carte VALUES (53, 1);
INSERT INTO Carte VALUES (54, 1);
INSERT INTO Carte VALUES (55, 7);
INSERT INTO Carte VALUES (56, 1);
INSERT INTO Carte VALUES (57, 1);
INSERT INTO Carte VALUES (58, 1);
INSERT INTO Carte VALUES (59, 1);
INSERT INTO Carte VALUES (60, 3);
INSERT INTO Carte VALUES (61, 1);
INSERT INTO Carte VALUES (62, 1);
INSERT INTO Carte VALUES (63, 1);
INSERT INTO Carte VALUES (64, 1);
INSERT INTO Carte VALUES (65, 2);
INSERT INTO Carte VALUES (66, 5);
INSERT INTO Carte VALUES (67, 1);
INSERT INTO Carte VALUES (68, 1);
INSERT INTO Carte VALUES (69, 1);
INSERT INTO Carte VALUES (70, 3);
INSERT INTO Carte VALUES (71, 1);
INSERT INTO Carte VALUES (72, 1);
INSERT INTO Carte VALUES (73, 1);
INSERT INTO Carte VALUES (74, 1);
INSERT INTO Carte VALUES (75, 2);
INSERT INTO Carte VALUES (76, 1);
INSERT INTO Carte VALUES (77, 5);
INSERT INTO Carte VALUES (78, 1);
INSERT INTO Carte VALUES (79, 1);
INSERT INTO Carte VALUES (80, 3);
INSERT INTO Carte VALUES (81, 1);
INSERT INTO Carte VALUES (82, 1);
INSERT INTO Carte VALUES (83, 1);
INSERT INTO Carte VALUES (84, 1);
INSERT INTO Carte VALUES (85, 2);
INSERT INTO Carte VALUES (86, 1);
INSERT INTO Carte VALUES (87, 1);
INSERT INTO Carte VALUES (88, 5);
INSERT INTO Carte VALUES (89, 1);
INSERT INTO Carte VALUES (90, 3);
INSERT INTO Carte VALUES (91, 1);
INSERT INTO Carte VALUES (92, 1);
INSERT INTO Carte VALUES (93, 1);
INSERT INTO Carte VALUES (94, 1);
INSERT INTO Carte VALUES (95, 2);
INSERT INTO Carte VALUES (96, 1);
INSERT INTO Carte VALUES (97, 1);
INSERT INTO Carte VALUES (98, 1);
INSERT INTO Carte VALUES (99, 5);
INSERT INTO Carte VALUES (100, 3);
INSERT INTO Carte VALUES (101, 1);
INSERT INTO Carte VALUES (102, 1);
INSERT INTO Carte VALUES (103, 1);
INSERT INTO Carte VALUES (104, 1);

INSERT INTO Plateau(Nom, Createur, Prive, estCommence) VALUES('Partie des Devs', 'BlazDark', 'LesBoss', -1);
INSERT INTO Plateau(Nom, Createur, Prive, estCommence) VALUES('Partie des Blondes', 'Blondie', 'Codouches', -1);
INSERT INTO Plateau(Nom, Createur, Prive, estCommence) VALUES('Partie des 4', 'Delni', 'LeMini2', -1);
INSERT INTO Plateau(Nom, Createur, Prive, estCommence) VALUES('Partie Full NonCom', 'BlazDark', 'FullNonCom', -1);


INSERT INTO log(Id_plat, html) VALUES (1,'<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
INSERT INTO log(Id_plat, html) VALUES (1,'<div class="row text-center"><p>Créée par BlazDark<p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (1,'<div class="row"><p class="log"><em class="underline">Nom : </em> Partie des Devs,<br> <em class="underline">Mot de passe :</em> LesBoss </p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (1,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row"><p class="log"> En attente de joueurs...</p></div><hr>');

INSERT INTO log(Id_plat, html) VALUES (2,'<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
INSERT INTO log(Id_plat, html) VALUES (2,'<div class="row text-center"><p>Créée par Blondie<p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (2,'<div class="row"><p class="log"><em class="underline">Nom : </em> Partie des Blondes,<br> <em class="underline">Mot de passe :</em> Codouches </p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (2,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row"><p class="log"> En attente de joueurs...</p></div><hr>');

INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row text-center"><p>Créée par Delni<p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log"><em class="underline">Nom : </em>Partie des 4,<br> <em class="underline">Mot de passe :</em> LeMini2 </p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row"><p class="log"> En attente de joueurs...</p></div><hr>');

INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row text-center"><h2> -- Création de la partie --</h2></div>');
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row text-center"><p>Créée par BlazDark<p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log"><em class="underline">Nom : </em> Partie Full NonCom,<br> <em class="underline">Mot de passe :</em> FullNonCom </p></div><hr>');
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div><div class="row"><p class="log"> En attente de joueurs...</p></div><hr>');


INSERT INTO Jouer VALUES (1,'BlazDark',42);
INSERT INTO Jouer VALUES (1,'Delni',55);
INSERT INTO log(Id_plat, html) VALUES (1,'<div class="row"><p class="log">Delni a rejoins la partie !</p></div><hr>');

INSERT INTO Jouer VALUES (2, 'Blondie',4);
INSERT INTO Jouer VALUES (2, 'DelaLune', 13);
INSERT INTO log(Id_plat, html) VALUES (2,'<div class="row"><p class="log">DelaLune a rejoins la partie !</p></div><hr>');

INSERT INTO Jouer VALUES (3, 'BlazDark', 27);
INSERT INTO Jouer VALUES (3,'Delni',40);
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log">Delni a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (3,'Blondie', 0);
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log">Blondie a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (3,'DelaLune',0);
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log">DelaLune a rejoins la partie !</p></div><hr>');

INSERT INTO Jouer VALUES (4,'Superman',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Superman a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Batman',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Batman a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'TazmaniedeSony',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">TazmaniedeSony a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Hérissondu59',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Hérissondu59 a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'PilleusedeTombe',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">PilleusedeTombe a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Delni',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Delni a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'SourisElectrique',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">SourisElectrique a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'FilloteA',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">FilloteA a rejoins la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'LHommeFemme',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">LHommeFemme a rejoins la partie !</p></div><hr>');

INSERT INTO Historique(Pseudo, Score, Nom) VALUES('Delni',12, 'LaPartieDeLEgalite');
INSERT INTO Historique(Pseudo, Score, Nom) VALUES('BlazDark', 12, 'LaPartieDeLEgalite');
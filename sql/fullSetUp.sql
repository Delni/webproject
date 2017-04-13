CREATE DATABASE `6nimmt`  DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE `6nimmt`;

--    ,ad8888ba,                                           88
--   d8"'    `"8b                                    ,d    ""
--  d8'                                              88
--  88            8b,dPPYba,  ,adPPYba, ,adPPYYba, MM88MMM 88  ,adPPYba,  8b,dPPYba,
--  88            88P'   "Y8 a8P_____88 ""     `Y8   88    88 a8"     "8a 88P'   `"8a
--  Y8,           88         8PP""""""" ,adPPPPP88   88    88 8b       d8 88       88
--   Y8a.    .a8P 88         "8b,   ,aa 88,    ,88   88,   88 "8a,   ,a8" 88       88
--    `"Y8888Y"'  88          `"Ybbd8"' `"8bbdP"Y8   "Y888 88  `"YbbdP"'  88       88

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
)ENGINE = InnoDB;

CREATE TABLE Carte (
Id_Carte int,
Poids int,
PRIMARY KEY (Id_Carte)
)ENGINE = InnoDB;

CREATE TABLE Pile (
Id_Pile int NOT NULL AUTO_INCREMENT,
Id_Plat int,
PRIMARY KEY (Id_Pile)
-- Foreign Key for Id_Plat is at the very end, because Plateau has not been created yet!
)ENGINE = InnoDB;

CREATE TABLE Etre_dans(
  Id_Pile int,
  Id_Carte int,
  PRIMARY KEY (Id_Pile,Id_Carte),
  CONSTRAINT Fk_Id_Pile FOREIGN KEY (Id_Pile) REFERENCES Pile(Id_Pile),
  CONSTRAINT Fk_Id_Carte FOREIGN KEY (Id_Carte) REFERENCES Carte(Id_Carte)
)ENGINE = InnoDB;

CREATE TABLE Plateau (
Id_Plat int NOT NULL AUTO_INCREMENT,
Nom varchar(50),
Createur varchar(50),
Prive varchar(50),
estCommence int DEFAULT -1,
KonamiCode int DEFAULT -1,
Suod varchar(50) DEFAULT 'Goku',
PRIMARY KEY (Id_Plat),
CONSTRAINT Fk_Createur FOREIGN KEY (Createur) REFERENCES Joueur(Pseudo)
)ENGINE = InnoDB;

CREATE TABLE Jouer(
 Id_Plat int,
 Pseudo varchar(50),
 Score int DEFAULT 0,
 PRIMARY KEY(Id_Plat, Pseudo),
 CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
 CONSTRAINT Fk_Pseudo FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
)ENGINE = InnoDB;

CREATE TABLE Historique(
  Id_Historique int NOT NULL AUTO_INCREMENT,
  Pseudo varchar(50),
  Score int,
  Nom varchar(50),
  Nom_Gagnant varchar(50),
  Score_Gagnant varchar(50),
  PRIMARY KEY (Id_Historique),
  CONSTRAINT Fk_Pseudo2 FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
)ENGINE = InnoDB;

CREATE TABLE appartenir_(
  Id_Main int,
  Pseudo varchar(50),
  PRIMARY KEY(Id_Main, Pseudo)
)ENGINE = InnoDB;

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
CONSTRAINT Fk_Id_Plat2 FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
CONSTRAINT Fk_Pseudo3 FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
)ENGINE = InnoDB;

CREATE TABLE Score(
  Id_Score int NOT NULL AUTO_INCREMENT,
  Pseudo varchar(50),
  Id_plat int,
  Val_score int,
  PRIMARY KEY (Id_Score),
  CONSTRAINT Fk_Id_Plat3 FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
  CONSTRAINT Fk_Pseudo4 FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
)ENGINE = InnoDB;

CREATE TABLE Log(
  Id int AUTO_INCREMENT,
  Id_Plat int,
  Html TEXT,
  PRIMARY KEY (Id),
  CONSTRAINT Fk_Id_Plat1 FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat)
)ENGINE = InnoDB;

ALTER TABLE Pile ADD CONSTRAINT Fk_Id_Plat4 FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat);


--  ad88888ba                                            88
-- d8"     "8b                                           88
-- Y8,                                                   88
-- `Y8aaaaa,   ,adPPYYba, 88,dPYba,,adPYba,  8b,dPPYba,  88  ,adPPYba, ,adPPYba,
--   `"""""8b, ""     `Y8 88P'   "88"    "8a 88P'    "8a 88 a8P_____88 I8[    ""
--         `8b ,adPPPPP88 88      88      88 88       d8 88 8PP"""""""  `"Y8ba,
-- Y8a     a8P 88,    ,88 88      88      88 88b,   ,a8" 88 "8b,   ,aa aa    ]8I
--  "Y88888P"  `"8bbdP"Y8 88      88      88 88`YbbdP"'  88  `"Ybbd8"' `"YbbdP"'
--                                           88
--                                           88


-- Real
INSERT INTO Joueur VALUES ('BlazDark', 'Gamer4Life', 'Handjani', 'Adrien', NULL, '2017-04-13', 'fr', NULL,0,0);
INSERT INTO Joueur VALUES ('Delni', 'Maniac', 'Delauney', 'Nicolas', NULL, '2017-04-13', 'fr', NULL,0,0);
INSERT INTO Joueur VALUES ('Blondie', 'Camstresse!!', 'Delory', 'Valentine', NULL, '2017-04-13', 'fr', NULL,0,0);
INSERT INTO Joueur VALUES ('DelaLune', 'PetiteChieuse', 'Lacroix', 'Claire', NULL, '2017-04-13', 'cl', NULL,0,0);
INSERT INTO Joueur VALUES ('Poupii', 'CheVaisEnvahirLaPologne!', 'Kerchove', 'Alice', NULL, '2017-04-13', 'be', NULL,0,0);
INSERT INTO Joueur VALUES ('LHommeFemme', 'MaisJe****Des*****', 'Coignet', 'Anthony', NULL, '2017-04-13', 'fr', NULL,0,0);
INSERT INTO Joueur VALUES ('Skitty', 'NimporteQuoi!', 'Le Mentec', 'Solène', NULL, '2017-04-13', 'fr', NULL,0,0);
INSERT INTO Joueur VALUES ('User', 'user', 'Nyme', 'Ano', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Admin', 'root', 'Istrateur', 'Admin', NULL, '2017-04-13', NULL, NULL,0,0);
-- Movie
INSERT INTO Joueur VALUES ('DarkVader', 'Giveinthedarkside', 'Skywalker', 'Anakin', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('MaîtreVert', 'AlEnversJeParle', '', 'Yoda', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Lambassadrice', 'CougarTown', 'Amidala', 'Padmé', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Jedu-Bid', 'Lastjedi', 'Skywalker', 'Luke', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Prof', 'FouetEtChapeau', 'Jones', 'Indiana', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('AlienKiller', 'secondLife', 'Ripley', 'Ellen', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Sonarseeker', 'godzillaExist', 'Joe', 'Brody', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Major', 'whoami', 'Kusanagi', 'Motoko', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Toruk Makto', 'navis', 'Sully', 'Jake', NULL, '2017-04-13', NULL, NULL,0,0);
-- Comics
INSERT INTO Joueur VALUES ('IronMan', 'TheBest', 'Stark', 'Tony', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('CaptainAmerica', 'LoveBucky', 'Roger', 'Steve', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Batman', 'Batcode', 'Wayne', 'Bruce', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Superman', 'KriptoPhobe', 'Kent', 'Clark', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('WonderWoman', 'LassoVerite', 'Prince', 'Diana', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Harley', 'dinguedeJ', 'Quinzel', 'Harleen', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Catwoman', 'jewels', 'Kyle', 'Selina', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('ProfX', 'mutants', 'Xavier', 'Charles', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('GreenArrow', 'carquois', 'Quinn', 'Oliver', NULL, '2017-04-13', NULL, NULL,0,0);
-- Game
INSERT INTO Joueur VALUES ('PèreFondateur', 'PuckMan', 'Man', 'Pack', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Plombierdu59', 'ItsME', 'Super', 'Mario', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('PrincessePlage', 'BowsersGirl', 'Peach', 'Princess', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('HiaHIA', 'Hyrule=IRule', 'Kokiri', 'Link', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Hérissondu59', 'ChaosControl', 'TheHedgehog', 'Sonic', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('Sara Namus', 'ZeroSuit', 'Aran', 'Samus', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('TazmaniedeSony', 'SnoobNaughtyDog', 'Bandicoot', 'Crash', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('GrosPoings', 'RayCharles', 'Man', 'Ray', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('SourisElectrique', 'OndineMaChose', 'Kachu', 'Pi', NULL, '2017-04-13', NULL, NULL,0,0);
-- Franchise
INSERT INTO Joueur VALUES ('PilleusedeTombes', 'SeinsTriangle', 'Croft', 'Lara', NULL, '2017-04-13', NULL, NULL,0,0);
INSERT INTO Joueur VALUES ('PilleurdeFranchise', 'RemplacelesBoobs', 'Drake', 'Nathan', NULL, '2017-04-13', NULL, NULL,0,0);



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
INSERT INTO log(Id_plat, html) VALUES (1,'<div class="row"><p class="log">Delni a rejoint la partie !</p></div><hr>');

INSERT INTO Jouer VALUES (2, 'Blondie',4);
INSERT INTO Jouer VALUES (2, 'DelaLune', 13);
INSERT INTO log(Id_plat, html) VALUES (2,'<div class="row"><p class="log">DelaLune a rejoint la partie !</p></div><hr>');

INSERT INTO Jouer VALUES (3, 'BlazDark', 27);
INSERT INTO Jouer VALUES (3,'Delni',40);
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log">Delni a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (3,'Blondie', 0);
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log">Blondie a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (3,'DelaLune',0);
INSERT INTO log(Id_plat, html) VALUES (3,'<div class="row"><p class="log">DelaLune a rejoint la partie !</p></div><hr>');

INSERT INTO Jouer VALUES (4,'Superman',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Superman a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Batman',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Batman a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'TazmaniedeSony',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">TazmaniedeSony a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Hérissondu59',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Hérissondu59 a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'PilleusedeTombes',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">PilleusedeTombe a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Delni',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Delni a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'SourisElectrique',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">SourisElectrique a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'Poupii',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">Poupii a rejoint la partie !</p></div><hr>');
INSERT INTO Jouer VALUES (4,'LHommeFemme',0);
INSERT INTO log(Id_plat, html) VALUES (4,'<div class="row"><p class="log">LHommeFemme a rejoint la partie !</p></div><hr>');

INSERT INTO Historique(Pseudo, Score, Nom, Nom_Gagnant, Score_Gagnant) VALUES('Delni',12, 'LaPartieDeLEgalite', 'DarkVader',42);
INSERT INTO Historique(Pseudo, Score, Nom, Nom_Gagnant, Score_Gagnant) VALUES('BlazDark', 12, 'LaPartieDeLEgalite', 'DarkVader',42);

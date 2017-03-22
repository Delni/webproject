CREATE DATABASE `6nimmt`;
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
-- Foreign Key for Id_Plat is at the very end, cause Plateau has not been created yet!
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

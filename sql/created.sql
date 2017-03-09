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
PRIMARY KEY (Pseudo)
);

CREATE TABLE Carte (
Id_Carte int,
Poids int, 
PRIMARY KEY (Id_Carte)
);

CREATE TABLE Pile (
Id_Pile int,
Id_Plat int, 
PRIMARY KEY (Id_Pile)
);

CREATE TABLE Plateau (
Id_Plat int, 
Id_Pile1 int, 
Id_Pile2 int,
Id_Pile3 int,
Id_Pile4 int,
Nom varchar(50),
Createur varchar(50),
Prive int,
PRIMARY KEY (Id_Plat),
CONSTRAINT Fk_Createur FOREIGN KEY (Createur) REFERENCES Joueur(Pseudo),
CONSTRAINT Fk_Id_Pile1 FOREIGN KEY (Id_Pile1) REFERENCES Pile(Id_Pile),
CONSTRAINT Fk_Id_Pile2 FOREIGN KEY (Id_Pile2) REFERENCES Pile(Id_Pile),
CONSTRAINT Fk_Id_Pile3 FOREIGN KEY (Id_Pile3) REFERENCES Pile(Id_Pile),
CONSTRAINT Fk_Id_Pile4 FOREIGN KEY (Id_Pile4) REFERENCES Pile(Id_Pile)
);

CREATE TABLE Main (
Id_Main int,
Pseudo varchar(50),
Id_Plat int, 
PRIMARY KEY (Id_Main),
CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat),
CONSTRAINT Fk_Pseudo FOREIGN KEY (Pseudo) REFERENCES Joueur(Pseudo)
);

ALTER TABLE Pile ADD CONSTRAINT Fk_Id_Plat FOREIGN KEY (Id_Plat) REFERENCES Plateau(Id_Plat);



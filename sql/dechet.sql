-- Déchet

-- Pile
-- Id_Carte1 int,
-- Id_Carte2 int,
-- Id_Carte3 int,
-- Id_Carte4 int,
-- Id_Carte5 int,
-- CONSTRAINT Fk_Id_Carte1 FOREIGN KEY (Id_Carte1) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte2 FOREIGN KEY (Id_Carte2) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte3 FOREIGN KEY (Id_Carte3) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte4 FOREIGN KEY (Id_Carte4) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte5 FOREIGN KEY (Id_Carte5) REFERENCES Carte(Id_Carte),

-- Main
-- Id_Carte1 int,
-- Id_Carte2 int,
-- Id_Carte3 int,
-- Id_Carte4 int,
-- Id_Carte5 int,
-- Id_Carte6 int,
-- Id_Carte7 int,
-- Id_Carte8 int,
-- Id_Carte9 int,
-- Id_Carte10 int,
-- CONSTRAINT Fk_Id_Carte1 FOREIGN KEY (Id_Carte1) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte2 FOREIGN KEY (Id_Carte2) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte3 FOREIGN KEY (Id_Carte3) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte4 FOREIGN KEY (Id_Carte4) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte5 FOREIGN KEY (Id_Carte5) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte6 FOREIGN KEY (Id_Carte6) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte7 FOREIGN KEY (Id_Carte7) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte8 FOREIGN KEY (Id_Carte8) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte9 FOREIGN KEY (Id_Carte9) REFERENCES Carte(Id_Carte),
-- CONSTRAINT Fk_Id_Carte10 FOREIGN KEY (Id_Carte10) REFERENCES Carte(Id_Carte)


-- CREATE TABLE Etre_Dans (
-- Id_Pile int, 
-- PRIMARY KEY (Id_Plat),
-- CONSTRAINT Fk_Id_Pile FOREIGN KEY (Id_Pile) REFERENCES Pile(Id_Pile)
-- );

-- CREATE TABLE Jouer (
-- Id_Plat int, 
-- Id_Pile int, 
-- PRIMARY KEY (Id_Plat),
-- CONSTRAINT Fk_Id_Pile FOREIGN KEY (Id_Pile) REFERENCES Pile(Id_Pile)
-- );

-- CREATE TABLE Contenir (
-- Id_Main int, 
-- Id_Carte int, 
-- Carte_Id_Carte int,
-- PRIMARY KEY (Id_Main,Id_Carte),
-- CONSTRAINT Fk_Id_Pile FOREIGN KEY (Id_Pile) REFERENCES Pile(Id_Pile)
-- );
-- Afficher la liste des joueurs triés par ordre alphabétique
SELECT Prenom, Nom, PSEUDO FROM joueur ORDER BY Nom, Prenom

-- Afficher les parties créées par un utilisateur
SELECT Id_Plat, nom FROM plateau WHERE createur='Delni'

-- Afficher les différents types de cartes
SELECT DISTINCT poids FROM carte

-- Lister les joueurs d'une partie
SELECT Pseudo FROM Jouer WHERE Id_plat=2

-- Lister les parties auxquelles un utilisateur peut s'inscrire aujourd'hui
SELECT ID_Plat FROM Jouer WHERE Id_Plat IN (SELECT COUNT(Id_Plat) as compte FROM Jouer GROUP BY Id_Plat WHERE compte<10)

-- Compter le nombre de cartes des 'tas' des joueurs d'une partie








-- Rechercher l'utilisateur 'Dupont' né le 5 février 1996
SELECT Nom LIKE 'Dupont' FROM User WHERE naissance='1996-02-05'

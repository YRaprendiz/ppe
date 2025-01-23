-- Script de migration de la base de données
-- Sauvegarde des données existantes
CREATE TABLE IF NOT EXISTS Utilisateurs_Backup AS SELECT * FROM Utilisateurs;
CREATE TABLE IF NOT EXISTS Photos_Backup AS SELECT * FROM Photos;
CREATE TABLE IF NOT EXISTS Chambres_Backup AS SELECT * FROM Chambres;
CREATE TABLE IF NOT EXISTS Reservations_Backup AS SELECT * FROM Reservations;

-- Suppression des contraintes de clé étrangère existantes
ALTER TABLE Reservations
DROP FOREIGN KEY Reservations_ibfk_1,
DROP FOREIGN KEY Reservations_ibfk_2;

-- Mise à jour de la table Utilisateurs
ALTER TABLE Utilisateurs
MODIFY COLUMN Mdp VARCHAR(255) NOT NULL,
MODIFY COLUMN User_role ENUM('Admin', 'Client') DEFAULT 'Client',
DROP COLUMN Images;

-- Mise à jour de la table Photos
ALTER TABLE Photos
MODIFY COLUMN Description VARCHAR(100) NOT NULL,
ADD COLUMN ID_Chambre INT AFTER Description;

-- Mise à jour de la table Chambres
ALTER TABLE Chambres
DROP COLUMN Images,
DROP COLUMN Chambre_000,
DROP COLUMN Descriptif,
MODIFY COLUMN Type_Chambre ENUM('Simple', 'Double', 'Triple', 'Suite') NOT NULL,
CHANGE COLUMN Stat Statut ENUM('Disponible', 'Occupée', 'En maintenance') NOT NULL DEFAULT 'Disponible';

-- Mise à jour de la table Reservations
ALTER TABLE Reservations
DROP COLUMN Date_Reservation,
CHANGE COLUMN Date_CheckIn Date_Debut DATE NOT NULL,
CHANGE COLUMN Date_CheckOut Date_Fin DATE NOT NULL,
CHANGE COLUMN Statut Statut_Reservation ENUM('En attente', 'Confirmée', 'Annulée') NOT NULL DEFAULT 'En attente';

-- Recréation des clés étrangères
ALTER TABLE Reservations
ADD CONSTRAINT fk_reservation_utilisateur
FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
ADD CONSTRAINT fk_reservation_chambre
FOREIGN KEY (ID_Chambres) REFERENCES Chambres(ID_Chambres);

-- Mise à jour des données dans Photos pour lier aux chambres
UPDATE Photos p
JOIN Chambres c ON c.ID_Chambres = p.ID_Chambre
SET p.ID_Chambre = c.ID_Chambres
WHERE p.ID_Chambre IS NOT NULL;

-- Mise à jour des statuts de réservation
UPDATE Reservations
SET Statut_Reservation = 'Confirmée'
WHERE Statut_Reservation = 'En attente';

-- Script de vérification des données
SELECT 'Nombre d\'utilisateurs' as Table_Info, COUNT(*) as Nombre FROM Utilisateurs
UNION ALL
SELECT 'Nombre de photos', COUNT(*) FROM Photos
UNION ALL
SELECT 'Nombre de chambres', COUNT(*) FROM Chambres
UNION ALL
SELECT 'Nombre de réservations', COUNT(*) FROM Reservations;

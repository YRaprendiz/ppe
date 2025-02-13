-- Improved Database Script for Hotel Reservation System
DROP DATABASE IF EXISTS ppe;
CREATE DATABASE IF NOT EXISTS ppe CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ppe;

-- Enhanced Users Table
CREATE TABLE IF NOT EXISTS Utilisateurs (
    ID_Utilisateur INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Mdp VARCHAR(255) NOT NULL,
    User_role ENUM('Admin', 'Client', 'Staff') DEFAULT 'Client',
    Date_Inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Derniere_Connexion TIMESTAMP NULL,
    Statut ENUM('Actif', 'Inactif', 'Suspendu') DEFAULT 'Actif',
    Avatar VARCHAR(255) NULL,
    Telephone VARCHAR(20) NULL,
    PRIMARY KEY (ID_Utilisateur),
    INDEX idx_email (Email)
) ENGINE=InnoDB;

-- Improved Rooms Table
CREATE TABLE IF NOT EXISTS Chambres (
    ID_Chambres INT NOT NULL AUTO_INCREMENT,
    Numero_Chambre VARCHAR(10) NOT NULL UNIQUE,
    Type_Chambre ENUM('Simple', 'Double', 'Triple', 'Suite', 'Familiale') NOT NULL,
    Capacite INT NOT NULL,
    Prix DECIMAL(10,2) NOT NULL,
    Statut ENUM('Disponible', 'Occupée', 'En maintenance', 'Réservée') NOT NULL DEFAULT 'Disponible',
    Description TEXT,
    Equipements SET('Toilettes', 'Lit', 'Parking', 'Wi-Fi', 'Déjeuner', 'Climatisation', 'TV', 'Minibar') DEFAULT NULL,
    Etage INT,
    Vue ENUM('Ville', 'Mer', 'Jardin', 'Piscine') NULL,
    PRIMARY KEY (ID_Chambres),
    INDEX idx_type_statut (Type_Chambre, Statut)
) ENGINE=InnoDB;

-- Enhanced Reservations Table
CREATE TABLE IF NOT EXISTS Reservations (
    ID_Reservation INT NOT NULL AUTO_INCREMENT,
    ID_Utilisateur INT NOT NULL,
    ID_Chambres INT NOT NULL,
    Date_Debut DATETIME NOT NULL,
    Date_Fin DATETIME NOT NULL,
    Nombre_Personnes INT NOT NULL DEFAULT 1,
    Prix_Total DECIMAL(10,2) NOT NULL,
    Statut_Reservation ENUM('En attente', 'Confirmée', 'Annulée', 'Terminée') NOT NULL DEFAULT 'En attente',
    Methode_Paiement ENUM('Carte Crédit', 'Paypal', 'Espèces', 'Virement') NULL,
    Date_Reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Commentaires TEXT NULL,
    PRIMARY KEY (ID_Reservation),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (ID_Chambres) REFERENCES Chambres(ID_Chambres) ON DELETE RESTRICT,
    INDEX idx_date_statut (Date_Debut, Date_Fin, Statut_Reservation)
) ENGINE=InnoDB;

-- Photos Table with More Context
CREATE TABLE IF NOT EXISTS Photos (
    ID_Photos INT NOT NULL AUTO_INCREMENT,
    ID_Chambre INT NOT NULL,
    Chemin_Image VARCHAR(255) NOT NULL,
    Description VARCHAR(200) NULL,
    Type_Image ENUM('Principale', 'Intérieur', 'Extérieur', 'Vue') NOT NULL,
    Date_Ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID_Photos),
    FOREIGN KEY (ID_Chambre) REFERENCES Chambres(ID_Chambres) ON DELETE CASCADE,
    INDEX idx_chambre (ID_Chambre)
) ENGINE=InnoDB;

-- Audit Log Table for Tracking Important Changes
CREATE TABLE IF NOT EXISTS Journal_Audit (
    ID_Audit INT NOT NULL AUTO_INCREMENT,
    Table_Concernee VARCHAR(50) NOT NULL,
    ID_Enregistrement INT NOT NULL,
    Action ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    Utilisateur_ID INT NULL,
    Date_Action TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Anciennes_Valeurs TEXT NULL,
    Nouvelles_Valeurs TEXT NULL,
    PRIMARY KEY (ID_Audit),
    FOREIGN KEY (Utilisateur_ID) REFERENCES Utilisateurs(ID_Utilisateur) ON DELETE SET NULL,
    INDEX idx_date_table (Date_Action, Table_Concernee)
) ENGINE=InnoDB;

-- Triggers for Audit Logging (Example for Reservations)
DELIMITER //

CREATE TRIGGER before_insert_reservation 
BEFORE INSERT ON Reservations
FOR EACH ROW
BEGIN
    INSERT INTO Journal_Audit 
    (Table_Concernee, ID_Enregistrement, Action, Utilisateur_ID, Nouvelles_Valeurs)
    VALUES 
    ('Reservations', NEW.ID_Reservation, 'INSERT', NEW.ID_Utilisateur, 
     CONCAT('Date_Debut: ', NEW.Date_Debut, ', Date_Fin: ', NEW.Date_Fin, 
            ', Statut: ', NEW.Statut_Reservation));
END;//

DELIMITER ;

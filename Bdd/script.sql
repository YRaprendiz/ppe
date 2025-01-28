-- Script de création de la base de données
CREATE DATABASE IF NOT EXISTS ppe;
USE ppe;

CREATE TABLE IF NOT EXISTS Utilisateurs (
    ID_Utilisateur INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Mdp VARCHAR(255) NOT NULL,
    User_role ENUM('Admin', 'Client') DEFAULT 'Client',
    PRIMARY KEY (ID_Utilisateur)
);

CREATE TABLE IF NOT EXISTS Photos (
    ID_Photos INT NOT NULL AUTO_INCREMENT,

    Description VARCHAR(100) NOT NULL,
    ID_Chambre INT,
    PRIMARY KEY (ID_Photos)
);

CREATE TABLE IF NOT EXISTS Chambres (
    ID_Chambres INT NOT NULL AUTO_INCREMENT,
    Images LONGBLOB NOT NULL,
    Type_Chambre ENUM('Simple', 'Double', 'Triple', 'Suite') NOT NULL,
    Statut ENUM('Disponible', 'Occupée', 'En maintenance') NOT NULL DEFAULT 'Disponible',
    Prix DECIMAL(10,2) NOT NULL,
    Description text DEFAULT 'Toilettes, Lit, Localisation, Parking, Wi-Fi, Déjeuner, Check-in et Check-out horaires',
    Image longblob NOT NULL,
    PRIMARY KEY (ID_Chambres)
);

CREATE TABLE IF NOT EXISTS Reservations (
    ID_Reservation INT NOT NULL AUTO_INCREMENT,
    ID_Utilisateur INT NOT NULL,
    ID_Chambres INT NOT NULL,
    Date_Debut DATE NOT NULL,
    Date_Fin DATE NOT NULL,
    Statut_Reservation ENUM('En attente', 'Confirmée', 'Annulée') NOT NULL DEFAULT 'En attente',
    PRIMARY KEY (ID_Reservation),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur),
    FOREIGN KEY (ID_Chambres) REFERENCES Chambres(ID_Chambres)
r) REFERENCES Utilisateurs(ID_Utilisateur)
);

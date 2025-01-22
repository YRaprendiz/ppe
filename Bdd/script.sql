CREATE DATABASE ppe_hotel;

USE ppe_hotel;

CREATE TABLE Utilisateurs (

	ID_Utilisateur INT NOT NULL AUTO_INCREMENT,
	Nom VARCHAR(50) NOT NULL,
	Prenom VARCHAR(50) NOT NULL,
	Email VARCHAR(100) NOT NULL UNIQUE,
	Mdp VARCHAR(100) NOT NULL,
	User_role ENUM('Client','Admin','Test3','Test4') NOT NULL DEFAULT 'Client' 
	Images longblob NOT NULL,
    PRIMARY KEY (ID_Utilisateur)
);

CREATE TABLE Photos (

	ID_Photos INT NOT NULL AUTO_INCREMENT,
	Images longblob NOT NULL,
	description VARCHAR(100) NOT NULL,
	PRIMARY KEY (ID_Photos)
);

CREATE TABLE IF NOT EXISTS Chambres (
    ID_Chambres INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Images LONGBLOB NOT NULL,
    Chambre_000 VARCHAR(50) NOT NULL UNIQUE,
    Type_Chambre ENUM('Single', 'Double', 'Triple', 'Test4') NOT NULL,
    Stat ENUM('Disponible', 'Réservé', 'Hors de service') DEFAULT 'Disponible',
    Prix DECIMAL(10, 2) NOT NULL,
    Descriptif VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS Reservations (
    ID_Reservation INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_Chambres INT NOT NULL,
    ID_Utilisateur INT NOT NULL,
    Date_Reservation DATE NOT NULL,
    Date_CheckIn DATE NOT NULL,
    Date_CheckOut DATE NOT NULL,
    Statut ENUM('Confirmée', 'Annulée') DEFAULT 'Confirmée',
    FOREIGN KEY (ID_Chambres) REFERENCES Chambres(ID_Chambres),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateurs(ID_Utilisateur)
);

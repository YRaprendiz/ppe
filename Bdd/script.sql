-- Criação da base de dados
CREATE DATABASE IF NOT EXISTS ppe_hotel;
USE ppe_hotel;

-- Tabela UTILISATEURS
CREATE TABLE UTILISATEURS (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    roles ENUM('client', 'admin') NOT NULL COMMENT 'Type de utilisateur',
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    pass VARCHAR(255) NOT NULL,
    telephone VARCHAR(20)
);

-- Tabela CHAMBRES
CREATE TABLE CHAMBRES (
    id_chambre INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único da chambre
    chambres_number VARCHAR(50) NOT NULL, -- Número da chambre
    chambre_type VARCHAR(100) NOT NULL, -- Tipo da chambre
    prix DECIMAL(10, 2) NOT NULL, -- Preço da chambre
    status ENUM('disponible', 'reserve', 'hors de service') NOT NULL, -- Status da chambre
    description TEXT DEFAULT NULL, -- Descrição da chambre (opcional)
    image VARCHAR(255) DEFAULT NULL, -- Caminho da imagem (opcional)
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de adição (adicionada automaticamente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela RESERVATIONS
CREATE TABLE RESERVATIONS (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_chambre INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    prix_total DECIMAL(10, 2) NOT NULL,
    statut ENUM('pending', 'confirmed', 'canceled') NOT NULL,
    FOREIGN KEY (id_user) REFERENCES UTILISATEURS(id_user),
    FOREIGN KEY (id_chambre) REFERENCES CHAMBRES(id_chambre)
);

-- Tabela PAIEMENTS
CREATE TABLE PAIEMENTS (
    id_paiement INT AUTO_INCREMENT PRIMARY KEY,
    id_reservation INT NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    date_paiement DATETIME NOT NULL,
    methode VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_reservation) REFERENCES RESERVATIONS(id_reservation)
);

-- Tabela CATEGORIES
CREATE TABLE CATEGORIES (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

-- Tabela PRODUITS
CREATE TABLE PRODUITS (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    id_categorie INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    description TEXT,
    FOREIGN KEY (id_categorie) REFERENCES CATEGORIES(id_categorie)
);

-- Tabela COMMANDES
CREATE TABLE COMMANDES (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_reservation INT NOT NULL,
    date_commande DATETIME NOT NULL,
    statut VARCHAR(20) NOT NULL,
    montant_total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_reservation) REFERENCES RESERVATIONS(id_reservation)
);

-- Tabela de ligação COMMANDES_PRODUITS
CREATE TABLE COMMANDES_PRODUITS (
    id_commande INT NOT NULL,
    id_produit INT NOT NULL,
    quantite INT NOT NULL,
    PRIMARY KEY (id_commande, id_produit),
    FOREIGN KEY (id_commande) REFERENCES COMMANDES(id_commande),
    FOREIGN KEY (id_produit) REFERENCES PRODUITS(id_produit)
);
=============================================================================================================
projet web avec méthode de code MVC ("Model", "Vue" et "Controller") appelé ``PPE_Hotel`` hébergé localement avec 'XAMPP' sur une machine Windows avec base de données SQL appelée `ppe_hotel` avec les codes suivants pour
/bootstrap ,/images
"bdd.php","ControllerUser.php","index.php","ModelUser.php","script.sql","VueAccueil.php","VueInscription.php","VueLogin.php","VueNavbar.php","VueProfil.php".

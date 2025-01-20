<?php
// Bdd/bdd.php - Configuration de la base de données
try {
    $user = "root"; // Nom d'utilisateur de la base de données
    $pass = "";    // Mot de passe de la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=ppe_hotel', $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur ! : " . $e->getMessage());
}
?>
<!-- bdd.php 
class BaseModel {
    public $bdd;

    public function __construct() {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=ppe_hotel', 'root', '');

        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage() . "<br>");
        }
    }
}

class FlashMessage {
    public static function set($type, $message) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash'] = [            'type' => $type,            'message' => $message        ];
    }

    public static function display() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['flash'])) {
            $type = $_SESSION['flash']['type'];
            $message = $_SESSION['flash']['message'];
            echo "<div class='alert alert-{$type} text-center'>{$message}</div>";
            unset($_SESSION['flash']);
        }
    }
}
-->

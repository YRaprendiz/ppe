<!-- Bdd/bdd.php                -->

<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=ppe;charset=utf8', 'root', '', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
} catch(PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
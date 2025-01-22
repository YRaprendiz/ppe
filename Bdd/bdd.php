<!-- Bdd/bdd.php                -->

<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=ppe_hotel', "root", "");
}
catch(PDOException $e){
print "Erreur! :" . $e->getMessage() . "<br/>";
die();
}
?>
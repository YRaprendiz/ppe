<?php

$chambres = $controller->listerChambres();
foreach ($chambres as $chambre) {
    echo "<div>";
    echo "<h3>{$chambre['Chambre_000']} ({$chambre['Type_Chambre']})</h3>";
    echo "<p>{$chambre['Descriptif']}</p>";
    echo "<p>Prix : {$chambre['Prix']} EUR</p>";
    if ($chambre['Stat'] === 'Disponible') {
        echo "<form action='Controller/ChambreController.php' method='POST'>";
        echo "<input type='hidden' name='idChambre' value='{$chambre['ID_Chambres']}'>";
        echo "<label>Date Check-in :</label><input type='date' name='checkIn' required><br>";
        echo "<label>Date Check-out :</label><input type='date' name='checkOut' required><br>";
        echo "<input type='hidden' name='action' value='reserverChambre'>";
        echo "<input type='submit' value='Réserver'>";
        echo "</form>";
    } else {
        echo "<p>Statut : {$chambre['Stat']}</p>";
    }
    echo "</div>";
}
?>
<?php
$chambres = $controller->listerChambres();

foreach ($chambres as $chambre) {
    echo "<div style='border: 1px solid #ddd; padding: 10px; margin-bottom: 15px;'>";
    // Afficher l'image décodée
    echo "<div style='text-align: center; margin-bottom: 10px;'>";
    if (!empty($chambre['Images'])) {
        $imageData = base64_encode($chambre['Images']); // Encoder les données en base64
        echo "<img src='data:image/jpeg;base64,{$imageData}' alt='Image de la chambre' style='max-width: 100%; height: auto;'>";
    } else {
        echo "<p>Aucune image disponible</p>";
    }
    echo "</div>";
    
    // Afficher les détails de la chambre
    echo "<h3>{$chambre['Chambre_000']} ({$chambre['Type_Chambre']})</h3>";
    echo "<p>{$chambre['Descriptif']}</p>";
    echo "<p><strong>Prix :</strong> {$chambre['Prix']} EUR</p>";

    // Afficher le statut et la possibilité de réserver
    if ($chambre['Stat'] === 'Disponible') {
        echo "<form action='Controller/ChambreController.php' method='POST'>";
        echo "<input type='hidden' name='idChambre' value='{$chambre['ID_Chambres']}'>";
        echo "<label for='checkIn'>Date Check-in :</label>";
        echo "<input type='date' name='checkIn' required><br>";
        echo "<label for='checkOut'>Date Check-out :</label>";
        echo "<input type='date' name='checkOut' required><br>";
        echo "<input type='hidden' name='action' value='reserverChambre'>";
        echo "<button type='submit'>Réserver</button>";
        echo "</form>";
    } else {
        echo "<p><strong>Statut :</strong> {$chambre['Stat']}</p>";
    }

    echo "</div>";
}
?>

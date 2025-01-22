<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une Chambre</title>
</head>
<body>
    <h1>Réserver une Chambre</h1>
    <?php
    $idChambre = $_GET['id'] ?? null;
    if ($idChambre) {
        echo "<form action='../Controller/ChambreController2.php' method='POST'>
            <input type='hidden' name='action' value='reserver'>
            <input type='hidden' name='idChambre' value='{$idChambre}'>
            <label for='idUtilisateur'>ID Utilisateur :</label>
            <input type='number' name='idUtilisateur' id='idUtilisateur' required>
            <br>
            <label for='dateCheckIn'>Date Check-In :</label>
            <input type='date' name='dateCheckIn' id='dateCheckIn' required>
            <br>
            <label for='dateCheckOut'>Date Check-Out :</label>
            <input type='date' name='dateCheckOut' id='dateCheckOut' required>
            <br>
            <button type='submit'>Réserver</button>
        </form>";
    } else {
        echo "<p>ID de chambre non fourni.</p>";
    }
    ?>
</body>
</html>

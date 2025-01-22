<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Chambre</title>
</head>
<body>
    <h1>Modifier une Chambre</h1>
    <?php
    include('./Model/ChambreModel2.php');
    include('./Bdd/bdd.php');
    $idChambre = $_GET['id'] ?? null;
    $chambreModel = new ChambreModel($bdd);

    if ($idChambre) {
        $chambre = $chambreModel->getChambres()[$idChambre - 1]; // Approche simplifiée
        echo "<form action='../Controller/ChambreController.php' method='POST'>
            <input type='hidden' name='action' value='modifier'>
            <input type='hidden' name='id' value='{$chambre['ID_Chambres']}'>
            <label for='type'>Type :</label>
            <select name='type' id='type' required>
                <option value='Single' " . ($chambre['Type_Chambre'] == 'Single' ? 'selected' : '') . ">Single</option>
                <option value='Double' " . ($chambre['Type_Chambre'] == 'Double' ? 'selected' : '') . ">Double</option>
                <option value='Triple' " . ($chambre['Type_Chambre'] == 'Triple' ? 'selected' : '') . ">Triple</option>
                <option value='Test4' " . ($chambre['Type_Chambre'] == 'Test4' ? 'selected' : '') . ">Test4</option>
            </select>
            <br>
            <label for='prix'>Prix :</label>
            <input type='number' step='0.01' name='prix' id='prix' value='{$chambre['Prix']}' required>
            <br>
            <label for='descriptif'>Descriptif :</label>
            <input type='text' name='descriptif' id='descriptif' value='{$chambre['Descriptif']}' required>
            <br>
            <label for='stat'>Statut :</label>
            <select name='stat' id='stat'>
                <option value='Disponible' " . ($chambre['Stat'] == 'Disponible' ? 'selected' : '') . ">Disponible</option>
                <option value='Réservé' " . ($chambre['Stat'] == 'Réservé' ? 'selected' : '') . ">Réservé</option>
                <option value='Hors de service' " . ($chambre['Stat'] == 'Hors de service' ? 'selected' : '') . ">Hors de service</option>
            </select>
            <br>
            <button type='submit'>Modifier</button>
        </form>";
    } else {
        echo "<p>ID de chambre non fourni.</p>";
    }
    ?>
</body>
</html>

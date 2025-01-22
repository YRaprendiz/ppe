<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Chambres</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gestion des Chambres</h1>

    <!-- Formulaire pour ajouter une chambre -->
    <h2>Ajouter une nouvelle chambre</h2>
    <form action="../Controller/ChambreController2.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="ajouter">
        <label for="image">Image :</label>
        <input type="file" name="image" id="image" required>
        <br>
        <label for="chambreNum">Numéro de Chambre :</label>
        <input type="text" name="chambreNum" id="chambreNum" required>
        <br>
        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            <option value="Triple">Triple</option>
            <option value="Test4">Test4</option>
        </select>
        <br>
        <label for="prix">Prix :</label>
        <input type="number" step="0.01" name="prix" id="prix" required>
        <br>
        <label for="descriptif">Descriptif :</label>
        <input type="text" name="descriptif" id="descriptif" required>
        <br>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Tableau des chambres existantes -->
    <h2>Liste des chambres</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Numéro</th>
                <th>Type</th>
                <th>Prix</th>
                <th>Statut</th>
                <th>Descriptif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('./Model/ChambreModel.php');
            include('./Bdd/bdd.php');
            $chambreModel = new ChambreModel($bdd);
            $chambres = $chambreModel->getChambres();

            foreach ($chambres as $chambre) {
                echo "<tr>
                    <td>{$chambre['ID_Chambres']}</td>
                    <td><img src='data:image/jpeg;base64," . base64_encode($chambre['Images']) . "' alt='Image Chambre' style='width: 100px; height: 100px;'></td>
                    <td>{$chambre['Chambre_000']}</td>
                    <td>{$chambre['Type_Chambre']}</td>
                    <td>{$chambre['Prix']} €</td>
                    <td>{$chambre['Stat']}</td>
                    <td>{$chambre['Descriptif']}</td>
                    <td>
                        <form action='../Controller/ChambreController.php' method='POST' style='display: inline-block;'>
                            <input type='hidden' name='action' value='supprimer'>
                            <input type='hidden' name='id' value='{$chambre['ID_Chambres']}'>
                            <button type='submit'>Supprimer</button>
                        </form>
                        <form action='ModifierChambreView.php' method='GET' style='display: inline-block;'>
                            <input type='hidden' name='id' value='{$chambre['ID_Chambres']}'>
                            <button type='submit'>Modifier</button>
                        </form>
                        <form action='ReserverChambreView.php' method='GET' style='display: inline-block;'>
                            <input type='hidden' name='id' value='{$chambre['ID_Chambres']}'>
                            <button type='submit'>Réserver</button>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

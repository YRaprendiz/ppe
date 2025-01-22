<?php
include('./Bdd/bdd.php');
include('./Model/ChambreModel.php');
$chambreModel = new ChambreModel($bdd);
$chambres = $chambreModel->getChambres();

if (isset($_GET['message'])) echo '<p style="color: green;">' . htmlspecialchars($_GET['message']) . '</p>';
if (isset($_GET['error'])) echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
?>

<h1>Gestion des Chambres</h1>

<h2>Ajouter une Chambre</h2>
<form action="../Controller/ChambreController.php" method="POST" enctype="multipart/form-data">
    <label for="image">Image :</label>
    <input type="file" name="image" id="image" required><br>
    <label for="chambreCode">Code Chambre :</label>
    <input type="text" name="chambreCode" id="chambreCode" required><br>
    <label for="type">Type :</label>
    <select name="type" id="type" required>
        <option value="Single">Single</option>
        <option value="Double">Double</option>
        <option value="Triple">Triple</option>
        <option value="Test4">Test4</option>
    </select><br>
    <label for="prix">Prix :</label>
    <input type="number" step="0.01" name="prix" id="prix" required><br>
    <label for="descriptif">Descriptif :</label>
    <input type="text" name="descriptif" id="des

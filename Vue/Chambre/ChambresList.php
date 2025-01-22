<!-- ChambreList.php-->
<?php
include ('./Bdd/bdd.php');
include ('./Controller/ChambreController.php');
//session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php?page=photos');
    exit();
}
?>

<h1>Liste des Chambres</h1>

<?php if ($_SESSION['user']['User_role'] === 'Admin') : ?>
    <a href="../../Controller/ChambreController.php?action=add">Ajouter une Chambre</a>
<?php endif; ?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Numéro</th>
        <th>Type</th>
        <th>Statut</th>
        <th>Prix</th>
        <th>Descriptif</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($chambres as $chambre) : ?>
        <tr>
            <td><?= $chambre['ID_Chambres'] ?></td>
            <td><img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']) ?>" alt="Image Chambre" style="width: 100px; height: 100px;"></td>
            <td><?= $chambre['Chambre_000'] ?></td>
            <td><?= $chambre['Type_Chambre'] ?></td>
            <td><?= $chambre['Stat'] ?></td>
            <td><?= $chambre['Prix'] ?> €</td>
            <td><?= $chambre['Descriptif'] ?></td>
            <td>
                <a href="reservationsForm.php?action=reserve&id=<?= $chambre['ID_Chambres'] ?>">Réserver</a>
                <?php if ($_SESSION['user']['User_role'] === 'Admin') : ?>
                    | <a href="chambresForm.php?action=edit&id=<?= $chambre['ID_Chambres'] ?>">Modifier</a>
                    | <a href="chambresController.php?action=delete&id=<?= $chambre['ID_Chambres'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette chambre ?');">Supprimer</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
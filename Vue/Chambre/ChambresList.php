<?php
include('./Bdd/bdd.php');
include ('./Model/ChambresModel.php');

$ChambresModel = new ChambresModel($bdd);
$chambres = $ChambresModel->getAllChambres();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Liste des Chambres</h1>
            
            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['Role'] === 'admin'): ?>
                <div class="mb-4">
                    <a href="index.php?page=chambreForm" class="btn btn-primary">Ajouter une chambre</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Numéro</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Prix</th>
                            <th>Description</th>
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['Role'] === 'admin'): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chambres as $chambre): ?>
                            <tr>
                                <td>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($chambre['Images']) ?>" 
                                         alt="Image Chambre" 
                                         class="img-thumbnail"
                                         width="100" height="100">
                                </td>
                                <td><?= htmlspecialchars($chambre['Chambre_000']) ?></td>
                                <td><?= htmlspecialchars($chambre['Type_Chambre']) ?></td>
                                <td>
                                    <span class="badge <?= $chambre['Stat'] ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $chambre['Stat'] ? 'Disponible' : 'Occupée' ?>
                                    </span>
                                </td>
                                <td><?= number_format($chambre['Prix'], 2, ',', ' ') ?> €</td>
                                <td><?= htmlspecialchars($chambre['Descriptif']) ?></td>
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['Role'] === 'admin'): ?>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?page=chambreForm&id=<?= $chambre['ID_Chambres'] ?>" 
                                               class="btn btn-warning btn-sm">Modifier</a>
                                            <form action="chambresController.php" method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $chambre['ID_Chambres'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Voulez-vous vraiment supprimer cette chambre ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
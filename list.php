<?php
require_once "../config/database.php";

$livres = $pdo->query("SELECT livres.*, categories.nom as categorie_nom 
                       FROM livres 
                       LEFT JOIN categories ON livres.id_categorie = categories.id
                       ORDER BY livres.titre")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des livres</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="content">
    <div class="topbar">
        <h2>Liste des livres</h2>
        <a href="../dashboard.php" class="back-link">← Retour au Dashboard</a>
    </div>

    <div class="table-section">
        <a href="add.php" class="add-button">➕ Ajouter un livre</a>

        <?php if (empty($livres)): ?>
            <p>Aucun livre trouvé. Ajoutez-en un !</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($livres as $livre): ?>
                    <tr>
                        <td><?= $livre['id'] ?></td>
                        <td><?= htmlspecialchars($livre['titre']) ?></td>
                        <td><?= htmlspecialchars($livre['categorie_nom']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $livre['id'] ?>" class="edit">Modifier</a>
                            <a href="delete.php?id=<?= $livre['id'] ?>" class="delete" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<?php
require_once "../config/database.php";

$message = '';
$error = '';

$categories = $pdo->query("SELECT * FROM categories ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $id_categorie = $_POST['id_categorie'] ?? '';

    if ($titre && $id_categorie) {
        try {
            $stmt = $pdo->prepare("INSERT INTO livres (titre, id_categorie) VALUES (?, ?)");
            $stmt->execute([$titre, $id_categorie]);
            $message = 'Livre ajouté avec succès !';
        } catch (PDOException $e) {
            $error = 'Erreur : ' . $e->getMessage();
        }
    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter un livre</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-container">
    <h2>Ajouter un livre</h2>

    <?php if ($message): ?>
        <div class="success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Titre du livre</label>
        <input type="text" name="titre" placeholder="Ex: Le Petit Prince" required>

        <label>Catégorie</label>
        <select name="id_categorie" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Ajouter</button>
        <a href="list.php" class="back-link">← Retour à la liste</a>
    </form>
</div>
</body>
</html>

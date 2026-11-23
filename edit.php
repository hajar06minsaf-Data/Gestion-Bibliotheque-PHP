<?php
require_once "../config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->execute([$id]);
$livre = $stmt->fetch();

if (!$livre) {
    die("Livre introuvable");
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY nom")->fetchAll();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $id_categorie = $_POST['id_categorie'] ?? '';

    if ($titre && $id_categorie) {
        $stmt = $pdo->prepare("UPDATE livres SET titre = ?, id_categorie = ? WHERE id = ?");
        $stmt->execute([$titre, $id_categorie, $id]);
        $message = 'Livre mis à jour avec succès !';
        $livre['titre'] = $titre;
        $livre['id_categorie'] = $id_categorie;
    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier un livre</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-container">
    <h2>Modifier un livre</h2>

    <?php if ($message): ?>
        <div class="success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Titre du livre</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>

        <label>Catégorie</label>
        <select name="id_categorie" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id']==$livre['id_categorie']?'selected':'' ?>>
                <?= htmlspecialchars($cat['nom']) ?>
            </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Mettre à jour</button>
        <a href="list.php" class="back-link">← Retour à la liste</a>
    </form>
</div>
</body>
</html>

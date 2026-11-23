<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

require_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Bibliothèque</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Sidebar - AVEC Catégories -->
    <aside class="sidebar">
        <h2 class="logo">Biblio<span>Tech</span></h2>
        <ul>
            <li class="active">📊 Dashboard</li>
            <li><a href="crud_principal/list.php" style="color: white; text-decoration: none;">📚 Livres</a></li>
            <li><a href="crud_secondaire/list.php" style="color: white; text-decoration: none;">🏷 Catégories</a></li>
            <li><a href="#" style="color: white; text-decoration: none; opacity: 0.7;">👥 Utilisateurs</a></li>
            <li><a href="#" style="color: white; text-decoration: none; opacity: 0.7;">📦 Emprunts</a></li>
            <li><a href="#" style="color: white; text-decoration: none; opacity: 0.7;">⚙ Paramètres</a></li>
            <li class="logout"><a href="logout.php" style="color: #ff6b6b; text-decoration: none;">🚪 Déconnexion</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content">

        <!-- Top Bar -->
        <header class="topbar">
            <h2>Tableau de Bord</h2>
            <div class="user">
                <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                <img src="image/admin.jpg" alt="Admin">
            </div>
        </header>

        <!-- Cards -->
        <section class="cards">
            <div class="card">
                <h3>📚 Total Livres</h3>
                <p>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM livres");
                    $result = $stmt->fetch();
                    echo $result['total'];
                    ?>
                </p>
            </div>
            
            <div class="card">
                <h3>🏷 Catégories</h3>
                <p>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM categories");
                    $result = $stmt->fetch();
                    echo $result['total'];
                    ?>
                </p>
            </div>
            
            <div class="card">
                <h3>👥 Utilisateurs</h3>
                <p>
                    <?php
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
                    $result = $stmt->fetch();
                    echo $result['total'];
                    ?>
                </p>
            </div>
            
            <div class="card">
                <h3>📦 Emprunts</h3>
                <p>0</p>
            </div>
        </section>

        <!-- Table Section -->
        <section class="table-section">
            <h3>📚 Derniers Livres</h3>
            <a href="crud_principal/add.php" class="add-button">➕ Ajouter un Livre</a>
            
            <?php
            $stmt = $pdo->query("SELECT livres.id, livres.titre, categories.nom AS categorie 
                                FROM livres 
                                LEFT JOIN categories ON livres.id_categorie = categories.id 
                                ORDER BY livres.id DESC 
                                LIMIT 5");
            $livres = $stmt->fetchAll();
            ?>
            
            <?php if (empty($livres)): ?>
                <div style="text-align: center; padding: 30px; background: white; border-radius: 10px; margin-top: 20px;">
                    <p style="color: #666; font-size: 16px; margin-bottom: 20px;">
                        Aucun livre dans la bibliothèque.
                    </p>
                    <a href="crud_principal/add.php" class="add-button">Ajouter votre premier livre</a>
                </div>
            <?php else: ?>
                <table style="margin-top: 20px;">
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
                            <td><?= htmlspecialchars($livre['categorie'] ?? 'Non catégorisé') ?></td>
                            <td>
                                <a href="crud_principal/edit.php?id=<?= $livre['id'] ?>" class="edit">Modifier</a>
                                <a href="crud_principal/delete.php?id=<?= $livre['id'] ?>" class="delete" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre?')">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div style="margin-top: 20px; text-align: center;">
                    <a href="crud_principal/list.php" class="add-button" style="background: #3498db;">
                        Voir tous les livres (<?php 
                        $stmt = $pdo->query("SELECT COUNT(*) as total FROM livres");
                        $total = $stmt->fetch();
                        echo $total['total'];
                        ?>)
                    </a>
                </div>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>
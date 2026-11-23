<?php
require_once "../config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
?>

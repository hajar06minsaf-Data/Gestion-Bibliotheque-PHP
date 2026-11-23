<?php
session_start();
session_destroy(); // Utilisez session_destroy() seulement
header('Location: login.php');
exit;
?>

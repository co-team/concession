<?php
global $pdo;
session_start();
require_once ('../db.php');
// Vérifier les autorisations
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}



// Vérifier si un ID est fourni dans l'URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM users WHERE id = $id";

    if ($pdo->query($sql) === TRUE) {
        echo "Utilisateur supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : ";
    }
} else {
    echo "Aucun ID d'utilisateur spécifié.";
}


header("Location: admin_manage_users.php");
exit();
?>


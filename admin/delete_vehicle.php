<?php
global $pdo;
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
require_once ('../db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM vehicules WHERE id = $id";

    if ($pdo->query($sql) === TRUE) {
        echo "Véhicule supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du véhicule : ";
    }
} else {
    echo "Aucun ID de véhicule spécifié.";
}


header("Location: admin_manage_vehicles.php");
exit();
?>


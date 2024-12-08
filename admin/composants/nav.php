<?php
//session_start();

// Vérifier si l'utilisateur est connecté et a le rôle 'user'
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");  // Rediriger vers la page de connexion si non autorisé
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Concessionnaire Automobile</title>

</head>
<style>
    /* Style général pour la navbar */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: #333;
        color: #fff;
        font-family: Arial, sans-serif;
    }

    .navbar a {
        color: #fff;
        text-decoration: none;
        margin-right: 15px;
    }

    .navbar-brand a {
        font-size: 24px;
        font-weight: bold;
    }

    .navbar-links {
        list-style: none;
        display: flex;
        padding: 0;
    }

    .navbar-links li {
        margin-right: 20px;
    }

    .navbar-user {
        display: flex;
        align-items: center;
    }

    .navbar-user span {
        margin-right: 10px;
        font-size: 16px;
    }

    .logout-button {
        padding: 5px 10px;
        background-color: #ff4b4b;
        border: none;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .logout-button:hover {
        background-color: #ff0000;
    }

</style>
<body>
<nav class="navbar">
    <div class="navbar-brand">
        <a href="dashboard.php">Concessionnaire Auto</a>
    </div>
    <ul class="navbar-links">
        <li><a href="../admin_manage_users.php">Gestion des utilisateurs</a></li>
        <li><a href="../admin_manage_vehicles.php">Gestion des véhicules</a></li>
        <li><a href="../admin_settings.php">Paramètres</a></li>
    </ul>
    <div class="navbar-user">
       <span>Bienvenue <?= $_SESSION['username'] ?></span>

        <a href="../logout.php" class="logout-button">Déconnexion</a>
    </div>
</nav>
</body>
</html>


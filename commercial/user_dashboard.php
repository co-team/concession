<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle 'user'
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");  // Rediriger vers la page de connexion si non autorisé
    exit();
}

// Code spécifique à l'utilisateur
//echo "<h1>Bienvenue " .  . " !</h1>";
// Vous pouvez ajouter des fonctionnalités pour les utilisateurs réguliers ici.
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Utilisateur - Concessionnaire Automobile</title>
    <link rel="stylesheet" href="dash.css">
</head>
<body>
<?php
require_once ('../admin/composants/nav.php')
?>
<div class="dashboard">


    <!-- Barre de recherche pour les clients -->
    <div class="search-section">
        <input type="text" id="search-client" placeholder="Rechercher informations client (nom, ID)">
        <button onclick="searchClient()">Rechercher</button>
    </div>

    <!-- Section des véhicules -->
    <div class="vehicles-section">
        <h2>Véhicules disponibles</h2>
        <div class="vehicle-card" id="vehicle-list">
            <!-- Exemple de carte de véhicule -->
            <div class="vehicle">
                <div class="vehicle-carousel">
                    <img src="images/vehicle1.jpg" alt="Image Véhicule" class="vehicle-image active">
                    <img src="images/vehicle2.jpg" alt="Image Véhicule" class="vehicle-image">
                    <img src="images/vehicle3.jpg" alt="Image Véhicule" class="vehicle-image">
                    <!-- Navigation du carrousel -->
                    <button class="carousel-button prev" onclick="previousImage(this)">&#10094;</button>
                    <button class="carousel-button next" onclick="nextImage(this)">&#10095;</button>
                </div>
                <div class="vehicle-details">
                    <h3>Marque: Toyota</h3>
                    <p>Modèle: Corolla</p>
                    <p>Année: 2022</p>
                    <p>Prix: 20,000 €</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

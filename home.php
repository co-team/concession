<?php
global $pdo;
require_once ('db.php');
include_once ('./admin/composants/navbar.php');
// Requête pour récupérer les véhicules et leurs images
$sql = "SELECT v.id, v.marque, v.modele, v.annee, v.prix, i.chemin_image
        FROM vehicules v
        JOIN images_vehicules i ON v.id = i.vehicule_id
        ORDER BY v.id";
$result = $pdo->query($sql);

// Vérification des erreurs dans la requête SQL
if (!$result) {
    echo "Erreur dans la requête SQL : ";
}

$vehicles = [];
while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
    // Vérifiez que l'ID existe dans chaque ligne avant de l'utiliser
    if (isset($row['id'])) {
        // Utilisation de l'ID comme clé pour organiser les données des véhicules
        $vehicles[$row['id']]['details'] = $row;
        $vehicles[$row['id']]['images'][] = $row['chemin_image'];
        $vehicles[$row['id']]['marque'] = $row['id'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Concessionnaire Automobile</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* Styles généraux */


        /* Menu de navigation */
        nav {
            background-color: #333;
            padding: 10px;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #5A67D8;
        }

        /* Conteneur général du catalogue */
        .catalogue-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
        }

        /* Liste des véhicules */
        .vehicle-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Carte de chaque véhicule */
        .vehicle-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
        }

        /* Image du véhicule */
        .vehicle-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Détails du véhicule */
        .vehicle-details {
            padding: 15px;
            text-align: center;
        }

        .vehicle-details h3 {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .vehicle-details p {
            font-size: 1.1em;
            color: #333;
        }

        .vehicle-details .btn-details {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .vehicle-details .btn-details:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <!-- Menu de navigation -->
    <nav>
        <a href="#">Accueil</a>
        <a href="#">Catalogue</a>
        <a href="#">Crédits</a>
        <a href="#">Contact</a>
    </nav>

    <!-- Titre principal -->


    <!-- Conteneur principal -->
    <div class="container">
        <div class="catalogue-container">
            <h1>Catalogue des Véhicules</h1>

            <div >
                <?php
                // Affichage des cartes de véhicule
                foreach ($vehicles as $vehicle) {
                    echo '<div class="vehicle-card">';
                    echo '<div class="vehicle-carousel">';
                    foreach ($vehicle['images'] as $index => $chemin_image) {
                        $activeClass = $index === 0 ? 'active' : '';
                        echo '<img src="./admin/' . $chemin_image . '" class="vehicle-image ' . $activeClass . '" alt="Image Véhicule">';
                    }
                    echo '<button class="carousel-button prev" onclick="previousImage(this)">&#10094;</button>';
                    echo '<button class="carousel-button next" onclick="nextImage(this)">&#10095;</button>';
                    echo '</div>';
                    echo '<div class="vehicle-details">';
                    echo '<h3>Marque: ' . $vehicle['details']['marque'] . '</h3>';
                    echo '<p>Modèle: ' . $vehicle['details']['modele'] . '</p>';
                    echo '<p>Année: ' . $vehicle['details']['annee'] . '</p>';
                    echo '<p>Prix: ' . $vehicle['details']['prix'] . ' €</p>';
                    echo '<a href="details.php?id=' . $vehicle['details']['id'] . '" >detail</a>';
                    echo '</div></div>';
                }
                ?>
            <script src="script.js"></script>

</body>
</html>

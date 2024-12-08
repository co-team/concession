<?php
// Connexion à la base de données avec PDO
global $pdo;
require_once ('db.php');
require_once ('./admin/composants/navbar.php');
// Récupérer l'ID du véhicule depuis l'URL
$vehicle_id = isset($_GET['id']) ? $_GET['id'] : null;

// Si l'ID du véhicule est présent, on continue avec la récupération des informations
if ($vehicle_id) {
    // Requête SQL pour obtenir les détails du véhicule
    $sql = "SELECT v.id, v.marque, v.modele, v.annee, v.prix,v.stock, i.chemin_image,c.vehicule_id,c.type_moteur,c.transmission,c.carburant,c.puissance,c.couleur,c.nb_portes,c.description FROM vehicules v JOIN images_vehicules i ON v.id = i.vehicule_id INNER JOIN caracteristiques c ON v.id = c.vehicule_id WHERE v.id = :vehicle_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
    $stmt->execute();

    // Vérifier si le véhicule a été trouvé
    if ($stmt->rowCount() > 0) {
        // Récupérer les données du véhicule
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Aucun véhicule trouvé.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Véhicule</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <h3 class="text-center">Détails du Véhicule <b class="text-success"><?= htmlspecialchars($vehicle['marque']) ?></b></h3>

            <?php


            // Requête pour récupérer les chemins d'images
            $vehicle_id = $_GET['id']; // L'ID du véhicule pour lequel on souhaite récupérer les images
            $sql_images = "SELECT chemin_image FROM images_vehicules WHERE vehicule_id = :vehicle_id";
            $stmt_images = $pdo->prepare($sql_images);
            $stmt_images->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
            $stmt_images->execute();

            // Stockage des chemins d'images dans un tableau JavaScript
            $images = [];
            while ($row = $stmt_images->fetch(PDO::FETCH_ASSOC)) {
                $images[] = 'admin/' . htmlspecialchars($row['chemin_image']);
            }
            ?>


                <style>
                    /* Style pour le diaporama d'images */
                    .slideshow-container {
                        width: 100%;
                        height: 490px;
                        background-size: cover;
                        background-position: center;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                        transition: background-image 0.8s ease-in-out; /* Transition en fondu */
                    }

                    /* Style pour la carte des détails du véhicule */
                    .card {
                        border: none;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }

                    .card-title {
                        font-weight: bold;
                        color: #333;
                    }

                    .card-text {
                        font-size: 1rem;
                        color: #555;
                    }

                    .card .card-text strong {
                        color: #000;
                    }

                    h6 {
                        font-weight: bold;
                        margin-top: 1rem;
                        color: #444;
                    }

                    /* Marges et espacement */
                    .container {
                        max-width: 900px;
                    }

                    .row {
                        margin-top: 20px;
                    }

                    .card-body {
                        padding: 1.5rem;
                    }

                    .card-text {
                        margin-bottom: 0.8rem;
                    }

                    /* Animation du diaporama */
                    @keyframes fadeInOut {
                        from {
                            opacity: 0;
                        }
                        to {
                            opacity: 1;
                        }
                    }

                    .slideshow-container {
                        animation: fadeInOut 1s ease-in-out both; /* Effet d’apparition en fondu */
                    }

                    /* Styles réactifs pour mobile */
                    @media (max-width: 768px) {
                        .slideshow-container {
                            height: 250px;
                        }

                        .card-text {
                            font-size: 0.9rem;
                        }
                    }


                </style>





    <div class="container my-5">
        <div class="row">
            <!-- Diaporama d'images du véhicule -->
            <div class="col-md-12 mb-5">
                <div class="slideshow-container" id="slideshow"></div>
            </div>

            <!-- Informations détaillées du véhicule -->
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h6 class="card-title">Marque et Modèle </h6>
                    <p class="card-text"><strong>Marque :</strong> <?= htmlspecialchars($vehicle['marque']) ?></p>
                    <p class="card-text"><strong>Modèle :</strong> <?= htmlspecialchars($vehicle['modele']) ?></p>
                    <p class="card-text"><strong>Année :</strong> <?= htmlspecialchars($vehicle['annee']) ?></p>
                    <p class="card-text"><strong>Prix :</strong> <?= htmlspecialchars($vehicle['prix']) ?> €</p>
                    <p class="card-text"><strong>Stock :</strong> <?= htmlspecialchars($vehicle['stock']) ?> unités</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h6>Caractéristiques Techniques</h6>
                    <p class="card-text"><strong>Type de Moteur :</strong> <?= htmlspecialchars($vehicle['type_moteur']) ?></p>
                    <p class="card-text"><strong>Transmission :</strong> <?= htmlspecialchars($vehicle['transmission']) ?></p>
                    <p class="card-text"><strong>Carburant :</strong> <?= htmlspecialchars($vehicle['carburant']) ?></p>
                    <p class="card-text"><strong>Puissance :</strong> <?= htmlspecialchars($vehicle['puissance']) ?> CV</p>
                    <p class="card-text"><strong>Couleur :</strong> <?= htmlspecialchars($vehicle['couleur']) ?></p>
                    <p class="card-text"><strong>Nombre de Portes :</strong> <?= htmlspecialchars($vehicle['nb_portes']) ?></p>


                </div>
            </div>
            <div class="col-4">
                <div class="card p-4 h-100">
                <p class="card-text"><strong>Description :</strong> <?= nl2br(htmlspecialchars($vehicle['description'])) ?></p>
               <p class="card-text"><small class=""><a href="simulationscript.php?id=<?=$vehicle_id ?>">simuler</a></small></p>
            </div>
        </div>
    </div>


            <script>
                // Images récupérées de PHP et converties en JavaScript
                const images = <?php echo json_encode($images); ?>;
                let currentIndex = 0;

                function changeBackgroundImage() {
                    const slideshow = document.getElementById("slideshow");
                    slideshow.style.backgroundImage = `url(${images[currentIndex]})`;

                    // Passer à l'image suivante, revenir à la première après la dernière
                    currentIndex = (currentIndex + 1) % images.length;
                }

                // Charger la première image immédiatement
                changeBackgroundImage();

                // Changer l'image toutes les 3 secondes, sans pause entre les transitions
                setInterval(changeBackgroundImage, 3000);
            </script>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

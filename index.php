<?php
global $pdo;
require_once './admin/composants/navbar.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Véhicules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .vehicle-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .carousel-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .image-container img {
            width: 100%;
            transition: transform 0.3s ease; /* Transition pour effet de zoom */
        }

        .image-container:hover img {
            transform: scale(1.2); /* Zoom à 120% */
        }
    </style>
</head>
<body>

<div class="container my-4">
    <div class="row">
        <?php
        require_once('db.php');

        // Requête pour obtenir les véhicules et leurs images
        $sql = "SELECT v.id, v.marque, v.modele, v.prix, MIN(i.chemin_image) AS chemin_image
                FROM vehicules v
                LEFT JOIN images_vehicules i ON v.id = i.vehicule_id
                GROUP BY v.id, v.marque, v.modele
                ORDER BY v.prix ASC LIMIT 6";

        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $vehicleId = $row['id'];
                $marque = $row['marque'];
                $modele = $row['modele'];
                $prix = $row['prix'];
                $cheminImage = $row['chemin_image'];

                // Requête pour obtenir toutes les images du véhicule
                $imageSql = "SELECT chemin_image FROM images_vehicules WHERE vehicule_id = :vehiculeId";
                $stmt = $pdo->prepare($imageSql);
                $stmt->execute(['vehiculeId' => $vehicleId]);

                $images = [];
                while ($imageRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $images[] = $imageRow['chemin_image']; // Récupérer chaque image
                }

                // Afficher les informations du véhicule et son carrousel d'images
                echo "<div class='col-4'>";
                echo "<div class='vehicle-card'>";

                // Carrousel d'images
                echo "<div id='carousel-$vehicleId' class='carousel slide' data-bs-ride='carousel' data-bs-interval='3000'>";
                echo "<div class='carousel-inner'>";

                // Images du véhicule
                foreach ($images as $index => $image) {
                    $activeClass = ($index === 0) ? 'active' : '';
                    echo "<div class='carousel-item $activeClass'>
                            <img src='./admin/$image' class='carousel-image' alt='$marque $modele'>
                          </div>";
                }

                echo "</div>";
                echo "<button class='carousel-control-prev' type='button' data-bs-target='#carousel-$vehicleId' data-bs-slide='prev'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                        <span class='visually-hidden'>Previous</span>
                      </button>
                      <button class='carousel-control-next' type='button' data-bs-target='#carousel-$vehicleId' data-bs-slide='next'>
                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                        <span class='visually-hidden'>Next</span>
                      </button>
                    </div>"; // Fin du carrousel

                echo "<h5 class='mt-3'>Marque: " . htmlspecialchars($marque) . "</h5>";
                echo "<h5 class='mt-3'>Modèle: " . htmlspecialchars($modele) . "</h5>";
                echo "<h5 class='mt-3'>Prix: " . htmlspecialchars($prix) . " €</h5>";

                echo "</div>"; // Fin de vehicle-card
                echo "</div>"; // Fin de col-4
            }
        } else {
            echo "<p>Aucun véhicule trouvé.</p>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

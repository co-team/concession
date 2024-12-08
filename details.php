<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "concessionnaire");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier la présence de l'ID dans l'URL et qu'il est valide
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour récupérer les informations du véhicule et ses images
    $sql = "SELECT v.id, v.marque, v.modele, v.annee, v.prix, i.chemin_image
            FROM vehicules v
            LEFT JOIN images_vehicules i ON v.id = i.vehicule_id
            WHERE v.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $vehicle = [
            'images' => []
        ];

        while ($row = $result->fetch_assoc()) {
            if (empty($vehicle['marque'])) {
                $vehicle['marque'] = $row['marque'];
                $vehicle['modele'] = $row['modele'];
                $vehicle['annee'] = $row['annee'];
                $vehicle['prix'] = $row['prix'];
            }
            $vehicle['images'][] = $row['chemin_image'];
        }
    } else {
        echo "Aucun véhicule trouvé pour cet ID.";
        exit;
    }
} else {
    echo "ID de véhicule non valide.";
    exit;
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Véhicule</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le CSS -->
</head>
<style>
    /* Conteneur principal pour les détails du véhicule */
    .vehicle-details {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-top: 100px;
    }

    /* Titre du véhicule */
    .vehicle-details h3 {
        font-size: 1.8em;
        color: #333;
        margin-bottom: 10px;
    }

    /* Informations complémentaires (année, prix) */
    .vehicle-details p {
        font-size: 1.2em;
        color: #666;
        margin: 5px 0;
    }

    /* Style de base du carrousel */
    .vehicle-carousel {
        position: relative;
        max-width: 100%;
        height: 400px;
        overflow: hidden;
        margin-top: 15px;
        border-radius: 8px;
    }

    .carousel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .carousel-image.active {
        opacity: 1;
    }

    .carousel-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2em;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 50%;
        z-index: 1;
    }

    .carousel-button.prev {
        left: 10px;
    }

    .carousel-button.next {
        right: 10px;
    }


    /* Style général pour la page */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        line-height: 1.6;
    }

</style>
<body>
<?php
require_once ('./admin/composants/navbar.php');
?>
<div class="vehicle-details">

    <!-- Carrousel d'images -->
    <div class="vehicle-carousel">
        <?php foreach ($vehicle['images'] as $index => $image): ?>
            <img src="./admin/<?php echo htmlspecialchars($image); ?>"
                 class="carousel-image <?php echo $index === 0 ? 'active' : ''; ?>"
                 alt="Image du Véhicule">
        <?php endforeach; ?>
        <button class="carousel-button prev" onclick="previousImage()">&#10094;</button>
        <button class="carousel-button next" onclick="nextImage()">&#10095;</button>
    </div>
    <h3><?php echo htmlspecialchars($vehicle['marque']) . ' ' . htmlspecialchars($vehicle['modele']); ?></h3>
    <p>Année: <?php echo htmlspecialchars($vehicle['annee']); ?></p>
    <p>Prix: <?php echo number_format($vehicle['prix'], 0, ',', ' ') . ' €'; ?></p>


</div>

<script>
    let currentIndex = 0;
    const images = document.querySelectorAll('.carousel-image');

    function showImage(index) {
        images.forEach((img, i) => {
            img.classList.toggle('active', i === index);
        });
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function previousImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }

    // Initialiser l'image active
    showImage(currentIndex);

    // Auto-carousel toutes les 3 secondes
    setInterval(nextImage, 3000);

</script>

</body>
</html>

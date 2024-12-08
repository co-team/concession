<?php
global $pdo;
include 'db.php';
include_once ('./admin/composants/navbar.php');

//$sql = "SELECT * FROM vehicules";
//$stmt = $pdo->query($sql);
//$vehicules = $stmt->fetchAll();
//
//foreach ($vehicules as $vehicule) {
//    echo "Marque : " . $vehicule['marque'] . "<br>";
//    echo "Modèle : " . $vehicule['modele'] . "<br>";
//    echo "Année : " . $vehicule['annee'] . "<br>";
//    echo "Prix : " . $vehicule['prix'] . "€<br>";
//    echo "Stock : " . $vehicule['stock'] . "<br><hr>";
//}
?>
    <link rel="stylesheet" href="index.css">
<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "concessionnaire");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Requête pour récupérer les véhicules et leurs images
$sql = "SELECT v.id, v.marque, v.modele, v.annee, v.prix, i.chemin_image
        FROM vehicules v
        JOIN images_vehicules i ON v.id = i.vehicule_id
        ORDER BY v.id";
$result = $conn->query($sql);

// Vérification des erreurs dans la requête SQL
if (!$result) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

$vehicles = [];
while ($row = $result->fetch_assoc()) {
    // Vérifiez que l'ID existe dans chaque ligne avant de l'utiliser
    if (isset($row['id'])) {
        // Utilisation de l'ID comme clé pour organiser les données des véhicules
        $vehicles[$row['id']]['details'] = $row;
        $vehicles[$row['id']]['images'][] = $row['chemin_image'];
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="index.css">

<div class="container">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($vehicles as $vehicle): ?>
            <div class="col">
                <a href="karak.php?id=<?= $vehicle['details']['id'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <!-- Carrousel d'images -->
                        <div id="carousel-<?= $vehicle['details']['id'] ?>" class="carousel slide vehicle-carousel" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($vehicle['images'] as $index => $chemin_image): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="./admin/<?= htmlspecialchars($chemin_image) ?>" class="card-img-top zoom-effect" alt="Image de véhicule">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Boutons de navigation du carrousel -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?= $vehicle['details']['id'] ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?= $vehicle['details']['id'] ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                        <!-- Détails du véhicule -->
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($vehicle['details']['marque']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($vehicle['details']['modele']) ?></p>
                            <p><?= htmlspecialchars($vehicle['details']['annee']) ?></p>
                            <p><?= htmlspecialchars($vehicle['details']['prix']) ?> €</p>
                        </div>
                        <a href="comparaison.php?id=<?= $vehicle['details']['id'] ?>">comparer</a>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Effet de zoom sur l'image */
    .zoom-effect {
        transition: transform 0.3s ease;
    }
    .zoom-effect:hover {
        transform: scale(1.1);
    }
</style>
<script src="script.js"></script>

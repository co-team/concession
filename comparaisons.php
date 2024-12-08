<?php
require_once ('db.php');
// Récupérer les véhicules sélectionnés
if (isset($_GET['vehicles'])) {
    $vehicles_ids = implode(',', $_GET['vehicles']);

    // Requête SQL pour obtenir les véhicules sélectionnés
    $sql = "SELECT * FROM vehicules WHERE id IN ($vehicles_ids)";
    $result = $pdo->query($sql);

    $vehicles = [];
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
        $vehicles[] = $row;
    }
} else {
    echo "Veuillez sélectionner des véhicules à comparer.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison de Véhicules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Comparaison de Véhicules</h1>

    <!-- Table de comparaison -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Marque</th>
            <th scope="col">Modèle</th>
            <th scope="col">Année</th>
            <th scope="col">Prix</th>
            <th scope="col">Options</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?= htmlspecialchars($vehicle['marque']) ?></td>
                <td><?= htmlspecialchars($vehicle['modele']) ?></td>
                <td><?= htmlspecialchars($vehicle['annee']) ?></td>
                <td><?= htmlspecialchars($vehicle['prix']) ?> €</td>
                <td>
                    <?php
                    // Récupérer les options pour chaque véhicule
                    $sql_options = "SELECT option_name FROM options_vehicule WHERE vehicule_id = " . $vehicle['id'];
                    $result_options = $pdo->query($sql_options);
                    while ($option = $result_options->fetchAll(PDO::FETCH_ASSOC)) {
                        echo $option['option_name'] . "<br>";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


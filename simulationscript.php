<?php
global $pdo;
require_once './admin/composants/navbar.php';

require_once('db.php');

// Vérifier si l'ID est défini et est un entier
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer une requête sécurisée
    $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Récupérer les données du véhicule
    $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($vehicule) {
        // Extraire le prix
        $prix = $vehicule['prix'];
      //  echo "Prix du véhicule : " . htmlspecialchars($prix);
    } else {
        echo "Aucun véhicule trouvé avec cet ID.";
    }
} else {
    echo "Vous voulez faire une simulation avec votre prix du vehicule neuf 😊?.";
}
?>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<div class="container">
<h3>Simulation de Crédit et Reprise</h3>
<form method="POST" action="simulation.php">
    Prix du véhicule: <input id="prix" type="number" name="prix" value="<?=$prix ?>" required><br>
    Valeur de reprise: <input type="number" name="reprise" required><br>
    Taux d'intérêt (%): <input type="number" step="0.01" name="taux_interet" required><br>
    Durée (en mois):  <label for="duree">Choisissez une durée :</label>
    <select name="duree" id="duree">
        <?php
        // Boucle pour générer les options, de 1 à 10 ans en mois
        for ($annees = 1; $annees <= 10; $annees++) {
            $mois = $annees * 12;
            echo "<option value='$mois'>{$mois} mois</option>";
        }
        ?>
    </select><br>
    <button type="submit">Simuler</button>
</form>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const prixField = document.getElementById("prix");

            // Vérifier si `id` est vide
            if (!idField.value) {
                idField.removeAttribute("readonly");
                idField.setAttribute("required", "true");
                prixField.removeAttribute("readonly");
                prixField.setAttribute("required", "true");
            }
        });
    </script>
</div>
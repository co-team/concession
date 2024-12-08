<form method="GET" action="comparaisons.php">
    <h3>Sélectionnez les véhicules à comparer :</h3>
    <?php
    require_once('db.php');

    try {
        // Récupérer tous les véhicules
        $sql = "SELECT id, marque, modele FROM vehicules";
        $result = $pdo->query($sql);

        // Vérifier si des véhicules existent
        if ($result->rowCount() > 0) {
            // Afficher chaque véhicule comme une case à cocher
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<input type="checkbox" name="vehicles[]" value="' . htmlspecialchars($row['id']) . '"> '
                    . htmlspecialchars($row['marque']) . ' ' . htmlspecialchars($row['modele']) . '<br>';
            }
        } else {
            echo "<p>Aucun véhicule disponible pour la comparaison.</p>";
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        echo "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
    <button type="submit" class="btn btn-primary">Comparer</button>
</form>


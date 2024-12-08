<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison de Véhicules</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles regroupés pour l'aperçu d'image et le formulaire */
        .image-preview {
            margin-top: 10px;
            text-align: center;
        }
        .preview-img {
            width: 150px;
            height: auto;
            border: 1px solid #ccc;
            padding: 5px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 1.2rem;
            margin: 10px 0;
            display: block;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            font-size: 1rem;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            font-size: 1.1rem;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<form method="post" action="compare.php">
    <label for="vehicle1">Sélectionnez le premier véhicule :</label>
    <select name="vehicle1" id="vehicle1" onchange="updateImagePreview('vehicle1', 'imagePreview1')">
        <?php
        require '../db.php';
        try {
            // Charger les véhicules avec leurs images
            $query = $pdo->query("
                SELECT v.id, v.marque, v.modele, v.annee, i.chemin_image
                FROM vehicules v
                JOIN images_vehicules i ON v.id = i.vehicule_id
                GROUP BY v.id
            ");
            if ($query->rowCount() > 0) {
                $vehicles = $query->fetchAll(PDO::FETCH_CLASSTYPE);
                foreach ($vehicles as $row) {
                    echo "<option value='{$row['id']}' data-image='../admin/{$row['chemin_image']}'>
                            {$row['marque']} {$row['modele']} ({$row['annee']})
                          </option>";
                }
            } else {
                echo "<option>Aucun véhicule disponible</option>";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        ?>
    </select>
    <div id="imagePreview1" class="image-preview"></div>

    <label for="vehicle2">Sélectionnez le deuxième véhicule :</label>
    <select name="vehicle2" id="vehicle2" onchange="updateImagePreview('vehicle2', 'imagePreview2')">
        <?php
        if (isset($vehicles)) {
            foreach ($vehicles as $row) {
                echo "<option value='{$row['id']}' data-image='../admin/{$row['chemin_image']}'>
                        {$row['marque']} {$row['modele']} ({$row['annee']})
                      </option>";
            }
        }
        ?>
    </select>
    <div id="imagePreview2" class="image-preview"></div>

    <button type="submit">Comparer</button>
</form>

<script>
    // Fonction pour mettre à jour l'aperçu de l'image selon la sélection
    function updateImagePreview(selectId, previewId) {
        const select = document.getElementById(selectId);
        const selectedOption = select.options[select.selectedIndex];
        const imagePath = selectedOption.getAttribute('data-image');

        // Afficher l'image dans l'élément de prévisualisation
        const previewDiv = document.getElementById(previewId);
        if (imagePath) {
            previewDiv.innerHTML = `<img src="${imagePath}" alt="Aperçu" class="preview-img">`;
        } else {
            previewDiv.innerHTML = "<p>Aucune image disponible</p>";
        }
    }
</script>

</body>
</html>

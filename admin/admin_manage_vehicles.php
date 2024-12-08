
<?php
global $pdo;
session_start();
require_once ('../db.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Query to fetch vehicle information
$sql = "SELECT id, marque, modele, annee, prix FROM vehicules";
$result = $pdo->query($sql);

// Include the header component
require_once ('./composants/body_header.php');
?>
<style>
    .button {
        width: 140px;
        height: 45px;
        font-family: 'Roboto', sans-serif;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        font-weight: 500;
        color: #000;
        background-color: #fff;
        border: none;
        border-radius: 45px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease 0s;
        cursor: pointer;
        outline: none;
    }

    .button:hover {
        background-color: #2EE59D;
        box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
        color: #fff;
        transform: translateY(-7px);
    }
    a{
        text-decoration: none;
    }
</style>
<h1>Gestion des Véhicules</h1>
<button class="button"><a  href="ajouter_vehicule.php">Ajouter un véhicule</a></button>
<table>
    <tr>
        <th>ID</th>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Année</th>
        <th>Prix</th>
        <th>Actions</th>
    </tr>

    <?php
    // Fetch all rows once and loop over them
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['marque']) ?></td>
            <td><?= htmlspecialchars($row['modele']) ?></td>
            <td><?= htmlspecialchars($row['annee']) ?></td>
            <td><?= htmlspecialchars($row['prix']) ?> €</td>
            <td>
                <button class="button"><a href="edit_vehicle.php?id=<?= htmlspecialchars($row['id']) ?>">Modifier</a></button> |
                    <button class="button"><a href="delete_vehicle.php?id=<?= htmlspecialchars($row['id']) ?>" onclick="return confirm('Supprimer ce véhicule ?')">Supprimer</a></button> |
                        <button class="button"><a href="image.php?id=<?= htmlspecialchars($row['id']) ?>">Ajouter des images</a></button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
// Include the footer component
require_once ('./composants/footer.php');
?>

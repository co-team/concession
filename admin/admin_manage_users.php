<?php
global $pdo;
session_start();
require_once ('../db.php');
// Vérifiez que l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}



// Gestion des opérations CRUD pour les utilisateurs ici (affichage, ajout, modification, suppression)

$sql = "SELECT id, username, email, role FROM users";
$result = $pdo->query($sql);
?>

    <?php
    require_once ('./composants/body_header.php');
    ?>

    <h1>Gestion des Utilisateurs</h1>
<a href="signup.php">Ajouter collaborateur</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetchAll(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['role'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['id'] ?>">Modifier</a> |
                    <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>

<?php
require_once ('./composants/footer.php');

?>


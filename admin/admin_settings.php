<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.html");
    exit();
}

require_once ('../db.php');
require_once ('./composants/body_header.php');

global $pdo;

// Récupérer tous les paramètres
$query = $pdo->query("SELECT * FROM settings");
$settings = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['settings_key']] = $row['settings_value'];
}

?>
<h1>Paramètres</h1>
<h2>Liste des Paramètres</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Email</th>
        <th>Logo</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($settings as $key => $value): ?>
        <tr>
            <td><?php echo isset($settings['id']) ? htmlspecialchars($settings['id']) : 'Non défini'; ?></td>
            <td><?php echo isset($settings['titre']) ? htmlspecialchars($settings['titre']) : 'Non défini'; ?></td>
            <td><?php echo isset($settings['email']) ? htmlspecialchars($settings['email']) : 'Non défini'; ?></td>
            <td>
                <?php if (isset($settings['logo'])): ?>
                    <img src="./uploads/logo/<?php echo htmlspecialchars($settings['logo']); ?>" alt="Logo" style="height: 50px;">
                <?php else: ?>
                    Logo non défini
                <?php endif; ?>
            </td>
            <td>
                <a href="settings.php?edit=<?php echo $key; ?>">Modifier</a> |
                <a href="settings.php?delete=<?php echo $key; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
require_once ('./composants/footer.php');
?>

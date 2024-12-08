<?php
global $pdo;
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
require_once ('../db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $pdo->query($sql);

    if ($result > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE id = $id";

    if ($pdo->query($sql) === TRUE) {
        echo "Utilisateur mis à jour avec succès.";
        header("Location: admin_manage_users.php");
        exit();
    } else {
        echo "Erreur de mise à jour : ";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="post">
    <label>Nom d'utilisateur:</label>
    <input type="text" name="username" value="<?= $user['username'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>

    <label>Rôle:</label>
    <select name="role">
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Utilisateur</option>
    </select>

    <button type="submit">Enregistrer</button>
</form>
</body>
</html>


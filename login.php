<?php
global $pdo;
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateurs WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        header("Location: dashboard_admin.php");
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<form method="POST">
    Nom d'utilisateur: <input type="text" name="username" required><br>
    Mot de passe: <input type="password" name="password" required><br>
    <button type="submit">Connexion</button>
</form>

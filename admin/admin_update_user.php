<?php
// Exemple de formulaire pour changer le rôle d'un utilisateur (admin seulement)
global $pdo;
if ($_SESSION['role'] == 'admin') {
    if (isset($_POST['new_role']) && isset($_POST['username'])) {
        $new_role = $_POST['new_role'];
        $username_to_update = $_POST['username'];

        // Mettre à jour le rôle de l'utilisateur dans la base de données
        $sql = "UPDATE users SET role='$new_role' WHERE username='$username_to_update'";

        if ($pdo->query($sql) === TRUE) {
            echo "Rôle mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du rôle : ";
        }
    }
}

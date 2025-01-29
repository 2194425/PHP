<?php
session_start();
require_once 'connectiondb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Controleer of de gebruiker bestaat
    $stmt = $conn->prepare("SELECT idaccounts, wachtwoorden FROM accounts WHERE gebruikersnaam = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Controleer het wachtwoord
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: users.php");
            exit();
        } else {
            header("Location: login.php?error=Foute inloggegevens");
            exit();
        }
    } else {
        header("Location: login.php?error=Gebruiker niet gevonden");
        exit();
    }
}
?>

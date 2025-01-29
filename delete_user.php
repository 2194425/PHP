<?php

$conn = require_once "connectiondb.php";

// Haal het ID van de gebruiker op uit de URL
$id = $_GET['id'] ?? null;

if ($id) {
    // Bereid de delete-query voor
    $stmt = $conn->prepare("DELETE FROM personen WHERE idpersonen = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Gegevens succesvol verwijderd, navigeren naar de overzichtspagina
        echo "Gegevens succesvol verwijderd!";
        header("Location: users.php"); // Terug naar overzichtspagina
        exit;
    } else {
        echo "Fout bij het verwijderen van gegevens: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Fout: Geen ID opgegeven voor verwijderen.";
}

$conn->close();
?>

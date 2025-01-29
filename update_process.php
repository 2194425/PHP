<?php

$conn = require_once "connectiondb.php";

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Haal de gegevens op uit het formulier
    $id = $_POST['idpersonen'] ?? null;
    $naam = $_POST['naam'] ?? '';
    $tussenvoegsel = $_POST['tussenvoegsel'] ?? '';
    $achternaam = $_POST['achternaam'] ?? '';
    $geboortedatum = $_POST['geboortedatum'] ?? '';
    $email = $_POST['E-mailadres'] ?? '';
    $telefoonnummer = $_POST['telefoonnummer'] ?? '';
    $geregistreerd = $_POST['geregistreerd'] ?? '';

    // Valideer verplichte velden
    if (empty($id) || empty($naam) || empty($achternaam) || empty($email)) {
        die("Fout: Alle verplichte velden moeten worden ingevuld.");
    }

    // Bereid de update-query voor
    $stmt = $conn->prepare("
        UPDATE personen 
        SET naam = ?, tussenvoegsel = ?, achternaam = ?, geboortedatum = ?, 
             `E-mailadres` = ?, telefoonnummer = ?, geregistreerd = ?
        WHERE idpersonen = ?
    ");

    // Bind parameters en voer de query uit
    $stmt->bind_param(
        "sssssssi",
        $naam,
        $tussenvoegsel,
        $achternaam,
        $geboortedatum,
        $email,
        $telefoonnummer,
        $geregistreerd,
        $id
    );

    if ($stmt->execute()) {
        echo "Gegevens succesvol bijgewerkt!";
        header("Location: users.php"); // Terug naar overzicht
        exit;
    } else {
        echo "Fout bij het bijwerken van gegevens: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Fout: Ongeldige aanvraag.";
}

$conn->close();

?>


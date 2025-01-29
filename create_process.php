<?php

$conn = require_once "connectiondb.php";


if ($conn->connect_error) {
    die("Fout bij verbinden met de database: " . $conn->connect_error);
}

// Haal gegevens op uit het formulier en valideer
$naam = $_POST['naam'] ?? '';
$tussenvoegsel = $_POST['tussenvoegsel'] ?? '';
$achternaam = $_POST['achternaam'] ?? '';
$geboortedatum = !empty($_POST['geboortedatum']) ? $_POST['geboortedatum'] : null; 
$email = $_POST['E-mailadres'] ?? '';
$telefoonnummer = $_POST['telefoonnummer'] ?? '';
$geregistreerd = $_POST['geregistreerd'] ?? '';

if (empty($naam) || empty($achternaam) || empty($email)) {
    echo "Fout: Alle verplichte velden moeten worden ingevuld.";
    exit; // Script stoppen als de vereiste velden niet zijn ingevuld
}


// Voorbereiden en uitvoeren van de query
$stmt = $conn->prepare("INSERT INTO personen (naam, tussenvoegsel, achternaam, geboortedatum, `E-mailadres`, telefoonnummer, geregistreerd) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $naam, $tussenvoegsel, $achternaam, $geboortedatum, $email, $telefoonnummer, $geregistreerd);

if ($stmt->execute()) {
    echo "Nieuwe gebruiker succesvol toegevoegd!";
} else {
    echo "Fout bij toevoegen: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>




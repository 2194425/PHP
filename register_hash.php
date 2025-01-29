<?php
require_once 'connectiondb.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoorden'];
    $rol = $_POST['rol'];
    $status = $_POST['status'];

    // Hash het wachtwoord
    $gehashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);


    $idpersoon = null;
    $queryCheckPerson = "SELECT idpersonen FROM personen WHERE naam = ?";
    if ($stmt = $conn->prepare($queryCheckPerson)) {
        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->bind_result($idpersoon);
        $stmt->fetch();
        $stmt->close();
    }

    // Voeg de persoon toe aan 'personen' als deze nog niet bestaat
    if (!$idpersoon) {
        $queryInsertPerson = "INSERT INTO personen (naam) VALUES (?)";
        if ($stmt = $conn->prepare($queryInsertPerson)) {
            $stmt->bind_param("s", $gebruikersnaam);
            $stmt->execute();
            $idpersoon = $conn->insert_id; // Haal het gegenereerde id op
            $stmt->close();
        }
    }

    // Voeg de gebruiker toe aan 'accounts'
    $queryInsertAccount = "INSERT INTO accounts (idaccounts, gebruikersnaam, wachtwoorden, rol, status) 
                           VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($queryInsertAccount)) {
        $stmt->bind_param("issss", $idpersoon, $gebruikersnaam, $gehashedWachtwoord, $rol, $status);
        if ($stmt->execute()) {
            echo "Gebruiker succesvol geregistreerd!";
        } else {
            echo "Fout bij het toevoegen aan accounts: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<?php

$conn = require_once "connectiondb.php";

// Haal ID op uit de URL
$id = $_GET['idpersonen'] ?? null;

if (!$id) {
    die("Fout: Geen ID opgegeven.");
}

// Haal huidige gegevens op
$stmt = $conn->prepare("SELECT * FROM personen WHERE idpersonen = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Fout: Geen gegevens gevonden.");
}

$data = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wijzig Gegevens</title>
</head>
<body>
    <h1>Wijzig Gegevens</h1>
    <form action="update_process.php" method="POST">
        <input type="hidden" name="idpersonen" value="<?php echo htmlspecialchars($data['idpersonen']); ?>">
        Naam: <input type="text" name="naam" value="<?php echo htmlspecialchars($data['naam']); ?>" required><br>
        Tussenvoegsel: <input type="text" name="tussenvoegsel" value="<?php echo htmlspecialchars($data['tussenvoegsel']); ?>"><br>
        Achternaam: <input type="text" name="achternaam" value="<?php echo htmlspecialchars($data['achternaam']); ?>" required><br>
        Geboortedatum: <input type="date" name="geboortedatum" value="<?php echo htmlspecialchars($data['geboortedatum']); ?>"><br>
        E-mailadres: <input type="email" name="E-mailadres" value="<?php echo htmlspecialchars($data['E-mailadres']); ?>" required><br>
        Telefoonnummer: <input type="text" name="telefoonnummer" value="<?php echo htmlspecialchars($data['telefoonnummer']); ?>"><br>
        Geregistreerd: <input type="text" name="geregistreerd" value="<?php echo htmlspecialchars($data['geregistreerd']); ?>"><br>
        <button type="submit">Opslaan</button>
    </form>
    <a href="users.php">Terug naar Overzicht</a>
</body>
</html>


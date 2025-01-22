<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personen; veilige gegevensophaling</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  // Inclusie van de databaseverbinding
  $conn = require_once "connectiondb.php";

  // Controleer of de verbinding succesvol is
  

  // SQL-query zonder parameter om alle gegevens op te halen
  $stmt = $conn->prepare("SELECT * FROM personen");
  if (!$stmt) {
    die("Fout bij het voorbereiden van de query: " . $conn->error);
  }

  // Voer de query uit
  $stmt->execute();
  $result = $stmt->get_result();

  // Controleer of er resultaten zijn
  if ($result->num_rows === 0) {
    echo "<p>Geen resultaten gevonden.</p>";
  } else {
    // Start de tabel
    echo "<table border='1'>";
    echo "<tr><th>idpersonen</th><th>naam</th><th>tussenvoegsel</th><th>achternaam</th><th>geboortedatum</th><th>E-mailadres</th><th>telefoonnummer</th><th>geregistreerd</th></tr>";

    // Loop door de resultaten en toon ze
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['idpersonen'] ?? '') . "</td>";
      echo "<td><a href='index.php?id=" . htmlspecialchars($row['idpersonen'] ?? '') . "'>" . htmlspecialchars($row['naam'] ?? '') . "</a></td>";
      echo "<td>" . htmlspecialchars($row['tussenvoegsel'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['achternaam'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['geboortedatum'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['E-mailadres'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['telefoonnummer'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['geregistreerd'] ?? '') . "</td>";
      echo "</tr>";
  }
  
    }
    echo "</table>";
  

  // Sluit de statement en de verbinding
  $stmt->close();
  $conn->close();
  ?>
</body>

</html>

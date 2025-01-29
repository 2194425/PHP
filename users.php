<?php
session_start();




// Stel sessie-verval in ( 10 minuten)
$inactive = 600; // 600 seconden = 10 minuten
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive)) {
    session_unset();
    session_destroy();
    header("Location: login.php?error=Sessie verlopen. Log opnieuw in.");
    exit();
}
$_SESSION['last_activity'] = time(); // Update laatste activiteit

if (!isset($_SESSION['user_id'])){

    header("location: login.php");
    exit();
}



  $conn = require_once "connectiondb.php";

// Haal alle gebruikers op
$result = $conn->query("SELECT * FROM personen");

if ($result->num_rows > 0): ?>
   

   <a href="logout.php" style="color: red; font-weight: bold;">Uitloggen</a>
   
   <h1>Gebruikers</h1>
   
   <a href="create_user.php" style="display: inline-block; margin-bottom: 15px; padding: 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Nieuwe gebruiker toevoegen</a>

   <table border="1">
        <tr>
            <th>idpersonen</th>
            <th>naam</th>
            <th>tussenvoegsel</th>
            <th>achternaam</th>
            <th>geboortedatum</th>
            <th>E-mailadres</th>
            <th>telefoonnummer</th>
            <th>geregistreerd</th>
            <th>acties</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['idpersonen']; ?></td>
                <td><?php echo $row['naam']; ?></td>
                <td><?php echo $row['tussenvoegsel']; ?></td>
                <td><?php echo $row['achternaam']; ?></td>
                <td><?php echo $row['geboortedatum']; ?></td>
                <td><?php echo $row['E-mailadres']; ?></td>
                <td><?php echo $row['telefoonnummer']; ?></td>
                <td><?php echo $row['geregistreerd']; ?></td>    
                <td>
          -   <a href="edit_user.php?idpersonen=<?php echo htmlspecialchars($row['idpersonen']); ?>">Bewerken</a> |
              <a href="delete_user.php?id=<?php echo $row['idpersonen']; ?>" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">Verwijderen</a>
                </td>
          
            </tr>

          
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Geen gebruikers gevonden.</p>
<?php endif; ?>

<?php $conn->close(); ?>

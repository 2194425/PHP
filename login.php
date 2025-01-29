<?php
session_start(); // Start de sessie bovenaan

// Controleer of de gebruiker al is ingelogd
if (isset($_SESSION['user_id'])) {
    header("Location: users.php"); // Als al ingelogd, doorverwijzen naar gebruikerspagina
    exit();
}

// Controleer op foutmeldingen in de URL
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/lethal.jpg');
            background-size: cover;
            background-position: center;
        }
        .login-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-container button {
            background: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .login-container button:hover {
            background: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
        .success {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
      
        <!-- Toon foutmelding indien aanwezig -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <label for="username">Gebruikersnaam</label>
            <input type="text" id="username" name="username" required pattern="[A-Za-z0-9]{4,}">

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required pattern="[A-Za-z0-9]{4,}">

            <button type="submit">Inloggen</button>
        </form>
    </div>
</body>
</html>

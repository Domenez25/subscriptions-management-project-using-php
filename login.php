<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session

require_once 'database.php';

$connexion = new PDO("mysql:host=sql212.infinityfree.com;port=3306","if0_35316583","95vhnfp7");
$setram = new Database('localhost', 'if0_35316583_Setram', 'root', '', $connexion);
$setram->connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in clients table
    $stmt = $connexion->prepare("SELECT `Client ID`, Password FROM clients WHERE `phone number` = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $clientResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($clientResult) {
        // Client found, check password
        if ($password == $clientResult['Password']) {
            // Password is correct, redirect to client dashboard
            setcookie("session", $clientResult['Client ID'], time() + 3600, "/"); // Set cookie for 1 hour
            header("Location: dashboards/client.php");
            exit();
        } else {
            $loginError = "Coordinates incorrect.";
        }
    } else {
        // Check in employers table
        $stmt = $connexion->prepare("SELECT `employer ID`, Type, Password FROM employers WHERE `employer ID` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $employerResult = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employerResult) {
            // Employer found, check password
            if ($password == $employerResult['Password']) {
                // Password is correct, redirect based on employer type
                setcookie("session", $employerResult['employer ID'], time() + 3600, "/"); // Set cookie for 1 hour
                if ($employerResult['Type'] == 'Admin') {
                    header("Location: dashboards/admin.php");
                } elseif ($employerResult['Type'] == 'Agent') {
                    header("Location: dashboards/agent.php");
                }
                exit();
            } else {
                $loginError = "Coordinates incorrect.";
            }
        } else {
            $loginError = "User not found.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form input {
            margin-bottom: 30px;
        }

        form {
            width: 300px;
        }

        form input[type="submit"] {
            margin-right: 0;
        }

        form a {
            text-decoration: none;
            margin-bottom: 5px;
        }

        form div {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <?php
        if (isset($loginError)) {
            echo "<p>$loginError</p>";
        }
        ?>
        <label for="username">phone number:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <div>
            <section style="display:flex; flex-direction:column ;">
                <a href="register.php">or sign up?! </a>
                <a href="#"> forget password</a>
            </section>
            <input type="submit" value="Login">
        </div>
    </form>
</body>

</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database.php';

$connexion = new PDO("mysql:host=localhost; dbname=Setram", "root", "");
$setram = new Database('localhost', 'Setram', 'root', '', $connexion);
$setram->connectToDatabase();

function generateID($db) {
    $exist = true;
    while ($exist) {
        $clientID = 20000 + rand(1, 9999);

        $sql = "SELECT COUNT(*) FROM clients WHERE `Client ID` = :clientID";
        $stmt = $db->connectToDatabase()->prepare($sql);
        $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count === 0) {
            $exist = false;
        }
    }
    return $clientID;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $category = $_POST['category'];
    $password = $_POST['password'];
    $clientID = generateID($setram);

    $pfp = "/pictures/bus.jpg";

    try {
        $connexion->beginTransaction();

        $query = "INSERT INTO `clients` (`Full name`, `Client ID`, `Date of birth`, `phone number`, `email`, `address`, `Category`, `Profile Picture`, `Password`)
                  VALUES (:fullname, :clientID, :dateOfBirth, :phoneNumber, :email, :address, :category, :pfp, :password)";
        $statement = $setram->connectToDatabase()->prepare($query);
        $statement->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $statement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
        $statement->bindParam(':dateOfBirth', $dateOfBirth, PDO::PARAM_STR);
        $statement->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':address', $address, PDO::PARAM_STR);
        $statement->bindParam(':category', $category, PDO::PARAM_STR);
        $statement->bindParam(':pfp', $pfp, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $statement->execute();
        header("refresh:0;url=login.php");

    } catch (Exception $e) {
        $connexion->rollBack();
        echo "Error: " . $e->getMessage();
        echo "<a href='index.php'>Go back to index</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <link rel="stylesheet" href="styles.css">
</head>


<body>
    <table>
        <td style="width: 50%; height: 100%;">
    <img src="pictures/oran.JPG"></td>
    <td style="width: 50%;">
    <form action="register.php" method="post">
        <h2>Registration Form</h2>
        <div style="display: flex;">
            <label for="fullName">Full Name:</label>
            <input class="texts" type="text" id="fullName" name="fullName" required>
        </div>
        <div style="display: flex;">
            <label for="dateOfBirth">Date of Birth:</label>
            <input class="texts" type="date" id="dateOfBirth" name="dateOfBirth" required>
        </div>
        <div style="display: flex;">
            <label for="phoneNumber">Phone Number:</label>
            <input class="texts" type="text" id="phoneNumber" name="phoneNumber" maxlength="10" required>
        </div>
        <div style="display: flex;">
            <label for="email">Email:</label>
            <input class="texts" type="email" id="email" name="email" required>
        </div>
        <div style="display: flex;">
            <label for="address">Address:</label>
            <textarea class="texts" id="address" name="address" required></textarea>
        </div>
        <div style="display: flex;">
            <label for="category">Category:</label>
            <select class="texts" id="category" name="category">
                <option value="employer">Employer</option>
                <option value="retired">Retired</option>
                <option value="student">Student</option>
                <option value="scolar">Scolar</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div style="display: flex;">
            <label for="password">Password:</label>
            <input class="texts" type="password" id="password" name="password" required>
        </div>

        <div style="display: flex;">
            <input style="margin-top: 0;" type="checkbox" id="agree" name="agree" required>
            <label style="font-size: 22px; margin: 0 0 0 10px;" for="agree">I agree to the terms and conditions</label>
            <input type="submit" value="Register">
        </div>
    </form>
</td></table>
</body>

</html>

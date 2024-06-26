
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="dashboards/styles.css" rel="stylesheet">

</head>
<body>

    <div id="top-bar">
        <a href="../index.php" style="text-decoration: none; vertical-align: middle; margin: 10px;"><h1 style="color: #05b4ac;">if0_35316583_Setram</h1>
        <h4 style="color: #d4fffd; transition: opacity 0.5s ease-in-out;">Acteur de modality</h4></a>
    </div>

    <div id="left-panel">
        <div class="objects">
            <h3 class="link-sections">Profile</h3>
            <hr>
            <a href="?content=profile" class="page-link">- View Profile</a>
            <a href="?content=edit" class="page-link">- Profile Management</a>
            <a href="?content=docs" class="page-link">- Personnel Docs</a>
            <h3 class="link-sections">Subscription</h3>
            <hr>
            <a href="?content=demand" class="page-link">- Demand Subscription </a>
            <a href="?content=status" class="page-link">- Subscription Status</a>
            <h3 class="link-sections">Other</h3>
            <hr>
            <a href="?content=lostCard" class="page-link">- Lost Card</a>
            <a href="?content=contact" class="page-link">- Contact Admin</a>
        </div>
        <div class="misc" style="margin-bottom: 10%";>
            <a href="?content=settings" class="link-sections">Settings</a>
            <a href="?content=logout" class="link-sections">Log Out</a>
        </div>
    </div>

    <?php
if (isset($_COOKIE['session'])) {
    $clientID = $_COOKIE['session'];

    try {
        $servername = "sql212.infinityfree.com;port=3306";
        $username = "if0_35316583";
        $password = "95vhnfp7";
        $dbname = "if0_35316583_Setram";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT `Full name`, `Client ID`, `Date of birth`, `phone number`, email, address, Category, `Profile Picture` FROM clients WHERE `Client ID` = :clientID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($_GET['content'])) {
                $selectedContent = $_GET['content'];

                if($selectedContent == "profile")

                echo '<div id="main-content">
                <div class="content-section">
                <div class="profile-container">
                <div class="header" style="display: flex;">
                <img src="' . $row['Profile Picture'] . '" width="40%" alt="Profile Picture">
                <div class="title" style="margin: 65px 0px;">
                <h2>' . $row['Full name'] . '</h2>
                <label style="margin-left: 20px;" for="clientID">Client ID:</label>
                <p id="clientID">' . $row['Client ID'] . '</p>
                </div>
                </div>
                <div class="profile-data">
                <label for="dateOfBirth">Date of Birth:</label>
                <p id="dateOfBirth">' . $row['Date of birth'] . '</p>
                </div>
                <div class="profile-data">
                <label for="phoneNumber">Phone Number:</label>
                <p id="phoneNumber">' . $row['phone number'] . '</p>
                </div>
                <div class="profile-data">
                <label for="email">Email:</label>
                <p id="email">' . $row['email'] . '</p>
                </div>
                <div class="profile-data">
                <label for="address">Address:</label>
                <p id="address">' . $row['address'] . '</p>
                </div>
                <div class="profile-data">
                <label for="category">Category:</label>
                <p id="category">' . $row['Category'] . '</p>
                </div>
                </div>
                </div>
                </div>';
            }
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    } finally {
        $conn = null;
    }
} else {
    echo 'Session cookie not set.';
}
?>

</body>

</html>

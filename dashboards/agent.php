<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_COOKIE['session'])) {
    $employerID = $_COOKIE['session'];

    try {
        $servername = "sql212.infinityfree.com;port=3306";
        $username = "if0_35316583";
        $password = "95vhnfp7";
        $dbname = "if0_35316583_Setram";
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT `Full name`, `employer ID`, `Date of birth` , place, Password FROM employers WHERE `employer ID` = :employerID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employerID', $employerID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);


        if (isset($_GET['content'])) {
            $selectedContent = $_GET['content'];

            
            switch ($selectedContent) {
                case 'profile':
                    $content = '<div class="content-section">
                        <div class="profile-container">
                        <div class="header" style="display: flex;">
                        <img src="../pictures/metro.jpg" width="40%" alt="Profile Picture">
                        <div class="title" style="margin: 65px 0px;">
                        <h2>' . $row['Full name'] . '</h2>
                        <label style="margin-left: 20px;" for="clientID">Client ID:</label>
                        <p id="clientID">' . $row['employer ID'] . '</p>
                        </div>
                        </div>
                        <div class="profile-data">
                        <label for="dateOfBirth">Date of Birth:</label>
                        <p id="dateOfBirth">' . $row['Date of birth'] . '</p>
                        </div>
                        <div class="profile-data">
                        <label for="place">place:</label>
                        <p id="place">' . $row['place'] . '</p>
                        </div>
                        </div>';
                    break;
                    
                case 'contact':
                    $content = '<div class="profile-container">
                                <h2>Contact Admin</h2>
                        
                                <p>Use the form below to contact the admin. Please provide a subject and details about your inquiry or message.</p>
                        
                                <form method="post">
                                    <label for="subject">Subject:</label>
                                    <input type="text" id="subject" name="subject" placeholder="Enter the subject" maxlength="255" required>
                        
                                    <label for="content">Message:</label>
                                    <textarea id="content" name="content" rows="6" placeholder="Enter your message" required></textarea>
                        
                                    <input type="submit" value="Submit">
                                </form>
                            </div>';

                        $exist = true;
                        while ($exist) {
                            $ComplimentID = rand(1, 9999);

                            $sql = "SELECT COUNT(*) FROM `compliments` WHERE `Compliment ID` = :ComplimentID";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':ComplimentID', $ComplimentID, PDO::PARAM_INT);
                            $stmt->execute();
                            $count = $stmt->fetchColumn();

                            if ($count === 0) {
                                $exist = false;
                            }
                        }

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
                            $message = isset($_POST['content']) ? $_POST['content'] : '';
                    
                            $clientId = '20000';
                            $employerId = $row['employer ID'];
                    
                            $insertQuery = "INSERT INTO compliments (`Compliment ID`, `Client ID`, `employer ID`, Subject, Message, Status)
                                            VALUES (:ComplimentID, :clientId, :employerId, :subject, :message, 'unchecked')";
                            
                            $insertStatement = $conn->prepare($insertQuery);
                            $insertStatement->bindParam(':ComplimentID', $ComplimentID, PDO::PARAM_INT);
                            $insertStatement->bindParam(':clientId', $clientId, PDO::PARAM_INT);
                            $insertStatement->bindParam(':employerId', $employerId, PDO::PARAM_INT);
                            $insertStatement->bindParam(':subject', $subject, PDO::PARAM_STR);
                            $insertStatement->bindParam(':message', $message, PDO::PARAM_STR);
                    
                            $insertStatement->execute();
                    
                            echo "Message submitted successfully!";
                        }
                            
                        break;
                                
                case 'demand':
                    $content = '<div class="form-container">
                                <h2 class="form-heading">Request New Subscription</h2>
                        
                                <form method="post">
                                <table>
                                    <colgroup>
                                        <col width="30%">
                                        <col width="20%">
                                        <col width="50%">
                                    </colgroup>
                                    <tr>
                                    <div>
                                        <td colspan="2" class="name">
                                            <label for="firstName">First Name:</label>
                                            <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                                        </td>
                                        <td colspan="2" class="name">
                                            <label for="lastName">Last Name:</label>
                                            <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
                                        </td>
                                    </div>
                        
                                    </tr><tr>
                                    
                                    <div>
                                        <td colspan="1">
                                            <label for="dob">Date of Birth:</label>
                                            </td>
                                            <td colspan="3" class="input-group">
                                            <input type="date" id="dob" name="dob" placeholder="Enter your date of birth" required>
                                        </td>
                                    </div>
                                    
                                </tr><tr>
                        
                                    <div>
                                        <td colspan="1">
                                            <label>Sex:</label>
                                        </td>
                                        <td colspan="3" class="input-group" style="display:flex; justify-content: space-between;">
                                            <input type="radio" id="male" name="sex" value="male">
                                            <label for="male">Male</label>
                                    
                                            <input type="radio" id="female" name="sex" value="female">
                                            <label for="female">Female</label>
                                        </td>
                                    </div>
                                    
                                </tr><tr>
                                    
                                    <div>
                                        <td colspan="1">
                                            <label for="phoneNumber">phone number:</label>
                                        </td>
                                        <td colspan="3" class="input-group">
                                            <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone Number" required>
                                        </td>
                                    </div>
                                    
                                </tr><tr>
                        
                                    <div>
                                        <td colspan="1">
                                            <label for="email">Email:</label>
                                        </td>
                                        <td colspan="3" class="input-group">
                                            <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                                        </td>
                                    </div>
                                    
                                </tr><tr>
                        
                                    <div>
                                        <td colspan="1">
                                            <label for="address">Address:</label>
                                        </td>
                                        <td colspan="3" class="input-group">
                                            <input type="text" id="address" name="address" placeholder="Enter your address" required>
                                        </td>
                                    </div>
                                    
                                </tr><tr>
                        
                                    <div>
                                        <td colspan="1">
                                            <label for="">Category:</label>
                                        </td>
                                        <td colspan="3" class="input-group">
                                            <select id="Category" name="Category" required>
                                                <option value="scholar">Scholar</option>
                                                <option value="student">Student</option>
                                                <option value="employer">Employer</option>
                                                <option value="retired">Retired</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </td>
                                    </div>
                                    
                                </tr><tr>
                        
                                    <div>
                                        <td colspan="1">
                                            <label for="subscriptionType">Type of Subscription:</label>
                                        </td><td colspan="2" class="input-group">
                                            <select id="subscriptionType" name="subscriptionType" required>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                                <option value="terrestrially">Terrestrially</option>
                                            </select>
                                        </td>
                                    </div>
                        
                                </tr>
                                </table>
                                <input class="submit-btn" type="submit" value="Submit">
                                </form>
                            </div>';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
                        $lastName = isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '';
                        $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
                        $sex = isset($_POST['sex']) ? htmlspecialchars($_POST['sex']) : '';
                        $phoneNumber = isset($_POST['phoneNumber']) ? htmlspecialchars($_POST['phoneNumber']) : '';
                        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
                        $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
                        $category = isset($_POST['Category']) ? htmlspecialchars($_POST['Category']) : '';
                        $subscriptionType = isset($_POST['subscriptionType']) ? htmlspecialchars($_POST['subscriptionType']) : '';
                    
                        // Insert into clients table
                        $exist = true;
                        while ($exist) {
                            $clientID = 20000 + rand(1, 9999);

                            $sql = "SELECT COUNT(*) FROM clients WHERE `Client ID` = :clientID";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                            $stmt->execute();
                            $count = $stmt->fetchColumn();

                            if ($count === 0) {
                                $exist = false;
                            }
                        }

                        $fullname = $firstName . $lastName ;
                        $profilePicture = '../pictures/bus.jpg'; // Default Profile Picture
                        $password = 'topSecret'; // Default Password
                    
                        $formattedDob = date('Y-m-d', strtotime($dob));
                        $clientsInsertQuery = "INSERT INTO clients (`Full name`, `Client ID`, `Date of birth`, `phone number`, email, address, Category, `Profile Picture`, Password)
                                                VALUES (:fullName, :clientID, :dob, :phoneNumber, :email, :address, :category, :profilePicture, :password)";
                    
                        $clientsInsertStatement = $conn->prepare($clientsInsertQuery);
                        $clientsInsertStatement->bindParam(':fullName', $fullname, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                        $clientsInsertStatement->bindParam(':dob', $formattedDob, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':email', $email, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':address', $address, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':category', $category, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':profilePicture', $profilePicture, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':password', $password, PDO::PARAM_STR);
                    
                        $clientsInsertStatement->execute();
                    
                        // Insert into subscription table
                        $status = 'valid'; // Default Status
                        $dateOfDemand = date('Y-m-d'); // Current Date
                        $dateAcceptance = date('Y-m-d'); 
                        $type = json_encode([$category, $subscriptionType]);
                    
                        // Calculate expiration based on subscription type
                        switch ($subscriptionType) {
                            case 'weekly':
                                $expiration = date('Y-m-d', strtotime($dateOfDemand . ' + 1 week'));
                                break;
                            case 'monthly':
                                $expiration = date('Y-m-d', strtotime($dateOfDemand . ' + 1 month'));
                                break;
                            case 'yearly':
                                $expiration = date('Y-m-d', strtotime($dateOfDemand . ' + 1 year'));
                                break;
                            case 'terrestrially':
                                $expiration = date('Y-m-d', strtotime($dateOfDemand . ' + 3 months'));
                                break;
                            default:
                                $expiration = date('Y-m-d');
                        }
                    
                        $subscriptionInsertQuery = "INSERT INTO subscription (`Client ID`, Status, `Date of demand`, `Date Acceptance`, Type, Expiration)
                                                    VALUES (:clientID, :status, :dateOfDemand, :dateAcceptance, :type, :expiration)";
                    
                        $subscriptionInsertStatement = $conn->prepare($subscriptionInsertQuery);
                        $subscriptionInsertStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                        $subscriptionInsertStatement->bindParam(':status', $status, PDO::PARAM_STR);
                        $subscriptionInsertStatement->bindParam(':dateOfDemand', $dateOfDemand, PDO::PARAM_STR);
                        $subscriptionInsertStatement->bindParam(':dateAcceptance', $dateAcceptance, PDO::PARAM_STR);
                        $subscriptionInsertStatement->bindParam(':type', $type, PDO::PARAM_STR);
                        $subscriptionInsertStatement->bindParam(':expiration', $expiration, PDO::PARAM_STR);
                    
                        $subscriptionInsertStatement->execute();
                    }
                        
                    break;

                case 'lostCard':
                    $content = '<div class="form-container">
                        <h2 class="form-heading">Lost Card Declaration</h2>
                        <form method ="post">
                        <div class="input-group">
                            <label for="phone">phone number:</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
                        </div>
                
                        <div class="input-group">
                            <label>Card Status:</label>
                            <div style="display: flex;">
                                <input type="radio" id="lost" name="cardStatus" value="lost">
                                <label for="lost">Lost</label>
                
                                <input type="radio" id="ruined" name="cardStatus" value="ruined">
                                <label for="ruined">Ruined</label>
                            </div>
                        </div>
                
                        <div class="input-group">
                            <label for="otpCode">OTP Confirmation Code:</label>
                            <input type="password" id="otpCode" name="otpCode">
                        </div>
                
                        <input class="submit-btn" type="submit" value="Submit">
                        </form>
                    </div>';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
                        $cardStatus = isset($_POST['cardStatus']) ? htmlspecialchars($_POST['cardStatus']) : '';
                        $otpCode = isset($_POST['otpCode']) ? htmlspecialchars($_POST['otpCode']) : '';
                    
                        if ($otpCode !== '0000') {
                            echo "Incorrect OTP. Please try again.";
                        } else {
                            $searchQuery = "SELECT `Client ID`, `Full name` FROM clients WHERE `phone number` = :phone";
                            $searchStatement = $conn->prepare($searchQuery);
                            $searchStatement->bindParam(':phone', $phone, PDO::PARAM_STR);
                            $searchStatement->execute();
                            $result = $searchStatement->fetch(PDO::FETCH_ASSOC);
                    
                            if ($result) {
                                echo "<script>
                                    var userConfirmed = confirm('Is {$result['Full name']} your name?');
                                    document.cookie = 'userConfirmed=' + userConfirmed;
                                    </script>";
                                
                                if (isset($_COOKIE['userConfirmed'])) {
                                    $confirmation = filter_var($_COOKIE['userConfirmed'], FILTER_VALIDATE_BOOLEAN);
                                        
                                    if ($confirmation) {
                                        $clientId = $result['Client ID'];
                                        $updateQuery = "UPDATE subscription SET Status = :status WHERE `Client ID` = :clientId";
                                        $updateStatement = $conn->prepare($updateQuery);
                                        $updateStatement->bindParam(':status', $cardStatus, PDO::PARAM_STR);
                                        $updateStatement->bindParam(':clientId', $clientId, PDO::PARAM_INT);
                                        $updateStatement->execute();
                                        
                                        echo "Subscription status updated successfully.";
                                    } else {
                                        echo "User did not confirm.";
                                    }
                                    setcookie('userConfirmed', '', time() - 3600, '/');
                                }
                            } else {
                                echo "No client found with the provided phone number.";
                            }
                        }
                    }
                    break;

                        
                case 'logout':
                    setcookie('session', '', time() - 3600, '/');
                        header("Location: ..");
                        break;
                    
                case 'edit':

                    $stmt = $conn->prepare("SELECT subscription.*, clients.`Full name` FROM subscription
                                            INNER JOIN clients ON subscription.`Client ID` = clients.`Client ID`
                                            WHERE subscription.Status = 'inhold'");
                    $stmt->execute();
                    $subscriptionRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    function getDocumentLink($clientID)
                        {
                            $cardPath = "docs/socialCard_{$clientID}.jpg";
                            $certPath = "docs/certificate_{$clientID}.jpg";
                            
                            if (file_exists($cardPath)) {
                                $textCard = "<a href='{$cardPath}' download>Download</a>";
                            } else {
                                $textCard = "(No socialCard) <br>";
                            }

                            if (file_exists($certPath)) {
                                $textCert = "<a href='{$certPath}' download>Download</a>";
                            } else {
                                $textCert = "(No certaficate)";
                            }

                            return $textCard . $textCert ;
                        }

                    $myTable = '';
                    foreach ($subscriptionRequests as $request) {
                        $myTable .= '<tr> <td> ' . $request['Client ID'] . '</td>
                                    <td>' . $request['Full name'] . '</td>
                                    <td>' . $request['Date of demand'] . '</td>
                                    <td>' . $request['Type'] . '</td>
                                    <td style="width:15%;">' . getDocumentLink($request['Client ID']) . ' </td>
                                    <td style="width:20%;"><form style="display: inline-block; margin-right: 10px;" method="post"><input type="hidden" name="acceptID" value="' . $request['Client ID'] . '"><input type="submit" name="Accept" value="Accept"></form>
                                    <form style="display: inline-block;" method="post">
                                        <input type="hidden" name="refuseID" value="' . $request['Client ID'] . '">
                                        <input type="submit" name="Refuse" value="Refuse">
                                    </form></td>
                                    </tr>';
                    }
                    

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Accept'])) {
                        $acceptID = $_POST['acceptID'];
            
                        $stmt = $conn->prepare("SELECT * FROM subscription WHERE `Client ID` = :acceptID");
                        $stmt->bindParam(':acceptID', $acceptID);
                        $stmt->execute();
                        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
                        
                        foreach ($results as $result) {
                            $stmt = $conn->prepare("UPDATE subscription SET `Status` = 'Valid' WHERE `Client ID` = :acceptID");
                            $stmt->bindParam(':acceptID', $acceptID);
                            $stmt->execute();
                        }
                        header("Refresh:0");
                    }

                    $messageDiv = '';


                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Refuse'])) {
                        $refuseID = $_POST['refuseID'];

                        setcookie("refusedID", $refuseID, time() + 86400, "/");

                        $stmt = $conn->prepare("SELECT * FROM subscription WHERE `Client ID` = :refuseID");
                        $stmt->bindParam(':refuseID', $refuseID);
                        $stmt->execute();
                        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

                        $messageDiv = '
                            <form method="post">
                                <label for="refuseMessage">Message for ' . $refuseID . ':</label>
                                <textarea id="refuseMessage" name="refuseMessage" rows="6" placeholder="Enter your Refusal message" required></textarea>
                                <input name="Message" type="submit" value="Submit">
                            </form>
                        ';

                    }


                    $content = '
                        <div class="profile-container">
                        <h2>Subscription Request Acceptance Manager</h2><brs>

                            <table border="1">
                                <thead>
                                    <tr>
                                        <th class="sort" onclick="sortTable(\'Client ID\')" >Client ID ▼</th>
                                        <th class="sort" onclick="sortTable(\'Full name\')" >Full Name ▼</th>
                                        <th class="sort" onclick="sortTable(\'Date of Demand\')" >Date of Demand ▼</th>
                                        <th class="sort" onclick="sortTable(\'Type\')" >Type ▼</th>
                                        <th>Documents</th>
                                        <th>Accept</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ' . $myTable . '
                                </tbody>
                            </table>
                            ' . $messageDiv. '
                        </div>
                        ';


                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Message'])) {
                            $refuseMessage = $_POST['refuseMessage'];   
                            $refuseID = intval($_COOKIE['refusedID']);
 

                            $stmt = $conn->prepare("INSERT INTO Refuses (`Client ID`, `message`) VALUES (:refuseID, :refuseMessage)");
                            $stmt->bindParam(':refuseID', $refuseID, PDO::PARAM_INT);
                            $stmt->bindParam(':refuseMessage', $refuseMessage, PDO::PARAM_STR);
                            $stmt->execute();

                            $stmt = $conn->prepare("SELECT * FROM subscription WHERE `Client ID` = :refuseID");
                            $stmt->bindParam(':refuseID', $refuseID);
                            $stmt->execute();
                            $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
                            
                            foreach ($results as $result) {
                                $stmt = $conn->prepare("UPDATE subscription SET `Status` = 'refused' WHERE `Client ID` = :refuseID");
                                $stmt->bindParam(':refuseID', $refuseID);
                                $stmt->execute();
                            }
                            
                            setcookie("refusedID", "", time() - 3600, "/");
                            header("Refresh:0");

                        }


                    //     if (isset($_POST['accept']) && is_array($_POST['accept'])) {
                        //         $acceptedClients = $_POST['accept'];
                        //         $status = "Valid";

                        //         print_r($acceptedClients);

                        //         foreach ($acceptedClients as $clientID) {

                        //             $currentDate = date('Y-m-d');
                        //             $typeArray = json_decode($clientID['Type'],true);

                        //             if (is_array($typeArray) && count($typeArray) >= 2) {
                                        
                        //                 $selectQuery = "SELECT `Type` FROM `subscription` WHERE `Client ID` = :clientID";
                        //                 $selectStatement = $conn->prepare($selectQuery);
                        //                 $selectStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                        //                 $selectStatement->execute();


                        //                 $result = $selectStatement->fetch(PDO::FETCH_ASSOC);
                        //                 $subscriptionType = json_decode($result['Type'])[1]; 
                        //                 echo "Subscription Type: $subscriptionType";


                        //                 switch ($subscriptionType) {
                        //                     case 'weekly':
                        //                         $expiration = date('Y-m-d', strtotime('+1 week'));
                        //                         echo "w";
                        //                         break;
                        //                     case 'month':
                        //                         $expiration = date('Y-m-d', strtotime('+1 month'));
                        //                         echo "m";
                        //                         break;
                        //                     case 'trimester':
                        //                         $expiration = date('Y-m-d', strtotime('+3 months'));
                        //                         echo "t";
                        //                         break;
                        //                     case 'yearly':
                        //                         $expiration = date('Y-m-d', strtotime('+1 year'));
                        //                         echo "y";
                        //                         break;
                        //                     default:
                        //                         echo "def";
                        //                         break;
                        //                 }
                        //                 echo $expiration ;
                        //             }

                        //             echo $expiration;

                        //             $updateQuery = "UPDATE subscription SET Status = :status, Expiration = :expiration, `Date Acceptance` = :currentDate WHERE `Client ID` = :clientID";
                        //             $updateStatement = $conn->prepare($updateQuery);
                        //             $updateStatement->bindParam(':status', $status, PDO::PARAM_STR);
                        //             $updateStatement->bindParam(':expiration', $expiration, PDO::PARAM_STR);
                        //             $updateStatement->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
                        //             $updateStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                        //             $updateStatement->execute();
                        //         }

                        //         echo 'Selected subscriptions accepted.';
                        //         // header("refresh:2;url=agent.php?content=edit");
                        //         echo '<br> Page will reload in 2 secons';
                        //     } else {
                        //         echo 'No subscriptions selected.';
                        //     }
                    // }
                    break;
                
                
                case 'settings':
                        $content = '<div style="display:block;">    <h2>Change Password</h2>
                            <form method="post">
                                <label for="oldPassword">Old Password:</label>
                                <input type="password" name="oldPassword" required>
                                <br>
                                <label for="newPassword">New Password:</label>
                                <input type="password" name="newPassword" required>
                                <br>
                                <label for="confirmNewPassword">Confirm New Password:</label>
                                <input type="password" name="confirmNewPassword" required>
                                <br>
                                <input type="submit" value="Change Password">
                            </form></div>';

                        
                        // Function to update the password in the database
                        function updatePassword($employerID, $newPassword)
                        {
                            global $conn;
                            $query = "UPDATE employers SET Password = :password WHERE `employer ID` = :employerID";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
                            $stmt->bindParam(':employerID', $employerID, PDO::PARAM_STR);
                            $stmt->execute();
                        }

                        // Process form submission
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            
                            $oldPassword = $_POST['oldPassword'];
                            $newPassword = $_POST['newPassword'];
                            $confirmNewPassword = $_POST['confirmNewPassword'];

                            // Verify the old password
                            if ($oldPassword == $row['Password']) {
                                // Check if the new password and confirmation match
                                if ($newPassword === $confirmNewPassword) {
                                    // Update the password in the database
                                    updatePassword($row['employer ID'], $newPassword);
                                    echo "Password updated successfully!";
                                } else {
                                    echo "New password and confirmation do not match.";
                                }
                            } else {
                                echo "Old password is incorrect.";
                            }
                        }

                            
                        break;

                default:
                    $content = '<h2>Welcome to the Dashboard</h2><br><p>Select a section from the left panel.</p>';
                    break;
            }
        } else {
            $content = 'Welcome back '. $row['Full name'];
        }
    } else {
        $content = "<div style='font-size:40px;'>oops! you're on the wrong page 🙂 <br> you will be redirected in 2 seconds..";
        header( "refresh:2;url=client.php" );
    }
} catch (PDOException $e) {
echo 'Conn failed: ' . $e->getMessage();

} finally {
$conn = null;
}

} else {
header("Location: ..");
}
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="styles.css" rel="stylesheet">

    <style>
        .form-container {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 800px;
            margin: auto;
        }

        .form-heading {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
        }

        .sort {
            cursor: pointer;
        }
        .sort:hover {
            background-color: #999;
        }

        label {
            margin-bottom: 5px;
            font-size: 18px;
            color: #000000;
        }

        .input-group input[type="text"],
        .input-group input[type=""],
        .input-group input[type="password"],
        .input-group input[type="number"],
        .input-group textarea,
        .input-group select,
        .name input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .name input {
            width: 72%;
        }

        .input-group textarea {
            resize: vertical; /* Allow vertical resizing of textarea */
        }

        .input-group input[type="radio"] {
            margin-right: 5px;
        }

        .input-group select {
            height: 38px;
        }

        .submit-btn {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            display: block;
            width: 100%;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div id="top-bar">
        <a href="../index.php" style="text-decoration: none; vertical-align: middle; margin: 10px;"><h1 style="color: #05b4ac;">SETRAM</h1>
        <h4 style="color: #d4fffd; transition: opacity 0.5s ease-in-out;">Acteur de modality</h4></a>
    </div>

    <div id="left-panel">
        <div class="objects">
            <h3 class="link-sections">Dashboard</h3>
            <hr>
            <a href="?content=profile" class="page-link">- Profile</a>
            
            <a href="?content=contact" class="page-link">- Contact administrator</a>
            <h3 class="link-sections">Activities</h3>
            <hr>
            <a href="?content=demand" class="page-link">- new Demand</a>
            <a href="?content=edit" class="page-link">- Manage Demands</a>
            <a href="?content=lostCard" class="page-link">- Card lost</a>
        </div>
        <div class="misc" style="margin-bottom: 10%";>
            <a href="?content=settings" class="link-sections">Settings</a>
            <a href="?content=logout" class="link-sections">Log Out</a>
        </div>
    </div>

    <div id="main-content">
        <div class="content-section">
            <?php echo $content; ?>
        </div>
    </div>
</body>


<script src="script.js"></script>



</html>




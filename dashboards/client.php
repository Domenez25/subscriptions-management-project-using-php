<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
 
if (isset($_COOKIE['session'])) {
    $clientID = $_COOKIE['session'];

    try {
        $servername = "sql212.infinityfree.com;port=3306";
        $username = "if0_35316583";
        $password = "95vhnfp7";
        $dbname = "if0_35316583_Setram";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT `Full name`, `Client ID`, `Date of birth`, `phone number`, email, address, Category, `Profile Picture`, Password FROM clients WHERE `Client ID` = :clientID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
        $stmt->execute();

        

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            


            if (isset($_GET['content'])) {
                $selectedContent = $_GET['content'];

                switch ($selectedContent) {
                    case 'profile':
                        $content = '
                            <div class="profile-container">
                            <div class="header" style="display: flex;">
                            <img src="../pictures/bus.jpg" width="40%" alt="Profile Picture">
                            <div class="title" style="margin: 65px 0px;">
                            <h2>__' . $row['Full name'] . '</h2>
                            <label style="margin-left: 20px;" for="clientID">Client ID: '. $row['Client ID'] . '</label>
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
                        break;

                    case 'edit':
                        $categories = ["employer", "retired", "student", "eleve", "other"];

                        $selectOptions = '';
                        foreach ($categories as $option) {
                            $selectOptions .= "<option value='$option'";
                            if ($option === $row["Category"] ) {
                                $selectOptions .= ' selected';
                            }
                            $selectOptions .= '>' . ucfirst($option) . '</option>';
                        }

                        $content = 
                            '<div class="profile-container">
                            
                            <form method="post">  
                            <div class="profile-data">
                            <label for="clientID">Client ID:</label>
                            <input style="width: 70%;" type="text" id="clientID" name="clientID" value="' . $row['Client ID'] . '" disabled>
                            </div>
                
                            <div class="profile-data">
                            <label for="fullName">Full Name:</label>
                            <input style="width: 70%;" type="text" id="fullName" name="fullName" value="' . $row['Full name'] . '">
                            </div>
                
                            <div class="profile-data">
                            <label for="dateOfBirth">Date of Birth:</label>
                            <input style="width: 70%;" type="text" id="dateOfBirth" name="dateOfBirth" value="' . $row['Date of birth'] . '">
                            </div>
                
                            <div class="profile-data">
                            <label for="phoneNumber">Phone Number:</label>
                            <input style="width: 70%;" type="text" id="phoneNumber" name="phoneNumber" value="' . $row['phone number'] . '">
                            </div>
                
                            <div class="profile-data">
                            <label for="email">Email:</label>
                            <input style="width: 70%;" type="text" id="email" name="email" value="' . $row['email'] . '">
                            </div>
                
                            <div class="profile-data">
                            <label for="address">Address:</label>
                            <input style="width: 70%;" type="text" id="address" name="address" value="' . $row['address'] . '">
                            </div>
                
                            <div class="profile-data">
                            <label for="category">Category:</label>
                            <select style="width: 70%;" id="category" name="category" class="texts" id="category" name="category"> '
                            . $selectOptions . '
                                
                            </select>
                            </div>
                
                            <input type="submit" name="submit" value="Save Changes">
                            </form>
                            </div>';


                        if (isset($_POST['submit'])) {
                            $newFullName = $_POST['fullName'];
                            $newDateOfBirth = $_POST['dateOfBirth'];
                            $newPhoneNumber = $_POST['phoneNumber'];
                            $newEmail = $_POST['email'];
                            $newAddress = $_POST['address'];
                            $newCategory = $_POST['category'];

                            $updateQuery = "UPDATE clients SET 
                                        `Full name` = :newFullName,
                                        `Date of birth` = :newDateOfBirth,
                                        `phone number` = :newPhoneNumber,
                                        email = :newEmail,
                                        `address` = :newAddress,
                                        Category = :newCategory
                                    WHERE `Client ID` = :clientID";

                            $updateStatement = $conn->prepare($updateQuery);
                            $updateStatement->bindParam(':newFullName', $newFullName, PDO::PARAM_STR);
                            $updateStatement->bindParam(':newDateOfBirth', $newDateOfBirth, PDO::PARAM_STR);
                            $updateStatement->bindParam(':newPhoneNumber', $newPhoneNumber, PDO::PARAM_STR);
                            $updateStatement->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
                            $updateStatement->bindParam(':newAddress', $newAddress, PDO::PARAM_STR);
                            $updateStatement->bindParam(':newCategory', $newCategory, PDO::PARAM_STR);

                            $updateStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);

                            $updateStatement->execute();
                            header("Refresh:0");
                        }

                        break;

                    case 'docs':

                        $clientID = $row['Client ID'];

                        function getDocumentLink($clientID, $type)
                        {
                            $documentPath = "docs/{$type}_{$clientID}.jpg";
                            
                            if (file_exists($documentPath)) {
                                return "<a href='{$documentPath}' download>Download</a>";
                            } else {
                                return "(No attached file yet)";
                            }
                        }

                        function getActionButton($clientID, $type)
                        {
                            $documentPath = "docs/{$type}_{$clientID}.jpg";
                            
                            if (file_exists($documentPath)) {
                                return "<form method='post'><input type='submit' name='delete{$type}' value='Delete'></form>";
                            } else {
                                return "<label class='adding-file' for='{$type}File'>Add</label>
                                        <input style='display: block;' type='file' id='{$type}File' name='{$type}File'>";
                            }
                        }
                        
                        

                        $content = '
                            <div class="profile-container">
                            <h2>Attach Files</h2>
                            <p>Please insert files in JPG format if possible.</p>


                            <table>
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Social Card</td>
                                        <td>' . getDocumentLink($clientID, 'socialCard') . '</td>
                                        <td style="text-align:center; width:20%;">
                                        ' . getActionButton($clientID, 'socialCard') . ' </td>
                                    </tr>
                                    <tr>
                                        <td>Student Certificate</td>
                                        <form method="post">
                                        <td>' . getDocumentLink($clientID, 'certificate') . '</td>
                                        <td style="text-align:center;">
                                        ' . getActionButton($clientID, 'certificate') . ' </td>
                                    </tr>
                                </tbody>
                            </table>
                    
                            <input style="margin-left: 43%;" type="submit" value="Submit">
                            </form>
                            </div>';


                        foreach ($_FILES as $file) {
                            $fileName = $file['name'];
                            $fileType = $file['type'];
                            $fileSize = $file['size'];
                            $fileTmp = $file['tmp_name'];
                
                            echo "<li><strong>File Name:</strong> $fileName<br>";
                            echo "<strong>File Type:</strong> $fileType<br>";
                            echo "<strong>File Size:</strong> $fileSize bytes<br>";
                            echo "<strong>Temporary File:</strong> $fileTmp</li><br>";
                        }



                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                                
                                echo "post"; 
                                print_r($_FILES);


                                if (isset($_FILES['socialCardFile'])) {
                                    // $socialCardPath = "docs/socialCard_{$clientID}.jpg";
                                    // move_uploaded_file($_FILES['socialCardFile']['tmp_name'], $socialCardPath);

                                    $fileTmp = $_FILES["socialCardFile"]["tmp_name"];
                                    $fileType = $_FILES["socialCardFile"]["type"];
                                    $fileSize = $_FILES["socialCardFile"]["size"];
                                    $fileName = 'socialCard_' . $clientID . '.jpg';
                                    $uploadPath = "docs/" . $fileName; // Change "uploads/" to your desired directory

                                    // Check if file is uploaded successfully
                                    if (move_uploaded_file($fileTmp, $uploadPath)) {
                                        echo "File uploaded successfully as $uploadPath.";
                                    } else {
                                        echo "Error uploading file.";
                                    }

                                }

                                
                                if (isset($_FILES['certificateFile']) && $_FILES['certificateFile']['error'] === UPLOAD_ERR_OK) {
                                    $certificatePath = "docs/certificate_{$clientID}.jpg";
                                    move_uploaded_file($_FILES['certificateFile']['tmp_name'], $certificatePath);
                                }
                            
    
                                
                                if (isset($_POST['deleteSocialCard'])) {
                                    $socialCardPath = "docs/socialCard_{$clientID}.jpg";
                                    if (file_exists($socialCardPath)) {
                                        unlink($socialCardPath);
                                    }
                                }
    
    
                                if (isset($_POST['deleteCertificate'])) {
                                    $certificatePath = "docs/certificate_{$clientID}.jpg";
                                    if (file_exists($certificatePath)) {
                                        unlink($certificatePath);
                                    }
                                }
                            }
                        break;

                    case 'demand':
                        
                        $content = '
                                <div class="profile-container">
                                <h2>Subscription Demand</h2>

                                <form method="post" oninput="calculateTotalPrice()">
                                    <label style="display: flex;">
                                        <strong>Type of Subscription:</strong>
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="subscriptionType" value="weekly" onclick="toggleDurationRadios(true)" required> Weekly
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="subscriptionType" value="' . $row['Category'] . '" onclick="toggleDurationRadios(false)"> '. $row['Category'] .'
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="subscriptionType" value="multimodal" onclick="toggleDurationRadios(false)"> Multimodal
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="subscriptionType" value="special" onclick="toggleDurationRadios(false)"> Special
                                    </label>

                                    <label style="display: flex;margin-top: 20px;">
                                        <strong>Duration:</strong>
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="duration" value="month" required> Month
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="duration" value="trimester"> Trimester
                                    </label>
                                    <label style="display: flex;">
                                        <input type="radio" class="radiodemand" name="duration" value="year"> Year
                                    </label>

                                    <div id="totalPrice"></div>
                                    <input type="submit" value="Submit">

                                </form>

                                <p class="note">(You have to attach your documents first)</p>
                            </div>';

                            
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            $clientID = $row['Client ID'];
                            $subscriptionType = $_POST['subscriptionType'];
                            $status = "inhold";
                            $dateOfDemand = date("Y-m-d H:i:s");
                            $dateAcceptance = "0000-00-00";
                            $now = new DateTime();

                            if ($subscriptionType == "weekly") {
                                $duration = "weekly";
                            } else {
                                $duration = $_POST['duration'];
                            }

                            $typeData = [
                                'subscriptionType' => $subscriptionType,
                                'duration' => $duration,
                            ];

                            switch ($duration){
                                case "weekly": $expiration = date('Y-m-d H:i:s', strtotime('+1 week'));    break;
                                case "month": $expiration = date('Y-m-d H:i:s', strtotime('+1 month'));    break;
                                case "trimester": $expiration = date('Y-m-d H:i:s', strtotime('+3 months'));    break;
                                case "year": $expiration = date('Y-m-d H:i:s', strtotime('+1 year'));    break;
                            }
                        
                            $type = json_encode([$typeData]);
                        
                            $insertQuery = "INSERT INTO subscription (`Client ID`, `Status`, `Date of demand`, `Date Acceptance`,`Type`, `Expiration`) 
                                            VALUES (:clientID, :status, :dateOfDemand, :dateAcceptance, :type, :expiration)";
                        
                            $insertStatement = $conn->prepare($insertQuery);
                            $insertStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                            $insertStatement->bindParam(':status', $status, PDO::PARAM_STR);
                            $insertStatement->bindParam(':dateOfDemand', $dateOfDemand, PDO::PARAM_STR);
                            $insertStatement->bindParam(':dateAcceptance', $dateAcceptance, PDO::PARAM_STR);
                            $insertStatement->bindParam(':type', $type, PDO::PARAM_STR);
                            $insertStatement->bindParam(':expiration', $expiration, PDO::PARAM_STR);
                        
                            if ($insertStatement->execute()) {
                                echo "Subscription demand submitted successfully!";
                            } else {
                                echo "Error submitting subscription demand: " . print_r($insertStatement->errorInfo(), true);
                            }
                        }
                        break;
                        

                    case 'status':
                        $clientID = $row['Client ID'];
                        $query = "SELECT * FROM `subscription` WHERE `Client ID` = :clientID";
                        $statement = $conn->prepare($query);
                        $statement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                        $statement->execute();
                        $sub = $statement->fetch(PDO::FETCH_ASSOC);

                        $content = '<div style="font-size:24px;">';

                        if ($sub) {
                            // Check if the subscription is still valid
                            if ($sub['Status'] === 'valid') {
                                $currentDate = date('Y-m-d');
                                $expirationDate = $sub['Expiration'];

                                // If the subscription is outdated, update the status
                                if ($expirationDate < $currentDate) {
                                    $updateQuery = "UPDATE `subscription` SET `Status` = 'Outdated' WHERE `Client ID` = :clientID";
                                    $updateStatement = $conn->prepare($updateQuery);
                                    $updateStatement->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                                    $updateStatement->execute();
                                    $sub['Status'] = 'Outdated';
                                }
                            }

                            $query = "SELECT `message` FROM Refuses WHERE `Client ID` = :clientID";

                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':clientID', $clientID, PDO::PARAM_STR);
                            $stmt->execute();
                            $refuseMessage = $stmt->fetch(PDO::FETCH_ASSOC);

                                switch ($sub['Status']) {
                                    case 'inhold':
                                        $content .= "Your subscription is waiting for a response.";
                                        break;
                                    case 'Valid':
                                        $content .= "Your subscription is valid until {$sub['Expiration']} ";
                                        break;
                                    case 'Outdated':
                                        $content .= "Your subscription expired on {$sub['Expiration']}. You can request a renewal <a href='?content=demand'>here</a>.";
                                        break;

                                    case 'Ruined':
                                    case 'Lost':
                                        $content .= "You have declared your card lost or ruined. An investigation is still in process.";
                                        break;

                                    case 'refused':
                                        $content .= "Sorry you application has been refused <br> cause: <br>  " . $refuseMessage['message'];
                                        break;

                                    default:
                                        $content .= "Unknown subscription status.";
                                        break;
                                }
                        } else {
                            $content .= "You do not have a subscription currently.<br> You can request one <a href='?content=demand'>here</a>.";
                        }
                        $content .= '</div>';
                        break;

                    case 'lostCard':
                        $content = '<div class="profile-container">
                                <h2>Card Lost Declaration</h2>
                        
                                <p>This form is used to declare the loss or ruination of your card. Please choose the appropriate option, confirm your password, provide the OTP (One-Time Password), and submit the form to report the incident.</p>
                        
                                <form method="post">
                                    <label>
                                        <strong>Declaration Type:</strong>
                                    </label>
                                    <label style="display: flex; justify-content: space-between;">
                                        <div class="radios"><input style="margin-right: 20%;" type="radio" name="declarationType" value="lost" required> Lost </div>
                                        <div class="radios"><input style="margin-right: 20%;" type="radio" name="declarationType" value="ruined"> Ruined </div>
                                    </label>
                        
                                    <label>
                                        <strong>Password Confirmation:</strong>
                                    </label>
                                        <input type="password" name="passConf" required>
                                    <label>
                                        <strong>OTP (One-Time Password):</strong>
                                    </label>
                                    <input type="text" name="otp" placeholder="Enter OTP" required>
                        
                                    <input type="submit" value="Submit">
                                </form>
                        
                                <p class="note">(Note: This form is for declaring the loss or ruination of your card.)</p>
                            </div>';
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $declarationType = isset($_POST['declarationType']) ? $_POST['declarationType'] : '';
                            $passwordConfirmation = isset($_POST['passConf']) ? $_POST['passConf'] : '';
                            $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
                                
                            $clientId = $row['Client ID']; 
                            $correctPassword = $row['Password'];
                            $correctOtp = '0000'; 
                    
                            if ($passwordConfirmation === $correctPassword && $otp === $correctOtp) {
                                
                                $updateStatus = ($declarationType === 'lost') ? 'lost' : 'ruined';
                                
                                $updateQuery = "UPDATE subscription SET Status = :updateStatus WHERE `Client ID` = :clientId";
                                $updateStatement = $conn->prepare($updateQuery);
                                $updateStatement->bindParam(':updateStatus', $updateStatus, PDO::PARAM_STR);
                                $updateStatement->bindParam(':clientId', $clientId, PDO::PARAM_INT);
                                $updateStatement->execute();
                    
                                echo "Declaration submitted successfully!";
                            } else {
                                echo "Password or OTP is incorrect. Please try again.";
                                
                            }
                        }

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
                    
                            $clientId = $row['Client ID'];
                            $employerId = '10000';
                    
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

                    case 'settings':
                        $content = '<div class="profile-container" style="display:block;">    <h2>Change Password</h2>
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
                        function updatePassword($clientID, $newPassword)
                        {
                            global $conn;
                            $query = "UPDATE clients SET Password = :password WHERE `Client ID` = :clientID";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
                            $stmt->bindParam(':clientID', $clientID, PDO::PARAM_STR);
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
                                    updatePassword($row['Client ID'], $newPassword);
                                    echo "Password updated successfully!";
                                } else {
                                    echo "New password and confirmation do not match.";
                                }
                            } else {
                                echo "Old password is incorrect.";
                            }
                        }

                            
                        break;

                    case 'logout':
                        setcookie('session', '', time() - 3600, '/');
                        header("Location: ..");
                        break;

                    
                    case 'feedback':
                        function hasSubmittedFeedback($clientID)
                        {
                            global $conn;
                            $query = "SELECT COUNT(*) FROM feedbacks WHERE `Client ID` = :clientID";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':clientID', $clientID, PDO::PARAM_STR);
                            $stmt->execute();
                            $count = $stmt->fetchColumn();
                        
                            return $count > 0;
                        }
                        
                        function storeFeedback($clientID, $rating, $comments)
                        {
                            global $conn;
                            $query = "INSERT INTO feedbacks (`Client ID`, Rating, Comments) VALUES (:clientID, :rating, :comments)";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':clientID', $clientID, PDO::PARAM_STR);
                            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
                            $stmt->bindParam(':comments', $comments, PDO::PARAM_STR);
                            $stmt->execute();
                        }
                        
                    
                            
                            if (hasSubmittedFeedback($clientID)) {
                                $content = "Sorry, you have already submitted feedback :)";
                            } else {

                                $content = '<div class="profile-container" style="display:block;"><h2>Feedback Form</h2>
                                    <form method="post" align="center">
                                        <label for="rating">Rate your experience:</label>
                                        <select name="rating">
                                            <option value="1">1 - Poor</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="3">3 - Good</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="5">5 - Excellent</option>
                                        </select>
                                        <br>
                                        <label for="comments">What did you like about the experience?</label>
                                        <textarea name="comments" rows="4" cols="50"></textarea>
                                        <br><br>
                                        <input type="submit" value="Submit Feedback">
                                    </form></div>';
                                
                            }

                                                
                            

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $clientID = $row['Client ID']; 
                                $rating = $_POST['rating'];
                                $comments = $_POST['comments'];

                                storeFeedback($clientID, $rating, $comments);
                                setcookie('promo', 30, time() + (30 * 24 * 60 * 60), '/'); 
                                $content = "<div style='display:block; font-size:24px;'>Thank you for your submition!<br> you can have <a href='?content=demand' class='page-link'> 30% promotion on your next achat :)</a> ";
                            }
                        
                        break;
                    default:
                        $content = '<h2>Welcome to the Dashboard</h2><br><p>Select a section from the left panel.</p>';
                        break;
                }
            } else {
                $content = 'welcome client!';           
            }
        } else {
            $content = "<div style='font-size:40px;'>oops! you're on the wrong page 🙂 <br> you will be redirected in 2 seconds..";
            header( "refresh:2;url=agent.php" );
        }

    } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    
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

</head>
<body>

    <div id="top-bar">
        <a href="../index.php" style="text-decoration: none; vertical-align: middle; margin: 10px;"><h1 style="color: #05b4ac;">SETRAM</h1>
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
            <a href="?content=feedback" class="page-link">- Give us feedback!</a>

        </div>
        <div class="misc" style="margin-bottom: 10%";>
            <a href="?content=settings" class="link-sections">Settings</a>
            <a href="?content=logout" class="link-sections">Log Out</a>
        </div>
    </div>

    <script src="script.js">
        
    </script>;

    <div id="main-content">
        <div class="content-section">
            <?php echo $content; ?>
        </div>
    </div>

    
</body>
</html>

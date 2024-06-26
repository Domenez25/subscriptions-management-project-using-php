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

        $sql = "SELECT `Full name`, `employer ID`, `Date of birth` , Place, Password FROM employers WHERE `employer ID` = :employerID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employerID', $employerID, PDO::PARAM_INT);
        $stmt->execute();



function getClientFullNameById($clientId) {
    global $conn; 

    $stmt = $conn->prepare("SELECT clients.`Full name` FROM clients WHERE `Client ID` = :clientId");
    $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();

    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
        return $client['Full name'];
    } else {
        return 'Client Not Found'; 
    }
}

function getemployerFullNameById($employerId) {
    global $conn; 

    $stmt = $conn->prepare("SELECT employers.`Full name` FROM employers WHERE `employer ID` = :employerId");
    $stmt->bindParam(':employerId', $employerId, PDO::PARAM_INT);
    $stmt->execute();

    $employer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employer) {
        return $employer['Full name'];
    } else {
        return 'employer Not Found'; 
    }
}
        
function updateComplimentStatusById($ComplimentId, $status) {
    global $conn;
    $updateQuery = "UPDATE compliments SET `status` = :status WHERE `compliment ID` = :ComplimentId";
    $updateStatement = $conn->prepare($updateQuery);
    $updateStatement->bindParam(':status', $status, PDO::PARAM_STR);
    $updateStatement->bindParam(':ComplimentId', $ComplimentId, PDO::PARAM_INT);
    $updateStatement->execute();
}


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
                        <label for="address">place:</label>
                        <p id="place">' . $row['Place'] . '</p>
                        </div>
                        </div>';
                    break;

        case 'add':

            $exist = true;
            while ($exist) {
                $employerID = 10000 + rand(1, 9999);

                $sql = "SELECT COUNT(*) FROM employers WHERE `Employer ID` = :employerID";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':employerID', $employerID, PDO::PARAM_INT);
                $stmt->execute();
                $count = $stmt->fetchColumn();

                if ($count === 0) {
                    $exist = false;
                }
            }


            $content = '<div class="form-container">
                    <form method="Post">
                        <h2 class="form-heading">Add New Agent</h2>
                
                        <div class="input-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" id="firstName" name="firstName" placeholder="Enter agent\'s first name">
                        </div>
                
                        <div class="input-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" id="lastName" name="lastName" placeholder="Enter agent\'s last name">
                        </div>
                
                        <div class="input-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob">
                        </div>
                
                        <div class="input-group">
                            <label for="employerID">Employer ID:</label>
                            <input type="number" id="employerID" name="employerID" value="' . $employerID . '" disabled>
                        </div>
                
                        <div class="input-group">
                            <label for="bureau">Bureau:</label>
                            <input type="text" id="bureau" name="bureau" placeholder="Enter agent\'s bureau">
                        </div>
                
                        <div class="input-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Enter agent\'s password">
                        </div>
                
                        <input class="submit-btn" type="submit" value="Submit">
                        </form>
                    </div>';
            

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
                        $lastName = isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '';
                        $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
                        $bureau = isset($_POST['bureau']) ? htmlspecialchars($_POST['bureau']) : '';
                        $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
                        $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
                        $category = isset($_POST['Category']) ? htmlspecialchars($_POST['Category']) : '';
                        $subscriptionType = isset($_POST['subscriptionType']) ? htmlspecialchars($_POST['subscriptionType']) : '';

                        $fullname = $firstName . ' ' . $lastName ;
                        $profilePicture = '../pictures/tram.jpg'; // Default Profile Picture
                        $Type = 'Agent';
                        
                    
                        $formattedDob = date('Y-m-d', strtotime($dob));
                        $clientsInsertQuery = "INSERT INTO employers (`Type`, `Full name`, `Date of birth`, `employer ID`, `Place`, `password`)
                                                VALUES (:Type, :fullName, :dob, :employerID, :bureau, :password)";
                    
                        $clientsInsertStatement = $conn->prepare($clientsInsertQuery);
                        $clientsInsertStatement->bindParam(':Type', $Type, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':fullName', $fullname, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':dob', $formattedDob, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':employerID', $employerID, PDO::PARAM_INT);
                        $clientsInsertStatement->bindParam(':bureau', $bureau, PDO::PARAM_STR);
                        $clientsInsertStatement->bindParam(':password', $password, PDO::PARAM_STR);
                    
                        $clientsInsertStatement->execute();

                        header("Refresh:1");

                    }
            break;

        
                
        case 'contact':
            
            $sql = "SELECT `Compliment ID`, `Client ID`,`employer ID`,   `Subject` , `Message`, `status` FROM compliments ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $compliments = $stmt->fetchALL(PDO::FETCH_ASSOC);


            if (isset($_GET['sort'])) {
                $i = 1;
                $j = -1;
                usort($compliments, function($a, $b) {
                    $statusOrder = ['checked' => 1, 'unchecked' => 2];
            
                    return $statusOrder[$a['status']] - $statusOrder[$b['status']];
                });
            }

            function generateSortLink($status) {
                $currentSort = isset($_GET['sort']) ? $_GET['sort'] : '';
                $queryString = http_build_query(['sort' => $status]);
                return "?$queryString&content=contact";
            }

            $condition2 = isset($_GET['sort']) && $_GET['sort'] == 'unchecked';

            if (!isset($_GET['sort']) || $condition2){
                $sortLink = generateSortLink('checked');
            } else {
                $sortLink = generateSortLink('unchecked');                
            }

            if (isset($_GET['sort']) && $_GET['sort'] == 'checked') {
                usort($compliments, function($a, $b) {
                    $statusOrder = ['checked' => 1, 'unchecked' => 2];
                    return $statusOrder[$a['status']] - $statusOrder[$b['status']];
                });
            } elseif (isset($_GET['sort']) && $_GET['sort'] == 'unchecked') {
                usort($compliments, function($a, $b) {
                    $statusOrder = ['checked' => 2, 'unchecked' => 1];
                    return $statusOrder[$a['status']] - $statusOrder[$b['status']];
                });
            }

            $tablerow = '';
            foreach ($compliments as $compliment) {
                
                
                if ($compliment['Client ID'] != 20000) {
                    
                    $clientFullName = getClientFullNameById($compliment['Client ID']);
                    $sender = '<td>from: ' . $clientFullName . ' (Client)</td>';
                } else {
                    
                    $employerFullName = ($compliment['employer ID'] == 10000) ? 'deleted user' : getEmployerFullNameById($compliment['employer ID']);
                    $sender = '<td>from: ' . $employerFullName . ' (Agent)</td>';
                }

                
                if ($compliment['status'] == 'unchecked') {
                    $stat = '<td><form method="post">
                            <input type="hidden" name="complimentId" value="' . $compliment['Compliment ID'] . '">
                            <input type="submit" name="checkCompliment" value="Check">
                            </form></td>';
                } else {
                    $stat = '<td>' . ' ' . $compliment['status'] . '</td>';
                }

                // function employersender($statement, $option) {
                //     return $statement ? $option : "Deleted account";
                // }

                // $employersender = employersender(($compliment['employer ID'] == 10000), $compliment['employer ID']) . $stat;
                

                $tablerow .= '<tr>
                <td>' . $compliment['Compliment ID'] . '</td>
                <td>' . $compliment['Subject'] . '</td>
                ' . $sender . ' ' . $stat .'
                </tr>
                <tr>
                <td colspan = "1">  Message:  </td>
                <td style="background-color:#eee;" colspan = "3">' . $compliment['Message'] . '</td>
                </tr>';
            }

            $content = '<table border="1">
                    <tr>
                        <th style="width:20%;">Compliment ID</th>
                        <th style="width:60%;">Subject</th>
                        <th style="width:20%;">Sender</th>
                        <th style="width:20%;">Status</th>
                    </tr>' . $tablerow . '<tr> <td style="text-align:center;" colspan="4">
                    <a href=" ' . $sortLink .' " ><input type="submit" name="toggleSortButton" value="Sort by unChecked"></a>
                    </td></table>';

            


            if (isset($_POST['checkCompliment'])) {
                $checkedComplimentId = $_POST['complimentId'];
                updateComplimentStatusById($checkedComplimentId, 'checked');
                header("Refresh:0");
            }
            break;

        case 'subs':
            
            $stmt = $conn->prepare("SELECT * FROM subscription");
            $stmt->execute();
            $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            function getClientFullName($clientId) {
                global $conn;
                $stmt = $conn->prepare("SELECT `Full name` FROM clients WHERE `Client ID` = :clientId");
                $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
                $stmt->execute();
        
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                return $result ? $result['Full name'] : null;
            }

            $sortColumn = 'Client ID';
            $sortOrder = 'asc';
            
            if (isset($_GET['sortColumn']) && isset($_GET['sortOrder'])) {
                $sortColumn = $_GET['sortColumn'];
                $sortOrder = $_GET['sortOrder'];
            }


            if ($sortColumn == "Full name") {
                usort($subscriptions, function($a, $b) use ($sortOrder) {
                    $fullNameA = getClientFullName($a['Client ID']);
                    $fullNameB = getClientFullName($b['Client ID']);
                
                    return $sortOrder === 'asc' ? strcmp($fullNameA, $fullNameB) : strcmp($fullNameB, $fullNameA) ;
                });
            }else {
                usort($subscriptions, function($a, $b) use ($sortColumn, $sortOrder) {
                    return $sortOrder === 'asc' ? strcmp($a[$sortColumn], $b[$sortColumn]) : strcmp($b[$sortColumn], $a[$sortColumn]);
                });
            }

            $content = '<table border="1">
                            <thead>
                                <tr>
                                    <th class="sort" onclick="sortTable(\'Client ID\')" >Client ID<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Full name\')" >Full Name<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Date of demand\')" >Date of demand<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Date Acceptance\')" >Date Acceptance<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Type\')" >Type<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Expiration\')" >Expiration<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Status\')" >Status<span class="arrow-down"></span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';



            foreach ($subscriptions as $subscription) {
                $clientId = $subscription['Client ID'];
                $clientFullName = getClientFullName($clientId);

                $content .= '<tr>
                                <td style="width:10%;">' . $subscription['Client ID'] . '</td>
                                <td style="width:15%;">' . $clientFullName . '</td>
                                <td style="width:15%;">' . $subscription['Date of demand'] . '</td>
                                <td style="width:15%;">' . $subscription['Date Acceptance'] . '</td>
                                <td style="width:10%;">' . $subscription['Type'] . '</td>
                                <td style="width:15%;">' . $subscription['Expiration'] . '</td>
                                <td style="width:10%;">' . $subscription['Status'] . '</td>
                                <td style="width:10%;"><form style="display: inline-block; margin-right: 10px;" method="post"><input type="hidden" name="deleteID" value="' . $subscription['Client ID'] . '"><input type="submit" name="delete" value="Delete"></form></td>
                            </tr>';
            }

            $content .= '</tbody>
                        </table>';


            function deleteSubscription($clientID) {
                global $conn;
            
                $stmt = $conn->prepare("DELETE FROM subscription WHERE `Client ID` = :clientID");
                $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                $stmt->execute();
        
                return true;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                $deleteID = $_POST['deleteID'];
                deleteSubscription($deleteID);
                header("Refresh:0");
            }

            break;
        
        case 'agents':
            
            $stmt = $conn->prepare("SELECT * FROM employers WHERE Type = 'Agent'");
            $stmt->execute();
            $employers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sortColumn = 'Full name';
            $sortOrder = 'asc';
            
            if (isset($_GET['sortColumn']) && isset($_GET['sortOrder'])) {
                $sortColumn = $_GET['sortColumn'];
                $sortOrder = $_GET['sortOrder'];
            }

            usort($employers, function($a, $b) use ($sortColumn, $sortOrder) {
                return $sortOrder === 'asc' ? strcmp($a[$sortColumn], $b[$sortColumn]) : strcmp($b[$sortColumn], $a[$sortColumn]);
            });


            $content = '<table border="1">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th class="sort" onclick="sortTable(\'Full name\')" >Full Name<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Date of birth\')" >Date of Birth<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'employer ID\')" >Employer ID<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Place\')" >Place<span class="arrow-down"></span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($employers as $employer) {
                $content .= '<tr>
                                <td>' . $employer['Type'] . '</td>
                                <td>' . $employer['Full name'] . '</td>
                                <td>' . $employer['Date of birth'] . '</td>
                                <td>' . $employer['employer ID'] . '</td>
                                <td>' . $employer['Place'] . '</td>
                                <td style="width:20%;"><form style="display: inline-block; margin-right: 10px;" method="post"><input type="hidden" name="deleteID" value="' . $employer['employer ID'] . '"><input type="submit" name="delete" value="Delete"></form>
                                <form style="display: inline-block;" method="post"><input type="hidden" name="editID" value="' . $employer['employer ID'] . '"><input type="submit" name="reset" value="Reset Password"></form></td>
                            </tr>';
            }

            $content .= '</tbody>
                        </table>';

            function updateComplimentID($searchID) {
                global $conn;

                $stmt = $conn->prepare("SELECT * FROM compliments WHERE `employer ID` = :searchID");
                $stmt->bindParam(':searchID', $searchID);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Update the employer ID to 10000 for each matching record
                foreach ($results as $result) {
                    $stmt = $conn->prepare("UPDATE compliments SET `employer ID` = 10000 WHERE `employer ID` = :searchID");
                    $stmt->bindParam(':searchID', $searchID);
                    $stmt->execute();
                }
 
                return count($results); // Return the number of updated records
            }

            function deleteEmployerByID($employerID) {
                global $conn;
            
                // Delete the employer with the specified ID
                $stmt = $conn->prepare("DELETE FROM employers WHERE `employer ID` = :employerID");
                $stmt->bindParam(':employerID', $employerID);
                $stmt->execute();
            
                // Return the number of deleted records
                return $stmt->rowCount();
            }

            function resetmployerpws($employerID) {
                global $conn;

                $stmt = $conn->prepare("SELECT * FROM employers WHERE `employer ID` = :employerID");
                $stmt->bindParam(':employerID', $employerID);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Update the employer ID to 10000 for each matching record
                foreach ($results as $result) {
                    $stmt = $conn->prepare("UPDATE employers SET `password` = 'hash' WHERE `employer ID` = :employerID");
                    $stmt->bindParam(':employerID', $employerID);
                    $stmt->execute();
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                $deleteID = $_POST['deleteID'];
                updateComplimentID($deleteID);
                deleteEmployerByID($deleteID);
                header("Refresh:0");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
                $editID = $_POST['editID'];
                resetmployerpws($editID);
                header("Refresh:1");
            }

            


            break;

        case 'clients':
            
            $stmt = $conn->prepare("SELECT * FROM clients WHERE `Client ID` <> 20000");
            $stmt->execute();
            $Clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sortColumn = 'Full name';
            $sortOrder = 'asc';
            
            if (isset($_GET['sortColumn']) && isset($_GET['sortOrder'])) {
                $sortColumn = $_GET['sortColumn'];
                $sortOrder = $_GET['sortOrder'];
            }

            usort($Clients, function($a, $b) use ($sortColumn, $sortOrder) {
                return $sortOrder === 'asc' ? strcmp($a[$sortColumn], $b[$sortColumn]) : strcmp($b[$sortColumn], $a[$sortColumn]);
            });

            $content = '<table border="1">
                            <thead>
                                <tr>
                                    <th class="sort" onclick="sortTable(\'phone number\')" >Phone number<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Full name\')" >Full Name<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Date of birth\')" >Date of Birth<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Client ID\')" >Client ID<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Category\')" >Category<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'address\')" >Address<span class="arrow-down"></span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($Clients as $Client) {
                $content .= '<tr>
                                <td style="width:15%;">' . $Client['phone number'] . '</td>
                                <td style="width:15%;">' . $Client['Full name'] . '</td>
                                <td style="width:15%;">' . $Client['Date of birth'] . '</td>
                                <td style="width:10%;">' . $Client['Client ID'] . '</td>
                                <td style="width:10%;">' . $Client['Category'] . '</td>
                                <td style="width:15%;">' . $Client['address'] . '</td>
                                <td style="width:20%;"><form style="display: inline-block; margin-right: 10px;" method="post"><input type="hidden" name="deleteID" value="' . $Client['Client ID'] . '"><input type="submit" name="delete" value="Delete"></form>
                                <form style="display: inline-block;" method="post"><input type="hidden" name="editID" value="' . $Client['Client ID'] . '"><input type="submit" name="reset" value="Reset Password"></form></td>
                            </tr>';
            }

            $content .= '</tbody>
                        </table>';

            function updateComplimentID($searchID) {
                global $conn;

                $stmt = $conn->prepare("SELECT * FROM compliments WHERE `Client ID` = :searchID");
                $stmt->bindParam(':searchID', $searchID);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $result) {
                    $stmt = $conn->prepare("UPDATE compliments SET `Client ID` = 20000 WHERE `Client ID` = :searchID");
                    $stmt->bindParam(':searchID', $searchID);
                    $stmt->execute();
                }
 
                return count($results); // Return the number of updated records
            }

            function deleteClientByID($ClientID) {
                global $conn;
            
                // Delete the Client with the specified ID
                $stmt = $conn->prepare("DELETE FROM clients WHERE `Client ID` = :ClientID");
                $stmt->bindParam(':ClientID', $ClientID);
                $stmt->execute();
            
                // Return the number of deleted records
                return $stmt->rowCount();
            }

            function deleteSubscription($clientId) {
                global $conn;
            
                $stmt = $conn->prepare("DELETE FROM subscription WHERE `Client ID` = :clientId");
                $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
                $stmt->execute();
        
                return true;
            }
            
            function resetmployerpws($ClientID) {
                global $conn;

                $stmt = $conn->prepare("SELECT * FROM clients WHERE `Client ID` = :ClientID");
                $stmt->bindParam(':ClientID', $ClientID);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Update the Client ID to 10000 for each matching record
                foreach ($results as $result) {
                    $stmt = $conn->prepare("UPDATE clients SET `password` = 'clienthash' WHERE `Client ID` = :ClientID");
                    $stmt->bindParam(':ClientID', $ClientID);
                    $stmt->execute();
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                $deleteID = $_POST['deleteID'];
                updateComplimentID($deleteID);
                deleteSubscription($deleteID);
                deleteClientByID($deleteID);
                header("Refresh:0");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
                $editID = $_POST['editID'];
                resetmployerpws($editID);
            }

            break;

        case 'cards':

            $stmt = $conn->prepare("SELECT * FROM subscription");
            $stmt->execute();
            $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $filteredSubscriptions = array_filter($subscriptions, function($subscription) {
                return in_array($subscription['Status'], ['Ruined', 'Lost']);
            });

            $subscriptions = $filteredSubscriptions;

            function getClientFullName($clientId) {
                global $conn;
                $stmt = $conn->prepare("SELECT `Full name` FROM clients WHERE `Client ID` = :clientId");
                $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);
                $stmt->execute();
        
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                return $result ? $result['Full name'] : null;
            }

            $sortColumn = 'Client ID';
            $sortOrder = 'asc';
            
            if (isset($_GET['sortColumn']) && isset($_GET['sortOrder'])) {
                $sortColumn = $_GET['sortColumn'];
                $sortOrder = $_GET['sortOrder'];
            }


            if ($sortColumn == "Full name") {
                usort($subscriptions, function($a, $b) use ($sortOrder) {
                    $fullNameA = getClientFullName($a['Client ID']);
                    $fullNameB = getClientFullName($b['Client ID']);
                
                    return $sortOrder === 'asc' ? strcmp($fullNameA, $fullNameB) : strcmp($fullNameB, $fullNameA) ;
                });
            }else {
                usort($subscriptions, function($a, $b) use ($sortColumn, $sortOrder) {
                    return $sortOrder === 'asc' ? strcmp($a[$sortColumn], $b[$sortColumn]) : strcmp($b[$sortColumn], $a[$sortColumn]);
                });
            }

            $content = '<table border="1">
                            <thead>
                                <tr>
                                    <th class="sort" onclick="sortTable(\'Client ID\')" >Client ID<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Full name\')" >Full Name<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Date of demand\')" >Date of demand<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Date Acceptance\')" >Date Acceptance<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Type\')" >Type<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Expiration\')" >Expiration<span class="arrow-down"></span></th>
                                    <th class="sort" onclick="sortTable(\'Status\')" >Status<span class="arrow-down"></span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';



            foreach ($subscriptions as $subscription) {
                $clientId = $subscription['Client ID'];
                $clientFullName = getClientFullName($clientId);

                $content .= '<tr>
                                <td style="width:10%;">' . $subscription['Client ID'] . '</td>
                                <td style="width:15%;">' . $clientFullName . '</td>
                                <td style="width:15%;">' . $subscription['Date of demand'] . '</td>
                                <td style="width:15%;">' . $subscription['Date Acceptance'] . '</td>
                                <td style="width:10%;">' . $subscription['Type'] . '</td>
                                <td style="width:15%;">' . $subscription['Expiration'] . '</td>
                                <td style="width:10%;">' . $subscription['Status'] . '</td>
                                <td style="width:10%;"><form style="display: inline-block; margin-right: 10px;" method="post"><input type="hidden" name="updateID" value="' . $subscription['Client ID'] . '"><input type="submit" name="update" value="Found!"></form></td>
                            </tr>';
            }

            $content .= '</tbody>
                        </table>';


            function updateSubscription($clientID) {
                global $conn;
            
                $stmt = $conn->prepare("UPDATE subscription SET `Status` = 'inhold'  WHERE `Client ID` = :clientID");
                $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
                $stmt->execute();
        
                return true;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                $updateID = $_POST['updateID'];
                updateSubscription($updateID);
                header("Refresh:0");
            }

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
        case 'logout':
            setcookie('session', '', time() - 3600, '/');
                        header("Location: ..");
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

        label {
            margin-bottom: 5px;
            font-size: 18px;
            color: #000000;
        }

        .input-group input[type="text"],
        .input-group input[type="email"],
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

        .sort {
            cursor: pointer;
        }
        .sort:hover {
            background-color: #999;
        }

        .arrow-up::after {
            content: " ▲";
        }

        .arrow-down::after {
            content: " ▼";
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
            <a href="?content=contact" class="page-link">- messages</a>
            <h3 class="link-sections">Manage users</h3>
            <hr>
            <a href="?content=add" class="page-link">- new user</a>
            <a href="?content=agents" class="page-link">- agents</a>
            <a href="?content=clients" class="page-link">- clients</a>
            <h3 class="link-sections">Activities</h3>
            <hr>
            <a href="?content=subs" class="page-link">- view subscriptions</a>
            <a href="?content=cards" class="page-link">- Lost cards</a>
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


<script src="script.js"></script>


</body>

</html>

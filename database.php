<?php

class Database {
    public $host;
    public $dbname;
    public $username;
    public $password;
    public $conn;

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        $this->connectToDatabase();
        // $this->connectToDatabase();
    }

    public function connectToDatabase() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};port=3306;dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Server Connection failed: " . $e->getMessage();
        }
    }

    // public function connectToDatabase() {
    //     try {
    //         $this->conn->exec("USE {$this->dbname}");
    //     } catch (PDOException $e) {
    //         echo "Database Connection failed: " . $e->getMessage();
    //     }
    // }

    public function closeConnection() {
        $this->conn = null;
    }

    // public function getConnections() {
    //     return $this->conn;
    // }
}

class Employers {
    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS employers (
                Type ENUM('Admin', 'Agent'),
                `Full name` VARCHAR(255),
                `Date of birth` DATE,
                `employer ID` INT PRIMARY KEY,
                Place VARCHAR(255),
                Password VARCHAR(255)
            )
        ";

        $this->db->connectToServer()->exec($sql);
    }
}

class Clients {
    private $db;

    // Clients table columns as class properties

    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS clients (
                `Full name` VARCHAR(255),
                `Client ID` INT PRIMARY KEY,
                `Date of birth` DATE,
                `phone number` VARCHAR(20),
                email VARCHAR(255),
                address VARCHAR(255),
                `social ID` VARCHAR(20),
                Category VARCHAR(255),
                `Profile Picture` VARCHAR(255),
                Password VARCHAR(255)
            )
        ";

        $this->db->connectToServer()->exec($sql);
    }
}

class Subscription {
    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS subscription (
                `Client ID` INT,
                FOREIGN KEY (`Client ID`) REFERENCES clients(`Client ID`),
                Status ENUM('inhold','Valid', 'Outdated', 'Lost','Ruined'),
                `Date of demand` DATE,
                `Date Acceptance` DATE,
                `Expiration` DATE
            )
        ";

        $this->db->connectToServer()->exec($sql);
    }
}

class Compliments {
    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS compliments (
                `Compliment ID` INT PRIMARY KEY,
                `Client ID` INT,
                FOREIGN KEY (`Client ID`) REFERENCES clients(`Client ID`),
                `employer ID` INT,
                FOREIGN KEY (`employer ID`) REFERENCES employers(`employer ID`),
                `Status` ENUM('checked', 'unchecked'),
                Message TEXT,
                `Subject` VARCHAR(255)
            )
        ";

        $this->db->connectToServer()->exec($sql);
    }
}

class AdditionalItems {
    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS additional_items (
                `name` VARCHAR(255),
                content TEXT
            )
        ";

        $this->db->connectToServer()->exec($sql);
    }
}

class Refuses {
    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS Refuses (
                `Client ID` INT,
                FOREIGN KEY (`Client ID`) REFERENCES clients(`Client ID`),
                message TEXT
            )
        ";

        $this->db->connectToServer()->exec($sql);
    }
}

class feedbacks {
    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS feedbacks (
                FeedbackID INT PRIMARY KEY AUTO_INCREMENT,
                `Client ID` INT,
                Rating INT,
                Comments TEXT,
                FOREIGN KEY (`Client ID`) REFERENCES clients(`Client ID`)
            );
        ";

        $this->db->connectToServer()->exec($sql);
    }

    
    
}

// $database = new Database("loaclhost", "Setram", "root", "");
// $employersTable = new Employers($database);
// $clientsTable = new Clients($database);
// $subscriptionTable = new Subscription($database);
// $complimentsTable = new Compliments($database);
// $additionalItemsTable = new AdditionalItems($database);
// $add = new Refuses($database);
// $feedbacks = new feedbacks($database);


// $employersTable->createTable();
// $clientsTable->createTable();
// $subscriptionTable->createTable();
// $complimentsTable->createTable();
// $additionalItemsTable->createTable();
// $add->createTable();
// $feedbacks->createTable();


?>
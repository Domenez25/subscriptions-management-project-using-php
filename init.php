<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php';

$database = new Database("sql212.infinityfree.com", "if0_35316583_Setram", "if0_35316583", "95vhnfp7");
$employersTable = new Employers($database);
$clientsTable = new Clients($database);
$subscriptionTable = new Subscription($database);
$complimentsTable = new Compliments($database);
$additionalItemsTable = new AdditionalItems($database);
$add = new Refuses($database);
$feedbacks = new feedbacks($database);


$employersTable->createTable();
$clientsTable->createTable();
$subscriptionTable->createTable();
$complimentsTable->createTable();
$additionalItemsTable->createTable();
$add->createTable();
$feedbacks->createTable();


$connexion = new PDO("mysql:host=sql212.infinityfree.com;port=3306;dbname=if0_35316583_Setram","if0_35316583","95vhnfp7");
$query = "INSERT INTO employers (`Type`, `Full name`, `Date of birth`, `employer ID`, `Place`, `password`)
        VALUES  ('Admin', 'Bouzara Zakaria', '2003-10-02', 10000, 'Headquarter', 'pass')";
            
$e = $connexion->prepare($query);
$e->execute();


// $database->closeConnection();

?>

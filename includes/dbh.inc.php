<?php
global $pdo;

//Database message
$dsn = "mysql:host=localhost;dbname=foodwastemanagementsystem";
$dbusername = "root";
$dbpassword = "";

//Connection to database(using PDO method), if error, pop out the error message
try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
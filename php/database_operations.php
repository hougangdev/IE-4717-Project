<?php
// File: database_operations.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haochi";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


// $conn = null;
?>
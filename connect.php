<?php

$servername = "localhost";
$username = "root"; 
$password = "password"; 
$database = "youdemy";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $error) {
    echo "Connection failed: " . $error->getMessage();
}
?>

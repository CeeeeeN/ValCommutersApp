<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "valcommutersdb";

try {
    
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}
?>
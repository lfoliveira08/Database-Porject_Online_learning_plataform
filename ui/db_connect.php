<?php
// db_connect.php
$host     = getenv('DB_HOST') ?: "localhost";
$dbname   = "OnlineLearningPlatform";
$username = "root";          // Change to your MySQL username if necessary
$password = "";              // Change to your MySQL password if necessary

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

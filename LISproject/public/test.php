<?php
$servername = "localhost";
$username = "root";
$password = "";  // XAMPP root password is empty
$dbname = "ls";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Database connected successfully!";
?>

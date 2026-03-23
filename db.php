<?php
$host = "localhost";
$user = "root";   // XAMPP default user
$pass = "";       // agar password set hai to likho
$dbname = "tpo";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php

$host = "localhost";
$username = "root";
$password = ""; // Replace with your actual database password
$database = "travel_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>
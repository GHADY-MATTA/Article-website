<?php
// Simple database connection

$host = 'localhost'; // Database host
$user = 'root'; // Database username
$pass = ''; // Database password
$dbname = 'articledb'; // Database name

// Create the connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

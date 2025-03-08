<?php
// Assuming you have a class for the database connection
require_once('website-wallet/server(api)/php/db.php');

// Start the session and check if the user is logged in
session_start();
$user_id = $_SESSION['user_id'];  // Assuming user ID is stored in session

// Create the database connection
$db = new Database();
$conn = $db->getConnection();

// Prepare and execute the SQL query to fetch the user data
$query = "SELECT username, email, phone, address FROM usersinfo WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// Fetch the result
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Return the data as JSON
echo json_encode($user_data);

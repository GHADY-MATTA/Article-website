<?php
// Start session to check for logged-in user
session_start();

// Check if user is logged in (assumes you have a session for user_id)
if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in.";
    exit();
}

// Create the connection to the SQL database
$conn = mysqli_connect("localhost", "root", "", "usersignupWallet");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch P2P number of the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT p2pnumber FROM usersmail WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the P2P number of the user
    $row = $result->fetch_assoc();
    echo $row['p2pnumber'];
} else {
    echo "No P2P number found.";
}

$conn->close();

<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usersignupwallet";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database for all three tables: usersmail, transactions, p2p_transactions
$sql_usersmail = "SELECT * FROM usersmail";
$sql_transaction = "SELECT * FROM transactions";
$sql_p2p_transaction = "SELECT * FROM p2p_transactions";

// Execute queries
$result_usersmail = $conn->query($sql_usersmail);
$result_transaction = $conn->query($sql_transaction);
$result_p2p_transaction = $conn->query($sql_p2p_transaction);

// Create an array to store the data
$data = [];

// Fetch data from usersmail table
$data['usersmail'] = $result_usersmail->num_rows > 0 ? $result_usersmail->fetch_all(MYSQLI_ASSOC) : [];

// Fetch data from transaction table
$data['transaction'] = $result_transaction->num_rows > 0 ? $result_transaction->fetch_all(MYSQLI_ASSOC) : [];

// Fetch data from p2p_transaction table
$data['p2p_transaction'] = $result_p2p_transaction->num_rows > 0 ? $result_p2p_transaction->fetch_all(MYSQLI_ASSOC) : [];

// Return the data as JSON
echo json_encode($data);

// Close the connection
$conn->close();

<?php
header("Content-Type: application/json"); //should add the jason path here or the editprofile.js

// Database credentials
$host = "localhost"; // Change if necessary
$user = "root"; // Your database username
$password = ""; // Your database password
$database = "usersignuwallet";

// Connect to MySQL database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Read JSON input from Axios
$data = json_decode(file_get_contents("php://input"), true); //what is php slash iput do i need to inser a php path or is somet hing for axios 

if (!isset($data["table"]) || !isset($data["changes"])) { // what is table the name of my table in teh data base usersignupwallet cs its named usersmail
    echo json_encode(["success" => false, "error" => "Invalid request parameters."]);
    exit;
}

$table = $conn->real_escape_string($data["table"]); //here also what is table and changes
$changes = $data["changes"];

// Validate table name (Prevent SQL Injection)
$allowed_tables = ["usersmail"];
if (!in_array($table, $allowed_tables)) {
    echo json_encode(["success" => false, "error" => "Invalid table name."]);
    exit;
}

// Construct SQL UPDATE statement
$set_clause = [];
foreach ($changes as $column => $value) {
    $safe_column = $conn->real_escape_string($column);
    $safe_value = $conn->real_escape_string($value);
    $set_clause[] = "$safe_column = '$safe_value'";
} //wtf is this trace it

// Ensure there is a valid identifier (modify as needed for security)
if (!isset($changes['username'])) {
    echo json_encode(["success" => false, "error" => "Missing identifier."]);
    exit; // what happening here
}
$username = $conn->real_escape_string($changes['username']);

$update_query = "UPDATE $table SET " . implode(", ", $set_clause) . " WHERE username = '$username'";
//is here that we are hangin the old dat t new data
// Execute query
if ($conn->query($update_query) === TRUE) {
    echo json_encode(["success" => true, "message" => "Record updated successfully."]);
} else {
    echo json_encode(["success" => false, "error" => "Error: " . $conn->error]);
}

// Close connection
$conn->close();

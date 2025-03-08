<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Include the external database connection file
require_once('../../admin/generals/connection.php');

// Create a database instance
$db = new Database();

// Prepare SQL query to fetch username and email from the usersmail table
$sql = "SELECT username, email FROM usersmail";
$result = $db->getConnection()->query($sql);

if ($result->num_rows > 0) {
    // Fetch all results and return as an array
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Return the users data as a JSON response
    echo json_encode($users);
} else {
    // If no results, return an empty array
    echo json_encode([]);
}

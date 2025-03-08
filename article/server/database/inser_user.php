<?php
// Include the database connection
require_once '/article/server/database/db.php';

// Get the data from the previous request (e.g., from signup.php)
$data = $_POST['signupvar'] ?? null;

if ($data) {
    // Extract data from the signup array
    $username = $data['username'];
    $lastname = $data['lastname'];
    $email = $data['useremail'];
    $password = $data['userpasswordhash'];

    // Prepare the SQL insert statement
    $stmt = $conn->prepare("INSERT INTO userinfo (username, userlastname, useremail, userpasswordhash, createdat) VALUES (?, ?, ?, ?, NOW())");

    // Bind the parameters to the statement
    $stmt->bind_param("ssss", $username, $lastname, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error inserting user."]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No data received."]);
}

// Close the database connection
$conn->close();

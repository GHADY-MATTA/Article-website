<?php

// Include the database connection file
require_once '/article/server/database/db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read JSON input from signup.php
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Check if signupvar is set
    if (isset($inputData['signupvar'])) {
        // Extract signup data
        $signupData = $inputData['signupvar'];

        // Prepare data for database insertion
        $username = $signupData['username'];
        $lastname = $signupData['lastname'];
        $email = $signupData['useremail'];
        $password = $signupData['userpasswordhash'];

        // Prepare the SQL query to insert the data
        $stmt = $conn->prepare("INSERT INTO userinfo (username, userlastname, useremail, userpasswordhash, createdat) VALUES (?, ?, ?, ?, NOW())");

        // Bind the data to the prepared statement
        $stmt->bind_param("ssss", $username, $lastname, $email, $password);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "User successfully inserted."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error inserting user."]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid data received."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

// Close the database connection
$conn->close();

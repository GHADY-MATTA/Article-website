<?php
// Include the database connection
include('C:\Users\Matta\Desktop\XAMP\htdocs\article\server\conn\db.php');

// Set the header for JSON response
header('Content-Type: application/json');

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is received
if ($data) {
    // Extract data from JSON
    $username = $data['username'];
    $lastname = $data['lastname'];
    $email = $data['email'];
    $questions = $data['questions'];
    $answers = $data['answers'];

    // Insert data into the database
    $sql = "INSERT INTO qatabel (username, lastname, email, questions, answers) 
            VALUES ('$username', '$lastname', '$email', '$questions', '$answers')";

    if ($conn->query($sql) === TRUE) {
        // Success response
        echo json_encode(["message" => "New record created successfully"]);
    } else {
        // Error response
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} else {
    // If no data was received
    echo json_encode(["error" => "No data received"]);
}

// Close the database connection
$conn->close();

<?php
// Include the database connection
include('conn/db.php');


// Get the raw POST data (JSON format)
$data = json_decode(file_get_contents('php://input'), true);

// Check if data exists
if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'No data received or invalid JSON format.']);
    exit;
}

// Extract the data
$username  = $data['username'];
$lastname  = $data['lastname'];
$email     = $data['email'];
$questions = $data['questions'];
$answers   = $data['answers'];

// Validate the inputs
if (empty($username) || empty($lastname) || empty($email) || empty($questions) || empty($answers)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Insert the data directly into the qatable
$sql = "INSERT INTO qatable (username, lastname, email, userques, useranswer, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

// Bind the parameters: "sssss" indicates all five fields are strings
$stmt->bind_param("sssss", $username, $lastname, $email, $questions, $answers);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Question and answer submitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit the data. Please try again.']);
}

// Close the statement and connection
$stmt->close();
$conn->close();

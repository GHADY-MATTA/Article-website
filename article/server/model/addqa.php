<?php
// Include the database connection
include 'C:/Users/Matta/Desktop/XAMP/htdocs/article/server/conn/db.php';

// Get the data from the POST request
$username = $_POST['username']; // The username
$lastname = $_POST['lastname']; // The last name
$email = $_POST['email']; // The email
$questions = $_POST['questions']; // The user's question
$answers = $_POST['answers']; // The user's answer

// Validate the inputs (you can customize this)
if (empty($username) || empty($lastname) || empty($email) || empty($questions) || empty($answers)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Insert the data into the database (make sure your `articledb` and table are set up properly)
$sql = "INSERT INTO questions_answers (user_id, userques, useranswer, created_at) VALUES (?, ?, ?, NOW())";

// Prepare the statement to prevent SQL injection
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("sss", $username, $questions, $answers); // Assuming user_id can be the username for now

// Execute the query
if ($stmt->execute()) {
    // Respond with success
    echo json_encode(['success' => true, 'message' => 'Question and answer submitted successfully!']);
} else {
    // Respond with error
    echo json_encode(['success' => false, 'message' => 'Failed to submit the data. Please try again.']);
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

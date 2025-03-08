<?php
// Include the database connection
include 'C:/Users/Matta/Desktop/XAMP/htdocs/article/server/conn/db.php';


// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    die(json_encode(["success" => false, "message" => "Only POST requests are allowed."]));
}

// Read the JSON input
$inputData = json_decode(file_get_contents("php://input"), true);

// Validate if data is sent correctly
if (empty($inputData['username']) || empty($inputData['lastname']) || empty($inputData['email']) || empty($inputData['password'])) {
    die(json_encode(["success" => false, "message" => "All fields are required."]));
}

// Extract the data from the POST request
$username = trim($inputData['username']);
$lastname = trim($inputData['lastname']);
$email = trim($inputData['email']);
$password = $inputData['password'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die(json_encode(["success" => false, "message" => "Invalid email format."]));
}

// Validate password strength
if (strlen($password) < 8 || !preg_match("@[A-Z]@", $password) || !preg_match("@[0-9]@", $password)) {
    die(json_encode(["success" => false, "message" => "Password must be at least 8 characters, contain an uppercase letter and a number."]));
}

// Hash the password before storing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the data to insert into the database
$userData = [
    "username" => $username,
    "lastname" => $lastname,
    "email" => $email,
    "password" => $hashedPassword
];

// Prepare the SQL statement to insert user data
$sql = "INSERT INTO userinfo (username, userlastname, useremail, userpasswordhash, createdat) VALUES (?, ?, ?, ?, NOW())";

// Prepare statement and bind parameters
$stmt = $conn->prepare($sql);

// Check if the statement is prepared successfully
if ($stmt === false) {
    error_log("Failed to prepare SQL statement: " . $conn->error);
    die(json_encode(["success" => false, "message" => "Failed to prepare SQL statement."]));
}

// Bind parameters
$stmt->bind_param("ssss", $userData['username'], $userData['lastname'], $userData['email'], $userData['password']);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User registered successfully."]);
} else {
    error_log("SQL error: " . $stmt->error);
    echo json_encode(["success" => false, "message" => "Error registering user."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();

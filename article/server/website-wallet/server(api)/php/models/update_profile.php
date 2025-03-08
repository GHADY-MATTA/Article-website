<?php
// Include the database connection class
require_once('C:/Users/Matta/Desktop/XAMP/htdocs/website-wallet/server(api)/php/db.php');


// Start session and get user id (assuming it's stored in session)
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in.");
}
$user_id = $_SESSION['user_id'];  // Get user_id from the session

// Get the form data from the POST request
if (isset($_POST['username'], $_POST['email'], $_POST['address'], $_POST['phone'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $new_phone = $_POST['phone'];
    $new_password = $_POST['password']; // This should be hashed before storing
} else {
    die("Missing form data.");
}

// Create the database connection
$db = new Database();
$conn = $db->getConnection();

// Hash the password before saving it (if a new password is provided)
if (!empty($new_password)) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
} else {
    // If the password is not changed, don't modify it
    $hashed_password = null; // In this case, don't update the password
}

// Prepare the SQL query to update the user's data
$query = "UPDATE usersmail 
          SET username = :username, 
              email = :email, 
              address = :address, 
              phone = :phone" .
    ($hashed_password ? ", password_hash = :password_hash" : "") .
    " WHERE id = :user_id";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind the parameters to the query
$stmt->bindParam(':username', $new_username);
$stmt->bindParam(':email', $new_email);
$stmt->bindParam(':address', $new_address);
$stmt->bindParam(':phone', $new_phone);
$stmt->bindParam(':user_id', $user_id);

if ($hashed_password) {
    $stmt->bindParam(':password_hash', $hashed_password);
}

// Execute the query and handle the response
if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Error: Could not update your profile.";
}

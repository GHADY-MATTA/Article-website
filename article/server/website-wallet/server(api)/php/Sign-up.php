<?php 
// ------------------------ validation for the password, email, username, phone, and address 

// Validating the name
if(empty($_POST["username"])){
    die("Name is required");
}

// Validating email
if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

// Password validation
if(strlen($_POST["password"]) < 8){
    die("Password must be at least 8 characters");
}

if(!preg_match("@[A-Z]@", $_POST["password"])){
    die("Password must contain at least one uppercase letter");
}

if(!preg_match("@[0-9]@", $_POST["password"])){
    die("Password must contain at least one number");
}

if(!preg_match("@[^\w]@", $_POST["password"])){
    die("Password must contain at least one special character");
}

// Validating if password_confirmation is equal to password
if($_POST["password"] !== $_POST["password_confirmation"]){
    die("Passwords do not match");
}

// Validating phone (optional, if provided)
if (isset($_POST["phone"]) && !preg_match("/^\+?[1-9]\d{7,14}$/", $_POST["phone"])) {
    die("Invalid phone number");
}

// Validating address (optional, if provided)
if (isset($_POST["address"]) && empty(trim($_POST["address"]))) {
    die("Address is required");
}

// ------------------------ password hashing
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Include the database connection script
$mysqli = require __DIR__."/save-sql.php";

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Handle image upload
$profile_picture = null; // Default value

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/profile_pictures/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }
    
    $fileName = basename($_FILES['profile_picture']['name']);
    $filePath = $uploadDir . uniqid() . '_' . $fileName; // Ensure unique file name
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filePath)) {
        $profile_picture = $filePath; // Save the file path
    } else {
        die("Error uploading file.");
    }
}

// Determine the newsletter preference
$newsletter_preference = isset($_POST["no-updates"]) ? 'no-news' : 'send-news';

// Prepare the SQL query with the profile_picture column
$sql = "INSERT INTO usersMail (username, email, password_hash, news_letter, phone, address, profile_picture) 
        VALUES(?,?,?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);

// Check for errors in preparing the query
if(!$stmt){
    die("Query preparation failed: " . $mysqli->error);
}

// Bind the form data to the prepared statement, including the profile picture
$stmt->bind_param("sssssss", $_POST["username"], $_POST["email"], $password, $newsletter_preference, $_POST["phone"], $_POST["address"], $profile_picture);

// Execute the query and check for success
if ($stmt->execute()) {
    // Include the mailer function
    require_once __DIR__ . '/mailer-send.php';
    // Send the welcome email
    sendWelcomeEmail($_POST["username"], $_POST["email"]);
    echo "Sign-up successful! <a href='/website-wallet/client/assets/front/login.html'>Log in</a>";
}



// website-wallet\client\assets\front\login.html 
// Close the statement and connection
$stmt->close();
$mysqli->close();
?>

<?php
require 'C:\Users\Matta\Desktop\XAMP\htdocs\article\server\api1\jwt_helper.php';

// Check if the token exists and is valid
if (!isset($_COOKIE['token']) || !validate_jwt($_COOKIE['token'])) {
    header("Location: home.html"); // Redirect to home.html if no valid token
    exit();
}

// Decode the JWT token
$decoded = validate_jwt($_COOKIE['token']);
$user_name = $decoded->data->user_name;
?>

<!-- Redirect to HTML page -->
<?php include 'C:\Users\Matta\Desktop\XAMP\htdocs\article\client\home.html'; ?>
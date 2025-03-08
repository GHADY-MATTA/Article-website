<?php
session_start(); // Start the session at the beginning

$is_valid = true;

// Admin credentials (hardcoded)
$admin_email = "admin@gmail.com";
$admin_password = "52556266Aa@"; // Admin password

// Process the login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // First, check if the user is the admin
    if ($_POST["email"] === $admin_email && $_POST["password"] === $admin_password) {
        // Admin login: Set session and redirect to admin page
        $_SESSION["user_id"] = 1; // Admin user_id (can be set to 1 or any constant value)
        header("Location: /website-wallet/admin/admin.html");
        exit;
    }
    //  FSW\website-wallet\admin\admin.html

    // If not admin, proceed with normal user login
    $mysqli = require __DIR__ . "/save-sql.php";

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM usersMail WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            // Login success: Set the user ID in the session
            $_SESSION["user_id"] = $user["id"];  // Store the user's ID in session

            // Redirect to the profile page
             header("Location: /website-wallet/client/assets/front/profile.html?id=" . $user["id"]);
            exit;
        } //\website-wallet\client\assets\front\profile.html
    }
    // If login fails, redirect back to login page with error message
    header("Location: /website-wallet/client/assets/front/login.html?error=invalid");
    exit;
} //\website-wallet\client\assets\front\login.html
?>

<?php
require 'C:\Users\Matta\Desktop\XAMP\htdocs\article\server\conn\db.php'; // Database connection
require 'C:\Users\Matta\Desktop\XAMP\htdocs\article\server\api1\jwt_helper.php'; // JWT helper functions

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Use the MySQLi connection to prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM userinfo WHERE useremail = ?");
        $stmt->bind_param("s", $email); // Bind the email as a string
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user["userpasswordhash"])) {
            // Generate JWT token
            $token = generate_jwt($user["user_id"], $user["username"]);

            // Set JWT token in a cookie
            setcookie("token", $token, time() + 3600, "/", "", true, true); // 1-hour expiration

            // Redirect to the welcome page
            header("Location: welcome.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}

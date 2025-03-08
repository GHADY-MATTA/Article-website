<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$mysqli = require __DIR__ . "/save-sql.php";

// Fetch user details including balance
$sql = "SELECT username, email, phone, address, balance FROM usersMail WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
if ($user) {
    // Add balance value to the response data
    echo json_encode([
        "username" => $user["username"],
        "email" => $user["email"],
        "phone" => $user["phone"],
        "address" => $user["address"],
        "balance" => $user["balance"] // Ensure balance is included in the JSON response
    ]);
} else {
    echo json_encode(["error" => "User not found"]);
}
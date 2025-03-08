<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /website-wallet/client/assets/front/login.html");
    exit;
}

// Include the database connection file
$mysqli = require __DIR__ . "/save-sql.php";  // Adjust the path as needed

// Get the user ID from the session
$user_id = $_SESSION["user_id"];

// Get the deposit amount from the POST data
$amount = $_POST["amount"];
$transaction_type = "deposit";  // Only handling deposits

// Check if the amount is valid
if ($amount <= 0) {
    die("Amount must be greater than zero.");
}

// Start a transaction to ensure data integrity
$mysqli->begin_transaction();

try {
    // Insert a record into the transactions table for the deposit
    $reference_id = uniqid("txn_");  // Generate a unique reference ID for the transaction
    $sql = "INSERT INTO transactions (user_id, transaction_type, amount, status, reference_id) 
            VALUES (?, ?, ?, 'completed', ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("isds", $user_id, $transaction_type, $amount, $reference_id);
    $stmt->execute();

    // Commit the transaction
    $mysqli->commit();

    // Redirect the user back to the profile page with a success message
    header("Location: /website-wallet/client/assets/front/profile.html?id=" . $user_id . "&status=success");
    exit;

} catch (Exception $e) {
    // Rollback the transaction if an error occurs
    $mysqli->rollback();

    // Redirect the user back to the profile page with an error message
    header("Location: /website-wallet/client/assets/front/profile.html?id=" . $user_id . "&status=error&message=" . urlencode($e->getMessage()));
    exit;
}
?>

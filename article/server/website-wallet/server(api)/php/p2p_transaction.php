<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /website-wallet/client/assets/front/login.html");
    exit;
}

// Include the database connection file
$mysqli = require __DIR__ . "/save-sql.php";  // Adjust the path as needed

$sender_id = $_SESSION['user_id'];

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for required POST variables
    if (!isset($_POST['send_to_user'], $_POST['amount'])) {
        die("Invalid request.");
    }

    $recipient_p2pnumber = trim($_POST['send_to_user']);
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        die("Amount must be greater than zero.");
    }

    // Fetch the sender's p2pnumber from the usersmail table
    $sql = "SELECT p2pnumber FROM usersmail WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $sender_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Sender not found.");
    }
    $sender_row = $result->fetch_assoc();
    $sender_p2pnumber = $sender_row['p2pnumber'];

    // Fetch the receiver's details using the provided p2pnumber
    $sql = "SELECT id, p2pnumber FROM usersmail WHERE p2pnumber = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $recipient_p2pnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Recipient not found.");
    }
    $receiver_row = $result->fetch_assoc();
    $receiver_id = $receiver_row['id'];
    $receiver_p2pnumber = $receiver_row['p2pnumber'];

    // (Optional) Here you might want to check if the sender has enough funds.

    // Generate a unique reference ID for this transaction
    $reference_id = uniqid("txn_");

    // Start a transaction for data integrity
    $mysqli->begin_transaction();

    try {
        // Insert the p2p transaction into the database
        $sql = "INSERT INTO p2p_transactions (sender_user_id, receiver_user_id, sender_p2pnumber, recipient_p2pnumber, amount, status, reference_id) 
                VALUES (?, ?, ?, ?, ?, 'completed', ?)";
        $stmt = $mysqli->prepare($sql);
        // Bind parameters: sender ID, receiver ID, sender's p2pnumber, recipient's p2pnumber, amount, and reference ID
        $stmt->bind_param("iissds", $sender_id, $receiver_id, $sender_p2pnumber, $receiver_p2pnumber, $amount, $reference_id);
        $stmt->execute();

        // Commit the transaction
        $mysqli->commit();

        // Redirect back to profile with a success message
        header("Location: /website-wallet/client/assets/front/profile.html?status=success");
        exit;
    } catch (Exception $e) {
        // Rollback on error
        $mysqli->rollback();
        header("Location: /website-wallet/client/assets/front/profile.html?status=error&message=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    die("Invalid request method.");
}

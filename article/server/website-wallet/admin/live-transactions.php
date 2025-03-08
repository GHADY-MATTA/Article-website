<?php
$conn = mysqli_connect("localhost", "root", "", "usersignupWallet");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query to fetch the latest 10 transactions
$sql = "SELECT * FROM p2p_transactions ORDER BY created_at DESC LIMIT 10";
$result = mysqli_query($conn, $sql);  // Use $conn here, not $connection

// Check if the query was successful
if (!$result) {
    echo json_encode(["error" => "Failed to retrieve transactions: " . mysqli_error($conn)]);
    exit;
}

// Fetch the results and store them in an array
$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}

// Check if we found any transactions
if (empty($transactions)) {
    echo json_encode(["message" => "No transactions found."]);
} else {
    // Return the transactions as a JSON response
    echo json_encode(["transactions" => $transactions]);
}

// Close the database connection
mysqli_close($conn);  // Use $conn here, not $connection

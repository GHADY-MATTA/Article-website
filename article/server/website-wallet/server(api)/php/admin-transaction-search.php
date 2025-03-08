<?php
require_once('../../admin/generals/connection.php');
require_once('../../admin/generals/TransactionSearchAPI.php'); // Adjusted to match the class name

if (isset($_GET['transactionKeyword'])) {
    $conn = $db->getConnection();  // Assuming $db is the object holding your connection method
    $api = new TransactionSearchAPI($conn);  // Using the class you created
    $api->searchTransactions($_GET['transactionKeyword']);  // Searching based on the keyword passed
    $conn->close();  // Closing the database connection
} else {
    echo "No search keyword provided.";  // In case no search keyword is provided
}

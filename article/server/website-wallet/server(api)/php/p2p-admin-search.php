<?php
require_once('../../admin/generals/connection.php');
require_once('../../admin/generals/P2PTransactionAPI.php');


if (isset($_GET['p2pKeyword'])) {
    $conn = $db->getConnection();
    $api = new P2PTransactionAPI($conn);
    $api->searchTransactions($_GET['p2pKeyword']);
    $conn->close();
} else {
    echo "No search keyword provided.";
}
?>
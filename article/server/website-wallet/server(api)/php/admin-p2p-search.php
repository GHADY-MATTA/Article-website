<?php
$conn = mysqli_connect("localhost", "root", "", "usersignupWallet");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
} // If no keyword is provided, fetch the latest transactions
$sql = "SELECT * FROM p2p_transactions ORDER BY created_at DESC LIMIT 10";





if (isset($_GET['p2pKeyword'])) {
    $keyword = $conn->real_escape_string($_GET['p2pKeyword']);

    $sql = "SELECT * FROM p2p_transactions 
            WHERE transaction_id LIKE '%$keyword%' 
            OR sender_user_id LIKE '%$keyword%' 
            OR receiver_user_id LIKE '%$keyword%' 
            OR sender_p2pnumber LIKE '%$keyword%' 
            OR recipient_p2pnumber LIKE '%$keyword%' 
            OR amount LIKE '%$keyword%' 
            OR status LIKE '%$keyword%' 
            OR created_at LIKE '%$keyword%' 
            OR reference_id LIKE '%$keyword%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output = "<div style='overflow-x:auto;'>";
        $output .= "<table border='1' cellpadding='5' cellspacing='0'>";
        $output .= "<tr>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>";

        while ($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>" . $row['transaction_id'] . "</td>";
            $output .= "<td>" . $row['sender_username'] . "</td>";
            $output .= "<td>" . $row['receiver_username'] . "</td>";
            $output .= "<td>" . $row['date'] . "</td>";
            $output .= "<td>" . $row['amount'] . "</td>";
            $output .= "<td>" . $row['status'] . "</td>";
            $output .= "</tr>";
        }
        $output .= "</table>";
        echo $output;
    } else {
        echo "No results found.";
    }
}

$conn->close();


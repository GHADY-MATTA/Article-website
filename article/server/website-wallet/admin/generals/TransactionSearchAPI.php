<?php
class TransactionSearchAPI
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function searchTransactions($keyword)
    {
        $keyword = $this->conn->real_escape_string($keyword);
        $sql = "SELECT * FROM transactions 
                WHERE user_id LIKE '%$keyword%' 
                OR id LIKE '%$keyword%' 
                OR transaction_type LIKE '%$keyword%' 
                OR amount LIKE '%$keyword%' 
                OR reference_id LIKE '%$keyword%' 
                OR status LIKE '%$keyword%' 
                OR created_at LIKE '%$keyword%'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $output = "<div style='overflow-x:auto;'>";
            $output .= "<table border='1' cellpadding='5' cellspacing='0'>";
            $output .= "<tr>
                            <th>Transaction ID</th>
                            <th>User ID</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Reference ID</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>";

            while ($row = $result->fetch_assoc()) {
                $output .= "<tr>";
                $output .= "<td>" . $row['id'] . "</td>";
                $output .= "<td>" . $row['user_id'] . "</td>";
                $output .= "<td>" . $row['transaction_type'] . "</td>";
                $output .= "<td>" . $row['amount'] . "</td>";
                $output .= "<td>" . $row['reference_id'] . "</td>";
                $output .= "<td>" . $row['status'] . "</td>";
                $output .= "<td>" . $row['created_at'] . "</td>";
                $output .= "</tr>";
            }

            $output .= "</table>";
            echo $output;
        } else {
            echo "No results found.";
        }
    }
}

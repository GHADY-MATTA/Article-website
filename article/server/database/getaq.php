<?php
// Include the database connection
include 'C:/Users/Matta/Desktop/XAMP/htdocs/article/server/conn/db.php';

// SQL query to join qatable with userinfo to get username and lastname along with question details
$sql = "SELECT 
            u.username, 
            u.userlastname, 
            q.userques, 
            q.useranswer, 
            q.created_at 
        FROM qatable q 
        JOIN userinfo u ON q.user_id = u.id";

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Fetch each row of data and add it to the array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Set the header to specify content type as JSON
header('Content-Type: application/json');

// Convert the data array to JSON and output it
echo json_encode($data, JSON_PRETTY_PRINT);

// Close the database connection
$conn->close();

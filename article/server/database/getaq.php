<?php
// Include the database connection
include 'C:/Users/Matta/Desktop/XAMP/htdocs/article/server/conn/db.php';

// SQL query to get the data from the qatabel
$sql = "SELECT 
            username, 
            lastname, 
            email, 
            questions, 
            answers,
            created_at
        FROM qatabel";

// Execute the query
$result = $conn->query($sql);

$data = array();

// Check if any results are returned
if ($result->num_rows > 0) {
    // Fetch each row and add it to the data array
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
?>

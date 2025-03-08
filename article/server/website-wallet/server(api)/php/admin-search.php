<?php
// Create the connection to the SQL database
$conn = mysqli_connect("localhost", "root", "", "usersignupWallet");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['keyword'])) {
    $keyword = $conn->real_escape_string($_GET['keyword']);
    // Protect against SQL injection
    $sql = "SELECT * FROM usersmail 
            WHERE username LIKE '%$keyword%' 
            OR phone LIKE '%$keyword%' 
            OR address LIKE '%$keyword%' 
            OR balance LIKE '%$keyword%' 
            OR tier LIKE '%$keyword%' 
            OR email LIKE '%$keyword%' 
            OR id LIKE '%$keyword%'";
    // Replace 'users' and 'name' with your table/column
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Wrapper div for horizontal scroll
        $output = "<div style='overflow-x:auto;'>";
        $output .= "<table border='1' cellpadding='5' cellspacing='0'>";

        // Corrected column order
        $output .= "<tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password Hash</th>
                        <th>Newsletter</th>
                        <th>Created At</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Profile Picture</th>
                        <th>Tier</th>
                        <th>Balance</th>
                        <th>tier-time-stamp</th>
                    </tr>";

        // Loop through each row and output data in the correct order
        while ($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>" . $row['id'] . "</td>";
            $output .= "<td>" . $row['username'] . "</td>";
            $output .= "<td>" . $row['email'] . "</td>";
            $output .= "<td>" . $row['password_hash'] . "</td>";
            $output .= "<td>" . $row['news_letter'] . "</td>";
            $output .= "<td>" . $row['created_at'] . "</td>";
            $output .= "<td>" . $row['phone'] . "</td>";
            $output .= "<td>" . $row['address'] . "</td>";
            $output .= "<td>" . $row['profile_picture'] . "</td>";
            $output .= "<td>" . $row['tier'] . "</td>";
            $output .= "<td>" . $row['balance'] . "</td>";
            $output .= "<td>" . $row['tier_change_time'] . "</td>";


            $output .= "</tr>";
        }
        $output .= "</table>";
        echo $output;
    } else {
        echo "No results found.";
    }
}

$conn->close();

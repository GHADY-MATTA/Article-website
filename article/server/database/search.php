<?php
include('C:\Users\Matta\Desktop\XAMP\htdocs\article\server\conn\db.php');

if (isset($_GET['keyword'])) {
    $keyword = $conn->real_escape_string($_GET['keyword']);

    // Modified SQL query to select only required columns
    $sql = "SELECT username, lastname, email, questions, answers,created_at FROM qatabel 
            WHERE username LIKE '%$keyword%' 
            OR lastname LIKE '%$keyword%' 
            OR email LIKE '%$keyword%' 
            OR questions LIKE '%$keyword%' 
            OR answers LIKE '%$keyword%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='box'  style='overflow-x:auto;'>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";

        // Table headers
        echo "<tr>
                <th>Username</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Questions</th>
                <th>Answers</th>
                <th>Date</th>
              </tr>";

        // Fetch and display data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['questions']) . "</td>";
            echo "<td>" . htmlspecialchars($row['answers']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "No results found.";
    }
}

$conn->close();

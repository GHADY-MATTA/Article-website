<?php
// Include database connection
// / Create the connection to the SQL database
$conn = mysqli_connect("localhost", "root", "", "usersignupWallet");

// Check if the user is logged in (you should have a session mechanism to validate user authentication)
session_start();

// Get the user ID (assuming it is stored in the session)
$user_id = $_SESSION['user_id']; // Replace with your actual session variable for the user's ID

// Check if the form was submitted and the tier was selected
if (isset($_POST['tier'])) {
    // Get the selected tier from the POST request
    $tier = $_POST['tier'];

    // Prepare the SQL query to update the tier for the user
    $query = "UPDATE usersMail SET tier = ?, tier_change_time = CURRENT_TIMESTAMP WHERE id = ?";


    // Use prepared statements to avoid SQL injection
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $tier, $user_id); // Bind the tier value and user ID (i = integer, s = string)
        
         // Execute the query
        if ($stmt->execute()) {
            // Tier updated successfully, now redirect to the profile page
            header("Location: /website-wallet/client/assets/front/profile.html?id=" . $user_id);
            exit;//website-wallet\client\assets\front\profile.html
        } else {
            echo "Error updating tier: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
} else {
    echo "No tier selected.";
}

// Close the database connection
$conn->close();
?>

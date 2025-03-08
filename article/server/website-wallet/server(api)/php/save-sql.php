<?php 

// Create the connection to the SQL database
$link = mysqli_connect("localhost", "root", "", "usersignupWallet");

// Check if the connection was successful
if($link->connect_errno){
    die("Failed to connect to MySQL: " . $link->connect_error);
}






// Return the connection object
return $link;

?>

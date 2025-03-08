<?php
// Clear the JWT cookie by setting it with a past expiration time
setcookie("token", "", time() - 3600, "/", "", true, true);

// Redirect to the login page (using a relative URL)
header("Location: /article/client/login.html"); // Adjust this path if needed
exit();

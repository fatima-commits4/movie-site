<?php
// Start the session to manage user login data
session_start();

// Destroy the session (this logs the user out)
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>

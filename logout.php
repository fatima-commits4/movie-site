<?php
session_start();

//destroy session
session_destroy();

//redirect to login
header("Location: login.php");
exit();
?>

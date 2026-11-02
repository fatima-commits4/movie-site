<?php
// Step 1: Connect to the database
$conn = mysqli_connect("localhost", "root", "", "movie_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 2: Get a few movies from the database
$sql = "SELECT title FROM Movies LIMIT 5"; // Fetch 5 movie titles
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Movie Database</title>
</head>
<body>
<?php

$conn = mysqli_connect("localhost", "root", "", "movie_db");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//get a few movies from the database
$sql = "SELECT title FROM Movies LIMIT 5"; //fetch 5 movie titles
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Movie Database</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
$connection = mysqli_connect("localhost", "root", "", "movie_db");

//check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

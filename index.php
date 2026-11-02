<?php
//database connection
$conn = new mysqli("localhost", "root", "", "movie_db");

//checks connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get movies from database
$sql = "SELECT title FROM Movies LIMIT 5";  //get 5 latest movies
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Movie Website</title>
</head>
<body>

<h1>Welcome to My Movie Site 🎬</h1>

<p>This is where the movies will go!</p>

<!-- Link to the full movie list -->
<p><a href="movies.php">See All Movies</a></p>

<h2>Latest Movies</h2>

<?php
//check if query was successful and if there are rows to display
if ($result && $result->num_rows > 0) {
    //loop through each movie and show the title 
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row['title'] . "</p>";
    }
} else {
    echo "<p>No movies found.</p>";
}

//closes the database connection
$conn->close();
?>

<h2>Sign Up</h2>

<?php
//handles user registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //hashes password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    //re-establishes database connection for user insertion
    $conn = new mysqli("localhost", "root", "", "movie_db");

    //inserts into users table
    $sql = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Registered!";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    //close new connection
    $conn->close();
}
?>

<!-- Registration Form -->
<form action="index.php" method="POST">
    <label>Username: <input type="text" name="username" required></label><br><br>
    <label>Email: <input type="email" name="email" required></label><br><br>
    <label>Password: <input type="password" name="password" required></label><br><br>
    <input type="submit" value="Register">
</form>

</body>
</html>


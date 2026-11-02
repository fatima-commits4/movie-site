<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "movie_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get movies from the database
$sql = "SELECT title FROM Movies LIMIT 5";  // Example: Get the latest 5 movies
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
// Check if the query was successful and if there are rows to display
if ($result && $result->num_rows > 0) {
    // Loop through each movie and show the title
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row['title'] . "</p>";
    }
} else {
    echo "<p>No movies found.</p>";
}

// Close the database connection
$conn->close();
?>

<h2>Sign Up</h2>

<?php
// Handle user registration (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password (so it's not plain text)
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Re-establish database connection for inserting user
    $conn = new mysqli("localhost", "root", "", "movie_db");

    // Insert into Users table
    $sql = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Registered!";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    // Close the new connection after registration
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


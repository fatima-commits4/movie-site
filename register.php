	<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session
session_start();

// Step 2: Check if the form is submitted and validate input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the required fields are set and not empty
    if (isset($_POST['username'], $_POST['email'], $_POST['password']) &&
        !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        // Step 3: Sanitize and validate user input to prevent SQL injection and other issues
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Step 4: Hash the password for security
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Step 5: Prepare the SQL query using prepared statements (prevents SQL injection)
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password_hashed);  // Bind parameters

        // Step 6: Execute the query
        if ($stmt->execute()) {
            echo "✅ Registered successfully!";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        // Step 7: Close the prepared statement and database connection
        $stmt->close();
    } else {
        echo "❌ Please fill out all the fields!";
    }
}

// Step 8: Close the connection
mysqli_close($conn);
?>

<!-- HTML Form for Registration -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>


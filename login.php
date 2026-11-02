<?php
session_start(); // Start session

// Database connection
$conn = new mysqli("localhost", "root", "", "movie_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simple login check
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare the SQL query to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if password matches
        if (password_verify($password, $user['password'])) {
			$user = $result->fetch_assoc(); // it includes user_id if you're selecting *
            $_SESSION['username'] = $username; // Save username in session
            $_SESSION['user_id'] = $user['user_id']; // Save user_id in session for reviews
            header("Location: welcome.php");  // Redirect to the welcome page
            exit;  // Make sure code stops here
        } else {
            echo "❌ Incorrect password!";
        }
    } else {
        echo "❌ User not found!";
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close(); // Close the database connection
?>

<!-- Simple Login Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>


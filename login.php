<?php
session_start(); //starts session

//connects to database
$conn = new mysqli("localhost", "root", "", "movie_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//login check
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

        //password verification
        if (password_verify($password, $user['password'])) {
			$user = $result->fetch_assoc(); 
            $_SESSION['username'] = $username; 
            $_SESSION['user_id'] = $user['user_id']; //user_id saved 
            header("Location: welcome.php");  //redirection to homepage
            exit; 
        } else {
            echo "❌ Incorrect password!";
        }
    } else {
        echo "❌ User not found!";
    }

    $stmt->close(); //close statament
}

$conn->close(); //closes database connection
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


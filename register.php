	<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

//creates connection
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

//validates input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //check if required fields aren't empty
    if (isset($_POST['username'], $_POST['email'], $_POST['password']) &&
        !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        //validate input
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        //password hash
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        //prepare SQL query
        $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password_hashed);  // Bind parameters

        //executes query
        if ($stmt->execute()) {
            echo "✅ Registered successfully!";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

      
        $stmt->close();
    } else {
        echo "❌ Please fill out all the fields!";
    }
}


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


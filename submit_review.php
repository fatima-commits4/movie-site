<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get user ID from session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $movie_id = $_POST['movie_id'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    // Validate movie_id
    if (!filter_var($movie_id, FILTER_VALIDATE_INT)) {
        echo "Invalid movie ID.";
        exit();
    }

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        echo "Rating must be between 1 and 5.";
        exit();
    }

    // Validate review text
    if (empty($review_text)) {
        echo "Review text cannot be empty.";
        exit();
    }

    // Insert review into the Reviews table using a prepared statement
    $stmt_review = $conn->prepare("INSERT INTO Reviews (movie_id, user_id, review_text, rating) VALUES (?, ?, ?, ?)");
    $stmt_review->bind_param("iisi", $movie_id, $user_id, $review_text, $rating);

    if ($stmt_review->execute()) {
        // Redirect back to the movie details page after the review is successfully submitted
        header("Location: movie_details.php?id=" . $movie_id);
        exit();  // Stop further execution
    } else {
        echo "Error: " . $stmt_review->error;
    }

    // Close the statement and connection
    $stmt_review->close();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Review</title>
</head>
<body>
    <h1>Submit Your Review</h1>
    
    <!-- The Form to submit a review -->
    <form action="submit_review.php" method="POST">
        <label for="movie_id">Movie ID:</label>
        <input type="text" name="movie_id" id="movie_id" required><br><br>
        
        <label for="review_text">Review:</label>
        <textarea name="review_text" id="review_text" required></textarea><br><br>

        <label for="rating">Rating (1 to 5):</label>
        <input type="number" name="rating" id="rating" min="1" max="5" required><br><br>

        <button type="submit">Submit Review</button>
    </form>

</body>
</html>

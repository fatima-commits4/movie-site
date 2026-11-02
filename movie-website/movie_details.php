<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "movie_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the movie ID from the URL
$movie_id = $_GET['id'];

// Query to get the movie details based on the movie ID
$sql = "SELECT * FROM Movies WHERE movie_id = '$movie_id'";
$result = mysqli_query($conn, $sql);

// Check if the movie exists
if (mysqli_num_rows($result) > 0) {
    // Fetch the movie details
    $movie = mysqli_fetch_assoc($result);
} else {
    echo "<p>Movie not found.</p>";
    exit;
}

// Query to get reviews for the specific movie
$sql_reviews = "SELECT Reviews.review_text, Reviews.rating, Users.username 
                FROM Reviews 
                JOIN Users ON Reviews.user_id = Users.user_id
                WHERE Reviews.movie_id = '$movie_id'";

$result_reviews = mysqli_query($conn, $sql_reviews);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $movie['title']; ?> - Details</title>
</head>
<body>

<h1><?php echo $movie['title']; ?></h1>
<p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
<p><strong>Release Year:</strong> <?php echo $movie['release_year']; ?></p>
<p><strong>Director:</strong> <?php echo $movie['director']; ?></p>
<p><strong>Cast:</strong> <?php echo $movie['cast']; ?></p>
<p><strong>Plot:</strong> <?php echo $movie['plot']; ?></p>
<img src="<?php echo $movie['poster_url']; ?>" alt="Poster">

<h2>Reviews</h2>

<?php
// Display reviews if there are any
if (mysqli_num_rows($result_reviews) > 0) {
    while ($review = mysqli_fetch_assoc($result_reviews)) {
        echo "<div>";
        echo "<p><strong>" . $review['username'] . " (Rating: " . $review['rating'] . "/5)</strong></p>";
        echo "<p>" . nl2br($review['review_text']) . "</p>";
        echo "</div><hr>";
    }
} else {
    echo "<p>No reviews yet.</p>";
}

?>

<!-- Form to submit a new review -->
<h3>Submit Your Review</h3>
<form action="submit_review.php" method="POST">
    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
    <textarea name="review_text" placeholder="Write your review here" required><?php echo isset($_POST['review_text']) ? htmlspecialchars($_POST['review_text']) : ''; ?></textarea><br>
    <label for="rating">Rating:</label>
    <input type="number" name="rating" min="1" max="5" required value="<?php echo isset($_POST['rating']) ? $_POST['rating'] : ''; ?>"><br><br>
    <button type="submit">Submit Review</button>
</form>

</body>
</html>

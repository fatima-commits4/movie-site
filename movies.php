<?php
// Step 1: Connect to the database (only once)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 2: Process AJAX request and display filtered results
if (isset($_GET['search']) || isset($_GET['year']) || isset($_GET['genre'])) {
    // Get the search term, year, and genre from the query string
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $year = isset($_GET['year']) ? $_GET['year'] : '';
    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';

    // Build the SQL query based on the filters
    $sql = "SELECT * FROM Movies WHERE 1";  // Base query
    if ($search) {
        $sql .= " AND title LIKE '%$search%'"; // Filter by title
    }
    if ($year) {
        $sql .= " AND release_year = '$year'"; // Filter by year
    }
    if ($genre) {
        $sql .= " AND genre LIKE '%$genre%'"; // Filter by genre
    }

    // Run the query and get the results
    $result = mysqli_query($conn, $sql);

    // Output only the filtered results
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='movie'>";
            echo "<a href='movie_details.php?id=" . $row['movie_id'] . "'>" . $row['title'] . "</a>";
            echo "<p><strong>Genre:</strong> " . $row['genre'] . "</p>";
            echo "<p><strong>Director:</strong> " . $row['director'] . "</p>";
            echo "<p><strong>Cast:</strong> " . $row['cast'] . "</p>";
            echo "<p><strong>Plot:</strong> " . $row['plot'] . "</p>";
            echo "<img src='" . $row['poster_url'] . "' alt='Poster'>";
            echo "</div>";
        }
    } else {
        echo "<p>No movies found.</p>";  // If no results
    }

    // Close the connection
    mysqli_close($conn);
    exit;  // Stop further processing, we only need the filtered results
}

// Step 3: Fetch all movies if no filters are applied
$sql = "SELECT * FROM Movies"; // Get all movies by default
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <!-- jQuery for AJAX -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .movie {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }
        img {
            width: 150px; /* Set poster image size */
        }
    </style>
</head>
<body>

<h1>Movies</h1>

<!-- Search Bar Form (using AJAX for dynamic filtering) -->
<form id="search-form">
    <input type="text" id="search" name="search" placeholder="Search for movies..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <input type="text" id="year" name="year" placeholder="Year" value="<?php echo isset($_GET['year']) ? $_GET['year'] : ''; ?>">
    <input type="text" id="genre" name="genre" placeholder="Genre" value="<?php echo isset($_GET['genre']) ? $_GET['genre'] : ''; ?>">
    <button type="submit">Search</button>
</form>

<hr>

<!-- This is where the filtered results will be displayed -->
<div id="movie-results">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='movie'>";
            echo "<a href='movie_details.php?id=" . $row['movie_id'] . "'>" . $row['title'] . "</a>";
            echo "<p><strong>Genre:</strong> " . $row['genre'] . "</p>";
            echo "<p><strong>Director:</strong> " . $row['director'] . "</p>";
            echo "<p><strong>Cast:</strong> " . $row['cast'] . "</p>";
            echo "<p><strong>Plot:</strong> " . $row['plot'] . "</p>";
            echo "<img src='" . $row['poster_url'] . "' alt='Poster'>";
            echo "</div>";
        }
    } else {
        echo "<p>No movies found.</p>";  // If no results
    }
    ?>
</div>

<script>
    $(document).ready(function() {
        // When the form is submitted
        $('#search-form').on('submit', function(event) {
            event.preventDefault();  // Prevent normal form submission
            
            var search = $('#search').val();
            var year = $('#year').val();
            var genre = $('#genre').val();
            
            // Make the AJAX request
            $.ajax({
                url: 'movies.php',  // Same PHP file to process search and filter
                method: 'GET',
                data: { search: search, year: year, genre: genre },  // Send the filters
                success: function(response) {
                    // Update the movie-results div with the response from the PHP file
                    $('#movie-results').html(response);
                }
            });
        });

        // Optional: Trigger search when input is changed (for real-time filtering)
        $('#search, #year, #genre').on('input', function() {
            $('#search-form').submit();  // Submit form when any input is changed
        });
    });
</script>

</body>
</html>

<?php
// Step 4: Close the connection to the database
mysqli_close($conn);
?>




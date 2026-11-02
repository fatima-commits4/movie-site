<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//process ajax request
if (isset($_GET['search']) || isset($_GET['year']) || isset($_GET['genre'])) {
    //search title, year and genre
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $year = isset($_GET['year']) ? $_GET['year'] : '';
    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';

    // Build the SQL query based on the filters
    $sql = "SELECT * FROM Movies WHERE 1"; 
    if ($search) {
        $sql .= " AND title LIKE '%$search%'"; //filter by title
    }
    if ($year) {
        $sql .= " AND release_year = '$year'"; //filter by year
    }
    if ($genre) {
        $sql .= " AND genre LIKE '%$genre%'"; //filter by genre
    }

    //run query & get results
    $result = mysqli_query($conn, $sql);

    //output filtered results
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

    
    mysqli_close($conn);
    exit; 
}

//get all movies if no filters are applied
$sql = "SELECT * FROM Movies"; //get all movies
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
        echo "<p>No movies found.</p>";  //if no results
    }
    ?>
</div>

<script>
    $(document).ready(function() {
        //form is submitted
        $('#search-form').on('submit', function(event) {
            event.preventDefault();  //prevent normal form submission
            
            var search = $('#search').val();
            var year = $('#year').val();
            var genre = $('#genre').val();
            
            //ajax request
            $.ajax({
                url: 'movies.php',  //same php file to search and filter 
                method: 'GET',
                data: { search: search, year: year, genre: genre },  //send filters
                success: function(response) {
                    //update the movie results with response from the php files
                    $('#movie-results').html(response);
                }
            });
        });

        //trigger search when input is added
        $('#search, #year, #genre').on('input', function() {
            $('#search-form').submit();  //submit form when input is changed
        });
    });
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>




-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 02:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'NOT NULL',
  `genre` varchar(100) NOT NULL,
  `release_year` year(4) NOT NULL,
  `director` varchar(100) NOT NULL,
  `cast` text NOT NULL,
  `plot` text NOT NULL,
  `poster_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `genre`, `release_year`, `director`, `cast`, `plot`, `poster_url`) VALUES
(1, 'Spider-Man: Into the Spider-Verse', 'Animation, Action, Adventure', '2018', 'Bob Persichetti, Peter Ramsey, Rodney Rothman', 'Shameik Moore, Jake Johnson, Hailee Steinfeld, Mahershala Ali, Nicolas Cage', 'Miles Morales becomes the Spider-Man of his reality and crosses paths with five spider-powered individuals from other dimensions to stop threats for all realities.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/iiZZdoQBEYBv6id8su7ImL0oCbD.jpg\r\n'),
(2, 'Spider-Man: Across the Spider-Verse', 'Animation, Action, Adventure', '2023', 'Joaquim Dos Santos, Kemp Powers, Justin K. Thompson', 'Shameik Moore, Hailee Steinfeld, Oscar Isaac, Jake Johnson, Issa Rae, Daniel Kaluuya', 'Miles Morales catapults across the Multiverse, where he encounters a team of Spider-People charged with protecting its very existence.', 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8Vt6mWEReuy4Of61Lnj5Xj704m8.jpg'),
(3, 'Inception', 'Sci-Fi, Thriller', '2010', 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page, Tom Hardy', 'A thief who enters the dreams of others to steal secrets from their subconscious.', 'https://image.tmdb.org/t/p/original/ljsZTbVsrQSqZgWeep2B1QiDKuh.jpg'),
(4, 'Interstellar', 'Sci-Fi, Drama', '2014', 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.', 'https://image.tmdb.org/t/p/original/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg'),
(5, 'The Matrix', 'Sci-Fi, Action', '1999', 'The Wachowskis', 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss, Hugo Weaving', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 'https://c7.alamy.com/comp/2K4TMJ5/the-matrix-1999-the-matrix-movie-poster-keanu-reeves-2K4TMJ5.jpg'),
(6, 'The Batman ', 'Action, Crime, Drama', '2022', 'Matt Reeves', 'Robert Pattinson, Zoë Kravitz, Paul Dano, Colin Farrell', 'Batman ventures into Gotham City\'s underworld when a sadistic killer leaves behind a trail of cryptic clues.', 'https://cdn.europosters.eu/image/1300/the-batman-2022-i133033.jpg'),
(7, 'Barbie', 'Comedy, Fantasy', '2023', 'Greta Gerwig', 'Margot Robbie, Ryan Gosling, America Ferrera, Issa Rae', 'Barbie suffers a crisis that leads her to question her world and her existence.\r\n\r\n', 'https://image.tmdb.org/t/p/original/iuFNMS8U5cb6xfzi51Dbkovj7vM.jpg'),
(8, 'Oppenheimer', 'Drama, History', '2023', 'Christopher Nolan', 'Cillian Murphy, Emily Blunt, Matt Damon, Robert Downey Jr.', 'The life of J. Robert Oppenheimer, the physicist who helped develop the atomic bomb.', 'https://image.tmdb.org/t/p/original/8Gxv8gSFCU0XGDykEGv7zR1n2ua.jpg'),
(9, 'Shrek', 'Animation, Adventure, Comedy', '2001', 'Andrew Adamson, Vicky Jenson', 'Mike Myers, Eddie Murphy, Cameron Diaz, John Lithgow', 'An ogre\'s peaceful life is disrupted when numerous fairy tale characters are exiled to his swamp.', 'https://image.tmdb.org/t/p/original/iB64vpL3dIObOtMZgX3RqdVdQDc.jpg'),
(10, 'Black Panther', 'Action, Adventure, Sci-Fi', '2018', 'Ryan Coogler', 'Chadwick Boseman, Michael B. Jordan, Lupita Nyong\'o, Danai Gurira', 'T\'Challa, the king of Wakanda, is challenged by a vengeful outsider who was a childhood victim of his father\'s mistake.', 'https://image.tmdb.org/t/p/original/VtMkk2s92SnDUt8eYyUyYaSJQK.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_movie_id` (`movie_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

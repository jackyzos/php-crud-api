-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2019 at 09:12 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviesdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `ActorID` int(11) NOT NULL,
  `ActorFirstName` varchar(45) NOT NULL,
  `ActorLastName` varchar(45) NOT NULL,
  `ActorBirthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`ActorID`, `ActorFirstName`, `ActorLastName`, `ActorBirthday`) VALUES
(1, 'Nilson', 'Brad', '1970-05-15'),
(5, 'Brad', 'Pitt', '1970-05-07'),
(6, 'Russel', 'Crow', '1973-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `DirectorID` int(11) NOT NULL,
  `DirectorFirstName` varchar(45) NOT NULL,
  `DirectorLastName` varchar(45) NOT NULL,
  `DirectorBirthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`DirectorID`, `DirectorFirstName`, `DirectorLastName`, `DirectorBirthday`) VALUES
(3, 'Paulo', 'Esta', '1940-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `GenreID` int(11) NOT NULL,
  `GenreName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`GenreID`, `GenreName`) VALUES
(1, 'Action2'),
(3, 'Advanture'),
(8, 'Romantic');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `MovieID` int(11) NOT NULL,
  `DirectorID` int(11) DEFAULT NULL,
  `MovieTitle` varchar(255) DEFAULT NULL,
  `MovieYear` date DEFAULT NULL,
  `MoviePlot` varchar(1000) DEFAULT NULL,
  `MovieLength` int(11) DEFAULT NULL,
  `MovieImg` varchar(255) DEFAULT NULL,
  `MovieTrailer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviesactors`
--

CREATE TABLE `moviesactors` (
  `MoviesActorsID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `ActorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moviesgenre`
--

CREATE TABLE `moviesgenre` (
  `MoviesGenreID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `GenreID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'jak', '$2y$10$KuMiyZsx1/qQAFPcwNB6weXkZ9bWbpRNXOvh9zM6IziL8JWm./.4i'),
(4, 'admin', '$2y$10$Z7frTN3rbsGcpAeRPA0l0.7ZyM8HjTNnPXThnkKdxHC4rw/AsMm/i');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`ActorID`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`DirectorID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`GenreID`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`MovieID`),
  ADD KEY `DirectorID` (`DirectorID`);

--
-- Indexes for table `moviesactors`
--
ALTER TABLE `moviesactors`
  ADD PRIMARY KEY (`MoviesActorsID`),
  ADD KEY `ActorID` (`ActorID`),
  ADD KEY `MovieID` (`MovieID`) USING BTREE;

--
-- Indexes for table `moviesgenre`
--
ALTER TABLE `moviesgenre`
  ADD PRIMARY KEY (`MoviesGenreID`) USING BTREE,
  ADD KEY `MovieID` (`MovieID`) USING BTREE,
  ADD KEY `GenreID` (`GenreID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `ActorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `DirectorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `GenreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `moviesactors`
--
ALTER TABLE `moviesactors`
  MODIFY `MoviesActorsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `moviesgenre`
--
ALTER TABLE `moviesgenre`
  MODIFY `MoviesGenreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`DirectorID`) REFERENCES `directors` (`DirectorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moviesactors`
--
ALTER TABLE `moviesactors`
  ADD CONSTRAINT `moviesactors_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MovieID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moviesactors_ibfk_2` FOREIGN KEY (`ActorID`) REFERENCES `actors` (`ActorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moviesgenre`
--
ALTER TABLE `moviesgenre`
  ADD CONSTRAINT `moviesgenre_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `movies` (`MovieID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moviesgenre_ibfk_3` FOREIGN KEY (`GenreID`) REFERENCES `genre` (`GenreID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

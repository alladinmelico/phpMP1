-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2019 at 05:50 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mp1`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`` PROCEDURE `getAllFilms` (IN `dtmBegin` TEXT, IN `dtmEnd` TEXT, IN `strSearch` TEXT)  BEGIN
SELECT act.lngActorID,act.strActorFullName,film.lngFilmTitleID,film.strFilmTitle,film.memFilmStory,film.picture,
film.dtmFilmReleaseDate,film.intFilmDuration,
GROUP_CONCAT(DISTINCT prod.strProducerName) as producers
FROM tblactors act
INNER JOIN tblfilmsactorroles fac ON fac.lngActorID = act.lngActorID
INNER JOIN tblfilmtitles film ON film.lngFilmTitleID = fac.lngFilmTitleID
INNER JOIN tblfilmtitlesproducers ftp ON ftp.lngFilmTitleID = film.lngFilmTitleID
INNER JOIN tblproducers prod ON prod.lngProducerID = ftp.lngProducerID
INNER JOIN tblfilmgenres genre ON genre.lngGenreID = film.lngGenreID
GROUP BY film.lngFilmTitleID HAVING DATE_FORMAT(film.dtmFilmReleaseDate, "%Y-%m-%d") BETWEEN dtmBegin AND dtmEnd;
END$$

CREATE DEFINER=`` PROCEDURE `selectActor` (IN `lngActorID` INT)  NO SQL
SELECT act.lngActorID,act.strActorFullName,act.memActorNotes,act.picture,
fac.strCharacterName,fac.memCharaterDescription,fac.lngActorID,
role.strRoleType,film.lngFilmTitleID,film.strFilmTitle,prod.strProducerName
FROM tblactors act
INNER JOIN tblfilmsactorroles fac ON fac.lngActorID = act.lngActorID
INNER JOIN tblroletypes role ON role.lngRoleTypeID = fac.lngRoleTypeID
INNER JOIN tblfilmtitles film ON film.lngFilmTitleID = fac.lngFilmTitleID
INNER JOIN tblfilmtitlesproducers ftp ON ftp.lngFilmTitleID = film.lngFilmTitleID
INNER JOIN tblproducers prod ON prod.lngProducerID = ftp.lngProducerID
WHERE act.lngActorID = lngActorID$$

CREATE DEFINER=`` PROCEDURE `selectFilm` (IN `lngFilmTitleID` INT)  NO SQL
SELECT act.lngActorID,act.strActorFullName,act.picture AS actPic,
fac.strCharacterName,fac.memCharaterDescription,
film.lngFilmTitleID,film.strFilmTitle,
film.memFilmStory,film.picture,
film.dtmFilmReleaseDate,film.intFilmDuration,cert.strCertificate
FROM tblactors act
INNER JOIN tblfilmsactorroles fac ON fac.lngActorID = act.lngActorID
INNER JOIN tblfilmtitles film ON film.lngFilmTitleID = fac.lngFilmTitleID
INNER JOIN tblfilmcertificates cert ON cert.lngCertificateID = film.lngCertificateID
INNER JOIN tblfilmgenres genre ON genre.lngGenreID = film.lngGenreID
WHERE film.lngFilmTitleID = lngFilmTitleID$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblactors`
--

CREATE TABLE `tblactors` (
  `lngActorID` int(11) NOT NULL,
  `strActorFullName` varchar(45) DEFAULT NULL,
  `memActorNotes` mediumtext DEFAULT NULL,
  `picture` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblactors`
--

INSERT INTO `tblactors` (`lngActorID`, `strActorFullName`, `memActorNotes`, `picture`) VALUES
(1, 'Santa Claus', 'white beard santa', 'Avatars Set Flat Style-15.png'),
(2, 'Arabian', 'just a saudi arabian', 'Avatars Set Flat Style-09.png'),
(6, 'Ryan Gosling', 'City of stars<3', 'Avatars Set Flat Style-17.png'),
(7, 'Black Ninja', 'last night ninja', 'Avatars Set Flat Style-33.png'),
(8, 'Santa Claus', 'friendly clown', 'Avatars Set Flat Style-47.png'),
(9, 'Baby boy', 'cute boii with a single hair', 'Avatars Set Flat Style-39.png'),
(10, 'King', 'bearded king', 'Avatars Set Flat Style-50.png'),
(11, 'boii', 'blue side placed cup', 'Avatars Set Flat Style-21.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmcertificates`
--

CREATE TABLE `tblfilmcertificates` (
  `lngCertificateID` int(11) NOT NULL,
  `strCertificate` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmcertificates`
--

INSERT INTO `tblfilmcertificates` (`lngCertificateID`, `strCertificate`) VALUES
(1, 'Parental Guidance (PG)'),
(2, 'Rated 16'),
(3, 'Universal (U)'),
(4, '12A'),
(5, '15');

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmgenres`
--

CREATE TABLE `tblfilmgenres` (
  `lngGenreID` int(11) NOT NULL,
  `strGenre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmgenres`
--

INSERT INTO `tblfilmgenres` (`lngGenreID`, `strGenre`) VALUES
(1, 'Thriller'),
(2, 'Action'),
(3, 'Drama'),
(4, 'Romance'),
(5, 'Horror');

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmsactorroles`
--

CREATE TABLE `tblfilmsactorroles` (
  `strCharacterName` varchar(45) NOT NULL,
  `memCharaterDescription` mediumtext DEFAULT NULL,
  `lngActorID` int(11) NOT NULL,
  `lngRoleTypeID` int(11) NOT NULL,
  `lngFilmTitleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitles`
--

CREATE TABLE `tblfilmtitles` (
  `lngFilmTitleID` int(11) NOT NULL,
  `strFilmTitle` varchar(45) DEFAULT NULL,
  `memFilmStory` mediumtext DEFAULT NULL,
  `dtmFilmReleaseDate` date DEFAULT NULL,
  `intFilmDuration` int(11) DEFAULT NULL,
  `memFilmAdditionalInfo` mediumtext DEFAULT NULL,
  `lngGenreID` int(11) NOT NULL,
  `lngCertificateID` int(11) NOT NULL,
  `picture` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmtitles`
--

INSERT INTO `tblfilmtitles` (`lngFilmTitleID`, `strFilmTitle`, `memFilmStory`, `dtmFilmReleaseDate`, `intFilmDuration`, `memFilmAdditionalInfo`, `lngGenreID`, `lngCertificateID`, `picture`) VALUES
(1, 'John Wick', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-08', 120, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 2, 5, '91wc7yc2R8L._SL1500_.jpg'),
(2, 'SpiderMan', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-16', 139, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 2, 4, 'Official_FFH_US_Poster.jpg'),
(3, 'Lalaland', 'fdsasdfafdfds', '2019-10-01', 122, 'fdsasdfafdfds', 2, 1, 'spiderman.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitlesproducers`
--

CREATE TABLE `tblfilmtitlesproducers` (
  `lngFilmTitleID` int(11) NOT NULL,
  `lngProducerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblproducers`
--

CREATE TABLE `tblproducers` (
  `lngProducerID` int(11) NOT NULL,
  `strProducerName` varchar(45) DEFAULT NULL,
  `hypContactEmailAddress` varchar(45) DEFAULT NULL,
  `hypWebsite` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblroletypes`
--

CREATE TABLE `tblroletypes` (
  `lngRoleTypeID` int(11) NOT NULL,
  `strRoleType` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `username` varchar(16) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblactors`
--
ALTER TABLE `tblactors`
  ADD PRIMARY KEY (`lngActorID`);

--
-- Indexes for table `tblfilmcertificates`
--
ALTER TABLE `tblfilmcertificates`
  ADD PRIMARY KEY (`lngCertificateID`);

--
-- Indexes for table `tblfilmgenres`
--
ALTER TABLE `tblfilmgenres`
  ADD PRIMARY KEY (`lngGenreID`);

--
-- Indexes for table `tblfilmsactorroles`
--
ALTER TABLE `tblfilmsactorroles`
  ADD PRIMARY KEY (`lngActorID`,`lngRoleTypeID`,`lngFilmTitleID`),
  ADD KEY `fk_tblFilmsActorRoles_tblRoleTypes1_idx` (`lngRoleTypeID`),
  ADD KEY `fk_tblFilmsActorRoles_tblFilmTitles1_idx` (`lngFilmTitleID`);

--
-- Indexes for table `tblfilmtitles`
--
ALTER TABLE `tblfilmtitles`
  ADD PRIMARY KEY (`lngFilmTitleID`,`lngGenreID`,`lngCertificateID`),
  ADD KEY `fk_tblFilmTitles_tblFilmGenres1_idx` (`lngGenreID`),
  ADD KEY `fk_tblFilmTitles_tblFilmCertificates1_idx` (`lngCertificateID`);

--
-- Indexes for table `tblfilmtitlesproducers`
--
ALTER TABLE `tblfilmtitlesproducers`
  ADD PRIMARY KEY (`lngFilmTitleID`,`lngProducerID`),
  ADD KEY `fk_tblFilmTitlesProducers_tblFilmTitles1_idx` (`lngFilmTitleID`),
  ADD KEY `fk_tblFilmTitlesProducers_tblProducers1_idx` (`lngProducerID`);

--
-- Indexes for table `tblproducers`
--
ALTER TABLE `tblproducers`
  ADD PRIMARY KEY (`lngProducerID`);

--
-- Indexes for table `tblroletypes`
--
ALTER TABLE `tblroletypes`
  ADD PRIMARY KEY (`lngRoleTypeID`),
  ADD UNIQUE KEY `lngRoleTypeID_UNIQUE` (`lngRoleTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblactors`
--
ALTER TABLE `tblactors`
  MODIFY `lngActorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblfilmcertificates`
--
ALTER TABLE `tblfilmcertificates`
  MODIFY `lngCertificateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblfilmgenres`
--
ALTER TABLE `tblfilmgenres`
  MODIFY `lngGenreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblfilmtitles`
--
ALTER TABLE `tblfilmtitles`
  MODIFY `lngFilmTitleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblproducers`
--
ALTER TABLE `tblproducers`
  MODIFY `lngProducerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblroletypes`
--
ALTER TABLE `tblroletypes`
  MODIFY `lngRoleTypeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblfilmsactorroles`
--
ALTER TABLE `tblfilmsactorroles`
  ADD CONSTRAINT `fk_tblFilmsActorRoles_tblActors1` FOREIGN KEY (`lngActorID`) REFERENCES `tblactors` (`lngActorID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tblFilmsActorRoles_tblFilmTitles1` FOREIGN KEY (`lngFilmTitleID`) REFERENCES `tblfilmtitles` (`lngFilmTitleID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tblFilmsActorRoles_tblRoleTypes1` FOREIGN KEY (`lngRoleTypeID`) REFERENCES `tblroletypes` (`lngRoleTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblfilmtitles`
--
ALTER TABLE `tblfilmtitles`
  ADD CONSTRAINT `fk_tblFilmTitles_tblFilmCertificates1` FOREIGN KEY (`lngCertificateID`) REFERENCES `tblfilmcertificates` (`lngCertificateID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblFilmTitles_tblFilmGenres1` FOREIGN KEY (`lngGenreID`) REFERENCES `tblfilmgenres` (`lngGenreID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblfilmtitlesproducers`
--
ALTER TABLE `tblfilmtitlesproducers`
  ADD CONSTRAINT `fk_tblFilmTitlesProducers_tblFilmTitles1` FOREIGN KEY (`lngFilmTitleID`) REFERENCES `tblfilmtitles` (`lngFilmTitleID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tblFilmTitlesProducers_tblProducers1` FOREIGN KEY (`lngProducerID`) REFERENCES `tblproducers` (`lngProducerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

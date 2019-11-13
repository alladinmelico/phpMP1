-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2019 at 01:06 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllFilms` (IN `dtmBegin` TEXT, IN `dtmEnd` TEXT, IN `strSearch` TEXT)  NO SQL
BEGIN
SELECT act.lngActorID,GROUP_CONCAT(DISTINCT act.strActorFullName) AS actors,film.lngFilmTitleID,film.strFilmTitle,film.memFilmStory,film.picture,film.dtmFilmReleaseDate,film.intFilmDuration,
GROUP_CONCAT(DISTINCT prod.strProducerName) as producers,GROUP_CONCAT(DISTINCT genre.strGenre) as genre
FROM tblactors act
INNER JOIN tblfilmsactorroles fac ON fac.lngActorID = act.lngActorID
INNER JOIN tblfilmtitles film ON film.lngFilmTitleID = fac.lngFilmTitleID
INNER JOIN tblfilmtitlesproducers ftp ON ftp.lngFilmTitleID = film.lngFilmTitleID
INNER JOIN tblproducers prod ON prod.lngProducerID = ftp.lngProducerID
INNER JOIN tblfilmgenres genre ON genre.lngGenreID = film.lngGenreID
GROUP BY film.lngFilmTitleID HAVING (DATE_FORMAT(film.dtmFilmReleaseDate, "%Y-%m-%d") BETWEEN dtmBegin AND dtmEnd) AND film.strFilmTitle LIKE CONCAT('%',strSearch,'%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFilmCertGenre` (IN `lngFilmTitleID` INT)  NO SQL
SELECT * FROM tblfilmtitles film
INNER JOIN tblfilmgenres genre ON film.lngFilmTitleID = genre.lngGenreID
INNER JOIN tblfilmcertificates cert on cert.lngCertificateID = film.lngGenreID
WHERE film.lngFilmTitleID = lngFilmTitleID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectActor` (IN `lngActorID` INT)  NO SQL
SELECT act.lngActorID,act.strActorFullName,act.memActorNotes,act.picture,
fac.strCharacterName,fac.memCharaterDescription,fac.lngActorID,
role.strRoleType,film.lngFilmTitleID,film.strFilmTitle,prod.strProducerName,film.picture as filmPicture
FROM tblactors act
INNER JOIN tblfilmsactorroles fac ON fac.lngActorID = act.lngActorID
INNER JOIN tblroletypes role ON role.lngRoleTypeID = fac.lngRoleTypeID
INNER JOIN tblfilmtitles film ON film.lngFilmTitleID = fac.lngFilmTitleID
INNER JOIN tblfilmtitlesproducers ftp ON ftp.lngFilmTitleID = film.lngFilmTitleID
INNER JOIN tblproducers prod ON prod.lngProducerID = ftp.lngProducerID

GROUP BY act.lngActorID,film.lngFilmTitleID
HAVING act.lngActorID = lngActorID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectFilm` (IN `lngFilmTitleID` INT)  NO SQL
SELECT act.lngActorID,act.strActorFullName,act.picture AS actPic,
fac.strCharacterName,fac.memCharaterDescription,
film.lngFilmTitleID,film.strFilmTitle,
film.memFilmStory,film.picture,
film.dtmFilmReleaseDate,film.intFilmDuration,cert.strCertificate,genre.strGenre
FROM tblactors act
INNER JOIN tblfilmsactorroles fac ON fac.lngActorID = act.lngActorID
INNER JOIN tblfilmtitles film ON film.lngFilmTitleID = fac.lngFilmTitleID
INNER JOIN tblfilmcertificates cert ON cert.lngCertificateID = film.lngCertificateID
INNER JOIN tblfilmgenres genre ON genre.lngGenreID = film.lngGenreID
WHERE film.lngFilmTitleID = lngFilmTitleID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectFilmProducers` (IN `lngFilmTitleID` INT)  NO SQL
SELECT * FROM tblfilmtitles film
INNER JOIN tblfilmtitlesproducers ftp ON ftp.lngFilmTitleID = film.lngFilmTitleID
INNER JOIN tblproducers prod ON prod.lngProducerID = ftp.lngProducerID
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
(7, 'Black Ninja', 'last night ninja', 'Avatars Set Flat Style-33.png'),
(8, 'Clown', 'friendly clown', 'Avatars Set Flat Style-47.png'),
(9, 'Baby boy', 'cute boii with a single hair', 'Avatars Set Flat Style-39.png'),
(10, 'King', 'bearded king', 'Avatars Set Flat Style-50.png');

--
-- Triggers `tblactors`
--
DELIMITER $$
CREATE TRIGGER `before_tblActors_delete` BEFORE DELETE ON `tblactors` FOR EACH ROW BEGIN

INSERT INTO tblactorsaudit (auditUser,auditAction,lngActorID,strActorFullName,memActorNotes,picture)
VALUES (CURRENT_USER(),'delete',OLD.lngActorID,OLD.strActorFullName,OLD.memActorNotes,OLD.picture);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_tblActors_update` BEFORE UPDATE ON `tblactors` FOR EACH ROW BEGIN

INSERT INTO tblactorsaudit (auditUser,auditAction,lngActorID,strActorFullName,memActorNotes,picture)
VALUES (CURRENT_USER(),'update',OLD.lngActorID,OLD.strActorFullName,OLD.memActorNotes,OLD.picture);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblactorsaudit`
--

CREATE TABLE `tblactorsaudit` (
  `auditUser` text NOT NULL,
  `auditAction` enum('update','delete') NOT NULL,
  `lngActorID` int(11) NOT NULL,
  `strActorFullName` text NOT NULL,
  `memActorNotes` text NOT NULL,
  `picture` text NOT NULL,
  `dtmTimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblactorsaudit`
--

INSERT INTO `tblactorsaudit` (`auditUser`, `auditAction`, `lngActorID`, `strActorFullName`, `memActorNotes`, `picture`, `dtmTimeStamp`) VALUES
('@', 'delete', 11, 'boii', 'blue side placed cup', 'Avatars Set Flat Style-21.png', '2019-10-29 00:02:10'),
('@', 'delete', 6, 'Ryan Gosling', 'City of stars<3', 'Avatars Set Flat Style-17.png', '2019-10-30 07:33:32');

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
(5, 'Horror'),
(6, 'War'),
(7, 'ajsas');

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

--
-- Dumping data for table `tblfilmsactorroles`
--

INSERT INTO `tblfilmsactorroles` (`strCharacterName`, `memCharaterDescription`, `lngActorID`, `lngRoleTypeID`, `lngFilmTitleID`) VALUES
('fdafdafdafd', 'fdsafdsasa', 2, 2, 1),
('bearded arabian', 'fdafdadfl;adff;doiewgonads;ofwefasdf', 2, 2, 2),
('assasin', 'fdsaofognwoefondsoaweoawiefnoisdfasjdofnasdofaidsfanfdosa', 7, 3, 1),
('ninja of matrix', 'dfoisnfdoahifandosa;dfa\'; fdsafda', 7, 3, 4),
('eating clown', 'fdafdafdadsfadsa', 8, 5, 1),
('foooo', 'fdsafdafdfewvaecadsfafdsafdsa', 10, 5, 2);

--
-- Triggers `tblfilmsactorroles`
--
DELIMITER $$
CREATE TRIGGER `before_tblFilmsActorRoles_delete` BEFORE DELETE ON `tblfilmsactorroles` FOR EACH ROW BEGIN 

INSERT INTO tblfilmsactorrolesaudit 
(auditUser,auditAction,strCharacterName,memCharaterDescription,lngActorID,lngRoleTypeID,lngFilmTitleID) 
VALUES (CURRENT_USER(),'delete',OLD.strCharacterName,
        OLD.memCharaterDescription,OLD.lngActorID,OLD.lngRoleTypeID,OLD.lngFilmTitleID); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_tblFilmsActorRoles_update` BEFORE UPDATE ON `tblfilmsactorroles` FOR EACH ROW BEGIN

INSERT INTO tblfilmsactorrolesaudit
(auditUser,auditAction,strCharacterName,memCharaterDescription,lngActorID,lngRoleTypeID,lngFilmTitleID)
VALUES
(CURRENT_USER(),'update',OLD.strCharacterName,
 OLD.memCharaterDescription,OLD.lngActorID,OLD.lngRoleTypeID,OLD.lngFilmTitleID);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmsactorrolesaudit`
--

CREATE TABLE `tblfilmsactorrolesaudit` (
  `auditUser` text DEFAULT NULL,
  `auditAction` enum('update','delete') DEFAULT NULL,
  `strCharacterName` text DEFAULT NULL,
  `memCharaterDescription` text DEFAULT NULL,
  `lngActorID` int(11) DEFAULT NULL,
  `lngRoleTypeID` int(11) DEFAULT NULL,
  `lngFilmTitleID` int(11) DEFAULT NULL,
  `dtmTimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmsactorrolesaudit`
--

INSERT INTO `tblfilmsactorrolesaudit` (`auditUser`, `auditAction`, `strCharacterName`, `memCharaterDescription`, `lngActorID`, `lngRoleTypeID`, `lngFilmTitleID`, `dtmTimeStamp`) VALUES
('@', 'update', 'eating clown', 'Quisque facilisis sollicitudin neque et imperdiet. Mauris efficitur nunc ut est vulputate, malesuada hendrerit felis sagittis. Mauris ac accumsan tortor. Etiam lobortis vitae magna ac varius. Nam metus ante, bibendum id condimentum sed, tempor non ipsum. Sed rhoncus at felis vitae vestibulum. Suspendisse in diam condimentum,', 8, 3, 2, '2019-10-28 16:00:00'),
('@', 'delete', 'king of matrix', 'dfsahofdoenfowafindsfoahewondfa', 10, 3, 4, '2019-10-30 03:12:29'),
('@', 'delete', 'cute eating clown', 'Quisque facilisis sollicitudin neque et imperdiet. Mauris efficitur nunc ut est vulputate, malesuada hendrerit felis sagittis. Mauris ac accumsan tortor. Etiam lobortis vitae magna ac varius. Nam metus ante, bibendum id condimentum sed, tempor non ipsum. Sed rhoncus at felis vitae vestibulum. Suspendisse in diam condimentum,', 8, 3, 2, '2019-10-30 03:19:24'),
('@', 'update', 'evil king', 'dfisaonfdoanfdsojasfdjaoifdsoanfda;dsa;fdsaoi\r\n', 10, 5, 3, '2019-10-30 03:37:24'),
('@', 'delete', 'foooo', 'fdsfzfdadsevsaewavtsfewf', 10, 6, 4, '2019-10-30 07:33:00'),
('@', 'delete', 'evil king', 'dfisaonfdoanfdsojasfdjaoifdsoanfda;dsa;fdsaoi\r\n', 10, 6, 3, '2019-10-30 07:33:52');

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
(2, 'SpiderMan', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-16', 139, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 4, 4, 'Official_FFH_US_Poster.jpg'),
(4, 'Matrix', 'fds;aifdoansfdoafi', '2019-10-31', 140, 'fds;aifdoansfdoafi', 1, 2, 'download.jpg');

--
-- Triggers `tblfilmtitles`
--
DELIMITER $$
CREATE TRIGGER `before_tblFilmTitle_delete` BEFORE DELETE ON `tblfilmtitles` FOR EACH ROW BEGIN

INSERT INTO tblfilmtitlesaudit 
(auditUser,auditAction,lngFilmTitleID,strFilmTitle,memFilmStory,
dtmFilmReleaseDate,intFilmDuration,memFilmAdditionalInfo,lngGenreID,
lngCertificateID,picture)
VALUES (CURRENT_USER(),'delete',OLD.lngFilmTitleID,OLD.strFilmTitle,OLD.memfilmStory,
       OLD.dtmFilmReleaseDate,OLD.intFilmDuration,OLD.memFilmAdditionalInfo,OLD.lngGenreID,
       OLD.lngCertificateID,OLD.picture);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_tblFilmTitle_update` BEFORE UPDATE ON `tblfilmtitles` FOR EACH ROW BEGIN

INSERT INTO tblfilmtitlesaudit 
(auditUser,auditAction,lngFilmTitleID,strFilmTitle,memFilmStory,
dtmFilmReleaseDate,intFilmDuration,memFilmAdditionalInfo,lngGenreID,
lngCertificateID,picture)
VALUES (CURRENT_USER(),'update',OLD.lngFilmTitleID,OLD.strFilmTitle,OLD.memfilmStory,
       OLD.dtmFilmReleaseDate,OLD.intFilmDuration,OLD.memFilmAdditionalInfo,OLD.lngGenreID,
       OLD.lngCertificateID,OLD.picture);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitlesaudit`
--

CREATE TABLE `tblfilmtitlesaudit` (
  `auditUser` text NOT NULL,
  `auditAction` enum('update','delete') NOT NULL,
  `lngFilmTitleID` int(11) NOT NULL,
  `strFilmTitle` text NOT NULL,
  `memFilmStory` text NOT NULL,
  `dtmFilmReleaseDate` date NOT NULL,
  `intFilmDuration` int(11) NOT NULL,
  `memFilmAdditionalInfo` text NOT NULL,
  `lngGenreID` int(11) NOT NULL,
  `lngCertificateID` int(11) NOT NULL,
  `picture` text NOT NULL,
  `dtmTimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmtitlesaudit`
--

INSERT INTO `tblfilmtitlesaudit` (`auditUser`, `auditAction`, `lngFilmTitleID`, `strFilmTitle`, `memFilmStory`, `dtmFilmReleaseDate`, `intFilmDuration`, `memFilmAdditionalInfo`, `lngGenreID`, `lngCertificateID`, `picture`, `dtmTimeStamp`) VALUES
('@', 'update', 1, 'John Wick', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-08', 120, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 2, 5, '91wc7yc2R8L._SL1500_.jpg', '2019-10-30 03:27:30'),
('@', 'update', 1, 'John Wick', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-08', 120, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 2, 3, '91wc7yc2R8L._SL1500_.jpg', '2019-10-30 03:27:36'),
('@', 'update', 1, 'John Wick', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-08', 120, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 2, 4, '91wc7yc2R8L._SL1500_.jpg', '2019-10-30 03:30:21'),
('@', 'update', 2, 'SpiderMan', 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', '2019-10-16', 139, 'Aliquam erat volutpat. Ut ornare libero enim, eget sollicitudin metus blandit sed. Sed quis bibendum libero, eget tempus orci. Ut iaculis enim iaculis ex varius, eget cursus turpis dapibus. Vestibulum convallis, justo ac lobortis pulvinar, lectus enim commodo justo, sit amet eleifend purus purus id tortor. Duis interdum dictum elit eu blandit. Ut tortor est, pharetra non magna vitae, vestibulum sodales tellus. Maecenas ut lorem in nulla pretium fermentum.  Duis pharetra facilisis nulla nec varius. Fusce ullamcorper tortor sed nulla congue blandit. Sed maximus lorem diam, ut cursus dolor porta tempus. Nunc non urna mauris. Nam eget ultrices eros, eget accumsan turpis. Sed pulvinar lacus nec ultrices lacinia. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum sed risus sit amet erat molestie sollicitudin quis eget diam.', 2, 4, 'Official_FFH_US_Poster.jpg', '2019-10-30 03:46:40'),
('@', 'update', 4, 'Matrix', 'fds;aifdoansfdoafi', '2019-10-31', 140, 'fds;aifdoansfdoafi', 2, 4, 'download.jpg', '2019-10-30 07:32:42'),
('@', 'update', 4, 'Matrix', 'fds;aifdoansfdoafi', '2019-10-31', 140, 'fds;aifdoansfdoafi', 1, 4, 'download.jpg', '2019-10-30 07:32:50'),
('@', 'delete', 3, 'Lalaland', 'fdsasdfafdfds', '2019-10-01', 122, 'fdsasdfafdfds', 2, 1, 'spiderman.jpg', '2019-10-30 07:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitlesproducers`
--

CREATE TABLE `tblfilmtitlesproducers` (
  `lngFilmTitleID` int(11) NOT NULL,
  `lngProducerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmtitlesproducers`
--

INSERT INTO `tblfilmtitlesproducers` (`lngFilmTitleID`, `lngProducerID`) VALUES
(1, 1),
(2, 2),
(2, 3),
(4, 4);

--
-- Triggers `tblfilmtitlesproducers`
--
DELIMITER $$
CREATE TRIGGER `before_tblFilmTitlesProducers_delete` BEFORE DELETE ON `tblfilmtitlesproducers` FOR EACH ROW BEGIN

INSERT INTO tblfilmtitlesproducersaudit (auditUser,auditAction,lngFilmTitleID,lngProducerID)
VALUES (CURRENT_USER(),'delete',OLD.lngFilmTitleID,OLD.lngProducerID);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_tblFilmTitlesProducers_update` BEFORE UPDATE ON `tblfilmtitlesproducers` FOR EACH ROW BEGIN

INSERT INTO tblfilmtitlesproducersaudit (auditUser,auditAction,lngFilmTitleID,lngProducerID)
VALUES (CURRENT_USER(),'update',OLD.lngFilmTitleID,OLD.lngProducerID);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitlesproducersaudit`
--

CREATE TABLE `tblfilmtitlesproducersaudit` (
  `auditUser` text NOT NULL,
  `auditAction` enum('update','delete') NOT NULL,
  `lngFilmTitleID` int(11) NOT NULL,
  `lngProducerID` int(11) NOT NULL,
  `dtmTimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilmtitlesproducersaudit`
--

INSERT INTO `tblfilmtitlesproducersaudit` (`auditUser`, `auditAction`, `lngFilmTitleID`, `lngProducerID`, `dtmTimeStamp`) VALUES
('@', 'delete', 4, 3, '2019-10-30 03:12:04'),
('@', 'delete', 1, 2, '2019-10-30 05:41:53'),
('@', 'delete', 1, 3, '2019-10-30 07:29:14');

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

--
-- Dumping data for table `tblproducers`
--

INSERT INTO `tblproducers` (`lngProducerID`, `strProducerName`, `hypContactEmailAddress`, `hypWebsite`) VALUES
(1, 'Alladin M. Melico', 'melico.alladin@gmail.com', 'https://www.alladinmelico.com'),
(2, 'Marc E. Platt', 'MarcPlatt@gmail.com', 'http://www.MarcPlatt.com'),
(3, 'Steven Spielberg', 'StevenSpielberg@gmail.com', 'https://www.StevenSpielberg.com'),
(4, 'Christopher Nolan', 'ChristopherNolan@gmail.com', 'https://www.ChristopherNolan.com');

-- --------------------------------------------------------

--
-- Table structure for table `tblroletypes`
--

CREATE TABLE `tblroletypes` (
  `lngRoleTypeID` int(11) NOT NULL,
  `strRoleType` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblroletypes`
--

INSERT INTO `tblroletypes` (`lngRoleTypeID`, `strRoleType`) VALUES
(1, 'Lead'),
(2, 'Protagonist'),
(3, 'Antagonist'),
(5, 'evil'),
(6, 'fooBar'),
(7, 'fooo');

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
-- Stand-in structure for view `viewallfilm`
-- (See below for the actual view)
--
CREATE TABLE `viewallfilm` (
`lngActorID` int(11)
,`actors` mediumtext
,`lngFilmTitleID` int(11)
,`strFilmTitle` varchar(45)
,`memFilmStory` mediumtext
,`picture` varchar(45)
,`dtmFilmReleaseDate` date
,`intFilmDuration` int(11)
,`producers` mediumtext
,`genre` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewfilmcertgenre`
-- (See below for the actual view)
--
CREATE TABLE `viewfilmcertgenre` (
`strFilmTitle` varchar(45)
,`lngFilmTitleID` int(11)
,`memFilmStory` mediumtext
,`lngGenreID` int(11)
,`strGenre` varchar(45)
,`lngCertificateID` int(11)
,`strCertificate` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewselectactor`
-- (See below for the actual view)
--
CREATE TABLE `viewselectactor` (
`lngActorID` int(11)
,`strActorFullName` varchar(45)
,`memActorNotes` mediumtext
,`picture` varchar(45)
,`strCharacterName` varchar(45)
,`memCharaterDescription` mediumtext
,`strRoleType` varchar(45)
,`lngFilmTitleID` int(11)
,`strFilmTitle` varchar(45)
,`strProducerName` varchar(45)
,`filmPicture` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewselectfilm`
-- (See below for the actual view)
--
CREATE TABLE `viewselectfilm` (
`lngActorID` int(11)
,`strActorFullName` varchar(45)
,`actPic` varchar(45)
,`strCharacterName` varchar(45)
,`memCharaterDescription` mediumtext
,`lngFilmTitleID` int(11)
,`strFilmTitle` varchar(45)
,`memFilmStory` mediumtext
,`picture` varchar(45)
,`dtmFilmReleaseDate` date
,`intFilmDuration` int(11)
,`strCertificate` varchar(45)
,`strGenre` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewselectfilmproducers`
-- (See below for the actual view)
--
CREATE TABLE `viewselectfilmproducers` (
`lngFilmTitleID` int(11)
,`strFilmTitle` varchar(45)
,`memFilmStory` mediumtext
,`dtmFilmReleaseDate` date
,`intFilmDuration` int(11)
,`memFilmAdditionalInfo` mediumtext
,`lngProducerID` int(11)
,`strProducerName` varchar(45)
);

-- --------------------------------------------------------

--
-- Structure for view `viewallfilm`
--
DROP TABLE IF EXISTS `viewallfilm`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewallfilm`  AS  select `act`.`lngActorID` AS `lngActorID`,group_concat(distinct `act`.`strActorFullName` separator ',') AS `actors`,`film`.`lngFilmTitleID` AS `lngFilmTitleID`,`film`.`strFilmTitle` AS `strFilmTitle`,`film`.`memFilmStory` AS `memFilmStory`,`film`.`picture` AS `picture`,`film`.`dtmFilmReleaseDate` AS `dtmFilmReleaseDate`,`film`.`intFilmDuration` AS `intFilmDuration`,group_concat(distinct `prod`.`strProducerName` separator ',') AS `producers`,group_concat(distinct `genre`.`strGenre` separator ',') AS `genre` from (((((`tblactors` `act` join `tblfilmsactorroles` `fac` on(`fac`.`lngActorID` = `act`.`lngActorID`)) join `tblfilmtitles` `film` on(`film`.`lngFilmTitleID` = `fac`.`lngFilmTitleID`)) join `tblfilmtitlesproducers` `ftp` on(`ftp`.`lngFilmTitleID` = `film`.`lngFilmTitleID`)) join `tblproducers` `prod` on(`prod`.`lngProducerID` = `ftp`.`lngProducerID`)) join `tblfilmgenres` `genre` on(`genre`.`lngGenreID` = `film`.`lngGenreID`)) group by `film`.`lngFilmTitleID` ;

-- --------------------------------------------------------

--
-- Structure for view `viewfilmcertgenre`
--
DROP TABLE IF EXISTS `viewfilmcertgenre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewfilmcertgenre`  AS  select `film`.`strFilmTitle` AS `strFilmTitle`,`film`.`lngFilmTitleID` AS `lngFilmTitleID`,`film`.`memFilmStory` AS `memFilmStory`,`genre`.`lngGenreID` AS `lngGenreID`,`genre`.`strGenre` AS `strGenre`,`cert`.`lngCertificateID` AS `lngCertificateID`,`cert`.`strCertificate` AS `strCertificate` from ((`tblfilmtitles` `film` join `tblfilmgenres` `genre` on(`film`.`lngFilmTitleID` = `genre`.`lngGenreID`)) join `tblfilmcertificates` `cert` on(`cert`.`lngCertificateID` = `film`.`lngGenreID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `viewselectactor`
--
DROP TABLE IF EXISTS `viewselectactor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewselectactor`  AS  select `act`.`lngActorID` AS `lngActorID`,`act`.`strActorFullName` AS `strActorFullName`,`act`.`memActorNotes` AS `memActorNotes`,`act`.`picture` AS `picture`,`fac`.`strCharacterName` AS `strCharacterName`,`fac`.`memCharaterDescription` AS `memCharaterDescription`,`role`.`strRoleType` AS `strRoleType`,`film`.`lngFilmTitleID` AS `lngFilmTitleID`,`film`.`strFilmTitle` AS `strFilmTitle`,`prod`.`strProducerName` AS `strProducerName`,`film`.`picture` AS `filmPicture` from (((((`tblactors` `act` join `tblfilmsactorroles` `fac` on(`fac`.`lngActorID` = `act`.`lngActorID`)) join `tblroletypes` `role` on(`role`.`lngRoleTypeID` = `fac`.`lngRoleTypeID`)) join `tblfilmtitles` `film` on(`film`.`lngFilmTitleID` = `fac`.`lngFilmTitleID`)) join `tblfilmtitlesproducers` `ftp` on(`ftp`.`lngFilmTitleID` = `film`.`lngFilmTitleID`)) join `tblproducers` `prod` on(`prod`.`lngProducerID` = `ftp`.`lngProducerID`)) group by `act`.`lngActorID`,`film`.`lngFilmTitleID` ;

-- --------------------------------------------------------

--
-- Structure for view `viewselectfilm`
--
DROP TABLE IF EXISTS `viewselectfilm`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewselectfilm`  AS  select `act`.`lngActorID` AS `lngActorID`,`act`.`strActorFullName` AS `strActorFullName`,`act`.`picture` AS `actPic`,`fac`.`strCharacterName` AS `strCharacterName`,`fac`.`memCharaterDescription` AS `memCharaterDescription`,`film`.`lngFilmTitleID` AS `lngFilmTitleID`,`film`.`strFilmTitle` AS `strFilmTitle`,`film`.`memFilmStory` AS `memFilmStory`,`film`.`picture` AS `picture`,`film`.`dtmFilmReleaseDate` AS `dtmFilmReleaseDate`,`film`.`intFilmDuration` AS `intFilmDuration`,`cert`.`strCertificate` AS `strCertificate`,`genre`.`strGenre` AS `strGenre` from ((((`tblactors` `act` join `tblfilmsactorroles` `fac` on(`fac`.`lngActorID` = `act`.`lngActorID`)) join `tblfilmtitles` `film` on(`film`.`lngFilmTitleID` = `fac`.`lngFilmTitleID`)) join `tblfilmcertificates` `cert` on(`cert`.`lngCertificateID` = `film`.`lngCertificateID`)) join `tblfilmgenres` `genre` on(`genre`.`lngGenreID` = `film`.`lngGenreID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `viewselectfilmproducers`
--
DROP TABLE IF EXISTS `viewselectfilmproducers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewselectfilmproducers`  AS  select `film`.`lngFilmTitleID` AS `lngFilmTitleID`,`film`.`strFilmTitle` AS `strFilmTitle`,`film`.`memFilmStory` AS `memFilmStory`,`film`.`dtmFilmReleaseDate` AS `dtmFilmReleaseDate`,`film`.`intFilmDuration` AS `intFilmDuration`,`film`.`memFilmAdditionalInfo` AS `memFilmAdditionalInfo`,`ftp`.`lngProducerID` AS `lngProducerID`,`prod`.`strProducerName` AS `strProducerName` from ((`tblfilmtitles` `film` join `tblfilmtitlesproducers` `ftp` on(`ftp`.`lngFilmTitleID` = `film`.`lngFilmTitleID`)) join `tblproducers` `prod` on(`prod`.`lngProducerID` = `ftp`.`lngProducerID`)) ;

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
  MODIFY `lngGenreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblfilmtitles`
--
ALTER TABLE `tblfilmtitles`
  MODIFY `lngFilmTitleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblproducers`
--
ALTER TABLE `tblproducers`
  MODIFY `lngProducerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblroletypes`
--
ALTER TABLE `tblroletypes`
  MODIFY `lngRoleTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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

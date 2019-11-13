-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2019 at 04:31 AM
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
-- Error reading structure for table db_mp1.tblactors: #1932 - Table 'db_mp1.tblactors' doesn't exist in engine
-- Error reading data for table db_mp1.tblactors: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblactors`' at line 1

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
-- Error reading structure for table db_mp1.tblactorsaudit: #1932 - Table 'db_mp1.tblactorsaudit' doesn't exist in engine
-- Error reading data for table db_mp1.tblactorsaudit: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblactorsaudit`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmcertificates`
--
-- Error reading structure for table db_mp1.tblfilmcertificates: #1932 - Table 'db_mp1.tblfilmcertificates' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmcertificates: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmcertificates`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmgenres`
--
-- Error reading structure for table db_mp1.tblfilmgenres: #1932 - Table 'db_mp1.tblfilmgenres' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmgenres: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmgenres`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmsactorroles`
--
-- Error reading structure for table db_mp1.tblfilmsactorroles: #1932 - Table 'db_mp1.tblfilmsactorroles' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmsactorroles: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmsactorroles`' at line 1

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
-- Error reading structure for table db_mp1.tblfilmsactorrolesaudit: #1932 - Table 'db_mp1.tblfilmsactorrolesaudit' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmsactorrolesaudit: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmsactorrolesaudit`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitles`
--
-- Error reading structure for table db_mp1.tblfilmtitles: #1932 - Table 'db_mp1.tblfilmtitles' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmtitles: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmtitles`' at line 1

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
-- Error reading structure for table db_mp1.tblfilmtitlesaudit: #1932 - Table 'db_mp1.tblfilmtitlesaudit' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmtitlesaudit: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmtitlesaudit`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblfilmtitlesproducers`
--
-- Error reading structure for table db_mp1.tblfilmtitlesproducers: #1932 - Table 'db_mp1.tblfilmtitlesproducers' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmtitlesproducers: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmtitlesproducers`' at line 1

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
-- Error reading structure for table db_mp1.tblfilmtitlesproducersaudit: #1932 - Table 'db_mp1.tblfilmtitlesproducersaudit' doesn't exist in engine
-- Error reading data for table db_mp1.tblfilmtitlesproducersaudit: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblfilmtitlesproducersaudit`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblproducers`
--
-- Error reading structure for table db_mp1.tblproducers: #1932 - Table 'db_mp1.tblproducers' doesn't exist in engine
-- Error reading data for table db_mp1.tblproducers: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblproducers`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tblroletypes`
--
-- Error reading structure for table db_mp1.tblroletypes: #1932 - Table 'db_mp1.tblroletypes' doesn't exist in engine
-- Error reading data for table db_mp1.tblroletypes: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tblroletypes`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--
-- Error reading structure for table db_mp1.tbluser: #1932 - Table 'db_mp1.tbluser' doesn't exist in engine
-- Error reading data for table db_mp1.tbluser: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `db_mp1`.`tbluser`' at line 1

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewallfilm`
-- (See below for the actual view)
--
CREATE TABLE `viewallfilm` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewfilmcertgenre`
-- (See below for the actual view)
--
CREATE TABLE `viewfilmcertgenre` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewselectactor`
-- (See below for the actual view)
--
CREATE TABLE `viewselectactor` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewselectfilm`
-- (See below for the actual view)
--
CREATE TABLE `viewselectfilm` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewselectfilmproducers`
-- (See below for the actual view)
--
CREATE TABLE `viewselectfilmproducers` (
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

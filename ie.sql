-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2020 at 06:48 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lectiibiologie`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `ID` int(10) NOT NULL,
  `UnlockedBy` int(10) NOT NULL,
  `Achievement` int(10) NOT NULL,
  `Claimed` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`ID`, `UnlockedBy`, `Achievement`, `Claimed`) VALUES
(16, 2, 1, 0),
(17, 3, 1, 1),
(18, 3, 10, 0),
(19, 3, 13, 0),
(20, 2, 2, 0),
(21, 5, 1, 0),
(22, 7, 1, 1),
(23, 7, 4, 1),
(24, 7, 7, 1),
(25, 8, 1, 0),
(26, 7, 3, 0),
(27, 7, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(2) NOT NULL,
  `Title` text NOT NULL,
  `Color` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Title`, `Color`) VALUES
(1, 'General', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `ID` int(10) NOT NULL,
  `Code` varchar(6) NOT NULL,
  `ExpireAt` datetime NOT NULL,
  `CreatedBy` int(10) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT 0,
  `Winner` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`ID`, `Code`, `ExpireAt`, `CreatedBy`, `Status`, `Winner`) VALUES
(18, 'd9tAtY', '2020-07-11 06:04:53', 7, 1, 8),
(19, '8TmPNx', '2020-07-11 07:58:40', 8, 1, 8),
(20, 'y3oHSQ', '2020-07-11 18:17:34', 8, 1, 8),
(21, 'jEqXHn', '2020-07-11 18:23:12', 7, 1, 0),
(22, 'VLFaj7', '2020-07-12 18:28:39', 7, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `ID` int(10) NOT NULL,
  `Title` varchar(48) NOT NULL,
  `Description` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`ID`, `Title`, `Description`) VALUES
(15, 'Virginitatea', 'Cel mai frumos lucru. Pentru o femeie.'),
(17, 'Sistemul osos', ''),
(18, 'Toate sistemele din organism', ''),
(20, 'Laba', 'Laba este un proces complex de autosatisfacere.');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `ID` int(10) NOT NULL,
  `Title` varchar(65) NOT NULL,
  `Chapter` int(10) NOT NULL,
  `Content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`ID`, `Title`, `Chapter`, `Content`) VALUES
(25, 'Introducere', 15, '<p><strong>Virginitatea </strong>(cunoscuta si ca starea \"Bors\") reprezinta proprietatea unui trist sau tocilar ca acesta <strong>nu a fost atins de o femei niciodata</strong> in viata lui (in zone intime, si nu din intamplare - anti-exemplu <em>\"coada la magazin, se loveste cu mana de pula\"</em>)</p>\r\n<p>Exemple de virgini</p>\r\n<table style=\"border-collapse: collapse; width: 65.8718%; height: 37px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 22px;\">\r\n<td style=\"width: 50%; height: 22px;\">Dragos Sirbu</td>\r\n<td style=\"width: 50%; height: 22px;\">labar trist</td>\r\n</tr>\r\n<tr style=\"height: 15px;\">\r\n<td style=\"width: 50%; height: 15px;\">Bors Andrei Darius</td>\r\n<td style=\"width: 50%; height: 15px;\">&nbsp;anti labar trist, anti pacatul malahiei convins</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Exemple de gagici non-virgine</p>\r\n<p><em>Beatrice Cristina, Viviana Radu, Maria Iordan.</em></p>');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `ID` int(10) NOT NULL,
  `User` int(10) NOT NULL,
  `Question` int(10) NOT NULL,
  `questionChapter` int(10) NOT NULL,
  `correctAnswers` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`ID`, `User`, `Question`, `questionChapter`, `correctAnswers`) VALUES
(1, 2, 9, 15, 10),
(2, 2, 5, 15, 7),
(3, 2, 6, 15, 7),
(4, 2, 7, 15, 9),
(5, 2, 8, 15, 6),
(6, 7, 8, 15, 11),
(7, 7, 5, 15, 9),
(8, 7, 7, 15, 13),
(9, 7, 11, 18, 2),
(10, 7, 9, 15, 8),
(11, 7, 6, 15, 13),
(12, 7, 10, 17, 2),
(13, 7, 17, 15, 8),
(14, 7, 15, 15, 9),
(15, 7, 14, 15, 6),
(16, 7, 18, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `ID` int(10) NOT NULL,
  `Question` text NOT NULL,
  `Type` int(1) NOT NULL,
  `Chapter` int(10) NOT NULL,
  `answerA` text DEFAULT NULL,
  `answerB` text DEFAULT NULL,
  `answerC` text DEFAULT NULL,
  `answerD` text DEFAULT NULL,
  `rightAnswer` int(1) NOT NULL,
  `answerEx` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`ID`, `Question`, `Type`, `Chapter`, `answerA`, `answerB`, `answerC`, `answerD`, `rightAnswer`, `answerEx`) VALUES
(5, 'Ce faci?', 1, 15, 'Bine', 'Ok', 'f bn', 'f rau', 1, 'papa'),
(6, 'Mai este Beatrice Codrianu virgina?', 1, 15, 'Nu', 'Clar NU', 'SIGUR CA NU', 'NEIN!', 4, 'bors style'),
(7, 'GrasuXXL e nasol?', 1, 15, 'Da', 'Cel mai', 'Nu, e chiar fain', 'Nu', 3, 'alexa play \"pizda la volan\"'),
(8, 'Il sono Ilie Dumitrescu?', 1, 15, 'Si', 'Du-te-n pizda ma-tii', 'Yes', 'Oui', 1, 'IL SONO ILIE DUMITRESCU. ALO? SON ILIE DUMITRESCU? ALO? ALO? DU-TE-N PIZDA MA-TII'),
(9, 'DU-TE', 1, 15, 'SI NU TE MAI INTOARCE', 'DICAAAAAA', '-N PIZDA MA-TII', 'LA MA-TA', 2, 'TAP TAP TAP TAP TARARAP TAP TAP'),
(10, 'giu suge?', 1, 17, 'da', 'da', 'da', 'da', 1, 'ca da'),
(11, 'da', 1, 18, 'da', 'dad', 'dadad', 'dad', 2, 'da'),
(14, 'Wut?', 1, 15, 'nmk', 'ok', 'bn', 'sal', 3, 'dc nu'),
(15, 'FCSB = Steaua?', 2, 15, NULL, NULL, NULL, NULL, 2, 'Da.'),
(17, 'Inima este compusa din ... camere.', 3, 15, 'trei', NULL, NULL, NULL, 0, 'dj project feat. ami - patru camere'),
(18, 'Tiberiu pop conduce', 3, 17, 'cel.ro', NULL, NULL, NULL, 0, 'rapido rapido');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `ID` int(10) NOT NULL,
  `Code` varchar(6) NOT NULL,
  `Solver` int(10) NOT NULL,
  `STime` int(4) NOT NULL,
  `Questions` text NOT NULL,
  `Result` float NOT NULL,
  `Challenge` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`ID`, `Code`, `Solver`, `STime`, `Questions`, `Result`, `Challenge`) VALUES
(36, 'U6zEqv', 7, 0, '9|8|17|14|7', 1, 'd9tAtY'),
(37, 'mdtqsP', 8, 10, '11|5|17|18|15', 2, '8TmPNx'),
(38, 'F9SxmU', 8, 12, '14|9|7|8|17', 2, 'd9tAtY'),
(39, 'm1AWNM', 8, 19, '8|10|18|17|15', 2.5, NULL),
(40, 'Xh6hJb', 8, 10, '17|5|9|14|15', 2, 'y3oHSQ'),
(41, '9AmijY', 7, 31, '17|5|9|14|15', 2, 'y3oHSQ'),
(42, 'PKeDC4', 7, 7, '7|14|15|10|9', 2, 'jEqXHn'),
(43, 'hYCGLx', 7, 7, '10|7|6|5|15', 1.5, 'VLFaj7'),
(44, '5Vqqvc', 7, 8, '6|8|5|9|18', 0, NULL),
(45, 'DSK3rT', 7, 4, '11|14|5|8|10', 0.5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `fName` varchar(24) NOT NULL,
  `lName` varchar(24) NOT NULL,
  `EMail` varchar(36) NOT NULL,
  `Password` varchar(65) NOT NULL,
  `Admin` int(1) DEFAULT NULL,
  `XP` int(11) NOT NULL DEFAULT 0,
  `Gender` int(2) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `City` varchar(25) DEFAULT NULL,
  `County` varchar(25) DEFAULT NULL,
  `AvatarType` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `fName`, `lName`, `EMail`, `Password`, `Admin`, `XP`, `Gender`, `Birthday`, `City`, `County`, `AvatarType`) VALUES
(7, 'Tudor', 'Micu', 'tudor.micubd@gmail.com', 'a60ab74452b1a8d27959cd32e0bed478f9feae8bb8585cdbe9aaaf91dc2ee18b', 1, 4835, NULL, NULL, NULL, NULL, ''),
(8, 'Victor', 'Micu', 'victor.micubd@gmail.com', '5b65b34ea568a16bcc8d86e1435085a9a5ea9f5fedc42cbc7a96cd6f5fffd112', NULL, 350, NULL, NULL, NULL, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

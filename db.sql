-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iul. 23, 2020 la 03:42 PM
-- Versiune server: 10.4.11-MariaDB
-- Versiune PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `lectiibiologie`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `achievements`
--

CREATE TABLE `achievements` (
  `ID` int(10) NOT NULL,
  `UnlockedBy` int(10) NOT NULL,
  `Achievement` int(10) NOT NULL,
  `Claimed` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `achievements`
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
(27, 7, 20, 1),
(28, 7, 2, 0),
(29, 8, 2, 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `categories`
--

CREATE TABLE `categories` (
  `ID` int(2) NOT NULL,
  `Title` text NOT NULL,
  `Color` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `categories`
--

INSERT INTO `categories` (`ID`, `Title`, `Color`) VALUES
(1, 'General', 'success');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `challenges`
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
-- Eliminarea datelor din tabel `challenges`
--

INSERT INTO `challenges` (`ID`, `Code`, `ExpireAt`, `CreatedBy`, `Status`, `Winner`) VALUES
(18, 'd9tAtY', '2020-07-11 06:04:53', 7, 1, 8),
(19, '8TmPNx', '2020-07-11 07:58:40', 8, 1, 8),
(20, 'y3oHSQ', '2020-07-11 18:17:34', 8, 1, 8),
(21, 'jEqXHn', '2020-07-11 18:23:12', 7, 1, 0),
(22, 'VLFaj7', '2020-07-12 18:28:39', 7, 1, 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `chapters`
--

CREATE TABLE `chapters` (
  `ID` int(10) NOT NULL,
  `Title` varchar(48) NOT NULL,
  `Category` int(11) NOT NULL,
  `Level` int(11) NOT NULL DEFAULT 1,
  `Description` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `chapters`
--

INSERT INTO `chapters` (`ID`, `Title`, `Category`, `Level`, `Description`) VALUES
(15, 'Virginitatea', 1, 1, 'Cel mai frumos lucru. Pentru o femeie.'),
(17, 'Sistemul osos', 1, 1, ''),
(18, 'Toate sistemele din organism', 1, 1, ''),
(20, 'Laba', 2, 1, 'Laba este un proces complex de autosatisfacere.'),
(21, 'pula', 2, 1, 'mea'),
(22, 'halal', 2, 1, 'de tara de cacat sa-mi bag poola');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `contests`
--

CREATE TABLE `contests` (
  `ID` int(10) NOT NULL,
  `Name` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Category` int(1) NOT NULL,
  `SDateTime` datetime NOT NULL,
  `Length` int(11) NOT NULL,
  `Prize` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `Winner` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `contests`
--

INSERT INTO `contests` (`ID`, `Name`, `Description`, `Category`, `SDateTime`, `Length`, `Prize`, `Status`, `Winner`) VALUES
(2, 'Admitere Academia Dan Bursuc, sectia Sexologie', 'Va vom testa abilitatile de futaci, ok?', 1, '2020-07-18 18:29:49', 20, 50, 2, 7);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `lessons`
--

CREATE TABLE `lessons` (
  `ID` int(10) NOT NULL,
  `Title` varchar(65) NOT NULL,
  `Chapter` int(10) NOT NULL,
  `Content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `lessons`
--

INSERT INTO `lessons` (`ID`, `Title`, `Chapter`, `Content`) VALUES
(25, 'Introducere', 20, '<p><strong>Virginitatea </strong>(cunoscuta si ca starea \"Bors\") reprezinta proprietatea unui trist sau tocilar ca acesta <strong>nu a fost atins de o femei niciodata</strong> in viata lui (in zone intime, si nu din intamplare - anti-exemplu <em>\"coada la magazin, se loveste cu mana de pula\"</em>)</p>\r\n<p>Exemple de virgini</p>\r\n<table style=\"border-collapse: collapse; width: 65.8718%; height: 37px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 22px;\">\r\n<td style=\"width: 50%; height: 22px;\">Dragos Sirbu</td>\r\n<td style=\"width: 50%; height: 22px;\">labar trist</td>\r\n</tr>\r\n<tr style=\"height: 15px;\">\r\n<td style=\"width: 50%; height: 15px;\">Bors Andrei Darius</td>\r\n<td style=\"width: 50%; height: 15px;\">&nbsp;anti labar trist, anti pacatul malahiei convins</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Exemple de gagici non-virgine</p>\r\n<p><em>Beatrice Cristina, Viviana Radu, Maria Iordan.</em></p>');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `posts`
--

CREATE TABLE `posts` (
  `ID` int(10) NOT NULL,
  `CreatedBy` int(10) NOT NULL,
  `Lesson` int(10) NOT NULL,
  `Text` varchar(240) NOT NULL,
  `BestReply` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `posts`
--

INSERT INTO `posts` (`ID`, `CreatedBy`, `Lesson`, `Text`, `BestReply`) VALUES
(1, 7, 25, 'Ai un leu?', 5);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `progress`
--

CREATE TABLE `progress` (
  `ID` int(10) NOT NULL,
  `User` int(10) NOT NULL,
  `Question` int(10) NOT NULL,
  `questionChapter` int(10) NOT NULL,
  `correctAnswers` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `progress`
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
-- Structură tabel pentru tabel `questions`
--

CREATE TABLE `questions` (
  `ID` int(10) NOT NULL,
  `Question` text NOT NULL,
  `Type` int(1) NOT NULL,
  `Chapter` int(10) NOT NULL,
  `Contest` int(11) NOT NULL DEFAULT 0,
  `Blocked` int(1) NOT NULL DEFAULT 0,
  `answerA` text DEFAULT NULL,
  `answerB` text DEFAULT NULL,
  `answerC` text DEFAULT NULL,
  `answerD` text DEFAULT NULL,
  `rightAnswer` int(1) NOT NULL,
  `answerEx` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `questions`
--

INSERT INTO `questions` (`ID`, `Question`, `Type`, `Chapter`, `Contest`, `Blocked`, `answerA`, `answerB`, `answerC`, `answerD`, `rightAnswer`, `answerEx`) VALUES
(5, 'Ce faci?', 1, 15, 0, 0, 'Bine', 'Ok', 'f bn', 'f rau', 1, 'papa'),
(6, 'Mai este Beatrice Codrianu virgina?', 1, 15, 0, 0, 'Nu', 'Clar NU', 'SIGUR CA NU', 'NEIN!', 4, 'bors style'),
(7, 'GrasuXXL e nasol?', 1, 15, 0, 0, 'Da', 'Cel mai', 'Nu, e chiar fain', 'Nu', 3, 'alexa play \"pizda la volan\"'),
(8, 'Il sono Ilie Dumitrescu?', 1, 15, 0, 0, 'Si', 'Du-te-n pizda ma-tii', 'Yes', 'Oui', 1, 'IL SONO ILIE DUMITRESCU. ALO? SON ILIE DUMITRESCU? ALO? ALO? DU-TE-N PIZDA MA-TII'),
(9, 'DU-TE', 1, 15, 0, 0, 'SI NU TE MAI INTOARCE', 'DICAAAAAA', '-N PIZDA MA-TII', 'LA MA-TA', 2, 'TAP TAP TAP TAP TARARAP TAP TAP'),
(10, 'giu suge?', 1, 17, 0, 0, 'da', 'da', 'da', 'da', 1, 'ca da'),
(11, 'da', 1, 18, 0, 0, 'da', 'dad', 'dadad', 'dad', 2, 'da'),
(14, 'Wut?', 1, 15, 0, 0, 'nmk', 'ok', 'bn', 'sal', 3, 'dc nu'),
(15, 'FCSB = Steaua?', 2, 15, 0, 0, NULL, NULL, NULL, NULL, 2, 'Da.'),
(17, 'Inima este compusa din ... camere.', 3, 15, 0, 0, 'trei', NULL, NULL, NULL, 0, 'dj project feat. ami - patru camere'),
(18, 'Tiberiu pop conduce', 3, 17, 0, 0, 'cel.ro', NULL, NULL, NULL, 0, 'rapido rapido'),
(19, 'mi-l sugi?', 1, 20, 0, 0, 'da', 'da', 'da', 'da', 2, 'bn'),
(20, 'La facultate, colegilor/colegelor li se suge pula/da limbi pe gratis?', 2, 21, 1, 1, NULL, NULL, NULL, NULL, 1, 'Nu fi bulangiu'),
(21, 'Care e cea mai buna femeie sa o futi?', 1, 20, 2, 1, 'Aia care e platita', 'Aia care sta cu tn doar pt bani', 'Aia care iti e nevasta/iubita', 'Aia al carui esti amant', 4, 'Ca te simti jmeker'),
(22, 'Cine e zeul femeilor?', 1, 20, 2, 1, 'Dani Mocanu', 'Katalin Talent', 'Tudor Micu', 'Klaus Iohannis', 2, 'KI si eu sugem pula pe 2 lei, iar DM e proxenet.'),
(23, 'Margott Robbie e buna de pula', 2, 20, 2, 1, NULL, NULL, NULL, NULL, 1, 'Esti prost?');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `quizzes`
--

CREATE TABLE `quizzes` (
  `ID` int(10) NOT NULL,
  `Code` varchar(6) NOT NULL,
  `Solver` int(10) NOT NULL,
  `STime` int(4) NOT NULL,
  `Questions` text NOT NULL,
  `Result` float NOT NULL,
  `Challenge` varchar(6) DEFAULT NULL,
  `Contest` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `quizzes`
--

INSERT INTO `quizzes` (`ID`, `Code`, `Solver`, `STime`, `Questions`, `Result`, `Challenge`, `Contest`) VALUES
(36, 'U6zEqv', 7, 0, '9|8|17|14|7', 1, 'd9tAtY', 0),
(37, 'mdtqsP', 8, 10, '11|5|17|18|15', 2, '8TmPNx', 0),
(38, 'F9SxmU', 8, 12, '14|9|7|8|17', 2, 'd9tAtY', 0),
(39, 'm1AWNM', 8, 19, '8|10|18|17|15', 2.5, NULL, 0),
(40, 'Xh6hJb', 8, 10, '17|5|9|14|15', 2, 'y3oHSQ', 0),
(41, '9AmijY', 7, 31, '17|5|9|14|15', 2, 'y3oHSQ', 0),
(42, 'PKeDC4', 7, 7, '7|14|15|10|9', 2, 'jEqXHn', 0),
(43, 'hYCGLx', 7, 7, '10|7|6|5|15', 1.5, 'VLFaj7', 0),
(44, '5Vqqvc', 7, 8, '6|8|5|9|18', 0, NULL, 0),
(45, 'DSK3rT', 7, 4, '11|14|5|8|10', 0.5, NULL, 0),
(46, 'naahWf', 7, 16, '21|23|22', 1, NULL, 2),
(47, 'g1t2Yh', 7, 32, '6|8|18|9|17', 1, NULL, 0),
(48, 'XgAfqe', 7, 14, '18|5|17|8|14', 0.5, NULL, 0),
(49, 'eEZ2Bv', 7, 59, '7|17|5|14|6', 0.5, NULL, 0);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `replies`
--

CREATE TABLE `replies` (
  `ID` int(10) NOT NULL,
  `CreatedBy` int(10) NOT NULL,
  `Post` int(10) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `replies`
--

INSERT INTO `replies` (`ID`, `CreatedBy`, `Post`, `Text`) VALUES
(1, 7, 2, 'Da.'),
(2, 7, 2, 'Hehehe'),
(3, 7, 1, 'N-am, ca-s sarak.'),
(5, 8, 1, 'sugi fraere');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `Code` varchar(6) NOT NULL,
  `fName` varchar(24) NOT NULL,
  `lName` varchar(24) NOT NULL,
  `EMail` varchar(36) NOT NULL,
  `Refferal` varchar(6) DEFAULT NULL,
  `Password` varchar(65) NOT NULL,
  `Admin` int(1) DEFAULT NULL,
  `ExamType` int(1) NOT NULL,
  `Level` int(3) NOT NULL DEFAULT 1,
  `XP` int(11) NOT NULL DEFAULT 0,
  `Coins` int(7) DEFAULT 0,
  `Trophies` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`ID`, `Code`, `fName`, `lName`, `EMail`, `Refferal`, `Password`, `Admin`, `ExamType`, `Level`, `XP`, `Coins`, `Trophies`) VALUES
(7, 'PLMARE', 'Tudor', 'Micu', 'tudor.micubd@gmail.com', NULL, 'a60ab74452b1a8d27959cd32e0bed478f9feae8bb8585cdbe9aaaf91dc2ee18b', 1, 2, 6, 15, 35, 0),
(8, 'aWFDA9', 'Victor', 'Micu', 'victor.micubd@gmail.com', NULL, '5b65b34ea568a16bcc8d86e1435085a9a5ea9f5fedc42cbc7a96cd6f5fffd112', NULL, 2, 1, 350, 1, 0);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`ID`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `achievements`
--
ALTER TABLE `achievements`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pentru tabele `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `challenges`
--
ALTER TABLE `challenges`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pentru tabele `chapters`
--
ALTER TABLE `chapters`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pentru tabele `contests`
--
ALTER TABLE `contests`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `lessons`
--
ALTER TABLE `lessons`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pentru tabele `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `progress`
--
ALTER TABLE `progress`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pentru tabele `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pentru tabele `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pentru tabele `replies`
--
ALTER TABLE `replies`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

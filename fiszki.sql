-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Wrz 05, 2024 at 05:08 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiszki`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(10) UNSIGNED NOT NULL,
  `Kategoria` varchar(50) NOT NULL,
  `obraz` varchar(50) NOT NULL,
  `Opis` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `Kategoria`, `obraz`, `Opis`) VALUES
(1, 'Jedzenie', 'jedzenie1.jpg', 'Kategoria zawierająca słówka związane z różnymi rodzajami jedzenia, potrawami i napojami.'),
(2, 'Kolory', 'kolory.jpg', 'Kategoria obejmująca słówka opisujące różne kolory i ich odcienie.'),
(3, 'Sport', 'sport.jpg', 'Kategoria obejmująca słówka związane ze sportem, dyscyplinami sportowymi i aktywnościami fizycznymi.'),
(4, 'Zwierzęta', 'zwierzęta.jpg', 'Kategoria zawierająca słówka opisujące różne gatunki zwierząt, ich cechy i środowisko naturalne.'),
(5, 'Zawody', 'zawody.jpg', 'Kategoria obejmująca słówka związane z różnymi zawodami, profesjami i pracą zawodową.'),
(6, 'Narzędzia', 'narzędzia.jpg', 'Kategoria zawierająca słówka opisujące różne rodzaje narzędzi, urządzeń i sprzętów używanych w różnych działaniach i pracach.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `progres`
--

CREATE TABLE `progres` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUrzytkownika` int(10) UNSIGNED NOT NULL,
  `idkategori` int(10) UNSIGNED NOT NULL,
  `id_ostatniejFiszki` int(10) UNSIGNED NOT NULL,
  `Data_` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `progres`
--

INSERT INTO `progres` (`id`, `idUrzytkownika`, `idkategori`, `id_ostatniejFiszki`, `Data_`) VALUES
(5, 4, 1, 1, '2024-09-05 09:51:23'),
(6, 4, 2, 31, '2024-09-05 09:54:02'),
(7, 3, 1, 1, '2024-09-05 07:24:30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recenzje`
--

CREATE TABLE `recenzje` (
  `id` int(10) UNSIGNED NOT NULL,
  `idKategorii` int(10) UNSIGNED NOT NULL,
  `login` varchar(50) NOT NULL,
  `tresc` varchar(50) NOT NULL,
  `Ocena` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `recenzje`
--

INSERT INTO `recenzje` (`id`, `idKategorii`, `login`, `tresc`, `Ocena`, `data`) VALUES
(1, 1, 'test', 'asdadas', 1, '2024-08-31 16:59:51'),
(2, 1, 'test', 'asdadas', 1, '2024-08-31 17:00:02'),
(3, 1, 'test', 'dasdadasda', 4, '2024-08-31 17:01:06'),
(4, 5, 'test', 'asdasdadasda', 5, '2024-08-31 17:01:15'),
(5, 5, 'test', 'sadadasd', 4, '2024-08-31 17:05:05'),
(6, 4, 'test', 'zajebiste', 4, '2024-09-03 07:59:59');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `slowo_kategoria`
--

CREATE TABLE `slowo_kategoria` (
  `idSlowa` int(10) UNSIGNED NOT NULL,
  `idKategorii` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `slowo_kategoria`
--

INSERT INTO `slowo_kategoria` (`idSlowa`, `idKategorii`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(86, 3),
(87, 3),
(88, 3),
(89, 3),
(90, 4),
(91, 4),
(92, 4),
(93, 4),
(94, 4),
(95, 4),
(96, 4),
(97, 4),
(98, 4),
(99, 4),
(100, 4),
(101, 4),
(102, 4),
(103, 4),
(104, 4),
(105, 4),
(106, 4),
(107, 4),
(108, 4),
(109, 4),
(110, 4),
(111, 4),
(112, 4),
(113, 4),
(114, 4),
(115, 4),
(116, 4),
(117, 4),
(118, 4),
(119, 4),
(120, 5),
(121, 5),
(122, 5),
(123, 5),
(124, 5),
(125, 5),
(126, 5),
(127, 5),
(128, 5),
(129, 5),
(130, 5),
(131, 5),
(132, 5),
(133, 5),
(134, 5),
(135, 5),
(136, 5),
(137, 5),
(138, 5),
(139, 5),
(140, 5),
(141, 5),
(142, 5),
(143, 5),
(144, 5),
(145, 5),
(146, 5),
(147, 5),
(148, 5),
(149, 6),
(150, 6),
(151, 6),
(152, 6),
(153, 6),
(154, 6),
(155, 6),
(156, 6),
(157, 6),
(158, 6),
(159, 6),
(160, 6),
(161, 6),
(162, 6),
(163, 6),
(164, 6),
(165, 6),
(166, 6),
(167, 6),
(168, 6),
(169, 6),
(170, 6),
(171, 6),
(172, 6),
(173, 6),
(174, 6),
(175, 6),
(176, 6),
(177, 6),
(179, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `słownik`
--

CREATE TABLE `słownik` (
  `id` int(10) UNSIGNED NOT NULL,
  `slowo_eng` varchar(50) NOT NULL,
  `slowo_pl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `słownik`
--

INSERT INTO `słownik` (`id`, `slowo_eng`, `slowo_pl`) VALUES
(1, 'apple', 'jabłko'),
(2, 'banana', 'banan'),
(3, 'cherry', 'wiśnia'),
(4, 'orange', 'pomarańcza'),
(5, 'pear', 'gruszka'),
(6, 'strawberry', 'truskawka'),
(7, 'pineapple', 'ananas'),
(8, 'grape', 'winogrono'),
(9, 'lemon', 'cytryna'),
(10, 'peach', 'brzoskwinia'),
(11, 'watermelon', 'arbuz'),
(12, 'melon', 'melon'),
(13, 'blueberry', 'borówka'),
(14, 'raspberry', 'malina'),
(15, 'kiwi', 'kiwi'),
(16, 'plum', 'śliwka'),
(17, 'apricot', 'morela'),
(18, 'fig', 'figa'),
(19, 'lime', 'limonka'),
(20, 'coconut', 'kokos'),
(21, 'mango', 'mango'),
(22, 'papaya', 'papaja'),
(23, 'avocado', 'awokado'),
(24, 'blackberry', 'jeżyna'),
(25, 'cranberry', 'żurawina'),
(26, 'nectarine', 'nektarynka'),
(27, 'persimmon', 'daktyle'),
(28, 'tangerine', 'mandarynka'),
(29, 'guava', 'gujawa'),
(30, 'dragonfruit', 'pitaja'),
(31, 'red', 'czerwony'),
(32, 'blue', 'niebieski'),
(33, 'green', 'zielony'),
(34, 'yellow', 'żółty'),
(35, 'orange', 'pomarańczowy'),
(36, 'purple', 'fioletowy'),
(37, 'pink', 'różowy'),
(38, 'brown', 'brązowy'),
(39, 'black', 'czarny'),
(40, 'white', 'biały'),
(41, 'gray', 'szary'),
(42, 'silver', 'srebrny'),
(43, 'gold', 'złoty'),
(44, 'maroon', 'karmazynowy'),
(45, 'turquoise', 'turkusowy'),
(46, 'lavender', 'lawendowy'),
(47, 'coral', 'koralowy'),
(48, 'indigo', 'indygo'),
(49, 'khaki', 'khaki'),
(50, 'magenta', 'magenta'),
(51, 'navy', 'granatowy'),
(52, 'olive', 'oliwkowy'),
(53, 'peach', 'brzoskwiniowy'),
(54, 'teal', 'zielonomodry'),
(55, 'violet', 'fioletowy'),
(56, 'aquamarine', 'akwamaryna'),
(57, 'beige', 'beżowy'),
(58, 'chartreuse', 'chartreuse'),
(59, 'crimson', 'karmazynowy'),
(60, 'cyan', 'cyjan'),
(61, 'football', 'piłka nożna'),
(62, 'basketball', 'koszykówka'),
(63, 'tennis', 'tenis'),
(64, 'swimming', 'pływanie'),
(65, 'baseball', 'baseball'),
(66, 'volleyball', 'siatkówka'),
(67, 'golf', 'golf'),
(68, 'cricket', 'krykiet'),
(69, 'rugby', 'rugby'),
(70, 'hockey', 'hokej'),
(71, 'boxing', 'boks'),
(72, 'wrestling', 'zapasy'),
(73, 'athletics', 'lekkoatletyka'),
(74, 'cycling', 'kolarstwo'),
(75, 'skiing', 'narciarstwo'),
(76, 'snowboarding', 'snowboarding'),
(77, 'surfing', 'surfing'),
(78, 'badminton', 'badminton'),
(79, 'table tennis', 'tenis stołowy'),
(80, 'judo', 'judo'),
(81, 'karate', 'karate'),
(82, 'taekwondo', 'taekwondo'),
(83, 'squash', 'squash'),
(84, 'archery', 'łucznictwo'),
(85, 'fencing', 'szermierka'),
(86, 'climbing', 'wspinaczka'),
(87, 'running', 'biegi'),
(88, 'yoga', 'joga'),
(89, 'pilates', 'pilates'),
(90, 'dog', 'pies'),
(91, 'cat', 'kot'),
(92, 'horse', 'koń'),
(93, 'rabbit', 'królik'),
(94, 'hamster', 'chomik'),
(95, 'guinea pig', 'świnka morska'),
(96, 'parrot', 'papuga'),
(97, 'goldfish', 'złota rybka'),
(98, 'turtle', 'żółw'),
(99, 'snake', 'wąż'),
(100, 'lizard', 'jaszczurka'),
(101, 'elephant', 'słoń'),
(102, 'lion', 'lew'),
(103, 'tiger', 'tygrys'),
(104, 'penguin', 'pingwin'),
(105, 'koala', 'koala'),
(106, 'panda', 'panda'),
(107, 'giraffe', 'żyrafa'),
(108, 'zebra', 'zebra'),
(109, 'crocodile', 'krokodyl'),
(110, 'dolphin', 'delfin'),
(111, 'whale', 'wieloryb'),
(112, 'octopus', 'ośmiornica'),
(113, 'seahorse', 'hipokamp'),
(114, 'monkey', 'małpa'),
(115, 'gorilla', 'goryl'),
(116, 'rhinoceros', 'nosorożec'),
(117, 'buffalo', 'bawół'),
(118, 'deer', 'jeleń'),
(119, 'fox', 'lis'),
(120, 'teacher', 'nauczyciel'),
(121, 'doctor', 'lekarz'),
(122, 'engineer', 'inżynier'),
(123, 'lawyer', 'prawnik'),
(124, 'accountant', 'księgowy'),
(125, 'chef', 'kucharz'),
(126, 'artist', 'artysta'),
(127, 'writer', 'pisarz'),
(128, 'actor', 'aktor'),
(129, 'musician', 'muzyk'),
(130, 'athlete', 'sportowiec'),
(131, 'pilot', 'pilot'),
(132, 'firefighter', 'strażak'),
(133, 'police officer', 'policjant'),
(134, 'nurse', 'pielęgniarka'),
(135, 'scientist', 'naukowiec'),
(136, 'entrepreneur', 'przedsiębiorca'),
(137, 'dentist', 'dentysta'),
(138, 'mechanic', 'mechanik'),
(139, 'electrician', 'elektryk'),
(140, 'plumber', 'hydraulik'),
(141, 'soldier', 'żołnierz'),
(142, 'singer', 'piosenkarz'),
(143, 'architect', 'architekt'),
(144, 'journalist', 'dziennikarz'),
(145, 'psychologist', 'psycholog'),
(146, 'waiter/waitress', 'kelner/kelnerka'),
(147, 'driver', 'kierowca'),
(148, 'gardener', 'ogrodnik'),
(149, 'hammer', 'młotek'),
(150, 'screwdriver', 'śrubokręt'),
(151, 'wrench', 'klucz'),
(152, 'pliers', 'kleszcze'),
(153, 'saw', 'piła'),
(154, 'drill', 'wiertarka'),
(155, 'tape measure', 'miarka'),
(156, 'level', 'poziomica'),
(157, 'chisel', 'dłuto'),
(158, 'pliers', 'szczypce'),
(159, 'file', 'pilnik'),
(160, 'trowel', 'kielnia'),
(161, 'wheelbarrow', 'taczka'),
(162, 'screw', 'śruba'),
(163, 'nail', 'gwóźdź'),
(164, 'bolt', 'śruba'),
(165, 'nut', 'nakrętka'),
(166, 'hacksaw', 'piła do metalu'),
(167, 'axe', 'topór'),
(168, 'wire cutter', 'obcinacz do drutu'),
(169, 'sander', 'szlifierka'),
(170, 'jigsaw', 'piła tarczowa'),
(171, 'sickle', 'sierp'),
(172, 'rake', 'grabie'),
(173, 'shovel', 'łopata'),
(174, 'crowbar', 'łom'),
(175, 'screw hook', 'hak śrubowy'),
(176, 'vice', 'imadło'),
(177, 'brush', 'szczotka'),
(179, 'apple', 'jabłko');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rola` varchar(50) NOT NULL DEFAULT 'user',
  `profilowe` varchar(50) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `rola`, `profilowe`, `data`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.pl', 'admin', 'profilowe6.jpg', '2024-09-05 07:02:49'),
(4, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@21.das', 'user', 'dzban_szarawy.jpg', '2024-07-03 10:16:55');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wyniki`
--

CREATE TABLE `wyniki` (
  `id` int(10) UNSIGNED NOT NULL,
  `idKategorii` int(10) UNSIGNED NOT NULL,
  `idUzytkownika` int(10) UNSIGNED NOT NULL,
  `punkty` int(11) NOT NULL,
  `ocena` int(2) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wyniki`
--

INSERT INTO `wyniki` (`id`, `idKategorii`, `idUzytkownika`, `punkty`, `ocena`, `data`) VALUES
(20, 1, 4, 12, 3, '2024-09-04 21:33:48'),
(21, 3, 4, 2, 1, '2024-09-05 06:46:01'),
(22, 1, 4, 6, 1, '2024-09-05 08:08:58'),
(23, 1, 4, 4, 1, '2024-09-05 09:59:17'),
(24, 2, 4, 10, 2, '2024-09-05 10:00:23');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zapamientaj`
--

CREATE TABLE `zapamientaj` (
  `id` int(10) UNSIGNED NOT NULL,
  `idslowa` int(10) UNSIGNED DEFAULT NULL,
  `idUzytkownika` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `zapamientaj`
--

INSERT INTO `zapamientaj` (`id`, `idslowa`, `idUzytkownika`) VALUES
(7, 179, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgłoszenia`
--

CREATE TABLE `zgłoszenia` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUzytkownika` int(10) UNSIGNED NOT NULL,
  `idKategorii` int(10) UNSIGNED NOT NULL,
  `Opis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `progres`
--
ALTER TABLE `progres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`idUrzytkownika`),
  ADD KEY `category_id` (`idkategori`),
  ADD KEY `last_studied_flashcard_id` (`id_ostatniejFiszki`);

--
-- Indeksy dla tabeli `recenzje`
--
ALTER TABLE `recenzje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKategorii` (`idKategorii`);

--
-- Indeksy dla tabeli `slowo_kategoria`
--
ALTER TABLE `slowo_kategoria`
  ADD PRIMARY KEY (`idSlowa`,`idKategorii`),
  ADD KEY `idKategorii` (`idKategorii`);

--
-- Indeksy dla tabeli `słownik`
--
ALTER TABLE `słownik`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `wyniki`
--
ALTER TABLE `wyniki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKategorii` (`idKategorii`),
  ADD KEY `idUzytkownika` (`idUzytkownika`);

--
-- Indeksy dla tabeli `zapamientaj`
--
ALTER TABLE `zapamientaj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKategorii` (`idslowa`),
  ADD KEY `idUzytkownika` (`idUzytkownika`);

--
-- Indeksy dla tabeli `zgłoszenia`
--
ALTER TABLE `zgłoszenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUzytkownika` (`idUzytkownika`),
  ADD KEY `idKategorii` (`idKategorii`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `progres`
--
ALTER TABLE `progres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `recenzje`
--
ALTER TABLE `recenzje`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `słownik`
--
ALTER TABLE `słownik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wyniki`
--
ALTER TABLE `wyniki`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `zapamientaj`
--
ALTER TABLE `zapamientaj`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zgłoszenia`
--
ALTER TABLE `zgłoszenia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `progres`
--
ALTER TABLE `progres`
  ADD CONSTRAINT `progres_ibfk_1` FOREIGN KEY (`idUrzytkownika`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `progres_ibfk_2` FOREIGN KEY (`idkategori`) REFERENCES `kategorie` (`id`),
  ADD CONSTRAINT `progres_ibfk_3` FOREIGN KEY (`id_ostatniejFiszki`) REFERENCES `słownik` (`id`);

--
-- Constraints for table `recenzje`
--
ALTER TABLE `recenzje`
  ADD CONSTRAINT `recenzje_ibfk_1` FOREIGN KEY (`idKategorii`) REFERENCES `kategorie` (`id`);

--
-- Constraints for table `slowo_kategoria`
--
ALTER TABLE `slowo_kategoria`
  ADD CONSTRAINT `slowo_kategoria_ibfk_1` FOREIGN KEY (`idSlowa`) REFERENCES `słownik` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `slowo_kategoria_ibfk_2` FOREIGN KEY (`idKategorii`) REFERENCES `kategorie` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wyniki`
--
ALTER TABLE `wyniki`
  ADD CONSTRAINT `wyniki_ibfk_1` FOREIGN KEY (`idUzytkownika`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `wyniki_ibfk_2` FOREIGN KEY (`idKategorii`) REFERENCES `kategorie` (`id`);

--
-- Constraints for table `zapamientaj`
--
ALTER TABLE `zapamientaj`
  ADD CONSTRAINT `zapamientaj_ibfk_2` FOREIGN KEY (`idUzytkownika`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `zapamientaj_ibfk_3` FOREIGN KEY (`idslowa`) REFERENCES `słownik` (`id`);

--
-- Constraints for table `zgłoszenia`
--
ALTER TABLE `zgłoszenia`
  ADD CONSTRAINT `zgłoszenia_ibfk_1` FOREIGN KEY (`idKategorii`) REFERENCES `kategorie` (`id`),
  ADD CONSTRAINT `zgłoszenia_ibfk_2` FOREIGN KEY (`idUzytkownika`) REFERENCES `uzytkownicy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

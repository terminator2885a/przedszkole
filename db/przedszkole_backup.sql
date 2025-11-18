-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 18, 2025 at 03:52 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `przedszkole`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `id_grupy` int(11) NOT NULL,
  `nazwa_grupy` varchar(20) NOT NULL,
  `opis_grupy` text NOT NULL,
  `wychowawca1` int(11) NOT NULL,
  `wychowawca2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `grupy`
--

INSERT INTO `grupy` (`id_grupy`, `nazwa_grupy`, `opis_grupy`, `wychowawca1`, `wychowawca2`) VALUES
(1, 'Leśne Duszki', 'Grupa najmłodsza, pełna energii i ciekawości świata', 2, 3),
(2, 'Zaczarowane Elfy', 'Grupa średnia, kreatywna i pełna wyobraźni', 4, 5),
(3, 'Mądre Gnomy', 'Grupa najstarsza, przygotowująca się do szkoły', 6, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komunikaty`
--

CREATE TABLE `komunikaty` (
  `id_komunikatu` int(11) NOT NULL,
  `data_komunikatu` date DEFAULT NULL,
  `tresc_komunikatu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `id_nauczyciela` int(11) NOT NULL,
  `nazwisko` varchar(20) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `ranga` int(11) NOT NULL,
  `nr_telefonu` varchar(9) NOT NULL,
  `e_mail` varchar(50) NOT NULL,
  `login` varchar(8) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `nauczyciele`
--

INSERT INTO `nauczyciele` (`id_nauczyciela`, `nazwisko`, `imie`, `pesel`, `ranga`, `nr_telefonu`, `e_mail`, `login`, `password`) VALUES
(1, 'Zawadzka', 'Joanna', '56121894848', 1, '123456789', 'j.zawadzka@gmail.com', 'dyr158af', '$2y$10$E9GIEjCE0TAyem8tiye8zebWAHPzbhU4lRbV/U7xKUVO2DoZBOHHi'),
(2, 'Wierzbicka', 'Anna', '82031512345', 2, '501123456', 'a.wierzbicka@gmail.com', 'anna8203', '$2y$10$F5aRQmeGxj1rsCH/hXmtSuQug7hnGIGkU87cbWIcmINK.anJst5q6'),
(3, 'Kaczmarek', 'Marta', '85071254321', 2, '502234567', 'm.kaczmarek@gmail.com', 'marta850', '$2y$10$8t8GxSGTX.vpvKcQRuQIneIhXBls858BI.QcIb0228QwtSC9M.NhW'),
(4, 'Maj', 'Karolina', '87092167890', 2, '503345678', 'k.maj@gmail.com', 'karo8709', '$2y$10$tEHycMhfSqQZ9h5z8l5O6eqfOph0GfgPLqFmkbnejeH8hk7Kn4rXO'),
(5, 'Sokołowska', 'Dorota', '86010498765', 2, '504456789', 'd.sokolowska@gmail.com', 'doro8601', '$2y$10$3p7CJMeU8OL9ysBoy5fIkudLjrHps8VsFqXTMZRMlFltoTc5NpiKi'),
(6, 'Nowak', 'Elżbieta', '79081245678', 2, '505567890', 'e.nowak@gmail.com', 'elzb7908', '$2y$10$yOq8Y9W8VlQ5qNSRgI.tOucepH6e1TrRwOJ.k5Gw3P9xlFNR5T2sG'),
(7, 'Kowalska', 'Julia', '90010123456', 3, '506678901', 'j.kowalska@gmail.com', 'julia900', '$2y$10$0h3WP8Qx6O/DCiYTDxNZSOJrrVB08zntsY5KNLyV9gFbfGGbu9ccm'),
(8, 'Tomala', 'Agnieszka', '88050534567', 4, '507789012', 'a.tomala@gmail.com', 'agni8805', '$2y$10$I11DpSY.PiOqO1JBw8KwO.YxgEPInj2fP10PTpa/w8CI764BiWQSS'),
(9, 'Zielińska', 'Monika', '87030345678', 5, '508890123', 'm.zielinska@gmail.com', 'moni8703', '$2y$10$7jXb0CDS5ryxTV6IozbxPub7MYCToLxPt5TkJCOm3rz7Du3ZYAZja'),
(10, 'Bartosik', 'Paulina', '91021467890', 6, '509901234', 'p.bartosik@gmail.com', 'pauli910', '$2y$10$Qx7ZGXIawoOm4V6VzazUKOP7KZ0XbQczSgTaAR/c8mmdDcFvIExP6');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedszkolaki`
--

CREATE TABLE `przedszkolaki` (
  `id_przedszkolaka` int(11) NOT NULL,
  `nazwisko` varchar(20) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `grupa` int(11) NOT NULL,
  `imiona_rodzicow` varchar(50) NOT NULL,
  `alergeny` varchar(100) DEFAULT NULL,
  `religia` tinyint(1) NOT NULL,
  `nr_telefonu` varchar(9) NOT NULL,
  `e_mail` varchar(20) NOT NULL,
  `dlug` int(11) NOT NULL,
  `login` varchar(8) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rangi`
--

CREATE TABLE `rangi` (
  `id_rangi` int(11) NOT NULL,
  `nazwa_rangi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `rangi`
--

INSERT INTO `rangi` (`id_rangi`, `nazwa_rangi`) VALUES
(1, 'dyrektor'),
(2, 'wychowawca'),
(3, 'nauczyciel języka angielskiego'),
(4, 'nauczyciel religii'),
(5, 'nauczyciel muzyki i rytmiki'),
(6, 'pomoc nauczycielska');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci`
--

CREATE TABLE `wiadomosci` (
  `id_wiadomosci` int(11) NOT NULL,
  `nadawca` text NOT NULL,
  `adresat` text NOT NULL,
  `tresc_wiadomosci` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`id_grupy`),
  ADD KEY `wychowawca1` (`wychowawca1`),
  ADD KEY `wychowawca2` (`wychowawca2`);

--
-- Indeksy dla tabeli `komunikaty`
--
ALTER TABLE `komunikaty`
  ADD PRIMARY KEY (`id_komunikatu`);

--
-- Indeksy dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD PRIMARY KEY (`id_nauczyciela`),
  ADD KEY `ranga` (`ranga`);

--
-- Indeksy dla tabeli `przedszkolaki`
--
ALTER TABLE `przedszkolaki`
  ADD PRIMARY KEY (`id_przedszkolaka`),
  ADD KEY `grupa` (`grupa`);

--
-- Indeksy dla tabeli `rangi`
--
ALTER TABLE `rangi`
  ADD PRIMARY KEY (`id_rangi`);

--
-- Indeksy dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD PRIMARY KEY (`id_wiadomosci`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id_grupy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `komunikaty`
--
ALTER TABLE `komunikaty`
  MODIFY `id_komunikatu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `przedszkolaki`
--
ALTER TABLE `przedszkolaki`
  MODIFY `id_przedszkolaka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `id_wiadomosci` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grupy`
--
ALTER TABLE `grupy`
  ADD CONSTRAINT `fk_wychowawca1` FOREIGN KEY (`wychowawca1`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `fk_wychowawca2` FOREIGN KEY (`wychowawca2`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `grupy_ibfk_1` FOREIGN KEY (`wychowawca1`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `grupy_ibfk_2` FOREIGN KEY (`wychowawca2`) REFERENCES `nauczyciele` (`id_nauczyciela`);

--
-- Constraints for table `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD CONSTRAINT `nauczyciele_ibfk_1` FOREIGN KEY (`ranga`) REFERENCES `rangi` (`id_rangi`);

--
-- Constraints for table `przedszkolaki`
--
ALTER TABLE `przedszkolaki`
  ADD CONSTRAINT `przedszkolaki_ibfk_1` FOREIGN KEY (`grupa`) REFERENCES `grupy` (`id_grupy`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

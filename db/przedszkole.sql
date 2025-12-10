-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 11:10 PM
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
-- Struktura tabeli dla tabeli `artykuly`
--

CREATE TABLE `artykuly` (
  `id_artykulu` int(11) NOT NULL,
  `autor_artykulu` int(11) NOT NULL,
  `tytul_artykulu` text NOT NULL,
  `tresc_artykulu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `artykuly`
--

INSERT INTO `artykuly` (`id_artykulu`, `autor_artykulu`, `tytul_artykulu`, `tresc_artykulu`) VALUES
(1, 2, 'Leśne Duszki – mali odkrywcy natury', '<h2>Leśne Duszki – mali odkrywcy natury</h2>\r\n<p>Leśne Duszki to grupa dzieci z Przedszkola Małe Skrzaty, która każdego dnia wyrusza na spotkanie z przyrodą. Ich nazwa nie jest przypadkowa – dzieci czują się jak małe duszki, które potrafią dostrzec piękno w każdym liściu, kamyku czy kropli rosy. W tym roku wychowawcy przygotowali dla nich cykl zajęć „Sekrety lasu”, podczas których dzieci poznawały rośliny i zwierzęta, a także uczyły się, jak chronić środowisko.</p>\r\n<p>Podczas wycieczki do pobliskiego lasu Leśne Duszki miały okazję zobaczyć mrowisko, posłuchać śpiewu ptaków i zebrać różnorodne liście. W sali przedszkolnej powstał zielnik, w którym dzieci umieszczały swoje znaleziska. Nie zabrakło też zajęć plastycznych – dzieci tworzyły figurki z kasztanów i żołędzi, a także malowały obrazy inspirowane naturą.</p>\r\n<p>Największą atrakcją była ścieżka edukacyjna, na której dzieci dowiedziały się, że w Polsce rosną drzewa tak ogromne, iż potrzeba kilku osób, aby je objąć. Leśne Duszki wróciły pełne wrażeń i z przekonaniem, że przyroda jest naszym wspólnym skarbem.</p>\r\n'),
(2, 4, 'Zaczarowane Elfy – magia wyobraźni', '<h2>Zaczarowane Elfy – magia wyobraźni</h2>\r\n<p>Zaczarowane Elfy to grupa, w której króluje fantazja i kreatywność. Dzieci uwielbiają opowieści, bajki i zabawy teatralne. W tym roku przygotowały przedstawienie „Podróż do krainy elfów”, które odbyło się w sali przedszkolnej. Mali aktorzy wcielili się w role wróżek, rycerzy i leśnych zwierząt, a ich występ został nagrodzony gromkimi brawami.</p>\r\n<p>Praca nad spektaklem była okazją do rozwijania wyobraźni, ćwiczenia pamięci i nauki odwagi. Dzieci samodzielnie przygotowały stroje i rekwizyty, a scenografia powstała dzięki wspólnym wysiłkom całej grupy. Zaczarowane Elfy przekonały się, że współpraca prowadzi do sukcesu.</p>\r\n<p>Oprócz teatru dzieci uczestniczyły w warsztatach plastycznych, podczas których tworzyły magiczne różdżki i kolorowe skrzydełka. Zajęcia rozwijały ich kreatywność i pozwalały przenieść się do świata baśni. Zaczarowane Elfy już planują kolejne przedstawienie, tym razem inspirowane legendami o smokach.</p>\r\n'),
(3, 5, 'Mądre Gnomy – mali naukowcy', '<h2>Mądre Gnomy – mali naukowcy</h2>\r\n<p>Mądre Gnomy to grupa, która szczególnie interesuje się nauką i eksperymentami. W ramach projektu „Mały naukowiec” dzieci poznawały podstawowe prawa fizyki i chemii w prosty, przystępny sposób. Największe emocje wzbudził eksperyment z wulkanem z sody i octu – dzieci z zachwytem obserwowały, jak z przygotowanej makiety wybucha kolorowa lawa.</p>\r\n<p>Kolejnym doświadczeniem było tworzenie tęczy w szklance przy użyciu cukru i barwników spożywczych. Dzięki takim zabawom przedszkolaki uczyły się cierpliwości, dokładności i logicznego myślenia. Mądre Gnomy przygotowały również własną wystawę naukową, na której zaprezentowały rodzicom swoje eksperymenty.</p>\r\n<p>Spotkanie zakończyło się wspólnym quizem, w którym dzieci mogły sprawdzić zdobytą wiedzę. Projekt pokazał, że nauka może być fascynującą przygodą, a Mądre Gnomy zyskały miano prawdziwych odkrywców.</p>\r\n'),
(4, 9, 'Wspólna wyprawa wszystkich grup', '<h2>Wspólna wyprawa wszystkich grup</h2>\r\n<p>Przedszkole Małe Skrzaty zorganizowało wyjątkową wycieczkę, w której uczestniczyły wszystkie grupy: Leśne Duszki, Zaczarowane Elfy i Mądre Gnomy. Celem wyprawy był park edukacyjny, gdzie dzieci mogły jednocześnie poznawać przyrodę, bawić się i uczyć.</p>\r\n<p>Leśne Duszki skupiły się na obserwacji roślin i zwierząt, Zaczarowane Elfy przygotowały krótką inscenizację o przyjaźni, a Mądre Gnomy przeprowadziły mini eksperymenty z wodą i światłem. Wspólne działania pokazały, jak różnorodne zainteresowania mogą się uzupełniać i tworzyć bogaty program edukacyjny.</p>\r\n<p>Na zakończenie dnia odbyło się ognisko, podczas którego dzieci śpiewały piosenki i dzieliły się wrażeniami. Wychowawcy podkreślali, że takie wyjazdy integrują grupy i uczą współpracy. Dzieci wróciły do przedszkola pełne radości i nowych doświadczeń.</p>\r\n'),
(5, 1, 'Święto Przedszkola Małe Skrzaty', '<h2>Święto Przedszkola Małe Skrzaty</h2>\r\n<p>Wielkim wydarzeniem w życiu przedszkola było coroczne Święto Małych Skrzatów. Podczas uroczystości każda grupa zaprezentowała swoje talenty. Leśne Duszki przygotowały wystawę prac plastycznych inspirowanych naturą, Zaczarowane Elfy wystąpiły w krótkiej bajce teatralnej, a Mądre Gnomy zaprezentowały pokaz eksperymentów.</p>\r\n<p>Rodzice mieli okazję zobaczyć, jak wiele dzieci nauczyły się w ciągu roku. Uroczystość była także okazją do wspólnej zabawy – odbyły się konkursy, tańce i gry zespołowe. Największą atrakcją okazał się pokaz „Top model skrzatów”, w którym dzieci prezentowały stroje przygotowane z materiałów recyklingowych.</p>\r\n<p>Święto zakończyło się wspólnym śpiewem i poczęstunkiem. Wychowawcy podkreślali, że takie wydarzenia budują więź między dziećmi, rodzicami i nauczycielami. Przedszkole Małe Skrzaty po raz kolejny udowodniło, że nauka i zabawa mogą iść w parze, tworząc niezapomniane wspomnienia.</p>\r\n');

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
(1, 'Leśne Duszki', 'Leśne Duszki to najmłodsza grupa w naszym przedszkolu, pełna radości i ciekawości świata. Dzieci uczą się tu poprzez zabawę, odkrywając pierwsze tajemnice przyrody i otaczającego środowiska. Codzienne aktywności rozwijają ich sprawność ruchową oraz umiejętności społeczne. W grupie panuje ciepła, przyjazna atmosfera sprzyjająca adaptacji i poczuciu bezpieczeństwa. To idealne miejsce na rozpoczęcie przedszkolnej przygody.', 2, 3),
(2, 'Zaczarowane Elfy', 'Zaczarowane Elfy to grupa średniaków, które z entuzjazmem poznają świat liter, cyfr i prostych zasad. Dzieci rozwijają tu swoją kreatywność poprzez zajęcia plastyczne, muzyczne i ruchowe. Ważnym elementem jest nauka współpracy i budowanie przyjaźni. Program dostosowany jest do ich rosnących możliwości poznawczych i emocjonalnych. To czas, kiedy mali odkrywcy stają się coraz bardziej samodzielni.', 4, 5),
(3, 'Mądre Gnomy', 'Mądre Gnomy to najstarsza grupa, przygotowująca dzieci do rozpoczęcia nauki w szkole. Podopieczni rozwijają tu umiejętności logicznego myślenia, koncentracji i samodzielności. Zajęcia edukacyjne są urozmaicone i wspierają wszechstronny rozwój. Dzieci uczą się odpowiedzialności, współpracy i radzenia sobie w nowych sytuacjach. To grupa, w której mali uczniowie stają się gotowi na kolejny etap edukacyjnej podróży.', 6, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komunikaty`
--

CREATE TABLE `komunikaty` (
  `id_komunikatu` int(11) NOT NULL,
  `data_komunikatu` date DEFAULT NULL,
  `tresc_komunikatu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `komunikaty`
--

INSERT INTO `komunikaty` (`id_komunikatu`, `data_komunikatu`, `tresc_komunikatu`) VALUES
(2, '2025-12-02', '<p>Dyrekcja Przedszkola „Małe Skrzaty” informuje, że w dniu <strong>15 grudnia 2025 roku (wtorek)</strong> o godzinie <strong>17:00</strong> odbędzie się zebranie z rodzicami wszystkich grup: Leśne Duszki, Zaczarowane Elfy oraz Mądre Gnomy.</p>\r\n<p>Podczas spotkania omówione zostaną:</p>\r\n<ul>\r\n<li>podsumowanie działań wychowawczych i edukacyjnych w pierwszym semestrze,</li>\r\n<li>plan zajęć i wydarzeń na okres zimowy,</li>\r\n<li>sprawy organizacyjne dotyczące ferii oraz wycieczek.</li>\r\n</ul>\r\n<p>Serdecznie zapraszamy wszystkich rodziców i opiekunów do udziału w spotkaniu. Obecność jest bardzo ważna dla dalszej współpracy i rozwoju naszych dzieci.</p>'),
(3, '2025-12-02', '<p>Dyrekcja Przedszkola „Małe Skrzaty” zaprasza na <strong>Jasełka Bożonarodzeniowe</strong>, które odbędą się w dniu <strong>20 grudnia 2025 roku (sobota)</strong> o godzinie <strong>15:00</strong> w sali gimnastycznej przedszkola.</p>\n<p>W programie:</p>\n<ul>\n<li>występy artystyczne dzieci z grup Leśne Duszki, Zaczarowane Elfy i Mądre Gnomy,</li>\n<li>wspólne kolędowanie,</li>\n<li>kiermasz świąteczny przygotowany przez dzieci i wychowawców.</li>\n</ul>\n<p>Dochód z kiermaszu zostanie przeznaczony na doposażenie sal dydaktycznych. Liczymy na Państwa obecność i wspólne świętowanie w atmosferze radości i życzliwości.</p>');

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
(1, 'Zawadzka', 'Joanna', '56121894848', 1, '123456789', 'j.zawadzka@gmail.com', 'dyr158af', '$2y$10$B4z4p6.jilrkZ1APo/xsJ.t.j/HyMD1lTHs9S0HYl6KPf1M2ATb7u'),
(2, 'Wierzbicka', 'Anna', '82031512345', 2, '501123456', 'a.wierzbicka@gmail.com', 'anna8203', '$2y$10$HIYGyWmmod/s3574S7.vYu0K/vvc7b62EEg5M.yem.4pG/ziuJsjW'),
(3, 'Kaczmarek', 'Marta', '85071254321', 2, '502234567', 'm.kaczmarek@gmail.com', 'marta850', '$2y$10$8t8GxSGTX.vpvKcQRuQIneIhXBls858BI.QcIb0228QwtSC9M.NhW'),
(4, 'Maj', 'Karolina', '87092167890', 2, '503345678', 'k.maj@gmail.com', 'karo8709', '$2y$10$tEHycMhfSqQZ9h5z8l5O6eqfOph0GfgPLqFmkbnejeH8hk7Kn4rXO'),
(5, 'Sokołowska', 'Dorota', '86010498765', 2, '504456789', 'd.sokolowska@gmail.com', 'doro8601', '$2y$10$3p7CJMeU8OL9ysBoy5fIkudLjrHps8VsFqXTMZRMlFltoTc5NpiKi'),
(6, 'Nowak', 'Elżbieta', '79081245678', 2, '505567890', 'e.nowak@gmail.com', 'elzb7908', '$2y$10$n2Y5N35qhv2pPJup4YolnelM8ZqdDdZDf8kwB1.nQIOXpvYpng9lm'),
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
  `nazwisko` text NOT NULL,
  `imie` text NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `grupa` int(11) DEFAULT NULL,
  `imiona_rodzicow` text NOT NULL,
  `alergeny` text NOT NULL,
  `religia` tinyint(1) DEFAULT NULL,
  `e_mail` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `przedszkolaki`
--

INSERT INTO `przedszkolaki` (`id_przedszkolaka`, `nazwisko`, `imie`, `pesel`, `grupa`, `imiona_rodzicow`, `alergeny`, `religia`, `e_mail`, `login`, `password`) VALUES
(1, 'Ogrodowczyk', 'Teresa', '22322672723', 2, 'Jędrzej Ogrodowczyk, Faustyna Ogrodowczyk', 'Gluten, Seler, Ryba', 1, 'f.ogrodowczyk@wp.pl', 'togrodowczyk', '$2y$10$iOIZjJZjJ0cbDNeakvIuBO6Hjih7ZCnAjr3Z/m40ePNU8ZLA8JtZy'),
(2, 'Dynur', 'Jeremi', '22322979703', 2, 'Otto Dynur, Helena Dynur', 'Sezam, Jajko, Ryba', 0, 'h.dynur@onet.pl', 'jdynur', '$2y$10$PQ/Pt0RylNRpJ.aVz00pgecDKBOd64RwobInu855/3S96lOPNRCby'),
(3, 'Korzyn', 'Zofia', '21312160611', 3, 'Szymon Korzyn, Maria Korzyn', 'Gluten, Seler', 1, 'korzyn.szykon@interia.pl', 'zkorzyn', '$2y$10$dWN7U.FKBl4XroyjoM7cIuogeAJzn2arARsqe/4GBedGJwoyPn/A6'),
(4, 'Biełasiewicz', 'Dobromiła', '22302441765', 2, 'Patryk Biełasiewicz, Weronika Biełasiewicz', '', 1, 'weronika.bialasewicz1889@gmail.com', 'dbialasewicz', '$2y$10$lrqnzORe1A7nt7neo5JZ0ehRQE5.CH7Fj2IlD2hre4NX0Zi1gvjXO'),
(5, 'Leś', 'Zuzanna', '22290590030', 1, 'Kajetan Leś, Władysława Leś', 'Dwutlenek siarki i siarczany, Seler', 0, 'wles@wp.pl', 'zles', '$2y$10$gQkJXoe3TTSkHeNcXbHElOZyRZZYu9nX/Ck/473gtWGDgeB7FesWq'),
(6, 'Buszyniewicz', 'Emilia', '20233080871', 3, 'Maksymilian Buszyniewicz, Dobrochna Buszyniewicz', 'Jajko', 1, 'buszyniewicz.maksymilian@gmail.com', 'ebuszyniewicz', '$2y$10$mjHDYGFRGZvUMf5iMuSynuE.bo4xenyPbqaSLJndsMCydUshXS.Vq'),
(7, 'Kalużny', 'Marcel', '21232461863', 3, 'Mariusz Kalużny, Monika Kalużna', 'Płeć żeńska, Access', 0, 'm.kaluzny@gmail.com', 'mkaluzny', '$2y$10$N5O4T1zmyEgGTJLLVmZFd.kAMQZYUd4eiZKBWcwnufaTir9YIZOVW'),
(8, 'Komisarski', 'Piotr', '23270488712', 2, 'Walery Komisarski, Anna Komisarska', 'Seler, Gluten, Laktoza', 0, 'a.komisarska@interia.pl', 'pkomisarski', '$2y$10$GYBuwbQ8xCOAapgheW996.u7OIvLO/fzEH5e29pC/OhG/RA3RrkJG'),
(9, 'Gogulska', 'Kaja', '21290196468', 2, 'Piotr Gogulski, Karolina Gogulska', 'Talibowie', 0, 'p.gogulski@onet.pl', 'kgogulska', '$2y$10$I4s4SLXmy8Pb9/WX3.J60enc71qZY4e.HkWlSUMgmtKnKENX2jH8a');

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
  `data_wyslania` date NOT NULL,
  `nadawca` text NOT NULL,
  `odbiorca` text NOT NULL,
  `temat` text NOT NULL,
  `tresc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `wiadomosci`
--

INSERT INTO `wiadomosci` (`id_wiadomosci`, `data_wyslania`, `nadawca`, `odbiorca`, `temat`, `tresc`) VALUES
(1, '2025-12-10', 'p007', 'n001', 'Podziękowanie', '<p>Szanowna Pani Dyrektor,</p>\r\n<p>Chciałabym serdecznie podziękować za organizację Jesiennego Festynu Rodzinnego w naszym przedszkolu. Było to wydarzenie pełne radości, które pozwoliło nam – rodzicom – spędzić czas razem z dziećmi w wyjątkowej atmosferze.</p>\r\n<p>Doceniam zaangażowanie całej kadry w przygotowanie atrakcji i poczęstunku. Dzieci wróciły do domu szczęśliwe i pełne wrażeń, a dla nas, rodziców, była to okazja do lepszego poznania się i integracji.</p>\r\n<p>Mam nadzieję, że podobne inicjatywy będą kontynuowane w przyszłości, ponieważ budują poczucie wspólnoty i wzmacniają więź między rodzinami a przedszkolem.</p>\r\n<p>Z wyrazami szacunku,</p>\r\n<p>Monika Kalużna</p>\r\n');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `artykuly`
--
ALTER TABLE `artykuly`
  ADD PRIMARY KEY (`id_artykulu`),
  ADD KEY `autor_artykulu` (`autor_artykulu`);

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
  ADD UNIQUE KEY `login` (`login`) USING HASH,
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
-- AUTO_INCREMENT for table `artykuly`
--
ALTER TABLE `artykuly`
  MODIFY `id_artykulu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id_grupy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komunikaty`
--
ALTER TABLE `komunikaty`
  MODIFY `id_komunikatu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `przedszkolaki`
--
ALTER TABLE `przedszkolaki`
  MODIFY `id_przedszkolaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `id_wiadomosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artykuly`
--
ALTER TABLE `artykuly`
  ADD CONSTRAINT `artykuly_ibfk_1` FOREIGN KEY (`autor_artykulu`) REFERENCES `nauczyciele` (`id_nauczyciela`);

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

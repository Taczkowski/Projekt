-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 11:22 PM
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
-- Database: `pdiddypizza`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `daneosobowe`
--

CREATE TABLE `daneosobowe` (
  `ID` int(11) NOT NULL,
  `Imie` varchar(100) DEFAULT NULL,
  `Nazwisko` varchar(100) DEFAULT NULL,
  `miejscowosc` varchar(255) DEFAULT NULL,
  `ulica` varchar(255) DEFAULT NULL,
  `numertelefonu` int(11) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daneosobowe`
--

INSERT INTO `daneosobowe` (`ID`, `Imie`, `Nazwisko`, `miejscowosc`, `ulica`, `numertelefonu`, `Email`, `profile_picture`) VALUES
(2, 'test', 'test', 'dzianis', 'pindele 32 b', 543345534, '0', NULL),
(3, 'pupu', 'pupu', 'cos', 'cos', 123456789, '0', NULL),
(14, 'cos', 'asd', 'as', 'as', 123123123, 'asd@asd.asd', './assets/avatar1.png'),
(16, 'asd', 'asd', 'asd', 'asd', 123456789, 'test@test.test', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

CREATE TABLE `konta` (
  `ID` int(11) NOT NULL,
  `Login` varchar(100) DEFAULT NULL,
  `Passwd` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konta`
--

INSERT INTO `konta` (`ID`, `Login`, `Passwd`, `Email`) VALUES
(2, 'test', '81dc9bdb52d04dc20036dbd8313ed055', 'test@test.pl'),
(3, 'test2', '$2y$10$sojz.uYe7q0ubd6Nr5wZDeRw/eW2OmJ0sGO.VATgeDT9CaaHwUY.G', 'test2@test.com'),
(4, '1', '$2y$10$fJSzhd2UWwiKv/Ls3lA14.VianA4YtSds0tc7Rmi5ziAh2SowsASm', '1@1'),
(5, '2', '2@2', '$2y$10$LUIYFsNiZdiyeQ7c8YveGekFuNDsTUKw0vx60l6Y2rGPK0BPEQEU2'),
(6, '3', '$2y$10$sL4jfBo7sN18637KFOmyHO4EvdVxpRQ8N9NlzZXkAru/COG9SigNm', '3@3'),
(7, 'buc', '$2y$10$bAbil/v1s65Gt6odsB8ebu78YksAm5yEAV0zFK/OWA3CdZBsJzHDu', 'buc@buc.pl'),
(8, 'jager', '$2y$10$RKMmPZe7QdyqUt53OpDV7OhwbI1MyAnYMo.L1a1B5LJEbmoGtLM1q', 'jager@jager.com'),
(9, 'buc2', '$2y$10$12fSFku2eKACrHgCk5APneKRGidiE3x1hSQ55JquY9amfN9TrvuPe', 'buc2@buc2.com'),
(10, 'pawian', '$2y$10$WS8HiEB8rPmzSfVzjg4EhejeSwVFA8.3LEs4bxb.rJjZgPj9IOUwm', 'pawian@pawian.com'),
(11, 'dupa', '$2y$10$wCcA9W0ui7BqqlpXoJ4cw.wbN6cJTB4O9jQkGDbzEOn1GiaP8wd52', 'jasia@gmail.com'),
(12, 'cos', '$2y$10$ilC8mCagu46fAfiSvfGaMOuhFQi9Vke368oEMXGZdKwV/6ZQyKyWa', 'cos@cos.cos'),
(13, 'pipi', '$2y$10$DwUjSCnGjgm95TT56Zn5wO1CM6l7R8MsDif0lPNiFs91NMWN4EmT2', 'pipi'),
(14, 'pupu', '$2y$10$iwxaDYx9WLUh3ZhlzF4h..Vku5.mWGcoAir/aP8v1A4GCvc7gciwG', 'pupu@pupu'),
(15, 'testtest', '$2y$10$kmweL4zBRGEssZzxt1h7Au8lhjJjQVEc8Fzql8Au/aFRZFnyH3CIu', 'testest'),
(16, 'springrolls', '$2y$10$./i/0zjvUlOD9.ZFTx3JOe8w6bB6MfZNFYIttYHb2pLQyhSEpSJLa', 'kupcia@kupcia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `IDproduktu` int(11) NOT NULL,
  `Nazwaproduktu` varchar(100) DEFAULT NULL,
  `Cena` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`IDproduktu`, `Nazwaproduktu`, `Cena`) VALUES
(1, 'Margherita', 20),
(2, 'Pepperoni', 30),
(3, 'Hawajska', 35),
(4, 'Wegetariańska', 34.5),
(5, 'Mięsna', 40);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `IDkonta` int(11) NOT NULL,
  `IDzamowienia` int(11) NOT NULL,
  `IDproduktu` int(11) NOT NULL,
  `Cena` float NOT NULL,
  `Zrealizowano` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`IDkonta`, `IDzamowienia`, `IDproduktu`, `Cena`, `Zrealizowano`) VALUES
(7, 28, 2, 200, 0),
(7, 29, 2, 100, 0),
(7, 30, 2, 100, 0),
(7, 31, 2, 2, 0),
(7, 32, 4, 3, 0),
(7, 35, 4, 3, 0),
(7, 36, 4, 3, 0),
(7, 37, 4, 3, 0),
(7, 38, 4, 3, 0),
(7, 39, 3, 35, 0),
(7, 40, 3, 35, 0),
(7, 41, 4, 34.5, 0),
(7, 42, 4, 34.5, 0),
(7, 43, 4, 34.5, 0),
(7, 44, 4, 34.5, 0),
(7, 45, 5, 40, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `daneosobowe`
--
ALTER TABLE `daneosobowe`
  ADD KEY `ID` (`ID`);

--
-- Indeksy dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`IDproduktu`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`IDzamowienia`),
  ADD KEY `IDkonta` (`IDkonta`),
  ADD KEY `IDproduktu` (`IDproduktu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `konta`
--
ALTER TABLE `konta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `IDproduktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `IDzamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daneosobowe`
--
ALTER TABLE `daneosobowe`
  ADD CONSTRAINT `daneosobowe_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `konta` (`ID`);

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`IDkonta`) REFERENCES `konta` (`ID`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`IDproduktu`) REFERENCES `produkty` (`IDproduktu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

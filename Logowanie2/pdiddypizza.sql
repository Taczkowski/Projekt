-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 08:56 PM
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
  `Nazwisko` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(8, 'jager', '$2y$10$RKMmPZe7QdyqUt53OpDV7OhwbI1MyAnYMo.L1a1B5LJEbmoGtLM1q', 'jager@jager.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `IDproduktu` int(11) NOT NULL,
  `Nazwaproduktu` varchar(100) DEFAULT NULL,
  `Rodzaj` enum('napoje','dania') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `IDproduktu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `IDzamowienia` int(11) NOT NULL AUTO_INCREMENT;

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

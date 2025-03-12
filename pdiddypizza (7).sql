-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 07:09 PM
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
-- Struktura tabeli dla tabeli `skladniki`
--

CREATE TABLE `skladniki` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skladniki`
--

INSERT INTO `skladniki` (`id`, `nazwa`, `json_data`) VALUES
(1, 'bazylia', '{\"obrazek\": \"Ingredients_Basil.png\", \"opis\": \"Świeża bazylia\"}'),
(2, 'kukurydza', '{\"obrazek\": \"Ingredients_Corn.png\", \"opis\": \"Słodka kukurydza\"}'),
(3, 'jalapeno', '{\"obrazek\": \"Ingredients_Jalapeno.png\", \"opis\": \"Ostra papryczka jalapeño\"}'),
(4, 'cebula', '{\"obrazek\": \"Ingredients_Onion.png\", \"opis\": \"Cebula czerwona\"}'),
(5, 'kurczak', '{\"obrazek\": \"Ingredients_Sliced_Chicken.png\", \"opis\": \"Kawałki kurczaka\"}'),
(6, 'boczek', '{\"obrazek\": \"Ingredients_Beacon.png\", \"opis\": \"Chrupiący boczek\"}'),
(7, 'czosnek', '{\"obrazek\": \"Ingredients_Garlic.png\", \"opis\": \"Zmielony czosnek\"}'),
(8, 'pieczarki', '{\"obrazek\": \"Ingredients_Mushroom.png\", \"opis\": \"Świeże pieczarki\"}'),
(9, 'pepperoni', '{\"obrazek\": \"Ingredients_Pepperoni.png\", \"opis\": \"Plasterki pepperoni\"}'),
(10, 'ananas', '{\"obrazek\": \"Ingredients_Sliced_SHIT.png\", \"opis\": \"Kawałki ananasa\"}'),
(11, 'sardela', '{\"obrazek\": \"Ingredients_Anchovy.png\", \"opis\": \"Sardele w oleju\"}'),
(12, 'papryka', '{\"obrazek\": \"Ingredients_Bell-Pepper.png\", \"opis\": \"Papryka czerwona\"}'),
(13, 'szynka', '{\"obrazek\": \"Ingredients_Ham.png\", \"opis\": \"Plasterki szynki\"}'),
(14, 'oliwki', '{\"obrazek\": \"Ingredients_Olive.png\", \"opis\": \"Oliwki czarne\"}'),
(15, 'krewetki', '{\"obrazek\": \"Ingredients_Shrimp.png\", \"opis\": \"Krewetki królewskie\"}'),
(16, 'pomidor', '{\"obrazek\": \"Ingredients_Sliced_Tomato.png\", \"opis\": \"Plasterki pomidora\"}');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `imie_nazwisko` varchar(255) NOT NULL,
  `adres` text NOT NULL,
  `miasto` varchar(255) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `metoda_platnosci` varchar(50) NOT NULL,
  `data_zamowienia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `id_uzytkownika`, `imie_nazwisko`, `adres`, `miasto`, `telefon`, `email`, `metoda_platnosci`, `data_zamowienia`) VALUES
(1, 14, 'pupu', 'asd', 'asd', '123456789', 'asd@asd.asd', 'cash', '2025-03-12 18:02:26'),
(2, 14, 'pupuuu', 'asd', 'asd', '123123123', 'asd@asd.asd', 'cash', '2025-03-12 18:03:03'),
(3, 14, 'asd', 'asd', 'asd', '123456789', 'asd@asd.asd', 'cash', '2025-03-12 18:04:30'),
(4, 14, 'asd', 'asd', 'asd', '123123123', 'asd@asd.asd', 'cash', '2025-03-12 18:06:54');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_szczegoly`
--

CREATE TABLE `zamowienia_szczegoly` (
  `id` int(11) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `nazwa_pizzy` varchar(255) NOT NULL,
  `skladniki` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skladniki`)),
  `cena` decimal(10,2) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia_szczegoly`
--

INSERT INTO `zamowienia_szczegoly` (`id`, `id_zamowienia`, `nazwa_pizzy`, `skladniki`, `cena`, `ilosc`) VALUES
(1, 1, 'Snoop Dogg BBQ', '[\"kurczak\",\"boczek\",\"cebula\"]', 35.00, 1),
(2, 1, 'Eminem Classic', '[\"pepperoni\",\"papryka\",\"cebula\"]', 32.00, 1),
(3, 2, 'Snoop Dogg BBQ', '[\"kurczak\",\"boczek\",\"cebula\"]', 35.00, 1),
(4, 2, 'Eminem Classic', '[\"pepperoni\",\"papryka\",\"cebula\"]', 32.00, 1),
(5, 3, 'Travis Scott Special', '[\"pepperoni\",\"boczek\",\"jalapeno\"]', 38.00, 3),
(6, 4, 'Eminem Classic', '[\"pepperoni\",\"papryka\",\"cebula\"]', 32.00, 4);

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
-- Indeksy dla tabeli `skladniki`
--
ALTER TABLE `skladniki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`);

--
-- Indeksy dla tabeli `zamowienia_szczegoly`
--
ALTER TABLE `zamowienia_szczegoly`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `skladniki`
--
ALTER TABLE `skladniki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zamowienia_szczegoly`
--
ALTER TABLE `zamowienia_szczegoly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daneosobowe`
--
ALTER TABLE `daneosobowe`
  ADD CONSTRAINT `daneosobowe_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `konta` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

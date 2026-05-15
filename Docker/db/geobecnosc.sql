SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `klasy` (
    `id` int(11) NOT NULL,
    `nazwa` varchar(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `klasy` ADD PRIMARY KEY (`id`);
ALTER TABLE `klasy` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `nauczyciele`(
    `id` int(11) NOT NULL,
    `przedmiot` int(11), 
    `imie` varchar(50),
    `nazwisko` varchar(50),
    `email` varchar(75),
    `hash_hasla` varchar(100),
    `administrator` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `nauczyciele` ADD PRIMARY KEY (`id`);
ALTER TABLE `nauczyciele` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--CREATE TABLE `nauczyciele_przedmiote`(
--    `nauczyciel` int(11), -- rel
--    `przedmiot` int(11) -- rel
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `uczeniowie` (
    `id` int(11) NOT NULL,
    `imie` varchar(50),
    `nazwisko` varchar(50),
    `email` varchar(75),
    `hash_hasla` varchar(100),
    `klasa` int(11) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `uczeniowie` ADD PRIMARY KEY (`id`);
ALTER TABLE `uczeniowie` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `lekcje` (
    `id` int(11) NOT NULL,
    `godzinaRozpoczecia` int(11),
    `godzinaZakonczenia` int(11),
    `przedmiot` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `lekcje` ADD PRIMARY KEY (`id`);
ALTER TABLE `lekcje` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `przedmioty` (
    `id` int(11) NOT NULL,
    `nazwa` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `przedmioty` ADD PRIMARY KEY (`id`);
ALTER TABLE `przedmioty` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `godziny` (
    `id` int(11) NOT NULL,
    `godzina` TIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `godziny` ADD PRIMARY KEY (`id`);
ALTER TABLE `godziny` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `obecnosci_w_dniu` (
    `id` int(11) NOT NULL,
    `dzien` int(11),
    `uczen` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `obecnosci_w_dniu` ADD PRIMARY KEY (`id`);
ALTER TABLE `obecnosci_w_dniu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `obecnosci_na_lekcji` (
    `id` int(11),
    `lekcja` int(11),
    `obecnosc` int(11),
    `spozniony` boolean,
    `obecny` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `obecnosci_na_lekcji` ADD PRIMARY KEY (`id`);
ALTER TABLE `obecnosci_na_lekcji` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


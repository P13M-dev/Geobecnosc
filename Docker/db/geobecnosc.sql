SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `klasy` (
    `id` int(11) NOT NULL,
    `nazwa` varchar(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `klasy` ADD PRIMARY KEY (`id`);
ALTER TABLE `klasy` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `nauczyciel`(
    `id` int(11) NOT NULL,
    `nauczyciel_przedmiot` int(11), -- rel
    `imie` varchar(50),
    `nazwisko` varchar(50),
    `email` varchar(75),
    `hash_hasla` varchar(100),
    `administrator` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `nauczyciel` ADD PRIMARY KEY (`id`);
ALTER TABLE `nauczyciel` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `nauczyciel_przedmiot`(
    `nauczyciel` int(11), -- rel
    `przedmiot` int(11) -- rel
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `uczen` (
    `id` int(11) NOT NULL,
    `imie` varchar(50),
    `nazwisko` varchar(50),
    `email` varchar(75),
    `hash_hasla` varchar(100),
    `klasa` int(11) -- rel
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `uczen` ADD PRIMARY KEY (`id`);
ALTER TABLE `uczen` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `lekcja` (
    `id` int(11) NOT NULL,
    `godzinaRozpoczecia` int(11), -- rel
    `godzinaZakonczenia` int(11), --rel
    `przedmiot` int(11) -- rel
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `lekcja` ADD PRIMARY KEY (`id`);
ALTER TABLE `lekcja` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `przedmiot` (
    `id` int(11) NOT NULL,
    `nazwa` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `przedmiot` ADD PRIMARY KEY (`id`);
ALTER TABLE `przedmiot` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `godzina` (
    `id` int(11) NOT NULL,
    `godzina` TIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `godzina` ADD PRIMARY KEY (`id`);
ALTER TABLE `godzina` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `obecnosc_w_dniu` (
    `id` int(11) NOT NULL,
    `dzien` int(11), --rel
    `uczen` int(11)  --rel
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `obecnosc_w_dniu` ADD PRIMARY KEY (`id`);
ALTER TABLE `obecnosc_w_dniu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `obecnosc_na_lekcji` (
    `id` int(11),
    `lekcja` int(11), --rel
    `obecnosc` int(11), --rel
    `spozniony` boolean,
    `obecny` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `obecnosc_na_lekcji` ADD PRIMARY KEY (`id`);
ALTER TABLE `obecnosc_na_lekcji` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


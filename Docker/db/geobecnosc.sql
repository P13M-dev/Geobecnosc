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

CREATE TABLE `uczniowie` (
    `id` int(11) NOT NULL,
    `imie` varchar(50),
    `nazwisko` varchar(50),
    `email` varchar(75),
    `hash_hasla` varchar(100),
    `klasa` int(11) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `uczniowie` ADD PRIMARY KEY (`id`);
ALTER TABLE `uczniowie` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `lekcje` (
    `id` int(11) NOT NULL,
    `godzina` int(11),
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
    `godzina` TIME,
    `dlugosc` int(11),
    `liczba_porzadkowa` int(11)
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


CREATE TABLE `dni` (
    `id` int(11),
    `dzien` DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `dni` ADD PRIMARY KEY (`id`);
ALTER TABLE `dni` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `uczniowie` ADD CONSTRAINT `fk_uczen_klasa` FOREIGN KEY (`klasa`) REFERENCES `klasy`(`id`);
ALTER TABLE `lekcje` ADD CONSTRAINT `fk_lekcja_godzina` FOREIGN KEY (`godzina`) REFERENCES `godziny`(`id`);
ALTER TABLE `lekcje` ADD CONSTRAINT `fk_lekcja_przedmiot` FOREIGN KEY (`przedmiot`) REFERENCES `przedmioty`(`id`);
ALTER TABLE `obecnosci_w_dniu` ADD CONSTRAINT `fk_ob_dzien` FOREIGN KEY (`dzien`) REFERENCES `dni`(`id`);
ALTER TABLE `obecnosci_w_dniu` ADD CONSTRAINT `fk_ob_uczen` FOREIGN KEY (`uczen`) REFERENCES `uczniowie`(`id`);
ALTER TABLE `obecnosci_na_lekcji` ADD CONSTRAINT `fk_ol_lekcja` FOREIGN KEY (`lekcja`) REFERENCES `lekcje`(`id`);
ALTER TABLE `obecnosci_na_lekcji` ADD CONSTRAINT `fk_ol_obecnosc` FOREIGN KEY (`obecnosc`) REFERENCES `obecnosci_w_dniu`(`id`);

INSERT INTO `przedmioty` (`nazwa`) VALUES ("Język Polski"),("Matematyka"),("Język Angielski"),("Informatyka");

INSERT INTO `nauczyciele` (`przedmiot`,`imie`,`nazwisko`,`email`,`hash_hasla`,`administrator`) VALUES (4,"Jan","Kowalski","administrator@szkola.com","$2y$10$LeBxmssys4kfEhzBoGWCcuS7wP6HCZKb6HFTvMnjiG7Cyf4E0mD4W",TRUE); --12345678
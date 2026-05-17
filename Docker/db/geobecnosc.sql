SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `dane_szkoly` (
    `id` int(11),
    `obszar_szkoly` JSON
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `dane_szkoly` ADD PRIMARY KEY (`id`);
ALTER TABLE `dane_szkoly` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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

CREATE TABLE `uczniowie` (
    `id` int(11) NOT NULL,
    `imie` varchar(50),
    `nazwisko` varchar(50),
    `email` varchar(75),
    `hash_hasla` varchar(100),
    `klasa` int(11),
    `token` varchar(64) DEFAULT '',
    `zweryfikowany` boolean DEFAULT FALSE,
    `godzina_loginu` DATETIME DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `uczniowie` ADD PRIMARY KEY (`id`);
ALTER TABLE `uczniowie` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `lekcje` (
    `id` int(11) NOT NULL,
    `godzina` int(11),
    `dzien` DATE,
    `przedmiot` int(11),
    `klasa` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `lekcje` ADD PRIMARY KEY (`id`);
ALTER TABLE `lekcje` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `przedmioty` (
    `id` int(11) NOT NULL,
    `nazwa` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `przedmioty` ADD PRIMARY KEY (`id`);
ALTER TABLE `przedmioty` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT , AUTO_INCREMENT=0;

CREATE TABLE `godziny` (
    `id` int(11) NOT NULL,
    `ustawienia_szkoly` int(11) DEFAULT 1,
    `godzina` TIME,
    `dlugosc` int(11) DEFAULT 45,
    `liczba_porzadkowa` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `godziny` ADD PRIMARY KEY (`id`);
ALTER TABLE `godziny` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `obecnosci_na_lekcji` (
    `id` int(11),
    `lekcja` int(11),
    `obecnosc` int(11),
    `spozniony` boolean,
    `obecny` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `obecnosci_na_lekcji` ADD PRIMARY KEY (`id`);
ALTER TABLE `obecnosci_na_lekcji` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `uczniowie` ADD CONSTRAINT `fk_uczen_klasa` FOREIGN KEY (`klasa`) REFERENCES `klasy`(`id`);
ALTER TABLE `lekcje` ADD CONSTRAINT `fk_lekcja_godzina` FOREIGN KEY (`godzina`) REFERENCES `godziny`(`id`);
ALTER TABLE `lekcje` ADD CONSTRAINT `fk_lekcja_przedmiot` FOREIGN KEY (`przedmiot`) REFERENCES `przedmioty`(`id`);
ALTER TABLE `godziny` ADD CONSTRAINT `fk_godzina_dane_szkoly` FOREIGN KEY (`ustawienia_szkoly`) REFERENCES `dane_szkoly`(`id`);
ALTER TABLE `obecnosci_na_lekcji` ADD CONSTRAINT `fk_ol_lekcja` FOREIGN KEY (`lekcja`) REFERENCES `lekcje`(`id`);

INSERT INTO `dane_szkoly` (`obszar_szkoly`) VALUES ("[]");
INSERT INTO `przedmioty` (`nazwa`) VALUES ("-");

INSERT INTO `nauczyciele` (`przedmiot`,`imie`,`nazwisko`,`email`,`hash_hasla`,`administrator`) VALUES 
(0,"Jan","Kowalski","admin@szkola.com","$2y$10$LeBxmssys4kfEhzBoGWCcuS7wP6HCZKb6HFTvMnjiG7Cyf4E0mD4W",TRUE); --hasło 12345678

INSERT INTO `godziny` (`liczba_porzadkowa`,`godzina`) VALUES 
(1,"07:10:00"),
(2,"08:00:00"),
(3,"08:55:00"),
(4,"09:50:00"),
(5,"10:45:00"),
(6,"11:50:00"),
(7,"12:45:00"),
(8,"13:35:00"),
(9,"14:25:00"),
(10,"15:15:00")
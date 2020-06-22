### Aplikace Klienti
Jednoduchá aplikace pro správu klientů. Klienty uživatel vidí vypsané v tabulce, může je upravovat i mazat. Přidat nového klienta
lze po kliknutí na tlačítko "Vytvořit klienta".

#### Co je potřeba
- Server s PHP >= 7.0
- V MySQL databázi mít vytvořenou tabulku s těmito sloupci:
id, name, phone, email, description. ID bude s automatickou inkrementací.
- Pro komunikaci s databází je potřeba mít správně nakonfigurovaný soubor config.php

Zde je skript pro založení tabulky:
```sql
CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `email` varchar(64) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
);
```
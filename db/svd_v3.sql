-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Št 04.Mar 2021, 11:04
-- Verzia serveru: 10.4.14-MariaDB
-- Verzia PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `svd_v3`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `abbreviation`, `number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Slovenská sporiteľňa', 'SLSP', 'SK101231231456', NULL, NULL, NULL),
(2, 'OTP Banka', 'OTP', 'SK1000009876', NULL, NULL, NULL),
(3, 'Pokladňa', '', '', NULL, NULL, NULL),
(4, 'Tatra Banka', 'TB', '2924865513', NULL, NULL, NULL),
(5, 'Dexia', 'DEX', '805945001', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nezaradené', NULL, NULL, NULL),
(2, 'Biskupstvá', NULL, NULL, NULL),
(3, 'Diecéza Žilina', NULL, NULL, NULL),
(4, 'Diecéza Bratislava', NULL, NULL, NULL),
(5, 'Diecéza Trnava', NULL, NULL, NULL),
(6, 'Diecéza Spiš', NULL, NULL, NULL),
(7, 'Diecéza Rožňava', NULL, NULL, NULL),
(8, 'Diecéza Prešov', NULL, NULL, NULL),
(9, 'Diecéza Nitra', NULL, NULL, NULL),
(10, 'Diecéza Košice', NULL, NULL, NULL),
(11, 'Diecéza Banská Bystrica', NULL, NULL, NULL),
(12, 'Osobny darca', NULL, NULL, NULL),
(13, 'Dobrodinci', NULL, NULL, NULL),
(14, 'Hromnice', NULL, NULL, NULL),
(15, 'Rehole', NULL, NULL, NULL),
(16, 'Rodičia', NULL, NULL, NULL),
(17, 'Pátri', NULL, NULL, NULL),
(18, 'Nemecko', NULL, NULL, NULL),
(19, 'Pošta', NULL, NULL, NULL),
(20, 'Ex-verbisti', NULL, NULL, NULL),
(21, 'Čína', NULL, NULL, NULL),
(22, 'Škola', NULL, NULL, NULL),
(23, 'Sponzor', NULL, NULL, NULL),
(24, 'Obecný úrad', NULL, NULL, NULL),
(25, 'Knižnica', NULL, NULL, NULL),
(26, 'Farnosť', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(28, '2014_10_12_000000_create_users_table', 1),
(29, '2014_10_12_100000_create_password_resets_table', 1),
(30, '2021_02_05_202632_create_bank_accounts_table', 1),
(31, '2021_02_05_203019_create_categories_table', 1),
(32, '2021_02_05_203133_create_people_table', 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `people`
--

CREATE TABLE `people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address1` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `people`
--

INSERT INTO `people` (`id`, `category_id`, `title`, `name1`, `address1`, `address2`, `organization`, `zip_code`, `city`, `state`, `email`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 'Dr.', 'Mr. Arthur Skiles', '296 Klocko Courts Suite 722', '', 'Stanton, Balistreri and Lowe', '94626-0316', 'Port Marquise', 'Mississippi', 'kirk39@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(2, 21, 'Mrs.', 'Jerald Eichmann II', '2714 Rowland Flat Apt. 064', '', 'Miller, Krajcik and Langosh', '31131', 'Port Hayley', 'Missouri', 'tyrese.veum@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(3, 9, 'Dr.', 'Demarcus Fritsch DVM', '41366 Hand Trace Apt. 749', '', 'Hermann, Abernathy and Ferry', '89605-0932', 'Bergstromville', 'Illinois', 'gfunk@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(4, 7, 'Dr.', 'Kendrick Rice', '5536 Madelynn Manor Suite 950', '', 'McClure PLC', '97451-1652', 'Port Violetberg', 'New Jersey', 'teagan32@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(5, 11, 'Mr.', 'Felix Brakus Jr.', '112 Colby Viaduct Apt. 016', '', 'Boyer-Nikolaus', '42249-2736', 'New Tristinmouth', 'Colorado', 'viviane84@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(6, 11, 'Dr.', 'Dr. Garfield Purdy V', '4435 Lindgren Plaza Suite 360', '', 'Lemke-Pfannerstill', '49551-1044', 'Port Roxanne', 'North Carolina', 'emma.kihn@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(7, 24, 'Prof.', 'Joan Vandervort', '24721 Kunze Ports', '', 'Sipes, Bins and Lind', '05970-0423', 'Reichertstad', 'New Hampshire', 'von.newell@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(8, 7, 'Mrs.', 'Dylan Rau', '796 Connelly Plains Apt. 330', '', 'Hackett-Kautzer', '11064-5443', 'Steviehaven', 'Rhode Island', 'xavier.fisher@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(9, 5, 'Mrs.', 'Germaine Haag', '559 Robert Unions Suite 682', '', 'Dibbert PLC', '44506-6265', 'North Erwinport', 'Rhode Island', 'qharris@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(10, 4, 'Prof.', 'Suzanne Quigley', '235 Lowe Extension', '', 'Bergstrom-Rodriguez', '88892', 'North Jewel', 'South Dakota', 'verner63@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(11, 15, 'Mr.', 'Allan Raynor', '833 Kristina Glen Suite 455', '', 'Green, Krajcik and Johns', '50850', 'Port Terrillport', 'Wyoming', 'cierra93@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(12, 14, 'Dr.', 'Mrs. Trisha Ebert', '82865 Mack Lights', '', 'Quigley Ltd', '21328-6750', 'Port German', 'North Dakota', 'christop66@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(13, 13, 'Prof.', 'Mr. Jamil Hills V', '7006 Shields Junctions Apt. 033', '', 'Rippin and Sons', '46206-9121', 'Mireilleland', 'Nevada', 'kemmer.jamar@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(14, 18, 'Miss', 'Kyla Brekke', '77449 Fisher Glens Apt. 879', '', 'Okuneva, Goyette and Keeling', '39692', 'Johnathonfort', 'Illinois', 'towne.pedro@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(15, 26, 'Prof.', 'Celia Rau DVM', '477 Jarrett Throughway', '', 'Bernhard PLC', '99543', 'New Thurmanport', 'California', 'brayan25@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(16, 18, 'Mr.', 'Gabriel Jones', '79385 Jayme Haven Suite 445', '', 'Gottlieb and Sons', '56631-3298', 'West Maudeton', 'New Jersey', 'ozella05@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(17, 18, 'Mr.', 'Prof. Carroll Mills V', '14348 Harold Island Apt. 657', '', 'Thompson-Feest', '54197', 'Brionnaside', 'Connecticut', 'hmarvin@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(18, 21, 'Prof.', 'Adrian Bogan DDS', '5772 Kacie Alley', '', 'Gutmann and Sons', '81596', 'Bodeborough', 'West Virginia', 'muller.carlotta@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(19, 10, 'Prof.', 'Candida Grimes II', '6141 Margarita Motorway Apt. 959', '', 'Schneider, Cronin and Dickens', '10545-3759', 'Stephaniefort', 'Washington', 'destiny48@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(20, 20, 'Dr.', 'Jayne Runolfsdottir', '724 Myrtie Pass', '', 'Rogahn-Schaefer', '90942-5790', 'Elisaland', 'Michigan', 'alden.powlowski@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(21, 6, 'Prof.', 'Orrin Marvin', '37609 Eleanora Square Suite 464', '', 'Steuber, Jenkins and Hodkiewicz', '23889-4645', 'North Camryn', 'Alabama', 'mariane.jacobs@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(22, 24, 'Prof.', 'Ludie Collier', '677 Murazik Grove Apt. 646', '', 'Reinger-Batz', '92821-5036', 'Port Angelashire', 'Washington', 'billie.langosh@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(23, 19, 'Mr.', 'Prof. Freeman Rempel', '8000 Smitham Course', '', 'Marquardt Ltd', '50323', 'Rahulberg', 'Indiana', 'robert67@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(24, 16, 'Mrs.', 'Green Friesen', '16641 Maggie Valley', '', 'Cartwright, Beahan and Rutherford', '19480-7924', 'Tillmanborough', 'California', 'dana65@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(25, 8, 'Mrs.', 'Wilson Nienow', '475 Murazik Corners Suite 455', '', 'Kunde, Pfeffer and Rowe', '79126', 'Lake Carson', 'Nebraska', 'konopelski.shemar@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(26, 7, 'Dr.', 'Fae Luettgen IV', '147 Jenkins Islands', '', 'Klein-Schuppe', '59368-5153', 'North Waltonfurt', 'West Virginia', 'leora08@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(27, 5, 'Prof.', 'Prof. Marshall Herzog', '6133 Green Divide Apt. 410', '', 'Deckow-Gaylord', '78478', 'North Bret', 'Oklahoma', 'sofia98@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(28, 16, 'Dr.', 'Prof. Carmelo Sanford Jr.', '619 Leilani Plaza Suite 174', '', 'Jacobs Group', '39695-5925', 'West Estel', 'Kansas', 'bella14@example.net', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(29, 10, 'Dr.', 'Price Schneider', '5288 Abernathy Parkway', '', 'Pacocha PLC', '69584-2796', 'Faystad', 'Louisiana', 'babshire@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(30, 22, 'Prof.', 'Rhett Runte MD', '2623 Keven Way', '', 'Turner-Streich', '62601', 'Waelchistad', 'Nevada', 'feil.roderick@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(31, 22, 'Mr.', 'Jacquelyn Medhurst', '92054 Murray Stravenue Apt. 369', '', 'Borer-Schinner', '71197-1829', 'East Juliaberg', 'South Dakota', 'judson17@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(32, 6, 'Dr.', 'Maye Wehner', '68018 Brody Extension', '', 'Hilpert, Blick and Kling', '03722', 'North Shannon', 'Idaho', 'conn.madalyn@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(33, 8, 'Prof.', 'Dorian Fay', '570 Isadore Meadows Apt. 151', '', 'Morissette Ltd', '99684-3962', 'Amyatown', 'Minnesota', 'lhomenick@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(34, 23, 'Mrs.', 'Kolby Cummerata', '310 Walter Pike Apt. 238', '', 'Carter PLC', '40817-1630', 'Kshlerintown', 'Idaho', 'destin82@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(35, 22, 'Mr.', 'Audreanne Kiehn', '74099 Schmeler Shores', '', 'Jacobson, Franecki and Lueilwitz', '03575-7639', 'Rempelfort', 'Vermont', 'nelson.cummings@example.com', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(36, 18, 'Prof.', 'Evie Turner', '7781 Bethany Wells', '', 'Hauck Group', '79671', 'Heidiview', 'New Mexico', 'cjohnston@example.org', '', '2021-02-05 20:55:03', '2021-02-05 20:55:03', NULL),
(37, 11, 'Ms.', 'Colt Quitzon IV', '764 Armstrong Rapid', '', 'Bayer, Carter and Marvin', '90828', 'West Alexandreton', 'Alaska', 'rempel.esta@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(38, 15, 'Mr.', 'Edwina Glover', '2553 Connie Village', '', 'Berge Ltd', '92172-4084', 'East Lesleyburgh', 'Massachusetts', 'manuela.weber@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(39, 13, 'Mrs.', 'Lance Purdy', '80134 Lockman Villages', '', 'Dietrich Ltd', '22453-1355', 'Port Aiyana', 'Alabama', 'boconnell@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(40, 4, 'Prof.', 'Levi Littel', '49589 Boehm Camp', '', 'Hegmann-Anderson', '19898-4980', 'North Demetrius', 'Connecticut', 'sage.nienow@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(41, 11, 'Mrs.', 'Alberta Bayer I', '8311 Estevan Springs', '', 'Carroll Inc', '71708', 'Brycenstad', 'Virginia', 'loconnell@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(42, 11, 'Prof.', 'Iva Russel Sr.', '638 Chyna Divide', '', 'Raynor and Sons', '45635', 'Lake Erastad', 'Ohio', 'felipa.cormier@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(43, 13, 'Dr.', 'Percival Fahey', '397 O\'Reilly Glens Suite 590', '', 'Veum, Glover and Bechtelar', '52954-9356', 'Port Jonatanville', 'Hawaii', 'anita41@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(44, 22, 'Dr.', 'Prof. Jabari Pacocha', '196 Schneider Rapids', '', 'Raynor Group', '88018', 'Shaniefort', 'Hawaii', 'zprosacco@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(45, 7, 'Prof.', 'Jannie Streich', '970 Eric Court', '', 'Wolf-Hill', '02263', 'Port Keyshawnmouth', 'Oklahoma', 'martina09@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(46, 1, 'Dr.', 'Jermey Hilpert', '45298 Marks Alley', '', 'Bednar-Rowe', '20666', 'Rolfsonhaven', 'Rhode Island', 'carlotta.shields@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(47, 11, 'Prof.', 'Dr. Monroe Aufderhar I', '490 Michelle Union Apt. 273', '', 'Hudson-Mosciski', '93893-9615', 'Darianside', 'Indiana', 'polly.swaniawski@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(48, 20, 'Ms.', 'Dr. Lambert Considine', '2553 Gleason Plaza', '', 'Pacocha, Hirthe and Jacobs', '20039-2217', 'Maximusshire', 'Massachusetts', 'emilie.gerlach@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(49, 10, 'Ms.', 'May Marvin Sr.', '304 Mckenna Port', '', 'Legros-Schaden', '18231', 'Douglaschester', 'Oregon', 'yundt.andre@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(50, 25, 'Mrs.', 'Mrs. Georgiana Casper MD', '72841 Jeanie Field', '', 'Stamm-Deckow', '48537-8629', 'North Reinhold', 'California', 'gulgowski.dwight@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(51, 8, 'Dr.', 'Travis Skiles III', '41755 Hudson Summit Suite 674', '', 'Goodwin LLC', '56489-9220', 'East Cullen', 'Oklahoma', 'mills.glenda@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(52, 23, 'Ms.', 'Prof. Piper Goodwin II', '37872 Liam Forge Suite 895', '', 'Beahan, Wehner and Heidenreich', '05041-8167', 'Minniechester', 'Oregon', 'jacobson.marcelina@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(53, 11, 'Prof.', 'Prof. Ignacio Watsica DVM', '71757 Wolff Spring', '', 'Orn-Boehm', '18255', 'Schuppeview', 'New Jersey', 'jaskolski.jadyn@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(54, 14, 'Dr.', 'Eileen Cremin', '8754 Marlon Place', '', 'McDermott, Luettgen and Reynolds', '96197-6884', 'New Anastasiaview', 'Michigan', 'barton.gay@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(55, 13, 'Dr.', 'Cesar Deckow', '79162 Heaney Radial Suite 885', '', 'Mosciski-Osinski', '76649-8841', 'Charleyside', 'Nevada', 'tomas.nikolaus@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(56, 21, 'Mr.', 'Dr. Hayden Mosciski', '18430 Trantow Route', '', 'Torphy, Bashirian and Schulist', '51408-5068', 'Beattyton', 'Florida', 'arnaldo48@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(57, 18, 'Prof.', 'Dr. Emmet Reynolds', '826 Marvin Skyway', '', 'Windler-O\'Connell', '76419', 'South Lily', 'Alabama', 'pwindler@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(58, 9, 'Prof.', 'Dr. Lindsey Schaden', '767 Conn Village', '', 'Lemke PLC', '19227', 'West Caitlyn', 'North Dakota', 'paula.sauer@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(59, 11, 'Prof.', 'Ernestina Baumbach', '66393 Wilma Hills Apt. 497', '', 'Wisozk-Waters', '14405', 'Port Camronview', 'South Dakota', 'maude85@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(60, 10, 'Mr.', 'Dr. Charley Lebsack DVM', '6308 Orn Vista Suite 769', '', 'Collins Ltd', '99121', 'Elfriedaborough', 'Montana', 'adele66@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(61, 23, 'Ms.', 'Mr. Preston Bashirian', '179 Sanford Underpass', '', 'Toy PLC', '12479', 'South Ericaport', 'Colorado', 'armstrong.princess@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(62, 11, 'Ms.', 'Mrs. Larissa Donnelly', '6855 Howe Haven', '', 'Hand-Kilback', '44857', 'Deondreberg', 'Indiana', 'jany.hagenes@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(63, 2, 'Mr.', 'Joe Crona', '769 Lura Spurs', '', 'Fadel-Trantow', '65041', 'North Bernice', 'Alabama', 'ryan.macejkovic@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(64, 1, 'Mr.', 'Mr. Frankie Cruickshank', '7887 Murray Fords Apt. 340', '', 'Hyatt-Blick', '78306', 'Artmouth', 'California', 'art20@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(65, 4, 'Miss', 'Prof. Libbie Blanda I', '346 Jett Forges', '', 'Thompson-Hilpert', '85379-1189', 'Jarretside', 'Arkansas', 'breana.stanton@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(66, 2, 'Dr.', 'Larue Cummings', '77477 Kelton Street', '', 'Spinka, Little and Hoeger', '79363', 'Port Paige', 'Texas', 'beth76@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(67, 19, 'Mr.', 'Helene Carroll', '955 Leif Highway Apt. 546', '', 'Douglas-Kilback', '22781', 'Lowetown', 'Washington', 'eliza.littel@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(68, 20, 'Mr.', 'Mallory Koch', '357 Bernhard Light', '', 'D\'Amore, Raynor and Kassulke', '20564-5834', 'Welchmouth', 'Virginia', 'fmclaughlin@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(69, 9, 'Dr.', 'Moshe Mante', '45708 Kuvalis Point', '', 'Donnelly, Keebler and Gulgowski', '05700-1484', 'Predovicville', 'Vermont', 'rosanna48@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(70, 26, 'Dr.', 'Mrs. Selena Bednar III', '17235 Huels Walk', '', 'Schaden-Crist', '85136', 'Alanisville', 'Mississippi', 'okovacek@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(71, 26, 'Mrs.', 'Julie Bahringer II', '64621 Abernathy Cliffs Suite 773', '', 'Moore-Rolfson', '54173', 'Axelstad', 'Arkansas', 'johnston.shawn@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(72, 8, 'Dr.', 'Ramona Turcotte', '1249 Walter Curve Suite 876', '', 'Stroman-Rippin', '02040', 'Waldobury', 'Indiana', 'alison.dickens@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(73, 6, 'Ms.', 'Shaina Pfannerstill', '1085 Abbott Creek', '', 'Bailey, Lueilwitz and Renner', '57114-2188', 'Shanahanstad', 'Wyoming', 'rowena.denesik@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(74, 13, 'Dr.', 'Makenna Ziemann Jr.', '324 Lindgren Brooks', '', 'Flatley-Sporer', '92316', 'Lake Blancamouth', 'Alabama', 'jaylen44@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(75, 23, 'Mrs.', 'Jordon Stracke', '34916 Waters Fields Apt. 900', '', 'Rippin Group', '62965-2142', 'Furmanville', 'Florida', 'zkunze@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(76, 2, 'Dr.', 'Jeramy Welch DDS', '9181 Jayde Trail Suite 480', '', 'Walsh PLC', '41424', 'South Brielleland', 'Virginia', 'bednar.mariela@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(77, 19, 'Mr.', 'Destini Collier', '22645 Abshire Plaza', '', 'Carter Inc', '50371-6591', 'Breitenbergborough', 'West Virginia', 'qokeefe@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(78, 22, 'Dr.', 'Christ Turner', '60053 Leann Creek', '', 'Krajcik PLC', '78999-7028', 'Talonstad', 'Colorado', 'littel.antonio@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(79, 24, 'Dr.', 'Dr. Raoul Doyle', '4480 Hickle Underpass', '', 'Conroy-Champlin', '29232-2543', 'New Breannaport', 'Delaware', 'burdette.bernhard@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(80, 6, 'Mr.', 'Prof. Emmanuelle Blick', '45284 Morissette Track Suite 269', '', 'Bradtke, Kris and Kozey', '25954-1908', 'Kayton', 'West Virginia', 'earnestine91@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(81, 15, 'Ms.', 'Kiara Gerlach', '582 Dashawn Mews Suite 355', '', 'Halvorson, Rutherford and Berge', '45799-3596', 'Jaredchester', 'Georgia', 'banderson@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(82, 2, 'Mr.', 'Dr. Kenneth Rogahn', '967 Estell Lane Suite 285', '', 'Casper Inc', '21872', 'New Frederiquefort', 'Alabama', 'keira.veum@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(83, 5, 'Prof.', 'Zora Cole', '1116 DuBuque Mountains Apt. 903', '', 'Shanahan, Lockman and Waters', '35547', 'Monahanmouth', 'Arkansas', 'mbotsford@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(84, 22, 'Mrs.', 'Prof. Francesca Harris DVM', '3304 Schoen Spring', '', 'VonRueden-Crist', '09049-7334', 'Rebeccamouth', 'Hawaii', 'jgleichner@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(85, 6, 'Mr.', 'Clare Effertz', '755 Toy Hills', '', 'Bernhard, Nolan and Herzog', '76266-5587', 'South Vellahaven', 'Minnesota', 'rbechtelar@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(86, 14, 'Prof.', 'Herminia Jakubowski', '4700 Lebsack Fords', '', 'O\'Connell-Blanda', '40734', 'Lake Malikaberg', 'Vermont', 'hayes.leon@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(87, 8, 'Prof.', 'Kallie Daugherty', '813 Ruben Branch Apt. 188', '', 'Marks, Langosh and Rosenbaum', '67400', 'Jarretbury', 'Utah', 'vhoeger@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(88, 12, 'Prof.', 'Adah Mertz Jr.', '5220 Arnaldo Flats', '', 'Aufderhar, Douglas and Turner', '33116', 'Terryshire', 'Virginia', 'rutherford.myrtis@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(89, 8, 'Mr.', 'Mr. Buddy Christiansen', '4086 Fritsch Ranch', '', 'Simonis-Toy', '85871-7977', 'Chelsiebury', 'West Virginia', 'homenick.everette@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(90, 14, 'Miss', 'Prof. Howard Aufderhar', '704 Raven Spurs Suite 376', '', 'Lynch-Abernathy', '99266', 'Port Elisaville', 'West Virginia', 'ortiz.jany@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(91, 21, 'Prof.', 'Laurine Considine', '299 Marques Turnpike', '', 'Simonis, Crooks and Sipes', '88333-7673', 'East Norbert', 'Alaska', 'corwin.sheldon@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(92, 1, 'Mrs.', 'Sandrine Murazik', '7588 Toy Lodge', '', 'Pouros-Breitenberg', '16783-3777', 'Reganmouth', 'South Dakota', 'calista71@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(93, 21, 'Dr.', 'Mrs. Eulalia Block', '7581 McKenzie Pines Apt. 112', '', 'Price-Gutkowski', '10073', 'Port Sarinaland', 'New Jersey', 'gregg.balistreri@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(94, 7, 'Dr.', 'Sylvia Hessel', '114 Donna Fall Apt. 934', '', 'Herzog Ltd', '10490-4322', 'West Samson', 'Georgia', 'prohaska.pearlie@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(95, 14, 'Prof.', 'Joseph Jakubowski', '4792 Brian Courts Apt. 006', '', 'McKenzie, Hill and Koelpin', '36405-9915', 'Fredrickview', 'Wisconsin', 'jbecker@example.org', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(96, 5, 'Prof.', 'Dr. Stephanie Barton I', '313 Murphy Bypass Suite 812', '', 'Rogahn and Sons', '99837-4045', 'East Destineemouth', 'Iowa', 'vhermiston@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(97, 22, 'Dr.', 'Prof. Eula Beatty', '6618 Clotilde Fort', '', 'Konopelski-Rippin', '15584-7339', 'North Hassie', 'New Hampshire', 'anderson.eli@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(98, 8, 'Mr.', 'Roman Kuhic', '7797 Franecki Lodge Suite 190', '', 'Kuphal-Labadie', '75168-7652', 'Louiehaven', 'Arkansas', 'susie66@example.net', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(99, 18, 'Mr.', 'Casey Stehr II', '6100 Wuckert Trail', '', 'Little-Murphy', '92484-4474', 'North Merl', 'Ohio', 'gledner@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL),
(100, 1, 'Mr.', 'Dr. Lenora Smitham MD', '5604 Josie Lodge', '', 'Legros-Doyle', '11933', 'Mullerstad', 'South Dakota', 'felipa60@example.com', '', '2021-02-05 20:55:04', '2021-02-05 20:55:04', NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Peter Stehlík', 'peter@inovative.sk', '2021-02-05 20:55:04', '$2y$10$Ktn6OXNlv/sF2HmcSKj2TOjVI7OG.E5xE.lL2rjDAO5VxYy9OtoAe', 'djlf2RJRI9', NULL, NULL, NULL),
(2, 'Katarína Vallová', 'katarina.vallova@svd.sk', '2021-02-05 20:55:04', '$2y$10$OQJSMuHHxIqaKDLN923pRu7vm5DV8WJrPzar3G7U4DVhhAmZbvCJm', 'EcbhcgrVxF', NULL, NULL, NULL),
(3, 'Katarína Mancírová', 'katarina.mancirova@svd.sk', '2021-02-05 20:55:04', '$2y$10$2Imx253K3fcWRjNLILUHSO1PKHEK7gCtHq6vTyl4u.qwApJhe0gTG', '14PcAPDO5a', NULL, NULL, NULL);

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexy pre tabuľku `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pre tabuľku `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pre tabuľku `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pre tabuľku `people`
--
ALTER TABLE `people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

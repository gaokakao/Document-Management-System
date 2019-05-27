-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2019 at 04:18 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sutartys`
--

-- --------------------------------------------------------

--
-- Table structure for table `asmenys`
--

CREATE TABLE `asmenys` (
  `asmens_id` int(11) NOT NULL,
  `vardas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `pavarde` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `pareigos` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `vartotojo_vardas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `slaptazodis` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `email` text,
  `lygis` enum('admin','user','special','guest','none') NOT NULL DEFAULT 'none',
  `eilutes` int(11) NOT NULL DEFAULT '25',
  `excel` enum('main','all') NOT NULL DEFAULT 'main'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asmenys`
--

INSERT INTO `asmenys` (`asmens_id`, `vardas`, `pavarde`, `pareigos`, `vartotojo_vardas`, `slaptazodis`, `email`, `lygis`, `eilutes`, `excel`) VALUES
(1, 'steven', 'gerrard', 'captain', 'lfc', '2005', 'admin@gao.lt', 'admin', 25, 'main'),
(2, 'demo', 'demo', 'demo', 'demo', 'demo', 'demo@demo.lt', 'admin', 25, 'main'),
(3, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin@admin.admin', 'admin', 25, 'main');

-- --------------------------------------------------------

--
-- Table structure for table `objektai`
--

CREATE TABLE `objektai` (
  `objekto_id` int(11) NOT NULL,
  `pavadinimas` text COLLATE utf8_lithuanian_ci NOT NULL,
  `adresas` text COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `objektai`
--

INSERT INTO `objektai` (`objekto_id`, `pavadinimas`, `adresas`) VALUES
(1, 'anfield', 'Liverpool');

-- --------------------------------------------------------

--
-- Table structure for table `subjektai`
--

CREATE TABLE `subjektai` (
  `subjekto_id` int(11) NOT NULL,
  `pavadinimas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kodas` text,
  `adresas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjektai`
--

INSERT INTO `subjektai` (`subjekto_id`, `pavadinimas`, `kodas`, `adresas`) VALUES
(1, 'Liverpool FC', '1', 'Liverpool'),
(2, 'asd', 'asd', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `sutartys`
--

CREATE TABLE `sutartys` (
  `sutarties_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `numeris` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kitas_numeris` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kita_salis` int(11) DEFAULT NULL,
  `data` date NOT NULL DEFAULT '0000-00-00',
  `terminas` date DEFAULT NULL,
  `objektas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `tipas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci,
  `pobudis` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci,
  `strukturinis_objektas` int(11) DEFAULT NULL,
  `atsakingas_asmuo` int(11) DEFAULT NULL,
  `pasirases_asmuo` int(11) NOT NULL DEFAULT '0',
  `dokumentas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci,
  `galiojimas` enum('taip','ne') CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL DEFAULT 'taip',
  `komentaras` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sutartys`
--

INSERT INTO `sutartys` (`sutarties_id`, `parent_id`, `numeris`, `kitas_numeris`, `kita_salis`, `data`, `terminas`, `objektas`, `tipas`, `pobudis`, `strukturinis_objektas`, `atsakingas_asmuo`, `pasirases_asmuo`, `dokumentas`, `galiojimas`, `komentaras`) VALUES
(1, NULL, 'asd', 'asd', 1, '2019-03-06', '2019-03-22', 'main', 'Žemė', 'Pirkimas', 1, 1, 2, '', 'taip', 'loan'),
(2, 1, '1234', 'asd', 1, '2019-05-10', '2008-09-26', '', 'Finansinės paslaugos', 'Išsinuomavimas', 1, 2, 1, '', 'taip', 'asdasd'),
(3, NULL, 'as', 'as', 1, '2019-05-15', '1111-11-11', '', 'Prekės', 'Nuomavimas', 1, 1, 2, '', 'taip', 'asd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asmenys`
--
ALTER TABLE `asmenys`
  ADD PRIMARY KEY (`asmens_id`);

--
-- Indexes for table `objektai`
--
ALTER TABLE `objektai`
  ADD PRIMARY KEY (`objekto_id`);

--
-- Indexes for table `subjektai`
--
ALTER TABLE `subjektai`
  ADD PRIMARY KEY (`subjekto_id`);

--
-- Indexes for table `sutartys`
--
ALTER TABLE `sutartys`
  ADD PRIMARY KEY (`sutarties_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asmenys`
--
ALTER TABLE `asmenys`
  MODIFY `asmens_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `objektai`
--
ALTER TABLE `objektai`
  MODIFY `objekto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subjektai`
--
ALTER TABLE `subjektai`
  MODIFY `subjekto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sutartys`
--
ALTER TABLE `sutartys`
  MODIFY `sutarties_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

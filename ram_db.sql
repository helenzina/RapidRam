-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 07 Ιαν 2024 στις 20:00:33
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `ram_db`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `ram`
--

CREATE TABLE `ram` (
  `product_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `ram`
--

INSERT INTO `ram` (`product_id`, `brand`, `model`, `capacity`, `channel`, `speed`, `price`, `photo`) VALUES
(1, 'Corsair', 'Vengeance RGB Pro', 8, 1, 3200, 35, '1.jpeg'),
(2, 'Corsair', 'Vengeance RGB Pro', 16, 1, 3200, 70, '1.jpeg'),
(3, 'Corsair', 'Vengeance RGB Pro', 32, 1, 3200, 85, '1.jpeg'),
(4, 'Corsair', 'Vengeance RGB Pro', 8, 1, 3000, 30, '1.jpeg'),
(5, 'Corsair', 'Vengeance RGB Pro', 16, 1, 3000, 65, '1.jpeg'),
(6, 'Corsair', 'Vengeance RGB Pro', 32, 1, 3000, 80, '1.jpeg'),
(7, 'Corsair', 'Vengeance RGB Pro', 16, 1, 3600, 70, '1.jpeg'),
(8, 'Corsair', 'Vengeance RGB Pro', 16, 2, 3200, 65, '2.jpeg'),
(9, 'Corsair', 'Vengeance RGB Pro', 16, 2, 3600, 80, '2.jpeg'),
(10, 'Corsair', 'Vengeance RGB Pro', 16, 2, 2666, 60, '2.jpeg'),
(11, 'Corsair', 'Vengeance RGB Pro', 16, 2, 3000, 70, '2.jpeg'),
(12, 'Corsair', 'Vengeance RGB Pro', 32, 2, 3600, 95, '2.jpeg'),
(13, 'Corsair', 'Vengeance RGB Pro', 32, 2, 3200, 90, '2.jpeg'),
(14, 'Corsair', 'Vengeance RGB Pro', 64, 2, 3200, 150, '2.jpeg'),
(15, 'Corsair', 'Vengeance RGB Pro', 32, 2, 3000, 85, '2.jpeg'),
(16, 'Corsair', 'Vengeance LPX', 16, 2, 3600, 60, '3.jpeg'),
(17, 'Corsair', 'Vengeance LPX', 16, 2, 3000, 50, '3.jpeg'),
(18, 'Corsair', 'Vengeance LPX', 16, 2, 3200, 60, '3.jpeg'),
(19, 'Corsair', 'Vengeance LPX', 32, 2, 3200, 80, '3.jpeg'),
(20, 'Corsair', 'Vengeance LPX', 64, 2, 3200, 120, '3.jpeg'),
(21, 'Corsair', 'Vengeance LPX', 8, 1, 3200, 30, '4.jpeg'),
(22, 'Corsair', 'Vengeance LPX', 8, 1, 3000, 25, '4.jpeg'),
(23, 'Kingston', 'Fury Beast', 8, 1, 3200, 25, '5.jpeg'),
(24, 'Kingston', 'Fury Beast', 16, 2, 3200, 40, '6.jpeg'),
(25, 'Kingston', 'Fury Beast', 32, 2, 3200, 80, '6.jpeg'),
(26, 'Kingston', 'Fury Beast', 64, 2, 3200, 120, '6.jpeg'),
(27, 'Kingston', 'Fury Beast RGB', 16, 2, 3200, 50, '7.jpeg'),
(28, 'Kingston', 'Fury Beast RGB', 32, 2, 3200, 100, '7.jpeg'),
(29, 'Kingston', 'Fury Beast RGB', 64, 2, 3200, 160, '7.jpeg'),
(30, 'G.Skill', 'Aegis', 8, 1, 3000, 20, '8.jpeg'),
(31, 'G.Skill', 'Aegis', 16, 1, 3200, 35, '8.jpeg'),
(32, 'G.Skill', 'Aegis', 16, 2, 3200, 60, '9.jpeg'),
(33, 'G.Skill', 'Aegis', 32, 2, 3200, 100, '9.jpeg'),
(34, 'G.Skill', 'Aegis', 64, 2, 3200, 130, '9.jpeg'),
(35, 'G.Skill', 'Ripjaws V', 16, 2, 3200, 60, '10.jpeg'),
(36, 'G.Skill', 'Ripjaws V', 16, 2, 3600, 60, '10.jpeg'),
(37, 'G.Skill', 'Ripjaws V', 32, 2, 3200, 120, '10.jpeg'),
(38, 'G.Skill', 'Ripjaws V', 64, 2, 3200, 170, '10.jpeg'),
(39, 'G.Skill', 'Trident Z RGB', 16, 2, 3600, 70, '11.jpeg'),
(40, 'G.Skill', 'Trident Z RGB', 16, 2, 3200, 65, '11.jpeg'),
(41, 'G.Skill', 'Trident Z RGB', 32, 2, 3600, 140, '11.jpeg'),
(42, 'G.Skill', 'Trident Z RGB', 64, 2, 3600, 200, '11.jpeg'),
(43, 'TeamGroup', 'T-Force Delta RGB', 16, 2, 3600, 60, '12.jpeg'),
(44, 'TeamGroup', 'T-Force Delta RGB', 16, 2, 3200, 50, '12.jpeg'),
(45, 'TeamGroup', 'T-Force Delta RGB', 32, 2, 3600, 120, '12.jpeg'),
(46, 'TeamGroup', 'T-Force Delta RGB', 32, 2, 3200, 100, '12.jpeg'),
(47, 'TeamGroup', 'T-Force Vulcan Z', 16, 2, 3200, 45, '13.jpeg'),
(48, 'TeamGroup', 'T-Force Vulcan Z', 16, 2, 3600, 55, '13.jpeg'),
(49, 'TeamGroup', 'T-Force Vulcan Z', 32, 2, 3200, 90, '13.jpeg'),
(50, 'TeamGroup', 'T-Force Vulcan Z', 32, 2, 3600, 120, '13.jpeg'),
(51, 'Patriot', 'Viper Steel', 8, 1, 3200, 25, '18.jpeg'),
(52, 'Patriot', 'Viper Steel', 8, 1, 3600, 30, '18.jpeg'),
(53, 'Patriot', 'Viper Steel', 16, 1, 3200, 50, '18.jpeg'),
(54, 'Patriot', 'Viper Steel', 16, 1, 3600, 60, '18.jpeg'),
(55, 'Patriot', 'Viper Steel', 16, 2, 3200, 60, '14.jpeg'),
(56, 'Patriot', 'Viper Steel', 32, 2, 3200, 100, '14.jpeg'),
(57, 'Patriot', 'Viper Steel', 64, 2, 3200, 130, '14.jpeg'),
(58, 'Patriot', 'Viper Steel', 16, 2, 3600, 65, '14.jpeg'),
(59, 'Patriot', 'Viper Steel', 32, 2, 3600, 110, '14.jpeg'),
(60, 'Patriot', 'Viper Steel', 64, 2, 3600, 140, '14.jpeg'),
(61, 'Patriot', 'Viper Steel RGB', 16, 2, 3600, 75, '15.jpeg'),
(62, 'Patriot', 'Viper Steel RGB', 32, 2, 3600, 120, '15.jpeg'),
(63, 'Patriot', 'Viper Steel RGB', 64, 2, 3600, 160, '15.jpeg'),
(64, 'Patriot', 'Viper Steel RGB', 16, 2, 3200, 70, '15.jpeg'),
(65, 'Patriot', 'Viper Steel RGB', 32, 2, 3200, 100, '15.jpeg'),
(66, 'Patriot', 'Viper Steel RGB', 64, 2, 3200, 150, '15.jpeg'),
(67, 'Patriot', 'Viper 4 Series', 16, 2, 3200, 45, '16.jpeg'),
(68, 'Patriot', 'Viper 4 Series', 16, 2, 3600, 55, '16.jpeg'),
(69, 'Patriot', 'Viper 4 Series', 32, 2, 3200, 85, '16.jpeg'),
(70, 'Patriot', 'Viper 4 Series', 64, 2, 3200, 125, '16.jpeg'),
(71, 'Patriot', 'Viper 4 Blackout', 16, 2, 3200, 50, '17.jpeg'),
(72, 'Patriot', 'Viper 4 Blackout', 16, 2, 3600, 60, '17.jpeg'),
(73, 'Patriot', 'Viper 4 Blackout', 32, 2, 3200, 90, '17.jpeg'),
(74, 'Patriot', 'Viper 4 Blackout', 32, 2, 3600, 95, '17.jpeg');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `ram`
--
ALTER TABLE `ram`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `ram`
--
ALTER TABLE `ram`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 04:52 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be18_cr5_animal_adoption_jaimecoca`
--
CREATE DATABASE IF NOT EXISTS `be18_cr5_animal_adoption_jaimecoca` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be18_cr5_animal_adoption_jaimecoca`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `size` varchar(10) NOT NULL,
  `age` int(3) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `vaccinated` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `location`, `picture`, `description`, `size`, `age`, `color`, `type`, `vaccinated`, `status`) VALUES
(1, 'Chula', 'Schnirchgasse 11', '642707ee85f95.jpg', 'A very nice and friendly dog', 'Medium', 6, 'Black and White', 'Dog', 'Yes', 'Adopted'),
(18, 'Pitty', 'Landstrasse 32', '642830d81698e.jpg', 'Scarlet-headed Blackbird', 'Small', 9, 'Blue', 'Bird', 'No', 'Adopted'),
(19, 'Puchy', 'Ruheppgasse24', '6428325e8ef96.jpg', 'Green Singing Finch', 'Small', 9, 'Yellow', 'Bird', 'Yes', 'Available'),
(20, 'Blacky', 'Simmering14', '6428334333192.jpg', 'Friendly, Affectionate, Loves kisses', 'Small', 1, 'Black', 'Dog', 'Yes', 'Available'),
(21, 'Alfred', 'Reumanplatz10', '642834b1c0a27.jpg', 'Friendly, Affectionate, Playful, Funny, Loves kisses', 'Medium', 6, 'Brown ', 'Dog', 'Yes', 'Available'),
(22, 'Lowey', 'Keinstadgutgasse 9', '6428368de4841.jpg', 'Friendly, Affectionate, Loyal, Gentle, Playful, Smart, Protective, Brave, Curious, Independent, Athletic, Dignified', 'Large', 8, 'Black and Brown', 'Dog', 'No', 'Adopted'),
(23, 'Funny', 'Hutteldorfstrasse 28', '64283880e982c.jpg', 'A nice lovely cat', 'Medium', 9, '', 'Cat', 'Yes', 'Available'),
(24, 'Sleepy', 'Mullstrasse 12', '642839296daf5.jpg', 'Kid friendly dog', 'Medium', 6, 'White', 'Dog', 'Yes', 'Available'),
(25, 'Kitty', 'Jägerstrasse 23', '64283991b3089.jpg', 'Quiet, independet cat', 'Large', 11, 'White', 'Cat', 'Yes', 'Adopted'),
(26, 'Ron', 'Wiedner Hauptstrasse 45', '642839f95beb2.jpg', 'Kid friendly, energic and lovely dog', 'Medium', 5, 'Brown', 'Dog', 'Yes', 'Available'),
(27, 'Maddy', 'Lassallestrasse 65', '64283b8c0d405.jpg', 'A quiet and peacyful cat', 'Large', 13, 'White', 'Cat', 'Yes', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(4) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `password`, `email`, `picture`, `address`, `status`) VALUES
(2, 'Mark', 'Anthony', '630455859', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', 'mark@gmail.com', '642812647265c.jpg', 'Miami Av. 32', 'user'),
(3, 'Jaime', 'Coca', '2147483647', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'jaime@gmail.com', 'avatar.png', 'Kleingasse 54', 'adm'),
(4, 'Anna', 'Miller', '6604748364', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', 'anamiller@gmail.com', '6428129871ad2.jpg', 'Donaugasse 11', 'user'),
(6, 'Hans', 'Koller', '066055444974', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', 'hans@hotmail.com', '64283cde817fe.jpg', 'Lasallestrasse 56', 'user'),
(7, 'Marie', 'Curie', '06857789542', '1718c24b10aeb8099e3fc44960ab6949ab76a267352459f203ea1036bec382c2', 'mariecurie@gmail.com', '64283d2cd26ec.jpg', 'Markusgasse 23', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 06:52 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctioncys`
--

-- --------------------------------------------------------

--
-- Table structure for table `addauction`
--

CREATE TABLE `addauction` (
  `id` int(255) NOT NULL,
  `lot_number` varchar(255) NOT NULL,
  `artist_name` varchar(255) NOT NULL,
  `year_produced` varchar(255) NOT NULL,
  `subject_classification` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auction_date` date NOT NULL,
  `estimated_price` decimal(10,2) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `drawing_medium` varchar(255) NOT NULL,
  `framed` tinyint(1) NOT NULL,
  `dimensions_height` decimal(10,2) NOT NULL,
  `dimensions_length` decimal(10,2) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addauction`
--

INSERT INTO `addauction` (`id`, `lot_number`, `artist_name`, `year_produced`, `subject_classification`, `description`, `auction_date`, `estimated_price`, `category_name`, `drawing_medium`, `framed`, `dimensions_height`, `dimensions_length`, `image_path`) VALUES
(3, '09872637', 'Bidhan', '2003', 'animal', 'Best', '2024-07-24', '5000.00', 'drawings', 'water colour', 1, '20.00', '30.00', './uploaded_files/29d5b22cc988dd2def8aa3d88e1c3c98.png'),
(6, '09865464', 'olive', '2001', 'landscape', 'gxvgxv', '2024-08-02', '2000.00', 'drawings', 'oil panting', 0, '20.00', '20.00', './uploaded_files/db61d9be28ae06605ce59150b474051e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `addcategory`
--

CREATE TABLE `addcategory` (
  `id` int(255) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addcategory`
--

INSERT INTO `addcategory` (`id`, `category_name`) VALUES
(1, 'photographic '),
(4, 'pantings drawing');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `role`) VALUES
(3, 'sonam@gmail.com', '$2y$10$v832E/I/Zw3.oLd.0o/YW./aFGmE7krVnUof5hWYwBKIePPmUJ9/W', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `auction_id`, `bid_amount`) VALUES
(1, 3, '6000.00'),
(2, 3, '7000.00'),
(3, 3, '8000.00'),
(4, 3, '9000.00'),
(5, 3, '10000.00'),
(6, 3, '12000.00'),
(7, 3, '13000.00'),
(8, 3, '14000.00'),
(9, 6, '3000.00');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` int(255) NOT NULL,
  `number` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `address`, `number`, `password`, `role`) VALUES
(5, 'rohan', 'ro@gmail.com', 0, 2147483647, '$2y$10$yfVke1KGb55zKP10MVT0t.1NVT1WbhrXOnj9TMfg6d/oSVVbqBGAC', 'user'),
(6, 'sonam', 'sonam@gmail.com', 0, 2147483647, '$2y$10$h/RvajBc30XoleKvMp1HY.Vi9WmecwXpD57NNzgiUBgBFbb8xrPYu', 'admin'),
(7, 'ram', 'ram@gmail.com', 0, 2147483647, '$2y$10$/Gj5bX1Q.FYfTxmq43iCN.GZFQMHoSKKNWH2AbRpEUkMTtdNBmCc2', 'admin'),
(8, 'sonam', 'sonam@gmail.com', 0, 2147483647, '$2y$10$NyIiWuDNHnOQo7wFDGpxAe0r.PJVqZiLSlO7KXaeDjLIsk0vnLiPG', 'admin'),
(9, 'numa', 'numa@gmail.com', 0, 2147483647, '$2y$10$I2ZFpSrOGSL0UmtWD/x75O0SYZOx9YiHUAnQR6C1WwYdo7QXEG.le', 'admin'),
(10, 'sita', 'sita@gmail.com', 0, 2147483647, '$2y$10$jhes6cLqHILrvIHxgBrFhepG7D2ZWI.ItsdX8y9C8WhOE2daiqOUO', 'seller'),
(11, 'ravii', 'ravi@gmail.com', 0, 2147483647, '$2y$10$vMkKcFqu5eHDZeGSY6.BKe74gLWeo8amVcx9DOL.LaAVvMBPwV/Sm', 'user'),
(12, 'Gita', 'gita@gmail.com', 0, 2147483647, '$2y$10$yEwwJ7Sx8dcab4eLXCdrVOT21z0YL4aPIMQAVbHrLaWLEXklSmlJy', 'seller'),
(13, 'Bidhan', 'b1@gmail.com', 0, 2147483647, '$2y$10$AomgoeG4WWOoevBinmdkO.z4KrHp3tT9DybvLo5hJMdS/u.zgI266', 'user'),
(14, 'thv', 'thv@gmail.com', 0, 2147483647, '$2y$10$/BKiUYg3EM9PXV8lx4eqx.cvZ/05r31rj.FPdKxiIZXkHlxAAqSw.', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addauction`
--
ALTER TABLE `addauction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addcategory`
--
ALTER TABLE `addcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_id` (`auction_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addauction`
--
ALTER TABLE `addauction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `addcategory`
--
ALTER TABLE `addcategory`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`auction_id`) REFERENCES `addauction` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

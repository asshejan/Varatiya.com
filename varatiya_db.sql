-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 30, 2024 at 05:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `varatiya_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`username`, `email`, `password`, `banned`) VALUES
('shejan1', 'shejan1@gmail.com', '$2y$10$Ex0ymSECPD.nY9zIMkxbp.WprPkZFO8b3156.UfjsBch7RJMTjFam', 0),
('shejan2', 'shejan2@gmail.com', '$2y$10$1gDqpgAdOETMDQw0a9trmuCeZEIzKRy.ahk1uSNj3b/LASexBYijS', 0),
('shejan3', 'shejan3@gmail.com', '$2y$10$1QwwOD/R8z/Z0Obsaf0MjewuzX/Nf9K5UqU72KUc4TE7bTO8NkTtC', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Listing`
--

CREATE TABLE `Listing` (
  `id` int(11) NOT NULL,
  `type` enum('Apartment','Villa','Home','Sublet','Building','Townhouse','Hostel','Garage') NOT NULL,
  `status` enum('For Sell','For Rent') NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `sqft` int(11) NOT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `image_url` varchar(2083) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `buyerContact` varchar(15) NOT NULL,
  `Description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Listing`
--

INSERT INTO `Listing` (`id`, `type`, `status`, `title`, `price`, `address`, `city`, `country`, `sqft`, `bedrooms`, `bathrooms`, `image_url`, `created_at`, `updated_at`, `buyerContact`, `Description`) VALUES
(2, 'Villa', 'For Rent', 'Spacious Villa in Chattogram', 30000.00, 'Near Patenga Beach', 'Chattogram', 'Bangladesh', 2500, 4, 3, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 12:46:03', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(3, 'Garage', 'For Sell', 'Affordable Garage in Khulna', 7000.00, 'Road 3, Sonadanga', 'Khulna', 'Bangladesh', 500, 1, 1, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 12:46:03', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(4, 'Apartment', 'For Sell', 'Modern Apartment in Dhaka', 9500000.00, '123 Gulshan Ave', 'Dhaka', 'Bangladesh', 1500, 3, 2, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(5, 'Villa', 'For Rent', 'Luxury Villa in Chittagong', 150000.00, '45 Sea View Road', 'Chittagong', 'Bangladesh', 3500, 5, 4, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(6, 'Home', 'For Sell', 'Cozy Home in Sylhet', 3500000.00, '88 Green Street', 'Sylhet', 'Bangladesh', 2000, 4, 3, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(7, 'Sublet', 'For Rent', 'Sublet Available in Barisal', 8000.00, '12 Lake Road', 'Barisal', 'Bangladesh', 800, 1, 1, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(8, 'Building', 'For Sell', 'Commercial Building in Dhaka', 75000000.00, '56 Motijheel', 'Dhaka', 'Bangladesh', 10000, NULL, NULL, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(9, 'Townhouse', 'For Rent', 'Spacious Townhouse in Khulna', 40000.00, '14 Rupsha Road', 'Khulna', 'Bangladesh', 2200, 3, 3, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(10, 'Hostel', 'For Rent', 'Affordable Hostel in Dhaka', 5000.00, '66 Banani', 'Dhaka', 'Bangladesh', 500, 1, 1, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(11, 'Garage', 'For Rent', 'Secure Garage in Rajshahi', 2000.00, '22 College Road', 'Rajshahi', 'Bangladesh', 300, NULL, NULL, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(12, 'Villa', 'For Sell', 'Exquisite Villa in Cox\'s Bazar', 12000000.00, '99 Beach View', 'Cox\'s Bazar', 'Bangladesh', 4000, 6, 5, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '01701909276', 'One of the prettiest accomodtion with all the facilities available. Neighbours are great as well and well behaved.'),
(13, 'Apartment', 'For Rent', 'Serviced Apartment in Dhaka', 75000.00, '33 Dhanmondi', 'Dhaka', 'Bangladesh', 1800, 3, 2, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-27 13:35:47', '2024-11-29 02:10:45', '', ''),
(14, 'Apartment', 'For Sell', 'Gulshan 2, Dhaka', 75000.00, 'Road #15, Block #C, Gulshan, Dhaka', 'Dhaka', 'Bangladesh', 2000, 4, 3, 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aG91c2V8ZW58MHx8MHx8fDA%3D', '2024-11-28 21:57:48', '2024-11-29 02:09:40', '', 'Nothing, Buy or die :/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `Listing`
--
ALTER TABLE `Listing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Listing`
--
ALTER TABLE `Listing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2020 at 01:37 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quantoxinternship`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `description`) VALUES
(1, 'Admin'),
(2, 'Backend Developer'),
(3, 'Frontend Developer');

-- --------------------------------------------------------

--
-- Table structure for table `subroles`
--

DROP TABLE IF EXISTS `subroles`;
CREATE TABLE IF NOT EXISTS `subroles` (
  `id_subroles` int(11) NOT NULL AUTO_INCREMENT,
  `sdescription` varchar(45) NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`id_subroles`),
  KEY `subroles_roles_idx` (`roles_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subroles`
--

INSERT INTO `subroles` (`id_subroles`, `sdescription`, `roles_id`) VALUES
(1, 'Angular', 3),
(2, 'React', 3),
(3, 'Vue', 3),
(4, 'PHP', 2),
(5, 'NodeJs', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sub_subroles`
--

DROP TABLE IF EXISTS `sub_subroles`;
CREATE TABLE IF NOT EXISTS `sub_subroles` (
  `id_sub_subroles` int(11) NOT NULL AUTO_INCREMENT,
  `ssdescription` varchar(45) NOT NULL,
  `subrole_id` int(11) NOT NULL,
  PRIMARY KEY (`id_sub_subroles`),
  KEY `sub_subroles_subrole_idx` (`subrole_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_subroles`
--

INSERT INTO `sub_subroles` (`id_sub_subroles`, `ssdescription`, `subrole_id`) VALUES
(9, 'AngularJs', 1),
(10, 'Angular 2', 1),
(11, 'React native', 2),
(12, 'Symfony', 4),
(13, 'Silex', 4),
(14, 'Laravel', 4),
(15, 'Lumen', 4),
(16, 'Express', 5),
(17, 'NestJS', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(45) NOT NULL,
  `role_id` int(11) NOT NULL,
  `subrole_id` int(11) NOT NULL,
  `sub_subrole_id` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `users_roles_idx` (`role_id`),
  KEY `users_subroles_idx` (`subrole_id`),
  KEY `users_sub_subroles_idx` (`sub_subrole_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `password`, `role_id`, `subrole_id`, `sub_subrole_id`) VALUES
(6, 'sigvard Mali', 'sgove3@slideshare.net', '202cb962ac59075b964b07152d234b70', 2, 5, 17),
(7, 'Aleksandar Cakic', 'cakic_aleksandar@yahoo.com', 'ef20c44fb65029e42b45891f1877bd78', 2, 4, 14),
(8, 'Dawson', 'adawson1@walmart.com', '51ea0114e5e7ba6a6cad70f1cd33b1b4', 2, 4, 12),
(9, 'Webley', 'kwebley2@hugedomains.com', '6cb628dc827d5c02478b4b51ed5bccf8', 2, 4, 13),
(10, 'Borborough', 'sborborough4@angelfire.com', '34acf4e7d20d1588012145a516a15929', 2, 4, 14),
(11, 'Claughton', 'mclaughton5@comcast.net', 'd7ef698d2e141a05ac87d4786b8f011b', 2, 4, 15),
(12, 'Sholem', 'ksholem6@craigslist.org', '97463f410ec1986d0532d8411cee782b', 2, 5, 16),
(13, 'Petkov', 'bpetkov7@mashable.com', '17a241df3bac2fe92b9033995c8d5df4', 2, 5, 17),
(14, 'Fiennes', 'cfiennes8@washington.edu', '2ccc27d99377011f05a418ad8480ce96', 3, 1, 9),
(15, 'Wardell', 'jwardell9@latimes.com', 'c64fc4142e1ded8ddd761c9b28854288', 3, 1, 10),
(16, 'Kiraly', 'okiraly0@blog.com', '78ea42e08e97e5cf62973f05cda0a07b', 3, 2, 11),
(17, 'Yurivtsev', 'myurivtsev1@columbia.edu', '238961d579f3e34477bd0915e72a1170', 3, 3, 11);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subroles`
--
ALTER TABLE `subroles`
  ADD CONSTRAINT `subroles_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_subroles`
--
ALTER TABLE `sub_subroles`
  ADD CONSTRAINT `sub_subroles_subrole` FOREIGN KEY (`subrole_id`) REFERENCES `subroles` (`id_subroles`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_sub_subroles` FOREIGN KEY (`sub_subrole_id`) REFERENCES `sub_subroles` (`id_sub_subroles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_subroles` FOREIGN KEY (`subrole_id`) REFERENCES `subroles` (`id_subroles`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

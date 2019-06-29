-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2019 at 09:58 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `userdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pendings`
--

CREATE TABLE IF NOT EXISTS `pendings` (
  `user_type` varchar(40) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendings`
--

INSERT INTO `pendings` (`user_type`, `first_name`, `last_name`, `email`, `password`) VALUES
('Teacher', 'saduni', 'harshamali', 'teacher2@yahoo.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `user_type` varchar(40) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `require_delete_account` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `first_name`, `last_name`, `email`, `password`, `last_login`, `is_deleted`, `require_delete_account`) VALUES
(3, 'Student', 'kasun', 'bandara', 'kasun@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(4, 'Book Keeper', 'sameera', 'Rathnayake', 'sameera@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(5, 'Student', 'sharmal', 'vithana', 'damith@ab.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-05-19 21:02:29', 0, 0),
(7, 'Book Keeper', 'nial', 'diaus', 'nial@123.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(8, 'Librarian', 'mithun', 'fernando', 'mithun@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-06-13 16:01:50', 1, 0),
(9, 'Student', 'edwin', 'root', 'edwin12@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(10, 'Teacher', 'mahela', 'jayawardana', 'mahela@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(11, 'Teacher', 'sanath', 'jayasooriya', 'sanath@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 1, 0),
(12, 'Librarian', 'randika', 'jeewantha', 'randikaherath0@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-06-20 01:19:29', 0, 0),
(13, 'Teacher', 'saduni', 'herath', 'teacher@yahoo.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(35, 'Student', 'kasun', 'udayanga', 'student@yahoo.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pendings`
--
ALTER TABLE `pendings`
 ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

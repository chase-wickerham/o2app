-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 14, 2023 at 11:26 AM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `o2appdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `graph_id` int(11) DEFAULT '0',
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `content`, `created_at`, `graph_id`, `title`) VALUES
(5, 10, 'Hi, I\'m Alpha! This is my first test post!', '2023-08-12 19:38:18', 0, 'Alpha Post Number One!'),
(6, 11, 'It\'s me, Test User Bravo! I\'m making another post!', '2023-08-12 19:39:28', 0, 'Bravo Post!'),
(7, 12, 'Hey, It\'s Charlie. Thought I\'d make a test post also.', '2023-08-12 19:40:19', 0, 'Charlie Time'),
(8, 13, 'It\'s delta time everyone. This is the test post that\'s going to change everything.', '2023-08-12 19:41:28', 0, 'Deltapost'),
(9, 14, 'Hey Everyone, Test User Echo here. That last post didn\'t actually change everything.', '2023-08-12 19:42:46', 0, 'I am the Echo. I am the Echo.'),
(11, 14, 'I just cant stop echoposting', '2023-08-12 19:51:10', 0, 'Echopost3 Cause'),
(12, 10, 'Alpha here with a nighttime test', '2023-08-13 01:19:22', 0, 'Alpha Post Nighttime'),
(13, 10, 'Just hitting those metrics', '2023-08-13 18:44:56', 0, 'Alpha third post maybe'),
(14, 14, 'This is to bump me over Alpha', '2023-08-13 20:53:51', 0, 'Echo posting again and again'),
(15, 14, 'I have the most posts!', '2023-08-13 20:54:05', 0, 'I need to win'),
(16, 16, 'I\'m the sixth test user, Foxtrot!', '2023-08-13 21:50:35', 0, 'Foxtrot on the scene'),
(17, 16, 'Sorry Just Testing Again Here', '2023-08-13 21:51:04', 0, 'Did I do that right?'),
(19, 18, 'I deleted the first one because of a spelling mistkae.', '2023-08-14 00:56:56', 0, 'Gammtest 2'),
(20, 18, 'Lad black jack overhaul fire in the hole mizzenmast pirate main sheet to go on account parley Arr. Scallywag Nelsons folly Arr Letter of Marque bilged on her anchor strike colors matey scuttle gibbet lanyard. Crow\'s nest Blimey mizzen mizzenmast scourge of the seven seas aft belaying pin quarterdeck handsomely hogshead.\r\n\r\nMaroon reef sails six pounders overhaul killick mizzen pinnace Buccaneer haul wind keel. Blimey rope\'s end chandler doubloon loaded to the gunwalls wherry crimp prow poop deck Barbary Coast. Squiffy jib piracy lee pink log Nelsons folly hogshead Davy Jones\' Locker nipperkin.\r\n\r\nJack keelhaul Shiver me timbers cackle fruit loaded to the gunwalls Blimey quarterdeck boatswain gaff black jack. Yawl splice the main brace cog cackle fruit rope\'s end gunwalls stern galleon lateen sail ballast. Coxswain jack Privateer Admiral of the Black draft scourge of the seven seas Sail ho long boat provost code of conduct.', '2023-08-14 00:59:32', 0, 'Yo Ho Ho');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT 'Anonymous User',
  `password` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` int(12) NOT NULL DEFAULT '1',
  `lastIP` varchar(255) NOT NULL,
  `tagline` varchar(255) NOT NULL DEFAULT 'I''m New!'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `username`, `password`, `userid`, `created`, `avatar`, `lastIP`, `tagline`) VALUES
('testuseralpha@test.com', 'Test User Alpha', '$2y$10$x4xYpCoa8t2oCJ46W6O6J.GbLHzK47Wy616rSVaYfF6kZHeQHKbvu', 10, '2023-08-12 19:36:32', 1, '24.144.130.80', 'I am the first test user!'),
('testuserbravo@test.com', 'Test User Bravo', '$2y$10$486LFE63bamFjD5Qx76ciuauuqVM2SziCcO29xCwwLor.Urz0PKMO', 11, '2023-08-12 19:36:48', 2, '24.144.130.80', 'I am the bravest test user!'),
('testusercharlie@test.com', 'Test User Charlie', '$2y$10$EQOveAdvJsVqYYzEoceYW.Eeqk2.RTmmwGmf0/tQt/tGApKShA/AK', 12, '2023-08-12 19:37:07', 3, '24.144.130.80', 'Charlie The Big Shot'),
('testuserdelta@test.com', 'Test User Delta', '$2y$10$X2MdWEqGtooRZf3hqThGQu5OXLILsV4PkWhPP5DkqGdx3.GrkE8Um', 13, '2023-08-12 19:37:24', 4, '24.144.130.80', 'The delta is where the party is at'),
('testuserecho@test.com', 'Test User Echo', '$2y$10$tWR4QESS3.O/zdiIKCqBn.YZcXNtVCfqHxRxq.lnQ5kW2esfG1sye', 14, '2023-08-12 19:41:52', 2, '24.144.130.80', 'It\'s me, Echo. It\'s me, Echo.'),
('testuserfoxtrot@test.com', 'Test User Foxtrot', '$2y$10$HTM7nkkjg3LH/GCMH/avDOG1iWLSK5kb21.LGeHZdDN7JtLDPeHne', 16, '2023-08-13 21:49:47', 4, '24.144.130.80', 'Trottin\' Like A Fox'),
('darcy@reallybigtractor.com', 'Darcy', '$2y$10$jCLj7KyljGdEYrZJL6tY0ey6hJgdwGHGRgxQUuIEykcT.piQmWjKO', 17, '2023-08-14 00:03:30', 2, '172.59.25.105', 'I have a really big tractor.'),
('testusergamma@test.com', 'Test User Gamma', '$2y$10$rPmiRZBjMazMDAfxaYD7lO0xk9NXJ48fs/is0dx7EVx10jqGjK3GS', 18, '2023-08-14 00:37:44', 2, '24.144.130.80', 'Gamma Ray\'D'),
('email@email.com', 'Anonymous User', '$2y$10$tkqHYfi1iIKEWBHBAzHCyOl/vR769h53fLLUbdlri6WRY3OoyRThO', 19, '2023-08-14 01:22:18', 4, '73.236.234.208', 'Le sigh... I\'m a battiboi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

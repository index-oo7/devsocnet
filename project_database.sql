-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2023 at 11:52 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_database`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addcomm` (IN `userid` INT, IN `postid` INT, IN `txt` TEXT)  BEGIN
  INSERT INTO users_comment (user_id, post_id,comment_text)
  VALUES (userid,postid,txt);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addpost` (IN `p_userid` INT, IN `p_caption` VARCHAR(255), IN `p_category` VARCHAR(255))  BEGIN
  INSERT INTO post (user_id, caption, category)
  VALUES (p_userid, p_caption, p_category);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getpost` (IN `id` INT)  BEGIN
    SELECT * FROM post WHERE post_id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `posts_procedure` (`userid` INT)  begin
select post_id from post where user_id = userid;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showcomm` (IN `p_user_id` INT, IN `p_post_id` INT)  BEGIN
    SELECT comment_text, created_datetime, user_id
    FROM users_comment
    WHERE user_id = p_user_id AND post_id = p_post_id;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fun_num_of_followed` (`user_id` INT) RETURNS INT(11) begin 
declare num_of_followed int;
select count(followed_user_id) into num_of_followed
from follower 
where following_user_id=user_id and following_status=1;
return num_of_followed;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fun_num_of_followers` (`user_id` INT) RETURNS INT(11) begin 
declare num_of_followers int;
select count(following_user_id) into num_of_followers
from follower 
where followed_user_id=user_id and following_status=1;
return num_of_followers;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE `app_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_surname` varchar(45) NOT NULL,
  `user_nickname` varchar(15) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `user_info` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_user`
--

INSERT INTO `app_user` (`user_id`, `user_name`, `user_surname`, `user_nickname`, `user_email`, `user_password`, `user_info`) VALUES
(1, 'milos', 'milovanovic', 'mikibog', 'milos@gmail.com', 'idegas', 'ovo je neki info jebemliga'),
(2, 'Luka', 'Radovanovic', '', 'index007@gmail.com', 'admin', 'ide gas micooooo');

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `following_user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL,
  `following_status` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follower`
--

INSERT INTO `follower` (`following_user_id`, `followed_user_id`, `following_status`) VALUES
(1, 2, 1),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE `keyword` (
  `keyword_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `keyword` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `caption` tinytext DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `uploaded_file` mediumtext NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `created_datetime`, `caption`, `category`, `uploaded_file`, `status`) VALUES
(2, 1, '2023-03-03 00:07:51', 'Ovo je prvi post koji je id usera 1', 'isprobavanje', '', 1),
(3, 2, '2023-03-03 00:09:13', 'ovo je drugi post koji treba da se vidi na time line\r\n', 'isprobavanje', '', 1),
(4, 2, '2023-03-03 00:09:32', 'ovo je drugi post koji treba da se vidi na time line\r\n', 'isprobavanje', '', 1),
(6, 1, '2023-03-03 00:11:11', 'drugi post kod milosa na profilu', 'isprobavanje', '', 1),
(7, 1, '2023-03-05 00:59:03', 'ovo je neki caption', 'testiranje', '', 1),
(8, 1, '2023-03-05 01:23:08', 'ovo je neki222 caption', 'testiranje', '', 1),
(9, 1, '2023-03-05 01:31:49', 'aaaaaaaaaaaaa', 'testiranje', '', 1),
(10, 1, '2023-03-05 01:54:59', 'aaaaaaaaaaaaaaa', 'ako ovo ne radi onda', '', 1),
(11, 1, '2023-03-05 01:56:13', 'aaaaaaaaaaaaaaa', 'ako ovo ne radi onda', '', 1),
(12, 1, '2023-03-05 01:58:21', 'aaaaaaaaaaaaaaa', 'ako ovo ne radi onda', '', 1),
(13, 1, '2023-03-09 00:24:36', 'ovo je pokazivanje da radi sve kako treba ', 'pokazivanje', '', 1),
(14, 1, '2023-03-09 00:24:39', 'ovo je pokazivanje da radi sve kako treba ', 'pokazivanje', '', 1),
(15, 1, '2023-03-09 00:25:34', 'kjgjgjl', 'vvzxc', '', 1),
(16, 1, '2023-03-10 16:47:34', 'kjgjgjl', 'vvzxc', '', 1),
(17, 1, '2023-03-10 16:47:59', 'kjgjgjl', 'vvzxc', '', 1),
(18, 1, '2023-03-10 16:49:51', 'kjgjgjl', 'vvzxc', '', 1),
(19, 1, '2023-03-10 16:50:21', 'kjgjgjl', 'vvzxc', '', 1),
(20, 2, '2023-03-10 16:58:16', 'Isporbavanje da li radi sve kako treba sa lukinog profila', 'testiranje', '', 1),
(21, 2, '2023-03-10 16:59:09', 'testiranje dodavanje i prikaz posta lukin profil ', 'testiranje', '', 1),
(22, 2, '2023-03-10 17:54:06', 'ae mile oplodime', 'ide mile', '', 1),
(23, 1, '2023-03-11 18:56:32', 'poslednji post', 'testiranje', '', 1),
(24, 1, '2023-03-11 19:05:22', 'ovo je slika ', 'slika', '', 1),
(25, 1, '2023-03-13 14:03:53', 'aseaeeaea', 'fdadfa', '', 1),
(26, 1, '2023-03-13 14:04:47', 'aseaeeaea', 'fdadfa', '', 1),
(27, 1, '2023-03-13 14:05:14', 'aseaeeaea', 'fdadfa', '', 1),
(28, 1, '2023-03-13 14:05:28', '', '', '', 1),
(29, 1, '2023-03-13 14:14:41', '', '', '', 1),
(30, 1, '2023-03-13 14:14:56', '', 'jel radio ovo ', '', 1),
(31, 1, '2023-03-13 14:16:35', '', 'ada', '', 1),
(32, 1, '2023-03-13 14:17:20', 'sdads', 'sjdfaskfj;asdf', '', 1),
(33, 1, '2023-03-14 16:30:14', '2', 'ae pls', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_comment`
--

CREATE TABLE `users_comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_text` tinytext NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_comment`
--

INSERT INTO `users_comment` (`comment_id`, `user_id`, `post_id`, `comment_text`, `created_datetime`) VALUES
(45, 1, 2, 'ovo je moj koment', '2023-03-16 16:59:59'),
(46, 1, 2, 'ovo je moj koment', '2023-03-16 16:59:59'),
(47, 1, 2, 'aaaaaaaaaaaaaaaa', '2023-03-16 17:01:04'),
(48, 1, 2, 'aaaaaaaaaaaaaaaa', '2023-03-16 17:01:06'),
(49, 1, 2, 'aaaaaaaaaaaaaaaa', '2023-03-16 17:02:34'),
(50, 1, 2, 'aaaa', '2023-03-16 17:02:38'),
(51, 1, 2, 'kkokokook', '2023-03-19 17:21:06'),
(52, 1, 6, 'kkokokook', '2023-03-19 17:21:13'),
(53, 1, 6, 'kkokokook', '2023-03-19 17:21:13'),
(54, 1, 6, 'kkokokook', '2023-03-19 17:21:14'),
(55, 1, 6, 'kkokokook', '2023-03-19 17:21:14'),
(56, 1, 2, 'jhjhjj', '2023-03-19 17:27:08'),
(57, 1, 2, 'jhjhjj', '2023-03-19 17:27:08'),
(58, 1, 2, 'aaaaaaa', '2023-03-19 17:44:23'),
(59, 1, 6, 'aaaaaaa', '2023-03-19 17:44:42'),
(60, 1, 7, 'aaaaaaa', '2023-03-19 17:45:01'),
(61, 1, 8, 'aaaaaaa', '2023-03-19 17:45:03'),
(62, 1, 9, 'aaaaaaa', '2023-03-19 17:45:04'),
(63, 1, 9, 'aaaaaaa', '2023-03-19 17:45:07'),
(64, 1, 9, 'aaaaaaa', '2023-03-19 17:45:10'),
(65, 1, 9, 'aaaaa', '2023-03-19 17:47:48'),
(66, 1, 8, 'dsdsdsd', '2023-03-19 17:47:50'),
(67, 1, 10, 'ghvhghjghjgjhg', '2023-03-19 17:47:59'),
(68, 1, 2, 'ide gas ja sambog', '2023-03-19 17:49:15'),
(69, 1, 2, 'aaaaaaaaaa', '2023-03-20 23:47:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD KEY `following_user_id` (`following_user_id`),
  ADD KEY `followed_user_id` (`followed_user_id`);

--
-- Indexes for table `keyword`
--
ALTER TABLE `keyword`
  ADD PRIMARY KEY (`keyword_id`),
  ADD KEY `keyword_ibfk_1` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_ibfk_1` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `users_comment`
--
ALTER TABLE `users_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `users_comment_ibfk_1` (`user_id`),
  ADD KEY `users_comment_ibfk_2` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_user`
--
ALTER TABLE `app_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `keyword`
--
ALTER TABLE `keyword`
  MODIFY `keyword_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users_comment`
--
ALTER TABLE `users_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `follower_ibfk_1` FOREIGN KEY (`following_user_id`) REFERENCES `app_user` (`user_id`),
  ADD CONSTRAINT `follower_ibfk_2` FOREIGN KEY (`followed_user_id`) REFERENCES `app_user` (`user_id`);

--
-- Constraints for table `keyword`
--
ALTER TABLE `keyword`
  ADD CONSTRAINT `keyword_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`user_id`);

--
-- Constraints for table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`user_id`),
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Constraints for table `users_comment`
--
ALTER TABLE `users_comment`
  ADD CONSTRAINT `users_comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`user_id`),
  ADD CONSTRAINT `users_comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

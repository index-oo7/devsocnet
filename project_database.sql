-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 01:10 PM
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
-- Database: `project_database`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addcomm` (IN `userid` INT, IN `postid` INT, IN `txt` TEXT)   BEGIN
  INSERT INTO users_comment (user_id, post_id,comment_text)
  VALUES (userid,postid,txt);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addpost` (IN `p_userid` INT, IN `p_caption` VARCHAR(255), IN `p_category` VARCHAR(255), IN `p_fileurl` VARCHAR(255), IN `p_filetype` VARCHAR(10))   BEGIN
  INSERT INTO post (user_id, caption, category,uploaded_file,file_ext)
  VALUES (p_userid, p_caption, p_category,p_fileurl,p_filetype);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `commentsofpost` (IN `p_post_id` INT)   BEGIN
    SELECT comment_text, created_datetime, user_id
    FROM users_comment
    WHERE post_id = p_post_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getpost` (IN `id` INT)   BEGIN
    SELECT * FROM post WHERE post_id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getuserbyid` (IN `userid` INT)   BEGIN
	SELECT * from app_user
    WHERE user_id=userid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `posts_procedure` (`userid` INT)   begin
select post_id from post where user_id = userid;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showcomm` (IN `p_post_id` INT)   BEGIN
    SELECT comment_text, created_datetime, user_id
    FROM users_comment
    WHERE post_id = p_post_id;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fun_num_of_followed` (`user_id` INT) RETURNS INT(11)  begin 
declare num_of_followed int;
select count(followed_user_id) into num_of_followed
from follower 
where following_user_id=user_id and following_status=1;
return num_of_followed;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fun_num_of_followers` (`user_id` INT) RETURNS INT(11)  begin 
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
(1, 'milos', 'milovanovic', 'BUKSNIC', 'milos@gmail.com', 'idegas', 'Gym rat bog i batina'),
(2, 'kokok', 'Radovanovic', 'lule', 'index007@gmail.com', 'admin', 'ide gas micooooo');

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
  `file_ext` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `created_datetime`, `caption`, `category`, `uploaded_file`, `file_ext`, `status`) VALUES
(2, 1, '2023-03-03 00:07:51', 'Ovo je prvi post koji je id usera 1', 'isprobavanje', '', '', 1),
(3, 2, '2023-03-03 00:09:13', 'ovo je drugi post koji treba da se vidi na time line\r\n', 'isprobavanje', '', '', 1),
(4, 2, '2023-03-03 00:09:32', 'ovo je drugi post koji treba da se vidi na time line\r\n', 'isprobavanje', '', '', 1),
(6, 1, '2023-03-03 00:11:11', 'drugi post kod milosa na profilu', 'isprobavanje', '', '', 1),
(7, 1, '2023-03-05 00:59:03', 'ovo je neki caption', 'testiranje', '', '', 1),
(77, 1, '2023-04-02 13:05:27', 'prvi put sa headerom bez fjala', 'testiranje', '', '', 1),
(78, 1, '2023-04-02 13:05:49', 'prvi put sa fajlom', 'testiranje ', '../../uploads/README.md', 'md', 1);

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
(70, 2, 3, 'komentar lukin na njegovom postu', '2023-03-28 14:04:55'),
(71, 2, 3, 'komentar lukin na njegovom postu', '2023-03-28 14:05:01'),
(72, 2, 4, 'haahahahah', '2023-03-28 14:05:07'),
(75, 2, 2, 'lukin komentar', '2023-03-28 14:14:46'),
(76, 2, 2, 'lukin komentar', '2023-03-28 14:14:49'),
(77, 2, 3, 'aaaa', '2023-03-28 14:38:13'),
(78, 2, 3, 'aaa', '2023-03-28 21:10:28'),
(79, 1, 2, 'komentar na prvom postu iz ajaxa iz komentara', '2023-03-30 16:30:35'),
(80, 1, 2, 'komentar na prvom postu iz ajaxa iz komentara', '2023-03-30 16:30:44'),
(81, 1, 2, 'ide gas ovo zapravo radi ', '2023-03-30 17:09:23'),
(82, 1, 2, 'ahahahah', '2023-03-30 17:10:48');

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
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users_comment`
--
ALTER TABLE `users_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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

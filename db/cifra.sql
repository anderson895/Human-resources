-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2024 at 08:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cifra`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `head_id` bigint(20) NOT NULL,
  `sign_in` datetime NOT NULL,
  `sign_out` datetime NOT NULL,
  `hour_count` int(11) NOT NULL,
  `verify_status` varchar(256) NOT NULL DEFAULT 'pending',
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `head_id`, `sign_in`, `sign_out`, `hour_count`, `verify_status`, `status`) VALUES
(14, 18, 2, '2024-08-27 11:24:00', '2024-08-27 01:24:00', 9, 'verified', 0),
(15, 18, 2, '2024-08-27 01:26:06', '2024-08-27 02:52:31', 1, 'verified', 0),
(16, 21, 25, '2024-09-28 19:12:53', '2024-09-28 19:13:00', 0, 'pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_responses`
--

CREATE TABLE `chatbot_responses` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `response` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_responses`
--

INSERT INTO `chatbot_responses` (`id`, `keyword`, `response`, `status`) VALUES
(1, 'hello', 'Hi there! How can I assist you today?', 0),
(2, 'how are you', 'I am just a bot, but I am doing great! How can I help you?', 0),
(3, 'info', 'Human Resource Information System (HRIS) is a software or online solution that helps organizations manage, streamline, and automate various HR processes and tasks. It serves as a centralized platform for storing employee data, managing payroll, tracking attendance, administering benefits, recruiting and onboarding, performance management, and more. HRIS systems often integrate with other business software, making it easier for HR departments to handle both administrative and strategic HR functions, improve efficiency, reduce manual workload, and ensure compliance with labor laws and regulations. These systems are essential for modern HR departments, providing valuable insights through analytics and reporting features, and enabling better decision-making.\n\n\n\n\n\n', 0),
(4, 'thanks', 'You’re welcome! If you have any more questions, feel free to ask.', 0),
(5, 'help', 'Sure! What do you need help with?', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_files`
--

CREATE TABLE `employee_files` (
  `id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `file_type` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  `file` text NOT NULL,
  `added_by` varchar(256) NOT NULL DEFAULT 'employee',
  `datetime_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_files`
--

INSERT INTO `employee_files` (`id`, `employee_id`, `file_type`, `description`, `file`, `added_by`, `datetime_created`, `status`) VALUES
(18, 18, 'NBI Clearance', 'asd', 'asdczxczxkdkqjwkejqwelkqmweblqwmebqlwemqwne.jpg', 'employee', '2024-08-28 17:37:23', 0),
(19, 18, 'Resume/CV', 'test', '972336CAPSTONE-PROJECT-PROPOSAL-FILE-medyo-final.pdf', 'admin', '2024-08-28 17:49:42', 0),
(20, 31, 'Resume/CV', 'asdasd', '4724544787623.png', 'admin', '2024-08-28 17:53:12', 0),
(21, 32, 'Resume/CV', 'Resume/CV', '77246466bf07b5b2473-CAP_1_Group___3_-_Information-Guide-for-BulSU-Bustos-Students_FINAL.pdf', 'employee', '2024-08-28 18:51:29', 0),
(22, 33, 'Resume/CV', 'Resume/CV', '940643CAPSTONE-PROJECT-PROPOSAL-FILE-medyo-final.pdf', 'employee', '2024-08-28 19:06:41', 0),
(23, 21, 'Passport', 'others.', '463602CHAPTER_1__2___3_DOCU_-_TERA_MEETS_BYTE.pdf', 'employee', '2024-09-28 19:16:12', 0),
(24, 36, 'Resume/CV', 'Resume/CV', '919005CHRISTINE_cor.pdf', 'employee', '2024-09-28 19:53:16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `application_status` varchar(256) NOT NULL DEFAULT 'for review',
  `status` int(11) NOT NULL DEFAULT 0,
  `datetime_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `user_id`, `job_id`, `application_status`, `status`, `datetime_created`) VALUES
(1, 18, 1, 'hired', 0, '2024-08-13 20:35:23'),
(3, 20, 1, 'hired', 0, '2024-08-13 20:35:23'),
(4, 21, 2, 'hired', 0, '2024-08-26 13:40:19'),
(5, 22, 2, 'hired', 0, '2024-08-26 14:19:35'),
(6, 29, 1, 'for review', 0, '2024-08-28 02:28:49'),
(7, 31, 7, 'declined', 0, '2024-08-28 03:07:11'),
(8, 32, 1, 'for review', 0, '2024-08-28 18:51:29'),
(9, 33, 8, 'for review', 0, '2024-08-28 19:06:41'),
(10, 36, 2, 'for review', 0, '2024-09-28 19:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `job_posting`
--

CREATE TABLE `job_posting` (
  `id` bigint(20) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `position` varchar(256) NOT NULL,
  `location` varchar(256) NOT NULL,
  `datetime_created` datetime NOT NULL DEFAULT current_timestamp(),
  `image` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posting`
--

INSERT INTO `job_posting` (`id`, `title`, `description`, `position`, `location`, `datetime_created`, `image`, `status`) VALUES
(1, 'Job Opening for Nurse ', 'Immediate hiring !!!', 'Full-time', 'Office of the nurses', '2024-08-11 18:27:19', 'bg1.png', 0),
(2, 'Job Opening (Macho Dancer)', 'Psst 150', 'Part-time', 'Office Of The President', '2024-08-09 18:30:52', 'a.jpg', 0),
(3, 'sad', 'Sad', 'Remote', 'Sad', '2024-08-11 18:31:06', 'clip.png', 1),
(4, 'zxc', 'zxc', 'Part-time', 'zxcz', '2024-08-11 18:31:31', 'pen.png', 1),
(5, 'ads', 'dasda', 'Remote', 'asd', '2024-08-11 18:31:53', 'bgg2.png', 1),
(6, 'ads', 'dasda', 'Remote', 'asd', '2024-08-11 18:32:12', 'bgg2.png', 1),
(7, 'NDT emee eme', 'Are you ready to take the next step in your career? We are actively seeking talented, passionate, and driven individuals to join our dynamic team across a variety of roles. As a growing organization, we offer exciting opportunities for professional development and personal growth. We value creativity, collaboration, and a strong work ethic, and we believe in empowering our employees to achieve their full potential. Whether you\'re an experienced professional looking to make a significant impact or a recent graduate eager to learn and grow, we have positions that can align with your skills and aspirations. Explore our job openings and discover how you can contribute to our mission while building a rewarding career with us. Apply today and become a part of our vibrant and supportive community!', 'Full-time', 'Simlong, Batangas City', '2024-08-26 14:22:53', 'book.png', 0),
(8, 'ui ux', 'Join our dynamic team! We&#039;re looking for motivated individuals to fill various roles in our company. If you&#039;re passionate, hardworking, and ready to contribute to a growing organization, we want to hear from you! Explore our current openings and take the next step in your career with us.', 'Full-time', 'work from home', '2024-08-28 18:12:08', 'c.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `leave_request`
--

CREATE TABLE `leave_request` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `head_id` bigint(20) NOT NULL,
  `type` varchar(256) NOT NULL,
  `reason` text NOT NULL,
  `date_from` date NOT NULL,
  `date_until` date NOT NULL,
  `leave_request_status` varchar(20) NOT NULL DEFAULT 'pending',
  `leave_day_count` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `datetime_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_request`
--

INSERT INTO `leave_request` (`id`, `user_id`, `head_id`, `type`, `reason`, `date_from`, `date_until`, `leave_request_status`, `leave_day_count`, `status`, `datetime_created`) VALUES
(9, 18, 2, 'Maternity Leave', 'Asd', '2024-08-29', '2024-08-31', 'accepted', 3, 0, '2024-08-27 03:10:27'),
(10, 21, 25, 'Personal Leave', 'A normal reason paragraph presents a clear and logical explanation for why something is the case. For example, if you\'re explaining why regular exercise is important, you might say: Regular exercise is crucial for maintaining overall health because it strengthens the heart, improves circulation, and helps manage body weight. Additionally, physical activity can reduce the risk of chronic diseases like diabetes and high blood pressure. Exercise also releases endorphins, which improve mood and reduce stress. By making exercise a consistent part of one’s routine, individuals can enhance both their physical and mental well-being.', '2024-09-28', '2024-09-30', 'pending', 3, 0, '2024-09-28 19:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `role` varchar(256) NOT NULL DEFAULT 'employee',
  `verification_code` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `status`, `role`, `verification_code`) VALUES
(1, 'admin@gmail.com', '$2y$10$wgoV0QVIU8njkY.ew/qEPOV2HMPkSeV8KJh6P1/e7hwH3/Otz1/CK', 0, 'admin', ''),
(2, 'head@gmail.com', '$2y$10$wgoV0QVIU8njkY.ew/qEPOV2HMPkSeV8KJh6P1/e7hwH3/Otz1/CK', 0, 'head', ''),
(18, 'mr.ephraiel@gmail.com', '$2y$10$QygFzU/uAKtb8OXbpgIfF.Rxdryk18P94fnrkbjQ5/BUaHmfgiS.G', 0, 'employee', ''),
(20, 'dummy16stapador@gmail.com', '$2y$10$dNTMkOZDqduz4vQA2JpbPey4gGgxucFbuMMdbqgFFSxadewhVfat.', 0, 'employee', ''),
(21, 'jovencatilo03@gmail.com', '$2y$10$zyxS8aqitzzzt1dY5IMczO0CxVkpQCT9RbwwYeUecK76lOnUWPVvu', 0, 'employee', ''),
(22, '21-08116@g.batstate-u.edu.ph1', '$2y$10$B2WvBt6aZm1NKI.mT4QP8uiXsRNzL7G5ZfmvIY.feac.F5b/ZQAhC', 0, 'employee', ''),
(25, 'happythreefriends43@gmail.com', '$2y$10$vSUEZ.0jFnDx29QSmXFvse8r5yCg.rj8C/3hdcZYrBwSKbxJ9xW9i', 0, 'head', ''),
(29, 'dummy12stapador@gmail.com', '$2y$10$IVaEWnJhHefAuRRnfz2goO9kavDIkMpS2o6Abe4RY7Bytv/lUsNIa', 0, 'applicant', ''),
(31, 'dummy21stapador@gmail.com', '$2y$10$.b2LsMduhF31AXu6bJ6PAetiS7OG8lu4htilV1A7teLXZahmu9u6i', 0, 'applicant', ''),
(32, 'dummyx1stapador@gmail.com', '$2y$10$jKnb6p.9.ic62GGly4Pg2ePCIa7ST.osF8SmWfhI/Wnl6UvSkW8W2', 0, 'applicant', ''),
(33, 'dummy1stapador@gmail.com', '$2y$10$D88RbRUY4M9PuZbfPKep1ukreQPvh8Hb/UFidHzJkQ0zO5cYB5/i2', 0, 'applicant', ''),
(36, '21-08116@g.batstate-u.edu.ph', '$2y$10$j3cfG2N.SwTEQZxlxDejzei7.MAc.xxINM2atEwpVdfI3vpbvbKqq', 0, 'applicant', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` bigint(20) NOT NULL,
  `fname` varchar(256) NOT NULL,
  `mname` varchar(256) NOT NULL,
  `lname` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL,
  `address` varchar(256) NOT NULL,
  `birthday` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `position` varchar(256) NOT NULL,
  `profile_picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `fname`, `mname`, `lname`, `gender`, `address`, `birthday`, `phone`, `position`, `profile_picture`) VALUES
(1, 'Badurya', 'Zxczxc', 'Garcia', 'Male', 'Manila, Tondo', '1989-07-01', '09876543112', 'HR ADMIN', 'c5e5f2a284945ba3af83a7e9ae5f0210.png'),
(2, 'Willson', '', 'Smith', 'Male', 'Zxc', '1991-07-18', '091231231233', 'Head Department', '4bee85c0367214ff5cea18b483b59aad.png'),
(18, 'Zxc', 'Asdasd', 'Qqq', 'Female', 'Brgy san agustin rizal group ', '2024-08-02', '09161363325', 'Applicant', '09a1b364df4ec571981ad0d8987d14ea.jpg'),
(20, 'g', '', 'c', 'Male', 'hatdog', '2024-08-06', '09876543212', 'panget lang', ''),
(21, 'Boy', 'Tapang', 'Tv', 'Female', 'Pallocan West, Batangas City', '2003-06-01', '09197970229', 'Applicant', '51b8788acf923fb72eba4f665c984651.png'),
(22, 'l', '', 'w', 'Male', 'Bulacan', '2003-06-01', '09197970229', 'Nurse', ''),
(25, 's', '', 'm', 'Male', 'Zxc', '2024-08-02', '09161363312', 'Asdasasd', ''),
(29, 'v', '', 'a', 'Male', 'asd', '2024-08-30', '09161363325', 'Job Opening for Nurse', ''),
(31, 'x', '', 'b', 'Male', 'a', '2024-08-17', '09161363325', 'NDT emee eme', ''),
(32, 'fname', 'mname', 'lname', 'Male', 'Bay', '2024-07-04', '09161363325', 'Job Opening for Nurse', '09a1b364df4ec571981ad0d8987d14ea.jpg'),
(33, 'very', 'me', 'hatdog', 'Male', 'Bay', '2024-08-08', '09161363325', 'ui ux', ''),
(36, 'JOVEN', 'CAPIO', 'CATILO', 'Male', '12 Kating-an St. Pallocan West, Batangas City', '2024-06-01', '09203549508', 'Job Opening (Macho Dancer)', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_hired`
--

CREATE TABLE `user_hired` (
  `user_id` bigint(20) NOT NULL,
  `date_from` varchar(256) NOT NULL,
  `date_to` varchar(256) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_hired`
--

INSERT INTO `user_hired` (`user_id`, `date_from`, `date_to`, `status`) VALUES
(2, '2024-08-30', '', 0),
(20, '2024-08-29', '2026-12-28', 0),
(21, '2024-08-31', '', 0),
(22, '2024-09-04', '', 0),
(25, '2024-08-31', '2030-12-28', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_files`
--
ALTER TABLE `employee_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_hired`
--
ALTER TABLE `user_hired`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_files`
--
ALTER TABLE `employee_files`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_posting`
--
ALTER TABLE `job_posting`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `leave_request`
--
ALTER TABLE `leave_request`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_hired`
--
ALTER TABLE `user_hired`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

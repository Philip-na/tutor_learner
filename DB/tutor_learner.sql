-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 01:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutor_learner`
--

-- --------------------------------------------------------

--
-- Table structure for table `attached`
--

CREATE TABLE `attached` (
  `id` int(11) NOT NULL,
  `tutorid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` varchar(200) NOT NULL,
  `prerequisites` varchar(2000) NOT NULL,
  `evaluation` varchar(1000) NOT NULL,
  `learningOutcome` varchar(1000) NOT NULL,
  `about` varchar(2000) DEFAULT NULL,
  `tutorid` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `category` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `duration`, `prerequisites`, `evaluation`, `learningOutcome`, `about`, `tutorid`, `created`, `category`) VALUES
(22, 'Full Stack Web Development', '12 Weeks', 'Basic understanding of HTML, CSS, and JavaScript', 'Project completion, quizzes, final exam', 'Develop complete web applications, understand front-end and back-end development, work with databases', ' This course covers the end-to-end process of building web applications, including front-end design and back-end programming. Students will learn to create interactive and responsive web pages, implement user authentication, and manage databases.', 33, '2023-08-03', 'Web Development'),
(23, 'Mobile App Development with Flutter', '10 weeks', 'Basic programming knowledge', 'Project completion, quizzes, final app submission', 'Develop cross-platform mobile apps, work with Flutter framework', 'This course covers mobile app development using the Flutter framework. Students will learn to build visually appealing and interactive apps that can run on both iOS and Android platforms.', 38, '2023-08-03', 'Mobile Development'),
(24, 'Interaction Design', '10 weeks', ' User-Centered Design Principles', 'Design Assignments (40%), Interaction Prototypes (30%)', 'Design interactive and dynamic user interfaces. Understand user behavior and create user-centered interactions. Implement microinteractions and animations', 'This course delves into the advanced aspects of interaction design, focusing on creating dynamic and engaging user interfaces. Students will learn how to design interactive elements, use animations to enhance user experience, and create microinteractions that delight users.', 37, '2023-08-03', 'UI UX Design'),
(25, 'Android App Development with Java and Android Studio', '12 Weeks', 'Basic programming knowledge, familiarity with Java', 'Project completion, coding assignments, final app submission', 'Develop native Android apps, understand Android Studio IDE', ' This course focuses on native Android app development using Java and the Android Studio IDE. Students will learn to create feature-rich apps for the Android platform.', 36, '2023-08-03', 'Mobile Development');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `id` int(11) NOT NULL,
  `learnerid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(200) NOT NULL,
  `grade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `learnerid`, `courseid`, `date`, `status`, `grade`) VALUES
(28, 39, 23, '2023-08-03', 'complete', 0);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `subcontent` varchar(355) DEFAULT NULL,
  `templatesjs` varchar(200) DEFAULT NULL,
  `templatescss` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `content`, `title`, `subtitle`, `subcontent`, `templatesjs`, `templatescss`) VALUES
(1, 'Home', 'Home', 'Home', 'home', 'homejs', 'homecss'),
(2, 'Course', 'Course Details', 'Course', 'Course tracking', 'coursesjs', 'coursescss'),
(3, 'Dashbord', 'learner dashbord', '', 'Wellcome', 'learnerdashbordjs', 'learnerdashboardcss'),
(4, 'Tutors', 'Tutors', 'tutors', 'tutor', 'tutorjs', 'tutorcss'),
(5, 'Submissions', 'Submission', 'submission', NULL, 'submissionjs', 'submissioncss'),
(6, 'Courses', 'Courses', '', '', 'admincoursesjs', 'admincoursescss'),
(7, 'Admin Dashboard', 'admin dashboard', 'dashboard', 'dashboard', 'admindashboardjs', 'admindashboardcss'),
(8, 'tutor', 'Tutors', 'tutors', NULL, 'tutorsadminjs', 'tutorsadmincss'),
(9, 'Dashboard', 'dashboard tutor', NULL, NULL, 'tutordashboardjs', 'tutordashboardcss'),
(10, 'submission', 'submissions', 'submission', NULL, 'tutorsubmissioncss', 'tutorsubmissionjs'),
(11, 'topics', 'topics', NULL, NULL, 'tutortopicjs', 'tutortopiccss'),
(12, 'sessions', 'sessions', NULL, NULL, 'tutortopicjs', 'tutortopiccss'),
(13, 'progress', 'progress', NULL, NULL, 'tutortopicjs', 'tutortopiccss');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `learnerid` int(11) NOT NULL,
  `tutorid` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `pretty_url` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `template` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `module`, `entity_id`, `pretty_url`, `action`, `template`, `location`) VALUES
(1, 'Home', 1, 'home', 'default', 'home', ''),
(2, 'Dashboard', 3, 'ldashboard', 'default', 'learner_main', 'learner'),
(3, 'Tutors', 4, 'tutors', 'default', 'learner_main', 'learner'),
(4, 'Courses', 2, 'courses', 'default', 'learner_main', 'learner'),
(5, 'Submissions', 5, 'submissions', 'default', 'learner_main', 'learner'),
(6, 'Dashboard', 7, 'admin_dashboard', 'default', 'admin_main', 'admin'),
(7, 'Courses', 6, 'courses_admin', 'default', 'admin_main', 'admin'),
(8, 'Tutors', 8, 'tutors_admin', 'default', 'admin_main', 'admin'),
(9, 'Dashboard', 9, 'tutor_dashboard', 'default', 'tutor_main', 'tutor'),
(10, 'Submissions', 10, 'tutor_submission', 'default', 'tutor_main', 'tutor'),
(11, 'Courses', 11, 'tutor_topics', 'topic', 'admin_main', 'admin'),
(12, 'Courses', 12, 'tutor_sessions', 'session', 'tutor_main', 'tutor'),
(13, 'Courses', 13, 'tutor_progress', 'progress', 'tutor_main', 'tutor'),
(14, 'Home', 14, 'login', '', '', ''),
(15, 'Courses', 2, 'enroll', 'enroll', 'empty', 'learner'),
(16, 'Dashboard', 8, 'enroll_admin', 'enroll', 'admin_main', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sessionatedence`
--

CREATE TABLE `sessionatedence` (
  `id` int(11) NOT NULL,
  `learnerid` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessionatedence`
--

INSERT INTO `sessionatedence` (`id`, `learnerid`, `sessionid`, `status`) VALUES
(7, 39, 7, 'attended');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `topicid` int(11) NOT NULL,
  `sessiondt` varchar(1000) NOT NULL,
  `tutorId` int(11) NOT NULL,
  `created` date NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `topicid`, `sessiondt`, `tutorId`, `created`, `date`) VALUES
(7, 24, 'online sesson', 38, '2023-08-03', '2023-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `slink` varchar(2000) DEFAULT NULL,
  `filename` varchar(2000) DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'Not Reviewed '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `studentid`, `courseid`, `name`, `slink`, `filename`, `status`) VALUES
(6, 39, 23, 'Final Submission', 'https://github.com/micheal-lubowa65', '64cba1b9d12ca.pdf', 'Reviewed');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `name` varchar(2000) NOT NULL,
  `topicdetiles` varchar(2000) NOT NULL,
  `courseId` int(11) NOT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`, `topicdetiles`, `courseId`, `createdAt`) VALUES
(14, 'Introduction to Full Stack Development', 'Basic Understanding of Web', 22, '2023-08-03'),
(16, 'HTML5 and CSS3 Fundamentals', 'Good for bigginers', 22, '2023-08-03'),
(17, 'Principles of Interaction Design', 'basic', 24, '2023-08-03'),
(18, 'Motion Graphics in UI/UX', 'basic', 24, '2023-08-03'),
(19, 'Gamification and User Engagement', 'basic', 24, '2023-08-03'),
(20, 'JavaScript and DOM Manipulation', 'Advanced course', 22, '2023-08-03'),
(21, 'Advanced Prototyping Techniques', 'basic', 24, '2023-08-03'),
(22, 'Collaborative Design Workflows', 'basic', 24, '2023-08-03'),
(23, 'Database Design and Management', 'Get started with my sql', 22, '2023-08-03'),
(24, 'Introduction to Mobile App Development', 'Get started with android', 23, '2023-08-03'),
(25, 'Introduction to Android App Development', 'basic', 25, '2023-08-03'),
(26, 'SQLite Database and Data Storage', 'basic', 25, '2023-08-03'),
(27, 'Networking and API Integration', 'basic', 25, '2023-08-03'),
(28, 'Firebase Integration: Push Notifications and Analytics', 'basic', 25, '2023-08-03'),
(29, 'App Testing and Debugging', 'basic', 25, '2023-08-03'),
(30, 'Flutter Basics: Widgets and Layouts', 'Flutter for beginner', 23, '2023-08-03'),
(31, 'State Management with Provider', 'Advanced', 23, '2023-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `role` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `expertise` varchar(2000) DEFAULT NULL,
  `qualifications` varchar(2000) DEFAULT NULL,
  `s_question` varchar(20) DEFAULT NULL,
  `answer` varchar(1000) DEFAULT NULL,
  `created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `role`, `phone`, `expertise`, `qualifications`, `s_question`, `answer`, `created`) VALUES
(18, '', 'Philip', '$2y$10$PKqdzFMDok.DE1k2cM8.m.Ao.7..3WJEf5evjU/bSMOfPBvRi8mP6', 'nabikamba14@gmail.com', 'admin', '', NULL, '', 'q3', '', NULL),
(32, '', 'Nalwanga Edith', '$2y$10$qtbZfhNTlOtFQU4JzEmTluzJTYkVuimNIPpJtOFsndUylGiVcpdIG', 'nalwangaedith@gmail.com', 'admin', '', NULL, '', 'q3', 'Kampala', '2023-08-03'),
(33, '', 'Bitwire George', '$2y$10$Qap5rGMqYbDnQ.DTCy8IJuibp7YYaXZ6wnmImqG2eaKhdQ0ORgCq6', 'bitwire@gmail.com', 'tutor', '+256773095120', NULL, 'Masters In Computer Science', '', '', '2023-08-03'),
(36, '', 'Baguma Rehema', '$2y$10$PHK1sFEtbsAtSrriRhel4OqQuExl/zdXzRU0FflxXHOrdAFeFgJjK', 'baguma@gmail.com', 'tutor', '+256782318001', NULL, 'Masters in Information Systems Technology', '', '', '2023-08-03'),
(37, '', 'Mugwanya Raymond', '$2y$10$PThQ6iuUXMqOsxf49Rrx3eFOQEjJdItcaqPkzOoJyj4kSAxlk3ZK.', 'mugwanya@gmail.com', 'tutor', '+256783464953', NULL, 'Masters in Information Technology', '', '', '2023-08-03'),
(38, '', 'Mugejjera Emmanuel', '$2y$10$G2mrEn80ckd2V0LXoubOt.80RhFF5/F7R5y6Zqh0pYK6yxEal8VXy', 'mugejjera@gmail.com', 'tutor', '+256783907864', NULL, 'Masters in Software Engineering', '', '', '2023-08-03'),
(39, '', 'Lubowa Micheal', '$2y$10$tTayDgAV6Vpxg1xqwhPmgODi2SxcW3PGN0YW30VJLtwgnoGib1uI2', 'lubowa65@gmail.com', 'learner', '', NULL, '', 'q3', 'Kampala', '2023-08-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attached`
--
ALTER TABLE `attached`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `en-cs` (`courseid`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rating` (`learnerid`),
  ADD KEY `tutorrate` (`tutorid`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pretty_url` (`pretty_url`);

--
-- Indexes for table `sessionatedence`
--
ALTER TABLE `sessionatedence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learnerAtedded` (`learnerid`),
  ADD KEY `sessionatted` (`sessionid`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
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
-- AUTO_INCREMENT for table `attached`
--
ALTER TABLE `attached`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sessionatedence`
--
ALTER TABLE `sessionatedence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `en-cs` FOREIGN KEY (`courseid`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `rating` FOREIGN KEY (`learnerid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tutorrate` FOREIGN KEY (`tutorid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessionatedence`
--
ALTER TABLE `sessionatedence`
  ADD CONSTRAINT `learnerAtedded` FOREIGN KEY (`learnerid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessionatted` FOREIGN KEY (`sessionid`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

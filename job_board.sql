-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 08:49 AM
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
-- Database: `job_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `candidate_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `linkedin_profile` varchar(255) DEFAULT NULL,
  `status` enum('New','Reviewed','Interview Scheduled') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `candidate_name`, `email`, `resume`, `cover_letter`, `linkedin_profile`, `status`) VALUES
(1, 1, 'Arayan Dalavi', 'aryan@gmail.copm', 'uploads/resumes/SanketNiwateResume.pdf', 'hello', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'Reviewed'),
(2, 2, 'Rohan Joshi', 'reshmajoshi0604@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hii', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'Reviewed'),
(3, 2, 'Rohan Joshi', 'reshmajoshi0604@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hii', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'New'),
(4, 2, 'Rohan Joshi', 'reshmajoshi0604@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hii', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'New'),
(5, 1, 'Arayan Dalavi', 'rohanjoshi093@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hello', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'Interview Scheduled'),
(6, 1, 'Arayan Dalavi', 'rohanjoshi093@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hello', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'New'),
(7, 1, 'Arayan Dalavi', 'rohanjoshi093@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hello', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'Interview Scheduled'),
(8, 3, 'Rohan Joshi', 'reshmajoshi0604@gmail.com', 'uploads/resumes/RohanJoshi.pdf', 'hihi', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'New'),
(9, 1, 'Rohan Joshi', 'rohanjoshi093@gmail.com', 'uploads/resumes/RohanJoshi (3).pdf', 'hello', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'New'),
(10, 3, 'shubham yadav', 'yadavshubham6565@gmail.com', 'uploads/resumes/Rohan Joshi resume (2).pdf', 'hello', 'https://www.linkedin.com/in/rohan-joshi-892835328/', 'Interview Scheduled'),
(11, 2, 'shubham yadav', 'yadavshubham6565@gmail.com', 'uploads/resumes/67933bed27c47_Rohan Joshi resume (2).pdf', 'hello', '', 'New'),
(12, 3, 'Rohan Bothre', 'rohanbothre20@gmail.com', 'uploads/resumes/67933e45ad949_RohanJoshi (2).pdf', 'Here’s a concise version for you:\r\n\r\nSubject: Application for [Job Title]\r\n\r\nDear [Hiring Manager&#039;s Name],\r\n\r\nI am excited to apply for the [Job Title] position at [Company Name]. As a Full Stack Developer with experience in [relevant skills, e.g., React.js, PHP, Laravel], I bring a strong ability to build responsive and user-friendly applications. I look forward to the opportunity to contribute to your team’s success and would love to discuss how my skills align with your goals.\r\n\r\nSincerely,\r\n[Your Name]', '', 'Reviewed');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `job_type` enum('Full Time','Part Time','Contract') DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary_range` varchar(50) DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company_name`, `description`, `job_type`, `location`, `salary_range`, `application_deadline`, `company_logo`, `posted_by`) VALUES
(1, 'Gym Trainer', 'Fitgenix Gym', 'Required fitness trainer', 'Full Time', 'mumbai', '120000-180000', '2025-01-29', 'uploads/logo.jpeg', 3),
(2, 'PHP Developer', 'stratify', 'Required A fresher PHP developer', 'Full Time', 'mumbai', '120000-180000', '2025-01-29', 'uploads/startifylogo.jpg', 3),
(3, 'PHP Developer', 'stratify', '1-2 years experience .', 'Part Time', 'mumbai', '240000-500000', '2025-01-30', 'uploads/startifylogo.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('job_seeker','employer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Rohan Joshi', 'rohanjoshi@gmail.com', '$2y$10$6dXUMGacbNpk/D4whx2yyO7Jp4fNQa8wghPQIbssXldyDLB2QUu96', 'job_seeker'),
(3, 'Rohan Joshi', 'rohanjoshi093@gmail.com', '$2y$10$MpEeFRZezpngh1LOXINbhuWCNmTjaZNHDz0VVvLaBpQm6mOfK5Ovu', 'employer'),
(4, 'Aryan Dalavi', 'aryan@gmail.copm', '$2y$10$lP5U93Dv3ryMAnAtY4HbVu667z8blF8oh30lvKwETTLQ/h1Wt5TQG', 'job_seeker'),
(6, 'shravan joshi', 'shravan@gmail.com', '$2y$10$bD.s.UwSGDCPAH4186j5DOZaebMuTxNMkPBG8igIEnHncMf0o6gb.', 'job_seeker'),
(7, 'Sanket Sawant', 'sanket@gmail.com', '$2y$10$jI3MYi/KV/bmnHSULR3taOAm4gVlVfjs3KXx6NijGKhE3PCYVSyQW', 'job_seeker'),
(8, 'Gaurav taneja', 'gauravtaneja@gmail.com', '$2y$10$6CJJEoPEjNkb/0OZy1lY6ePNq0XTLDhqclon.0F3ZlEGmuAhMJwey', 'job_seeker'),
(10, 'gaurav dakare', 'gauradakare@gmail.com', '$2y$10$L3O6ZDUUF2SXy7Hqj2hcb.P7VeWVxWe4LljODc6Qr2iKM4rDstxZ.', 'job_seeker'),
(11, 'Akshay Shinde', 'akshayshinde@gmail.com', '$2y$10$Lamjv2uA04E9ddM7ROhyzu2Y21ZESd6JScYpLx6JFoBtZOKWGILOW', 'job_seeker'),
(12, 'Rohan Joshi', 'reshmajoshi0604@gmail.com', '$2y$10$ZJTMDKjbQXwAtS/Pk6b4TuZCjrQp4QuYiJUochUYPtDr98f8YqF1a', 'job_seeker'),
(14, 'shubham Yadav', 'yadavshubham6565@gmail.com', '$2y$10$TQ6zWOctQRcQ6wst7EF3r.rM/ZllbwPKI/U3y/Rd/23RKabynLpNO', 'job_seeker'),
(15, 'Rohan Bothre', 'rohanbothre20@gmail.com', '$2y$10$Mof0N./8d4c2aszoMk4ZiuPR/sG1umb0bGm6lvUOHIOLt4tdIySkS', 'job_seeker');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

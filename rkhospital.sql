-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 02:16 PM
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
-- Database: `rkhospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `reset_token`, `reset_expires`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$FPq5fWrTxxGeFM0s7hje0OVEf4o4tnpiSCfp4Vxu3L.rTNGjeg3Qu', NULL, NULL, '2026-03-25 10:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(280) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT 'assets/img/blog/blog-01.jpg',
  `category_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `tags` varchar(500) DEFAULT NULL COMMENT 'comma-separated tags',
  `views` int(10) UNSIGNED DEFAULT 0,
  `comments` int(10) UNSIGNED DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 1,
  `published_at` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `meta_title` varchar(70) DEFAULT NULL,
  `meta_description` varchar(180) DEFAULT NULL,
  `focus_keyword` varchar(100) DEFAULT NULL,
  `canonical_url` varchar(500) DEFAULT NULL,
  `og_title` varchar(200) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(500) DEFAULT NULL,
  `og_type` varchar(50) DEFAULT 'article',
  `twitter_title` varchar(200) DEFAULT NULL,
  `twitter_description` text DEFAULT NULL,
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `robots_meta` varchar(50) DEFAULT 'index,follow',
  `schema_type` varchar(50) DEFAULT 'BlogPosting',
  `schema_json` longtext DEFAULT NULL,
  `reading_time` tinyint(3) UNSIGNED DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `category_id`, `author_id`, `tags`, `views`, `comments`, `is_published`, `published_at`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image`, `og_type`, `twitter_title`, `twitter_description`, `twitter_card`, `robots_meta`, `schema_type`, `schema_json`, `reading_time`, `image_alt`) VALUES
(1, 'Joint Replacement Surgery: What to Expect Before & After', 'joint-replacement-surgery-what-to-expect', 'A complete guide to knee and hip replacement — preparation, procedure, recovery, and when to return to normal activity.', '<p>Joint replacement surgery is one of the most successful and life-changing orthopedic procedures available today. Whether it is a knee replacement or a hip replacement, the goal is the same — to relieve chronic pain, restore mobility, and help patients return to a comfortable, active life. At Dr. Agrawal\'s R.K. Hospital, Nagpur, our orthopedic team performs hundreds of joint replacement surgeries each year with excellent outcomes and high patient satisfaction.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Who Needs Joint Replacement Surgery?</h5>\r\n<p>Joint replacement is typically recommended when conservative treatments such as medications, physiotherapy, and lifestyle modifications no longer provide adequate relief. Common candidates include patients suffering from severe osteoarthritis, rheumatoid arthritis, avascular necrosis, or post-traumatic arthritis.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Before the Surgery — Preparation is Key</h5>\r\n<p>A thorough pre-operative evaluation is carried out before scheduling your surgery. This includes blood tests, X-rays, ECG, and a fitness assessment to ensure you are in the best possible condition for the procedure.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">The Surgical Procedure</h5>\r\n<p>Joint replacement surgery is typically performed under spinal or general anaesthesia and takes approximately 1.5 to 2 hours. Our surgeons use minimally invasive techniques wherever possible to reduce tissue damage and promote faster healing.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">After the Surgery — Recovery & Rehabilitation</h5>\r\n<p>Recovery begins almost immediately. Most patients are encouraged to stand within 24 hours of surgery. Most patients are discharged within 3 to 5 days and can resume light activities within 4 to 6 weeks.</p>', 'assets/img/blog/blog-37.jpg', 1, 1, 'Orthopedics,Joint Replacement,Knee Surgery,Hip Surgery,Bone Health,Physiotherapy', 142, 18, 1, '2026-01-10', '2026-03-25 08:56:48', '2026-03-25 11:52:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'article', NULL, NULL, 'summary_large_image', 'index,follow', 'BlogPosting', NULL, NULL, NULL),
(2, 'Normal vs C-Section Delivery: Helping You Make the Right Choice', 'normal-vs-c-section-delivery', 'Understanding the difference between normal and cesarean delivery, risks, benefits, and what your doctor recommends.', '<p>The decision between normal delivery and a cesarean section (C-section) is one of the most significant choices expectant mothers face. At R.K. Hospital, our gynecology team helps you understand all options so you can make an informed, confident decision.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Normal Delivery</h5>\r\n<p>A vaginal delivery is the natural process of childbirth. Recovery is generally faster, with shorter hospital stays and lower risk of surgical complications. Most healthy pregnancies are candidates for normal delivery.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Cesarean Section</h5>\r\n<p>A C-section is a surgical procedure recommended when vaginal delivery poses risks to the mother or baby. This includes cases of fetal distress, placenta previa, breech presentation, or prolonged labor.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Making the Right Choice</h5>\r\n<p>The best delivery method depends on your health, your baby\'s position, and any complications present. Our doctors guide you through the process with complete transparency and personalized care.</p>', 'assets/img/blog/blog-32.jpg', 2, 2, 'Gynecology,Delivery,C-Section,Normal Delivery,Pregnancy,Maternity', 98, 12, 1, '2026-01-18', '2026-03-25 08:56:48', '2026-03-25 08:56:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'article', NULL, NULL, 'summary_large_image', 'index,follow', 'BlogPosting', NULL, NULL, NULL),
(3, 'Pregnancy Nutrition: Foods That Support a Healthy Baby', 'pregnancy-nutrition-foods-healthy-baby', 'Essential dietary advice for expecting mothers — what to eat, what to avoid, and how to manage common pregnancy discomforts.', '<p>Good nutrition during pregnancy is one of the most powerful gifts you can give your growing baby. The right diet supports healthy fetal development, reduces complications, and keeps the mother energized throughout the journey.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Key Nutrients During Pregnancy</h5>\r\n<p>Folic acid, iron, calcium, and DHA are among the most critical nutrients. Folic acid prevents neural tube defects, iron supports healthy blood production, and calcium builds strong bones and teeth for your baby.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Foods to Include</h5>\r\n<p>Leafy greens, legumes, dairy products, eggs, nuts, seeds, whole grains, and lean protein should form the foundation of your pregnancy diet. Fresh fruits provide essential vitamins and antioxidants.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Foods to Avoid</h5>\r\n<p>Raw or undercooked meat, unpasteurized dairy, high-mercury fish, caffeine in excess, and processed junk foods should be avoided during pregnancy.</p>', 'assets/img/blog/blog-33.jpg', 3, 3, 'Pregnancy,Nutrition,Maternal Health,Baby Health,Diet', 75, 8, 1, '2026-01-25', '2026-03-25 08:56:48', '2026-03-25 11:35:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'article', NULL, NULL, 'summary_large_image', 'index,follow', 'BlogPosting', NULL, NULL, NULL),
(4, 'Chronic Back Pain: Causes, Diagnosis & Modern Treatment Options', 'chronic-back-pain-causes-diagnosis-treatment', 'From slip disc to spondylosis — understand the root cause of your back pain and the advanced treatment options available at our hospital.', '<p>Chronic back pain is one of the most common reasons patients visit R.K. Hospital. It affects people of all ages and can significantly reduce quality of life if left untreated.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Common Causes</h5>\r\n<p>Slip disc (herniated disc), spondylosis, muscle strain, sciatica, and poor posture are the leading causes of chronic back pain. In some cases, underlying conditions like osteoporosis or spinal stenosis may be responsible.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Diagnosis</h5>\r\n<p>Our specialists use a combination of clinical examination, X-rays, MRI scans, and nerve conduction studies to accurately diagnose the cause of your back pain.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Treatment Options</h5>\r\n<p>Treatment ranges from physiotherapy, medication, and lifestyle changes to advanced procedures like epidural injections, minimally invasive spine surgery, and disc replacement. Our team creates a personalized plan for every patient.</p>', 'assets/img/blog/blog-34.jpg', 6, 1, 'Spine Care,Back Pain,Slip Disc,Spondylosis,Orthopedics', 111, 15, 1, '2026-02-02', '2026-03-25 08:56:48', '2026-03-25 09:38:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'article', NULL, NULL, 'summary_large_image', 'index,follow', 'BlogPosting', NULL, NULL, NULL),
(5, 'PCOS & PCOD: Symptoms, Causes and How We Treat It', 'pcos-pcod-symptoms-causes-treatment', 'Polycystic ovary syndrome affects millions of women. Learn about early warning signs, hormonal imbalance, and treatment plans.', '<p>Polycystic Ovary Syndrome (PCOS) and Polycystic Ovarian Disease (PCOD) are among the most common hormonal disorders affecting women of reproductive age. Early detection and management are key to preventing long-term complications.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Symptoms to Watch For</h5>\r\n<p>Irregular periods, excessive hair growth, acne, weight gain, thinning scalp hair, and difficulty conceiving are common signs of PCOS. Many women also experience fatigue and mood fluctuations.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Root Causes</h5>\r\n<p>Insulin resistance, excess androgen production, and genetics all play a role. Lifestyle factors like poor diet and sedentary habits can worsen symptoms.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Our Treatment Approach</h5>\r\n<p>We combine lifestyle counselling, hormonal therapy, and medication to manage PCOS effectively. For women planning pregnancy, fertility treatments are available at our hospital.</p>', 'assets/img/blog/blog-35.jpg', 5, 2, 'PCOS,PCOD,Women\'s Health,Hormonal Health,Fertility', 133, 20, 1, '2026-02-10', '2026-03-25 08:56:48', '2026-03-25 09:57:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'article', NULL, NULL, 'summary_large_image', 'index,follow', 'BlogPosting', NULL, NULL, NULL),
(6, 'Laparoscopic Surgery: Minimally Invasive, Maximum Recovery', 'laparoscopic-surgery-minimally-invasive', 'Discover why laparoscopic (keyhole) surgery is safer, faster to recover from, and now available for a wide range of procedures at R.K. Hospital.', '<p>Laparoscopic surgery, also known as keyhole surgery, has revolutionized the way we perform operations. At R.K. Hospital, our surgical team is trained in the latest minimally invasive techniques to deliver better outcomes with less pain and faster recovery.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">What is Laparoscopic Surgery?</h5>\r\n<p>Instead of making large incisions, the surgeon uses a small camera (laparoscope) and thin instruments inserted through tiny cuts. This allows full visualization and precise operation inside the abdomen.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Advantages</h5>\r\n<p>Smaller scars, reduced blood loss, lower infection risk, shorter hospital stay, and significantly faster return to daily life are the key advantages over open surgery.</p>\r\n\r\n<h5 class=\"mt-4 mb-2\">Procedures Available at R.K. Hospital</h5>\r\n<p>Appendectomy, cholecystectomy (gallbladder removal), hernia repair, hysterectomy, ovarian cyst removal, and diagnostic laparoscopy are among the many procedures available.</p>', 'assets/img/blog/blog-36.jpg', 4, 4, 'Laparoscopy,Surgery,Minimally Invasive,Keyhole Surgery', 95, 10, 1, '2026-02-20', '2026-03-25 08:56:48', '2026-03-25 09:48:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'article', NULL, NULL, 'summary_large_image', 'index,follow', 'BlogPosting', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_authors`
--

CREATE TABLE `blog_authors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'assets/img/patients/default.jpg',
  `profile_url` varchar(255) DEFAULT 'doctor-profile.html'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_authors`
--

INSERT INTO `blog_authors` (`id`, `name`, `designation`, `bio`, `photo`, `profile_url`) VALUES
(1, 'Dr. R.K. Agrawal', 'MS (Ortho) | Senior Orthopedic Surgeon | R.K. Hospital, Nagpur', 'Dr. R.K. Agrawal is the founder and chief orthopedic surgeon at Dr. Agrawal\'s R.K. Hospital, Nagpur. With over two decades of experience in joint replacement, spine surgery, and sports injuries, he has transformed the lives of thousands of patients across Central India.', 'assets/img/patients/patient21.jpg', 'doctor-profile.html'),
(2, 'Dr. Priya Sharma', 'MD (Gynecology) | Senior Gynecologist | R.K. Hospital, Nagpur', 'Dr. Priya Sharma is a senior gynecologist and obstetrician with over 15 years of experience in managing high-risk pregnancies, PCOS, and minimally invasive gynecologic procedures.', 'assets/img/patients/patient20.jpg', 'doctor-profile.html'),
(3, 'Dr. Neha Joshi', 'MS (OBG) | Obstetrician | R.K. Hospital, Nagpur', 'Dr. Neha Joshi specializes in maternal-fetal medicine and prenatal care, helping expecting mothers navigate pregnancy with confidence and safety.', 'assets/img/patients/patient23.jpg', 'doctor-profile.html'),
(4, 'Dr. Anil Mehta', 'MS (Surgery) | General & Laparoscopic Surgeon | R.K. Hospital, Nagpur', 'Dr. Anil Mehta is an experienced general and laparoscopic surgeon known for his precision in minimally invasive procedures.', 'assets/img/patients/patient13.jpg', 'doctor-profile.html');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Orthopedics', 'orthopedics', '2026-03-25 08:56:47'),
(2, 'Gynecology', 'gynecology', '2026-03-25 08:56:47'),
(3, 'Pregnancy Care', 'pregnancy-care', '2026-03-25 08:56:47'),
(4, 'Surgery', 'surgery', '2026-03-25 08:56:47'),
(5, 'Women\'s Health', 'womens-health', '2026-03-25 08:56:47'),
(6, 'Spine Care', 'spine-care', '2026-03-25 08:56:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `blog_authors`
--
ALTER TABLE `blog_authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blog_authors`
--
ALTER TABLE `blog_authors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `blog_authors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2023 at 04:18 PM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investigators`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_admin_profiles`
--

CREATE TABLE `company_admin_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone_id` bigint UNSIGNED DEFAULT NULL,
  `is_company_profile_submitted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_admin_profiles`
--

INSERT INTO `company_admin_profiles` (`id`, `user_id`, `company_name`, `company_phone`, `address`, `address_1`, `city`, `state`, `country`, `zipcode`, `timezone_id`, `is_company_profile_submitted`, `created_at`, `updated_at`) VALUES
(1, 5, 'tst', '8950840464', '2525A Holly Hall Street', NULL, 'Houston', 'TX', 'United States', '77054', 5, 1, '2023-06-05 10:59:02', '2023-06-05 10:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hiring_manager_companies`
--

CREATE TABLE `hiring_manager_companies` (
  `id` bigint UNSIGNED NOT NULL,
  `company_admin_id` bigint UNSIGNED NOT NULL,
  `hiring_manager_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investigator_availabilities`
--

CREATE TABLE `investigator_availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `days` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_availabilities`
--

INSERT INTO `investigator_availabilities` (`id`, `user_id`, `days`, `hours`, `distance`, `timezone_id`, `created_at`, `updated_at`) VALUES
(1, 7, '2525', '8989', '200', 4, '2023-06-05 11:17:26', '2023-06-05 11:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `investigator_blocked_company_admins`
--

CREATE TABLE `investigator_blocked_company_admins` (
  `id` bigint UNSIGNED NOT NULL,
  `investigator_id` bigint UNSIGNED NOT NULL,
  `company_admin_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_blocked_company_admins`
--

INSERT INTO `investigator_blocked_company_admins` (`id`, `investigator_id`, `company_admin_id`, `created_at`, `updated_at`) VALUES
(2, 3, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `investigator_documents`
--

CREATE TABLE `investigator_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `driving_license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Driving License',
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Passport',
  `ssn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SSN',
  `birth_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Birth Certificate',
  `form_19` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Form 19',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investigator_equipments`
--

CREATE TABLE `investigator_equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `camera_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `camera_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_dash_cam` tinyint(1) NOT NULL DEFAULT '0',
  `is_convert_video` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_equipments`
--

INSERT INTO `investigator_equipments` (`id`, `user_id`, `camera_type`, `camera_model`, `is_dash_cam`, `is_convert_video`, `created_at`, `updated_at`) VALUES
(1, 7, '25IP', 'OOP5252', 1, 1, '2023-06-05 11:17:26', '2023-06-05 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `investigator_languages`
--

CREATE TABLE `investigator_languages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fluency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `writing_fluency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_languages`
--

INSERT INTO `investigator_languages` (`id`, `user_id`, `language`, `fluency`, `writing_fluency`, `created_at`, `updated_at`) VALUES
(1, 7, '3', '1', '2', '2023-06-05 11:17:26', '2023-06-05 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `investigator_licenses`
--

CREATE TABLE `investigator_licenses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_insurance` tinyint(1) NOT NULL DEFAULT '0',
  `insurance_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Insurance file',
  `is_bonded` tinyint(1) NOT NULL DEFAULT '0',
  `bonded_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bonded file',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_licenses`
--

INSERT INTO `investigator_licenses` (`id`, `user_id`, `state`, `license_number`, `expiration_date`, `is_insurance`, `insurance_file`, `is_bonded`, `bonded_file`, `created_at`, `updated_at`) VALUES
(1, 7, '14', '25222522IOS', '2023-06-14', 0, NULL, 0, NULL, '2023-06-05 11:17:26', '2023-06-05 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `investigator_ratings_and_reviews`
--

CREATE TABLE `investigator_ratings_and_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `video_claimant_percentage` double NOT NULL,
  `survelance_report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'file of survelance report',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_ratings_and_reviews`
--

INSERT INTO `investigator_ratings_and_reviews` (`id`, `user_id`, `video_claimant_percentage`, `survelance_report`, `created_at`, `updated_at`) VALUES
(1, 7, 89.2, NULL, '2023-06-05 11:17:26', '2023-06-05 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `investigator_service_lines`
--

CREATE TABLE `investigator_service_lines` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `investigation_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_experience` int DEFAULT NULL,
  `years_experience` int DEFAULT NULL,
  `hourly_rate` double DEFAULT NULL,
  `travel_rate` double DEFAULT NULL,
  `milage_rate` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_service_lines`
--

INSERT INTO `investigator_service_lines` (`id`, `user_id`, `investigation_type`, `case_experience`, `years_experience`, `hourly_rate`, `travel_rate`, `milage_rate`, `created_at`, `updated_at`) VALUES
(1, 7, 'surveillance', 3, 25, 10, 15, 12.2, '2023-06-05 11:17:26', '2023-06-05 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `investigator_users`
--

CREATE TABLE `investigator_users` (
  `id` bigint UNSIGNED NOT NULL,
  `investigator_id` int NOT NULL,
  `company_admin_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investigator_work_vehicles`
--

CREATE TABLE `investigator_work_vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `make` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` date NOT NULL,
  `proof_of_insurance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'File of proof of insurance',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investigator_work_vehicles`
--

INSERT INTO `investigator_work_vehicles` (`id`, `user_id`, `year`, `make`, `model`, `picture`, `insurance_company`, `policy_number`, `expiration_date`, `proof_of_insurance`, `created_at`, `updated_at`) VALUES
(1, 7, '2018', '2017', '2018', NULL, 'TATA', 'IPSINTUI', '2023-06-07', NULL, '2023-06-05 11:17:26', '2023-06-05 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'English', NULL, NULL),
(2, 'Spanish', NULL, NULL),
(3, 'Chinese', NULL, NULL),
(4, 'Tagalog', NULL, NULL),
(5, 'Vietnamese', NULL, NULL),
(6, 'Russian', NULL, NULL),
(7, 'Ukrainian', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_02_113052_add_first_name_roles_to_users_table', 1),
(6, '2023_05_02_130113_create_roles_table', 1),
(7, '2023_05_06_111057_add_phone_to_users_table', 1),
(8, '2023_05_06_111442_create_investigator_service_lines_table', 1),
(9, '2023_05_11_064524_state', 1),
(10, '2023_05_11_064556_country', 1),
(11, '2023_05_11_074421_add_address_to_users_table', 1),
(12, '2023_05_11_182440_create_investigator_equipments_table', 1),
(13, '2023_05_11_182506_create_investigator_licenses_table', 1),
(14, '2023_05_11_182522_create_investigator_work_vehicles_table', 1),
(15, '2023_05_11_182538_create_investigator_languages_table', 1),
(16, '2023_05_11_182552_create_investigator_documents_table', 1),
(17, '2023_05_11_182700_create_investigator_availabilities_table', 1),
(18, '2023_05_15_092951_change_address_fields_to_users_table', 1),
(19, '2023_05_15_093804_change_address_fields_datatype_to_users_table', 1),
(20, '2023_05_15_105352_add_new_columns_for_files_path__saving_to_investigator_licenses_table', 1),
(21, '2023_05_18_051857_add_writing_fluency_in_investigator_languages_table', 1),
(22, '2023_05_22_042538_create_hr_company_profile_table', 1),
(23, '2023_05_23_064420_create_investigator_ratings_and_reviews_table', 1),
(24, '2023_05_23_113829_change_video_claimant_percentage_field_datatype_to_investigator_reviews_table', 1),
(25, '2023_05_23_200540_change_field_datatype_to_investigator_service_lines_table', 1),
(26, '2023_05_26_055611_add_is_investigator_profile_submitted_to_users_table', 1),
(27, '2023_05_29_073126_add_is_company_profile_submitted_in_company_profiles_table', 1),
(28, '2023_06_01_113958_rename_hr_company_profiles_table_to_company_profiles', 1),
(29, '2023_06_01_192644_rename_is_hr_profile_submitted_to_company_admin_profiles_table', 1),
(30, '2023_06_02_021013_add_website_to_users_table', 1),
(31, '2023_06_02_024134_create_timezones_table', 1),
(32, '2023_06_02_043517_add_timezone_to_investigator_availabilities_table', 1),
(33, '2023_06_02_043543_add_timezone_to_company_admin_profiles_table', 1),
(34, '2023_06_02_082138_create_languages_table', 1),
(35, '2023_06_02_162525_create_hiring_manager_companies_table', 1),
(36, '2023_06_02_191914_add_lat_lng_to_users_table', 1),
(37, '2023_06_03_092155_create_investigator_users_table', 1),
(38, '2023_06_03_093337_create_investigator_blocked_company_admins_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2023-06-05 10:45:20', '2023-06-05 10:45:20'),
(2, 'company-admin', '2023-06-05 10:45:20', '2023-06-05 10:45:20'),
(3, 'investigator', '2023-06-05 10:45:20', '2023-06-05 10:45:20'),
(4, 'hiring-manager', '2023-06-05 10:45:20', '2023-06-05 10:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Alabama', 'AL', NULL, NULL),
(2, 1, 'Alaska', 'AK', NULL, NULL),
(3, 1, 'Arizona', 'AZ', NULL, NULL),
(4, 1, 'Arkansas', 'AR', NULL, NULL),
(5, 1, 'California', 'CA', NULL, NULL),
(6, 1, 'Colorado', 'CO', NULL, NULL),
(7, 1, 'Connecticut', 'CT', NULL, NULL),
(8, 1, 'Delaware', 'DE', NULL, NULL),
(9, 1, 'District of Columbia', 'DC', NULL, NULL),
(10, 1, 'District of Columbia', 'DC', NULL, NULL),
(11, 1, 'Florida', 'FL', NULL, NULL),
(12, 1, 'Georgia', 'GA', NULL, NULL),
(13, 1, 'Hawaii', 'HI', NULL, NULL),
(14, 1, 'Idaho', 'ID', NULL, NULL),
(15, 1, 'Illinois', 'IL', NULL, NULL),
(16, 1, 'Indiana', 'IN', NULL, NULL),
(17, 1, 'Iowa', 'IA', NULL, NULL),
(18, 1, 'Kansas', 'KS', NULL, NULL),
(19, 1, 'Kentucky', 'KY', NULL, NULL),
(20, 1, 'Louisiana', 'LA', NULL, NULL),
(21, 1, 'Maine', 'ME', NULL, NULL),
(22, 1, 'Maryland', 'MD', NULL, NULL),
(23, 1, 'Massachusetts', 'MA', NULL, NULL),
(24, 1, 'Michigan', 'MI', NULL, NULL),
(25, 1, 'Minnesota', 'MN', NULL, NULL),
(26, 1, 'Mississippi', 'MS', NULL, NULL),
(27, 1, 'Missouri', 'MO', NULL, NULL),
(28, 1, 'Montana', 'MT', NULL, NULL),
(29, 1, 'Nebraska', 'NE', NULL, NULL),
(30, 1, 'Nevada', 'NV', NULL, NULL),
(31, 1, 'New Hampshire', 'NH', NULL, NULL),
(32, 1, 'New Jersey', 'NJ', NULL, NULL),
(33, 1, 'New Mexico', 'NM', NULL, NULL),
(34, 1, 'New York', 'NY', NULL, NULL),
(35, 1, 'North Carolina', 'NC', NULL, NULL),
(36, 1, 'North Dakota', 'ND', NULL, NULL),
(37, 1, 'Ohio', 'OH', NULL, NULL),
(38, 1, 'Oklahoma', 'OK', NULL, NULL),
(39, 1, 'Oregon', 'OR', NULL, NULL),
(40, 1, 'Pennsylvania', 'PA', NULL, NULL),
(41, 1, 'Rhode Island', 'RI', NULL, NULL),
(42, 1, 'South Carolina', 'SC', NULL, NULL),
(43, 1, 'South Dakota', 'SD', NULL, NULL),
(44, 1, 'Tennessee', 'TN', NULL, NULL),
(45, 1, 'Texas', 'TX', NULL, NULL),
(46, 1, 'Utah', 'UT', NULL, NULL),
(47, 1, 'Vermont', 'VT', NULL, NULL),
(48, 1, 'Virginia', 'VA', NULL, NULL),
(49, 1, 'Washington', 'WA', NULL, NULL),
(50, 1, 'West Virginia', 'WV', NULL, NULL),
(51, 1, 'Wisconsin', 'WI', NULL, NULL),
(52, 1, 'Wyoming', 'WY', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint UNSIGNED NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `timezone`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Pacific/Midway', '(GMT -11:00) Midway Island, Samoa', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(2, 'America/Adak', '(GMT -10:00) Hawai', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(3, 'America/Anchorage', '(GMT -9:00) Alaska', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(4, 'America/Los_Angeles', '(GMT -8:00) Pacific Time (US & Canada)', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(5, 'America/Denver', '(GMT -7:00) Mountain Time (US & Canada)', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(6, 'America/Chicago', '(GMT -6:00) Central Time (US & Canada), Mexico City', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(7, 'America/New_York', '(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(8, 'America/Halifax', '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(9, 'America/St_Johns', '(GMT -3:30) Newfoundland', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(10, 'America/Argentina/Buenos_Aires', '(GMT -3:00) Brazil, Buenos Aires, Georgetown', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(11, 'Atlantic/South_Georgia', '(GMT -2:00) Mid-Atlantic', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(12, 'Atlantic/Azores', '(GMT -1:00 hour) Azores, Cape Verde Islands', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(13, 'Europe/Dublin', '(GMT) Western Europe Time, London, Lisbon, Casablanca', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(14, 'Europe/Belgrade', '(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(15, 'Europe/Minsk', '(GMT +2:00) Kaliningrad, South Africa', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(16, 'Asia/Kuwait', '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(17, 'Asia/Tehran', '(GMT +3:30) Tehran', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(18, 'Asia/Muscat', '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(19, 'Asia/Kabul', '(GMT +4:30) Kabu', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(20, 'Asia/Karachi', '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(21, 'Asia/Kolkata', '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(22, 'Asia/Kathmandu', '(GMT +5:45) Kathmandu', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(23, 'Asia/Dhaka', '(GMT +6:00) Almaty, Dhaka, Colombo', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(24, 'Asia/Bangkok', '(GMT +7:00) Bangkok, Hanoi, Jakarta', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(25, 'Asia/Brunei', '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(26, 'Asia/Seoul', '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(27, 'Australia/Darwin', '(GMT +9:30) Adelaide, Darwin', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(28, 'Australia/Brisbane', '(GMT +10:00) Eastern Australia, Guam, Vladivostok', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(29, 'Australia/Canberra', '(GMT +11:00) Magadan, Solomon Islands, New Caledonia', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(30, 'Pacific/Fiji', '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka', 1, '2023-06-05 10:45:22', '2023-06-05 10:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` int DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Latitude',
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Longitude',
  `role` int NOT NULL COMMENT '1 for admin , 2 for company-admin , 3 for investigator, 4 for hiring-manager',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_investigator_profile_submitted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `website`, `address`, `address_1`, `city`, `state`, `country`, `zipcode`, `lat`, `lng`, `role`, `email_verified_at`, `password`, `remember_token`, `is_investigator_profile_submitted`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$10$jcgmCaECBTkZ.qfCiXAnp.VFviGvw7MpkSoVFzjgas2a4yOldEOfy', NULL, 0, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(2, 'Company', 'Admin', 'company_admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 135001, NULL, NULL, 2, NULL, '$2y$10$v6pqtbyyJSSjGD1kd8rQWuLyaXKQtLsVz6xl/vsH/vjpvA2q0tlaC', NULL, 0, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(3, 'Investigator', 'Investigator', 'investigator@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, '$2y$10$S8bdQK0EBbUOBYASADjIxOd2GXN5n6sDhkjTf45WhlyDAeuRKgS9q', NULL, 0, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(4, 'Hiring', 'Manager', 'hm@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, '$2y$10$sUDSMNwAwKl.OwzNBysf3OQakjtm/n8AmiTgR8ZE1kFzy23yUgiUG', NULL, 0, '2023-06-05 10:45:22', '2023-06-05 10:45:22'),
(5, 'company', 'company', 'company@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 135001, NULL, NULL, 2, NULL, '$2y$10$JynAGpzQyWqasJOmBAYoEeOs2BepWp9kaTx3nV/0lP8mOfTf1koni', NULL, 0, '2023-06-05 10:58:41', '2023-06-05 10:58:41'),
(6, 'company', 'one', 'companyone@gmail.com', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, 135001, NULL, NULL, 2, NULL, '$2y$10$C41QSsOhsk9CjCghEOjWWejNmG4ZhuLz.SLmTRJ0JoaLQXSI9FjnW', NULL, 0, '2023-06-05 10:59:46', '2023-06-05 10:59:46'),
(7, 'investigator', 'one', 'investigatorone@gmail.com', '8989898989', NULL, '226 West 52nd Street', NULL, 'New York', 'NY', 'United States', 10019, '40.7628067', '-73.9836851', 3, NULL, '$2y$10$7gIRJl3cO4vXXMsUcOLAl.6TVk4qCFPkQAzfXPkuGs6yccwCbn4rS', NULL, 1, '2023-06-05 11:15:16', '2023-06-05 11:17:27'),
(10, 'Tim', 'Muraki', 'tmuraki@siuconsultantgroup.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, '$2y$10$e3TUsPty0QS79Q03wVQql.hqCub4VDf8Y447Slv8eCs/H8V2oCMCm', NULL, 0, '2023-06-14 13:14:14', '2023-06-14 13:14:14'),
(11, 'Todd', 'Tano', 'ttano@askinsco.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, '$2y$10$Akz2sClpDZeIHzIyUZMjZOSb3cL9Td7EW3McGutgDeuREuf0vuJq6', NULL, 0, '2023-06-14 13:16:02', '2023-06-14 13:16:02'),
(12, 'Christopher', 'Champlin', 'chris@cwdataweb.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, '$2y$10$6pRJtbv9Ayo2h.dd92PmMernI03zJj7/yxDyv7tb/NUDK6fbN1iJe', NULL, 0, '2023-06-14 13:17:37', '2023-06-14 13:17:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_admin_profiles`
--
ALTER TABLE `company_admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hr_company_profiles_user_id_foreign` (`user_id`),
  ADD KEY `company_admin_profiles_timezone_id_foreign` (`timezone_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hiring_manager_companies`
--
ALTER TABLE `hiring_manager_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hiring_manager_companies_company_admin_id_foreign` (`company_admin_id`),
  ADD KEY `hiring_manager_companies_hiring_manager_id_foreign` (`hiring_manager_id`);

--
-- Indexes for table `investigator_availabilities`
--
ALTER TABLE `investigator_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_availabilities_user_id_foreign` (`user_id`),
  ADD KEY `investigator_availabilities_timezone_id_foreign` (`timezone_id`);

--
-- Indexes for table `investigator_blocked_company_admins`
--
ALTER TABLE `investigator_blocked_company_admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_blocked_company_admins_investigator_id_foreign` (`investigator_id`),
  ADD KEY `investigator_blocked_company_admins_company_admin_id_foreign` (`company_admin_id`);

--
-- Indexes for table `investigator_documents`
--
ALTER TABLE `investigator_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `investigator_equipments`
--
ALTER TABLE `investigator_equipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_equipments_user_id_foreign` (`user_id`);

--
-- Indexes for table `investigator_languages`
--
ALTER TABLE `investigator_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_languages_user_id_foreign` (`user_id`);

--
-- Indexes for table `investigator_licenses`
--
ALTER TABLE `investigator_licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_licenses_user_id_foreign` (`user_id`);

--
-- Indexes for table `investigator_ratings_and_reviews`
--
ALTER TABLE `investigator_ratings_and_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_ratings_and_reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `investigator_service_lines`
--
ALTER TABLE `investigator_service_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_service_lines_user_id_foreign` (`user_id`);

--
-- Indexes for table `investigator_users`
--
ALTER TABLE `investigator_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investigator_work_vehicles`
--
ALTER TABLE `investigator_work_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investigator_work_vehicles_user_id_foreign` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_state_id_index` (`state`),
  ADD KEY `users_country_id_index` (`country`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_admin_profiles`
--
ALTER TABLE `company_admin_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hiring_manager_companies`
--
ALTER TABLE `hiring_manager_companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investigator_availabilities`
--
ALTER TABLE `investigator_availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investigator_blocked_company_admins`
--
ALTER TABLE `investigator_blocked_company_admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `investigator_documents`
--
ALTER TABLE `investigator_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investigator_equipments`
--
ALTER TABLE `investigator_equipments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investigator_languages`
--
ALTER TABLE `investigator_languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investigator_licenses`
--
ALTER TABLE `investigator_licenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investigator_ratings_and_reviews`
--
ALTER TABLE `investigator_ratings_and_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investigator_service_lines`
--
ALTER TABLE `investigator_service_lines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investigator_users`
--
ALTER TABLE `investigator_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investigator_work_vehicles`
--
ALTER TABLE `investigator_work_vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_admin_profiles`
--
ALTER TABLE `company_admin_profiles`
  ADD CONSTRAINT `company_admin_profiles_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `hr_company_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hiring_manager_companies`
--
ALTER TABLE `hiring_manager_companies`
  ADD CONSTRAINT `hiring_manager_companies_company_admin_id_foreign` FOREIGN KEY (`company_admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hiring_manager_companies_hiring_manager_id_foreign` FOREIGN KEY (`hiring_manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_availabilities`
--
ALTER TABLE `investigator_availabilities`
  ADD CONSTRAINT `investigator_availabilities_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `investigator_availabilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_blocked_company_admins`
--
ALTER TABLE `investigator_blocked_company_admins`
  ADD CONSTRAINT `investigator_blocked_company_admins_company_admin_id_foreign` FOREIGN KEY (`company_admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investigator_blocked_company_admins_investigator_id_foreign` FOREIGN KEY (`investigator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_documents`
--
ALTER TABLE `investigator_documents`
  ADD CONSTRAINT `investigator_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_equipments`
--
ALTER TABLE `investigator_equipments`
  ADD CONSTRAINT `investigator_equipments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_languages`
--
ALTER TABLE `investigator_languages`
  ADD CONSTRAINT `investigator_languages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_licenses`
--
ALTER TABLE `investigator_licenses`
  ADD CONSTRAINT `investigator_licenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_ratings_and_reviews`
--
ALTER TABLE `investigator_ratings_and_reviews`
  ADD CONSTRAINT `investigator_ratings_and_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_service_lines`
--
ALTER TABLE `investigator_service_lines`
  ADD CONSTRAINT `investigator_service_lines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investigator_work_vehicles`
--
ALTER TABLE `investigator_work_vehicles`
  ADD CONSTRAINT `investigator_work_vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

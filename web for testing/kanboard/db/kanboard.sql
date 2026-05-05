-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 03:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kanboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `event_name` mediumtext NOT NULL,
  `action_name` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `action_has_params`
--

CREATE TABLE `action_has_params` (
  `id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

CREATE TABLE `columns` (
  `id` int(11) NOT NULL,
  `title` varchar(191) NOT NULL,
  `position` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_limit` int(11) DEFAULT 0,
  `description` mediumtext DEFAULT NULL,
  `hide_in_dashboard` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `columns`
--

INSERT INTO `columns` (`id`, `title`, `position`, `project_id`, `task_limit`, `description`, `hide_in_dashboard`) VALUES
(1, 'Todo', 1, 1, 0, '', 0),
(2, 'Ready for review', 3, 1, 0, '', 0),
(3, 'Work in progress', 2, 1, 0, '', 0),
(4, 'Done', 4, 1, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `column_has_move_restrictions`
--

CREATE TABLE `column_has_move_restrictions` (
  `restriction_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `src_column_id` int(11) NOT NULL,
  `dst_column_id` int(11) NOT NULL,
  `only_assigned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `column_has_restrictions`
--

CREATE TABLE `column_has_restrictions` (
  `restriction_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `rule` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `date_creation` bigint(20) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `reference` varchar(191) DEFAULT '',
  `date_modification` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `currency` char(3) NOT NULL,
  `rate` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_filters`
--

CREATE TABLE `custom_filters` (
  `id` int(11) NOT NULL,
  `filter` mediumtext NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `is_shared` tinyint(1) DEFAULT 0,
  `append` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `external_id` varchar(255) DEFAULT '',
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `external_id`, `name`) VALUES
(1, '', 'HocVien');

-- --------------------------------------------------------

--
-- Table structure for table `group_has_users`
--

CREATE TABLE `group_has_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_has_users`
--

INSERT INTO `group_has_users` (`group_id`, `user_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `email` varchar(191) NOT NULL,
  `project_id` int(11) NOT NULL,
  `token` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_logins`
--

CREATE TABLE `last_logins` (
  `id` int(11) NOT NULL,
  `auth_type` varchar(25) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `date_creation` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `last_logins`
--

INSERT INTO `last_logins` (`id`, `auth_type`, `user_id`, `ip`, `user_agent`, `date_creation`) VALUES
(1, 'Database', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 1768759098),
(2, 'Database', 2, '1.55.211.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 1768760272),
(3, 'RememberMe', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 1768762992),
(4, 'Database', 1, '1.55.211.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 1768767108);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `label` varchar(191) NOT NULL,
  `opposite_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `label`, `opposite_id`) VALUES
(1, 'relates to', 0),
(2, 'blocks', 3),
(3, 'is blocked by', 2),
(4, 'duplicates', 5),
(5, 'is duplicated by', 4),
(6, 'is a parent of', 7),
(7, 'is a child of', 6),
(8, 'is a milestone of', 9),
(9, 'targets milestone', 8),
(10, 'is fixed by', 11),
(11, 'fixes', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `token` varchar(80) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_expiration` int(11) NOT NULL,
  `date_creation` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plugin_schema_versions`
--

CREATE TABLE `plugin_schema_versions` (
  `plugin` varchar(80) NOT NULL,
  `version` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predefined_task_descriptions`
--

CREATE TABLE `predefined_task_descriptions` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `token` varchar(255) DEFAULT NULL,
  `last_modified` bigint(20) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `is_private` tinyint(1) DEFAULT 0,
  `description` mediumtext DEFAULT NULL,
  `identifier` varchar(50) DEFAULT '',
  `start_date` varchar(10) DEFAULT '',
  `end_date` varchar(10) DEFAULT '',
  `owner_id` int(11) DEFAULT 0,
  `priority_default` int(11) DEFAULT 0,
  `priority_start` int(11) DEFAULT 0,
  `priority_end` int(11) DEFAULT 3,
  `email` mediumtext DEFAULT NULL,
  `predefined_email_subjects` mediumtext DEFAULT NULL,
  `per_swimlane_task_limits` int(11) NOT NULL DEFAULT 0,
  `task_limit` int(11) DEFAULT 0,
  `enable_global_tags` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `is_active`, `token`, `last_modified`, `is_public`, `is_private`, `description`, `identifier`, `start_date`, `end_date`, `owner_id`, `priority_default`, `priority_start`, `priority_end`, `email`, `predefined_email_subjects`, `per_swimlane_task_limits`, `task_limit`, `enable_global_tags`) VALUES
(1, 'Auto Test Project', 1, '', 1768759161, 0, 0, NULL, 'AT', '', '', 1, 0, 0, 3, NULL, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_activities`
--

CREATE TABLE `project_activities` (
  `id` int(11) NOT NULL,
  `date_creation` bigint(20) DEFAULT NULL,
  `event_name` mediumtext NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `data` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_daily_column_stats`
--

CREATE TABLE `project_daily_column_stats` (
  `id` int(11) NOT NULL,
  `day` char(10) NOT NULL,
  `project_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `score` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_daily_stats`
--

CREATE TABLE `project_daily_stats` (
  `id` int(11) NOT NULL,
  `day` char(10) NOT NULL,
  `project_id` int(11) NOT NULL,
  `avg_lead_time` int(11) NOT NULL DEFAULT 0,
  `avg_cycle_time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_categories`
--

CREATE TABLE `project_has_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `project_id` int(11) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `color_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_files`
--

CREATE TABLE `project_has_files` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `path` mediumtext NOT NULL,
  `is_image` tinyint(1) DEFAULT 0,
  `size` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `date` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_groups`
--

CREATE TABLE `project_has_groups` (
  `group_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_metadata`
--

CREATE TABLE `project_has_metadata` (
  `project_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) DEFAULT '',
  `changed_by` int(11) NOT NULL DEFAULT 0,
  `changed_on` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_notification_types`
--

CREATE TABLE `project_has_notification_types` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `notification_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_roles`
--

CREATE TABLE `project_has_roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(191) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_has_roles`
--

INSERT INTO `project_has_roles` (`role_id`, `role`, `project_id`) VALUES
(1, 'Test lead', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_has_users`
--

CREATE TABLE `project_has_users` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_has_users`
--

INSERT INTO `project_has_users` (`project_id`, `user_id`, `role`) VALUES
(1, 1, 'project-manager'),
(1, 2, 'project-member'),
(1, 3, 'project-member'),
(1, 5, 'project-member'),
(1, 6, 'project-member'),
(1, 7, 'project-member'),
(1, 8, 'project-member'),
(1, 9, 'project-member');

-- --------------------------------------------------------

--
-- Table structure for table `project_role_has_restrictions`
--

CREATE TABLE `project_role_has_restrictions` (
  `restriction_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `rule` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remember_me`
--

CREATE TABLE `remember_me` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `sequence` varchar(255) DEFAULT NULL,
  `expiration` int(11) DEFAULT NULL,
  `date_creation` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remember_me`
--

INSERT INTO `remember_me` (`id`, `user_id`, `ip`, `user_agent`, `token`, `sequence`, `expiration`, `date_creation`) VALUES
(1, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '6f13f200513730a3c8859f5377b4d97da7657bde1a1eecc1ec2d0e300e86a91b', '4870feb8a1ee17abdc62103bb005a0fb8d00b4ca274f0002f59a14284a39', 1773943098, 1768759098),
(3, 1, '1.55.211.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '0639f0421b72e6975dba6ea6d5d8785bce221b8003b108028915e348e4fe2a7a', '6d3f4b4c7e3cf780358cab3954cfd19c3f3194a829105b67c758f857130f', 1773951108, 1768767108);

-- --------------------------------------------------------

--
-- Table structure for table `schema_version`
--

CREATE TABLE `schema_version` (
  `version` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `schema_version`
--

INSERT INTO `schema_version` (`version`) VALUES
(138);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `expire_at` int(11) NOT NULL,
  `data` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `expire_at`, `data`) VALUES
('2cr9bq8dk9fp1siju4ab8am89p', 1768764432, ''),
('ihanm2b9tkoervtko9fr066hjm', 1768768548, 'csrf_key|s:64:\"1bc0dacc3027bb63abea153bdf72df849ff65972ea1f797de84802079b069406\";hasRememberMe|b:1;'),
('knps0klk5biad9esj59ac9q7k3', 1768768454, 'user|a:24:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:12:\"is_ldap_user\";b:0;s:4:\"name\";N;s:5:\"email\";N;s:9:\"google_id\";N;s:9:\"github_id\";N;s:21:\"notifications_enabled\";s:1:\"0\";s:8:\"timezone\";N;s:8:\"language\";N;s:18:\"disable_login_form\";s:1:\"0\";s:19:\"twofactor_activated\";b:0;s:16:\"twofactor_secret\";N;s:5:\"token\";s:0:\"\";s:20:\"notifications_filter\";s:1:\"4\";s:15:\"nb_failed_login\";s:1:\"0\";s:20:\"lock_expiration_date\";s:1:\"0\";s:9:\"gitlab_id\";N;s:4:\"role\";s:9:\"app-admin\";s:9:\"is_active\";s:1:\"1\";s:11:\"avatar_path\";N;s:16:\"api_access_token\";N;s:6:\"filter\";N;s:5:\"theme\";s:5:\"light\";}postAuthenticationValidated|b:1;hasSubtaskInProgress|b:0;csrf_key|s:64:\"a080b10298f96557da0f4b3f1aff9bf38b84cf4e778b80a71e415c5ce1f05242\";flash|a:0:{}filters:1|s:27:\"status:open assignee:nobody\";pcsrf_key|s:64:\"6757c2b246847832c2c07cf283c7ac1a91b5745ff6a251792342f1b5f77b247f\";listOrder:1|a:2:{i:0;s:8:\"tasks.id\";i:1;s:4:\"DESC\";}'),
('lbgvp0ildv9huv9k03mjgokg8c', 1768760538, 'redirectAfterLogin|s:10:\"/kanboard/\";csrf_key|s:64:\"c021d6722d3b4d320832cefefd67e1b9802c596fc715eebfdcbf9cc349ce8f59\";hasRememberMe|b:1;'),
('lck354bhu7u0bu8f38e6vu7hb0', 1768761442, 'redirectAfterLogin|s:69:\"/kanboard/?controller=ProjectViewController&action=share&project_id=1\";csrf_key|s:64:\"4d376ae1c6fa580d8f47ea8339e8e6c7950d45ac6d15f101b81c28172ead36b1\";'),
('mu05lg0o2gpkjrrt5ejgr03oha', 1768768605, 'csrf_key|s:64:\"1bc0dacc3027bb63abea153bdf72df849ff65972ea1f797de84802079b069406\";hasRememberMe|b:1;user|a:24:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:12:\"is_ldap_user\";b:0;s:4:\"name\";N;s:5:\"email\";N;s:9:\"google_id\";N;s:9:\"github_id\";N;s:21:\"notifications_enabled\";s:1:\"0\";s:8:\"timezone\";N;s:8:\"language\";N;s:18:\"disable_login_form\";s:1:\"0\";s:19:\"twofactor_activated\";b:0;s:16:\"twofactor_secret\";N;s:5:\"token\";s:0:\"\";s:20:\"notifications_filter\";s:1:\"4\";s:15:\"nb_failed_login\";s:1:\"0\";s:20:\"lock_expiration_date\";s:1:\"0\";s:9:\"gitlab_id\";N;s:4:\"role\";s:9:\"app-admin\";s:9:\"is_active\";s:1:\"1\";s:11:\"avatar_path\";N;s:16:\"api_access_token\";N;s:6:\"filter\";N;s:5:\"theme\";s:5:\"light\";}postAuthenticationValidated|b:0;hasSubtaskInProgress|b:0;'),
('njl8jjtg84mid051dogfe8jj67', 1768763704, 'csrf_key|s:64:\"c021d6722d3b4d320832cefefd67e1b9802c596fc715eebfdcbf9cc349ce8f59\";hasRememberMe|b:1;user|a:24:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:12:\"is_ldap_user\";b:0;s:4:\"name\";N;s:5:\"email\";N;s:9:\"google_id\";N;s:9:\"github_id\";N;s:21:\"notifications_enabled\";s:1:\"0\";s:8:\"timezone\";N;s:8:\"language\";N;s:18:\"disable_login_form\";s:1:\"0\";s:19:\"twofactor_activated\";b:0;s:16:\"twofactor_secret\";N;s:5:\"token\";s:0:\"\";s:20:\"notifications_filter\";s:1:\"4\";s:15:\"nb_failed_login\";s:1:\"0\";s:20:\"lock_expiration_date\";s:1:\"0\";s:9:\"gitlab_id\";N;s:4:\"role\";s:9:\"app-admin\";s:9:\"is_active\";s:1:\"1\";s:11:\"avatar_path\";N;s:16:\"api_access_token\";N;s:6:\"filter\";N;s:5:\"theme\";s:5:\"light\";}postAuthenticationValidated|b:0;hasSubtaskInProgress|b:0;flash|a:0:{}filters:1|s:11:\"status:open\";pcsrf_key|s:64:\"915109f46777bd5ffa48fee2811dfd0bcdb8994e5db75a5221d992b87726b85a\";'),
('pq82m59aub98t7koo456op1vr8', 1768769374, 'csrf_key|s:64:\"1bc0dacc3027bb63abea153bdf72df849ff65972ea1f797de84802079b069406\";hasRememberMe|b:1;user|a:24:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:12:\"is_ldap_user\";b:0;s:4:\"name\";s:18:\"Quang, NGUYEN DANG\";s:5:\"email\";s:0:\"\";s:9:\"google_id\";N;s:9:\"github_id\";N;s:21:\"notifications_enabled\";s:1:\"0\";s:8:\"timezone\";s:0:\"\";s:8:\"language\";s:0:\"\";s:18:\"disable_login_form\";s:1:\"0\";s:19:\"twofactor_activated\";b:0;s:16:\"twofactor_secret\";N;s:5:\"token\";s:0:\"\";s:20:\"notifications_filter\";s:1:\"4\";s:15:\"nb_failed_login\";s:1:\"0\";s:20:\"lock_expiration_date\";s:1:\"0\";s:9:\"gitlab_id\";N;s:4:\"role\";s:9:\"app-admin\";s:9:\"is_active\";s:1:\"1\";s:11:\"avatar_path\";N;s:16:\"api_access_token\";N;s:6:\"filter\";s:0:\"\";s:5:\"theme\";s:4:\"dark\";}postAuthenticationValidated|b:0;hasSubtaskInProgress|b:0;flash|a:0:{}'),
('q291aio1skkfqg1a4upscvt2f7', 1768768634, 'csrf_key|s:64:\"1bc0dacc3027bb63abea153bdf72df849ff65972ea1f797de84802079b069406\";hasRememberMe|b:1;user|a:24:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:12:\"is_ldap_user\";b:0;s:4:\"name\";N;s:5:\"email\";N;s:9:\"google_id\";N;s:9:\"github_id\";N;s:21:\"notifications_enabled\";s:1:\"0\";s:8:\"timezone\";N;s:8:\"language\";N;s:18:\"disable_login_form\";s:1:\"0\";s:19:\"twofactor_activated\";b:0;s:16:\"twofactor_secret\";N;s:5:\"token\";s:0:\"\";s:20:\"notifications_filter\";s:1:\"4\";s:15:\"nb_failed_login\";s:1:\"0\";s:20:\"lock_expiration_date\";s:1:\"0\";s:9:\"gitlab_id\";N;s:4:\"role\";s:9:\"app-admin\";s:9:\"is_active\";s:1:\"1\";s:11:\"avatar_path\";N;s:16:\"api_access_token\";N;s:6:\"filter\";N;s:5:\"theme\";s:5:\"light\";}postAuthenticationValidated|b:0;hasSubtaskInProgress|b:0;flash|a:0:{}'),
('qf89ue36auie5aklgvb4jktn2e', 1768761711, 'redirectAfterLogin|s:10:\"/kanboard/\";csrf_key|s:64:\"89b22325370d390af38138dc9f19ff61cf9f5a322b38e952b748378968753ebf\";hasRememberMe|b:1;'),
('slj7pifjbtn2uldca8i6s5qdie', 1768768605, 'csrf_key|s:64:\"1bc0dacc3027bb63abea153bdf72df849ff65972ea1f797de84802079b069406\";hasRememberMe|b:1;user|a:24:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:12:\"is_ldap_user\";b:0;s:4:\"name\";N;s:5:\"email\";N;s:9:\"google_id\";N;s:9:\"github_id\";N;s:21:\"notifications_enabled\";s:1:\"0\";s:8:\"timezone\";N;s:8:\"language\";N;s:18:\"disable_login_form\";s:1:\"0\";s:19:\"twofactor_activated\";b:0;s:16:\"twofactor_secret\";N;s:5:\"token\";s:0:\"\";s:20:\"notifications_filter\";s:1:\"4\";s:15:\"nb_failed_login\";s:1:\"0\";s:20:\"lock_expiration_date\";s:1:\"0\";s:9:\"gitlab_id\";N;s:4:\"role\";s:9:\"app-admin\";s:9:\"is_active\";s:1:\"1\";s:11:\"avatar_path\";N;s:16:\"api_access_token\";N;s:6:\"filter\";N;s:5:\"theme\";s:5:\"light\";}postAuthenticationValidated|b:0;hasSubtaskInProgress|b:0;');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `option` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `changed_by` int(11) NOT NULL DEFAULT 0,
  `changed_on` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`option`, `value`, `changed_by`, `changed_on`) VALUES
('api_token', 'd66c342e56025f2b1dc57f51d3bd4c204c0ce2940c0c881a02b2ae7e3da3', 0, 0),
('application_currency', 'USD', 0, 0),
('application_date_format', 'm/d/Y', 0, 0),
('application_language', 'en_US', 0, 0),
('application_stylesheet', '', 0, 0),
('application_timezone', 'UTC', 0, 0),
('application_url', '', 0, 0),
('board_columns', '', 0, 0),
('board_highlight_period', '172800', 0, 0),
('board_private_refresh_interval', '10', 0, 0),
('board_public_refresh_interval', '60', 0, 0),
('calendar_project_tasks', 'date_started', 0, 0),
('calendar_user_subtasks_time_tracking', '0', 0, 0),
('calendar_user_tasks', 'date_started', 0, 0),
('cfd_include_closed_tasks', '1', 0, 0),
('default_color', 'yellow', 0, 0),
('integration_gravatar', '0', 0, 0),
('password_reset', '1', 0, 0),
('project_categories', '', 0, 0),
('subtask_restriction', '0', 0, 0),
('subtask_time_tracking', '1', 0, 0),
('webhook_token', 'd0c220f06bd17b82cd5f2656ec604348e6f8530217830c9fabfa421acbd5', 0, 0),
('webhook_url', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `status` int(11) DEFAULT 0,
  `time_estimated` float DEFAULT NULL,
  `time_spent` float DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtask_time_tracking`
--

CREATE TABLE `subtask_time_tracking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subtask_id` int(11) NOT NULL,
  `start` bigint(20) DEFAULT NULL,
  `end` bigint(20) DEFAULT NULL,
  `time_spent` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swimlanes`
--

CREATE TABLE `swimlanes` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `position` int(11) DEFAULT 1,
  `is_active` int(11) DEFAULT 1,
  `project_id` int(11) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `task_limit` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `swimlanes`
--

INSERT INTO `swimlanes` (`id`, `name`, `position`, `is_active`, `project_id`, `description`, `task_limit`) VALUES
(1, 'Default swimlane', 1, 1, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `project_id` int(11) NOT NULL,
  `color_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `date_creation` bigint(20) DEFAULT NULL,
  `date_completed` bigint(20) DEFAULT NULL,
  `date_due` bigint(20) DEFAULT NULL,
  `color_id` varchar(50) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT 0,
  `position` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `category_id` int(11) DEFAULT 0,
  `creator_id` int(11) DEFAULT 0,
  `date_modification` int(11) DEFAULT 0,
  `reference` varchar(191) DEFAULT '',
  `date_started` bigint(20) DEFAULT NULL,
  `time_spent` float DEFAULT 0,
  `time_estimated` float DEFAULT 0,
  `swimlane_id` int(11) NOT NULL,
  `date_moved` bigint(20) DEFAULT NULL,
  `recurrence_status` int(11) NOT NULL DEFAULT 0,
  `recurrence_trigger` int(11) NOT NULL DEFAULT 0,
  `recurrence_factor` int(11) NOT NULL DEFAULT 0,
  `recurrence_timeframe` int(11) NOT NULL DEFAULT 0,
  `recurrence_basedate` int(11) NOT NULL DEFAULT 0,
  `recurrence_parent` int(11) DEFAULT NULL,
  `recurrence_child` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT 0,
  `external_provider` varchar(255) DEFAULT NULL,
  `external_uri` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_has_external_links`
--

CREATE TABLE `task_has_external_links` (
  `id` int(11) NOT NULL,
  `link_type` varchar(100) NOT NULL,
  `dependency` varchar(100) NOT NULL,
  `title` mediumtext NOT NULL,
  `url` mediumtext NOT NULL,
  `date_creation` int(11) NOT NULL,
  `date_modification` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `creator_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_has_files`
--

CREATE TABLE `task_has_files` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `path` mediumtext NOT NULL,
  `is_image` tinyint(1) DEFAULT 0,
  `task_id` int(11) NOT NULL,
  `date` bigint(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `size` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_has_links`
--

CREATE TABLE `task_has_links` (
  `id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `opposite_task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_has_metadata`
--

CREATE TABLE `task_has_metadata` (
  `task_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) DEFAULT '',
  `changed_by` int(11) NOT NULL DEFAULT 0,
  `changed_on` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_has_tags`
--

CREATE TABLE `task_has_tags` (
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transitions`
--

CREATE TABLE `transitions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `src_column_id` int(11) NOT NULL,
  `dst_column_id` int(11) NOT NULL,
  `date` bigint(20) DEFAULT NULL,
  `time_spent` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_ldap_user` tinyint(1) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `google_id` varchar(30) DEFAULT NULL,
  `github_id` varchar(30) DEFAULT NULL,
  `notifications_enabled` tinyint(1) DEFAULT 0,
  `timezone` varchar(50) DEFAULT NULL,
  `language` varchar(11) DEFAULT NULL,
  `disable_login_form` tinyint(1) DEFAULT 0,
  `twofactor_activated` tinyint(1) DEFAULT 0,
  `twofactor_secret` char(16) DEFAULT NULL,
  `token` varchar(255) DEFAULT '',
  `notifications_filter` int(11) DEFAULT 4,
  `nb_failed_login` int(11) DEFAULT 0,
  `lock_expiration_date` bigint(20) DEFAULT NULL,
  `gitlab_id` int(11) DEFAULT NULL,
  `role` varchar(25) NOT NULL DEFAULT 'app-user',
  `is_active` tinyint(1) DEFAULT 1,
  `avatar_path` varchar(255) DEFAULT NULL,
  `api_access_token` varchar(255) DEFAULT NULL,
  `filter` mediumtext DEFAULT NULL,
  `theme` varchar(50) NOT NULL DEFAULT 'light'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_ldap_user`, `name`, `email`, `google_id`, `github_id`, `notifications_enabled`, `timezone`, `language`, `disable_login_form`, `twofactor_activated`, `twofactor_secret`, `token`, `notifications_filter`, `nb_failed_login`, `lock_expiration_date`, `gitlab_id`, `role`, `is_active`, `avatar_path`, `api_access_token`, `filter`, `theme`) VALUES
(1, 'admin', '$2y$10$HryJvAsACIqOSr6wjl9y2.AuW1Pl2MZB/HCbxgX12j1aIa7GLJaXm', 0, 'Quang, NGUYEN DANG', '', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, 0, NULL, 'app-admin', 1, NULL, NULL, '', 'dark'),
(2, 'hung', '$2y$10$0gmVmLrj/n.QJo7rpBrEd.eLo8SiHbH9hD.45p5zJhbTN2Adt2lhW', 0, 'Duong Manh Hung (Test lead 1)', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, 0, NULL, 'app-user', 1, NULL, NULL, '', 'dark'),
(3, 'phuonganh', '$2y$10$VxG7k0VGSnJaDMgMHD0UfuDgLQBgIKIi6043nSCW0DvTrZOeiZOdG', 0, 'Phuong Anh', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'light'),
(4, 'dat', '$2y$10$cEJwlp1qgTGNLRWuGDsZ9.HFDotFQt9jHUOdUUbq9TEHdIqhOx26y', 0, 'Pham Tien Dat', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'light'),
(5, 'hue', '$2y$10$7SknqXut13GAp1zx7IfGBOZHj21WCwxBz6WmaEimagJ5gUBo97VkO', 0, 'Tran Gia Hue', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'light'),
(6, 'son', '$2y$10$3j0fYrT3JXnke07qZL/.5OCYiGt2txgJ3tru12dTEVGnKkponM2Za', 0, 'Mai Thanh Son', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'light'),
(7, 'tung', '$2y$10$hEylaMATVgps81Ckvl2STOL1kOWraRI3gos6xqCjNbMI9H7WhPsjq', 0, 'Le Thanh Tung (Test lead 2)', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'dark'),
(8, 'nhi', '$2y$10$Ti5ZA9XuXBRaxLz6fqlS1ONyoFjUNlpsElZwKAmwDuJIykiLSfi/.', 0, 'Tran Vu Uyen Nhi', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'light'),
(9, 'minh', '$2y$10$eNiDvOSjRPXOfICHt9DfN..wCXiDikOcy6DDY0lZLFpUh8UTetVZq', 0, 'Nguyen Thi Minh', 'test@gmail.com', NULL, NULL, 0, '', '', 0, 0, NULL, '', 4, 0, NULL, NULL, 'app-user', 1, NULL, NULL, '', 'dark');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_metadata`
--

CREATE TABLE `user_has_metadata` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) DEFAULT '',
  `changed_by` int(11) NOT NULL DEFAULT 0,
  `changed_on` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_has_notifications`
--

CREATE TABLE `user_has_notifications` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_has_notification_types`
--

CREATE TABLE `user_has_notification_types` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_has_unread_notifications`
--

CREATE TABLE `user_has_unread_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_creation` bigint(20) NOT NULL,
  `event_name` mediumtext NOT NULL,
  `event_data` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `action_has_params`
--
ALTER TABLE `action_has_params`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_id` (`action_id`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_title_project` (`title`,`project_id`),
  ADD KEY `columns_project_idx` (`project_id`);

--
-- Indexes for table `column_has_move_restrictions`
--
ALTER TABLE `column_has_move_restrictions`
  ADD PRIMARY KEY (`restriction_id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`src_column_id`,`dst_column_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `src_column_id` (`src_column_id`),
  ADD KEY `dst_column_id` (`dst_column_id`);

--
-- Indexes for table `column_has_restrictions`
--
ALTER TABLE `column_has_restrictions`
  ADD PRIMARY KEY (`restriction_id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`column_id`,`rule`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `column_id` (`column_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comments_reference_idx` (`reference`),
  ADD KEY `comments_task_idx` (`task_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD UNIQUE KEY `currency` (`currency`);

--
-- Indexes for table `custom_filters`
--
ALTER TABLE `custom_filters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `group_has_users`
--
ALTER TABLE `group_has_users`
  ADD UNIQUE KEY `group_id` (`group_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`email`,`token`);

--
-- Indexes for table `last_logins`
--
ALTER TABLE `last_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`label`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `plugin_schema_versions`
--
ALTER TABLE `plugin_schema_versions`
  ADD PRIMARY KEY (`plugin`);

--
-- Indexes for table `predefined_task_descriptions`
--
ALTER TABLE `predefined_task_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_activities`
--
ALTER TABLE `project_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `project_daily_column_stats`
--
ALTER TABLE `project_daily_column_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_daily_column_stats_idx` (`day`,`project_id`,`column_id`),
  ADD KEY `column_id` (`column_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_daily_stats`
--
ALTER TABLE `project_daily_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_daily_stats_idx` (`day`,`project_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_has_categories`
--
ALTER TABLE `project_has_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_project_category` (`project_id`,`name`),
  ADD KEY `categories_project_idx` (`project_id`);

--
-- Indexes for table `project_has_files`
--
ALTER TABLE `project_has_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_has_groups`
--
ALTER TABLE `project_has_groups`
  ADD UNIQUE KEY `group_id` (`group_id`,`project_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_has_metadata`
--
ALTER TABLE `project_has_metadata`
  ADD UNIQUE KEY `project_id` (`project_id`,`name`);

--
-- Indexes for table `project_has_notification_types`
--
ALTER TABLE `project_has_notification_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`notification_type`);

--
-- Indexes for table `project_has_roles`
--
ALTER TABLE `project_has_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`role`);

--
-- Indexes for table `project_has_users`
--
ALTER TABLE `project_has_users`
  ADD UNIQUE KEY `idx_project_user` (`project_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_role_has_restrictions`
--
ALTER TABLE `project_role_has_restrictions`
  ADD PRIMARY KEY (`restriction_id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`rule`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`option`);

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtasks_task_idx` (`task_id`);

--
-- Indexes for table `subtask_time_tracking`
--
ALTER TABLE `subtask_time_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subtask_id` (`subtask_id`);

--
-- Indexes for table `swimlanes`
--
ALTER TABLE `swimlanes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`project_id`),
  ADD KEY `swimlanes_project_idx` (`project_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`name`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_task_active` (`is_active`),
  ADD KEY `column_id` (`column_id`),
  ADD KEY `tasks_reference_idx` (`reference`),
  ADD KEY `tasks_project_idx` (`project_id`),
  ADD KEY `tasks_swimlane_ibfk_1` (`swimlane_id`);

--
-- Indexes for table `task_has_external_links`
--
ALTER TABLE `task_has_external_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `task_has_files`
--
ALTER TABLE `task_has_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_task_idx` (`task_id`);

--
-- Indexes for table `task_has_links`
--
ALTER TABLE `task_has_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_has_links_unique` (`link_id`,`task_id`,`opposite_task_id`),
  ADD KEY `opposite_task_id` (`opposite_task_id`),
  ADD KEY `task_has_links_task_index` (`task_id`);

--
-- Indexes for table `task_has_metadata`
--
ALTER TABLE `task_has_metadata`
  ADD UNIQUE KEY `task_id` (`task_id`,`name`);

--
-- Indexes for table `task_has_tags`
--
ALTER TABLE `task_has_tags`
  ADD UNIQUE KEY `tag_id` (`tag_id`,`task_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `transitions`
--
ALTER TABLE `transitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `src_column_id` (`src_column_id`),
  ADD KEY `dst_column_id` (`dst_column_id`),
  ADD KEY `transitions_task_index` (`task_id`),
  ADD KEY `transitions_project_index` (`project_id`),
  ADD KEY `transitions_user_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_idx` (`username`);

--
-- Indexes for table `user_has_metadata`
--
ALTER TABLE `user_has_metadata`
  ADD UNIQUE KEY `user_id` (`user_id`,`name`);

--
-- Indexes for table `user_has_notifications`
--
ALTER TABLE `user_has_notifications`
  ADD UNIQUE KEY `user_has_notifications_unique_idx` (`user_id`,`project_id`),
  ADD KEY `user_has_notifications_ibfk_2` (`project_id`);

--
-- Indexes for table `user_has_notification_types`
--
ALTER TABLE `user_has_notification_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_has_notification_types_user_idx` (`user_id`,`notification_type`);

--
-- Indexes for table `user_has_unread_notifications`
--
ALTER TABLE `user_has_unread_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `action_has_params`
--
ALTER TABLE `action_has_params`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `column_has_move_restrictions`
--
ALTER TABLE `column_has_move_restrictions`
  MODIFY `restriction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `column_has_restrictions`
--
ALTER TABLE `column_has_restrictions`
  MODIFY `restriction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_filters`
--
ALTER TABLE `custom_filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `last_logins`
--
ALTER TABLE `last_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `predefined_task_descriptions`
--
ALTER TABLE `predefined_task_descriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_activities`
--
ALTER TABLE `project_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_daily_column_stats`
--
ALTER TABLE `project_daily_column_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_daily_stats`
--
ALTER TABLE `project_daily_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_has_categories`
--
ALTER TABLE `project_has_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_has_files`
--
ALTER TABLE `project_has_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_has_notification_types`
--
ALTER TABLE `project_has_notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_has_roles`
--
ALTER TABLE `project_has_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_role_has_restrictions`
--
ALTER TABLE `project_role_has_restrictions`
  MODIFY `restriction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remember_me`
--
ALTER TABLE `remember_me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtask_time_tracking`
--
ALTER TABLE `subtask_time_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `swimlanes`
--
ALTER TABLE `swimlanes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_has_external_links`
--
ALTER TABLE `task_has_external_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_has_files`
--
ALTER TABLE `task_has_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_has_links`
--
ALTER TABLE `task_has_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transitions`
--
ALTER TABLE `transitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_has_notification_types`
--
ALTER TABLE `user_has_notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_has_unread_notifications`
--
ALTER TABLE `user_has_unread_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `action_has_params`
--
ALTER TABLE `action_has_params`
  ADD CONSTRAINT `action_has_params_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `columns`
--
ALTER TABLE `columns`
  ADD CONSTRAINT `columns_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `column_has_move_restrictions`
--
ALTER TABLE `column_has_move_restrictions`
  ADD CONSTRAINT `column_has_move_restrictions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `column_has_move_restrictions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `project_has_roles` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `column_has_move_restrictions_ibfk_3` FOREIGN KEY (`src_column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `column_has_move_restrictions_ibfk_4` FOREIGN KEY (`dst_column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `column_has_restrictions`
--
ALTER TABLE `column_has_restrictions`
  ADD CONSTRAINT `column_has_restrictions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `column_has_restrictions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `project_has_roles` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `column_has_restrictions_ibfk_3` FOREIGN KEY (`column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_filters`
--
ALTER TABLE `custom_filters`
  ADD CONSTRAINT `custom_filters_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_filters_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_has_users`
--
ALTER TABLE `group_has_users`
  ADD CONSTRAINT `group_has_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_has_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `last_logins`
--
ALTER TABLE `last_logins`
  ADD CONSTRAINT `last_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `predefined_task_descriptions`
--
ALTER TABLE `predefined_task_descriptions`
  ADD CONSTRAINT `predefined_task_descriptions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_activities`
--
ALTER TABLE `project_activities`
  ADD CONSTRAINT `project_activities_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_activities_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_activities_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_daily_column_stats`
--
ALTER TABLE `project_daily_column_stats`
  ADD CONSTRAINT `project_daily_column_stats_ibfk_1` FOREIGN KEY (`column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_daily_column_stats_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_daily_stats`
--
ALTER TABLE `project_daily_stats`
  ADD CONSTRAINT `project_daily_stats_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_categories`
--
ALTER TABLE `project_has_categories`
  ADD CONSTRAINT `project_has_categories_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_files`
--
ALTER TABLE `project_has_files`
  ADD CONSTRAINT `project_has_files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_groups`
--
ALTER TABLE `project_has_groups`
  ADD CONSTRAINT `project_has_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_has_groups_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_metadata`
--
ALTER TABLE `project_has_metadata`
  ADD CONSTRAINT `project_has_metadata_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_notification_types`
--
ALTER TABLE `project_has_notification_types`
  ADD CONSTRAINT `project_has_notification_types_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_roles`
--
ALTER TABLE `project_has_roles`
  ADD CONSTRAINT `project_has_roles_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_has_users`
--
ALTER TABLE `project_has_users`
  ADD CONSTRAINT `project_has_users_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_has_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_role_has_restrictions`
--
ALTER TABLE `project_role_has_restrictions`
  ADD CONSTRAINT `project_role_has_restrictions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_role_has_restrictions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `project_has_roles` (`role_id`) ON DELETE CASCADE;

--
-- Constraints for table `remember_me`
--
ALTER TABLE `remember_me`
  ADD CONSTRAINT `remember_me_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subtask_time_tracking`
--
ALTER TABLE `subtask_time_tracking`
  ADD CONSTRAINT `subtask_time_tracking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subtask_time_tracking_ibfk_2` FOREIGN KEY (`subtask_id`) REFERENCES `subtasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `swimlanes`
--
ALTER TABLE `swimlanes`
  ADD CONSTRAINT `swimlanes_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_swimlane_ibfk_1` FOREIGN KEY (`swimlane_id`) REFERENCES `swimlanes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_has_external_links`
--
ALTER TABLE `task_has_external_links`
  ADD CONSTRAINT `task_has_external_links_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_has_files`
--
ALTER TABLE `task_has_files`
  ADD CONSTRAINT `task_has_files_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_has_links`
--
ALTER TABLE `task_has_links`
  ADD CONSTRAINT `task_has_links_ibfk_1` FOREIGN KEY (`link_id`) REFERENCES `links` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_has_links_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_has_links_ibfk_3` FOREIGN KEY (`opposite_task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_has_metadata`
--
ALTER TABLE `task_has_metadata`
  ADD CONSTRAINT `task_has_metadata_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_has_tags`
--
ALTER TABLE `task_has_tags`
  ADD CONSTRAINT `task_has_tags_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_has_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transitions`
--
ALTER TABLE `transitions`
  ADD CONSTRAINT `transitions_ibfk_1` FOREIGN KEY (`src_column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transitions_ibfk_2` FOREIGN KEY (`dst_column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transitions_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transitions_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transitions_ibfk_5` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_has_metadata`
--
ALTER TABLE `user_has_metadata`
  ADD CONSTRAINT `user_has_metadata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_has_notifications`
--
ALTER TABLE `user_has_notifications`
  ADD CONSTRAINT `user_has_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_notifications_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_has_notification_types`
--
ALTER TABLE `user_has_notification_types`
  ADD CONSTRAINT `user_has_notification_types_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_has_unread_notifications`
--
ALTER TABLE `user_has_unread_notifications`
  ADD CONSTRAINT `user_has_unread_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

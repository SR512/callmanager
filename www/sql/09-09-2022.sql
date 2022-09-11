/*Table structure for table `devices` */

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `device_code` varchar(100) DEFAULT NULL,
  `device_os` varchar(100) DEFAULT NULL,
  `device_model` varchar(100) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'N',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `devices` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `failed_jobs` */

/*Table structure for table `mail_templates` */

DROP TABLE IF EXISTS `mail_templates`;

CREATE TABLE `mail_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_code` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `mailable` varchar(255) NOT NULL,
  `subject` text DEFAULT NULL,
  `html_template` longtext NOT NULL,
  `text_template` longtext DEFAULT NULL,
  `template_type` enum('SMS','EMAIL') DEFAULT 'EMAIL',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

/*Data for the table `mail_templates` */

insert  into `mail_templates`(`id`,`template_code`,`template_name`,`mailable`,`subject`,`html_template`,`text_template`,`template_type`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(19,'create_user_notification','Create user notification','App\\Mail\\UserCreateNotification','User Create Notification','<p>Hello {{NAME}}</p>\r\n\r\n<p>We have created your account in {{PRACTICE_NAME}} backen and below is the login details.</p>\r\n\r\n<p>Username: {{USER}}</p>\r\n\r\n<p>Password: {{PASSWORD}}</p>\r\n\r\n<p>{{LOGIN}}</p>\r\n\r\n<p>Regards,<br />\r\n{{PRACTICE_NAME}}</p>\r\n\r\n<p><span style=\"color:#e74c3c\"><strong>DO NOT REPLY TO THIS E-MAIL</strong></span><br />\r\nThis is an automated e-mail message sent from our support system.<br />\r\nDo not reply to this e-mail as we will not receive your reply!</p>','Hello \\n \\n I am inviting you to a video consultation session. Please click below to join the consultation (no account needed) \\n \\nVideo consultation time: {time} \\n \\nVideo consultation link: {URL} \\n \\nBest Regards,\\n{PRACTICE_NAME}','EMAIL',NULL,NULL,'2021-09-30 07:52:54',NULL,NULL,NULL),
(21,'reset_password_notification','Reset Password Notification','App\\Mail\\ResetPasswordMail','Reset Password Notification','<p>You are receiving this email because we received a password reset request for your account.</p>\r\n\r\n<p>{{RESET}}</p>\r\n\r\n<p>This password reset link will expire in 60 minutes.</p>\r\n\r\n<p>If you did not request a password reset, no further action is required.</p>\r\n\r\n<p>Regards,<br />\r\n{{PRACTICE_NAME}}</p>\r\n\r\n<p><span style=\"color:#e74c3c\"><strong>DO NOT REPLY TO THIS E-MAIL</strong></span><br />\r\nThis is an automated e-mail message sent from our support system.<br />\r\nDo not reply to this e-mail as we will not receive your reply!</p>','Hello \\n \\n I am inviting you to a video consultation session. Please click below to join the consultation (no account needed) \\n \\nVideo consultation time: {time} \\n \\nVideo consultation link: {URL} \\n \\nBest Regards,\\n{PRACTICE_NAME}','EMAIL',NULL,NULL,'2022-01-27 07:31:15',NULL,NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2021_09_30_053857_create_permission_tables',1),
(6,'2018_10_10_000000_create_mail_templates_table',2);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values 
(1,'App\\Models\\User',2),
(1,'App\\Models\\User',8),
(2,'App\\Models\\User',5),
(2,'App\\Models\\User',15),
(2,'App\\Models\\User',21),
(2,'App\\Models\\User',24),
(6,'App\\Models\\User',12),
(6,'App\\Models\\User',16),
(6,'App\\Models\\User',18),
(6,'App\\Models\\User',19),
(6,'App\\Models\\User',20),
(6,'App\\Models\\User',22),
(6,'App\\Models\\User',23),
(6,'App\\Models\\User',26);

/*Table structure for table `oauth_access_tokens` */

DROP TABLE IF EXISTS `oauth_access_tokens`;

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `oauth_access_tokens` */

insert  into `oauth_access_tokens`(`id`,`user_id`,`client_id`,`name`,`scopes`,`revoked`,`created_at`,`updated_at`,`expires_at`) values 
('0a3cd5ca55395ad04dc07c35ce0c7dea740cf3d4480166214a0da44735a3eaf68eac4d9359f8e47d',26,1,'callmanager','[]',0,'2022-09-08 16:43:52','2022-09-08 16:43:52','2023-09-08 16:43:52'),
('362aa9b4fc3820eacc4112a0ef8bebb0b1916be550fe1946ece746b6036b794b29096e7f27c25012',26,1,'callmanager','[]',0,'2022-09-08 16:43:04','2022-09-08 16:43:04','2023-09-08 16:43:04'),
('39c4d9bb6365c165576b672cbabac16f65f634aafed191142e7411f6a55a0ef104d0b42150b4061b',26,1,'callmanager','[]',0,'2022-09-08 17:08:32','2022-09-08 17:08:32','2023-09-08 17:08:32'),
('3df7ce2e36373d987715b0fe28a6be27e5c19baeac32bfd5fc7a61e255356e71fb4bfaa06d039970',26,1,'callmanager','[]',0,'2022-09-08 17:47:47','2022-09-08 17:47:47','2023-09-08 17:47:47'),
('44e2e9eb3cdf15a17e01cfe2b7a305c5ed183048d2d86e31ea0ed658519ce5bfb84ffd0033e5fe90',26,1,'callmanager','[]',0,'2022-09-08 17:37:54','2022-09-08 17:37:54','2023-09-08 17:37:54'),
('47d873a0091640b28d619ee868ef4310a92562c5a7095936c4962f52ad858ffe735aca3b8dfa40d2',26,1,'callmanager','[]',0,'2022-09-08 17:38:21','2022-09-08 17:38:21','2023-09-08 17:38:21'),
('4a5f96611d9087976539f514dadaad3b1558e0abe010386a1cb9d2df3829fc0084fe3df0d988f820',26,1,'callmanager','[]',1,'2022-09-08 11:31:18','2022-09-08 17:53:11','2023-09-08 11:31:18'),
('558f68c5b823eb97664fd21a6fb138c3d12538f942a3aae4ea8d7d0e5a46ddea59da418561a223db',26,1,'callmanager','[]',0,'2022-09-08 17:46:35','2022-09-08 17:46:35','2023-09-08 17:46:35'),
('5766bdd40a29bdd94eee1ea3860b6b8cbde33f70b68417d3b26dcf165ad5eb374738bc932c18eb77',26,1,'callmanager','[]',0,'2022-09-08 17:34:18','2022-09-08 17:34:18','2023-09-08 17:34:18'),
('5d7bd3041e11170e7aaa5054792483b7c2bdd8cd38fcf83829e96ef566e4289f7f3af50aaf5e5c3c',26,1,'callmanager','[]',0,'2022-09-08 17:45:53','2022-09-08 17:45:53','2023-09-08 17:45:53'),
('64dcf6cafb8cb8472ed267f66ff3bb5758ddf886e281ebbebafa418c3965eb99279a3e125cc38a31',26,1,'callmanager','[]',0,'2022-09-08 17:08:39','2022-09-08 17:08:39','2023-09-08 17:08:39'),
('665867f120f5aff1f7cbfe6c389c7b080819662a0b56e74fe6cba185bf13080a98e747df203c8ed6',26,1,'callmanager','[]',0,'2022-09-08 17:09:05','2022-09-08 17:09:05','2023-09-08 17:09:05'),
('80905abada53f28aede5e8414b5fbaed48402a7ff00b05bf6cd0297987cdf70998af66570f0cd3ed',26,1,'callmanager','[]',0,'2022-09-08 17:36:20','2022-09-08 17:36:20','2023-09-08 17:36:20'),
('87181d543bd33024a373089e3dd247e85a76e3fc417a03edeffd236ad9cfc3dae1b729f8bdac1796',26,1,'callmanager','[]',0,'2022-09-08 17:47:19','2022-09-08 17:47:19','2023-09-08 17:47:19'),
('91948391a4bf76b697d15f1ac74194e6223ea537fa952f7138cf334c6c6eefdce2c3c014cc332ae7',26,1,'callmanager','[]',0,'2022-09-08 17:46:22','2022-09-08 17:46:23','2023-09-08 17:46:22'),
('9656e2dc4a45408b858c6f9d291c85778f16acb7ae8fbb982d1f426effe0da721ef62b1fcd95e369',26,1,'callmanager','[]',0,'2022-09-08 16:40:31','2022-09-08 16:40:31','2023-09-08 16:40:31'),
('a9ab39393f8eb465c9847b91a9e4940804bb2c1d299aacc65d11f9e13dc33874519af92d10236b38',26,1,'callmanager','[]',0,'2022-09-08 17:09:33','2022-09-08 17:09:33','2023-09-08 17:09:33'),
('aa8bf9e7dd0f91c7d66c78c259bc5ae2850ca4f7bb85e809940f6106766e180c92852123f019efa7',26,1,'callmanager','[]',0,'2022-09-08 17:48:14','2022-09-08 17:48:14','2023-09-08 17:48:14'),
('ba50876b0e8701bf12c5996a8b5871b3b90beafa40fad1453648cedfbb6f4383a2c5402f686c6cd1',26,1,'callmanager','[]',0,'2022-09-08 18:10:45','2022-09-08 18:10:45','2023-09-08 18:10:45'),
('c31f07006ce01a3a0fb84ca3c2bef4b2bef7b5f1845d85014d45a6e75879e31c4a72f4c7fe32f04a',26,1,'callmanager','[]',0,'2022-09-08 16:42:26','2022-09-08 16:42:26','2023-09-08 16:42:26'),
('cafd7df5172817f15dad91d4d85797c213d56db29dd2ddf341eb46c7b0773638541b58943ff1950a',26,1,'callmanager','[]',0,'2022-09-08 17:35:05','2022-09-08 17:35:05','2023-09-08 17:35:05'),
('cb9557e9352ecf5c8dd1062f820c6fcc7185c2907dfeb3f13f51defec7312b4cb2fb520cd461ff93',26,1,'callmanager','[]',0,'2022-09-08 16:45:53','2022-09-08 16:45:53','2023-09-08 16:45:53'),
('e377d85456901c7c66efab21a85e35cfd04031c249ca37c17e322732b7a5c041b9b4c90f567134ca',26,1,'callmanager','[]',0,'2022-09-08 16:43:24','2022-09-08 16:43:24','2023-09-08 16:43:24'),
('f974e8ef87cb5a13d8b0df9ff87b85c0f67bd91c2365b17f77170c271c9587cf36e2339f7371edfb',26,1,'callmanager','[]',0,'2022-09-08 17:08:52','2022-09-08 17:08:52','2023-09-08 17:08:52');

/*Table structure for table `oauth_auth_codes` */

DROP TABLE IF EXISTS `oauth_auth_codes`;

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `oauth_auth_codes` */

/*Table structure for table `oauth_clients` */

DROP TABLE IF EXISTS `oauth_clients`;

CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `oauth_clients` */

insert  into `oauth_clients`(`id`,`user_id`,`name`,`secret`,`provider`,`redirect`,`personal_access_client`,`password_client`,`revoked`,`created_at`,`updated_at`) values 
(1,NULL,'Call manager Personal Access Client','RQNPNHAzlPSJtbERVPmJXkWyEEB8bMsAbh3HCqP8',NULL,'http://localhost',1,0,0,'2022-09-08 11:12:14','2022-09-08 11:12:14'),
(2,NULL,'Call manager Password Grant Client','kKIAuzSRqAxDvYqZ6l8ugPkfRzUG3BWNd4SENdpi','users','http://localhost',0,1,0,'2022-09-08 11:12:14','2022-09-08 11:12:14');

/*Table structure for table `oauth_personal_access_clients` */

DROP TABLE IF EXISTS `oauth_personal_access_clients`;

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `oauth_personal_access_clients` */

insert  into `oauth_personal_access_clients`(`id`,`client_id`,`created_at`,`updated_at`) values 
(1,1,'2022-09-08 11:12:14','2022-09-08 11:12:14');

/*Table structure for table `oauth_refresh_tokens` */

DROP TABLE IF EXISTS `oauth_refresh_tokens`;

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `oauth_refresh_tokens` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`token`,`created_at`) values 
('itplanet99@gmail.com','$2y$10$af1QXwbEuub8xA81HEMFMuJQ31YsKK4LmaajkUXfrW.zHVJVR.2l.','2022-09-05 07:57:52');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `permission_label` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`title`,`name`,`permission_label`,`guard_name`,`is_active`,`created_at`,`updated_at`) values 
(1,'Dashboard','home','Dashboard','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(2,'Settings','setting.index','Site configuration show','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(3,'Settings','emailtemplate.index','Email template show','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(4,'Settings','emailtemplates.create','Email edit','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(5,'User and role management','usermanagement.index','User show','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(6,'User and role management','usermanagements.create','User create','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(7,'User and role management','usermanagements.edit','User edit','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(8,'User and role management','usermanagements.destroy','User delete','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(9,'User and role management','role.index','Role show','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(10,'User and role management','roles.create','Role create','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(11,'User and role management','roles.edit','Role edit','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(12,'User and role management','roles.destroy','Role delete','web','Y','2021-09-30 06:06:57','2021-09-30 06:06:57'),
(26,'Report','smslogs.index','Sms logs show','web','Y',NULL,NULL);

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values 
(1,2),
(2,2),
(3,2),
(4,2),
(5,2),
(6,2),
(7,2),
(8,2),
(9,2),
(10,2),
(11,2),
(12,2),
(26,6);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `show_while_creating_user` enum('YES','NO') DEFAULT 'YES',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`show_while_creating_user`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(1,'Super Admin','web','YES','2021-09-30 06:02:37',NULL,'2021-09-30 06:02:37',NULL,NULL,NULL),
(2,'Admin','web','YES','2021-09-30 06:02:38',NULL,'2021-09-30 06:02:38',NULL,NULL,NULL),
(6,'user','web','YES','2022-01-27 07:16:05',NULL,'2022-09-06 11:47:44',NULL,NULL,NULL);

/*Table structure for table `sms_configuration` */

DROP TABLE IF EXISTS `sms_configuration`;

CREATE TABLE `sms_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `api_key` varchar(200) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `sender_name` varchar(50) DEFAULT NULL,
  `sms_type` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sms_configuration` */

/*Table structure for table `sms_logs` */

DROP TABLE IF EXISTS `sms_logs`;

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `message` text DEFAULT NULL,
  `errors` text DEFAULT NULL,
  `is_send` enum('Y','N') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`,`device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sms_logs` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `message` int(20) DEFAULT 0,
  `device` int(11) DEFAULT 0,
  `logins` int(11) DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(50) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`profile`,`remember_token`,`message`,`device`,`logins`,`last_login_at`,`last_login_ip`,`is_active`,`expiry_date`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(2,'Admin','itplanet99@gmail.com',NULL,'$2y$10$ToxxJm5ajt7mSRb2tYCM4O9OpH5W7FEEt0nXIUd.gkG6D4euXv2T2','trKssfRDK4usdgmnjBu2WZSAXpdKHzkpTgysXdK0.png','IY6SaKUGPn7Bir1L4pkXOWgj7FkUKejOwXO3yWUE832RBrW1omoBr8HKcPHn',0,0,14,'2022-09-08 16:34:45','127.0.0.1',NULL,NULL,'2021-09-30 06:14:32',NULL,'2022-09-08 16:34:45',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

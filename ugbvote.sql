-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: ugbvote
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiant_officiels`
--

DROP TABLE IF EXISTS `etudiant_officiels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudiant_officiels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `etudiant_officiels_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant_officiels`
--

LOCK TABLES `etudiant_officiels` WRITE;
/*!40000 ALTER TABLE `etudiant_officiels` DISABLE KEYS */;
INSERT INTO `etudiant_officiels` VALUES (1,'p31 2127','2025-03-29 18:05:03','2025-03-29 18:05:03'),(2,'p31 2227','2025-03-29 18:05:03','2025-03-29 18:05:03'),(3,'p31 2327','2025-03-29 18:05:03','2025-03-29 18:05:03'),(4,'p312121','2025-04-02 01:47:52','2025-04-02 01:47:55'),(5,'p312277','2025-04-02 17:17:21','2025-04-02 17:17:25'),(6,'p310000','2025-04-02 17:37:55','2025-04-02 17:37:57');
/*!40000 ALTER TABLE `etudiant_officiels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudiants` (
  `id_etudiant` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_etudiant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ufr_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_etudiant`),
  UNIQUE KEY `etudiants_code_etudiant_unique` (`code_etudiant`),
  UNIQUE KEY `etudiants_mail_unique` (`mail`),
  KEY `etudiants_ufr_id_foreign` (`ufr_id`),
  CONSTRAINT `etudiants_ufr_id_foreign` FOREIGN KEY (`ufr_id`) REFERENCES `u_f_r_s` (`id_ufr`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiants`
--

LOCK TABLES `etudiants` WRITE;
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` VALUES (1,'gueye','amteh','p31 2127','ameth@gmail.com','$2y$12$MGfzEB98W0Z0zK8xgpaKOORAr/Kegt.yREzfUG3F8xvJiGUKKa3vG',1,'2025-03-29 18:05:03','2025-03-30 00:59:12'),(2,'diop','anta','p31 2227','anta@gmail.com','$2y$12$egJetdBrpbDpEebom72.MOBgqo6t9xYiSaW/3kIhKuCipMlGGsRKS',1,'2025-03-29 18:05:03','2025-03-30 01:00:21'),(3,'fickou','daouda','p31 2327','daouda@gmail.com','$2y$12$/zFJ7YCp0RA97MtN6yq2JOpZxQ7TJZTGx9dhnaUf1IYbYGsDdFO3q',1,'2025-03-29 18:05:03','2025-03-30 01:05:07'),(4,'test1','test1','test1','test1@gmail.com','$2y$12$jjM9UrzPFU9t9zJjLUzR/OP26KtMWwDoU4lWfBtGD1L0QQCx0U/JS',1,'2025-03-31 20:35:16','2025-03-31 20:35:16'),(5,'gueye','Mouhamdou','p31 2126','gueye.mouhamadou7@ugb.edu.sn','$2y$12$hGNPXW8VyTNB.30624vx6OoRIQ/fvI87m18yNZErjst..4LRIlsVa',1,'2025-04-02 01:11:42','2025-04-02 01:11:42'),(6,'gueye','Mouhamdou2','p312121','2gueye.mouhamadou7@ugb.edu.sn','$2y$12$SfzCN3bWv9GG6sQBa11V/.DuORS/PXpvoVo0AwAqxQMUmaCzSV6Cq',1,'2025-04-02 01:48:33','2025-04-02 01:48:33'),(7,'Nom','Prenom','p312277','prenom@gmaill.com','$2y$12$WrwAV5hPfKoq8Kc7KcyQXOnSsVaQiCscne7RMe.UU6T2rGUnHkfXO',1,'2025-04-02 17:20:27','2025-04-02 17:20:27'),(9,'Nom','Prenom','p310000','exemple@gmail.com','$2y$12$cichfOIiJN0pKMZAlRClru3/ZhyHkaDzB2M14mz/Rlf6ySuVxHYHW',1,'2025-04-02 18:34:18','2025-04-02 18:34:18');
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listes`
--

DROP TABLE IF EXISTS `listes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listes` (
  `id_list` bigint unsigned NOT NULL AUTO_INCREMENT,
  `programme` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_list` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ufr_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_list`),
  KEY `listes_ufr_id_foreign` (`ufr_id`),
  CONSTRAINT `listes_ufr_id_foreign` FOREIGN KEY (`ufr_id`) REFERENCES `u_f_r_s` (`id_ufr`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listes`
--

LOCK TABLES `listes` WRITE;
/*!40000 ALTER TABLE `listes` DISABLE KEYS */;
INSERT INTO `listes` VALUES (1,'programme d-election de la liste','Convergeons vers un avenir meilleur ','convergence',1,'2025-03-29 18:05:03','2025-03-29 18:05:03'),(2,'programme d-election de la liste','craquer pour crack','crak',1,'2025-03-29 18:05:43','2025-03-29 18:05:43'),(3,'Et est dolor enim elit ad labore sint ex aute. Nostrud ipsum cillum voluptate nisi labore laborum nisi. Labore aliqua exercitation eiusmod voluptate culpa aliquip voluptate minim incididunt eu eiusmod.  Aliquip officia minim fugiat proident dolor nulla est aute in dolor sit laboris occaecat. Ut pariatur nisi mollit commodo. Est aute veniam exercitation excepteur mollit. Tempor sit proident do nisi sunt incididunt Lorem dolore.  Velit ut cillum incididunt id mollit dolore est ea. Labore labore pariatur commodo consectetur nisi amet qui nisi commodo. Dolore tempor anim Lorem reprehenderit voluptate labore excepteur sit sint magna. Ut incididunt sit consectetur non velit minim veniam quis cupidatat nostrud nostrud.  Excepteur in do sint cupidatat cillum nostrud aliqua reprehenderit nulla in labore Lorem magna. Voluptate ea adipisicing Lorem non cupidatat pariatur commodo eiusmod mollit pariatur velit ex et aute. Consequat laborum in irure veniam non dolore et quis esse eu cillum proident nisi non. Aliqua officia laborum proident non veniam id reprehenderit sunt.  Labore excepteur laborum quis ea fugiat ullamco excepteur eu ipsum. Minim ad ut cupidatat mollit ea eu. Ea duis duis eu magna reprehenderit elit voluptate tempor est do. Labore reprehenderit consequat duis elit do amet commodo est minim.  Voluptate adipisicing id tempor sint eiusmod aliquip ipsum incididunt laboris ut. Exercitation eu irure consequat deserunt culpa do. Excepteur mollit dolor do est tempor. Ea dolor amet non amet Lorem cillum nulla sit est.  Dolor velit labore ea dolore fugiat reprehenderit. Consequat dolor eu id labore excepteur elit. Irure ea cupidatat irure elit nulla minim velit eu mollit dolor tempor anim ipsum pariatur.  Culpa consequat commodo Lorem anim ullamco qui non qui ad cupidatat ad culpa voluptate. Ad eu occaecat proident ullamco ad elit ipsum est dolor. Ea exercitation culpa dolor irure adipisicing. Magna pariatur laboris voluptate Lorem nisi consequat occaecat nulla excepteur dolor proident deserunt commodo duis. Anim laboris labore aliqua aliqua deserunt duis labore Lorem qui tempor dolore. Esse et proident sunt sit nostrud sint.  Ad aliqua adipisicing qui proident in aliqua do reprehenderit duis. Ex dolore exercitation aute veniam ut aliqua adipisicing adipisicing laborum nulla ea anim eu. Officia nostrud dolore magna amet. Magna pariatur fugiat pariatur velit tempor culpa occaecat ullamco id. Id pariatur nulla anim tempor aute amet. Deserunt velit laborum ea incididunt enim in amet cupidatat deserunt laborum et ullamco sunt do.  Aliquip aliqua consectetur consequat sit enim est est id anim pariatur elit voluptate. Quis cillum irure labore commodo excepteur. Et commodo in laborum quis esse in quis. Dolor amet ut consectetur cupidatat minim esse.','TitreDuProgramme','NomDeLaListe ',1,'2025-04-02 17:48:47','2025-04-02 17:48:50');
/*!40000 ALTER TABLE `listes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membres_listes`
--

DROP TABLE IF EXISTS `membres_listes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membres_listes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tete_liste` tinyint(1) NOT NULL DEFAULT '0',
  `list_id` bigint unsigned NOT NULL,
  `id_membre` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membres_listes_list_id_foreign` (`list_id`),
  KEY `membres_listes_id_membre_foreign` (`id_membre`),
  CONSTRAINT `membres_listes_id_membre_foreign` FOREIGN KEY (`id_membre`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE,
  CONSTRAINT `membres_listes_list_id_foreign` FOREIGN KEY (`list_id`) REFERENCES `listes` (`id_list`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membres_listes`
--

LOCK TABLES `membres_listes` WRITE;
/*!40000 ALTER TABLE `membres_listes` DISABLE KEYS */;
INSERT INTO `membres_listes` VALUES (1,1,1,2,'2025-03-29 18:05:03','2025-03-29 18:05:03'),(2,0,1,3,'2025-03-29 18:05:03','2025-03-29 18:05:03'),(3,1,2,1,'2025-04-01 17:37:33','2025-04-01 17:37:36'),(4,0,2,3,'2025-04-01 17:38:13','2025-04-01 17:38:16'),(5,1,3,1,'2025-04-02 17:58:36','2025-04-02 17:58:38'),(6,0,3,2,'2025-04-02 17:59:13','2025-04-02 17:59:16'),(7,0,3,3,'2025-04-02 17:59:42','2025-04-02 17:59:45');
/*!40000 ALTER TABLE `membres_listes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_03_29_160118_create_u_f_r_s_table',1),(5,'2025_03_29_160414_create_etudiants_table',1),(6,'2025_03_29_160624_create_listes_table',1),(7,'2025_03_29_160850_create_votes_table',1),(8,'2025_03_29_161004_create_membres_listes_table',1),(9,'2025_03_29_161151_create_etudiant_officiels_table',1),(10,'2025_03_30_160803_add_vote_id_to_ufrs_table',2),(11,'2025_03_30_223921_add_titre_to_listes_table',3),(12,'2025_03_31_204542_create_vote_etudiants_table',4),(13,'2025_04_01_000045_add_list_id_to_vote_etudiants_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('dOCvrOXWRbdhEihK1jsQe0H5ivwWWuQZ4StScr7v',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTgzYXo1MnBLS0JxTENXenlIZlptaUI2ZnhpU1FjWmU0NU5CdVRxMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=',1743620241);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `u_f_r_s`
--

DROP TABLE IF EXISTS `u_f_r_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `u_f_r_s` (
  `id_ufr` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vote_id` bigint unsigned DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ufr`),
  KEY `u_f_r_s_vote_id_foreign` (`vote_id`),
  CONSTRAINT `u_f_r_s_vote_id_foreign` FOREIGN KEY (`vote_id`) REFERENCES `votes` (`id_vote`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `u_f_r_s`
--

LOCK TABLES `u_f_r_s` WRITE;
/*!40000 ALTER TABLE `u_f_r_s` DISABLE KEYS */;
INSERT INTO `u_f_r_s` VALUES (1,1,'sat','2025-03-29 18:05:02','2025-03-29 18:05:02'),(2,2,'sjp','2025-03-29 18:05:02','2025-03-29 18:05:02');
/*!40000 ALTER TABLE `u_f_r_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-03-29 18:05:02','$2y$12$jpIeEEuDOnBSz2t2Tsov4ehOTT9w/vxJOjisxUk7g.o5d1OVg58Ga','2M066yh0lb','2025-03-29 18:05:02','2025-03-29 18:05:02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote_etudiants`
--

DROP TABLE IF EXISTS `vote_etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vote_etudiants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `etudiant_id` bigint unsigned NOT NULL,
  `vote_id` bigint unsigned NOT NULL,
  `list_id` bigint unsigned NOT NULL,
  `voted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vote_etudiants_etudiant_id_foreign` (`etudiant_id`),
  KEY `vote_etudiants_vote_id_foreign` (`vote_id`),
  KEY `vote_etudiants_list_id_foreign` (`list_id`),
  CONSTRAINT `vote_etudiants_etudiant_id_foreign` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id_etudiant`) ON DELETE CASCADE,
  CONSTRAINT `vote_etudiants_list_id_foreign` FOREIGN KEY (`list_id`) REFERENCES `listes` (`id_list`) ON DELETE CASCADE,
  CONSTRAINT `vote_etudiants_vote_id_foreign` FOREIGN KEY (`vote_id`) REFERENCES `votes` (`id_vote`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote_etudiants`
--

LOCK TABLES `vote_etudiants` WRITE;
/*!40000 ALTER TABLE `vote_etudiants` DISABLE KEYS */;
INSERT INTO `vote_etudiants` VALUES (1,1,1,1,'2025-04-01 13:01:25','2025-04-01 13:01:25','2025-04-01 13:01:25'),(2,3,1,2,'2025-04-01 17:43:01','2025-04-01 17:43:01','2025-04-01 17:43:01'),(3,5,1,1,'2025-04-02 01:14:54','2025-04-02 01:14:54','2025-04-02 01:14:54'),(4,7,1,2,'2025-04-02 17:21:45','2025-04-02 17:21:45','2025-04-02 17:21:45'),(6,9,1,3,'2025-04-02 18:44:55','2025-04-02 18:44:55','2025-04-02 18:44:55');
/*!40000 ALTER TABLE `vote_etudiants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votes` (
  `id_vote` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_vote`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
INSERT INTO `votes` VALUES (1,'2025-03-29','2025-04-05','2025-03-29 18:05:03','2025-03-29 18:05:03'),(2,'2025-04-06','2025-04-15','2025-03-29 18:05:03','2025-03-29 18:05:03');
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-02 19:09:00

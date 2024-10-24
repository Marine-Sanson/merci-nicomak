-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de table merci_nicomak. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table merci_nicomak.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20241024074433', '2024-10-24 07:45:01', 157);

-- Listage de la structure de table merci_nicomak. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table merci_nicomak.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table merci_nicomak. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table merci_nicomak.user : ~6 rows (environ)
INSERT INTO `user` (`id`, `username`, `roles`, `password`, `avatar`) VALUES
	(1, 'Alice', '["ROLE_USER"]', '$2y$13$A0rOnQOB2H//WQhSy6C1wO8J9HNP2nZNWwrMQG8PnEA3jHiZLJnV.', 'avatar_alice.PNG'),
	(2, 'Céline', '["ROLE_USER"]', '$2y$13$A0rOnQOB2H//WQhSy6C1wO8J9HNP2nZNWwrMQG8PnEA3jHiZLJnV.', 'avatar_celine.PNG'),
	(3, 'Geoffroy', '["ROLE_USER"]', '$2y$13$A0rOnQOB2H//WQhSy6C1wO8J9HNP2nZNWwrMQG8PnEA3jHiZLJnV.', 'avatar_geoffroy.PNG'),
	(4, 'Laetitia', '["ROLE_USER"]', '$2y$13$A0rOnQOB2H//WQhSy6C1wO8J9HNP2nZNWwrMQG8PnEA3jHiZLJnV.', 'avatar_laetitia.PNG'),
	(5, 'Laura', '["ROLE_USER"]', '$2y$13$A0rOnQOB2H//WQhSy6C1wO8J9HNP2nZNWwrMQG8PnEA3jHiZLJnV.', 'avatar_laura.PNG'),
	(6, 'Myriam', '["ROLE_USER"]', '$2y$13$A0rOnQOB2H//WQhSy6C1wO8J9HNP2nZNWwrMQG8PnEA3jHiZLJnV.', 'avatar_myriam.PNG');

-- Listage de la structure de table merci_nicomak. merci
CREATE TABLE IF NOT EXISTS `merci` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_86B31E76F675F31B` (`author_id`),
  KEY `IDX_86B31E76E92F8F78` (`recipient_id`),
  CONSTRAINT `FK_86B31E76E92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_86B31E76F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table merci_nicomak.merci : ~7 rows (environ)
INSERT INTO `merci` (`id`, `author_id`, `recipient_id`, `reason`, `created_at`) VALUES
	(1, 2, 5, 'm\'avoir apporté son aide sur un dossier', '2024-09-21 11:04:16'),
	(2, 4, 3, 'avoir appporté des croissants ce matin', '2024-08-31 10:05:13'),
	(3, 6, 3, 'pour les croissants moi aussi', '2024-08-31 11:55:13'),
	(4, 1, 6, 'avoir pris mes appels téléphoniques pendant que je me concentrais', '2024-06-15 17:09:27'),
	(5, 1, 4, 'm\'avoir donné un bon coup de main !', '2024-09-24 14:24:35'),
	(6, 3, 2, 'sa bonne humeur', '2024-10-24 14:31:54'),
	(7, 5, 1, 'l\'inspiration qu\'elle m\'a apporté', '2024-07-05 15:07:36');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

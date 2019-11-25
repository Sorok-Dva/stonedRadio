-- --------------------------------------------------------
-- Hôte :                        allodssaobsite.mysql.db
-- Version du serveur:           5.5.43-0+deb7u1-log - (Debian)
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Export de la structure de table allodssaobsite. news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` varchar(50) DEFAULT NULL,
  `auteur` varchar(50) DEFAULT NULL,
  `contenu` text,
  `date` bigint(20) DEFAULT NULL,
  `administratif` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Export de données de la table allodssaobsite.news : ~0 rows (environ)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;


-- Export de la structure de table allodssaobsite. posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `is_share` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `titre` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `texte` text COLLATE utf8_unicode_ci NOT NULL,
  `formater` text COLLATE utf8_unicode_ci NOT NULL,
  `commentaires` int(11) NOT NULL,
  `jaime` int(11) NOT NULL,
  `share` int(11) NOT NULL,
  `vues` int(11) NOT NULL,
  `deleted` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;


-- Export de la structure de table allodssaobsite. tchat
CREATE TABLE IF NOT EXISTS `tchat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `message` mediumtext,
  `date` bigint(20) DEFAULT NULL,
  `prive` varchar(50) DEFAULT NULL,
  `reset` enum('Y','N') DEFAULT 'N',
  `type` enum('J','I','M','P') DEFAULT 'J',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `tchat` ENABLE KEYS */;


-- Export de la structure de table allodssaobsite. tchat_bans
CREATE TABLE IF NOT EXISTS `tchat_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `modo` varchar(50) DEFAULT NULL,
  `raison` varchar(50) DEFAULT NULL,
  `duree` bigint(20) DEFAULT NULL,
  `date` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `tchat_bans` ENABLE KEYS */;


-- Export de la structure de table allodssaobsite. tchat_kicks
CREATE TABLE IF NOT EXISTS `tchat_kicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) DEFAULT NULL,
  `modo` varchar(50) DEFAULT NULL,
  `date` bigint(20) DEFAULT NULL,
  `raison` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- Export de données de la table allodssaobsite.tchat_kicks : ~337 rows (environ)
/*!40000 ALTER TABLE `tchat_kicks` DISABLE KEYS */;



-- Export de la structure de table allodssaobsite. tchat_users
CREATE TABLE IF NOT EXISTS `tchat_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `last_msg` bigint(20) DEFAULT NULL,
  `mute` enum('Y','N') DEFAULT 'N',
  `ban` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


-- Export de la structure de table allodssaobsite. trophies
CREATE TABLE IF NOT EXISTS `trophies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('New','JDR','Help','Tuto','Share_JDR','STAFF') DEFAULT NULL,
  `desc` tinytext,
  `requireLvl1` int(11) DEFAULT NULL,
  `requireLvl2` int(11) DEFAULT NULL,
  `requireLvl3` int(11) DEFAULT NULL,
  `requireLvl4` int(11) DEFAULT NULL,
  `requireLvl5` int(11) DEFAULT NULL,
  `TitreLvl1` varchar(50) DEFAULT NULL,
  `TitreLvl2` varchar(50) DEFAULT NULL,
  `TitreLvl3` varchar(50) DEFAULT NULL,
  `TitreLvl4` varchar(50) DEFAULT NULL,
  `TitreLvl5` varchar(50) DEFAULT NULL,
  `isInfinite` enum('Y','N') DEFAULT NULL,
  `css` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Export de données de la table allodssaobsite.trophies : ~4 rows (environ)
/*!40000 ALTER TABLE `trophies` DISABLE KEYS */;
INSERT INTO `trophies` (`id`, `type`, `desc`, `requireLvl1`, `requireLvl2`, `requireLvl3`, `requireLvl4`, `requireLvl5`, `TitreLvl1`, `TitreLvl2`, `TitreLvl3`, `TitreLvl4`, `TitreLvl5`, `isInfinite`, `css`) VALUES
	(1, 'New', 'a rejoins la communauté', NULL, NULL, NULL, NULL, NULL, 'Nouvel auditeur', NULL, NULL, NULL, NULL, 'Y', 'trophiesNewMember'),
	(2, 'STAFF', 'est membre de l\\\'équipe du site', NULL, NULL, NULL, NULL, NULL, 'Membre du Staff', NULL, NULL, NULL, NULL, 'Y', 'trophiesEquipeSite');
/*!40000 ALTER TABLE `trophies` ENABLE KEYS */;


-- Export de la structure de table allodssaobsite. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `pseudo` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `sexe` enum('H','F') DEFAULT NULL,
  `avatar` varchar(50) DEFAULT '/app/user_folder/default/avatar/default.png',
  `grade` enum('Ban','Mem','VIP','Mod','Adm') DEFAULT 'Mem',
  `points` int(11) NOT NULL DEFAULT '0',
  `register_ip` varchar(25) DEFAULT NULL,
  `date_inscription` bigint(21) DEFAULT NULL,
  `valider` enum('Y','N') DEFAULT 'N',
  `deleted` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- Export de données de la table allodssaobsite.users : ~24 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `user_id`, `pseudo`, `password`, `mail`, `sexe`, `avatar`, `grade`, `points`, `register_ip`, `date_inscription`, `valider`, `deleted`) VALUES
	(1, '55cb4e0a3d12b', 'Liightman', '$2y$07$wqazsxcedfrvbtghynujke6jBqwrN4rkZ8HaBenTUk2RLZQRS4ar2', 'garutor@gmail.com', 'H', '55cb4e0a3d12b/avatar/avatar55cd12db57f02.png', 'Adm', 3480, '::1', NULL, '', 'N');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Export de la structure de table allodssaobsite. users_exploits
CREATE TABLE IF NOT EXISTS `users_exploits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(50) DEFAULT NULL,
  `actual` int(11) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `type` enum('New','Help','STAFF') DEFAULT NULL,
  `lvl` enum('Infini','1','2','3','4','5') DEFAULT NULL,
  `date1` bigint(20) DEFAULT NULL,
  `date2` bigint(20) DEFAULT NULL,
  `date3` bigint(20) DEFAULT NULL,
  `date4` bigint(20) DEFAULT NULL,
  `date5` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `users_exploits` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

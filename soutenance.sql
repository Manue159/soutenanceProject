-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 22 juil. 2023 à 09:47
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soutenance`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220304143338', '2022-03-04 14:34:51', 7268),
('DoctrineMigrations\\Version20220407075304', '2022-04-07 07:53:49', 1927),
('DoctrineMigrations\\Version20220422164454', '2022-04-22 16:46:16', 4570),
('DoctrineMigrations\\Version20220426132938', '2022-04-26 13:30:11', 6568);

-- --------------------------------------------------------

--
-- Structure de la table `emplacements_materiels`
--

DROP TABLE IF EXISTS `emplacements_materiels`;
CREATE TABLE IF NOT EXISTS `emplacements_materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `emplacements_materiels`
--

INSERT INTO `emplacements_materiels` (`id`, `libelle`, `date_creation`, `is_delete`) VALUES
(1, 'Comptabilité', '2022-04-25 10:03:41', 0),
(2, 'Technique', '2022-04-26 08:18:09', 0);

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

DROP TABLE IF EXISTS `employes`;
CREATE TABLE IF NOT EXISTS `employes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paswword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `is_technicien` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id`, `nom`, `prenom`, `email`, `paswword`, `pole`, `statut`, `token`, `date_creation`, `is_delete`, `is_admin`, `is_technicien`) VALUES
(1, 'Bolade', 'Benjamin', 'benito@gmail.com', '$2y$10$uS0ArKQLQSQJPkWUVHUSLezRZAyVzisPfWyAQ6qazVv.2XU8PF0LC', 'Infogérance', 'Disponible', 'KUyKWZBQj7', '2022-03-10 08:37:48', 0, 0, 0),
(2, 'Padawan', 'Jaune', 'padawan@gmail.com', '$2y$10$VV3Aak6JJoIGCMDNRAO3o.tSSbMKXLDOk/rXZxL/sHTsMDjn8fwx.', 'Utilisateur', 'Disponible', 'zLF6CDKKqJ', '2022-04-08 14:08:46', 0, 0, 1),
(3, 'Dibingo', 'Manue', 'dibingo@gmail.com', '$2y$10$lIUmSNEHWSpZt4.OVZ1UEerTVFArC8nJDK95Dy2672F0TREVJHb0i', 'Professionnal Services Manager', 'Disponible', 'xUBr3dtq8V', '2022-04-08 14:12:44', 0, 1, 1),
(4, 'Gnassounou', 'Jerry', 'gnassounoujerry@gmail.com', '', 'Infrastructure Informatique et Software', 'Disponible', 'Z3fLULsbK2', '2022-04-22 08:31:49', 0, 0, 1),
(5, 'Gnassounou', 'Jerry', 'gnassourry@gmail.com', '', 'Controleur de gestion', 'Disponible', 'bSQjehm18A', '2022-04-22 10:10:28', 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `employes_pannes`
--

DROP TABLE IF EXISTS `employes_pannes`;
CREATE TABLE IF NOT EXISTS `employes_pannes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employes_id` int(11) NOT NULL,
  `pannes_id` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C561D7D8F971F91F` (`employes_id`),
  KEY `IDX_C561D7D852C4C5A1` (`pannes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employes_pannes`
--

INSERT INTO `employes_pannes` (`id`, `employes_id`, `pannes_id`, `date_creation`, `is_delete`) VALUES
(1, 2, 1, '2022-04-27 10:41:08', 0),
(2, 3, 2, '2022-04-27 10:51:42', 0),
(3, 1, 3, '2022-04-27 10:51:42', 0),
(4, 4, 4, '2022-02-17 10:10:02', 0),
(5, 5, 5, '2022-03-03 14:49:31', 0);

-- --------------------------------------------------------

--
-- Structure de la table `materiels`
--

DROP TABLE IF EXISTS `materiels`;
CREATE TABLE IF NOT EXISTS `materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_serie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `type_id` int(11) NOT NULL,
  `emplacement_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9C1EBE69C54C8C93` (`type_id`),
  KEY `IDX_9C1EBE69C4598A51` (`emplacement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `materiels`
--

INSERT INTO `materiels` (`id`, `numero_serie`, `date_creation`, `is_delete`, `type_id`, `emplacement_id`) VALUES
(1, '12NB2541HQ17', '2022-04-26 07:20:43', 0, 4, 1),
(2, '15HF1205GG152', '2022-04-26 08:17:29', 0, 3, 1),
(3, '35HHF875DF0086', '2022-04-26 08:19:06', 0, 2, 2),
(4, '0784HG7964R5K', '2022-04-26 08:19:33', 0, 1, 2),
(5, '05KH735468DT086', '2022-04-26 08:20:15', 0, 1, 2),
(6, '54DHIKDF46883', '2022-04-26 08:44:13', 1, 3, 1),
(7, '34RT6747IJJ898', '2022-04-27 10:04:16', 0, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `pannes`
--

DROP TABLE IF EXISTS `pannes`;
CREATE TABLE IF NOT EXISTS `pannes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `materiel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_56842BE116880AAF` (`materiel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pannes`
--

INSERT INTO `pannes` (`id`, `type`, `description`, `etat`, `date_creation`, `is_delete`, `materiel_id`) VALUES
(1, 'Logicielle', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto id autem, deleniti iure doloribus necessitatibus quibusdam culpa delectus doloremque tenetur, ratione itaque ex fuga laudantium consequuntur eum asperiores! Est, reiciendis.', 'réparée', '2022-04-27 10:36:04', 0, 1),
(2, 'Logicielle', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto id autem, deleniti iure doloribus necessitatibus quibusdam culpa delectus doloremque tenetur, ratione itaque ex fuga laudantium consequuntur eum asperiores! Est, reiciendis.', 'non réparée', '2022-04-27 10:47:18', 0, 4),
(3, 'Materielle', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto id autem, deleniti iure doloribus necessitatibus quibusdam culpa delectus doloremque tenetur, ratione itaque ex fuga laudantium consequuntur eum asperiores! Est, reiciendis.', 'réparée', '2022-04-25 10:47:18', 0, 2),
(4, 'Materielle', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto id autem, deleniti iure doloribus necessitatibus quibusdam culpa delectus doloremque tenetur, ratione itaque ex fuga laudantium consequuntur eum asperiores! Est, reiciendis.', 'non réparée', '2022-04-15 10:49:05', 0, 6),
(5, 'Logicielle', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto id autem, deleniti iure doloribus necessitatibus quibusdam culpa delectus doloremque tenetur, ratione itaque ex fuga laudantium consequuntur eum asperiores! Est, reiciendis.', 'réparée', '2022-04-27 10:49:05', 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `types_materiels`
--

DROP TABLE IF EXISTS `types_materiels`;
CREATE TABLE IF NOT EXISTS `types_materiels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `types_materiels`
--

INSERT INTO `types_materiels` (`id`, `libelle`, `date_creation`, `is_delete`) VALUES
(1, 'ordinateur portable', '2022-04-25 10:04:23', 0),
(2, 'ordinateur de bureau', '2022-04-25 10:04:40', 0),
(3, 'imprimante', '2022-04-25 10:05:06', 0),
(4, 'copieur', '2022-04-25 10:05:20', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `employes_pannes`
--
ALTER TABLE `employes_pannes`
  ADD CONSTRAINT `FK_C561D7D852C4C5A1` FOREIGN KEY (`pannes_id`) REFERENCES `pannes` (`id`),
  ADD CONSTRAINT `FK_C561D7D8F971F91F` FOREIGN KEY (`employes_id`) REFERENCES `employes` (`id`);

--
-- Contraintes pour la table `materiels`
--
ALTER TABLE `materiels`
  ADD CONSTRAINT `FK_9C1EBE69C4598A51` FOREIGN KEY (`emplacement_id`) REFERENCES `emplacements_materiels` (`id`),
  ADD CONSTRAINT `FK_9C1EBE69C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `types_materiels` (`id`);

--
-- Contraintes pour la table `pannes`
--
ALTER TABLE `pannes`
  ADD CONSTRAINT `FK_56842BE116880AAF` FOREIGN KEY (`materiel_id`) REFERENCES `materiels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

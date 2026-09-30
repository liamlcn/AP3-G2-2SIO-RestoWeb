-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 30 sep. 2026 à 14:50
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `apresto`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `idCOM` bigint(20) NOT NULL,
  `etatCOM` varchar(30) DEFAULT NULL,
  `date_horaireCOM` datetime DEFAULT NULL,
  `valeurTTC` decimal(13,3) DEFAULT NULL,
  `typeCOM` varchar(50) DEFAULT NULL,
  `TVA` tinyint(3) UNSIGNED DEFAULT NULL,
  `idUTIL` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`idCOM`, `etatCOM`, `date_horaireCOM`, `valeurTTC`, `typeCOM`, `TVA`, `idUTIL`) VALUES
(2, 'en_attente', '2026-09-30 12:42:29', 176.000, 'Manger sur place', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_de_commande`
--

CREATE TABLE `ligne_de_commande` (
  `idLIGNCOM` bigint(20) NOT NULL,
  `quantiteProduit` int(11) DEFAULT NULL,
  `totalHT` decimal(13,3) DEFAULT NULL,
  `idCOM` bigint(20) NOT NULL,
  `idPROD` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ligne_de_commande`
--

INSERT INTO `ligne_de_commande` (`idLIGNCOM`, `quantiteProduit`, `totalHT`, `idCOM`, `idPROD`) VALUES
(1, 8, 160.000, 2, 7);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idPROD` bigint(20) NOT NULL,
  `libellePROD` varchar(100) DEFAULT NULL,
  `prixHT` decimal(13,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idPROD`, `libellePROD`, `prixHT`) VALUES
(1, 'Pizza 5 fromages', 13.000),
(2, 'Tacos 3 viandes', 11.000),
(3, 'Poulet roti (2kg)', 20.000),
(4, 'Nouiles sautées', 10.000),
(5, 'Sachet de frites', 6.000),
(6, 'Salade César', 10.000),
(7, 'Magret de canard', 20.000),
(8, 'Foie gras (pot)', 8.000),
(9, 'Coeurs de canards (0,5kg)', 7.000),
(10, 'Pizza Margerita', 10.000),
(11, 'Eau plate (bouteille 33cl)', 4.000),
(12, 'Coca Cola (canette 33cl)', 4.000),
(13, 'Perrier (bouteille 0,5L)', 5.000);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUTIL` bigint(20) NOT NULL,
  `emailUtil` varchar(100) DEFAULT NULL,
  `loginUtil` varchar(100) DEFAULT NULL,
  `mdpUtil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUTIL`, `emailUtil`, `loginUtil`, `mdpUtil`) VALUES
(1, 'test.test@test.test', 'test test', '$2y$10$ENyMAlql1ixrosKtA8bVLuIx7gcAPT9cgXqV48jOT628.BsPONbRK');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idCOM`),
  ADD KEY `idUTIL` (`idUTIL`);

--
-- Index pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  ADD PRIMARY KEY (`idLIGNCOM`),
  ADD KEY `idCOM` (`idCOM`),
  ADD KEY `idPROD` (`idPROD`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idPROD`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUTIL`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `idCOM` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  MODIFY `idLIGNCOM` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idPROD` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUTIL` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`idUTIL`) REFERENCES `utilisateur` (`idUTIL`);

--
-- Contraintes pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  ADD CONSTRAINT `ligne_de_commande_ibfk_1` FOREIGN KEY (`idCOM`) REFERENCES `commande` (`idCOM`),
  ADD CONSTRAINT `ligne_de_commande_ibfk_2` FOREIGN KEY (`idPROD`) REFERENCES `produit` (`idPROD`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

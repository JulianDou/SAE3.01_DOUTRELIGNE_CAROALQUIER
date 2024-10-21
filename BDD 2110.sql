-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 21 oct. 2024 à 09:18
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `caroalquier1`
--

-- --------------------------------------------------------

--
-- Structure de la table `Admins`
--

CREATE TABLE `Admins` (
  `id_admins` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Categories`
--

CREATE TABLE `Categories` (
  `id_categories` int(11) NOT NULL,
  `nom_categories` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Categories`
--

INSERT INTO `Categories` (`id_categories`, `nom_categories`, `icone`, `image`) VALUES
(1, 'Manettes', 'manettes.svg', 'manettes.jpg'),
(2, 'Consoles', 'consoles.svg', 'consoles.webp'),
(3, 'Jeux-vidéo', 'jeux-video.svg', 'jeux-video.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `Clients`
--

CREATE TABLE `Clients` (
  `id_clients` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Clients`
--

INSERT INTO `Clients` (`id_clients`, `email`, `mot_de_passe`, `nom`) VALUES
(1, 'julian.dou@gmail.com', 'micromania2024', 'Julian');

-- --------------------------------------------------------

--
-- Structure de la table `Clients_Produits`
--

CREATE TABLE `Clients_Produits` (
  `id_clients` int(11) NOT NULL,
  `id_produits` int(11) NOT NULL,
  `quantite` smallint(6) NOT NULL,
  `id_options` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Clients_Produits`
--

INSERT INTO `Clients_Produits` (`id_clients`, `id_produits`, `quantite`, `id_options`) VALUES
(1, 5, 2, 7),
(1, 6, 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `Commandes`
--

CREATE TABLE `Commandes` (
  `id_commandes` int(11) NOT NULL,
  `statut` enum('en_cours','disponible','annulee','retiree') NOT NULL,
  `date_commande` datetime NOT NULL,
  `id_clients` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Commandes_Produits`
--

CREATE TABLE `Commandes_Produits` (
  `id_produits` int(11) NOT NULL,
  `id_commandes` int(11) NOT NULL,
  `quantite` smallint(6) NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Options`
--

CREATE TABLE `Options` (
  `id_options` int(11) NOT NULL,
  `nom_court` varchar(30) DEFAULT NULL,
  `type` enum('Plateforme','Couleur','Edition') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Options`
--

INSERT INTO `Options` (`id_options`, `nom_court`, `type`) VALUES
(5, 'Rouge', 'Couleur'),
(6, 'Bleue', 'Couleur'),
(7, 'Xbox', 'Plateforme'),
(8, 'Switch', 'Plateforme'),
(9, 'Standard', 'Edition'),
(10, 'Pro', 'Edition'),
(11, 'Lite', 'Edition');

-- --------------------------------------------------------

--
-- Structure de la table `Produits`
--

CREATE TABLE `Produits` (
  `id_produits` int(11) NOT NULL,
  `id_categories` int(11) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `revendeur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Produits`
--

INSERT INTO `Produits` (`id_produits`, `id_categories`, `nom`, `description`, `revendeur`) VALUES
(3, 1, 'Manette de Xbox', 'Ceci est une manette de xbox classque ', 'Microsoft'),
(4, 1, 'Manette de switch', 'Une manette pour la console de nintendo qu\'est la nintendo switch une console hybride car elle est portable et fixe ce qui est dingue quand on y pense.', 'Nintendo'),
(5, 3, 'Minecraft', 'Un jue de cube classique', 'Microsoft'),
(6, 2, 'Nintendo Switch', 'Une console hybride incroyable', 'Nintendo'),
(7, 2, 'PS5', 'Une console objectivement mieux que la PS4.', 'Sony');

-- --------------------------------------------------------

--
-- Structure de la table `Produits_Options`
--

CREATE TABLE `Produits_Options` (
  `id_produits` int(11) NOT NULL,
  `id_options` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Produits_Options`
--

INSERT INTO `Produits_Options` (`id_produits`, `id_options`, `prix`, `stock`, `image`) VALUES
(3, 5, '61.99', 8, 'manette-microsoft-rouge.jpg'),
(3, 6, '59.99', 6, 'manette-microsoft-bleue.jpg'),
(4, 5, '69.99', 9, 'manette-nintendo-rouge.jpg'),
(4, 6, '65.99', 15, 'manette-nintendo-bleue.jpg'),
(5, 7, '19.99', 22, 'minecraft-xbox.jpg'),
(5, 8, '29.99', 15, 'minecraft-switch.jpg'),
(6, 9, '299.99', 12, 'switch-standard.jpg'),
(6, 11, '179.99', 12, 'switch-lite.jpg'),
(7, 9, '499.99', 6, 'ps5-standard.jpg'),
(7, 10, '799.99', 9, 'ps5-pro.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id_admins`);

--
-- Index pour la table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id_categories`);

--
-- Index pour la table `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`id_clients`);

--
-- Index pour la table `Clients_Produits`
--
ALTER TABLE `Clients_Produits`
  ADD PRIMARY KEY (`id_clients`,`id_produits`),
  ADD KEY `id_produits` (`id_produits`),
  ADD KEY `Clients_Produits_ibfk_3` (`id_options`);

--
-- Index pour la table `Commandes`
--
ALTER TABLE `Commandes`
  ADD PRIMARY KEY (`id_commandes`),
  ADD KEY `id_clients` (`id_clients`);

--
-- Index pour la table `Commandes_Produits`
--
ALTER TABLE `Commandes_Produits`
  ADD PRIMARY KEY (`id_produits`,`id_commandes`),
  ADD KEY `id_commandes` (`id_commandes`);

--
-- Index pour la table `Options`
--
ALTER TABLE `Options`
  ADD PRIMARY KEY (`id_options`);

--
-- Index pour la table `Produits`
--
ALTER TABLE `Produits`
  ADD PRIMARY KEY (`id_produits`),
  ADD KEY `id_categories` (`id_categories`);

--
-- Index pour la table `Produits_Options`
--
ALTER TABLE `Produits_Options`
  ADD PRIMARY KEY (`id_produits`,`id_options`),
  ADD KEY `id_options` (`id_options`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id_admins` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id_categories` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Clients`
--
ALTER TABLE `Clients`
  MODIFY `id_clients` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Commandes`
--
ALTER TABLE `Commandes`
  MODIFY `id_commandes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Options`
--
ALTER TABLE `Options`
  MODIFY `id_options` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `Produits`
--
ALTER TABLE `Produits`
  MODIFY `id_produits` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Clients_Produits`
--
ALTER TABLE `Clients_Produits`
  ADD CONSTRAINT `Clients_Produits_ibfk_1` FOREIGN KEY (`id_clients`) REFERENCES `Clients` (`id_clients`) ON DELETE CASCADE,
  ADD CONSTRAINT `Clients_Produits_ibfk_2` FOREIGN KEY (`id_produits`) REFERENCES `Produits` (`id_produits`) ON DELETE CASCADE,
  ADD CONSTRAINT `Clients_Produits_ibfk_3` FOREIGN KEY (`id_options`) REFERENCES `Options` (`id_options`);

--
-- Contraintes pour la table `Commandes`
--
ALTER TABLE `Commandes`
  ADD CONSTRAINT `Commandes_ibfk_1` FOREIGN KEY (`id_clients`) REFERENCES `Clients` (`id_clients`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Commandes_Produits`
--
ALTER TABLE `Commandes_Produits`
  ADD CONSTRAINT `Commandes_Produits_ibfk_1` FOREIGN KEY (`id_produits`) REFERENCES `Produits` (`id_produits`) ON DELETE CASCADE,
  ADD CONSTRAINT `Commandes_Produits_ibfk_2` FOREIGN KEY (`id_commandes`) REFERENCES `Commandes` (`id_commandes`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Produits`
--
ALTER TABLE `Produits`
  ADD CONSTRAINT `Produits_ibfk_1` FOREIGN KEY (`id_categories`) REFERENCES `Categories` (`id_categories`) ON DELETE SET NULL;

--
-- Contraintes pour la table `Produits_Options`
--
ALTER TABLE `Produits_Options`
  ADD CONSTRAINT `Produits_Options_ibfk_1` FOREIGN KEY (`id_produits`) REFERENCES `Produits` (`id_produits`) ON DELETE CASCADE,
  ADD CONSTRAINT `Produits_Options_ibfk_2` FOREIGN KEY (`id_options`) REFERENCES `Options` (`id_options`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

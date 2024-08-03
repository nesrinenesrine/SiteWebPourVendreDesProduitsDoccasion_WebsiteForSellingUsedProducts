-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3307
-- Généré le : mar. 24 mai 2022 à 22:21
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_pweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`) VALUES
(1, 'Voiture'),
(2, 'Telephone'),
(3, 'PC'),
(4, 'Pièces détachée'),
(5, 'Electroménager'),
(6, 'Divers');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nom_produit` varchar(50) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `prix_produit` float NOT NULL,
  `etat_produit` varchar(10) NOT NULL,
  `discription` varchar(250) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `date_de_publication` date DEFAULT NULL,
  `etat` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_user`, `nom_produit`, `id_categorie`, `prix_produit`, `etat_produit`, `discription`, `photo`, `date_de_publication`, `etat`) VALUES
(14, 1, 'piece detacher', 4, 12000, 'neuf', 'une piece detacher ', '14.jfif', '2022-05-24', 0),
(15, 1, 'cousinière', 5, 12000, 'abime', 'une cuisini', '15.jfif', '2022-05-24', 0),
(16, 17, 'piece detacher', 4, 7000, 'neuf', 'une piece detache  ', '16.jfif', '2022-05-24', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `user_name`, `mdp`, `email`, `tel`) VALUES
(1, 'Ait said', 'nesrine', 'nesrine as', '$2y$10$BT8bv7rSGeZeRuNj99ik1.0aTq.Byl7VMhJARC9MdXMT.F1NoBCVy', 'aitsaidnesrine19@gmail.com', '0797571099'),
(17, 'latoula', 'kenza', 'kensa as', '$2y$10$r6N80Q2Z..FGO/m/XAywnufC94.LYt3gzSYc43icQvq/ivwmjFzHC', 'kensaas@gmail.com', '0666775751');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

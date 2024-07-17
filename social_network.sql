-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: social_network
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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

DROP DATABASE IF EXISTS `social_network`;
CREATE DATABASE IF NOT EXISTS `social_network` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `social_network`;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tweets` (
  `username` varchar(50) NOT NULL,
  `data` datetime NOT NULL,
  `testo` text NOT NULL,
  KEY `username` (`username`),
  CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utenti` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES ('mrossi','2024-05-30 10:15:00','Questo è il mio primo tweet!'),('abianchi','2024-05-30 11:00:00','Ciao a tutti! Questo è il mio tweet di benvenuto!'),('robv','2024-05-30 12:30:00','Ciao, sono Roberto!'),('robv','2024-05-31 08:45:00','Buongiorno a tutti!'),('abianchi','2024-05-31 09:20:00','Oggi è una bella giornata!');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utenti` (
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `indirizzo` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  PRIMARY KEY (`username`),
  CONSTRAINT `indirizzo_check` CHECK (((`indirizzo` like _utf8mb4'Via %') or (`indirizzo` like _utf8mb4'Corso %') or (`indirizzo` like _utf8mb4'Largo %') or (`indirizzo` like _utf8mb4'Piazza %') or (`indirizzo` like _utf8mb4'Vicolo %')))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utenti`
--

LOCK TABLES `utenti` WRITE;
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` VALUES ('Anna','Bianchi','1990-12-20','Corso Italia 25','abianchi','Mar1@+Car1@'),('Mario','Rossi','1985-06-15','Via Roma 10','mrossi','RedRob8#8#8'),('Roberto','Verdi','1992-07-08','Piazza del Popolo 3','robv','S1@cc@99');
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

-- Permessi DB user: normale; pwd: 'posso_leggere?' (solo SELECT)

GRANT USAGE ON `social_network`.* TO 'normale'@'%' IDENTIFIED BY PASSWORD '*BB4DF10CAFBE8E060CB11B1BAEA48369CEDCAF6C';
GRANT SELECT ON `social_network`.* TO 'normale'@'%';


--
-- Permessi DB user: privilegiato; pwd: 'SuperPippo!!!'' (solo SELECT, INSERT, UPDATE)
--

GRANT USAGE ON `social_network`.* TO 'privilegiato'@'%' IDENTIFIED BY PASSWORD '*400BF58DFE90766AF20296B3D89A670FC66BEAEC';
GRANT SELECT, INSERT, UPDATE ON `social_network`.* TO 'privilegiato'@'%';



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-30 18:31:37

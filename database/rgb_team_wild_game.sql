-- MySQL dump 10.13  Distrib 8.0.25, for Linux (x86_64)
--
-- Host: localhost    Database: rgb_team_wild
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date_release` date DEFAULT NULL,
  `description` longtext,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=armscii8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (17,'Tom Clancy\'s Rainbow Six siege',NULL,'Tom Clancy\'s Rainbow Six Siege is the latest installment of the acclaimed first person shooter franchise developed by the renowned Ubisoft Montreal Studio','rainbow_six.jpg'),(18,'Counter-Strike: Global Offensive',NULL,'Counter-Strike: Global Offensive (CS: GO) expands upon the team-based action gameplay that it pioneered when it was launched 19 years ago. CS: GO features new maps, characters, weapons, and game modes, and delivers updated versions of the classic CS content (de_dust2, etc.). ','counter_strike.jpg'),(19,'Terraria',NULL,'Dig, fight, explore, build! Nothing is impossible in this action-packed adventure game. Four Pack also available! ','terraria.jpg'),(20,'Batman: Arkham Asylum',NULL,'Experience what it\'s like to be Batman and face off against Gotham\'s greatest villians. Explore every inch of Arkham Asylum and roam freely on the infamous island. ','batman harkam.jpg'),(21,'Arma 3',NULL,'Experience true combat gameplay in a massive military sandbox. Deploying a wide variety of single- and multiplayer content, over 20 vehicles and 40 weapons, and limitless opportunities for content creation, this is the PC\'s premier military game. Authentic, diverse, open - Arma 3 sends you to war.','arma_3.jpg'),(22,'Forza Horizon 4',NULL,'Dynamic seasons change everything at the world\'s greatest automotive festival. Go it alone or team up with others to explore beautiful and historic Britain in a shared open world. ','forza5.jpg'),(23,'Age of Empires II (2013)',NULL,'Age of Empires II has been re-imagined in high definition with new features, trading cards, improved AI, workshop support, multiplayer, Steamworks integration and more! ','age_of_empire_II.jpg'),(24,'FINAL FANTASY XIV Online',NULL,'Take part in an epic and ever-changing FINAL FANTASY as you adventure and explore with friends from around the world.','final_fantasy.jpg'),(25,'Portal 2',NULL,'The \"Perpetual Testing Initiative\" has been expanded to allow you to design co-op puzzles for you and your friends! ','portal2.jpg'),(26,'Grand Theft Auto V',NULL,'Grand Theft Auto V for PC offers players the option to explore the award-winning world of Los Santos and Blaine County in resolutions of up to 4k and beyond, as well as the chance to experience the game running at 60 frames per second. ','GTA_V.jpg');
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-03 14:51:40

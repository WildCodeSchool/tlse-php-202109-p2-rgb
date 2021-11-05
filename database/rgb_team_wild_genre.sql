-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: rgb_team_wild
-- ------------------------------------------------------
-- Server version	8.0.26-0ubuntu0.20.04.3

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
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,'action','https://s1.gaming-cdn.com/images/products/9459/271x377/counter-strike-global-offensive-pc-mac-jeu-steam-cover.jpg'),(2,'aventure','https://www.actugaming.net/wp-content/uploads/2020/01/the-witcher-3-889x500.jpg'),(3,'simulation','https://www.actugaming.net/wp-content/uploads/2016/09/Sid-Meier%E2%80%99s-Civilization-VI-1-889x500.jpg'),(4,'strategie','https://h3v2h5f6.rocketcdn.me/wp-content/uploads/2021/11/age-of-empires-iv.jpg'),(5,'RPG','https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/clans/26064318/1796767b1dc2dbac4ad22851dd38391ef5c30d6a.jpg'),(6,'sport_course','https://staticg.sportskeeda.com/editor/2021/09/f76c2-16327488598899-800.jpg'),(7,'FPS','https://media.contentapi.ea.com/content/dam/apex-legends/common/articles/apex-mobile-regional-beta/apex-mobile-art-featured-image.jpg.adapt.1456w.jpg'),(8,'shooter','https://image.jeuxvideo.com/medias-sm/163129/1631287693-8700-jaquette-avant.jpg'),(9,'multiplayer','https://www.pedagojeux.fr/wp-content/uploads/2019/11/1280x720_LoL.jpg'),(10,'competitive','https://xboxplay.games/imagenes/redimensionar2.php?imagen=https://xboxplay.games/uploadStream/835.jpg&an=722&al=400'),(11,'open world','https://cdn03.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_4/H2x1_NSwitch_TheElderScrollsVSkyrim_image1600w.jpg'),(12,'sandbox','https://cdn03.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_4/H2x1_NSwitch_Minecraft_image1600w.jpg'),(13,'2D','https://upload.wikimedia.org/wikipedia/fr/3/3d/Street_Fighter_II_The_World_Warrior_Logo.png'),(14,'superhero','https://i0.wp.com/www.2pjeuxvideo.com/wp-content/uploads/2020/11/Critique-Spiderman-Miles-Morales.jpg?resize=1536%2C864&ssl=1'),(15,'dark','https://s2.gaming-cdn.com/images/products/8686/271x377/resident-evil-village-xbox-one-xbox-series-xs-cover.jpg'),(16,'third person','https://psverso.com.br/wp-content/uploads/2021/06/god-of-war-ragnarok-state-of-play-em-breve-768x433.jpg'),(17,'military','https://cdn.cloudflare.steamstatic.com/steam/apps/107410/header.jpg?t=1635346728'),(18,'racing','https://www.lesuricate.org/wp-content/uploads/2018/02/mario-kart-8-deluxe-678x381.jpg'),(19,'medieval','https://gepig.com/game_cover_460w/6325.jpg'),(20,'classic','https://m.media-amazon.com/images/I/71OWWCZNouL._AC_SL1000_.jpg'),(21,'MMORPG','https://www.dlcompare.fr/upload/gameimage/file/a4ca-world_of_warcraft:_shadowlands.jpeg'),(22,'fantasy','https://fr.shopping.rakuten.com/photo/876801161.jpg'),(23,'plateformer puzzle','https://cdn03.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_download_software_1/H2x1_NSwitchDS_CastlevaniaAdvanceCollection_image1600w.jpg'),(24,'tactical','https://cdn.cloudflare.steamstatic.com/steam/apps/1407200/header.jpg?t=1635837965');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-02 13:28:14

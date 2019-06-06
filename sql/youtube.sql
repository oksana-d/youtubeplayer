-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.20 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных youtube
CREATE DATABASE IF NOT EXISTS `youtube` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `youtube`;

-- Дамп структуры для таблица youtube.like
CREATE TABLE IF NOT EXISTS `like` (
  `idLike` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(11) unsigned NOT NULL,
  `idVideo` varchar(50) NOT NULL,
  PRIMARY KEY (`idLike`),
  KEY `user` (`idUser`),
  KEY `idVideo` (`idVideo`),
  CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idVideo` FOREIGN KEY (`idVideo`) REFERENCES `video` (`idVideo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы youtube.like: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
/*!40000 ALTER TABLE `like` ENABLE KEYS */;

-- Дамп структуры для таблица youtube.page
CREATE TABLE IF NOT EXISTS `page` (
  `idPage` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nextPageToken` varchar(50) DEFAULT NULL,
  `prevPageToken` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idPage`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы youtube.page: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` (`idPage`, `nextPageToken`, `prevPageToken`) VALUES
	(1, 'CDAQAA', NULL);
/*!40000 ALTER TABLE `page` ENABLE KEYS */;

-- Дамп структуры для таблица youtube.query
CREATE TABLE IF NOT EXISTS `query` (
  `idQuery` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `queryText` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idQuery`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы youtube.query: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `query` DISABLE KEYS */;
/*!40000 ALTER TABLE `query` ENABLE KEYS */;

-- Дамп структуры для таблица youtube.user
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы youtube.user: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`idUser`, `firstname`, `lastname`, `email`, `password`) VALUES
	(1, 'Оксана', 'Егорова', 'oksana.yegorova99@gmail.com', 'oksana19');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Дамп структуры для таблица youtube.video
CREATE TABLE IF NOT EXISTS `video` (
  `idVideo` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `preview` text NOT NULL,
  `publishedAt` varchar(50) NOT NULL,
  PRIMARY KEY (`idVideo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы youtube.video: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
/*!40000 ALTER TABLE `video` ENABLE KEYS */;

-- Дамп структуры для таблица youtube.videoQuery
CREATE TABLE IF NOT EXISTS `videoQuery` (
  `idVideoQuery` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `query` int(11) unsigned NOT NULL,
  `video` varchar(50) NOT NULL,
  `page` int(11) unsigned NOT NULL,
  PRIMARY KEY (`idVideoQuery`),
  KEY `query` (`query`),
  KEY `page` (`page`),
  KEY `video` (`video`),
  CONSTRAINT `page` FOREIGN KEY (`page`) REFERENCES `page` (`idPage`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `query` FOREIGN KEY (`query`) REFERENCES `query` (`idQuery`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `video` FOREIGN KEY (`video`) REFERENCES `video` (`idVideo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы youtube.videoQuery: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `videoQuery` DISABLE KEYS */;
/*!40000 ALTER TABLE `videoQuery` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

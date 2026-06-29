-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para playscore
CREATE DATABASE IF NOT EXISTS `playscore` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `playscore`;

-- A despejar estrutura para tabela playscore.avaliacoes
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `id_jogo` int NOT NULL,
  `classificacao` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_utilizador` (`id_utilizador`,`id_jogo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.comentarios
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id_comentario` int NOT NULL AUTO_INCREMENT,
  `comentario` text NOT NULL,
  `id_utilizador` int NOT NULL,
  `id_jogo` int NOT NULL,
  `data_comentario` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comentario`),
  KEY `fk_comentarios_users` (`id_utilizador`),
  KEY `fk_comentarios_jogos` (`id_jogo`),
  CONSTRAINT `fk_comentarios_jogos` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`) ON DELETE CASCADE,
  CONSTRAINT `fk_comentarios_users` FOREIGN KEY (`id_utilizador`) REFERENCES `users` (`id_utilizador`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.contactos
CREATE TABLE IF NOT EXISTS `contactos` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mensagem` text,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.favoritos
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_favorito` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int DEFAULT NULL,
  `id_jogo` int DEFAULT NULL,
  `capa_url` text,
  `id_genero` int DEFAULT NULL,
  `data_adicao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_favorito`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `id_jogo` (`id_jogo`),
  KEY `id_genero` (`id_genero`),
  CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `users` (`id_utilizador`),
  CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`),
  CONSTRAINT `favoritos_ibfk_3` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.franquias
CREATE TABLE IF NOT EXISTS `franquias` (
  `id_franquia` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `capa_url` text,
  PRIMARY KEY (`id_franquia`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.generos
CREATE TABLE IF NOT EXISTS `generos` (
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.jogos
CREATE TABLE IF NOT EXISTS `jogos` (
  `id_jogo` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `desenvolvedor` varchar(150) NOT NULL,
  `editor` varchar(150) NOT NULL,
  `descricao` text,
  `data_lancamento` date DEFAULT NULL,
  `capa_url` text,
  `trailer_url` text,
  `plataforma` text,
  `classificacao` float DEFAULT NULL,
  `id_genero` int DEFAULT NULL,
  `id_franquia` int DEFAULT NULL,
  `num_votos` int DEFAULT '0',
  `soma_classificacao` float DEFAULT '0',
  PRIMARY KEY (`id_jogo`),
  KEY `id_genero` (`id_genero`),
  KEY `id_franquia` (`id_franquia`),
  CONSTRAINT `jogos_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`),
  CONSTRAINT `jogos_ibfk_3` FOREIGN KEY (`id_franquia`) REFERENCES `franquias` (`id_franquia`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.jogo_do_ano
CREATE TABLE IF NOT EXISTS `jogo_do_ano` (
  `id_jogo_ano` int NOT NULL AUTO_INCREMENT,
  `id_jogo` int DEFAULT NULL,
  `ano` int DEFAULT NULL,
  `num_votos` int DEFAULT NULL,
  PRIMARY KEY (`id_jogo_ano`),
  UNIQUE KEY `chave_unica_jogo_por_ano` (`id_jogo`,`ano`),
  KEY `id_jogo` (`id_jogo`),
  CONSTRAINT `jogo_do_ano_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.jogo_genero
CREATE TABLE IF NOT EXISTS `jogo_genero` (
  `id_jogo` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_jogo`,`id_genero`),
  KEY `id_genero` (`id_genero`),
  CONSTRAINT `jogo_genero_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jogo_genero_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.lancamentos
CREATE TABLE IF NOT EXISTS `lancamentos` (
  `id_lancamento` int NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `plataformas` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_lancamento`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_utilizador` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `avatar_url` text,
  `password_hash` text NOT NULL,
  `tipo_utilizador` enum('admin','membro') DEFAULT 'membro',
  `data_registo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bio` text,
  PRIMARY KEY (`id_utilizador`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela playscore.votos_utilizadores_ano
CREATE TABLE IF NOT EXISTS `votos_utilizadores_ano` (
  `id_voto` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `id_jogo` int NOT NULL,
  `ano` int NOT NULL,
  PRIMARY KEY (`id_voto`),
  UNIQUE KEY `chave_unica_voto_por_ano` (`id_utilizador`,`ano`),
  KEY `fk_votos_jogos` (`id_jogo`),
  CONSTRAINT `fk_votos_jogos` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_votos_users` FOREIGN KEY (`id_utilizador`) REFERENCES `users` (`id_utilizador`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

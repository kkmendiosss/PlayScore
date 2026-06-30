CREATE DATABASE IF NOT EXISTS `playscore`;
USE `playscore`;

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

CREATE TABLE IF NOT EXISTS `franquias` (
  `id_franquia` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `capa_url` text,
  PRIMARY KEY (`id_franquia`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `generos` (
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `contactos` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mensagem` text,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `lancamentos` (
  `id_lancamento` int NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `plataformas` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_lancamento`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `id_jogo` int NOT NULL,
  `classificacao` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_utilizador` (`id_utilizador`,`id_jogo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE IF NOT EXISTS `jogo_genero` (
  `id_jogo` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_jogo`,`id_genero`),
  KEY `id_genero` (`id_genero`),
  CONSTRAINT `jogo_genero_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jogo_genero_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
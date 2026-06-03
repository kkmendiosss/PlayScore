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

-- A despejar dados para tabela playscore.avaliacoes: ~2 rows (aproximadamente)
INSERT INTO `avaliacoes` (`id`, `id_utilizador`, `id_jogo`, `classificacao`) VALUES
	(1, 1, 20, 5),
	(2, 2, 20, 3),
	(3, 1, 22, 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.comentarios: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela playscore.contactos
CREATE TABLE IF NOT EXISTS `contactos` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mensagem` text,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.contactos: ~1 rows (aproximadamente)
INSERT INTO `contactos` (`id_contacto`, `nome`, `email`, `mensagem`) VALUES
	(3, 'Admin', 'admin@gmail.com', 'Mensagem teste.'),
	(4, 'raetgae', 'aerte@ethg', 'ersgts');

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

-- A despejar dados para tabela playscore.favoritos: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela playscore.franquias
CREATE TABLE IF NOT EXISTS `franquias` (
  `id_franquia` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `capa_url` text,
  PRIMARY KEY (`id_franquia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.franquias: ~0 rows (aproximadamente)
INSERT INTO `franquias` (`id_franquia`, `nome`, `descricao`, `capa_url`) VALUES
	(1, 'God of War', 'dasnufasihnfas', 'img/Franquia/uploads/franquia_6a1ef4d7eeeb43.57765890.jpg'),
	(2, 'god of war', 'fsako+gp', 'img/Franquia/uploads/franquia_6a203278227671.68298502.webp');

-- A despejar estrutura para tabela playscore.generos
CREATE TABLE IF NOT EXISTS `generos` (
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.generos: ~11 rows (aproximadamente)
INSERT INTO `generos` (`id_genero`, `nome`) VALUES
	(1, 'Adventure'),
	(2, 'FPS'),
	(3, 'RPG'),
	(4, 'Horror'),
	(5, 'Action'),
	(6, 'Puzzle'),
	(7, 'Simulator'),
	(8, 'Survival'),
	(9, 'Racing'),
	(10, 'Metroidvania'),
	(14, 'Plataforma');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.jogos: ~20 rows (aproximadamente)
INSERT INTO `jogos` (`id_jogo`, `titulo`, `desenvolvedor`, `editor`, `descricao`, `data_lancamento`, `capa_url`, `trailer_url`, `plataforma`, `classificacao`, `id_genero`, `id_franquia`, `num_votos`, `soma_classificacao`) VALUES
	(1, 'Portal 2', 'Valve', 'Valve', 'Sequel to the acclaimed Portal (2007), Portal 2 pits the protagonist of the original game, Chell, and her new robot friend, Wheatley, against more puzzles conceived by GLaDOS, an A.I. with the sole purpose of testing the Portal Gun\'s mechanics and taking revenge on Chell for the events of Portal. As a result of several interactions and revelations, Chell once again pushes to escape Aperture Science Labs.', '2011-04-18', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co1rs4.jpg', 'https://www.youtube.com/embed/tax4e4hBBZc?si=WDh5UzBqxDynV_E9', 'Windows PC / Mac / Linux / Nintendo Switch / Xbox 360 / PS3', NULL, 6, NULL, 0, 0),
	(2, 'Subnautica 2', 'Unknown Worlds Entertainment', 'Unknown Worlds Entertainment', 'Subnautica 2 is an underwater survival adventure set on an all-new alien world, developed by Unknown Worlds. Play alone or with friends in 4-player co-op. Adapt to survive by building custom bases and crafting tools. Explore the unknown to uncover the mysteries hidden within the depths.', '2026-05-14', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co8yd0.jpg', 'https://www.youtube.com/embed/8EZhCzFaQuw?si=gyFw6BAwB2XyiPmj', 'Windows PC / PS5 / Xbox Series X|S', NULL, 8, NULL, 0, 0),
	(3, 'God of War', 'SIE Santa Monica Studio', 'Sony Interactive Entertainment', 'God of War is the sequel to God of War III as well as a continuation of the canon God of War chronology. Unlike previous installments, this game focuses on Norse mythology and follows an older and more seasoned Kratos and his son Atreus in the years since the third game. It is in this harsh, unforgiving world that he must fight to survive… and teach his son to do the same.', '2018-04-20', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/cobkt6.jpg', 'https://www.youtube.com/embed/K0u_kAWLJOA?si=ohApk1TO4l0syoyx', 'Windows PC / PS4', NULL, 5, 2, 0, 0),
	(4, 'Outer Wilds', 'Mobius Digital', 'Annapurna Interactive', 'Outer Wilds is a critically-acclaimed and award-winning open world mystery about a solar system trapped in an endless time loop. The newest member of the space program in a small village on the planet Timber Hearth, the player navigates a space shuttle and travels across their solar system to get to the bottom of its mysteries by exploring the cosmos and gathering the knowledge hidden within each of the system\'s planets, left behind by another civilization in the distant past.', '2019-05-28', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co65ac.jpg', 'https://www.youtube.com/embed/ZKJUMMCJvGM?si=1N0iu_oNJn93l6Lm', 'Windows PC / PS4 / PS5 / Xbox One / Xbox Series X|S / Nintendo Switch', NULL, 6, NULL, 0, 0),
	(5, 'Bloodborne', 'FromSoftware', 'Sony Computer Entertainment', 'An action RPG in which the player embodies a Hunter who, after being transfused with the mysterious blood local to the city of Yharnam, sets off into a "night of the Hunt", an extended night in which Hunters may phase in and out of dream and reality in order to thin the outbreak of abominable beasts that plague the land and, for the more resilient and insightful Hunters, uncover the answers to the Hunt\'s many mysteries.', '2015-03-24', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/cob99l.jpg', 'https://www.youtube.com/embed/2Crk_GpxGQE?si=VBLtpAl7B-Q3fsIg', 'PS4', NULL, 3, NULL, 0, 0),
	(6, 'Disco Elysium', 'ZA/UM', 'ZA/UM', 'Disco Elysium is a role-playing game developed and published by ZA/UM. It is set in the fictional city of Revachol, where players assume the role of an amnesiac detective investigating a murder case. The game emphasises dialogue and skill-based choices, with character attributes represented by internal voices that influence decisions and interactions. Its narrative explores themes of politics, philosophy, and personal identity, and it is known for its unconventional gameplay and deep storytelling.', '2019-10-15', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co1sfj.jpg', 'https://www.youtube.com/embed/nk_K5DM0UTk?si=FAreSGNyU4foKZOM', 'Windows PC / Mac / PS4 / PS5 / Xbox One / Xbox Series X|S / Nintendo Switch / iOS / Android', NULL, 3, NULL, 0, 0),
	(7, '1000xResist', 'sunset visitor 斜陽過客', 'Fellow Traveller', '1000xRESIST is a thrilling sci-fi adventure. The year is unknown, and a disease spread by an alien invasion keeps you underground. You are Watcher. You dutifully fulfil your purpose in serving the ALLMOTHER, until the day you discover a shocking secret that changes everything. The game blends visual novel, walking simulator, and third-person exploration as you navigate nonlinear memories and unravel the mystery of what really happened—and what’s still being kept from you.', '2024-05-09', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co87zq.jpg', 'https://www.youtube.com/embed/ISmiWUpiDs4?si=s_OaXAS9-6MGchAm', 'Windows PC / Nintendo Switch / PS5 / Xbox Series X|S', NULL, 1, NULL, 0, 0),
	(8, 'BioShock', '2K Boston', '2K Games', 'BioShock is a horror-themed first-person shooter set in a steampunk underwater dystopia. The player is urged to turn everything into a weapon: biologically modifying their own body with Plasmids, hacking devices and systems, upgrading their weapons, crafting new ammo variants, and experimenting with different battle techniques are all possible. The game is described by the developers as a spiritual successor to their previous PC title System Shock 2. BioShock received high praise in critical reviews for its atmospheric audio and visual quality, absorbing and original plot and its unique gaming experience.', '2007-08-21', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co2mli.jpg', 'https://www.youtube.com/embed/rrqfPG4ZcAA?si=kSzEqU5aBGQfxi6I', 'Windows PC / Mac / PS4 / Xbox One / Nintendo Switch / iOS', NULL, 2, NULL, 0, 0),
	(9, 'Half-Life 2', 'Valve', 'Valve', '1998. HALF-LIFE sends a shock through the game industry with its combination of pounding action and continuous, immersive storytelling. NOW. By taking the suspense, challenge and visceral charge of the original, and adding startling new realism and responsiveness, Half-Life 2 opens the door to a world where the player\'s presence affects everything around them, from the physical environment to the behaviors even the emotions of both friends and enemies.', '2004-11-16', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co1nmw.jpg', 'https://www.youtube.com/embed/UKA7JkV51Jw?si=Vxujg6KkGRLEJInG', 'Windows PC / Mac / Linux / Android (via NVIDIA Shield) / Xbox / Xbox 360 / PS3', NULL, 2, NULL, 0, 0),
	(10, 'Persona 5', 'Atlus', 'Sega', 'Persona 5, a turn-based JRPG with visual novel elements, follows a high school student with a criminal record for a crime he didn\'t commit. Soon he meets several characters who share similar fates to him, and discovers a metaphysical realm which allows him and his friends to channel their pent-up frustrations into becoming a group of vigilantes reveling in aesthetics and rebellion while fighting corruption.', '2016-09-15', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co1r76.jpg', 'https://www.youtube.com/embed/QnDzJ9KzuV4?si=K3-L0KGwQYlUiwBu', 'Windows PC / PS3 / PS4 / PS5 / Xbox One / Xbox Series X|S / Nintendo Switch', NULL, 3, NULL, 0, 0),
	(11, 'OneShot', 'Future Cat LLC', 'KOMODO', 'OneShot is a surreal top down puzzle/adventure game with unique gameplay capabilities. You are to guide a child through a mysterious world on a mission to restore its long-dead sun. The world knows you exist.', '2016-12-08', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co1u08.jpg', 'https://www.youtube.com/embed/ld_tcs0CKdo?si=iezLE7XQwhHzB1_P', 'Windows PC / Mac / Linux / PS4 / Xbox One / Nintendo Switch', NULL, 1, NULL, 0, 0),
	(12, 'Return of the Obra Dinn', 'Lucas Pope', '3909', 'In this 1-bit first-person mystery game, a merchant ship called the Obra Dinn has appeared at a London harbor, years after being declared lost at sea. As an insurance adjuster, the player must examine the ship for clues.', '2018-10-18', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co27j9.jpg', 'https://www.youtube.com/embed/ILolesm8kFY?si=AlV1MyBQSAlH5mmF', 'Windows PC / Mac / PS4 / Xbox One / Nintendo Switch', NULL, 6, NULL, 0, 0),
	(13, 'Soma', 'Frictional Games', 'Frictional Games', 'SOMA is a sci-fi horror game from Frictional Games, the creators of Amnesia: The Dark Descent. It is an unsettling story about identity, consciousness, and what it means to be human. Enter the world of SOMA and face horrors buried deep beneath the ocean waves. Delve through locked terminals and secret documents to uncover the truth behind the chaos. Seek out the last remaining inhabitants and take part in the events that will ultimately shape the fate of the station. But be careful, danger lurks in every corner: corrupted humans, twisted creatures, insane robots, and even an inscrutable omnipresent A.I. You will need to figure out how to deal with each one of them. Just remember there’s no fighting back, either you outsmart your enemies or you get ready to run.', '2015-09-21', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co2a20.jpg', 'https://www.youtube.com/embed/SlZfznVWiBQ?si=7-wBsp-tJnryyTIt', 'Windows PC / Mac / Linux / PS4 / Xbox One', NULL, 4, NULL, 0, 0),
	(14, 'Spiritfarer', 'Thunder Lotus', 'Thunder Lotus', 'Spiritfarer is a cozy management game about dying. You play Stella, ferrymaster to the deceased, a Spiritfarer. Build a boat to explore the world, then befriend and care for spirits before finally releasing them into the afterlife. Farm, mine, fish, harvest, cook, and craft your way across mystical seas. Join the adventure as Daffodil the cat, in two-player cooperative play. Spend relaxing quality time with your spirit passengers, create lasting memories, and, ultimately, learn how to say goodbye to your cherished friends. What will you leave behind?', '2019-08-18', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co2fe7.jpg', 'https://www.youtube.com/embed/4pKJ-NuSjNE?si=aT_QhHHiBY9fqDD0', 'Windows PC / Mac / Linux / PS4 / Xbox One / Nintendo Switch / iOS / Android', NULL, 7, NULL, 0, 0),
	(15, 'Stories Untold', 'No Code', 'Devolver Digital', 'Stories Untold is a compilation tape of four episodes from the now cancelled series of the same name, including a remaster of the original pilot episode “The House Abandon”.', '2017-02-27', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co45ws.jpg', 'https://www.youtube.com/embed/nQ5eUoG0mFM?si=0No9j3DS9aOWf6bI', 'Windows PC / Mac / PS4 / Xbox One / Nintendo Switch', NULL, 4, NULL, 0, 0),
	(16, 'The Talos Principle', 'Croteam', 'Devolver Digital', 'The Talos Principle is a philosophical first-person puzzle game from Croteam, the creators of the legendary Serious Sam series, written by Tom Jubert (FTL, The Swapper) and Jonas Kyratzes (The Sea Will Claim Everything).', '2014-12-11', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co1rb5.jpg', 'https://www.youtube.com/embed/iAVh4_wnOIw?si=dvwFL30pYrSSMPWn', 'Windows PC / Mac / Linux / PS4 / Xbox One / Nintendo Switch / iOS / Android', NULL, 6, NULL, 0, 0),
	(17, 'To the Moon', 'Freebird Games', 'Freebird Games', 'Join Dr. Rosalene and Dr. Watts as they enter a patient named Johnny\'s mind on his death bed to grant his final request. Watch, interact, and change the past as Johnny\'s life unfolds before you and takes you on a magical journey inside one\'s head that asks the greatest question of all: "What if...?" If you had the chance to relive your life, would you change things? Would you try to achieve some grand goal? Could you find love? Fame? Fortune? Or would you realize that sometimes the past is meant to stay the same. Join Dr. Rosalene and Watts on their journey and travel To The Moon.', '2011-11-01', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co25yv.jpg', 'https://www.youtube.com/embed/sqkJuSV-23U?si=H1TCUTu4kD-wWpUf', 'Windows PC / Mac / Linux / Nintendo Switch / iOS / Android', NULL, 1, NULL, 0, 0),
	(18, 'Devotion', 'Red Candle Games', 'Red Candle Games', '‘Devotion’ is a first-person atmospheric horror game set in the 1980s Taiwan. The story centers around a seemingly ordinary family of three that lived in an old apartment complex. Explore the nostalgic house in the 80s where religion plays a significant role in their daily life. When one day the same house that once filled with joy and love had turned into a hell-like nightmare, and by venturing in the haunted and confined space, each puzzle leads you closer to the mysteries nested deep inside.', '2019-02-19', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co2muf.jpg', 'https://www.youtube.com/embed/IbQlBGniUQQ?si=WYKK73f0rpBqN6w2', 'Windows PC / Mac', NULL, 4, NULL, 0, 0),
	(19, 'Undertale', 'tobyfox', 'tobyfox', 'A small child falls into the Underground, where monsters have long been banished by humans and are hunting every human that they find. The player controls the child as they try to make it back to the Surface through hostile environments, all the while engaging with a turn-based combat system with puzzle-solving and bullet hell elements, as well as other unconventional game mechanics.', '2015-09-15', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/cob1t2.jpg', 'https://www.youtube.com/embed/ycsnBIX8wTU?si=4letBnrN2WGIq609', 'Windows PC / Mac / Linux / PS4 / PS Vita / Xbox One / Nintendo Switch', NULL, 3, NULL, 0, 0),
	(20, 'VA-11 Hall-A: Cyberpunk Bartender Action', 'SUKEBAN', 'Ysbryd Games', 'Learn about daily life in a cyberpunk dystopia. A branching storyline where your decisions do not depend on traditional choices, but through the drinks you prepare. Visuals inspired by old japanese adventure games for the PC-98, with a modern touch for an other-wordly experience. A beatiful soundtrack composed entirely by Garoad. Get to know your clients, their tastes, and prepare the drink that will change their lives.', '2016-06-21', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co2z8k.jpg', 'https://www.youtube.com/embed/7x393waFKDw?si=DK-MfT9CxBThc4yt', 'Windows PC / Mac / Linux / PS4 / PS Vita / Nintendo Switch', 4, 7, NULL, 2, 0),
	(21, 'LEGO Batman: Legacy of the Dark Knight', 'Traveller\'s Tales', 'Warner Bros. Games', 'Rise as the Dark Knight and experience the essential Batman story in a bold, action-packed adventure with hard-hitting combat, an open-world Gotham City, and the signature LEGO charm that fans know and love.', '2026-05-22', 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/coab09.jpg', 'https://www.youtube.com/embed/DfJaUpW_P00', 'Playstation 5 / Windows PC / Xbox Series X/S / Nintendo Switch 2', 0, 1, NULL, 0, 0);

-- A despejar estrutura para tabela playscore.jogo_do_ano
CREATE TABLE IF NOT EXISTS `jogo_do_ano` (
  `id_jogo_ano` int NOT NULL AUTO_INCREMENT,
  `id_jogo` int DEFAULT NULL,
  `ano` int DEFAULT NULL,
  `num_votos` int DEFAULT NULL,
  PRIMARY KEY (`id_jogo_ano`),
  KEY `id_jogo` (`id_jogo`),
  CONSTRAINT `jogo_do_ano_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.jogo_do_ano: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela playscore.lancamentos
CREATE TABLE IF NOT EXISTS `lancamentos` (
  `id_lancamento` int NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `plataformas` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_lancamento`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.lancamentos: ~20 rows (aproximadamente)
INSERT INTO `lancamentos` (`id_lancamento`, `data`, `nome`, `plataformas`) VALUES
	(1, '2026-07-02', 'Avatar Legends: The Fighting Game', 'PC, PS5, Xbox Series X/S, Switch 2'),
	(2, '2026-07-02', 'Rhythm Heaven Groove', 'Nintendo Switch'),
	(3, '2026-07-07', 'Moonlight Peaks', 'PC, Nintendo Switch, Switch 2'),
	(4, '2026-07-09', 'Assassins Creed Black Flag Resynced', 'PC, PS5, Xbox Series X/S'),
	(5, '2026-07-09', 'Granblue Fantasy: Relink', 'Nintendo Switch 2'),
	(6, '2026-07-09', 'Backyard Baseball', 'PC, PS5, Xbox Series X/S, Nintendo Switch'),
	(7, '2026-07-10', 'Digimon Story: Time Stranger', 'Nintendo Switch, Switch 2'),
	(8, '2026-07-10', 'Echoes of Aincrad', 'PC, PS5, Xbox Series X/S'),
	(9, '2026-07-13', 'Ascend to Zero', 'PC, Xbox Series X/S'),
	(10, '2026-07-14', 'D-topia', 'PC, PS5, Xbox Series X/S, Nintendo Switch, Switch 2'),
	(11, '2026-07-16', 'Ratatan', 'Nintendo Switch 2'),
	(12, '2026-07-16', 'Culdcept Begins', 'PC, PS5, Xbox Series X/S, Nintendo Switch'),
	(13, '2026-07-23', 'Splatoon Raiders', 'Nintendo Switch 2'),
	(14, '2026-07-30', 'Truxton Extreme', 'PC, PS5, Xbox Series X/S, Nintendo Switch 2'),
	(15, '2026-08-03', 'Anomaly President', 'PC'),
	(16, '2026-08-04', 'Beast of Reincarnation', 'PC, PS5, Xbox Series X/S'),
	(17, '2026-08-06', 'Marvel TOKON: Fighting Souls', 'PC, PS5'),
	(18, '2026-08-13', 'Memoirium', 'PC'),
	(19, '2026-08-14', 'Grave Seasons', 'PC, PS5, Xbox Series X/S, Nintendo Switch'),
	(20, '2026-08-27', 'Metal Gear Solid: Master Collection Vol. 2', 'PC, PS5, Xbox Series X/S, Nintendo Switch, Switch 2'),
	(22, '2026-06-25', 'adads', 'pc'),
	(23, '2026-06-25', 'asdasfdsfsdf', 'ps5');

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

-- A despejar dados para tabela playscore.users: ~2 rows (aproximadamente)
INSERT INTO `users` (`id_utilizador`, `nome`, `email`, `avatar_url`, `password_hash`, `tipo_utilizador`, `data_registo`, `bio`) VALUES
	(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$BSYBaazHdqhujJi4LVroj.MngwnyMg.rDegvC3tjPRtEgUFz9HG7G', 'admin', '2026-05-26 16:36:43', NULL),
	(2, 'user', 'user@gmail.com', NULL, '$2y$12$fHI2waCE08koJ.xXlRI.zeotu.atku0U.XQ8P6BEKUq9mZLKiGm6q', 'membro', '2026-05-26 16:37:05', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

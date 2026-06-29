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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.franquias: ~0 rows (aproximadamente)
INSERT INTO `franquias` (`id_franquia`, `nome`, `descricao`, `capa_url`) VALUES
	(5, 'Portal', 'Portal is a series of first-person puzzle-platform video games developed by Valve. Set in the Half-Life universe, the two main games in the series, Portal (2007) and Portal 2 (2011), center on a woman, Chell, who is forced to undergo a series of tests within the Aperture Science Enrichment Center by a malicious artificial intelligence, GLaDOS, that controls the facility.', 'img/Franquia/uploads/franquia_6a4147602b8232.24363531.png'),
	(6, 'Hades', 'The Hades series is a critically acclaimed, story-rich roguelike action RPG franchise developed by Supergiant Games, blending fast-paced hack-and-slash combat with deep, mythological, and character-driven storytelling.', 'img/Franquia/uploads/franquia_6a41472fad7556.21581551.webp'),
	(7, 'Hollow Knight', 'The Hollow Knight series is an acclaimed Metroidvania franchise created by Australian independent developer Team Cherry. It is celebrated for its tight 2D controls, hand-drawn art, atmospheric lore, and deep exploration.', 'img/Franquia/uploads/franquia_6a4146eb63a700.40991523.webp'),
	(8, 'Undertale', 'The Undertale series, created by indie developer Toby Fox, is an acclaimed RPG series known for its unique combat system, branching choices, and memorable music. The official series consists of the original 2015 game and its ongoing multi-chapter sequel, Deltarune.', 'img/Franquia/uploads/franquia_6a4146bcaec402.90379245.jpg'),
	(9, 'The Talos Principle', 'The Talos Principle is an acclaimed philosophical, first-person puzzle franchise developed by Croteam and published by Devolver Digital. It explores themes of artificial consciousness, humanity, and the search for meaning, challenging players to solve complex spatial puzzles utilizing lasers, jammers, and time-recording devices.', 'img/Franquia/uploads/franquia_6a41469a9125b9.21605488.jpg'),
	(10, 'Bioshock', 'The BioShock franchise is a critically acclaimed series of retrofuturistic, narrative-driven first-person shooters. Created by Ken Levine and published by 2K Games, the series is celebrated for its immersive environments, deep philosophical themes, and iconic dystopian cities like the underwater Rapture and the airborne Columbia.', 'img/Franquia/uploads/franquia_6a414658c31f19.19048304.webp'),
	(11, 'Elden Ring', 'The Elden Ring franchise is a critically acclaimed dark fantasy action-RPG series created by FromSoftware and published by Bandai Namco. Blending the worldbuilding of Game of Thrones author George R. R. Martin with the visionary direction of Hidetaka Miyazaki, the franchise has expanded into a massive global phenomenon.', 'img/Franquia/uploads/franquia_6a4145bce63839.39380875.webp'),
	(12, 'Half-Life', 'Developed by Valve, the Half-Life franchise is one of the most influential first-person shooter (FPS) series in video game history. Renowned for its seamless storytelling, immersive environments, and physics-based gameplay, the saga follows theoretical physicist Gordon Freeman as he leads a resistance against an alien empire.', 'img/Franquia/uploads/franquia_6a413ff67bf6e1.40188162.jpg'),
	(13, 'Subnautica', 'The Subnautica series is a critically acclaimed underwater survival-crafting franchise developed by Unknown Worlds Entertainment. It puts players on an alien ocean planet, tasking them with gathering resources, building bases, piloting submersibles, and surviving the deep-sea terrors while unraveling compelling sci-fi narratives.', 'img/Franquia/uploads/franquia_6a41431ae10527.75454048.webp'),
	(14, 'Persona 5', 'The Persona 5 series is a sub-franchise of Atlus’s Megami Tensei role-playing games. Centered on the "Phantom Thieves of Hearts," it masterfully combines Japanese high school life-simulation with turn-based supernatural dungeon crawling.', 'img/Franquia/uploads/franquia_6a41486f3774a0.29446025.jpg'),
	(15, 'God of War', 'The God of War franchise is an action-adventure series following Kratos, a Spartan warrior who becomes a vengeful god. Spanning two massive mythologies, the narrative details his violent crusade against the Greek Pantheon, followed by his journey to the Norse realms seeking redemption and a fresh start.', 'img/Franquia/uploads/franquia_6a4149e7de2246.23934870.jpg'),
	(16, 'Monster Hunter', 'The Monster Hunter franchise is a globally popular, fantasy-themed action RPG series developed and published by Capcom. Players assume the role of a hunter taking on quests to slay or trap massive creatures. Instead of traditional leveling, progression is driven by looting monsters to craft increasingly powerful weapons and armor.', 'img/Franquia/uploads/franquia_6a414b0cdfb0f5.63683905.jpg');

-- A despejar estrutura para tabela playscore.generos
CREATE TABLE IF NOT EXISTS `generos` (
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.generos: ~15 rows (aproximadamente)
INSERT INTO `generos` (`id_genero`, `nome`) VALUES
	(1, 'Adventure'),
	(2, 'FPS'),
	(3, 'RPG'),
	(4, 'Horror'),
	(5, 'Action'),
	(6, 'Puzzle'),
	(7, 'Simulation'),
	(8, 'Survival'),
	(9, 'Racing'),
	(10, 'Metroidvania'),
	(15, 'Platformer'),
	(16, 'Strategy'),
	(18, 'Visual Novel'),
	(19, 'Hack & Slash'),
	(24, 'Roguelike');

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

-- A despejar dados para tabela playscore.jogos: ~57 rows (aproximadamente)
INSERT INTO `jogos` (`id_jogo`, `titulo`, `desenvolvedor`, `editor`, `descricao`, `data_lancamento`, `capa_url`, `trailer_url`, `plataforma`, `classificacao`, `id_genero`, `id_franquia`, `num_votos`, `soma_classificacao`) VALUES
	(1, 'Portal 2', 'Valve', 'Valve', 'Sequel to the acclaimed Portal (2007), Portal 2 pits the protagonist of the original game, Chell, and her new robot friend, Wheatley, against more puzzles conceived by GLaDOS, an A.I. with the sole purpose of testing the Portal Gun\'s mechanics and taking revenge on Chell for the events of Portal. As a result of several interactions and revelations, Chell once again pushes to escape Aperture Science Labs.', '2011-04-18', '../uploads/capas/1781648736_co1rs4.jpg', 'https://www.youtube.com/embed/tax4e4hBBZc?si=WDh5UzBqxDynV_E9', 'PC, PlayStation 3, Xbox 360, Nintendo Switch', NULL, 6, 5, 0, 0),
	(2, 'Subnautica 2', 'Unknown Worlds Entertainment', 'Unknown Worlds Entertainment', 'Subnautica 2 is an underwater survival adventure set on an all-new alien world, developed by Unknown Worlds. Play alone or with friends in 4-player co-op. Adapt to survive by building custom bases and crafting tools. Explore the unknown to uncover the mysteries hidden within the depths.', '2026-05-14', '../uploads/capas/1781648699_co8yd0.jpg', 'https://www.youtube.com/embed/8EZhCzFaQuw?si=gyFw6BAwB2XyiPmj', 'PC, Xbox Series X/S', NULL, 8, 13, 0, 0),
	(3, 'God of War', 'SIE Santa Monica Studio', 'Sony Interactive Entertainment', 'God of War is the sequel to God of War III as well as a continuation of the canon God of War chronology. Unlike previous installments, this game focuses on Norse mythology and follows an older and more seasoned Kratos and his son Atreus in the years since the third game. It is in this harsh, unforgiving world that he must fight to survive… and teach his son to do the same.', '2018-04-20', '../uploads/capas/1781648561_cobkt6.jpg', 'https://www.youtube.com/embed/K0u_kAWLJOA?si=ohApk1TO4l0syoyx', 'PC, PlayStation 4', NULL, 5, 15, 0, 0),
	(4, 'Outer Wilds', 'Mobius Digital', 'Annapurna Interactive', 'Outer Wilds is a critically-acclaimed and award-winning open world mystery about a solar system trapped in an endless time loop. The newest member of the space program in a small village on the planet Timber Hearth, the player navigates a space shuttle and travels across their solar system to get to the bottom of its mysteries by exploring the cosmos and gathering the knowledge hidden within each of the system\'s planets, left behind by another civilization in the distant past.', '2019-05-28', '../uploads/capas/1781648487_co65ac.jpg', 'https://www.youtube.com/embed/ZKJUMMCJvGM?si=1N0iu_oNJn93l6Lm', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch', NULL, 6, NULL, 0, 0),
	(5, 'Bloodborne', 'FromSoftware', 'Sony Computer Entertainment', 'An action RPG in which the player embodies a Hunter who, after being transfused with the mysterious blood local to the city of Yharnam, sets off into a "night of the Hunt", an extended night in which Hunters may phase in and out of dream and reality in order to thin the outbreak of abominable beasts that plague the land and, for the more resilient and insightful Hunters, uncover the answers to the Hunt\'s many mysteries.', '2015-03-24', '../uploads/capas/1781648414_cob99l.jpg', 'https://www.youtube.com/embed/2Crk_GpxGQE?si=VBLtpAl7B-Q3fsIg', 'PlayStation 4', NULL, 3, NULL, 0, 0),
	(6, 'Disco Elysium', 'ZA/UM', 'ZA/UM', 'Disco Elysium is a role-playing game developed and published by ZA/UM. It is set in the fictional city of Revachol, where players assume the role of an amnesiac detective investigating a murder case. The game emphasises dialogue and skill-based choices, with character attributes represented by internal voices that influence decisions and interactions. Its narrative explores themes of politics, philosophy, and personal identity, and it is known for its unconventional gameplay and deep storytelling.', '2019-10-15', '../uploads/capas/1781648335_co1sfj.jpg', 'https://www.youtube.com/embed/nk_K5DM0UTk?si=FAreSGNyU4foKZOM', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch, Mobile', NULL, 3, NULL, 0, 0),
	(7, '1000xResist', 'sunset visitor 斜陽過客', 'Fellow Traveller', '1000xRESIST is a thrilling sci-fi adventure. The year is unknown, and a disease spread by an alien invasion keeps you underground. You are Watcher. You dutifully fulfil your purpose in serving the ALLMOTHER, until the day you discover a shocking secret that changes everything. The game blends visual novel, walking simulator, and third-person exploration as you navigate nonlinear memories and unravel the mystery of what really happened—and what’s still being kept from you.', '2024-05-09', '../uploads/capas/1781648202_co87zq.jpg', 'https://www.youtube.com/embed/ISmiWUpiDs4?si=s_OaXAS9-6MGchAm', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch', NULL, 1, NULL, 0, 0),
	(8, 'BioShock', '2K Boston', '2K Games', 'BioShock is a horror-themed first-person shooter set in a steampunk underwater dystopia. The player is urged to turn everything into a weapon: biologically modifying their own body with Plasmids, hacking devices and systems, upgrading their weapons, crafting new ammo variants, and experimenting with different battle techniques are all possible. The game is described by the developers as a spiritual successor to their previous PC title System Shock 2. BioShock received high praise in critical reviews for its atmospheric audio and visual quality, absorbing and original plot and its unique gaming experience.', '2007-08-21', '../uploads/capas/1781648165_co2mli.jpg', 'https://www.youtube.com/embed/rrqfPG4ZcAA?si=kSzEqU5aBGQfxi6I', 'PC, PlayStation 3, Xbox 360, Mobile', NULL, 2, 10, 0, 0),
	(9, 'Half-Life 2', 'Valve', 'Valve', '1998. HALF-LIFE sends a shock through the game industry with its combination of pounding action and continuous, immersive storytelling. NOW. By taking the suspense, challenge and visceral charge of the original, and adding startling new realism and responsiveness, Half-Life 2 opens the door to a world where the player\'s presence affects everything around them, from the physical environment to the behaviors even the emotions of both friends and enemies.', '2004-11-16', '../uploads/capas/1781648031_co1nmw.jpg', 'https://www.youtube.com/embed/UKA7JkV51Jw?si=Vxujg6KkGRLEJInG', 'PC, PlayStation 3, Xbox 360, Xbox', NULL, 2, 12, 0, 0),
	(10, 'Persona 5', 'Atlus', 'Sega', 'Persona 5, a turn-based JRPG with visual novel elements, follows a high school student with a criminal record for a crime he didn\'t commit. Soon he meets several characters who share similar fates to him, and discovers a metaphysical realm which allows him and his friends to channel their pent-up frustrations into becoming a group of vigilantes reveling in aesthetics and rebellion while fighting corruption.', '2016-09-15', '../uploads/capas/1781647893_co1r76.jpg', 'https://www.youtube.com/embed/QnDzJ9KzuV4?si=K3-L0KGwQYlUiwBu', 'PC, PlayStation 5, PlayStation 4, PlayStation 3, Xbox Series X/S, Xbox One, Nintendo Switch', NULL, 3, 14, 0, 0),
	(11, 'OneShot', 'Future Cat LLC', 'KOMODO', 'OneShot is a surreal top down puzzle/adventure game with unique gameplay capabilities. You are to guide a child through a mysterious world on a mission to restore its long-dead sun. The world knows you exist.', '2016-12-08', '../uploads/capas/1781647796_co1u08.jpg', 'https://www.youtube.com/embed/ld_tcs0CKdo?si=iezLE7XQwhHzB1_P', 'PC, PlayStation 4, Xbox One, Nintendo Switch', NULL, 1, NULL, 0, 0),
	(12, 'Return of the Obra Dinn', 'Lucas Pope', '3909', 'In this 1-bit first-person mystery game, a merchant ship called the Obra Dinn has appeared at a London harbor, years after being declared lost at sea. As an insurance adjuster, the player must examine the ship for clues.', '2018-10-18', '../uploads/capas/1781647752_co27j9.jpg', 'https://www.youtube.com/embed/ILolesm8kFY?si=AlV1MyBQSAlH5mmF', 'PC, PlayStation 4, Xbox One, Nintendo Switch', NULL, 6, NULL, 0, 0),
	(13, 'Soma', 'Frictional Games', 'Frictional Games', 'SOMA is a sci-fi horror game from Frictional Games, the creators of Amnesia: The Dark Descent. It is an unsettling story about identity, consciousness, and what it means to be human. Enter the world of SOMA and face horrors buried deep beneath the ocean waves. Delve through locked terminals and secret documents to uncover the truth behind the chaos. Seek out the last remaining inhabitants and take part in the events that will ultimately shape the fate of the station. But be careful, danger lurks in every corner: corrupted humans, twisted creatures, insane robots, and even an inscrutable omnipresent A.I. You will need to figure out how to deal with each one of them. Just remember there’s no fighting back, either you outsmart your enemies or you get ready to run.', '2015-09-21', '../uploads/capas/1781647560_co2a20.jpg', 'https://www.youtube.com/embed/SlZfznVWiBQ?si=7-wBsp-tJnryyTIt', 'PC, PlayStation 4, Xbox One, Nintendo Switch', NULL, 4, NULL, 0, 0),
	(14, 'Spiritfarer', 'Thunder Lotus', 'Thunder Lotus', 'Spiritfarer is a cozy management game about dying. You play Stella, ferrymaster to the deceased, a Spiritfarer. Build a boat to explore the world, then befriend and care for spirits before finally releasing them into the afterlife. Farm, mine, fish, harvest, cook, and craft your way across mystical seas. Join the adventure as Daffodil the cat, in two-player cooperative play. Spend relaxing quality time with your spirit passengers, create lasting memories, and, ultimately, learn how to say goodbye to your cherished friends. What will you leave behind?', '2020-08-18', '../uploads/capas/1781647462_co2fe7.jpg', 'https://www.youtube.com/embed/4pKJ-NuSjNE?si=aT_QhHHiBY9fqDD0', 'PC, PlayStation 4, Xbox One, Nintendo Switch, Mobile', NULL, 7, NULL, 0, 0),
	(15, 'Stories Untold', 'No Code', 'Devolver Digital', 'Stories Untold is a compilation tape of four episodes from the now cancelled series of the same name, including a remaster of the original pilot episode “The House Abandon”.', '2017-02-27', '../uploads/capas/1781647315_co45ws.jpg', 'https://www.youtube.com/embed/nQ5eUoG0mFM?si=0No9j3DS9aOWf6bI', 'PC, PlayStation 4, Xbox One, Nintendo Switch', NULL, 4, NULL, 0, 0),
	(16, 'The Talos Principle', 'Croteam', 'Devolver Digital', 'The Talos Principle is a philosophical first-person puzzle game from Croteam, the creators of the legendary Serious Sam series, written by Tom Jubert (FTL, The Swapper) and Jonas Kyratzes (The Sea Will Claim Everything).', '2014-12-11', '../uploads/capas/1781647232_co1rb5.jpg', 'https://www.youtube.com/embed/iAVh4_wnOIw?si=dvwFL30pYrSSMPWn', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch, Mobile', NULL, 6, 9, 0, 0),
	(17, 'To the Moon', 'Freebird Games', 'Freebird Games', 'Join Dr. Rosalene and Dr. Watts as they enter a patient named Johnny\'s mind on his death bed to grant his final request. Watch, interact, and change the past as Johnny\'s life unfolds before you and takes you on a magical journey inside one\'s head that asks the greatest question of all: "What if...?" If you had the chance to relive your life, would you change things? Would you try to achieve some grand goal? Could you find love? Fame? Fortune? Or would you realize that sometimes the past is meant to stay the same. Join Dr. Rosalene and Watts on their journey and travel To The Moon.', '2011-11-01', '../uploads/capas/1781647171_co25yv.jpg', 'https://www.youtube.com/embed/sqkJuSV-23U?si=H1TCUTu4kD-wWpUf', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch, Mobile', NULL, 1, NULL, 0, 0),
	(18, 'Devotion', 'Red Candle Games', 'Red Candle Games', '‘Devotion’ is a first-person atmospheric horror game set in the 1980s Taiwan. The story centers around a seemingly ordinary family of three that lived in an old apartment complex. Explore the nostalgic house in the 80s where religion plays a significant role in their daily life. When one day the same house that once filled with joy and love had turned into a hell-like nightmare, and by venturing in the haunted and confined space, each puzzle leads you closer to the mysteries nested deep inside.', '2019-02-19', '../uploads/capas/1781647115_co2muf.jpg', 'https://www.youtube.com/embed/IbQlBGniUQQ?si=WYKK73f0rpBqN6w2', 'PC', NULL, 4, NULL, 0, 0),
	(19, 'Undertale', 'tobyfox', 'tobyfox', 'A small child falls into the Underground, where monsters have long been banished by humans and are hunting every human that they find. The player controls the child as they try to make it back to the Surface through hostile environments, all the while engaging with a turn-based combat system with puzzle-solving and bullet hell elements, as well as other unconventional game mechanics.', '2015-09-15', '../uploads/capas/1781647045_cob1t2.jpg', 'https://www.youtube.com/embed/ycsnBIX8wTU?si=4letBnrN2WGIq609', 'PC, PlayStation 4, PlayStation Vita, Xbox One, Nintendo Switch', NULL, 3, 8, 0, 0),
	(20, 'VA-11 Hall-A: Cyberpunk Bartender Action', 'SUKEBAN', 'Ysbryd Games', 'Learn about daily life in a cyberpunk dystopia. A branching storyline where your decisions do not depend on traditional choices, but through the drinks you prepare. Visuals inspired by old japanese adventure games for the PC-98, with a modern touch for an other-wordly experience. A beatiful soundtrack composed entirely by Garoad. Get to know your clients, their tastes, and prepare the drink that will change their lives.', '2016-06-21', '../uploads/capas/1781646755_co2z8k.jpg', 'https://www.youtube.com/embed/7x393waFKDw?si=DK-MfT9CxBThc4yt', 'PC, PlayStation 4, PlayStation Vita, Nintendo Switch', 4, 7, NULL, 2, 0),
	(21, 'LEGO Batman: Legacy of the Dark Knight', 'Traveller\'s Tales', 'Warner Bros. Games', 'Rise as the Dark Knight and experience the essential Batman story in a bold, action-packed adventure with hard-hitting combat, an open-world Gotham City, and the signature LEGO charm that fans know and love.', '2026-05-22', '../uploads/capas/1781646618_coab09.jpg', 'https://www.youtube.com/embed/DfJaUpW_P00', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, 1, NULL, 0, 0),
	(26, 'Mina the Hollower', 'Yacht Club Games', 'Yacht Club Games', 'Mina the Hollower is a bone-chilling action-adventure game featuring classic gameplay and an 8-bit aesthetic in the style of Game Boy Color, refined for the modern era. Quick and deliberate 60fps action combat, captivating world design, and top-down adventuring combine in a nostalgic blend. Whip foes, burrow through the ground, and explore a pixel-perfect world in Mina the Hollower, a brand new game from the developers who brought you Shovel Knight!', '2026-05-29', '../uploads/capas/capa_6a4039f53fd8b8.33859277.jpg', 'https://www.youtube.com/embed/_Fx0aJCRRpE?si=Ha15Ot2PE003KMFM', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2, Nintendo Switch', 0, NULL, NULL, 0, 0),
	(27, 'Mixtape', 'Beethoven & Dinosaur', 'Annapurna Interactive', 'Mixtape is a narrative adventure game developed by Beethoven & Dinosaur and published by Annapurna Interactive. Set during the last night of high school, it follows three friends as they revisit memories connected to music, youth and leaving home. The game combines story scenes with playable vignettes, including skating, parties, and other moments, all framed by a licensed soundtrack.', '2026-05-07', '../uploads/capas/capa_6a403a96ab12e4.16814471.jpg', 'https://www.youtube.com/embed/dL4WxbBO08o?si=bpGUnFZX1qMI9Vp1', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(28, 'Reanimal', 'Tarsier Studios', 'THQ Nordic', 'The creators of Little Nightmares I & II have returned to take you on a darker, more terrifying journey than ever before. In this horror adventure game, a brother & sister go through hell to rescue their missing friends and escape the island that they used to call home.', '2026-02-13', '../uploads/capas/capa_6a403ecd7b17e5.10329670.jpg', 'https://www.youtube.com/embed/GjZBPhsDLZ0?si=c4vsLOoknmG6pZZN', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(29, 'Resident Evil Requiem', 'Capcom', 'Capcom', 'Resident Evil Requiem is the ninth entry in the Resident Evil series. Experience terrifying survival horror with FBI analyst Grace Ashcroft, and dive into pulse-pounding action with legendary agent Leon S. Kennedy. Both of their journeys and unique gameplay styles intertwine into a heart-stopping, emotional experience that will chill you to your core.', '2026-02-27', '../uploads/capas/capa_6a403f8de7bd88.30177172.jpg', 'https://www.youtube.com/embed/POz1-EmLsTY?si=CmETqHWaXjcMiJXD', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(30, 'Pragmata', 'Capcom', 'Capcom', 'Pragmata is a sci-fi action-adventure game set in the near future. The story follows Hugh and his android companion Diana as they navigate a Lunar research station. Gameplay incorporates action elements alongside mechanics involving interaction with systems within the environment.', '2026-04-17', '../uploads/capas/capa_6a4040074f2f20.14378314.jpg', 'https://www.youtube.com/embed/TzBtbtOghV0?si=JjKazDbR5AUig7aI', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(31, '007 First Light', 'IO Interactive', 'IO Interactive', '007 First Light is a thrilling espionage action-adventure game from IO Interactive. Players follow James Bond as a young, resourceful, and sometimes reckless recruit in MI6\'s training program and discover an origin story of the world\'s most famous spy.', '2026-05-27', '../uploads/capas/capa_6a40408353abe5.25027959.jpg', 'https://www.youtube.com/embed/i-fgtpwEMPM?si=-Oo0BmCQDK5eXAhg', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(32, 'Forza Horizon 6', 'Playground Games', 'Xbox Game Studios', 'Discover the breathtaking landscapes of Japan in over 550 real-world cars and become a racing Legend at the Horizon Festival. Start your journey as a tourist and explore a world full of hit music and Japanese culture. Build a Valley Estate, acquire awe-inspiring homes, and display your prized car collection in fully Customizable Garages. Cruise the roads with your friends and join Car Meets around Japan, unleash your imagination with EventLab and build together in Horizon CoLab.', '2026-05-19', '../uploads/capas/capa_6a404eede3fd93.40598701.jpg', 'https://www.youtube.com/embed/oYhaW-Vr4wg?si=VzWRQcSBI0sTVyXq', 'PC, PlayStation 5, Xbox Series X/S', 0, NULL, NULL, 0, 0),
	(33, 'Pokémon Pokopia', 'Game Freak, Omega Force', 'Nintendo', 'Pokémon and people once lived happily together, but the world has withered and the humans are gone. The only remaining resident appears to be a lone Tangrowth. After waking from a long slumber, a peculiar Ditto decides to restore the desolate land using its transformation skills and its surprising new crafting abilities. Play as a Ditto and build a charming world alongside your Pokémon friends. After a satisfying day of crafting, building, and gardening, relax in your very own paradise or invite Pokémon and your friends to visit. As you restore your world and cultivate its natural beauty, you\'ll encounter more Pokémon who will teach you useful moves! Your Pokémon neighbors are excited to play together, as well as help you build houses to welcome even more friends! Pokémon might even ask for your help – work with them to build a cozy utopia.', '2026-03-05', '../uploads/capas/capa_6a404f9d0b5ed8.96670440.jpg', 'https://www.youtube.com/embed/-zpr21HzJ9Q?si=oRrTfDbDFL_6xzNk', 'Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(34, 'Clair Obscur: Expedition 33', 'Sandfall Interactive', 'Kepler Interactive', 'Lead the members of Expedition 33 on their quest to destroy the Paintress so that she can never paint death again. Explore a world of wonders inspired by Belle Époque France and battle unique enemies in this turn-based RPG with real-time mechanics.', '2025-04-24', '../uploads/capas/capa_6a4051dc8ee136.07997246.jpg', 'https://www.youtube.com/embed/ejgW-upPMgk?si=zWh6g-KKYUu4w5au', 'PC, PlayStation 5, Xbox Series X/S', 0, NULL, NULL, 0, 0),
	(35, 'Hollow Knight: Silksong', 'Team Cherry', 'Team Cherry', 'Hollow Knight: Silksong is the epic sequel to Hollow Knight, the epic action-adventure of bugs and heroes. As the lethal hunter Hornet, journey to all-new lands, discover new powers, battle vast hordes of bugs and beasts and uncover ancient secrets tied to your nature and your past.', '2025-09-04', '../uploads/capas/capa_6a40526a74fbf9.93010703.jpg', 'https://www.youtube.com/embed/6XGeJwsUP9c?si=3lCV9VGSc375AsQY', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch 2, Nintendo Switch', 0, NULL, 7, 0, 0),
	(36, 'Dispatch', 'AdHoc Studio', 'AdHoc Studio', 'Dispatch is a superhero workplace comedy where choices matter. Manage a dysfunctional team of misfit heroes and strategize who to send to emergencies around the city, all while balancing office politics, personal relationships, and your own quest to become a hero.', '2025-10-22', '../uploads/capas/capa_6a4053316a5694.93072322.jpg', 'https://www.youtube.com/embed/ZbERWU5bc50?si=XYKKi48tNV5tAvrX', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2, Nintendo Switch', 0, NULL, NULL, 0, 0),
	(37, 'Peak', 'Aggro Crab, Landfall', 'Aggro Crab, Landfall', 'Peak is a cooperative climbing game for up to four players. After crash-landing on an unknown island, players take the role of scouts attempting to ascend the mountain at its center. The mountain is semi-procedurally generated and changes every 24 hours, featuring five distinct biomes with unique obstacles and enemies. Players manage stamina, collect climbing tools like ropes and pitons, and must work together to survive hazards while ascending.', '2025-06-16', '../uploads/capas/capa_6a405408724224.96508294.jpg', 'https://www.youtube.com/embed/jrlUVhLBjG0?si=PNt6KnXCt1z9y34-', 'PC', 0, NULL, NULL, 0, 0),
	(38, 'Hades II', 'Supergiant Games', 'Supergiant Games', 'Battle beyond the Underworld using dark sorcery to take on the Titan of Time in this bewitching sequel to the award-winning rogue-like dungeon crawler.', '2025-09-25', '../uploads/capas/capa_6a405511e329a4.88323905.jpg', 'https://www.youtube.com/embed/U8lJRcUeEMs?si=gA4xf6FjqBF2WVo-', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2, Nintendo Switch', 0, NULL, 6, 0, 0),
	(39, 'Mario Kart World', 'Nintendo', 'Nintendo', 'Mario Kart World is a kart racing game for the Nintendo Switch 2, featuring characters from the Mario franchise. It introduces an open-world design to the series, allowing players to drive freely between courses rather than selecting them from a menu. Races support up to 24 players and include new mechanics such as off-roading, boat racing, rail grinding, and wall riding. The game features a Knockout Tour elimination mode where racers compete across connected courses with periodic eliminations at checkpoints, as well as a Free Roam mode for open exploration and collectible-finding.', '2025-06-05', '../uploads/capas/capa_6a4056186db506.62591110.jpg', 'https://www.youtube.com/embed/3pE23YTYEZM?si=Pv9MFtksKts-G4Bn', 'Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(40, 'Deltarune', 'Toby Fox', 'Toby Fox', 'Dive into the parallel story to UNDERTALE! Fight or spare your way through action-packed battles as you explore a mysterious world alongside an endearing cast of new and familiar characters.', '2025-06-04', '../uploads/capas/capa_6a40574d8eae60.60641660.jpg', 'https://www.youtube.com/embed/yDzgiGdekas?si=Iq_CEAVmxntzCxhw', 'PC, PlayStation 5, PlayStation 4, Nintendo Switch 2, Nintendo Switch', 0, NULL, 8, 0, 0),
	(41, 'Split Fiction', 'Hazelight Studios', 'Electronic Arts', 'Split Fiction is a 2025 cooperative multiplayer game. It follows two writers, Mio Hudson and Zoe Foster, as they become trapped in their imaginations.', '2025-03-06', '../uploads/capas/capa_6a4057e8021ae4.90412711.jpg', 'https://www.youtube.com/embed/fcwngWPXQtg?si=69EoNUe-UnqiRvuc', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(42, 'Elden Ring Nightreign', 'FromSoftware', 'Bandai Namco Entertainment', 'Elden Ring: Nightreign is a standalone adventure within the ELDEN RING universe, crafted to offer players a new gaming experience by reimagining the game’s core design.', '2025-05-30', '../uploads/capas/capa_6a405869a53633.07266743.jpg', 'https://www.youtube.com/embed/Djtsw5k_DNc?si=NWijJHV6iIOmCwWy', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One', 0, NULL, 11, 0, 0),
	(43, 'Monster Hunter Wilds', 'Capcom', 'Capcom', 'The unbridled force of nature runs wild and relentless, with environments transforming drastically from one moment to the next. This is a story of monsters and humans and their struggles to live in harmony in a world of duality.', '2025-02-28', '../uploads/capas/capa_6a4058e694f152.05371794.jpg', 'https://www.youtube.com/embed/a_wNFT4j6qI?si=TjTs05JVRABshgfT', 'PC, PlayStation 5, Xbox Series X/S', 0, NULL, 16, 0, 0),
	(44, 'Silent Hill f', 'NeoBards Entertainment', 'Konami Digital Entertainment', 'Silent Hill f is a survival horror game published by Konami as part of the Silent Hill series. It is set in rural Japan during the 1960s, marking a departure from the franchise’s traditional Western settings. The story is written by Ryukishi07 and focuses on psychological horror, social pressure, and transformation.', '2025-09-25', '../uploads/capas/capa_6a4059ad39d2e7.16135295.jpg', 'https://www.youtube.com/embed/AcKAnxzMez8?si=cpdu6FF7H3BQt11i', 'PC, PlayStation 5, Xbox Series X/S', 0, NULL, NULL, 0, 0),
	(45, 'Blue Prince', 'Dogubomb', 'Raw Fury', 'Welcome to Mt. Holly, where every dawn unveils a new mystery. Navigate through shifting corridors and ever-changing chambers in this genre-defying strategy puzzle adventure. But will the unpredictable path you create lead you to the rumored Room 46?', '2025-04-10', '../uploads/capas/capa_6a405a29884126.12259309.jpg', 'https://www.youtube.com/embed/wIrgdM6shNA?si=Nz0dmgtHlg05HN2R', 'PC, PlayStation 5, Xbox Series X/S, Nintendo Switch 2', 0, NULL, NULL, 0, 0),
	(46, 'Portal', 'Valve', 'Valve', 'Waking up in a seemingly empty laboratory, the player is made to complete various physics-based puzzle challenges through numerous test chambers in order to test out the new Aperture Science Handheld Portal Device, without an explanation as to how, why or by whom.\r\n\r\n', '2007-10-10', '../uploads/capas/capa_6a412d8ecf5624.83368659.jpg', 'https://www.youtube.com/embed/-cO_DIVuSyQ?si=rboXmCo2DE2QNmst', 'PC, PlayStation 3, Xbox 360, Nintendo Switch, Mobile', 0, NULL, 5, 0, 0),
	(47, 'Hades', 'Supergiant Games', 'Supergiant Games', 'A rogue-lite hack and slash dungeon crawler in which Zagreus, son of Hades the Greek god of the dead, attempts to escape his home and his oppressive father by fighting the souls of the dead through the various layers of the ever-shifting underworld, while getting to know and forging relationships with its inhabitants.', '2020-09-17', '../uploads/capas/capa_6a41347ed5a243.96350706.jpg', 'https://www.youtube.com/embed/Bz8l935Bv0Y?si=dqR3mZQHpEupx6TQ', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch, Mobile', 0, NULL, 6, 0, 0),
	(48, 'Hollow Knight', 'Team Cherry', 'Team Cherry', 'A 2D metroidvania with an emphasis on close combat and exploration in which the player enters the once-prosperous now-bleak insect kingdom of Hallownest, travels through its various districts, meets friendly inhabitants, fights hostile ones and uncovers the kingdom\'s history while improving their combat abilities and movement arsenal by fighting bosses and accessing out-of-the-way areas.', '2017-02-24', '../uploads/capas/capa_6a4135eab459c1.88166027.jpg', 'https://www.youtube.com/embed/UAO2urG23S4?si=sYll4GMvCEd3Hlph', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch 2, Nintendo Switch', 0, NULL, 7, 0, 0),
	(49, 'The Talos Principle II', 'Croteam', 'Devolver Digital', 'The Talos Principle II is a thought-provoking first-person puzzle experience that greatly expands on the first game\'s philosophical themes and stunning environments with increasingly mind-bending challenges.', '2023-11-02', '../uploads/capas/capa_6a4139279f4a36.04105473.jpg', 'https://www.youtube.com/embed/9ivatJM-9oA?si=dAxgncvw2Ontpoid', 'PC, PlayStation 5, Xbox Series X/S', 0, NULL, 9, 0, 0),
	(50, 'BioShock 2', '2K', '2K', 'BioShock 2 is the second game of the BioShock series and the sequel to BioShock. It continues the grand storyline of the underwater metropolis Rapture. BioShock 2 capitalizes and improves upon the high-quality effects, unique gameplay elements, and immersive atmosphere that defined the first game. It explores more brutal gameplay than its predecessor, with new enemies, weapons, Plasmids, and Gene Tonics.', '2010-02-09', '../uploads/capas/capa_6a413d62c05388.56456473.jpg', 'https://www.youtube.com/embed/QGMzkNApMUI?si=uLWPOQr78daR5jzo', 'PC, PlayStation 3, Xbox 360', 0, NULL, 10, 0, 0),
	(51, 'BioShock Infinite', 'Irrational Games', '2K', 'BioShock Infinite is the third game in the BioShock series. It is not a direct sequel/prequel to any of the previous BioShock games but takes place in an entirely different setting, although it shares similar features, gameplay and concepts with the previous games. BioShock Infinite features a range of environments that force the player to adapt, with different weapons and strategies for each situation. Interior spaces feature close combat with enemies, but unlike previous games set in Rapture, the setting of Infinite contains open spaces with emphasis on sniping and ranged combat against as many as fifteen enemies at once.', '2013-03-26', '../uploads/capas/capa_6a413ddc2dc533.90265783.jpg', 'https://www.youtube.com/embed/J_gEzOZKyE4?si=RBxaaEP0RFvUT3cj', 'PC, PlayStation 3, Xbox 360', 0, NULL, 10, 0, 0),
	(52, 'Elden Ring', 'FromSoftware', 'Bandai Namco Entertainment', 'Elden Ring is an action RPG developed by FromSoftware and published by Bandai Namco Entertainment, released in February 2022. Directed by Hidetaka Miyazaki, with world-building contributions from novelist George R. R. Martin, the game features an expansive open world called the Lands Between. Players assume the role of a customisable character known as the Tarnished, who must explore this world, battle formidable enemies, and seek to restore the Elden Ring to become the Elden Lord. The game builds on the challenging gameplay mechanics familiar from the Dark Souls series but introduces a more open-ended structure with vast exploration, dynamic weather, and a day-night cycle. It offers deep lore, complex characters, and an interconnected world filled with secrets, dungeons, and powerful bosses.', '2022-02-24', '../uploads/capas/capa_6a413f0275e176.45976025.jpg', 'https://www.youtube.com/embed/MUV5dqaumHE?si=WU0C6g2ZSU3txyBz', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch 2', 0, NULL, 11, 0, 0),
	(53, 'Half-Life', 'Valve', 'Valve', 'Half-Life is a 1998 first-person shooter (FPS) game developed by Valve Corporation and published by Sierra Studios for Windows. It was Valve\'s debut product and the first game in the Half-Life series. The player assumes the role of Gordon Freeman, a theoretical physicist who must escape from the Black Mesa Research Facility after it is overrun by aliens following a disastrous scientific experiment. Its gameplay consists of diverse combat, exploration and puzzles.', '1998-11-19', '../uploads/capas/capa_6a4140a9d496b0.06755940.jpg', 'https://www.youtube.com/embed/5Wavn29LMrs?si=DmcFFnNywSnqFTMp', 'PC', 0, NULL, 12, 0, 0),
	(54, 'Half-Life: Alyx', 'Valve', 'Valve', 'Half-Life: Alyx is Valve’s VR return to the Half-Life series. It’s the story of an impossible fight against a vicious alien race known as the Combine, set between the events of Half-Life and Half-Life 2. Alyx Vance and her father Eli mount an early resistance to the Combine\'s brutal occupation of Earth.', '2020-03-23', '../uploads/capas/capa_6a4140f9664eb5.36322545.jpg', 'https://www.youtube.com/embed/O2W0N3uKXmo?si=wmTbFwGuou_wIrBq', 'PC', 0, NULL, 12, 0, 0),
	(55, 'Subnautica', 'Unknown Worlds Entertainment', 'Unknown Worlds Entertainment', 'Descend into the depths of an alien underwater world filled with wonder and peril. Craft equipment, pilot submarines and out-smart wildlife to explore lush coral reefs, volcanoes, cave systems, and more, all while trying to survive.', '2018-01-23', '../uploads/capas/capa_6a4144e650cab6.40077464.jpg', 'https://www.youtube.com/embed/Rz2SNm8VguE?si=Q9RGsCfOoN4pYKR0', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch 2, Mobile', 0, NULL, 13, 0, 0),
	(56, 'Subnautica: Below Zero', 'Unknown Worlds Entertainment', 'Unknown Worlds Entertainment', 'Dive into a freezing underwater adventure on an alien planet. Below Zero is set two years after the original Subnautica. Return to Planet 4546B to uncover the truth behind a deadly cover-up. Survive by building habitats, crafting tools, & diving deeper into the world of Subnautica.', '2021-03-13', '../uploads/capas/capa_6a4145859069f2.99783443.jpg', 'https://www.youtube.com/embed/rdix1XxaZyU?si=NAOTFuOLKnMpMb8C', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch 2, Nintendo Switch, Mobile', 0, NULL, 13, 0, 0),
	(57, 'Persona 5 Strikers', 'Omega Force, P-Studio', 'Sega', 'Persona 5 Strikers is a crossover between Koei Tecmo\'s hack and slash Dynasty Warriors series and Atlus\'s turn-based role-playing game Persona series. As a result, it features gameplay elements from both, such as the real-time action combat of the former with the turn-based Persona-battling aspect of the latter. The game is set six months after the events of Persona 5, and follows Joker and the rest of the Phantom Thieves of Hearts as they end up in a mysterious version of Tokyo filled with supernatural enemies.', '2020-02-20', '../uploads/capas/capa_6a414848d29e62.54489259.jpg', 'https://www.youtube.com/embed/wTp_q76UWBo?si=s4xY1A16UIbLyCki', 'PC, PlayStation 4, Nintendo Switch', 0, NULL, 14, 0, 0),
	(58, 'Persona 5 Tactica', 'P-Studio', 'Sega', 'After a strange incident, the Phantom Thieves wander into a bizarre realm where its citizens are living under tyrannical oppression. Surrounded by a military group named Legionnaires, they find themselves in grave danger until a mysterious revolutionary named Erina rescues them and offers an enticing deal in exchange for their help. What truth lies behind Erina and the deal she offers to the Phantom Thieves.', '2023-11-17', '../uploads/capas/capa_6a4148fd93ac91.74061144.jpg', 'https://www.youtube.com/embed/Z5aBbuInWvs?si=OeonpISbIR8N0ToQ', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch', 0, NULL, 14, 0, 0),
	(59, 'God of War Ragnarök', 'Santa Monica Studio', 'Sony Interactive Entertainment', 'God of War: Ragnarök is the ninth installment in the God of War series and the sequel to 2018\'s God of War. Continuing with the Norse mythology theme, the game is set in ancient Norway and features series protagonists Kratos, the former Greek God of War, and his young son Atreus. The game kicked off the events of Ragnarök, where Kratos and Atreus must journey to each of the Nine Realms in search of answers as they prepare for the prophesied battle that will end the world.', '2022-11-09', '../uploads/capas/capa_6a414a737534a6.78948351.jpg', 'https://www.youtube.com/embed/EYIuLO-BzB8?si=iRO6uQmOpApD8KZX', 'PC, PlayStation 5, PlayStation 4', 0, NULL, 15, 0, 0),
	(60, 'Monster Hunter: World', 'Capcom', 'Capcom', 'Welcome to a new world! Take on the role of a hunter and slay ferocious monsters in a living, breathing ecosystem where you can use the landscape and its diverse inhabitants to get the upper hand. Hunt alone or in co-op with up to three other players, and use materials collected from fallen foes to craft new gear and take on even bigger, badder beasts!\r\n\r\n', '2018-01-26', '../uploads/capas/capa_6a414b80c0f0f7.01388622.jpg', 'https://www.youtube.com/embed/OotQrKEqe94?si=_-TygcVa0vUbRgIU', 'PC, PlayStation 4, Xbox One', 0, NULL, 16, 0, 0),
	(61, 'Monster Hunter Rise', 'Capcom', 'Capcom', 'Rise to the challenge and join the hunt! In Monster Hunter Rise, the latest installment in the award-winning and top-selling Monster Hunter series, you’ll become a hunter, explore brand new maps and use a variety of weapons to take down fearsome monsters as part of an all-new storyline.\r\n\r\n', '2021-03-26', '../uploads/capas/capa_6a414bf2cf2f80.76915237.jpg', 'https://www.youtube.com/embed/a6C5lH5b-f4?si=nfU0aynNsHg-TAaj', 'PC, PlayStation 5, PlayStation 4, Xbox Series X/S, Xbox One, Nintendo Switch', 0, NULL, 16, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.jogo_do_ano: ~0 rows (aproximadamente)
INSERT INTO `jogo_do_ano` (`id_jogo_ano`, `id_jogo`, `ano`, `num_votos`) VALUES
	(1, 21, 2026, 0),
	(2, 2, 2026, 0),
	(8, 18, 2019, 1),
	(9, 6, 2019, 0),
	(10, 4, 2019, 0),
	(14, 12, 2018, 1),
	(15, 26, 2026, 2),
	(17, 45, 2025, 1);

-- A despejar estrutura para tabela playscore.jogo_genero
CREATE TABLE IF NOT EXISTS `jogo_genero` (
  `id_jogo` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_jogo`,`id_genero`),
  KEY `id_genero` (`id_genero`),
  CONSTRAINT `jogo_genero_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id_jogo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jogo_genero_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.jogo_genero: ~36 rows (aproximadamente)
INSERT INTO `jogo_genero` (`id_jogo`, `id_genero`) VALUES
	(2, 1),
	(3, 1),
	(4, 1),
	(7, 1),
	(11, 1),
	(12, 1),
	(15, 1),
	(17, 1),
	(21, 1),
	(26, 1),
	(27, 1),
	(30, 1),
	(31, 1),
	(36, 1),
	(37, 1),
	(41, 1),
	(45, 1),
	(49, 1),
	(55, 1),
	(56, 1),
	(59, 1),
	(8, 2),
	(9, 2),
	(50, 2),
	(51, 2),
	(53, 2),
	(54, 2),
	(5, 3),
	(6, 3),
	(10, 3),
	(19, 3),
	(34, 3),
	(38, 3),
	(40, 3),
	(42, 3),
	(43, 3),
	(47, 3),
	(52, 3),
	(57, 3),
	(58, 3),
	(60, 3),
	(61, 3),
	(13, 4),
	(15, 4),
	(18, 4),
	(28, 4),
	(29, 4),
	(44, 4),
	(2, 5),
	(3, 5),
	(4, 5),
	(5, 5),
	(21, 5),
	(26, 5),
	(30, 5),
	(31, 5),
	(37, 5),
	(38, 5),
	(41, 5),
	(42, 5),
	(43, 5),
	(47, 5),
	(52, 5),
	(55, 5),
	(56, 5),
	(57, 5),
	(59, 5),
	(60, 5),
	(61, 5),
	(1, 6),
	(11, 6),
	(12, 6),
	(15, 6),
	(16, 6),
	(18, 6),
	(45, 6),
	(49, 6),
	(10, 7),
	(14, 7),
	(20, 7),
	(33, 7),
	(36, 7),
	(2, 8),
	(55, 8),
	(56, 8),
	(32, 9),
	(39, 9),
	(35, 10),
	(48, 10),
	(1, 15),
	(14, 15),
	(28, 15),
	(41, 15),
	(20, 18),
	(3, 19),
	(38, 19),
	(47, 19),
	(57, 19),
	(59, 19),
	(38, 24),
	(42, 24),
	(45, 24),
	(47, 24);

-- A despejar estrutura para tabela playscore.lancamentos
CREATE TABLE IF NOT EXISTS `lancamentos` (
  `id_lancamento` int NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `plataformas` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_lancamento`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela playscore.lancamentos: ~21 rows (aproximadamente)
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
	(20, '2026-08-27', 'Metal Gear Solid: Master Collection Vol. 2', 'PC, PS5, Xbox Series X/S, Nintendo Switch, Switch 2');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela playscore.votos_utilizadores_ano: ~0 rows (aproximadamente)
INSERT INTO `votos_utilizadores_ano` (`id_voto`, `id_utilizador`, `id_jogo`, `ano`) VALUES
	(1, 1, 26, 2026),
	(2, 2, 26, 2026),
	(3, 1, 18, 2019),
	(4, 1, 12, 2018),
	(5, 1, 45, 2025);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

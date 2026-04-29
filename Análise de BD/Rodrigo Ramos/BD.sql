CREATE DATABASE jogos_db;
USE jogos_db;

CREATE TABLE Utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_jogos INT,
    avatar_url VARCHAR(255),
    bio TEXT,
    FOREIGN KEY (id_jogos) REFERENCES Jogos(id)
);

CREATE TABLE Generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomes VARCHAR(100) NOT NULL
);

CREATE TABLE Franquias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomes VARCHAR(100),
    descricao TEXT,
    capa_url VARCHAR(255),
    id_jogo INT,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id)
);

CREATE TABLE Jogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomes VARCHAR(150) NOT NULL,
    titulos VARCHAR(150),
    descricao TEXT,
    data DATE,
    capa_url VARCHAR(255),
    classificacao VARCHAR(10),
    id_genero INT,
    id_franquia INT,
    FOREIGN KEY (id_genero) REFERENCES Generos(id),
    FOREIGN KEY (id_franquia) REFERENCES Franquias(id)
);

CREATE TABLE Favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    id_genero INT,
    capa_url VARCHAR(255),
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id),
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id),
    FOREIGN KEY (id_genero) REFERENCES Generos(id)
);

CREATE TABLE Jogo_do_ano (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_jogo INT,
    ano YEAR,
    num_votos INT DEFAULT 0,
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id)
);

CREATE TABLE Lancamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150),
    plataformas VARCHAR(150),
    data DATE
);

CREATE TABLE Jogos_Generos (
    id_jogo INT,
    id_genero INT,
    PRIMARY KEY (id_jogo, id_genero),
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id),
    FOREIGN KEY (id_genero) REFERENCES Generos(id)
);

ALTER TABLE Perfis
ADD id_utilizador INT,
ADD FOREIGN KEY (id_utilizador) REFERENCES Utilizadores(id);
-- Tabela Users
CREATE TABLE Users (
    id_utilizador INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    avatar_url TEXT,
    password_hash TEXT NOT NULL,
    data_registo TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela Generos
CREATE TABLE Generos (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(20) NOT NULL
);

-- Tabela Desenvolvedor
CREATE TABLE Desenvolvedor (
    id_desenvolvedor INT AUTO_INCREMENT PRIMARY KEY,
    data_fundacao DATE
);

-- Tabela Franquias
CREATE TABLE Franquias (
    id_franquia INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    capa_url TEXT
);

-- Tabela Jogos
CREATE TABLE Jogos (
    id_jogo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    data_lancamento DATE,
    capa_url TEXT,
    trailer_url TEXT,
    plataforma TEXT,
    classificacao FLOAT,
    id_desenvolvedor INT,
    id_genero INT,
    id_franquia INT,

    FOREIGN KEY (id_desenvolvedor) REFERENCES Desenvolvedor(id_desenvolvedor),
    FOREIGN KEY (id_genero) REFERENCES Generos(id_genero),
    FOREIGN KEY (id_franquia) REFERENCES Franquias(id_franquia)
);

-- Tabela Favoritos
CREATE TABLE Favoritos (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    capa_url TEXT,
    id_genero INT,
    data_adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_utilizador) REFERENCES Users(id_utilizador),
    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo),
    FOREIGN KEY (id_genero) REFERENCES Generos(id_genero)
);

-- Tabela Lancamentos
CREATE TABLE Lancamentos (
    id_lancamento INT AUTO_INCREMENT PRIMARY KEY,
    data DATE,
    nome VARCHAR(100),
    plataformas VARCHAR(150)
);

-- Tabela Jogo do Ano
CREATE TABLE Jogo_do_Ano (
    id_jogo_ano INT AUTO_INCREMENT PRIMARY KEY,
    id_jogo INT,
    ano INT,
    num_votos INT,

    FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo)
);

-- Tabela Contactos
CREATE TABLE Contactos (
    id_contacto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(150),
    mensagem TEXT
);
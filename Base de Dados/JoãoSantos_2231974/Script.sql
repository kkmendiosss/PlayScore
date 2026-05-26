-- 1. Tabela Franquias
CREATE TABLE Franquias (
    id_franquia INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao TEXT,
    capa VARCHAR(255)
);

-- 2. Tabela Utilizadores
CREATE TABLE Utilizadores (
    id_utilizador INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    bio TEXT,
    avatar VARCHAR(255)
);

-- 3. Tabela Jogos
CREATE TABLE Jogos (
    id_jogo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    descricao TEXT,
    capa VARCHAR(255),
    trailer_url VARCHAR(255),
    data_lancamento DATE,
    desenvolvedor VARCHAR(100),
    editora VARCHAR(100),
    plataforma VARCHAR(255),
    id_franquia INT,
    CONSTRAINT fk_jogo_franquia FOREIGN KEY (id_franquia) REFERENCES Franquia(id_franquia) ON DELETE SET NULL
);

-- 4. Tabela Lancamentos
CREATE TABLE Lancamentos (
    id_lancamento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    data_exata DATE,
    plataforma VARCHAR(100)
);

-- 5. Tabela Contactos
CREATE TABLE Contactos (
    id_contacto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    assunto VARCHAR(50) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 6. Tabela Comentarios
CREATE TABLE Comentarios (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    texto TEXT NOT NULL,
    data_postagem DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_com_utilizador FOREIGN KEY (id_utilizador) REFERENCES Utilizador(id_utilizador) ON DELETE CASCADE,
    CONSTRAINT fk_com_jogo FOREIGN KEY (id_jogo) REFERENCES Jogo(id_jogo) ON DELETE CASCADE
);

-- 7. Tabela Favoritos
CREATE TABLE Favoritos (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    data_adicao DATE DEFAULT (CURRENT_DATE),
    CONSTRAINT fk_fav_utilizador FOREIGN KEY (id_utilizador) REFERENCES Utilizador(id_utilizador) ON DELETE CASCADE,
    CONSTRAINT fk_fav_jogo FOREIGN KEY (id_jogo) REFERENCES Jogo(id_jogo) ON DELETE CASCADE
);

-- 8. Tabela Historico_Jogado
CREATE TABLE Historico_Jogado (
    id_historico INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    CONSTRAINT fk_hist_utilizador FOREIGN KEY (id_utilizador) REFERENCES Utilizador(id_utilizador) ON DELETE CASCADE,
    CONSTRAINT fk_hist_jogo FOREIGN KEY (id_jogo) REFERENCES Jogo(id_jogo) ON DELETE CASCADE
);

-- 9. Tabela Jogo do Ano
CREATE TABLE Jogo_do_Ano (
    id_voto INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    ano INT,
    CONSTRAINT fk_voto_utilizador FOREIGN KEY (id_utilizador) REFERENCES Utilizador(id_utilizador) ON DELETE CASCADE,
    CONSTRAINT fk_voto_jogo FOREIGN KEY (id_jogo) REFERENCES Jogo(id_jogo) ON DELETE CASCADE
);
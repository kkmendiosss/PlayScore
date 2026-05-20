CREATE TABLE UTILIZADOR (
    id_utilizador INT PRIMARY KEY,
    nome_display VARCHAR(120) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    data_registo DATETIME DEFAULT CURRENT_TIMESTAMP,
    biografia TEXT
);


CREATE TABLE JOGO (
    id_jogo INT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    data_lancamento DATE,
    desenvolvedor VARCHAR(255),
    capa_url VARCHAR(255),
    playscore_global DECIMAL(3, 2)
);

CREATE TABLE CATEGORIA (
    id_categoria INT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL
);

CREATE TABLE JOGO_CATEGORIA (
    id_jogo INT,
    id_categoria INT,
    PRIMARY KEY (id_jogo, id_categoria),
    FOREIGN KEY (id_jogo) REFERENCES JOGO(id_jogo),
    FOREIGN KEY (id_categoria) REFERENCES CATEGORIA(id_categoria)
);


CREATE TABLE AVALIACAO (
    id_avaliacao INT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    nota DECIMAL(3, 1),
    comentario_heuristico TEXT,
    data_avaliacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilizador) REFERENCES UTILIZADOR(id_utilizador),
    FOREIGN KEY (id_jogo) REFERENCES JOGO(id_jogo)
);

CREATE TABLE FAVORITO (
    id_utilizador INT,
    id_jogo INT,
    data_adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_utilizador, id_jogo),
    FOREIGN KEY (id_utilizador) REFERENCES UTILIZADOR(id_utilizador),
    FOREIGN KEY (id_jogo) REFERENCES JOGO(id_jogo)
);


CREATE TABLE VOTO_JOGO_ANO (
    id_voto INT PRIMARY KEY,
    id_utilizador INT,
    id_jogo INT,
    ano_edicao TEXT,
    data_voto DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilizador) REFERENCES UTILIZADOR(id_utilizador),
    FOREIGN KEY (id_jogo) REFERENCES JOGO(id_jogo)
);


CREATE TABLE FORMULARIO_FRANQUIA (
    id_pedido INT PRIMARY KEY,
    nome_investidor VARCHAR(255),
    email_contacto VARCHAR(255),
    modelo_desejado VARCHAR(255),
    localizacao_alvo VARCHAR(255),
    data_submissao DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado_pedido VARCHAR(50)
);


CREATE TABLE TICKET_CONTACTOS (
    id_ticket INT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    assunto VARCHAR(255),
    mensagem TEXT,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(50)
);

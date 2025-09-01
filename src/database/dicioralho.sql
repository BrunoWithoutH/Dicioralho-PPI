-- Script de Criação da database do Dicioralho para PostgreSQL

-- CREATE DATABASE dicioralho;
-- \c dicioralho;

CREATE TABLE usuarios (
    idusuario VARCHAR(12) PRIMARY KEY UNIQUE,
    nomeusuario VARCHAR(255) NOT NULL,
    emailusuario VARCHAR(255) NOT NULL,
    senhausuario VARCHAR(255) NOT NULL,
    registrousuario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    instituicaousuario VARCHAR(255),
    documentousuario BYTEA,
    matriculausuario VARCHAR(50),
    nivelusuario INT DEFAULT 0,
    statususuario VARCHAR(20) CHECK (statususuario IN ('ativo', 'pendente', 'desativado')) DEFAULT 'pendente'
);

CREATE TABLE palavras (
    idpalavra VARCHAR(12) PRIMARY KEY,
    idprofessor VARCHAR(12) NOT NULL,
    idusuario VARCHAR(12) NOT NULL,
    idtarefa VARCHAR(16),
    nomepalavra VARCHAR(255) NOT NULL,
    descpalavra TEXT NOT NULL,
    categoria VARCHAR(50),
    tagspalavra VARCHAR(255),
    avaliacaopalavra INT CHECK (avaliaçãopalavra BETWEEN 0 AND 100),

    dataregistropalavra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statuspalavra VARCHAR(20) CHECK (statususuario IN ('ativo', 'pendente', 'desativado')) DEFAULT 'pendente',
    FOREIGN KEY idusuario REFERENCES usuarios(idusuario) ON DELETE CASCADE
);
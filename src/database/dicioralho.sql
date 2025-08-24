-- Script de Criação da database do Dicioralho para PostgreSQL

CREATE DATABASE dicioralho;
\c dicioralho;

CREATE TABLE usuarios (
    id VARCHAR(12) PRIMARY KEY UNIQUE,
    nomeusuario VARCHAR(255) NOT NULL,
    emailusuario VARCHAR(255) NOT NULL UNIQUE,
    senhausuario VARCHAR(255) NOT NULL,
    registrousuario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    instituicaousuario VARCHAR(255) NOT NULL,
    documentousuario VARCHAR(255) NOT NULL,
    matriculausuario VARCHAR(50) NOT NULL UNIQUE,
    nivelusuario VARCHAR(20) NOT NULL CHECK (nivelusuario IN ('administrador', 'professor', 'aluno', 'user')),
    statususuario VARCHAR(20) DEFAULT 'ativo';
);

CREATE TABLE palavras (
    id VARCHAR(12) PRIMARY KEY,
    nomepalavra VARCHAR(255) NOT NULL,
    descpalavra TEXT NOT NULL,
    categoria VARCHAR(50),
    registrousuario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,


    statuspalavra VARCHAR(20) DEFAULT 'ativa',
    usuario_id VARCHAR(12) REFERENCES usuarios(id) ON DELETE CASCADE
);
CREATE DATABASE labs;

USE labs;

CREATE TABLE laboratorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE professores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laboratorio_id INT NOT NULL,
    professor_id INT NOT NULL,
    turma_id INT NOT NULL,
    data DATE NOT NULL,
    inicio TIME NOT NULL,
    fim TIME NOT NULL,
    atividade VARCHAR(200) NOT NULL
);

INSERT INTO laboratorios (nome) VALUES
('Lab 1'),
('Lab 2'),
('Lab 3'),
('Lab 4'),
('Lab 5'),
('Lab 6');

INSERT INTO professores (nome) VALUES
('Willians'),
('Meire'),
('Oswaldo'),
('José'),
('Calixto'),
('Patricia'),
('Ivan'),
('Claudio'),
('Augusto');

INSERT INTO turmas (nome) VALUES
('1MAD-N'),
('2MAD-N'),
('3MAD-N'),
('1MDS-N'),
('2MDS-N'),
('3MDS-N'),
('1FARM-N'),
('2FARM-N'),
('3FARM-N');

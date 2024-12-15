CREATE DATABASE meu_banco_de_dados;
USE meu_banco_de_dados;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100)
);

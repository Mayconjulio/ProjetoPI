
CREATE DATABASE sistema_login;

USE sistema_login;

-- Criar tabela gastos
CREATE TABLE gastos (
  id INT(11) NOT NULL,
  user_id INT(11) NOT NULL,
  gasto DECIMAL(10,2) NOT NULL,
  data_gasto DATE NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  categoria VARCHAR(50) NOT NULL,
  descricao TEXT DEFAULT NULL
);

-- Criar tabela usuarios
CREATE TABLE usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  admin TINYINT(1) DEFAULT 0
);


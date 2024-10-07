-- Criação do banco de dados  
CREATE DATABASE bancodedados;  

-- Selecionar o banco de dados  
USE bancodedados;  

-- Criação da tabela gastos  
CREATE TABLE gastos (  
    id INT AUTO_INCREMENT PRIMARY KEY,  
    valor DECIMAL(10, 2),  
    data_gasto DATE,  
    categoria VARCHAR(255),  
    descricao TEXT,  
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);
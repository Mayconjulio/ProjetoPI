
CREATE DATABASE sistema_login;

USE sistema_login;

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gasto` decimal(10,2) NOT NULL,
  `data_gasto` date NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) 

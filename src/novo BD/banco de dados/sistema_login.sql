-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/11/2024 às 22:59
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_login`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gasto` varchar(255) NOT NULL,
  `data_gasto` date NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `gastos`
--

INSERT INTO `gastos` (`id`, `user_id`, `gasto`, `data_gasto`, `preco`, `categoria`, `descricao`) VALUES
(5, 4, '12m', '2024-11-15', 1234.00, 'Saúde', 'vfuodd'),
(8, 2, 'blabla', '2005-02-12', 699563.00, 'Transporte', 'hhdkv,bn.svjn ljn');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `admin`) VALUES
(1, 'adm', 'adm@gmail.com', '$2y$10$qrOnfKKDN3qjvWSnn4SFWeSnRgKOT7mUB3e95ARg9GAjJ7gZs671i', 0),
(2, 'maycon', 'jabasplay34@gmail.com', '$2y$10$RMsLCQdeJYtI7SHHKaLS/OX1nPKIzBIL3n4s9g.BlXauLdhzrnBcK', 0),
(3, 'teste', 'test@gmail.com', '$2y$10$d.TAFeK9OSXzJs1zfzEYT.pkZmlv4P/P.plEglXQaXyc73wgkx.C6', 0),
(4, 'luis', 'luis@gmail.com', '$2y$10$BinxHvfsHZim2o1ykWfhrecgG7fib9OqohXIz9TWYCqsL87cvBhhe', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

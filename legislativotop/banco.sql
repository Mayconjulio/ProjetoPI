-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 30-Jul-2022 às 13:24
-- Versão do servidor: 5.7.39
-- versão do PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `testedb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` text NOT NULL,
  `senha` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `senha`) VALUES
(1, 'admin', '$2y$10$BwTomx79gKS4fm34lenm0OHXb2wcGEJk.V/55/0KjSy68sxNnAtvC');

-- --------------------------------------------------------

--
-- Estrutura da tabela `anotacoes`
--

CREATE TABLE `anotacoes` (
  `id` int(11) NOT NULL,
  `anota` text NOT NULL,
  `idvereador` int(11) NOT NULL,
  `datan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `calendario`
--

CREATE TABLE `calendario` (
  `idc` int(11) NOT NULL,
  `idvereador` int(11) NOT NULL,
  `evento` text NOT NULL,
  `dataev` text NOT NULL,
  `hora` time NOT NULL,
  `obs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `camconfig`
--

CREATE TABLE `camconfig` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `nomee` text NOT NULL,
  `logo` text NOT NULL,
  `cormenu` text NOT NULL,
  `corexibidor` text NOT NULL,
  `cortxtexibidor` text NOT NULL,
  `corgeral` text NOT NULL,
  `discurso` int(11) NOT NULL,
  `aparte` int(11) NOT NULL,
  `qordem` int(11) NOT NULL,
  `cfinal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `camconfig`
--

INSERT INTO `camconfig` (`id`, `nome`, `nomee`, `logo`, `cormenu`, `corexibidor`, `cortxtexibidor`, `corgeral`, `discurso`, `aparte`, `qordem`, `cfinal`) VALUES
(1, 'Nome Camara', 'Nome Casa', 'https://legislativo.top/completo/assets/logo.png', 'yellow', 'Black', 'White', '#1E90FF', 4, 1, 0, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comissoesp`
--

CREATE TABLE `comissoesp` (
  `id` int(11) NOT NULL,
  `comissao` text NOT NULL,
  `nomes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `debates`
--

CREATE TABLE `debates` (
  `id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `nome` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `discurso`
--

CREATE TABLE `discurso` (
  `id` int(11) NOT NULL,
  `idvotacao` int(11) NOT NULL,
  `vereador` int(11) NOT NULL,
  `inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fim` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `duvidasfrequentes`
--

CREATE TABLE `duvidasfrequentes` (
  `id` int(11) NOT NULL,
  `duvida` text NOT NULL,
  `resposta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `enquetes`
--

CREATE TABLE `enquetes` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  `categoria` text NOT NULL,
  `inicio` text NOT NULL,
  `fim` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gastos`
--

CREATE TABLE `gastos` (
  `idgasto` int(11) NOT NULL,
  `quemgastou` text NOT NULL,
  `valgasto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `indica`
--

CREATE TABLE `indica` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `likesdebate`
--

CREATE TABLE `likesdebate` (
  `id` int(11) NOT NULL,
  `userid` text COLLATE utf8_unicode_ci NOT NULL,
  `reaction` text COLLATE utf8_unicode_ci NOT NULL,
  `opid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `de` text COLLATE utf8_unicode_ci NOT NULL,
  `para` text COLLATE utf8_unicode_ci NOT NULL,
  `titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `msg` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesadir`
--

CREATE TABLE `mesadir` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `cargo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mocoes`
--

CREATE TABLE `mocoes` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelos`
--

CREATE TABLE `modelos` (
  `model_id` int(11) NOT NULL,
  `idenquete` int(11) NOT NULL,
  `nome` text NOT NULL,
  `img` text NOT NULL,
  `votos` int(11) NOT NULL,
  `votospovo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordemdodia`
--

CREATE TABLE `ordemdodia` (
  `id` int(11) NOT NULL,
  `ordem` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `povo`
--

CREATE TABLE `povo` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reqcidadao`
--

CREATE TABLE `reqcidadao` (
  `id` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `telefone` text NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reqs`
--

CREATE TABLE `reqs` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessoes`
--

CREATE TABLE `sessoes` (
  `id` int(11) NOT NULL,
  `sessao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tvcamara`
--

CREATE TABLE `tvcamara` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `presidente` int(11) NOT NULL,
  `nome` text NOT NULL,
  `usuario` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `foto` text NOT NULL,
  `partido` text NOT NULL,
  `sigla` text NOT NULL,
  `endereco` text NOT NULL,
  `sobre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `usuario` text NOT NULL,
  `enqueteid` int(11) NOT NULL,
  `modelo` text NOT NULL,
  `hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `votospovo`
--

CREATE TABLE `votospovo` (
  `id` int(11) NOT NULL,
  `idenquete` int(11) NOT NULL,
  `quemvotou` int(11) NOT NULL,
  `nome` text NOT NULL,
  `voto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `votospr`
--

CREATE TABLE `votospr` (
  `id` int(11) NOT NULL,
  `quemvotou` int(11) NOT NULL,
  `votado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`idc`);

--
-- Índices para tabela `camconfig`
--
ALTER TABLE `camconfig`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `comissoesp`
--
ALTER TABLE `comissoesp`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `debates`
--
ALTER TABLE `debates`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `discurso`
--
ALTER TABLE `discurso`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `duvidasfrequentes`
--
ALTER TABLE `duvidasfrequentes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `enquetes`
--
ALTER TABLE `enquetes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`idgasto`);

--
-- Índices para tabela `indica`
--
ALTER TABLE `indica`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `likesdebate`
--
ALTER TABLE `likesdebate`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mesadir`
--
ALTER TABLE `mesadir`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mocoes`
--
ALTER TABLE `mocoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`model_id`);

--
-- Índices para tabela `ordemdodia`
--
ALTER TABLE `ordemdodia`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `povo`
--
ALTER TABLE `povo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `reqcidadao`
--
ALTER TABLE `reqcidadao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `reqs`
--
ALTER TABLE `reqs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sessoes`
--
ALTER TABLE `sessoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tvcamara`
--
ALTER TABLE `tvcamara`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `votospovo`
--
ALTER TABLE `votospovo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `calendario`
--
ALTER TABLE `calendario`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `camconfig`
--
ALTER TABLE `camconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `comissoesp`
--
ALTER TABLE `comissoesp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `debates`
--
ALTER TABLE `debates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `discurso`
--
ALTER TABLE `discurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `duvidasfrequentes`
--
ALTER TABLE `duvidasfrequentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gastos`
--
ALTER TABLE `gastos`
  MODIFY `idgasto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `indica`
--
ALTER TABLE `indica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `likesdebate`
--
ALTER TABLE `likesdebate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mesadir`
--
ALTER TABLE `mesadir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mocoes`
--
ALTER TABLE `mocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `modelos`
--
ALTER TABLE `modelos`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ordemdodia`
--
ALTER TABLE `ordemdodia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `povo`
--
ALTER TABLE `povo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reqcidadao`
--
ALTER TABLE `reqcidadao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reqs`
--
ALTER TABLE `reqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sessoes`
--
ALTER TABLE `sessoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tvcamara`
--
ALTER TABLE `tvcamara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `votospovo`
--
ALTER TABLE `votospovo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

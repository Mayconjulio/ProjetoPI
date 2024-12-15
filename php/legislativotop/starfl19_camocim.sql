-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 11/12/2024 às 14:06
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `starfl19_camocim`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `calendario`
--

CREATE TABLE `calendario` (
  `idc` int(11) NOT NULL,
  `evento` text NOT NULL,
  `dataev` date NOT NULL,
  `hora` time NOT NULL,
  `obs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comissoesp`
--

CREATE TABLE `comissoesp` (
  `id` int(11) NOT NULL,
  `comissao` text NOT NULL,
  `nomes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `debates`
--

CREATE TABLE `debates` (
  `id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `nome` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `discurso`
--

CREATE TABLE `discurso` (
  `id` int(11) NOT NULL,
  `idvotacao` int(11) NOT NULL,
  `vereador` int(11) NOT NULL,
  `inicio` datetime NOT NULL,
  `fim` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `discurso`
--

INSERT INTO `discurso` (`id`, `idvotacao`, `vereador`, `inicio`, `fim`, `status`, `tipo`) VALUES
(10, 1, 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'discurso'),
(11, 1, 31, '2021-11-24 08:47:58', '1969-12-31 21:04:00', 2, 'discurso'),
(12, 1, 22, '2021-11-24 08:50:21', '1969-12-31 21:04:00', 2, 'discurso');

-- --------------------------------------------------------

--
-- Estrutura para tabela `duvidasfrequentes`
--

CREATE TABLE `duvidasfrequentes` (
  `id` int(11) NOT NULL,
  `duvida` text NOT NULL,
  `resposta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enquetes`
--

CREATE TABLE `enquetes` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  `inicio` text NOT NULL,
  `fim` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `enquetes`
--

INSERT INTO `enquetes` (`id`, `titulo`, `descricao`, `inicio`, `fim`) VALUES
(1, 'projeto 01', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gastos`
--

CREATE TABLE `gastos` (
  `idgasto` int(11) NOT NULL,
  `quemgastou` text NOT NULL,
  `valgasto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `gastos`
--

INSERT INTO `gastos` (`idgasto`, `quemgastou`, `valgasto`) VALUES
(1, '22', 5000);

-- --------------------------------------------------------

--
-- Estrutura para tabela `indica`
--

CREATE TABLE `indica` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `likesdebate`
--

CREATE TABLE `likesdebate` (
  `id` int(11) NOT NULL,
  `userid` text COLLATE utf8_unicode_ci NOT NULL,
  `reaction` text COLLATE utf8_unicode_ci NOT NULL,
  `opid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
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
-- Estrutura para tabela `mesadir`
--

CREATE TABLE `mesadir` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `cargo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mocoes`
--

CREATE TABLE `mocoes` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelos`
--

CREATE TABLE `modelos` (
  `model_id` int(11) NOT NULL,
  `idenquete` int(11) NOT NULL,
  `nome` text NOT NULL,
  `img` text NOT NULL,
  `votos` int(11) NOT NULL,
  `votospovo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `modelos`
--

INSERT INTO `modelos` (`model_id`, `idenquete`, `nome`, `img`, `votos`, `votospovo`) VALUES
(10, 1, 'A Favor', 'afavor.png', 1, 0),
(11, 1, 'Contra', 'contra.png', 1, 0),
(12, 1, 'Abster', 'abster.png', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordemdodia`
--

CREATE TABLE `ordemdodia` (
  `id` int(11) NOT NULL,
  `ordem` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `povo`
--

CREATE TABLE `povo` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `povo`
--

INSERT INTO `povo` (`id`, `nome`, `email`) VALUES
(17, 'Jonathan', '123456');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reqcidadao`
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
-- Estrutura para tabela `reqs`
--

CREATE TABLE `reqs` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tvcamara`
--

CREATE TABLE `tvcamara` (
  `id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
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

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `presidente`, `nome`, `usuario`, `email`, `senha`, `foto`, `partido`, `sigla`, `endereco`, `sobre`) VALUES
(22, 0, 'teste', 'teste', 'teste@live.com', '$2y$10$dMBH/yNfKKNpkTSpSg5Jb.L8wrhZi9pBgvK.Xt5Lqg7l4kAAWKqh2', '', '', '', '', ''),
(23, 1, 'Edimilson Gomes de Souza', 'Presidente', '', '$2y$10$Nq44rA2eRz3uiIS76pgrX.3p0BOwjutieSjvFTGFBXragv3r2k63a', '1637684492P3Ihci9cxha0Vaxn7NisHvxYzIvpu6.jpeg', 'PSD', 'PSD', '', ''),
(24, 0, 'José João de Moraes', 'Vice Presidente', '', '$2y$10$Cxhh13qX6tywp6d1fFCgMergdOKp246y9KvJK.iVtr7A2tCNcNIJi', '1637685572UwHFcC7KgDKOfvLM9GVfsl1sG0fjIY.jpeg', 'PSD', 'PSD', '', ''),
(25, 0, 'Ewerton Thiago Amador Monteiro', '1 secretario', '', '$2y$10$aAG06vWut.hxi1oR02g9Q.NJDIVuqPTqnLZ7sX/h6z/eg4vl4xula', '1637686090MOtqV9hmCO1R3DSIDd8QN4ALtFxtn5.jpeg', 'PSB', 'PSB', '', ''),
(26, 0, 'Antônio Carvalho dos Santos ', '2 secretário', '', '$2y$10$MDuqDQgKraCOcxYnUe0Ir.00gKh4TE6JhClqXADGXVN5fYWSQnxEK', '1637686337sYXDHYZEtGXhXwjXSUbgaYHlNoklCY.jpeg', 'PSD', 'PSD', '', ''),
(27, 0, 'Vandeilson Manoel dos santos', 'Vandeilson', '', '$2y$10$admsvMJMoym1FKIgbYJq3.QvslZtj3.nIj156OidtO3Z7vK/dCM6y', '1637686617dvdP9i2h9Af5rPJ3OwuZjWwUoXPrwE.jpeg', 'PSD', 'PSD', '', ''),
(28, 0, 'teste2', 'teste2', 'teste2@live.com', '$2y$10$66AlaEhoWel6Lxpo5snSrukCYN0/liRmk6yfgD5Ua6fHVwRXBBNUq', '', '', '', '', ''),
(29, 0, 'teste3', 'teste3', 'teste3@live.com', '$2y$10$IdMd2QyEDkfA97YqXLECG.O30EWLtprxTXmWiqFNhN3Iz0BiYhXt6', '', '', '', '', ''),
(30, 0, 'Emanuel Caetano de Meneses', 'Emanuel ', '', '$2y$10$4iIYIDnANULNFZxJoLyZ.eVH4Gt6dBocJc4EJ.fgA8503FvZgZlIC', '1637687726sGnFJrfmicz09KO7axqcKnbreGM8M6.jpeg', 'PR', 'PR', '', ''),
(31, 0, 'Sivaldo João da Silva', 'Sivaldo', '', '$2y$10$xu8TC5wRo4Z/iD9dl9ZIeOBw9aP6G.Qtr245g5FEQHEsajvY7dKKq', '16376880442PUdAskRrsDFA9pLz25qdSfXIj3L6T.jpeg', 'PSD', 'PSD', '', ''),
(32, 0, 'Manoel Fernandito do Nascimento', 'Manoel', '', '$2y$10$MsHATcyTcpmyyO83/hIPaOAXSCsqYPWrYnjzc0Lm6uhCxP04sstCi', '1637688505r6g26WgDOZRnKruVX75lMyRXp17HGE.jpeg', 'PSD', 'PSD', '', ''),
(33, 0, 'Tiago Anderson de Moura França', 'Tiago', '', '$2y$10$Fzm/aAzDDRg.b0h9SIRpMed/J.aDVge34lE1vWUxczbHChbxdC1xW', '1637688616Cc3aQiyLxhf8jTXXXIv9pcedQp7Qtr.jpeg', 'PR', 'PR', '', ''),
(34, 0, 'José Reginaldo Souza Silva', 'José', '', '$2y$10$XWXGiFuWmmqTIdi6.apbt.zJiKJxKwdtnOtdStkxRSAQkrTg1arca', '1637688742Ru49VmqaJ9UGYGYp8Y8cagAYdQ02Sk.jpeg', '', '', '', ''),
(35, 0, 'Luciano José da Silva Assis', 'Luciano', '', '$2y$10$lJwAus9vnlSxtX4wbhs0Yew3Rj8kLUi261PlUJbd7quXZ6SUO9bWq', '16376889825lnFDDe41BfQHvpAsExcTzNsnADYXL.jpeg', 'PR', 'PR', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `usuario` text NOT NULL,
  `enqueteid` int(11) NOT NULL,
  `modelo` text NOT NULL,
  `hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `votos`
--

INSERT INTO `votos` (`id`, `nome`, `usuario`, `enqueteid`, `modelo`, `hora`) VALUES
(11, 'teste', 'teste', 1, 'A Favor', '2021-11-23 16:08:10'),
(12, 'teste2', 'teste2', 1, 'Contra', '2021-11-24 11:46:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `votospovo`
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
-- Estrutura para tabela `votospr`
--

CREATE TABLE `votospr` (
  `id` int(11) NOT NULL,
  `quemvotou` int(11) NOT NULL,
  `votado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `votospr`
--

INSERT INTO `votospr` (`id`, `quemvotou`, `votado`) VALUES
(0, 22, 23);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`idc`);

--
-- Índices de tabela `comissoesp`
--
ALTER TABLE `comissoesp`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `debates`
--
ALTER TABLE `debates`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `discurso`
--
ALTER TABLE `discurso`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `duvidasfrequentes`
--
ALTER TABLE `duvidasfrequentes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `enquetes`
--
ALTER TABLE `enquetes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`idgasto`);

--
-- Índices de tabela `indica`
--
ALTER TABLE `indica`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `likesdebate`
--
ALTER TABLE `likesdebate`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mesadir`
--
ALTER TABLE `mesadir`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mocoes`
--
ALTER TABLE `mocoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`model_id`);

--
-- Índices de tabela `ordemdodia`
--
ALTER TABLE `ordemdodia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `povo`
--
ALTER TABLE `povo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reqcidadao`
--
ALTER TABLE `reqcidadao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reqs`
--
ALTER TABLE `reqs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tvcamara`
--
ALTER TABLE `tvcamara`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices de tabela `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `votospovo`
--
ALTER TABLE `votospovo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `calendario`
--
ALTER TABLE `calendario`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `duvidasfrequentes`
--
ALTER TABLE `duvidasfrequentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `enquetes`
--
ALTER TABLE `enquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `gastos`
--
ALTER TABLE `gastos`
  MODIFY `idgasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `ordemdodia`
--
ALTER TABLE `ordemdodia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `povo`
--
ALTER TABLE `povo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT de tabela `tvcamara`
--
ALTER TABLE `tvcamara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `votospovo`
--
ALTER TABLE `votospovo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

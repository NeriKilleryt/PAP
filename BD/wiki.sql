-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Maio-2025 às 13:41
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wiki`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `armazem`
--

CREATE TABLE `armazem` (
  `pin` int(255) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Localizacao` varchar(255) DEFAULT NULL,
  `Id_Loja` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `armazem`
--

INSERT INTO `armazem` (`pin`, `Nome`, `Localizacao`, `Id_Loja`) VALUES
(1, 'Armazém A', 'Zona Industrial 1', 1),
(2, 'Armazém B', 'Zona Industrial 2', 2),
(30, 'Armazém Z', 'Zona Industrial 30', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `Funcao` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `Funcao`, `imagem`) VALUES
(1, 'Furadeira\r\n', 'Perfurar materiais', 'uploads/transferir (4).jpg\r\n\r\n'),
(2, 'Chave-fenda', 'Apertar parafusos', 'uploads/transferir.png'),
(3, 'Martelo', 'Ferramenta para bater pregos', 'uploads/transferir (5).jpg'),
(4, 'Serra', 'Cortar materiais diversos', 'uploads/transferir.jpg'),
(5, 'Alicate', ' agarrar, segurar e cortar fios e cabos, seja em materiais macios ou mais resistentes.', 'uploads/Alicate.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ferramentas`
--

CREATE TABLE `ferramentas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `idCategoria` int(255) NOT NULL,
  `idMarca` int(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `loja1_nome` varchar(255) DEFAULT NULL,
  `loja1_link` varchar(255) DEFAULT NULL,
  `loja2_nome` varchar(255) DEFAULT NULL,
  `loja2_link` varchar(255) DEFAULT NULL,
  `loja3_nome` varchar(255) DEFAULT NULL,
  `loja3_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ferramentas`
--

INSERT INTO `ferramentas` (`id`, `nome`, `descricao`, `idCategoria`, `idMarca`, `imagem`, `loja1_nome`, `loja1_link`, `loja2_nome`, `loja2_link`, `loja3_nome`, `loja3_link`) VALUES
(1, 'Martelo', 'O martelo é uma ferramenta usada na indústria para golpear objetos.', 3, 4, 'uploads/Martelo.jpg', 'Leroy Merlin', 'https://www.leroymerlin.pt/produtos/ferramentas/ferramentas-de-mao/martelos/', 'Aury Mat', 'https://aurymat.com/categoria-produto/ferramentas-bricolage-e-construcao/ferramentas-de-pedreiro/martelos/', 'Worten', 'https://www.worten.pt/bricolage/ferramentas/ferramentas-manuais/martelos'),
(2, 'Alicate', 'O alicate é uma ferramenta articulada usada para multiplicar a força aplicada pelo usuário.', 5, 2, 'uploads/Alicate.jpg', 'Ferramentas', 'https://ferramentas.pt/ferramentas/ferramentas/alicates', 'Leroy Merlin', 'https://www.leroymerlin.pt/produtos/ferramentas/ferramentas-de-mao/alicates-e-turqueses/', 'Worten', 'https://www.worten.pt/bricolage/ferramentas/ferramentas-manuais/alicates'),
(3, 'Chave de Fendas', 'A chave de fendas é uma ferramenta usada para apertar ou soltar parafusos.', 2, 3, 'uploads/Chave de Fendas.jpg', 'Leroy Merlin', 'https://www.leroymerlin.pt/search?q=chave+de+fendas', 'Worten', 'https://www.worten.pt/search?query=chave+de+fendas', 'Aki', 'https://www.aki.pt/ferramentas/ferramentas-manuais/chaves-de-fendas'),
(4, 'Furadeira', 'Furar quase todos os tipos de materiais de construção.', 1, 4, 'uploads/transferir (4).jpg', 'Worten', 'https://www.worten.pt/search?query=furadeira', 'Leroy Merlin', 'https://www.leroymerlin.pt/search?q=furadeira&autocomplete=top', 'Ferramentas', 'https://ferramentas.pt/catalogsearch/result/?q=furadeira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja`
--

CREATE TABLE `loja` (
  `ID` int(255) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Morada` varchar(255) DEFAULT NULL,
  `Contacto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `loja`
--

INSERT INTO `loja` (`ID`, `Nome`, `Morada`, `Contacto`) VALUES
(1, 'Leroy Merlin', 'Av. da Bélgica, Est, Nac. 2 Km 170 550, 3510-159 Viseu', '21 194 4944'),
(2, 'Worten', 'Av. da Bélgica 150 ', '21 015 5222'),
(30, 'Ferramentas', 'R. Virgílio Correia 14B, 1600-223 Lisboa', '21 226 7000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

CREATE TABLE `marca` (
  `ID` int(255) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Morada` varchar(255) DEFAULT NULL,
  `Contacto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`ID`, `Nome`, `Morada`, `Contacto`) VALUES
(1, 'WUrth', NULL, '911111111'),
(2, 'DeWalt', NULL, '922222222'),
(3, 'Wurth', NULL, '933333333'),
(4, 'Bellota', NULL, '218268474');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `Id` int(255) NOT NULL,
  `ean` varchar(255) DEFAULT NULL,
  `Preco_Ferramenta` varchar(255) DEFAULT NULL,
  `Nome_Marca` varchar(255) DEFAULT NULL,
  `Texto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `mensagem`
--

INSERT INTO `mensagem` (`Id`, `ean`, `Preco_Ferramenta`, `Nome_Marca`, `Texto`) VALUES
(2, 'EAN001', '19.99', '1', 'Promoção especial no martelo!'),
(3, 'EAN002', '129.99', '2', 'Desconto na serra elétrica!'),
(4, 'EAN001', '9.99', '3', 'Nova chave Philips disponível!'),
(5, 'EAN030', '45.99', '30', 'Últimas unidades da broca de titânio!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `nome`, `email`, `mensagem`, `data_envio`) VALUES
(1, 'loiro', 'loiro@gmail.com', 'gay', '2025-04-03 14:17:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `ID` int(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Data_nascimento` date DEFAULT current_timestamp(),
  `Contacto` varchar(255) DEFAULT NULL,
  `Perfil` tinyint(4) DEFAULT NULL COMMENT '1 = admin; 2 = utilizador; 3 = colaborador',
  `Email` varchar(150) DEFAULT NULL,
  `Data_registo` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT NULL,
  `imagem` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`ID`, `password`, `Nome`, `Data_nascimento`, `Contacto`, `Perfil`, `Email`, `Data_registo`, `status`, `imagem`) VALUES
(1, '$2y$10$TDq0YuCKeykx0/ryzMCwuee4SJ744fp9hGk.3.O3DVPrO2svWktiu', 'Loiro', '2025-03-10', '985123456', 1, 'loiro@gmail.com', '2025-03-10', 'Ativo\r\n', ''),
(2, '$2y$10$mMYjqw0OLbo.ok8q5Rp57uRy5qGQTFJjyPsAnLsY.yeS5rghm/3QO', 'Gomes', '2025-03-10', '365328523', 3, 'Andrewgomes@gmail.com', '2025-03-10', 'Ativo', 'uploads/transferir.png'),
(3, '$2y$10$eZXBhDz5qvpN.sTvROaE8.uIdjv7nG5yfsyF8BOnD7vFr21.DGmFK', 'Machado', '2025-03-12', '914875146', 1, 'machado@gmail.com', '2025-03-12', 'Ativo\r\n', ''),
(4, '$2y$10$b.w0D5z0CUBu7saK0q9.keMutK7ZGRh.fXCGrz7rtjpoPakBA2qaO', 'Brinca', '2025-03-12', '986156864', 3, 'Brinca@gmail.com', '2025-03-12', 'Ativo', 'uploads/transferir (1).jpg'),
(5, '$2y$10$OnXCf/izQLnk0yuLs6CSpeXZLUsxfz2cy9rQ2ZuB9vvCV4Omxvba6', 'goncalo', '2025-03-12', '985157864', 3, 'goncalo.m.neri16@hotmail.com', '2025-03-12', 'Ativo', 'uploads/11.jpg'),
(6, '$2y$10$RwuUeJ87dU30Xtk/2AbkX.WmiFeiHVMRk17pffrYBoekqVY/Ctaca', 'Diogo', '2025-04-03', '93532523', 1, 'diogo@esenviseu.net', '2025-04-03', 'Ativo', 'upload/transferir.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `armazem`
--
ALTER TABLE `armazem`
  ADD PRIMARY KEY (`pin`),
  ADD KEY `Id_Loja` (`Id_Loja`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ferramentas`
--
ALTER TABLE `ferramentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcategoria` (`idCategoria`),
  ADD KEY `fk_idmarca` (`idMarca`);

--
-- Índices para tabela `loja`
--
ALTER TABLE `loja`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `ferramentas`
--
ALTER TABLE `ferramentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `armazem`
--
ALTER TABLE `armazem`
  ADD CONSTRAINT `armazem_ibfk_1` FOREIGN KEY (`Id_Loja`) REFERENCES `loja` (`ID`);

--
-- Limitadores para a tabela `ferramentas`
--
ALTER TABLE `ferramentas`
  ADD CONSTRAINT `fk_idcategoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `fk_idmarca` FOREIGN KEY (`idMarca`) REFERENCES `marca` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

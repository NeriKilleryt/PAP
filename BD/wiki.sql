-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Mar-2025 às 16:40
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
  `Nome` varchar(255) NOT NULL,
  `Funcao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`Nome`, `Funcao`) VALUES
('Broca', 'Perfurar materiais'),
('Chave de fenda', 'Apertar parafusos'),
('Martelo', 'Ferramenta para bater pregos'),
('Serra', 'Cortar materiais diversos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ferramenta`
--

CREATE TABLE `ferramenta` (
  `Ean` varchar(13) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Peso` int(255) DEFAULT NULL,
  `Preco` float DEFAULT NULL,
  `Nome_Categoria` varchar(255) DEFAULT NULL,
  `Id_Marca` int(255) DEFAULT NULL,
  `Id_Users` int(255) DEFAULT NULL,
  `pin_armazém` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ferramenta`
--

INSERT INTO `ferramenta` (`Ean`, `Nome`, `Peso`, `Preco`, `Nome_Categoria`, `Id_Marca`, `Id_Users`, `pin_armazém`) VALUES
('EAN001', 'Martelo de ferro', 500, 19.99, 'Martelo', 1, 1, 1),
('EAN002', 'Serra elétrica', 3000, 129.99, 'Serra', 1, 2, 2),
('EAN003', 'Chave Philips', 250, 9.99, 'Chave de fenda', 3, 3, 3),
('EAN030', 'Broca de titânio', 700, 45.99, 'Broca', 30, 30, 30);

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
(1, 'Loja Centro', 'Rua X, 100', '955555555'),
(2, 'Loja Norte', 'Avenida Y, 200', '966666666'),
(30, 'Loja Sul', 'Rua Z, 300', '977777777');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

CREATE TABLE `marca` (
  `ID` int(255) NOT NULL,
  `Morada` varchar(255) DEFAULT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Contacto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`ID`, `Morada`, `Nome`, `Contacto`) VALUES
(1, 'Viseu, Rua A, 123', 'WUrth', '911111111'),
(2, 'Avenida B, 456,Viseu', 'DeWalt', '922222222'),
(3, 'Travessa C, 789', 'Wurth', '933333333'),
(30, 'Rua Z, 321', 'Fluke', '944444444');

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
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `ID` int(255) NOT NULL COMMENT '1 = admin; 2 = utilizador; 3 = colaborador',
  `password` varchar(255) DEFAULT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Data_nascimento` date DEFAULT current_timestamp(),
  `Contacto` varchar(255) DEFAULT NULL,
  `Perfil` tinyint(4) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Data_registo` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`ID`, `password`, `Nome`, `Data_nascimento`, `Contacto`, `Perfil`, `Email`, `Data_registo`) VALUES
(1, '$2y$10$8YmzdTEV09XEOsf6zq4VzOQM8qPpwRBwjF42L2j5NmP/c6Fm36a6W', 'Sousa', '2025-03-10', '931425243', 1, 'sousa@gmail.com', '2025-03-10'),
(2, '$2y$10$Ew7eteGI.6Rx.6/HrA/tOegucZIiMgQhFo.xN1Sr0oYiOXAgDiX42', 'Titirri', '2025-03-10', '365328523\r\n', 2, 'titirri@gmail.com', '2025-03-10'),
(3, '$2y$10$TDq0YuCKeykx0/ryzMCwuee4SJ744fp9hGk.3.O3DVPrO2svWktiu', 'Loiro', '2025-03-10', '985123456', 3, 'loiro@gmail.com', '2025-03-10'),
(4, '$2y$10$3838VZDQ.ciosHxUHGcxeef9BYjjzxqTwYL3hwkOdU4noSuW.OtZm', 'Gomes', '2025-03-11', '951564146', 3, 'gomes@gmail.com', '2025-03-11'),
(5, '$2y$10$L5l98kwMMBHKBTqebJZaOeS3K/CCLdH6lOnvjAdJRM.G9pRykDv.i', 'Gonçalo', '2025-03-11', '913456876', 3, 'goncalo.m.neri@hotmail.com', '2025-03-11'),
(6, '$2y$10$eZXBhDz5qvpN.sTvROaE8.uIdjv7nG5yfsyF8BOnD7vFr21.DGmFK', 'Machado', '2025-03-12', '914875146', 1, 'machado@gmail.com', '2025-03-12'),
(7, '$2y$10$b.w0D5z0CUBu7saK0q9.keMutK7ZGRh.fXCGrz7rtjpoPakBA2qaO', 'Brinca', '2025-03-12', '986156864', 3, 'Brinca@gmail.com', '2025-03-12'),
(8, '$2y$10$OnXCf/izQLnk0yuLs6CSpeXZLUsxfz2cy9rQ2ZuB9vvCV4Omxvba6', 'goncalo', '2025-03-12', '985157864', 3, 'goncalo.m.neri16@hotmail.com', '2025-03-12');

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
  ADD PRIMARY KEY (`Nome`);

--
-- Índices para tabela `ferramenta`
--
ALTER TABLE `ferramenta`
  ADD PRIMARY KEY (`Ean`);

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
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT COMMENT '1 = admin; 2 = utilizador; 3 = colaborador', AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `armazem`
--
ALTER TABLE `armazem`
  ADD CONSTRAINT `armazem_ibfk_1` FOREIGN KEY (`Id_Loja`) REFERENCES `loja` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

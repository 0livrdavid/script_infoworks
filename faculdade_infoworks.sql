-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26-Mar-2023 às 06:05
-- Versão do servidor: 8.0.21
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `faculdade_infoworks`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `fk_idUsuarioAvalia` tinyint NOT NULL,
  `fk_idUsuarioAvaliado` tinyint NOT NULL,
  `nota` tinyint NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `nome` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

DROP TABLE IF EXISTS `cidades`;
CREATE TABLE IF NOT EXISTS `cidades` (
  `id` tinyint NOT NULL,
  `nome` varchar(50) NOT NULL,
  `fk_estado` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estado` (`fk_estado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`, `fk_estado`) VALUES
(1, 'Rio Branco', 'AC'),
(2, 'Maceió', 'AL'),
(3, 'Macapá', 'AP'),
(4, 'Manaus', 'AM'),
(5, 'Salvador', 'BA'),
(6, 'Fortaleza', 'CE'),
(7, 'Brasília', 'DF'),
(8, 'Vitória', 'ES'),
(9, 'Goiânia', 'GO'),
(10, 'São Luís', 'MA'),
(11, 'Cuiabá', 'MT'),
(12, 'Campo Grande', 'MS'),
(13, 'Belo Horizonte', 'MG'),
(14, 'Belém', 'PA'),
(15, 'João Pessoa', 'PB'),
(16, 'Curitiba', 'PR'),
(17, 'Recife', 'PE'),
(18, 'Teresina', 'PI'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Natal', 'RN'),
(21, 'Porto Alegre', 'RS'),
(22, 'Porto Velho', 'RO'),
(23, 'Boa Vista', 'RR'),
(24, 'Florianópolis', 'SC'),
(25, 'São Paulo', 'SP'),
(26, 'Aracaju', 'SE'),
(27, 'Palmas', 'TO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `sigla` varchar(2) NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`sigla`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`sigla`, `nome`) VALUES
('AC', 'Acre'),
('AL', 'Alagoas'),
('AP', 'Amapá'),
('AM', 'Amazonas'),
('BA', 'Bahia'),
('CE', 'Ceará'),
('DF', 'Distrito Federal'),
('ES', 'Espírito Santo'),
('GO', 'Goiás'),
('MA', 'Maranhão'),
('MT', 'Mato Grosso'),
('MS', 'Mato Grosso do Sul'),
('MG', 'Minas Gerais'),
('PA', 'Pará'),
('PB', 'Paraíba'),
('PR', 'Paraná'),
('PE', 'Pernambuco'),
('PI', 'Piauí'),
('RJ', 'Rio de Janeiro'),
('RN', 'Rio Grande do Norte'),
('RS', 'Rio Grande do Sul'),
('RO', 'Rondônia'),
('RR', 'Roraima'),
('SC', 'Santa Catarina'),
('SP', 'São Paulo'),
('SE', 'Sergipe'),
('TO', 'Tocantins');

-- --------------------------------------------------------

--
-- Estrutura da tabela `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `fk_idUsuario` tinyint NOT NULL,
  `filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filesize` bigint NOT NULL,
  `filetype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `fk_idUsuario` tinyint NOT NULL,
  `fk_idCategoria` tinyint NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `valor` float NOT NULL,
  `tipoValor` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `fk_estado` tinyint NOT NULL,
  `fk_cidade` tinyint NOT NULL,
  `bairro` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` tinyint NOT NULL,
  `whatsapp` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

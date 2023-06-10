-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 10/06/2023 às 04:13
-- Versão do servidor: 5.7.39
-- Versão do PHP: 8.2.0

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
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id` int(11) NOT NULL,
  `fk_idUsuarioAvalia` int(11) NOT NULL,
  `fk_idUsuarioAvaliado` int(11) NOT NULL,
  `nota` tinyint(4) NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `fk_idUsuarioAvalia`, `fk_idUsuarioAvaliado`, `nota`, `comentario`, `status`) VALUES
(47, 47, 17, 4, 'Fez um bom trabalho, dentro do prazo.', 1),
(46, 46, 16, 1, 'Foi difícil contato com o profissional, não recomendo.', 1),
(45, 45, 15, 3, 'Serviço poderia ter sido melhor.', 1),
(44, 44, 14, 5, 'Profissional muito competente, fiquei muito satisfeito.', 1),
(43, 43, 13, 4, 'Atendeu bem às minhas expectativas.', 1),
(42, 42, 12, 2, 'Deixou a desejar em alguns aspectos.', 1),
(41, 41, 11, 5, 'Realizou o serviço com excelência, recomendo.', 1),
(40, 40, 10, 3, 'Atrasou um pouco a entrega, mas o serviço ficou bom.', 1),
(39, 39, 9, 4, 'Fez tudo conforme combinado, ótimo profissional.', 1),
(38, 38, 8, 5, 'Excelente trabalho, recomendo muito!', 1),
(37, 37, 7, 3, 'Serviço razoável, mas poderia ser melhor.', 1),
(36, 36, 6, 1, 'Péssimo atendimento, não recomendo.', 1),
(35, 35, 5, 4, 'Serviço entregue dentro do prazo.', 1),
(34, 34, 4, 2, 'Não atendeu às expectativas.', 1),
(33, 33, 3, 5, 'Profissional competente, fiquei muito satisfeito.', 1),
(32, 32, 2, 3, 'Bom serviço, mas pode melhorar.', 1),
(31, 31, 1, 4, 'Ótimo atendimento, recomendo!', 1),
(48, 48, 18, 2, 'Não gostei do serviço, não recomendo.', 1),
(49, 49, 19, 3, 'Trabalho razoável, mas esperava mais.', 1),
(50, 50, 20, 5, 'Profissional muito bom, recomendo.', 1),
(51, 51, 21, 4, 'Realizou o serviço conforme combinado.', 1),
(52, 52, 22, 3, 'Poderia ter entregue o serviço antes, mas ficou bom.', 1),
(53, 53, 23, 5, 'Excelente profissional, realizou o serviço com perfeição.', 1),
(54, 54, 24, 1, 'Não atendeu às expectativas, não recomendo.', 1),
(55, 55, 25, 4, 'Atendimento muito bom, recomendo.', 1),
(56, 56, 26, 2, 'Serviço deixou a desejar em alguns pontos.', 1),
(57, 57, 27, 3, 'Serviço foi realizado, mas poderia ter sido melhor.', 1),
(58, 58, 28, 5, 'Profissional muito competente, recomendo.', 1),
(59, 59, 29, 4, 'Fez um bom trabalho, dentro do prazo.', 1),
(60, 60, 30, 3, 'Serviço foi ok, mas esperava mais qualidade.', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fk_estado` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `cidades`
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
(27, 'Palmas', 'TO'),
(28, 'Itajubá', 'MG');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estados`
--

CREATE TABLE `estados` (
  `sigla` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `estados`
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
-- Estrutura para tabela `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `fk_idUsuario` int(11) NOT NULL,
  `filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filesize` bigint(20) NOT NULL,
  `filetype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `tipo` tinyint(1) NOT NULL COMMENT '1 - perfil; 2 - servico'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `file`
--

INSERT INTO `file` (`id`, `fk_idUsuario`, `filepath`, `filename`, `filesize`, `filetype`, `created_on`, `status`, `tipo`) VALUES
(29, 2, 'service/6465500b8c1a3.jpg', '6465500b8c1a3', 151052, 'image/jpeg', '2023-05-17 19:07:07', 0, 2),
(30, 2, 'avatar/64656563cc654.jpg', '64656563cc654', 19730, 'image/jpeg', '2023-05-17 20:38:11', 1, 1),
(28, 2, 'service/6465500b8b034.jpg', '6465500b8b034', 175082, 'image/jpeg', '2023-05-17 19:07:07', 0, 2),
(27, 2, 'service/6465441878d9d.jpg', '6465441878d9d', 161609, 'image/jpeg', '2023-05-17 18:16:08', 0, 2),
(12, 2, 'avatar/6464f001e3606.jpg', '6464f001e3606', 7381, 'image/jpeg', '2023-05-17 12:17:21', 0, 1),
(26, 2, 'service/6465441878a8d.jpg', '6465441878a8d', 166004, 'image/jpeg', '2023-05-17 18:16:08', 0, 2),
(25, 2, 'service/6465441878865.jpg', '6465441878865', 175082, 'image/jpeg', '2023-05-17 18:16:08', 0, 2),
(24, 2, 'service/6465441878575.jpg', '6465441878575', 151052, 'image/jpeg', '2023-05-17 18:16:08', 0, 2),
(23, 2, 'service/6465441878077.jpg', '6465441878077', 135456, 'image/jpeg', '2023-05-17 18:16:08', 0, 2),
(36, 4, 'service/6465794648a86.jpg', '6465794648a86', 175082, 'image/jpeg', '2023-05-17 22:03:02', 1, 2),
(35, 4, 'service/6465794647353.jpg', '6465794647353', 135456, 'image/jpeg', '2023-05-17 22:03:02', 1, 2),
(34, 4, 'avatar/64657837d0d92.jpg', '64657837d0d92', 60393, 'image/jpeg', '2023-05-17 21:58:31', 1, 1),
(37, 4, 'service/6465794648fcb.jpg', '6465794648fcb', 166004, 'image/jpeg', '2023-05-17 22:03:02', 1, 2),
(38, 4, 'service/6465794649190.jpg', '6465794649190', 161609, 'image/jpeg', '2023-05-17 22:03:02', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `service`
--

CREATE TABLE `service` (
  `id` tinyint(4) NOT NULL,
  `fk_idUsuario` tinyint(4) NOT NULL,
  `fk_idCategory` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `valor` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `fk_idType` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `service`
--

INSERT INTO `service` (`id`, `fk_idUsuario`, `fk_idCategory`, `descricao`, `valor`, `fk_idType`, `status`) VALUES
(86, 2, 'Motorista', '<p><b>Etiam urna lacus</b></p><ol><li>fermentum non neque </li><li>nonviverra pharetra lectus.</li></ol><p>Donec auctor, libero eu luctus tincidunt, elit magna consectetur massa, nec efficitur odio nisl a metus. Aenean suscipit efficitur mi vel vulputate. Nam auctor, dui sit amet pretium aliquet, diam lacus feugiat purus, in facilisis erat enim sit amet lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse ut nunc eget lorem malesuada scelerisque. Donec lobortis neque a ex viverra eleifend. Suspendisse suscipit mattis sem. Nunc finibus sem id nibh elementum ultricies. Nunc vel scelerisque velit, non malesuada lectus. Ut egestas aliquet dui et pellentesque.<br></p>', 'R$ 50,00', 'evento', 1),
(85, 2, 'Desenvolvedor de software', 'Etiam urna lacus, fermentum non neque non, viverra pharetra lectus. Donec auctor, libero eu luctus tincidunt, elit magna consectetur massa, nec efficitur odio nisl a metus. Aenean suscipit efficitur mi vel vulputate. Nam auctor, dui sit amet pretium aliquet, diam lacus feugiat purus, in facilisis erat enim sit amet lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse ut nunc eget lorem malesuada scelerisque. Donec lobortis neque a ex viverra eleifend. Suspendisse suscipit mattis sem. Nunc finibus sem id nibh elementum ultricies. Nunc vel scelerisque velit, non malesuada lectus. Ut egestas aliquet dui et pellentesque.', 'R$ 5.000,00', 'projeto', 1),
(88, 4, 'Fotógrafo', 'Etiam urna lacus, fermentum non neque non, viverra pharetra lectus. Donec auctor, libero eu luctus tincidunt, elit magna consectetur massa, nec efficitur odio nisl a metus. Aenean suscipit efficitur mi vel vulputate. Nam auctor, dui sit amet pretium aliquet, diam lacus feugiat purus, in facilisis erat enim sit amet lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse ut nunc eget lorem malesuada scelerisque. Donec lobortis neque a ex viverra eleifend. Suspendisse suscipit mattis sem. Nunc finibus sem id nibh elementum ultricies. Nunc vel scelerisque velit, non malesuada lectus. Ut egestas aliquet dui et pellentesque.', 'R$ 3.750,00', 'projeto', 1),
(89, 4, 'Fotógrafo', 'Etiam urna lacus, fermentum non neque non, viverra pharetra lectus. Donec auctor, libero eu luctus tincidunt, elit magna consectetur massa, nec efficitur odio nisl a metus. Aenean suscipit efficitur mi vel vulputate. Nam auctor, dui sit amet pretium aliquet, diam lacus feugiat purus, in facilisis erat enim sit amet lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse ut nunc eget lorem malesuada scelerisque. Donec lobortis neque a ex viverra eleifend. Suspendisse suscipit mattis sem. Nunc finibus sem id nibh elementum ultricies. Nunc vel scelerisque velit, non malesuada lectus. Ut egestas aliquet dui et pellentesque.', 'R$ 3.750,00', 'projeto', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `service_category`
--

CREATE TABLE `service_category` (
  `nome` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `service_category`
--

INSERT INTO `service_category` (`nome`, `descricao`) VALUES
('Babá', 'Profissional que cuida de crianças em domicílio, com responsabilidade e atenção às necessidades das crianças.'),
('Pedreiro', 'Profissional que trabalha com construção civil, realizando atividades como alvenaria, reboco, colocação de pisos e azulejos.'),
('Motorista', 'Profissional responsável por dirigir veículos, transportando pessoas ou cargas, seguindo as normas de trânsito e garantindo a segurança.'),
('Diarista', 'Profissional que realiza serviços domésticos em casas ou escritórios, como limpeza e organização.'),
('Cabeleireiro', 'Profissional que trabalha com cortes, coloração e tratamento de cabelos, buscando oferecer um serviço de qualidade e satisfação aos clientes.'),
('Cozinheiro', 'Profissional que prepara refeições em restaurantes, bares ou domicílios, seguindo as receitas e normas de higiene.'),
('Mecânico', 'Profissional que trabalha com manutenção e reparo de veículos, garantindo o bom funcionamento dos mesmos.'),
('Encanador', 'Profissional que realiza instalações e reparos de sistemas hidráulicos, como tubulações, torneiras e chuveiros.'),
('Jardineiro', 'Profissional que cuida de jardins, plantas e flores, realizando atividades como poda, irrigação e adubação.'),
('Eletricista', 'Profissional que trabalha com instalação e manutenção de sistemas elétricos, como fiação, disjuntores e iluminação.'),
('Pintor', 'Profissional que trabalha com pintura em paredes, tetos e outras superfícies, utilizando técnicas e materiais adequados.'),
('Encarregado de Obra', 'Profissional responsável por gerenciar e coordenar a equipe de trabalhadores em uma obra, garantindo a execução adequada das atividades.'),
('Vendedor', 'Profissional que trabalha com vendas de produtos ou serviços, atendendo clientes, fazendo demonstrações e negociações.'),
('Zelador', 'Profissional que realiza serviços de limpeza, manutenção e segurança em condomínios, garantindo o bem-estar dos moradores.'),
('Segurança', 'Profissional que atua na proteção e vigilância de pessoas, locais ou eventos, utilizando técnicas de segurança adequadas.'),
('Técnico em Informática', 'Profissional que trabalha com manutenção e reparo de equipamentos de informática, como computadores e redes.'),
('Médico Veterinário', 'Profissional que atua na saúde e bem-estar dos animais, realizando consultas, diagnósticos e tratamentos.'),
('Nutricionista', 'Profissional que orienta e prescreve dietas adequadas para a promoção da saúde e prevenção de doenças.'),
('Advogado', 'Profissional que atua na defesa de direitos e interesses de pessoas e empresas, prestando consultoria jurídica e representação legal.'),
('Professor Particular', 'Profissional que oferece aulas particulares de diversas disciplinas, atendendo alunos com dificuldades ou que desejam aprimorar seus conhecimentos.'),
('Fotógrafo', 'Profissional que trabalha com captura de imagens, utilizando equipamentos e técnicas adequadas para produzir fotos de alta qualidade.'),
('Açougueiro', 'Profissional que trabalha em açougues, realizando o corte e preparo de carnes para venda ou consumo.'),
('Carpinteiro', 'Profissional que trabalha com madeira, realizando atividades como corte, lixamento, montagem e instalação de móveis e estruturas.'),
('Entregador', 'Profissional que realiza entregas de produtos ou documentos, utilizando veículos adequados e garantindo a segurança e rapidez.'),
('Garçom', 'Profissional que trabalha em bares e restaurantes, atendendo clientes, anotando pedidos e servindo refeições e bebidas.'),
('Esteticista', 'Profissional que trabalha com tratamentos estéticos, como limpeza de pele, depilação, massagem e outros procedimentos para cuidado com a beleza.'),
('Psicólogo', 'Profissional que atua na saúde mental e emocional das pessoas, realizando terapias e acompanhamento psicológico.'),
('Engenheiro Civil', 'Profissional que atua no planejamento, projeto e execução de obras civis, como construção de edifícios, pontes, estradas e outros empreendimentos.'),
('Designer Gráfico', 'Profissional que trabalha com criação de materiais gráficos, como logotipos, cartões de visita, banners e outros produtos visuais.'),
('Músico', 'Profissional que atua na música, realizando apresentações ao vivo, gravações de estúdio e outras atividades relacionadas.'),
('Catador de recicláveis', 'Profissional que coleta materiais recicláveis, como papel, plástico e metal, contribuindo para a preservação do meio ambiente.'),
('Costureira', 'Profissional que trabalha com costura, realizando reparos e confecção de peças de vestuário, como roupas e acessórios.'),
('Ambulante', 'Profissional que vende produtos nas ruas, como alimentos, bebidas e outros itens de conveniência.'),
('Office boy', 'Profissional que realiza serviços de entregas, cópias e outras atividades administrativas em escritórios e empresas.'),
('Motoboy', 'Profissional que realiza entregas de documentos, encomendas e alimentos, utilizando motocicletas.'),
('Diácono', 'Profissional que atua em igrejas, auxiliando em atividades religiosas e sociais, como casamentos, batismos e ações sociais.'),
('Agricultor', 'Profissional que trabalha no campo, cultivando e colhendo alimentos, contribuindo para a produção de alimentos para a população.'),
('Frentista', 'Profissional que trabalha em postos de combustíveis, realizando serviços como abastecimento de veículos, verificação de níveis de óleo e água, entre outros.'),
('Jornalista', 'Profissional que atua na produção e divulgação de notícias e informações, em meios de comunicação como jornais, revistas, rádio e televisão.'),
('Arquiteto', 'Profissional que atua no planejamento e projeto de espaços arquitetônicos, como casas, edifícios e outros empreendimentos.'),
('Professor', 'Profissional que atua na educação, ensinando disciplinas diversas em escolas, universidades e outras instituições de ensino.'),
('Desenvolvedor de software', 'Profissional que atua no desenvolvimento de programas e aplicativos para computadores e dispositivos móveis.'),
('Consultor de negócios', 'Profissional que atua na análise e consultoria de negócios, auxiliando empresas e empreendedores em questões estratégicas.'),
('Personal trainer', 'Profissional que atua no acompanhamento e treinamento de pessoas que desejam melhorar sua saúde e condicionamento físico.'),
('Psiquiatra', 'Profissional que atua na saúde mental, realizando diagnósticos e tratamentos para transtornos psiquiátricos.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `service_file`
--

CREATE TABLE `service_file` (
  `id` int(11) NOT NULL,
  `fk_idUsuario` int(11) NOT NULL,
  `fk_idService` int(11) NOT NULL,
  `fk_idFile` int(11) NOT NULL,
  `ordem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `service_file`
--

INSERT INTO `service_file` (`id`, `fk_idUsuario`, `fk_idService`, `fk_idFile`, `ordem`) VALUES
(3, 2, 85, 23, 0),
(4, 2, 85, 24, 1),
(5, 2, 85, 25, 2),
(6, 2, 85, 26, 3),
(7, 2, 85, 27, 4),
(8, 2, 86, 28, 0),
(9, 2, 86, 29, 1),
(12, 4, 88, 35, 0),
(13, 4, 88, 36, 1),
(14, 4, 88, 37, 2),
(15, 4, 88, 38, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `service_type`
--

CREATE TABLE `service_type` (
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `service_type`
--

INSERT INTO `service_type` (`tipo`) VALUES
('dia'),
('evento'),
('hora'),
('mês'),
('noite'),
('obra'),
('projeto'),
('unidade');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 -> desativado\r\n1 -> ativado',
  `tipo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 -> admin\r\n2 -> Profissional\r\n3 -> clientes',
  `autorizado` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 -> ainda nao autorizado a prestar serviço\r\n1 -> admin autorizou prestar serviço',
  `cpf` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idade` date DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_estado` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_cidade` int(11) DEFAULT NULL,
  `bairro` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rua` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sobre_mim` text COLLATE utf8_unicode_ci NOT NULL,
  `formacao` text COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`id`, `status`, `tipo`, `autorizado`, `cpf`, `email`, `nome`, `senha`, `hash`, `salt`, `idade`, `cep`, `fk_estado`, `fk_cidade`, `bairro`, `rua`, `numero`, `telefone`, `whatsapp`, `sobre_mim`, `formacao`, `instagram`, `facebook`) VALUES
(2, 1, 3, 0, '134.389.076-40', 'teste@gmail.com', 'David Gonçalves de Oliveira', '1234', '0fe2ebcf082e4d2036f1d09dcb8780937acd6c11', '1ab30fea248a8602698452584d588ee7', '2002-08-22', '37500-014', 'MG', 28, 'Centro', 'Rua Maestro Luiz Ramos de Lima', '5', '5535991315617', '5535991315617', 'Olá, meu nome é Igor e sou um profissional de marketing digital com mais de cinco anos de experiência no ramo. Sou apaixonada por tudo relacionado à tecnologia e mídias sociais, o que me levou a me especializar em estratégias digitais. Adoro trabalhar em equipe e sou movida por desafios que me permitam explorar novas ideias e aprender mais sobre a minha área de atuação.', 'Sou graduado em Comunicação Social com ênfase em Publicidade e Propaganda pela Universidade Federal de Minas Gerais (UFMG). Também tenho um MBA em Marketing Digital pela Fundação Getúlio Vargas (FGV) e diversos cursos complementares na área, incluindo certificações em Google Ads e Facebook Ads. Além disso, sou uma entusiasta do aprendizado contínuo e estou sempre buscando me atualizar sobre as últimas tendências e novidades do mercado.', 'https://www.instagram.com', 'https://www.facebook.com'),
(4, 1, 3, 0, '133.375.666-69', 'teste2@gmail.com', 'José Lucas Magalhães Ribeiro', '1234', '210f81e330c08a3e6e3fe781df608e4a7ce59bc8', 'b6c3f7a76647703d60cdfcdd39e6e935', '1998-10-28', '37501-334', 'AM', 1, 'teste2', 'teste1', '3', NULL, NULL, '', '', '', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estado` (`fk_estado`);

--
-- Índices de tabela `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`sigla`);

--
-- Índices de tabela `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`nome`);

--
-- Índices de tabela `service_file`
--
ALTER TABLE `service_file`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`tipo`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `service`
--
ALTER TABLE `service`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de tabela `service_file`
--
ALTER TABLE `service_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

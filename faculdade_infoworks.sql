-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26-Mar-2023 às 11:42
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
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_idUsuarioAvalia` int NOT NULL,
  `fk_idUsuarioAvaliado` int NOT NULL,
  `nota` tinyint NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `avaliacao`
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
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `nome` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`nome`, `descricao`) VALUES
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
-- Estrutura da tabela `cidades`
--

DROP TABLE IF EXISTS `cidades`;
CREATE TABLE IF NOT EXISTS `cidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fk_estado` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estado` (`fk_estado`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `sigla` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sigla`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_idUsuario` int NOT NULL,
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
  `fk_idCategoria` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `valor` float NOT NULL,
  `tipoValor` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `service`
--

INSERT INTO `service` (`id`, `fk_idUsuario`, `fk_idCategoria`, `descricao`, `valor`, `tipoValor`, `status`) VALUES
(16, 6, 'Arquiteto', 'Projeto de reforma de cozinha em apartamento de 60 metros quadrados, com acompanhamento da obra. Trabalho com projetos personalizados e modernos, buscando aliar estética e funcionalidade.', 5000, 'obra', 1),
(15, 5, 'Diarista', 'Faxina em apartamento de 2 quartos, com cozinha e banheiro, uma vez por semana. Faço uma limpeza minuciosa e organizada, com produtos de qualidade e respeitando as particularidades de cada cliente.', 120, 'dia', 1),
(14, 4, 'Motorista', 'Transporte de pessoa de casa para o trabalho, de segunda a sexta-feira. Ofereço um serviço pontual e seguro, com veículo sempre limpo e confortável.', 800, 'mês', 1),
(13, 3, 'Babá', 'Cuidado com criança de 6 meses a 1 ano de idade, com alimentação e higiene pessoal. Sou uma babá experiente e carinhosa, garantindo segurança e tranquilidade aos pais.', 100, 'dia', 1),
(12, 2, 'Pedreiro', 'Construção de muro de tijolos aparentes com altura de 2 metros e comprimento de 5 metros. Realizo um trabalho de alta qualidade e durabilidade.', 3000, 'obra', 1),
(11, 1, 'Pintor', 'Pintura de parede de um cômodo de até 20 metros quadrados com tinta acrílica. Trabalho com qualidade, limpeza e agilidade.', 500, 'mês', 1),
(17, 7, 'Professor', 'Aulas particulares de matemática para aluno do ensino fundamental II, duas vezes por semana. Utilizo uma metodologia dinâmica e personalizada, buscando identificar as necessidades individuais de cada aluno.', 80, 'hora', 1),
(18, 8, 'Desenvolvedor de software', 'Desenvolvimento de aplicativo de delivery para restaurante, incluindo integração com pagamento online. Sou um desenvolvedor experiente e comprometido, buscando oferecer soluções modernas e eficientes para meus clientes.', 10000, 'projeto', 1),
(19, 9, 'Consultor de negócios', 'Consultoria para abertura de empresa, incluindo elaboração de plano de negócios e registro de marca. Tenho ampla experiência na área de negócios e busco oferecer soluções inovadoras e personalizadas para cada cliente.', 5000, 'projeto', 1),
(20, 10, 'Nutricionista', 'Consulta nutricional para acompanhamento de dieta de emagrecimento, com avaliação física e prescrição de cardápio. Sou uma nutricionista dedicada e comprometida, buscando auxiliar meus pacientes na conquista de uma vida mais saudável e equilibrada.', 200, 'mês', 1),
(21, 11, 'Marceneiro', 'Faço móveis sob medida com qualidade e eficiência', 2500, 'projeto', 1),
(22, 12, 'Cozinheiro', 'Preparo refeições deliciosas e saudáveis para sua família', 120, 'dia', 1),
(23, 13, 'Jardineiro', 'Cuido do seu jardim com muito carinho e dedicação', 60, 'hora', 1),
(24, 14, 'Pintor', 'Pinto sua casa com qualidade e rapidez', 800, 'dia', 1),
(25, 15, 'Cuidador de idosos', 'Cuido do seu ente querido com muito amor e dedicação', 1500, 'mês', 1),
(26, 16, 'Encanador', 'Resolvo seus problemas de encanamento com eficiência', 120, 'hora', 1),
(27, 17, 'Eletricista', 'Resolvo seus problemas elétricos com segurança e rapidez', 150, 'hora', 1),
(28, 18, 'Manicure', 'Faço suas unhas com delicadeza e perfeição', 30, 'dia', 1),
(29, 19, 'Cabeleireiro', 'Corte e penteado para todas as ocasiões', 80, 'dia', 1),
(30, 20, 'Vendedor ambulante', 'Tenho produtos variados e de qualidade a preços acessíveis', 10, 'unidade', 1),
(31, 21, 'Professor particular', 'Aulas de matemática, física e química para ensino médio e superior', 100, 'hora', 1),
(32, 22, 'Entregador', 'Entrego seus produtos com segurança e rapidez', 30, 'hora', 1),
(33, 23, 'Carpinteiro', 'Faço reparos e construções em madeira com qualidade e eficiência', 150, 'dia', 1),
(34, 24, 'Montador de móveis', 'Monto seus móveis com rapidez e eficiência', 80, 'hora', 1),
(35, 25, 'Faxineiro', 'Limpo sua casa com qualidade e organização', 70, 'dia', 1),
(36, 26, 'Mecânico', 'Resolvo seus problemas mecânicos com eficiência e honestidade', 200, 'dia', 1),
(37, 27, 'Fotógrafo', 'Registre seus momentos especiais com qualidade e estilo', 500, 'evento', 1),
(38, 28, 'Web Designer', 'Desenvolvo seu site com qualidade e eficiência', 3000, 'projeto', 1),
(39, 29, 'Programador', 'Desenvolvo softwares sob medida para sua empresa', 150, 'hora', 1),
(40, 30, 'Vigia', 'Faço ronda em sua empresa ou condomínio com segurança e eficiência', 120, 'noite', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 -> desativado\r\n1 -> ativado',
  `tipo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 -> admin\r\n2 -> Profissional\r\n3 -> clientes',
  `autorizado` tinyint(1) NOT NULL COMMENT '0 -> ainda nao autorizado a prestar serviço\r\n1 -> admin autorizou prestar serviço',
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idade` date NOT NULL,
  `cep` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `fk_estado` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `fk_cidade` int NOT NULL,
  `bairro` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` int NOT NULL,
  `whatsapp` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `status`, `tipo`, `autorizado`, `cpf`, `email`, `nome`, `senha`, `salt`, `idade`, `cep`, `fk_estado`, `fk_cidade`, `bairro`, `rua`, `numero`, `telefone`, `whatsapp`) VALUES
(12, 1, 2, 0, '58160376490', 'anaclarasouza@gmail.com', 'Ana Clara Souza', '', '', '2003-03-24', '1501500', 'SP', 1, 'Jardim Brasil', 'Rua das Flores', '123', 2147483647, 2147483647),
(2, 1, 2, 0, '93787219898', 'julio.souza_89@hotmail.com', 'Julio Cesar de Souza', '', '', '2003-03-24', '9123654', 'SP', 0, 'Jardim São Paulo', 'Rua Dona Amélia', '234', 2147483647, 2147483647),
(3, 1, 2, 0, '84569571203', 'mariarodrigues91@yahoo.com.br', 'Maria Luiza Rodrigues', '', '', '2003-03-24', '1342500', 'SP', 0, 'Centro', 'Rua XV de Novembro', '128', 2147483647, 2147483647),
(4, 1, 2, 0, '72584639150', 'gustavo.pereira23@gmail.com', 'Gustavo Oliveira Pereira', '', '', '2003-03-24', '2801542', 'SE', 0, 'São Conrado', 'Rua das Palmeiras', '753', 2139025255, 2147483647),
(5, 1, 2, 0, '36322016789', 'luana.santos32@outlook.com', 'Luana Santos', '', '', '2003-03-24', '1308114', 'SP', 0, 'Jardim Santa Genebra', 'Rua José Martins de Toledo', '562', 2147483647, 2147483647),
(6, 1, 2, 0, '14097824853', 'pedro.amaral21@gmail.com', 'Pedro Henrique Amaral', '', '', '2003-03-24', '7023401', 'DF', 0, 'Asa Norte', 'Quadra SQN 209', 'Bloco B', 2147483647, 2147483647),
(7, 1, 2, 0, '92548766914', 'ana.ferreira87@gmail.com', 'Ana Carolina Ferreira', '', '', '2003-03-24', '8902700', 'SC', 0, 'Itoupava Norte', 'Rua Francisco Vahldieck', '116', 2136885238, 2147483647),
(8, 1, 2, 0, '57536718212', 'eduardo.borges12@hotmail.com', 'Eduardo Alves Borges', '', '', '2003-03-24', '0474403', 'SP', 0, 'Vila São Francisco', 'Rua Bento Vieira', '1075', 2147483647, 2147483647),
(9, 1, 2, 0, '42589899130', 'roberta.almeida3@gmail.com', 'Roberta da Silva Almeida', '', '', '2003-03-24', '6031010', 'CE', 0, 'Carlito Pamplona', 'Rua 24 de Maio', '890', 2132620628, 2147483647),
(10, 1, 2, 0, '72725499608', 'victor.oliveira34@yahoo.com.br', 'Victor Augusto de Oliveira', '', '', '2003-03-24', '2921633', 'ES', 0, 'Praia da Costa', 'Rua José Teixeira', '275', 2147483647, 2147483647),
(11, 1, 2, 0, '28703177695', 'larissa.rodrigues18@uol.com.br', 'Larissa Aparecida Rodrigues', '', '', '2003-03-24', '1106001', 'SP', 0, 'Embaré', 'Rua Professor Augusto Cesar, 64', 'Apto 14', 2147483647, 2147483647),
(13, 1, 2, 0, '85393057001', 'albertocosta@hotmail.com', 'Alberto da Costa', '', '', '2003-03-24', '5801010', 'PB', 2, 'Tambauzinho', 'Rua dos Pardais', '456', 2147483647, 2147483647),
(14, 1, 2, 0, '28575229535', 'andrevasconcelos@yahoo.com.br', 'Andre Vasconcelos', '', '', '2003-03-24', '3516236', 'MG', 3, 'Sao Francisco', 'Rua das Mangueiras', '789', 1475086002, 2147483647),
(15, 1, 2, 0, '94064534157', 'beatrizalmeida@uol.com.br', 'Beatriz Almeida', '', '', '2003-03-24', '0141500', 'SP', 4, 'Jardim Paulista', 'Rua Pamplona', '567', 2132293736, 2147483647),
(16, 1, 2, 0, '45252636660', 'carlosrodrigues@gmail.com', 'Carlos Rodrigues', '', '', '2003-03-24', '9003590', 'RS', 5, 'Moinhos de Vento', 'Rua dos Jacarandas', '891', 2136210679, 2147483647),
(17, 1, 2, 0, '74878933595', 'danielamonteiro@outlook.com', 'Daniela Monteiro', '', '', '2003-03-24', '5804000', 'PB', 6, 'Jaguaribe', 'Rua dos Colibris', '1011', 2147483647, 2147483647),
(18, 1, 2, 0, '13245280231', 'eduardolima@bol.com.br', 'Eduardo Lima', '', '', '2003-03-24', '5011008', 'BA', 7, 'Garcia', 'Rua das Tulipas', '345', 2112228902, 2147483647),
(19, 1, 2, 0, '39038621689', 'fernandorocha@gmail.com', 'Fernando Rocha', '', '', '2003-03-24', '3011011', 'MG', 8, 'Centro', 'Rua dos Ipês', '123', 2108627953, 2147483647),
(20, 1, 2, 0, '69451081711', 'gabrielasouza@hotmail.com', 'Gabriela Souza', '', '', '2003-03-24', '7900236', 'MS', 9, 'Vila Carvalho', 'Rua dos Girassóis', '456', 2106453061, 2147483647),
(21, 1, 2, 0, '30395686494', 'henriquesantos@gmail.com', 'Henrique Santos', '', '', '2003-03-24', '0400300', 'SP', 10, 'Saúde', 'Rua dos Crisântemos', '789', 2106381449, 2147483647),
(22, 1, 2, 0, '48638345956', 'lucassousa@gmail.com', 'Lucas Sousa Costa', '', '', '2003-03-24', '7215058', 'DF', 0, 'Taguatinga', 'QNA 02 Conjunto N', '11', 2112548067, 2147483647),
(23, 1, 2, 0, '26385340680', 'patriciacastro@gmail.com', 'Patrícia Castro Lima', '', '', '2003-03-24', '2123534', 'RJ', 0, 'Tijuca', 'Rua Haddock Lobo', '205', 2143595992, 2147483647),
(24, 1, 2, 0, '70007646236', 'rodrigocarvalho@yahoo.com.br', 'Rodrigo Carvalho Santos', '', '', '2003-03-24', '5807045', 'PB', 0, 'Cristo Redentor', 'Rua João Batista Carneiro', '122', 2147483647, 2147483647),
(25, 1, 2, 0, '87836834529', 'mariaoliveira@hotmail.com', 'Maria Oliveira Silva', '', '', '2003-03-24', '6017503', 'CE', 0, 'Aldeota', 'Rua Carlos Vasconcelos', '555', 2147483647, 2147483647),
(26, 1, 2, 0, '00914662308', 'fernandabrito@gmail.com', 'Fernanda Brito Almeida', '', '', '2003-03-24', '5803001', 'PB', 0, 'Manaíra', 'Rua Esperança', '210', 2147483647, 2147483647),
(27, 1, 2, 0, '13825902522', 'leandrosilva@gmail.com', 'Leandro da Silva Santos', '', '', '2003-03-24', '5008001', 'PE', 0, 'Boa Viagem', 'Rua Visconde de Jequitinhonha', '1065', 1854562015, 2147483647),
(28, 1, 2, 0, '89194401520', 'julianapereira@yahoo.com.br', 'Juliana Pereira Alves', '', '', '2003-03-24', '2021013', 'RJ', 0, 'Centro', 'Rua Senador Dantas', '75', 2132469364, 2147483647),
(29, 1, 2, 0, '47979430309', 'carloslopes@hotmail.com', 'Carlos Lopes Ferreira', '', '', '2003-03-24', '6609350', 'PA', 0, 'Marco', 'Passagem São Francisco', '60', 2147483647, 2147483647),
(30, 1, 2, 0, '02022274326', 'joseoliveira@gmail.com', 'José Oliveira Santos', '', '', '2003-03-24', '5703057', 'AL', 0, 'Ponta Verde', 'Rua Engenheiro Mário de Gusmão', '105', 2147483647, 2147483647),
(31, 1, 3, 0, '88938540002', 'andreacosta@gmail.com', 'Andrea Costa Carvalho', '', '', '2003-03-24', '6908441', 'AM', 0, 'Japiim', 'Rua São Francisco', '150', 2147483647, 2147483647),
(32, 1, 3, 0, '12456789012', 'lucas.julio@gmail.com', 'Lucas Julio Oliveira', '', '', '2003-03-24', '1234567', 'SP', 0, 'Vila Mariana', 'Rua Domingos de Morais', '123', 2129796091, 2147483647),
(33, 1, 3, 0, '98765432109', 'amanda.goncalves@hotmail.com', 'Amanda Gonçalves Silva', '', '', '2003-03-24', '9876543', 'RJ', 0, 'Copacabana', 'Avenida Atlântica', '456', 1598490353, 2147483647),
(34, 1, 3, 0, '45678912300', 'gabriel_santos@yahoo.com.br', 'Gabriel Santos', '', '', '2003-03-24', '4567890', 'BA', 0, 'Pituba', 'Rua das Flores', '789', 2103063497, 2147483647),
(35, 1, 3, 0, '65432198700', 'rafael.oliveira@gmail.com', 'Rafael Oliveira', '', '', '2003-03-24', '6543219', 'MG', 0, 'Savassi', 'Rua Pernambuco', '321', 2119846428, 2147483647),
(36, 1, 3, 0, '14785236900', 'aline.dias@hotmail.com', 'Aline Dias', '', '', '2003-03-24', '1478523', 'SC', 0, 'Jurerê Internacional', 'Rua das Palmeiras', '741', 2147483647, 2147483647),
(37, 1, 3, 0, '96385274100', 'carla.silva@gmail.com', 'Carla Silva', '', '', '2003-03-24', '9638527', 'SP', 0, 'Vila Olímpia', 'Rua Funchal', '456', 2147483647, 2147483647),
(38, 1, 3, 0, '45678912301', 'felipe.alves@yahoo.com.br', 'Felipe Alves', '', '', '2003-03-24', '4567890', 'BA', 0, 'Barra', 'Avenida Oceânica', '123', 2147483647, 2147483647),
(39, 1, 3, 0, '78945612309', 'camila.almeida@gmail.com', 'Camila Almeida', '', '', '2003-03-24', '7894561', 'RJ', 0, 'Leblon', 'Avenida Delfim Moreira', '456', 2144093016, 2147483647),
(40, 1, 3, 0, '25896314700', 'gustavo.souza@yahoo.com.br', 'Gustavo Souza', '', '', '2003-03-24', '2589631', 'MG', 0, 'Centro', 'Rua Direita', '159', 2147483647, 2147483647),
(41, 1, 3, 0, '75315985200', 'raissa.ferreira@hotmail.com', 'Raíssa Ferreira', '', '', '2003-03-24', '7531598', 'SC', 0, 'Ingleses', 'Rua das Gaivotas', '321', 2121746416, 2147483647),
(42, 1, 3, 0, '87628125331', 'julieta.farias@hotmail.com', 'Julieta Farias da Silva', '', '', '2003-03-24', '8022037', 'PR', 523, 'Jardim das Américas', 'Rua Santa Catarina', '987', 2147483647, 2147483647),
(43, 1, 3, 0, '11176787497', 'rafaela.alves@gmail.com', 'Rafaela Alves Santos', '', '', '2003-03-24', '7101500', 'DF', 1045, 'Guará II', 'QI 31', '12', 2116344782, 2147483647),
(44, 1, 3, 0, '92391849770', 'rodrigo.ferreira@gmail.com', 'Rodrigo Ferreira Dias', '', '', '2003-03-24', '2304235', 'RJ', 712, 'Campo Grande', 'Rua Nereu Sampaio', '13', 2147483647, 2147483647),
(45, 1, 3, 0, '49000478781', 'ana.silveira@yahoo.com.br', 'Ana Silveira Souza', '', '', '2003-03-24', '4565000', 'BA', 3270, 'Centro', 'Rua Getúlio Vargas', '44', 2114833148, 2147483647),
(46, 1, 3, 0, '28721286591', 'lucas.martins@gmail.com', 'Lucas Martins da Costa', '', '', '2003-03-24', '3015003', 'MG', 1201, 'Funcionários', 'Rua Sergipe', '128', 2147483647, 2147483647),
(47, 1, 3, 0, '48663241807', 'maria_mendes@hotmail.com', 'Maria Mendes da Silva', '', '', '2003-03-24', '0873043', 'PE', 3, 'São Francisco', 'Rua José Bonifácio', '376', 2134726798, 2147483647),
(48, 1, 3, 0, '02023952271', 'roberto_santos@gmail.com', 'Roberto Santos de Oliveira', '', '', '2003-03-24', '0401513', 'SP', 5, 'Vila Mariana', 'Rua Morgado de Mateus', '182', 2147483647, 1199789456),
(49, 1, 3, 0, '78446399542', 'ana_carla_costa@yahoo.com.br', 'Ana Carla Costa dos Santos', '', '', '2003-03-24', '4127500', 'BA', 2, 'Cajazeiras', 'Rua Santa Rita', '98', 2126310875, 2147483647),
(50, 1, 3, 0, '14616342523', 'jose_alves@uol.com.br', 'José Alves Rodrigues', '', '', '2003-03-24', '5805222', 'PB', 8, 'Mangabeira', 'Rua Francisco Gomes de Medeiros', '460', 2147483647, 2147483647),
(51, 1, 3, 0, '60178900139', 'juliana_silveira@hotmail.com', 'Juliana Silveira Souza', '', '', '2003-03-24', '6017510', 'CE', 4, 'Aldeota', 'Rua Monsenhor Catão', '440', 2147483647, 2147483647),
(52, 1, 3, 0, '24456294111', 'pedro_campos@gmail.com', 'Pedro Campos de Almeida', '', '', '2003-03-24', '2053001', 'RJ', 1, 'Tijuca', 'Rua Pereira Nunes', '239', 2117048487, 2147483647),
(53, 1, 3, 0, '13814460191', 'raquel_martins@bol.com.br', 'Raquel Martins da Silva', '', '', '2003-03-24', '7805335', 'MT', 7, 'Cidade Verde', 'Rua das Flores', '123', 2123146037, 2147483647),
(54, 1, 3, 0, '67940891222', 'fernanda_souza@hotmail.com', 'Fernanda Souza de Lima', '', '', '2003-03-24', '5803513', 'PB', 8, 'Jardim São Paulo', 'Rua Enéas Cavalcante', '42', 1064584726, 2147483647),
(55, 1, 3, 0, '12131101208', 'luiz_ferreira@gmail.com', 'Luiz Ferreira da Cruz', '', '', '2003-03-24', '6909725', 'AM', 6, 'Cidade Nova', 'Rua Monte Sinai', '93', 2147483647, 2147483647),
(56, 1, 3, 0, '21458022318', 'daniel_oliveira@outlook.com', 'Daniel Oliveira Santos', '', '', '2003-03-24', '8053039', 'PR', 9, 'Jardim Social', 'Rua Pasteur', '88', 2147483647, 2147483647),
(57, 1, 3, 0, '04806407322', 'amanda_rocha@yahoo.com.br', 'Amanda Rocha dos Santos', '', '', '2003-03-24', '0707410', 'SP', 5, 'Vila Augusta', 'Rua Humberto de Campos', '77', 2107910638, 1199152288),
(58, 1, 3, 0, '82996250373', 'marianaoliveira@hotmail.com', 'Mariana Oliveira', '', '', '2003-03-24', '3874000', 'MG', 41, 'Centro', 'Rua do Comércio', '123', 2118532870, 2147483647),
(59, 1, 3, 0, '66714948567', 'julioalmeida@yahoo.com', 'Júlio Almeida', '', '', '2003-03-24', '0397901', 'SP', 12, 'Jardim Aurora', 'Rua das Flores', '987', 2147483647, 2147483647),
(60, 1, 3, 0, '31123095751', 'fabiolafernandes@gmail.com', 'Fabiola Fernandes', '', '', '2003-03-24', '5803742', 'PB', 37, 'Manaíra', 'Rua Dr. Ovídio Pessoa', '246', 2147483647, 2147483647),
(1, 1, 3, 0, '93714752898', 'renatapereira@outlook.com', 'Renata Pereira', '', '', '2003-03-24', '3604819', 'MG', 23, 'Vila Ideal', 'Rua Marciano Pinto', '345', 2138520671, 2147483647);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

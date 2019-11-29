-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 29-Nov-2019 às 13:54
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `id11701742_focal`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabBanner`
--

CREATE TABLE `tabBanner` (
  `id` int(11) NOT NULL,
  `idPagina` int(11) DEFAULT NULL,
  `txtFileName` varchar(255) NOT NULL,
  `txtPath` varchar(500) NOT NULL,
  `txtTitle` varchar(255) DEFAULT NULL,
  `txtDescription` longtext DEFAULT NULL,
  `txtAlt` varchar(255) DEFAULT NULL,
  `intOrdenacao` int(11) DEFAULT 0,
  `txtUrl` varchar(500) DEFAULT '#',
  `txtTypeTarget` varchar(45) DEFAULT '_self',
  `txtIcone` varchar(255) DEFAULT 'img/avatars/default_olho.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabClasses`
--

CREATE TABLE `tabClasses` (
  `id` int(11) NOT NULL,
  `idMenuAdmin` int(11) NOT NULL,
  `txtClasse` varchar(100) NOT NULL,
  `txtMetodo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabClasses`
--

INSERT INTO `tabClasses` (`id`, `idMenuAdmin`, `txtClasse`, `txtMetodo`) VALUES
(1, 1, 'dashboard', 'index'),
(2, 6, 'user', 'action'),
(3, 6, 'user', 'new_user'),
(4, 6, 'user', 'alter_user'),
(5, 7, 'user', 'list_all_users'),
(6, 7, 'user', 'remove_user'),
(7, 7, 'user', 'alter_password_user'),
(8, 8, 'user', 'list_group'),
(9, 8, 'user', 'alter_group_access'),
(10, 9, 'client', 'index'),
(11, 11, 'banner', 'config_banner'),
(12, 12, 'contato', 'list_tipo_contato'),
(13, 13, 'produto', 'list_produtos'),
(14, 14, 'contato', 'list_contato_site'),
(15, 15, 'sobre', 'list_sobre'),
(16, 16, 'informacoes', 'list_informacoes'),
(17, 17, 'lugar', 'list_tipo_lugar'),
(18, 13, 'produto', 'list_diferencial_imovel'),
(19, 13, 'produto', 'list_obra_imovel'),
(20, 13, 'produto', 'list_all_especificacoes'),
(21, 13, 'produto', 'action_produto'),
(22, 13, 'produto', 'new_obra'),
(23, 13, 'produto', 'alter_obra'),
(24, 13, 'produto', 'alter_dados_obra'),
(25, 13, 'produto', 'remove_obra'),
(26, 13, 'produto', 'remove_imovel'),
(27, 13, 'produto', 'new_diferencial'),
(28, 13, 'produto', 'alter_diferencial'),
(29, 13, 'produto', 'alter_dados_diferencial'),
(30, 13, 'produto', 'remove_diferencial'),
(31, 13, 'produto', 'new_produto'),
(32, 13, 'produto', 'alter_produto'),
(33, 13, 'produto', 'alter_status_produto'),
(34, 13, 'produto', 'alter_capa'),
(35, 13, 'produto', 'new_especificacao'),
(36, 13, 'produto', 'alter_especificacao'),
(37, 13, 'produto', 'remove_especificacao'),
(38, 13, 'produto', 'imoveis_relacionados'),
(39, 13, 'produto', 'config_relacionados'),
(40, 13, 'ficha', 'list_ficha'),
(41, 13, 'ficha', 'new_ficha'),
(42, 13, 'ficha', 'alter_ficha'),
(43, 13, 'ficha', 'remove_ficha'),
(44, 17, 'lugar', 'new_tipo'),
(45, 17, 'lugar', 'alter_tipo'),
(46, 17, 'lugar', 'remove_tipo'),
(47, 15, 'sobre', 'action_sobre'),
(48, 15, 'sobre', 'alter_sobre'),
(49, 11, 'files', 'list_image');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabContatoSite`
--

CREATE TABLE `tabContatoSite` (
  `id` int(11) NOT NULL,
  `txtNome` varchar(255) NOT NULL,
  `txtEmail` varchar(255) NOT NULL,
  `txtTelefone` varchar(15) NOT NULL,
  `txtAssunto` varchar(55) NOT NULL,
  `txtMensagem` text NOT NULL,
  `datCreate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabContatoSite`
--

INSERT INTO `tabContatoSite` (`id`, `txtNome`, `txtEmail`, `txtTelefone`, `txtAssunto`, `txtMensagem`, `datCreate`) VALUES
(1, 'Lucas da Silva Moreira', 'Lucas@raised.com.br', '(41) 2562-15625', 'Comprar', 'Quero Comprar um Imóvel', '2016-10-10 14:39:16'),
(2, 'Lucas da Silva Moreira', 'Teste@teste.com.br', '(11) 4565-46546', 'sa dsad sa dsa d', 'ASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSAASDSA DSA DSA DSA DSA', '2016-10-17 19:47:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabDiferencialImovel`
--

CREATE TABLE `tabDiferencialImovel` (
  `id` int(11) NOT NULL,
  `idImovel` int(11) NOT NULL,
  `txtDescricao` text NOT NULL,
  `txtPathIcone` varchar(255) NOT NULL,
  `intOrdem` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabDiferencialImovel`
--

INSERT INTO `tabDiferencialImovel` (`id`, `idImovel`, `txtDescricao`, `txtPathIcone`, `intOrdem`) VALUES
(1, 0, 'asdasd as dasd ad asd!', 'img/site/c7c1e55615c2c1e1899720016b40253e.jpg', 0),
(4, 1, 'ddddddddddddddddddddddd', '', 1),
(5, 1, 'sad as dsad', '', 0),
(6, 1, 'sad asdas das d', '', 0),
(7, 1, 'asd asd asd asd ', '', 0),
(8, 1, 'asd asd asd asd sadasdsad', '', 0),
(9, 1, 'sadasdasdsa!', '', 0),
(10, 1, 'asd asdas dsad sd!', '', 0),
(11, 3, 'Teste de diferencial no sistema ', 'img/site/abd9e75114f56d6769dbf517572069f7.jpg', 0),
(12, 3, 'Segundo Teste de diferencial', 'img/site/0a14b5046457d966f63df7e44092368d.jpg', 0),
(13, 2, 'asdasdasd', '', 0),
(14, 2, 'sadasdasd', '', 0),
(15, 2, 'asdasdas', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabFichaTecnica`
--

CREATE TABLE `tabFichaTecnica` (
  `id` int(11) NOT NULL,
  `idImovel` int(11) NOT NULL,
  `txtFichaTecnica` varchar(45) NOT NULL,
  `txtConteudo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabFichaTecnica`
--

INSERT INTO `tabFichaTecnica` (`id`, `idImovel`, `txtFichaTecnica`, `txtConteudo`) VALUES
(1, 0, 'sadsadsa', 'dsadasdasd'),
(2, 0, 'asdasdas', 'dasdasd'),
(6, 2, 'sadsadsadsad', 'asdsad,sadsad,asdsada sdas d'),
(7, 3, 'sadasdasd', 'adasdas,sadasdas,asdasdasd,asdsad,asdsadsadsad,1'),
(8, 3, 'asdsad', 'dasdasdasd,asdsad,sadasdsad');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabGroupAccess`
--

CREATE TABLE `tabGroupAccess` (
  `id` int(11) NOT NULL,
  `txtTituloGroupAccess` varchar(45) NOT NULL,
  `txtRandonNumber` varchar(45) NOT NULL,
  `bitVisivel` int(11) NOT NULL DEFAULT 1 COMMENT 'Informa se este grupo de ser utilizado quando for realizado o cadastro de um novo usuário\n0 - não poderá ser utilizado\n1 - poderá ser utilizado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabGroupAccess`
--

INSERT INTO `tabGroupAccess` (`id`, `txtTituloGroupAccess`, `txtRandonNumber`, `bitVisivel`) VALUES
(1, 'Administrativo', 'administra', 1),
(2, 'Usuário padrão', 'user_padrao', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabGroupAccessMenuAdmin`
--

CREATE TABLE `tabGroupAccessMenuAdmin` (
  `id` int(11) NOT NULL,
  `idGroupAccess` int(11) NOT NULL,
  `idMenuAdmin` int(11) NOT NULL,
  `txtPermissoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabGroupAccessMenuAdmin`
--

INSERT INTO `tabGroupAccessMenuAdmin` (`id`, `idGroupAccess`, `idMenuAdmin`, `txtPermissoes`) VALUES
(486, 2, 1, NULL),
(487, 2, 14, NULL),
(488, 2, 15, NULL),
(489, 2, 12, NULL),
(490, 2, 16, NULL),
(491, 2, 11, NULL),
(492, 2, 3, NULL),
(493, 2, 5, NULL),
(494, 2, 7, NULL),
(495, 2, 2, NULL),
(496, 2, 4, NULL),
(497, 2, 10, NULL),
(511, 1, 1, NULL),
(512, 1, 13, NULL),
(513, 1, 14, NULL),
(514, 1, 16, NULL),
(515, 1, 11, NULL),
(516, 1, 3, NULL),
(517, 1, 5, NULL),
(518, 1, 6, NULL),
(519, 1, 7, 'Editar;editar;1|Excluir;excluir;1|Alterar Senha;alterar_senha;1'),
(520, 1, 8, NULL),
(521, 1, 2, NULL),
(522, 1, 4, NULL),
(523, 1, 10, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabImovel`
--

CREATE TABLE `tabImovel` (
  `id` int(11) NOT NULL,
  `idTipoProduto` int(11) NOT NULL,
  `txtTituloImovel` varchar(255) NOT NULL,
  `txtDescricaoImovel` text NOT NULL,
  `txtBairro` varchar(55) NOT NULL,
  `txtEstado` varchar(55) NOT NULL COMMENT 'Sempre registrar em gramas o peso do produto',
  `txtMetragemPrivada` varchar(10) NOT NULL DEFAULT '0',
  `datLancamento` date NOT NULL,
  `datEntrega` date NOT NULL,
  `txtLatitude` varchar(10) DEFAULT NULL,
  `txtLongitude` varchar(10) DEFAULT NULL,
  `bitAtivo` int(11) NOT NULL DEFAULT 1,
  `txtUrlAmigavel` varchar(255) NOT NULL,
  `txtDescriptionSeo` varchar(255) NOT NULL,
  `txtPathDocumento` varchar(255) DEFAULT NULL,
  `idImoveisRelacionados` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabImovel`
--

INSERT INTO `tabImovel` (`id`, `idTipoProduto`, `txtTituloImovel`, `txtDescricaoImovel`, `txtBairro`, `txtEstado`, `txtMetragemPrivada`, `datLancamento`, `datEntrega`, `txtLatitude`, `txtLongitude`, `bitAtivo`, `txtUrlAmigavel`, `txtDescriptionSeo`, `txtPathDocumento`, `idImoveisRelacionados`) VALUES
(2, 1, 'Jaunas 1', 'Morbi eu urna non magna semper congue at vel odio. Phasellus convallis bibendum justo quis pretium. Duis laoreet orci tellus,\neget sagittis dui semper ut. Aliquam varius nisl ut condimentum auctor. Duis ut ante fermentum, pharetra nisl viverra, faucibus lacus.\nMorbi eu urna non magna semper congue at vel odio. Phasellus convallis bibendum justo quis pretium. Duis laoreet orci tellus,\neget sagittis dui semper ut. Aliquam varius nisl ut condimentum auctor. Duis ut ante fermentum, pharetra nisl viverra, faucibus lacus.', 'Villa Lobos', 'São Paulo', '50 a 200M²', '2016-10-13', '2016-01-01', '', '', 1, 'Testedeurl', 'Teste', '/assets/documentos/4fabea211794d2c88b3e2935bf5d1718.pdf', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabInformacoesContato`
--

CREATE TABLE `tabInformacoesContato` (
  `id` int(11) NOT NULL,
  `txtTitulo` varchar(45) NOT NULL,
  `txtIconeContato` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabInformacoesContato`
--

INSERT INTO `tabInformacoesContato` (`id`, `txtTitulo`, `txtIconeContato`) VALUES
(1, 'RUA ALAMEDA BRASIL, 685 - MOOCA - SP', 'img/site/d43417f6a547f62bd51ee635f376c7b2.png'),
(2, 'CONTATO@FOCALINC.COM.BR', 'img/site/587ba0728fe1fb52040e9c5cf4d08c12.png'),
(3, '(11) 3774-0166', 'img/site/147f992c21e9a31f74335ee1190e482d.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabLugaresProximos`
--

CREATE TABLE `tabLugaresProximos` (
  `id` int(11) NOT NULL,
  `idImovel` int(11) NOT NULL,
  `idProximidades` int(11) NOT NULL,
  `txtLugarProximo` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabLugaresProximos`
--

INSERT INTO `tabLugaresProximos` (`id`, `idImovel`, `idProximidades`, `txtLugarProximo`) VALUES
(1, 0, 0, 'PÉ NO PARQUE'),
(2, 0, 0, 'TANAKA'),
(3, 0, 0, 'DJAPA'),
(4, 0, 0, ''),
(5, 0, 0, ''),
(6, 0, 0, 'PÉ NO PARQUE'),
(7, 0, 0, 'TANAKA'),
(8, 0, 0, ''),
(9, 0, 0, 'PIZZARIA NACIONAL'),
(10, 0, 0, 'BAR DO ALEMÃO'),
(11, 0, 0, ''),
(12, 0, 0, 'TANAKA'),
(13, 0, 0, 'DJAPA'),
(14, 0, 0, ''),
(15, 0, 0, 'BAR DO ALEMÃO'),
(21, 0, 0, ''),
(22, 0, 0, ''),
(23, 0, 0, ''),
(24, 0, 0, ''),
(25, 0, 0, ''),
(26, 0, 0, 'asdasdasd'),
(27, 0, 0, 'aaaaaaaaaaaaaaaaaa'),
(28, 0, 0, 'dsadsadsad'),
(29, 0, 0, 'dsadsadsad'),
(30, 0, 0, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(31, 0, 0, 'sadasdasdasdsadasd'),
(32, 0, 0, 'asdsadasd');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabMaisInformacoes`
--

CREATE TABLE `tabMaisInformacoes` (
  `id` int(11) NOT NULL,
  `txtNome` varchar(255) NOT NULL,
  `txtTelefone` varchar(15) NOT NULL,
  `txtEmail` varchar(255) NOT NULL,
  `txtMensagem` text NOT NULL,
  `datCreate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabMaisInformacoes`
--

INSERT INTO `tabMaisInformacoes` (`id`, `txtNome`, `txtTelefone`, `txtEmail`, `txtMensagem`, `datCreate`) VALUES
(1, 'Lucas da Silva Moreira', '(54) 6546-45645', 'Teste@teste.com.br', 'SAD ASDSA DAS DSAD ASDSA DAS DSAD ASDSA DAS DSAD ASDSA DAS DSAD ASDSA DAS DSAD ASDSA DAS DSAD ASDSA DAS D', '2016-10-19 13:57:00'),
(2, 'Lucas da Silva Moreira', '(45) 6546-45654', 'Teste@teste.com.br', 'sad asdsa das dsa das dsa das d', '2016-10-19 17:32:46'),
(3, 'asdasdasd', '(54) 6456-45654', 'asdasdasd@dsaufhdsuhf.com', 'asdas das das das d asdas d', '2016-10-19 18:26:20'),
(4, 'Lucas da Silva Moreira', '(54) 6456-54654', 'Teste@teste.com.br', 'ASD ASDSA DAS DASD ASDSA DAS DASD ASDSA DAS DASD ASDSA DAS DASD ASDSA DAS D', '2016-10-19 19:25:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabMedia`
--

CREATE TABLE `tabMedia` (
  `id` int(11) NOT NULL,
  `idReferencia` int(11) NOT NULL COMMENT 'ID da tabela de referencia, por exemplo:\nSe a imagem faz referencia ao Segmento, então é o ID do segmento',
  `txtReferencia` varchar(45) NOT NULL COMMENT 'ID da tabela de referencia, por exemplo:\nSe a imagem faz referencia ao Segmento, então é o nome da tabela de Segmento',
  `txtFileName` varchar(255) NOT NULL COMMENT 'Nome do arquivo',
  `txtPath` varchar(500) NOT NULL COMMENT 'Caminho onde a imagem está localizada e o nome da imagem',
  `txtTitle` varchar(255) DEFAULT NULL COMMENT 'Título que será dado a imagem',
  `txtTipo` varchar(45) NOT NULL DEFAULT 'Escolha um Tipo',
  `intOrdenacao` int(11) NOT NULL DEFAULT 999 COMMENT 'Ordem que a imagem será exibida caso existam outras imagens para o mesmo idReferencia',
  `bitCapa` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabMedia`
--

INSERT INTO `tabMedia` (`id`, `idReferencia`, `txtReferencia`, `txtFileName`, `txtPath`, `txtTitle`, `txtTipo`, `intOrdenacao`, `bitCapa`) VALUES
(1, 1, 'tabProduto', '2bb3f399388e27643a9074076c46b72d.png', 'img/site/2bb3f399388e27643a9074076c46b72d.png', '2bb3f399388e27643a9074076c46b72d.png', 'lazer', 999, 0),
(6, 1, 'tabPlanta', '457a2550135bfad24f741856d37046ec.jpg', 'img/site/457a2550135bfad24f741856d37046ec.jpg', '457a2550135bfad24f741856d37046ec.jpg', 'Escolha um Tipo', 0, 0),
(7, 2, 'tabProduto', '426a1a857ba0ee5991fb4ba0d72b8c06.jpg', 'img/site/426a1a857ba0ee5991fb4ba0d72b8c06.jpg', '426a1a857ba0ee5991fb4ba0d72b8c06.jpg', 'relacionado', 999, 1),
(8, 2, 'tabProduto', 'b852251ff46465981d2dc64e5e9f44c6.jpg', 'img/site/b852251ff46465981d2dc64e5e9f44c6.jpg', 'b852251ff46465981d2dc64e5e9f44c6.jpg', 'banner', 1, 0),
(9, 3, 'tabProduto', '79d2d9ba1bc4524c9a423d2f8c470989.jpg', 'img/site/79d2d9ba1bc4524c9a423d2f8c470989.jpg', '79d2d9ba1bc4524c9a423d2f8c470989.jpg', 'Escolha um Tipo', 999, 1),
(10, 2, 'tabProduto', '80dbd2100f6fe07781df06df806a0a98.jpg', 'img/site/80dbd2100f6fe07781df06df806a0a98.jpg', '80dbd2100f6fe07781df06df806a0a98.jpg', 'banner', 999, 0),
(11, 2, 'tabProduto', '6c7db8c0f1e84b18292cd8b92da9147d.jpg', 'img/site/6c7db8c0f1e84b18292cd8b92da9147d.jpg', '6c7db8c0f1e84b18292cd8b92da9147d.jpg', 'banner', 999, 0),
(12, 3, 'tabProduto', '7fbe49f101fedfecfcc01615ca177828.jpg', 'img/site/7fbe49f101fedfecfcc01615ca177828.jpg', '7fbe49f101fedfecfcc01615ca177828.jpg', 'banner', 999, 0),
(13, 3, 'tabProduto', 'd7d25d20162d6e255bf23b6da916fd67.jpg', 'img/site/d7d25d20162d6e255bf23b6da916fd67.jpg', 'd7d25d20162d6e255bf23b6da916fd67.jpg', 'banner', 999, 0),
(14, 3, 'tabProduto', '773b9bc6f6d65a4df9a0e9c07ffc3c20.jpg', 'img/site/773b9bc6f6d65a4df9a0e9c07ffc3c20.jpg', '773b9bc6f6d65a4df9a0e9c07ffc3c20.jpg', 'fachada', 999, 0),
(15, 3, 'tabProduto', '19b016af3273880ef437841687a3876b.jpg', 'img/site/19b016af3273880ef437841687a3876b.jpg', '19b016af3273880ef437841687a3876b.jpg', 'fachada', 999, 0),
(16, 3, 'tabProduto', 'aca42894b04d842d5cbc52c3714c134a.jpg', 'img/site/aca42894b04d842d5cbc52c3714c134a.jpg', 'aca42894b04d842d5cbc52c3714c134a.jpg', 'fachada', 999, 0),
(17, 3, 'tabProduto', 'de35a253a2ed9ca9df29c4e3b209b1df.jpg', 'img/site/de35a253a2ed9ca9df29c4e3b209b1df.jpg', 'de35a253a2ed9ca9df29c4e3b209b1df.jpg', 'lazer', 999, 0),
(18, 3, 'tabProduto', '61f129e411be8fd3c8e5c85bc548b0fe.jpg', 'img/site/61f129e411be8fd3c8e5c85bc548b0fe.jpg', '61f129e411be8fd3c8e5c85bc548b0fe.jpg', 'lazer', 999, 0),
(19, 3, 'tabProduto', '4166141dbc383d236f8793c5882384e3.jpg', 'img/site/4166141dbc383d236f8793c5882384e3.jpg', '4166141dbc383d236f8793c5882384e3.jpg', 'lazer', 999, 0),
(20, 3, 'tabProduto', 'ac81267b98aee18cee49856a4c1c8b1a.jpg', 'img/site/ac81267b98aee18cee49856a4c1c8b1a.jpg', 'ac81267b98aee18cee49856a4c1c8b1a.jpg', 'apartamento', 999, 0),
(21, 3, 'tabProduto', 'a967f8b7acabdba7e4cf0845d8b994e1.jpg', 'img/site/a967f8b7acabdba7e4cf0845d8b994e1.jpg', 'a967f8b7acabdba7e4cf0845d8b994e1.jpg', 'apartamento', 999, 0),
(22, 3, 'tabProduto', '3fe04bb32fcd5b7aa59cce24fb88d128.jpg', 'img/site/3fe04bb32fcd5b7aa59cce24fb88d128.jpg', '3fe04bb32fcd5b7aa59cce24fb88d128.jpg', 'apartamento', 999, 0),
(23, 3, 'tabProduto', '180abc9670cef9a06a0a59023be2bc98.jpg', 'img/site/180abc9670cef9a06a0a59023be2bc98.jpg', '180abc9670cef9a06a0a59023be2bc98.jpg', 'apartamento', 999, 0),
(24, 3, 'tabProduto', '70bf012a7449004b807418e32aa8aebb.jpg', 'img/site/70bf012a7449004b807418e32aa8aebb.jpg', '70bf012a7449004b807418e32aa8aebb.jpg', 'fachada', 999, 0),
(25, 3, 'tabProduto', '5e4b1734ef0f3d5d4368b7ef08adae76.jpg', 'img/site/5e4b1734ef0f3d5d4368b7ef08adae76.jpg', '5e4b1734ef0f3d5d4368b7ef08adae76.jpg', 'lazer', 999, 0),
(27, 3, 'tabPlanta', '9524f4a3d8b748ef33f5757312daed7f.jpg', 'img/site/9524f4a3d8b748ef33f5757312daed7f.jpg', '9524f4a3d8b748ef33f5757312daed7f.jpg', 'apartamento', 999, 0),
(28, 3, 'tabPlanta', '72fd38f2c575f08805f258bdf99a6ae3.png', 'img/site/72fd38f2c575f08805f258bdf99a6ae3.png', '72fd38f2c575f08805f258bdf99a6ae3.png', 'apartamento', 1, 0),
(30, 3, 'tabPlanta', '83bbe6420a82fa834ac47064873bc967.png', 'img/site/83bbe6420a82fa834ac47064873bc967.png', '83bbe6420a82fa834ac47064873bc967.png', 'duplex', 999, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabMenuAdmin`
--

CREATE TABLE `tabMenuAdmin` (
  `id` int(11) NOT NULL,
  `idMenuPrincipal` int(11) DEFAULT NULL,
  `idMenuCabecalho` int(11) DEFAULT NULL,
  `txtIcone` varchar(100) DEFAULT NULL,
  `txtMenu` varchar(45) NOT NULL,
  `txtIdMenu` varchar(45) NOT NULL,
  `txtUrl` varchar(45) DEFAULT NULL,
  `intOrdem` int(11) NOT NULL,
  `bitCabecalho` int(11) DEFAULT NULL,
  `bitOculto` int(11) NOT NULL DEFAULT 0 COMMENT 'Informa se o menu é Oculto, para que o usuário possa ter acesso a uma página que não está presente ao menu\n0 - Oculto\n1 - Visível',
  `txtButtonAction` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabMenuAdmin`
--

INSERT INTO `tabMenuAdmin` (`id`, `idMenuPrincipal`, `idMenuCabecalho`, `txtIcone`, `txtMenu`, `txtIdMenu`, `txtUrl`, `intOrdem`, `bitCabecalho`, `bitOculto`, `txtButtonAction`) VALUES
(1, 0, 0, 'si si-speedometer', 'Dashboard', 'dashboard', 'dashboard', 1, 0, 0, NULL),
(2, 0, 0, NULL, 'Perfil do Usuário', 'perfil-do-usuario', NULL, 995, 1, 0, NULL),
(3, 0, 2, 'si si-user', 'Meu Perfil', 'meu-perfil', 'user/perfil-user', 996, 0, 0, NULL),
(4, 0, 0, NULL, 'Configuração de Acesso', 'config-acesso', NULL, 997, 1, 0, NULL),
(5, 0, 4, 'si si-users', 'Usuários', 'usuarios', NULL, 998, 0, 0, NULL),
(6, 5, 0, NULL, 'Novo Usuário', 'novo-usuario', 'user/action', 1, 0, 0, NULL),
(7, 5, 0, NULL, 'Listar usuários', 'all-users', 'user/list-all-users', 2, 0, 0, 'a:3:{i:0;a:3:{i:0;s:6:\"Editar\";i:1;s:6:\"editar\";i:2;s:1:\"0\";}i:1;a:3:{i:0;s:7:\"Excluir\";i:1;s:7:\"excluir\";i:2;s:1:\"0\";}i:2;a:3:{i:0;s:13:\"Alterar Senha\";i:1;s:13:\"alterar_senha\";i:2;s:1:\"0\";}}'),
(8, 5, 0, NULL, 'Grupos de Acesso', 'grupos-de-acesso', 'user/list-group', 3, 0, 0, NULL),
(9, 0, 0, 'si si-users', 'Clientes', 'clientes', 'client', 20, 0, 0, NULL),
(10, 0, 0, NULL, 'Configurações Gerais', 'config-produto', NULL, 31, 1, 0, NULL),
(11, 0, 10, 'fa fa-file-image-o', 'Banner', 'banner', 'banner/config-banner', 36, 0, 0, NULL),
(12, 0, 10, 'fa fa-comment-o', 'Informações de Contato', 'tipo-contato', 'contato/list-tipo-contato', 35, 0, 0, NULL),
(13, 0, 10, 'fa fa-building-o', 'Home', 'produtos', 'produto/list-produtos', 32, 0, 0, NULL),
(14, 0, 10, 'si si-bar-chart', 'Listar Contatos', 'contato', 'contato/list-contato-site', 33, 0, 0, NULL),
(15, 0, 10, 'si si-pin', 'Focal Inc', 'focal', 'sobre/list-sobre', 34, 0, 0, NULL),
(16, 0, 10, 'fa fa-align-left', 'Listar Mais Informações', 'informacoes', 'informacoes/list-informacoes', 35, 0, 0, NULL),
(17, 0, 10, 'si si-directions', 'Tipo de Lugar', 'tipo-lugar', 'lugar/list-tipo-lugar', 37, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabProximidades`
--

CREATE TABLE `tabProximidades` (
  `id` int(11) NOT NULL,
  `txtProximidade` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabProximidades`
--

INSERT INTO `tabProximidades` (`id`, `txtProximidade`) VALUES
(6, 'aaaaaaaaaaaaaaaaaa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabSobre`
--

CREATE TABLE `tabSobre` (
  `id` int(11) NOT NULL,
  `txtTitulo` varchar(45) NOT NULL,
  `txtDescricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabSobre`
--

INSERT INTO `tabSobre` (`id`, `txtTitulo`, `txtDescricao`) VALUES
(1, 'FOCAL INC', 'MORBI EU URNA NON MAGNA SEMPER CONGUE AT VEL ODIO. PHASELLUS CONVALLIS BIBENDUM JUSTO QUIS PRETIUM. DUIS LAOREET ORCI TELLUS,EGET SAGITTIS DUI SEMPER UT. ALIQUAM VARIUS NISL UT CONDIMENTUM AUCTOR. DUIS UT ANTE FERMENTUM, PHARETRA NISL VIVERRA, FAUCIBUS LACUS.\n'),
(2, 'DIGA OLÁ', 'INTEGER ACCUMSAN ID DUI ET MOLLIS. SUSPENDISSE AC LOREM VEL AUGUE EGESTAS ELEIFEND'),
(3, 'MAIS INFORMAÇÕES', 'INTEGER ACCUMSAN ID DUI ET MOLLIS. SUSPENDISSE AC LOREM VEL AUGUE EGESTAS ELEIFEND');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabStatusObra`
--

CREATE TABLE `tabStatusObra` (
  `id` int(11) NOT NULL,
  `idImovel` int(11) NOT NULL,
  `txtTitulo` varchar(255) NOT NULL,
  `intPorcentagem` int(11) NOT NULL,
  `intOrdem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabStatusObra`
--

INSERT INTO `tabStatusObra` (`id`, `idImovel`, `txtTitulo`, `intPorcentagem`, `intOrdem`) VALUES
(1, 1, 'PROJETOS EXECUTIVOS', 50, 1),
(2, 2, 'sadadasdasd', 10, 0),
(3, 3, 'PROJETOS EXECUTIVOS', 70, 0),
(4, 3, 'FUNDAÇÃO', 60, 0),
(5, 3, 'ESTRUTURA', 50, 0),
(6, 3, 'ALVENARIA', 40, 0),
(7, 3, 'INSTALAÇÃO', 10, 0),
(8, 4, 'asdasdasdas', 10, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabTemplateEmail`
--

CREATE TABLE `tabTemplateEmail` (
  `id` int(11) NOT NULL,
  `txtTitulo` varchar(255) NOT NULL,
  `txtMensagem` text NOT NULL,
  `tabTemplate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabTemplateEmail`
--

INSERT INTO `tabTemplateEmail` (`id`, `txtTitulo`, `txtMensagem`, `tabTemplate`) VALUES
(2, 'Um novo contato foi feito através do site', 'Uma nova solicitação de contato foi realizada através do site', 'contato.html');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabTipoProduto`
--

CREATE TABLE `tabTipoProduto` (
  `id` int(11) NOT NULL,
  `txtTipoProduto` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabTipoProduto`
--

INSERT INTO `tabTipoProduto` (`id`, `txtTipoProduto`) VALUES
(1, 'Lançamento'),
(2, 'Construção'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabUsuarioAdministrativo`
--

CREATE TABLE `tabUsuarioAdministrativo` (
  `id` int(11) NOT NULL,
  `idGroupAccess` int(11) NOT NULL,
  `txtNome` varchar(150) NOT NULL,
  `txtLogin` varchar(45) DEFAULT NULL,
  `txtEmail` varchar(255) NOT NULL,
  `txtSenha` varchar(255) NOT NULL,
  `bitAtivo` tinyint(1) NOT NULL DEFAULT 1,
  `bitDelete` int(11) NOT NULL DEFAULT 0 COMMENT 'Informa de este usuário pode ser excluído do sistema ou desativado\n\n0 - pode ser excluído e desativado\n1 - não pode ser excluído ou desativado',
  `datCreate` timestamp NULL DEFAULT current_timestamp(),
  `txtPathAvatar` varchar(255) DEFAULT 'img/avatars/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tabUsuarioAdministrativo`
--

INSERT INTO `tabUsuarioAdministrativo` (`id`, `idGroupAccess`, `txtNome`, `txtLogin`, `txtEmail`, `txtSenha`, `bitAtivo`, `bitDelete`, `datCreate`, `txtPathAvatar`) VALUES
(1, 1, 'Zarpou', 'zarpou', 'admin@zarpou.com.br', '040bd08a4290267535cd247b8ba2eca129d9fe9f', 1, 0, '2016-09-19 19:26:30', 'img/avatars/e4219f03313aa560b6cada7c3cdeae95.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tabBanner`
--
ALTER TABLE `tabBanner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tabBanner_tabPagina1_idx` (`idPagina`);

--
-- Índices para tabela `tabClasses`
--
ALTER TABLE `tabClasses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tabClasses_tabMenuAdmin1_idx` (`idMenuAdmin`);

--
-- Índices para tabela `tabContatoSite`
--
ALTER TABLE `tabContatoSite`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tabDiferencialImovel`
--
ALTER TABLE `tabDiferencialImovel`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tabFichaTecnica`
--
ALTER TABLE `tabFichaTecnica`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

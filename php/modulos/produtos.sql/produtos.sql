-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Nov-2021 às 21:09
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `erp_parrot_varejo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `custo` varchar(255) NOT NULL,
  `preco` varchar(255) NOT NULL,
  `peso` varchar(255) NOT NULL,
  `dimensoes` varchar(255) NOT NULL,
  `data_lancamento` date NOT NULL,
  `slug` varchar(255) NOT NULL,
  `id_categoria` varchar(255) NOT NULL,
  `status` enum('Lançamento','Em Estoque','Esgotado','') NOT NULL,
  `id_fornecedor` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `dt_atualizacao` datetime NOT NULL,
  `dt_exclusao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `hash`, `nome`, `custo`, `preco`, `peso`, `dimensoes`, `data_lancamento`, `slug`, `id_categoria`, `status`, `id_fornecedor`, `descricao`, `dt_cadastro`, `dt_atualizacao`, `dt_exclusao`) VALUES
(1, 'd41d8cd98f00b204e9800998ecf8427e', 'Acer Switf', '1945.00', '1858.00', '2 kg', '40x52x45 cm', '2021-11-03', 'notebook acer', 'notebook', 'Lançamento', '6a0e7e5ddeaaae59cf5f67a3c96f8dc6', 'O Acer Swift5 da Acer foi lançado em 08/09/2021.\r\nEle chegou com processador Intel® Core™ i5-1135G7 , placa de vídeo Intel Iris Xe Graphics , memória RAM de 8 GB LPDDR4X 2666 MHz, e armazenamento de 512 GB (NVMe SSD).', '2021-11-17 20:53:29', '2021-11-17 20:53:29', '2021-11-17 20:53:29'),
(8, '73dc4e5786b5799d62f8dcc982c02467', 'Lenovo IdeaPad S145', 'R$ 1.935,99', 'R$ 1.935,99', '2 Kg', '52x41x65 cm', '2021-06-12', 'notebook lenovo', 'notebook', 'Lançamento', 'f14dfd88013018ae17487d725046c10b', 'O Lenovo IdeaPad S145 traz processador Intel Core i5 8265U de 8ª Geração, 8GB de memória RAM, HD de 1TB de capacidade, tela de 15,6\" HD, sua placa de vídeo é integrada e Windows 10.\r\n\r\nDimensões (LxPxA): 362,2 x 251,5 x 19,9 mm\r\nPeso: 1.85Kg', '2021-11-17 17:04:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fornecedores` (`id_fornecedor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_fornecedores` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`hash`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

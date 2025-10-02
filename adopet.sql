-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/10/2025 às 23:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `adopet`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adocoes`
--

CREATE TABLE `adocoes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL,
  `data_adocao` timestamp NOT NULL DEFAULT current_timestamp(),
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `adocoes`
--

INSERT INTO `adocoes` (`id`, `id_usuario`, `id_animal`, `data_adocao`, `observacoes`) VALUES
(1, 6, 1, '2025-10-02 20:54:30', 'Adoção registrada via painel');

-- --------------------------------------------------------

--
-- Estrutura para tabela `animais`
--

CREATE TABLE `animais` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `especie_outro` varchar(100) DEFAULT NULL,
  `raca` varchar(100) DEFAULT NULL,
  `idade` enum('Filhote','Adulto','Idoso') NOT NULL,
  `genero` enum('Macho','Fêmea') NOT NULL,
  `porte` enum('Pequeno','Medio','Grande') NOT NULL,
  `castrado` tinyint(1) DEFAULT NULL,
  `vacinado` tinyint(1) DEFAULT NULL,
  `vermifugado` tinyint(1) DEFAULT NULL,
  `descricao` text NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT 1,
  `status` enum('Ativo','Inativo','Adotado') DEFAULT 'Ativo',
  `id_usuario` int(11) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `animais`
--

INSERT INTO `animais` (`id`, `nome`, `id_especie`, `especie_outro`, `raca`, `idade`, `genero`, `porte`, `castrado`, `vacinado`, `vermifugado`, `descricao`, `foto_url`, `disponivel`, `status`, `id_usuario`, `data_cadastro`) VALUES
(1, 'Pimenta', 1, NULL, 'SRD', 'Filhote', 'Fêmea', 'Medio', 1, 1, 1, 'Cachorra extremamente enérgica e pronta para ter uma família!', 'animal_68ded395783172.08083600.jpg', 0, 'Ativo', 2, '2025-10-02 19:33:41'),
(2, 'Rex', 2, NULL, 'SRD', 'Adulto', 'Macho', 'Medio', 1, 1, 1, 'Gato branco peludo dócil', 'animal_68deea51d54a97.78666168.jpg', 1, 'Ativo', 7, '2025-10-02 21:10:41'),
(3, 'Miau', 2, NULL, 'SRD', 'Adulto', 'Macho', 'Pequeno', 0, 0, 0, 'Gato colorido', 'animal_68deeb4da8d3b4.50915383.jpg', 1, 'Ativo', 7, '2025-02-04 21:14:53'),
(4, 'Pipoca', 1, NULL, 'SRD', 'Filhote', 'Fêmea', 'Pequeno', 1, 1, 1, 'Pequena e querida', 'animal_68deebb926ab43.84019098.jpg', 1, 'Ativo', 3, '2025-10-02 21:16:41'),
(5, 'Frajola', 2, NULL, 'SRD', 'Adulto', 'Macho', 'Medio', 0, 0, 1, 'Gato frajola docil e amigavel', 'animal_68deec06abefa3.54041414.jpg', 1, 'Ativo', 2, '2025-06-02 21:17:58'),
(6, 'Tico', 1, NULL, 'SRD', 'Filhote', 'Macho', 'Pequeno', 0, 1, 0, 'Porte pequeno, vacinas em dia', 'animal_68deecd67273f2.86897557.jpg', 1, 'Ativo', 7, '2025-10-02 21:21:26'),
(7, 'Fantasma', 2, NULL, 'SRD', 'Idoso', 'Macho', 'Grande', 1, 1, 1, 'Gato laranja tranquilo, vacinas em dia', 'animal_68deed78a6c0c7.01301866.jpg', 1, 'Ativo', 7, '2024-06-03 21:24:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `pais` varchar(100) DEFAULT 'Brasil',
  `complemento` varchar(255) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `rua`, `numero`, `bairro`, `cep`, `cidade`, `estado`, `pais`, `complemento`, `data_cadastro`) VALUES
(1, 'Rua do Principe', '22', 'Centro', '89403222', 'Joinville', 'SC', 'Brasil', NULL, '2025-10-02 19:21:33'),
(2, 'Rua do Principe', '22', 'Centro', '89403-222', 'Joinville', 'SC', 'Brasil', NULL, '2025-10-02 19:22:33'),
(3, 'Rua Oliveiras', '33', 'Centro', '89403-343', 'Joinville', 'SC', 'Brasil', NULL, '2025-10-02 19:26:44'),
(6, 'Rua Oliveiras', '000800143', 'Centro', '89403343', 'Joinville', 'SC', 'Brasil', NULL, '2025-10-02 20:52:00'),
(7, 'Rua Rio Branco', '344', 'Centro', '89403343', 'Joinville', 'SC', 'Brasil', NULL, '2025-10-02 21:07:25');

-- --------------------------------------------------------

--
-- Estrutura para tabela `especies`
--

CREATE TABLE `especies` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `especies`
--

INSERT INTO `especies` (`id`, `nome`, `descricao`, `data_cadastro`) VALUES
(1, 'Cachorro', 'Cachorro', '2025-10-02 19:23:46'),
(2, 'Gato', 'Gato', '2025-10-02 19:23:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_adocao`
--

CREATE TABLE `historico_adocao` (
  `id` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL,
  `campo_alterado` varchar(100) NOT NULL,
  `valor_anterior` text DEFAULT NULL,
  `valor_alterado` text DEFAULT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico_adocao`
--

INSERT INTO `historico_adocao` (`id`, `id_animal`, `campo_alterado`, `valor_anterior`, `valor_alterado`, `data_alteracao`, `id_usuario`) VALUES
(1, 1, 'status_interesse', 'Pendente', 'Aprovado', '2025-10-02 20:53:40', 2),
(2, 1, 'disponivel', '1', '0', '2025-10-02 20:54:30', 2),
(3, 1, 'status_interesse_final', 'Aprovado', 'Adotado', '2025-10-02 20:54:30', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `interesses_adocao`
--

CREATE TABLE `interesses_adocao` (
  `id` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL,
  `id_interessado` int(11) NOT NULL,
  `status` enum('Pendente','Em Análise','Aprovado','Rejeitado','Adotado') DEFAULT 'Pendente',
  `mensagem_interessado` text DEFAULT NULL,
  `mensagem_doador` text DEFAULT NULL,
  `data_interesse` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `interesses_adocao`
--

INSERT INTO `interesses_adocao` (`id`, `id_animal`, `id_interessado`, `status`, `mensagem_interessado`, `mensagem_doador`, `data_interesse`) VALUES
(1, 1, 6, 'Adotado', 'Quero um amigo fiel', NULL, '2025-10-02 20:53:09'),
(2, 7, 6, 'Pendente', 'Gostaria muito de adota-lo!!!', NULL, '2025-10-02 21:25:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefones`
--

CREATE TABLE `telefones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `ddd` varchar(3) NOT NULL,
  `numero` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `telefones`
--

INSERT INTO `telefones` (`id`, `id_usuario`, `descricao`, `ddd`, `numero`) VALUES
(1, 2, NULL, '47', '90232-1129'),
(2, 3, NULL, '47', '92038-8204'),
(5, 6, NULL, '47', '92038-8203'),
(6, 7, NULL, '47', '92038-3445');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `descricao`) VALUES
(1, 'ONG'),
(2, 'Pessoa Fisica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('Ativo','Inativo','Bloqueado') DEFAULT 'Ativo',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `id_tipo_usuario`, `documento`, `id_endereco`, `descricao`, `status`, `data_cadastro`) VALUES
(2, 'Abrigo animal', 'abrigoanimal@gmail.com', '$2y$10$I702lsLMC7vGRxkfJlss0OHzJ4ueuyCwAWuSI8UKej94GMhqWxrvO', 1, '12.840.382/8282-22', 2, 'Ong para abrigar animais em abandono', 'Ativo', '2025-10-02 19:22:33'),
(3, 'Camila Almeida', 'camilaferreira@gmail.com', '$2y$10$N6noFkrXKqB8eiQWfF/5n.f6WiJnSX8awqJUmFE8f1.nL7GH19Yci', 2, '485.473.733-73', 3, '', 'Ativo', '2025-10-02 19:26:44'),
(6, 'joao cancelo', 'joaocancelo@gmail.com', '$2y$10$e1yI6OIHywgdr2F.u3ubVukbY.KYC6sSjKlMXAQ4r4ITjeklEmIUm', 2, '222.222.222-22', 6, '', 'Ativo', '2025-10-02 20:52:00'),
(7, 'Patas Felizes', 'patasfelizes@gmail.com', '$2y$10$C/84Oo59bM3sOGgQ1VjUEeshmnKR2b.Gsr4JttL3zf0qyqPbmaJRe', 1, '12.840.382/8282-66', 7, 'Ong patas felizes em joinville', 'Ativo', '2025-10-02 21:07:25');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adocoes`
--
ALTER TABLE `adocoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_animal` (`id_animal`);

--
-- Índices de tabela `animais`
--
ALTER TABLE `animais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_especie` (`id_especie`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `especies`
--
ALTER TABLE `especies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `historico_adocao`
--
ALTER TABLE `historico_adocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_animal` (`id_animal`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `interesses_adocao`
--
ALTER TABLE `interesses_adocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_animal` (`id_animal`),
  ADD KEY `id_interessado` (`id_interessado`);

--
-- Índices de tabela `telefones`
--
ALTER TABLE `telefones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descricao` (`descricao`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `id_endereco` (`id_endereco`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adocoes`
--
ALTER TABLE `adocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `animais`
--
ALTER TABLE `animais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `especies`
--
ALTER TABLE `especies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `historico_adocao`
--
ALTER TABLE `historico_adocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `interesses_adocao`
--
ALTER TABLE `interesses_adocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `telefones`
--
ALTER TABLE `telefones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `adocoes`
--
ALTER TABLE `adocoes`
  ADD CONSTRAINT `adocoes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `adocoes_ibfk_2` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`);

--
-- Restrições para tabelas `animais`
--
ALTER TABLE `animais`
  ADD CONSTRAINT `animais_ibfk_1` FOREIGN KEY (`id_especie`) REFERENCES `especies` (`id`),
  ADD CONSTRAINT `animais_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `historico_adocao`
--
ALTER TABLE `historico_adocao`
  ADD CONSTRAINT `historico_adocao_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`),
  ADD CONSTRAINT `historico_adocao_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `interesses_adocao`
--
ALTER TABLE `interesses_adocao`
  ADD CONSTRAINT `interesses_adocao_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`),
  ADD CONSTRAINT `interesses_adocao_ibfk_2` FOREIGN KEY (`id_interessado`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `telefones`
--
ALTER TABLE `telefones`
  ADD CONSTRAINT `telefones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

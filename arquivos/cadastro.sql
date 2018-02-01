-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 30/01/2018 às 23:02
-- Versão do servidor: 5.7.21-0ubuntu0.16.04.1
-- Versão do PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cadastro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cenarios`
--

CREATE TABLE `cenarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_cenario` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `permissao` varchar(30) NOT NULL,
  `descricao` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `cenarios`
--

INSERT INTO `cenarios` (`id`, `nome_cenario`, `id_user`, `permissao`, `descricao`, `path`) VALUES
(1, 'CenÃ¡rio 1', 1, 'pub', 'CenÃ¡rio simples para prÃ¡tica em uma mÃ¡quina', 'cenarios/cenario1'),
(2, 'CenÃ¡rio 2', 1, 'pub', 'Esse cenÃ¡rio contem trÃªs mÃ¡quinas e objetivo Ã© configurar o encaminhamento de pacotes na maquina Gateway', 'cenarios/cenario2'),
(3, 'Teste 01 - Banco de Dados', 1, 'pub', 'ConfiguraÃ§Ã£o de um servidor de Banco de Dados Postgres para o acesso remoto.', 'cenarios/cenario3'),
(4, 'Teste 02 - TCP-IP', 1, 'pub', 'CenÃ¡rio para a configuraÃ§Ã£o de configuraÃ§Ã£o de rotas e encaminhamento de pacotes.', 'cenarios/cenario4'),
(5, 'Teste 03 - SeguranÃ§a', 1, 'pub', 'CenÃ¡rio para configuraÃ§Ã£o de regras do iptables.', 'cenarios/cenario5'),
(6, 'CenÃ¡rio 1', 1, 'priv', 'CenÃ¡rio simples para prÃ¡tica em uma mÃ¡quina', 'cenarios/cenario6'),
(7, 'CenÃ¡rio 1', 1, 'priv', 'CenÃ¡rio simples para prÃ¡tica em uma mÃ¡quina', 'cenarios/cenario7'),
(8, 'Aaaa', 1, 'pub', 'addvsvsdvsvdvsd', 'cenarios/cenario8');

-- --------------------------------------------------------

--
-- Estrutura para tabela `containers`
--

CREATE TABLE `containers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cenario` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `matricula` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens`
--

CREATE TABLE `imagens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(30) NOT NULL,
  `versao` varchar(30) NOT NULL,
  `pacotes` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `imagens`
--

INSERT INTO `imagens` (`id`, `nome`, `versao`, `pacotes`) VALUES
(2, 'dvl-ubuntu-base', '1.0', 'base'),
(3, 'dvl-ubuntu-completo', '1.0', 'Completo'),
(4, 'dvl-bd-cliente', '1.0', 'ping, nano, net-tools'),
(5, 'dvl-bd-servidor', '1.0', 'ping, nano, net-tools'),
(6, 'dvl-tcpip-cliente', '1.0', 'traceroute, net-tools, ping. nano'),
(7, 'dvl-tcpip-servidor', '1.0', 'iptables, tracerout, net-tools, ping, nano, tcpdump'),
(8, 'dvl-seguranca-cliente', '1.0', 'net-tools, nano, ping, wget, nslookup'),
(9, 'dvl-seguranca-servidor', '1.0', 'net-tools, nano, ping, wget, ssh, iptables, tcpdump');

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina`
--

CREATE TABLE `maquina` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cenario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `imagem` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `maquina`
--

INSERT INTO `maquina` (`id`, `id_cenario`, `nome`, `imagem`) VALUES
(1, 1, 'Maquina', 'dvl_ubuntu_completo:1.0'),
(2, 2, 'Gateway', 'dvl_ubuntu_completo:1.0'),
(3, 2, 'Maquina01', 'dvl_ubuntu_completo:1.0'),
(4, 2, 'Maquina02', 'dvl_ubuntu_completo:1.0'),
(5, 3, 'Servidor', 'dvl_bd_servidor:1.0	'),
(6, 3, 'Cliente', 'dvl_bd_cliente:1.0	'),
(7, 4, 'Firewall', 'dvl_tcpip_servidor:1.0'),
(8, 4, 'Cliente01', 'dvl_tcpip_cliente:1.0'),
(9, 4, 'Cliente02', 'dvl_tcpip_cliente:1.0'),
(10, 5, 'firewall', 'dvl_seguranca_servidor:1.0'),
(11, 5, 'cliente', 'dvl_seguranca_cliente:1.0'),
(12, 6, 'Maquina', 'dvl_ubuntu_completo:1.0'),
(13, 7, 'Maquina', 'dvl_ubuntu_completo:1.0'),
(15, 8, 'cliente', 'dvl'),
(16, 8, 'servidor', 'dvl');

-- --------------------------------------------------------

--
-- Estrutura para tabela `redes`
--

CREATE TABLE `redes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(30) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `redes`
--

INSERT INTO `redes` (`id`, `nome`, `tipo`) VALUES
(1, 'bridge', 'bridge'),
(2, 'host', 'host'),
(3, 'none', 'null'),
(11, 'Rede_Alunos', 'bridge'),
(13, 'Rede1', 'bridge'),
(14, 'Rede2', 'bridge');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `login`, `senha`) VALUES
(1, 'master', 'root', 'root'),
(2, 'comum', 'walafi', 'H87PX52');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `cenarios`
--
ALTER TABLE `cenarios`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `containers`
--
ALTER TABLE `containers`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `imagens`
--
ALTER TABLE `imagens`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `maquina`
--
ALTER TABLE `maquina`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `redes`
--
ALTER TABLE `redes`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `cenarios`
--
ALTER TABLE `cenarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `containers`
--
ALTER TABLE `containers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `maquina`
--
ALTER TABLE `maquina`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de tabela `redes`
--
ALTER TABLE `redes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

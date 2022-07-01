-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01-Jul-2022 às 20:12
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sicoob_vue_software`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `accesses`
--

DROP TABLE IF EXISTS `accesses`;
CREATE TABLE IF NOT EXISTS `accesses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accesses` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accesses_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `accesses`
--

INSERT INTO `accesses` (`id`, `user_id`, `name`, `accesses`, `created_at`, `updated_at`) VALUES
(1, 1, 'Acesso Base', '{\"commissions\":\"operator\",\"accesses\":1,\"users\":1}', '2022-05-24 12:27:20', '2022-06-08 18:34:22'),
(2, 1, 'Geral Vendedor 2 oi tudo bem', '{\"commissions\":\"operator\",\"accesses\":1,\"users\":1}', '2022-05-24 12:27:20', '2022-06-27 19:30:38'),
(3, 1, 'Geral Indicador 3', '{\"commissions\":\"operator\",\"accesses\":1,\"users\":1}', '2022-05-24 12:27:20', '2022-06-27 19:30:40'),
(4, 1, 'testeasdds1\'', '{\"commissions\":\"operator\",\"accesses\":1,\"users\":1}', '2022-05-24 12:27:20', '2022-05-26 15:51:07'),
(5, 1, 'Geral Vendedor2', '{\"commissions\":\"indicator\",\"accesses\":1,\"users\":1}', '2022-05-24 12:27:20', '2022-06-27 19:30:50'),
(6, 1, 'teste 6', '{\"commissions\":\"seller\",\"accesses\":0,\"users\":0}', '2022-05-26 12:51:22', '2022-06-06 12:20:05'),
(8, 1, 'oidasd', '{\"commissions\":\"operator\",\"accesses\":1,\"users\":1}', '2022-05-26 12:53:46', '2022-06-06 12:20:20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `commissions`
--

DROP TABLE IF EXISTS `commissions`;
CREATE TABLE IF NOT EXISTS `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_indicator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_seller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_operator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(15,2) DEFAULT NULL,
  `custom_value` decimal(15,2) DEFAULT NULL,
  `commission_percentage` decimal(4,2) DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `operator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `indicator_commission` decimal(15,2) DEFAULT NULL,
  `seller_commission` decimal(15,2) DEFAULT NULL,
  `operator_commission` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commissions_user_id_foreign` (`user_id`),
  KEY `commissions_indicator_id_foreign` (`indicator_id`),
  KEY `commissions_seller_id_foreign` (`seller_id`),
  KEY `commissions_operator_id_foreign` (`operator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `commissions`
--

INSERT INTO `commissions` (`id`, `user_id`, `date_indicator`, `date_seller`, `date_operator`, `product`, `value`, `custom_value`, `commission_percentage`, `status`, `indicator_id`, `seller_id`, `operator_id`, `indicator_commission`, `seller_commission`, `operator_commission`, `created_at`, `updated_at`) VALUES
(1, 5, '2022-05-13 02:12', '2022-05-16 09:44', '2022-06-14 01:11', 'Seguro de Vida', '1545045.00', NULL, '3.44', 'Aprovado UPS', 1, 1, 5, '328.25', '984.75', '328.25', '2022-05-13 16:50:14', '2022-06-20 18:12:41'),
(9, 5, '2022-05-11 01:03', NULL, NULL, 'Seguro Animal de Elite', NULL, NULL, NULL, 'Aguard. Venda', 1, NULL, NULL, NULL, NULL, NULL, '2022-05-13 17:46:37', '2022-06-08 18:27:56'),
(3, 5, '2022-05-13 03:14', NULL, NULL, 'Consórcio', NULL, NULL, '3.00', 'Aguard. Venda', 4, NULL, NULL, NULL, NULL, NULL, '2022-05-13 16:07:46', '2022-05-23 17:10:14'),
(4, 5, '2022-05-19 04:33', '2022-05-13 03:19', '2022-05-20 03:16', 'Seguro de Vida - Sicoob Seguradora', '6000.00', NULL, '30.00', 'Aprovado UPS', 2, 3, 2, '11.12', '33.35', '11.12', '2022-05-13 16:09:22', '2022-05-19 19:16:43'),
(5, 5, '2022-05-03 11:54', NULL, NULL, 'Seguro Residencial e Empresarial', NULL, NULL, NULL, 'Não Vendido', 4, 9, NULL, NULL, NULL, NULL, '2022-05-13 16:06:30', '2022-06-27 19:30:06'),
(6, 5, '2022-05-17 02:10', '2022-06-08 02:15', '2022-04-01 02:18', 'Seguro Agrícola', '3499.99', NULL, '23.00', 'Aprovado UPS', 2, 4, 7, '4.97', '14.91', '4.97', '2022-05-13 16:33:33', '2022-06-27 19:30:17'),
(7, 5, '2022-05-18 06:29', '2022-05-13 02:13', '2022-06-14 03:16', 'Seguro Prestamista', '17000.02', '600.00', '40.00', 'Aprovado UPS', 4, 1, 3, '1.48', '4.45', '1.48', '2022-05-13 16:35:09', '2022-06-20 18:19:01'),
(10, 5, '2022-05-12 02:16', '2022-05-13 02:54', NULL, 'Seguro de Vida', '400.00', NULL, '20.00', 'Aguard. UPS', 6, 4, NULL, NULL, NULL, NULL, '2022-05-13 17:58:38', '2022-06-24 15:25:24'),
(13, 1, '2022-05-22 08:41', NULL, NULL, 'Seguro de Vida', NULL, NULL, NULL, 'Aguard. Venda', 1, NULL, NULL, NULL, NULL, NULL, '2022-05-23 15:37:44', '2022-05-23 15:37:44'),
(14, 6, '2022-05-23 08:11', '2022-05-23 08:09', '2022-06-29 04:17', 'Seguro Auto', '3400.00', NULL, '70.00', 'Recusado UPS', 2, 5, 8, NULL, NULL, NULL, '2022-05-23 18:40:05', '2022-06-28 12:30:16'),
(11, 5, '2022-05-19 03:14', '2022-05-20 03:15', '2022-05-21 03:17', 'Seguro de Vida', '122.22', NULL, '20.00', 'Recusado UPS', 1, 15, 12, NULL, NULL, NULL, '2022-05-19 18:23:54', '2022-06-27 19:29:27'),
(12, 5, '2022-05-19 03:15', NULL, NULL, 'Consórcio', NULL, NULL, '3.00', 'Não Vendido', 2, 2, NULL, NULL, NULL, NULL, '2022-05-19 18:24:28', '2022-05-23 15:42:25'),
(15, 10, '2022-05-22 10:13', NULL, NULL, 'Seguro Agrícola', NULL, NULL, NULL, 'Aguard. Venda', 10, NULL, NULL, NULL, NULL, NULL, '2022-05-23 18:43:47', '2022-05-23 18:43:47'),
(18, 1, '2022-05-30 07:12', '2022-06-09 02:12', NULL, 'Seguro de Vida', '5556.66', NULL, '54.55', 'Aguard. UPS', 1, 8, NULL, NULL, NULL, NULL, '2022-05-30 12:05:43', '2022-06-28 12:19:11'),
(17, 7, '2022-05-24 01:14', '2022-05-05 00:07', '2022-05-25 04:15', 'Seguro Auto', '1000.00', NULL, '10.00', 'Aprovado UPS', 4, 1, 5, '0.62', '1.85', '0.62', '2022-05-24 17:07:40', '2022-05-24 17:15:17'),
(19, 15, '2022-06-08 00:05', '2022-06-09 03:15', '2022-06-10 03:17', 'Seguro de Vida', '50000.00', NULL, '15.00', 'Aprovado UPS', 1, 6, 15, '46.32', '138.96', '46.32', '2022-06-08 17:55:36', '2022-06-08 17:56:35'),
(20, 15, '2022-06-08 02:15', '2022-06-09 03:15', '2022-06-20 08:40', 'Crédito Consignado', '2232.33', NULL, '23.33', 'Aprovado UPS', 15, 2, 1, '4.02', '12.06', '4.02', '2022-06-08 18:30:17', '2022-06-09 16:11:40'),
(21, 1, '2022-06-02 02:10', '2022-06-03 02:10', '2022-06-08 02:10', 'Seguro Residencial e Empresarial', '43242.34', NULL, '43.43', 'Aprovado UPS', 1, 1, 3, '115.99', '347.96', '115.99', '2022-06-09 13:59:18', '2022-06-09 13:59:18'),
(22, 1, '2022-05-01 03:01', '2022-05-02 05:12', '2022-03-24 00:04', 'Seguro de Vida Coletivo', '80000.00', NULL, '50.00', 'Aprovado UPS', 2, 5, 4, '247.04', '741.12', '247.04', '2022-06-21 16:00:29', '2022-06-21 16:01:22'),
(23, 1, '2022-06-23 03:15', '2022-06-24 04:19', '2022-06-24 04:20', 'Seguro Animal de Elite', '5454.44', NULL, '22.22', 'Aprovado UPS', 1, 2, 5, '7.49', '22.46', '7.49', '2022-06-23 16:48:07', '2022-06-23 16:48:07'),
(24, 1, '2022-06-24 04:20', '2022-06-17 03:16', '2022-06-24 04:20', 'Seguro Equipamentos', '5645.45', NULL, '34.34', 'Aprovado UPS', 4, 4, 5, '11.97', '35.92', '11.97', '2022-06-23 16:49:02', '2022-06-28 12:26:28'),
(25, 1, '2022-06-09 02:11', '2022-06-23 03:13', '2022-06-18 03:16', 'Consórcio', '5467.77', NULL, '3.00', 'Aprovado UPS', 2, 3, 8, '1.27', '3.80', '1.27', '2022-06-23 16:49:49', '2022-06-23 16:49:49'),
(26, 1, '2022-06-10 00:17', '2022-06-25 04:18', '2022-06-24 04:17', 'Seguro Auto', '65.75', NULL, '5.45', 'Aprovado UPS', 7, 2, 5, '0.02', '0.07', '0.02', '2022-06-23 16:50:25', '2022-06-23 16:50:25'),
(27, 1, '2022-06-27 02:15', '2022-06-28 06:17', '2022-06-28 05:25', 'Consórcio', '44444.44', NULL, '3.00', 'Aprovado UPS', 3, 8, 1, '10.29', '30.88', '10.29', '2022-06-28 12:22:11', '2022-06-28 12:28:16'),
(28, 1, '2022-06-23 03:16', '2022-06-28 03:16', NULL, 'Consórcio', '5666.66', NULL, '3.00', 'Aguard. UPS', 8, 8, NULL, NULL, NULL, NULL, '2022-06-28 12:25:08', '2022-06-28 12:25:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `departments`
--

INSERT INTO `departments` (`id`, `name`, `team`, `created_at`, `updated_at`) VALUES
(1, 'Tecnologia da Informação', 'Administrativa', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(8, 'Caixa', 'Negócios', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(9, 'Gerência', 'Negócios', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(17, 'Cadastro', 'Operacional', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(18, 'Crédito', 'Operacional', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(19, 'Cobrança', 'Operaconal', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(11, 'Produtos e Serviços', 'Negócios', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(2, 'Contas a Pagar', 'Administrativa', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(3, 'Cedoc/Contabilidade', 'Administrativa', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(6, 'Controle Interno', 'Gestão de Riscos', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(20, 'Staff', 'Staff', '2022-07-01 16:10:46', '2022-07-01 16:10:46'),
(12, 'Gestão Executiva', 'Negócios', '2022-07-01 16:15:37', '2022-07-01 16:15:37'),
(7, 'Gestão Executiva', 'Gestão de Riscos', '2022-07-01 16:15:37', '2022-07-01 16:15:37'),
(13, 'Gestão Tática', 'Negócios', '2022-07-01 16:15:37', '2022-07-01 16:15:37'),
(5, 'Gestão Tática', 'Administrativa', '2022-07-01 16:15:37', '2022-07-01 16:15:37'),
(15, 'Atendimento', 'Negócios', '2022-07-01 16:15:37', '2022-07-01 16:15:37'),
(16, 'Assistentes', 'Negócios', '2022-07-01 16:15:37', '2022-07-01 16:15:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_login`
--

DROP TABLE IF EXISTS `log_login`;
CREATE TABLE IF NOT EXISTS `log_login` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_login_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `log_login`
--

INSERT INTO `log_login` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-06-30 11:39:32', '2022-06-30 11:39:32'),
(2, 1, 0, '2022-07-01 16:40:44', '2022-07-01 16:40:44'),
(3, 1, 1, '2022-07-01 16:41:44', '2022-07-01 16:41:44'),
(4, 1, 0, '2022-07-01 16:45:22', '2022-07-01 16:45:22'),
(5, 1, 1, '2022-07-01 16:45:27', '2022-07-01 16:45:27'),
(6, 1, 0, '2022-07-01 16:45:43', '2022-07-01 16:45:43'),
(7, 1, 1, '2022-07-01 16:45:49', '2022-07-01 16:45:49'),
(8, 1, 0, '2022-07-01 16:47:45', '2022-07-01 16:47:45'),
(9, 1, 1, '2022-07-01 16:47:47', '2022-07-01 16:47:47'),
(10, 1, 0, '2022-07-01 18:55:56', '2022-07-01 18:55:56'),
(11, 1, 1, '2022-07-01 18:55:59', '2022-07-01 18:55:59'),
(12, 1, 0, '2022-07-01 20:10:26', '2022-07-01 20:10:26'),
(13, 1, 1, '2022-07-01 20:10:32', '2022-07-01 20:10:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2022_05_19_022736_create_products_table', 2),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2022_04_18_022736_create_tasks_table', 1),
(12, '2022_04_19_022736_create_commissions_table', 3),
(6, '2014_10_12_000000_create_users_table', 2),
(17, '2022_04_19_022736_create_log_login_table', 8),
(14, '2022_04_19_022736_create_accesses_table', 5),
(15, '2010_04_19_022736_create_accesses_table', 6),
(16, '2010_04_19_022736_create_system_coms_table', 7),
(18, '2014_10_12_000000_create_tests_table', 9),
(19, '2008_04_19_022736_create_departments_table', 10),
(20, '2009_04_19_022736_create_roles_table', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Seguro de Vida Coletivo', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(2, 'Seguro de Vida', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(3, 'Seguro Animal de Elite', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(4, 'Seguro Auto', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(5, 'Seguro Equipamentos', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(6, 'Seguro Residencial e Empresarial', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(7, 'Seguro Agrícola', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(8, 'Seguro Prestamista', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(9, 'Crédito Consignado', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(10, 'Consórcio', '2022-04-28 17:54:16', '2022-04-28 17:54:16'),
(11, 'Previdência', '2022-04-28 17:54:16', '2022-04-28 17:54:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_department_id_foreign` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `department_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Analista de TI', '2022-07-01 16:24:43', '2022-07-01 16:24:43'),
(2, 4, 'Diretor Administrativo', '2022-07-01 16:24:43', '2022-07-01 16:24:43'),
(3, 12, 'Diretor de Negócios', '2022-07-01 16:24:43', '2022-07-01 16:24:43'),
(4, 7, 'Diretor de Gestão de Riscos', '2022-07-01 16:24:43', '2022-07-01 16:24:43'),
(5, 2, 'Agente Administrativo', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(6, 20, 'Secretária Executiva', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(7, 3, 'Agente Administrativo', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(8, 5, 'Gerente Administrativo', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(9, 6, 'Agente de Controle Interno', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(10, 8, 'Agente de Atendimento', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(11, 9, 'Gerente de Relacionamento', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(12, 11, 'Agente de Produtos', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(13, 13, 'Gerente de Negócios', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(14, 13, 'Gerente de PA', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(15, 15, 'Agente de Atendimento', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(16, 17, 'Agente Administrativo', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(17, 18, 'Agente Administrativo', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(18, 19, 'Agente Administrativo', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(19, 20, 'Agente de Marketing', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(20, 20, 'Analista de Negócios', '2022-07-01 18:27:11', '2022-07-01 18:27:15'),
(21, 20, 'Agente de RH', '2022-07-01 18:27:11', '2022-07-01 18:27:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_coms`
--

DROP TABLE IF EXISTS `system_coms`;
CREATE TABLE IF NOT EXISTS `system_coms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `done` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `subtitle`, `done`, `created_at`, `updated_at`) VALUES
(1, 2, 'Comprar Lanche', '*Feijoada com com \"oreia\" de porco', 1, '2022-04-22 15:17:35', '2022-05-17 17:16:13'),
(2, 2, 'Ligar para cliente X ', '*Assunto a tratar: \"Conversar Fiado\" *Telefone: 40028922', 1, '2022-04-22 15:22:00', '2022-05-16 15:46:04'),
(3, 2, 'Contratar Fulano', 'testeteste', 0, '2022-04-22 15:22:11', '2022-04-22 22:28:39'),
(4, 2, 'Verificar a Temperatura do Servidor', 'eafsa4324', 0, '2022-04-22 15:22:16', '2022-04-22 22:28:40'),
(5, 2, 'Reunião da Equipe Administrativa', 'Data: 20/03/2032', 1, '2022-04-22 15:22:19', '2022-04-22 16:47:57'),
(6, 2, 'Elaborar Planilha 23/05', 'Sobre o crescimento do consumo de pequi em São Gotardo', 1, '2022-04-22 15:22:24', '2022-04-22 16:47:59'),
(7, 2, 'Avaliar Metas', 'Quando atingirmos a meta, dobraremos a meta', 1, '2022-04-22 15:22:31', '2022-04-22 16:47:58'),
(8, 2, 'Verificar o estoque de vento', 'Concluímos que não é possível estocar vento.', 1, '2022-04-22 15:22:36', '2022-04-22 16:47:56'),
(9, 1, 'Reunião da Equipe de Negócios', 'Realizar testes Unit no sistema', 0, '2022-04-22 15:22:42', '2022-06-28 13:21:28'),
(10, 1, 'fazer aquilo', 'Lorem Ipsum', 1, '2022-04-22 15:22:48', '2022-06-28 13:55:23'),
(11, 2, 'Comunicar a minha falta ', 'Falta de aniversário 25/07', 0, '2022-04-22 15:22:55', '2022-06-08 18:39:41'),
(12, 2, 'aaaaaaaaaaaaa', 'Lorem Ipsum', 1, '2022-04-22 15:23:00', '2022-04-26 18:48:07'),
(14, 2, 'fazer isso', 'Lorem Ipsum', 1, '2022-04-22 15:23:11', '2022-04-22 16:47:59'),
(15, 1, '\"O fim justifica os meios\" ou \"os fins justificam os meios\"', 'Frase proferida pelo poeta romano Ovídio na sua obra Heroides. Esta frase é habitualmente atribuída de forma errônea a Nicolau Maquiavel. Significa que os governantes devem estar acima da éti', 0, '2022-04-22 15:23:16', '2022-06-28 13:24:01'),
(16, 1, 'A Poison Tree by William Blake', 'I was angry with my friend;. I told my wrath, my wrath did end. I was angry with my foe: I told it not, my wrath did grow', 0, '2022-04-22 15:23:21', '2022-04-22 15:23:21'),
(17, 1, 'Lavar Calçada', 'Lorem Ipsum', 1, '2022-04-22 15:23:29', '2022-06-28 13:18:01'),
(18, 2, 'Analisar Stock Market', 'Lorem Ipsum', 0, '2022-04-22 15:23:35', '2022-05-23 18:50:28'),
(19, 1, 'Estudar Assunto X', 'Livro Cap, 32 link: https://google.com', 0, '2022-04-22 15:23:49', '2022-04-22 15:23:49'),
(20, 1, 'Até tu, Brutus filho meu', 'Lorem Ipsum', 0, '2022-04-22 15:23:56', '2022-04-22 15:23:56'),
(21, 2, 'Second Part', 'And it grew both day and night. \nTill it bore an apple bright. \nAnd my foe beheld it shine,\nAnd he knew that it was mine. ', 1, '2022-04-22 15:23:59', '2022-04-25 15:59:04'),
(22, 1, 'Resolver bug pdf ', 'Para resoluções maiores que 1660', 1, '2022-04-22 15:24:02', '2022-06-28 13:55:21'),
(23, 1, 'Third Part', 'And into my garden stole, \nWhen the night had veild the pole; \nIn the morning glad I see; \nMy foe outstretched beneath the tree.', 0, '2022-04-22 15:24:07', '2022-04-22 15:24:07'),
(25, 1, 'Comunicar ao gestor sobre o assunto X', 'Lorem Ipsum', 0, '2022-04-22 15:24:21', '2022-04-22 15:24:21'),
(26, 2, 'Deixar o banheiro limpo', 'Lorem Ipsum', 0, '2022-04-22 15:24:50', '2022-05-23 18:50:17'),
(27, 1, 'Trocar óleo', 'Até dia 30/05', 0, '2022-04-25 15:35:18', '2022-04-25 15:35:18'),
(28, 1, 'testando task insert name', 'hhhh', 0, '2022-04-25 15:35:38', '2022-06-28 13:21:47'),
(29, 2, 'Fazer isso', 'De modo assado', 0, '2022-05-23 18:48:56', '2022-05-23 18:49:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `updates`
--

DROP TABLE IF EXISTS `updates`;
CREATE TABLE IF NOT EXISTS `updates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `updates`
--

INSERT INTO `updates` (`id`, `title`, `content`, `date`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Inserção inicial da Landing Page', 'Implementação', '2022/06/10 16:48', '1', '2022-06-10 19:47:34', '2022-06-10 19:47:34'),
(2, 'Inserção inicial da Landing Pagefdfs', 'Implementação', '2022/06/10 16:48', '1', '2022-06-10 19:47:34', '2022-06-10 19:47:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `cpf` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `access_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `configs` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_about` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_corporation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_cpf_unique` (`cpf`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `full_name`, `gender`, `active`, `cpf`, `email`, `photo`, `access_id`, `role_id`, `configs`, `profile_about`, `agency`, `address`, `phone`, `phone_corporation`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Marcel', 'Marcel Kendy Rabelo Matsumoto', 1, 1, '09022715639', 'kendymarcel@gmail.com', 'uploads/avatars/09022715639/9T3rrSXSBIvojIuk4wD6TN0NYVLLEqIQMcJAMsX9.jpg', 8, 1, '{\"theme\":0}', 'Customizando meu perfil, seção About :) Gostei viu', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$YtsTsN.8sZYYjx/K7328keFAVyq/9z.A3I17APTuuNf5jeOx71vRe', '2022-04-28 17:49:51', '2022-07-01 15:46:59'),
(2, 'Niccoló', 'Niccoló di Bernardo dei Machiavelli', 1, 1, '32323232356', 'machiavelli@gmail.com', 'uploads/avatars/32323232356/axXyxAFvVGbgCVQzzlO6uJXUwczaPeH8c5j6LjID.jpg', 2, 7, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-04-28 17:49:51', '2022-06-27 19:28:48'),
(3, 'Michelangelo', 'Michelangelo Soares', 2, 0, '43223424333', 'michel@dad.c', NULL, 5, 2, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-05-02 15:32:25', '2022-06-14 18:15:28'),
(4, 'Leonardo', 'Leonardo Da Vinci', 1, 1, '21312313213', 'leo@leo.com', 'uploads/avatars/21312313213/uwoOlOXItHqd7kE71oGU3q3e6KS6zKD8uZNJ9k9q.webp', 4, 1, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$XZUzmIxEp1yJP9fXcmpfbuCUktF3lQIqfENeFKxx8oWp0rusOBozG', '2022-05-02 15:37:28', '2022-06-27 19:27:48'),
(5, 'Alan', 'Alan Mathison Turing', 1, 1, '66666666609', 'alan@gmail.com', 'uploads/avatars/66666666609/BRdrBXeyxH1fQbwmcEBzYLmsL486MtQprZi0s38H.jpg', 6, 5, '{\"theme\":1}', 'Fui um matemático, cientista da computação, lógico, criptoanalista, filósofo e biólogo teórico britânico.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$uF3.PqtvHl0/qt6QvHWYQO/H1B8oX8mX7FZpWnVln9sYn2PUCSPka', '2022-05-04 21:36:11', '2022-07-01 13:45:50'),
(6, 'Donatello', 'Donatello Vincerine', 1, 0, '76865765756', 'seller@seller.com', NULL, 3, 6, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-05-04 21:46:14', '2022-06-06 15:36:19'),
(7, 'Marie', 'Marie Currie', 2, 1, '43543543342', 'basic@basic.com', NULL, 1, 3, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-05-04 21:46:47', '2022-06-09 17:35:51'),
(8, 'Nikola', 'Nikola Tesla Никола Тесла', 1, 1, '76865733765', 'nikola@gmail.com', 'uploads/avatars/76865733765/pr6b0xZmLYAzo0BZbsib3tzZD4AHGbjwZcut53Fv.jpg', 2, 1, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-05-04 21:46:14', '2022-06-27 19:24:28'),
(9, 'Monalisa', 'Monalisa Geek de Roma', 2, 1, '77551111111', 'monalisa@gmail.com', 'uploads/avatars/77551111111/GCP4jPvcovilzxixEYs1JPTXkAZPYfJZahy633Re.jpg', 5, 8, '{\"theme\":0}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$ecfVfVQ/THWUmK/GoXAgHujKvFsXstZ7XKItzYAh2VmN/.XBXhmbq', '2022-05-16 13:45:35', '2022-06-14 20:01:17'),
(10, 'Caius', 'Caius Julius Ceasar', 1, 1, '54354354353', 'teste@teste.com', NULL, 5, 9, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', 'Belle Fornitude, Forth Avenue n. 64', '(34) 98885-7677', '0795', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-05-17 16:05:36', '2022-06-14 20:00:45'),
(11, 'Friedrich', 'Friedrich Nietzsche', 1, 1, '34342342423', 'teste2@teste.vom', NULL, 6, 10, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', '78 District, Fifth Avenue n. 23', '(34) 98865-6566', '4367', '$2y$10$O8288ZEq99PZnLEB/bHNVuHIKTQgvDxliQyjgZjets316E3rnSlGC', '2022-05-17 16:15:44', '2022-06-06 15:37:14'),
(12, 'Anne', 'Anne Frank', 2, 1, '22222222222', 'anne@gmail.com', 'uploads/avatars/22222222222/31RAyXFaPg1b3VzWGjZEUG12jNqQN36hatP9w6Q5.jpg', 1, 13, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', '78 District, Fifth Avenue n. 23', '(34) 98865-6566', '4367', '$2y$10$ZOgSufewlgcZea4gh9MBqulnIzKqgh0rIRY.4qOg1Db19vXMPPwvC', '2022-05-23 19:06:15', '2022-06-27 19:26:17'),
(13, 'David', 'David Hume', 1, 1, '23123241221', 'acesso@acesso.com', NULL, 1, 15, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', '78 District, Fifth Avenue n. 23', '(34) 98865-6566', '4367', '$2y$10$MUS8WMv1uMLcGm2Gk4wBC.CAFY88IpysIkB.EU.aE4WOJZ12JZ1wW', '2022-05-24 16:37:30', '2022-06-06 15:37:42'),
(14, 'Santo', 'Santo Agostinho', 2, 1, '44444444444', 'genero@gmail.com', NULL, 8, 19, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', '78 District, Fifth Avenue n. 23', '(34) 98865-6566', '4367', '$2y$10$c6Z2e2.HTU4r032BrbkRYeV8hTaGQ6EE3f.jig7T1bSRdDP7DBQLq', '2022-05-27 17:22:31', '2022-06-06 15:37:21'),
(15, 'São Tomás', 'São Tomás de Aquino', 2, 1, '42321312312', 'camila@gmail.com', 'uploads/avatars/42321312312/ejwVRr0BNkHPoV7UlnfvyTlK954ekLtwawpOxsxr.jpg', 1, 20, '{\"theme\":0}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', '78 District, Fifth Avenue n. 23', '(34) 98865-6566', '4367', '$2y$10$Qar1o2xtMe4qsmfsix8EgurJCNSVEyqyIlqv06EWrB9.7n1nxihcu', '2022-06-08 17:37:04', '2022-06-09 16:27:47'),
(16, 'Tiririca', 'Tiririca Dos Santos Melo', 1, 1, '43243677777', 'tiririca@gmail.com', 'uploads/avatars/43243677777/VTuYPDvB5BYeMuIafR8p7v1fdMMy3wDgfsYiLMvQ.webp', 1, 21, '{\"theme\":1}', 'Eu conecto pessoas para promover justiça financeira e prosperidade.', 'Matriz', '78 District, Fifth Avenue n. 23', '(34) 98865-6566', '4367', '$2y$10$1tgOfAK90ODCHy.AviggueN6si.E9Iw9.vIFsHw5H5Gy5QfdryjpC', '2022-06-09 16:45:48', '2022-06-09 17:01:16');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

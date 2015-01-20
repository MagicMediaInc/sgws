-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-03-2013 a las 16:07:25
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `sololar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_banco_user`
--

CREATE TABLE IF NOT EXISTS `info_banco_user` (
  `id_info_banco` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_banco` int(11) NOT NULL,
  `titular` varchar(30) NOT NULL,
  `agencia` varchar(30) NOT NULL,
  `numero_conta` varchar(30) NOT NULL,
  PRIMARY KEY (`id_info_banco`),
  KEY `id_user` (`id_user`),
  KEY `id_banco` (`id_banco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `info_banco_user`
--

INSERT INTO `info_banco_user` (`id_info_banco`, `id_user`, `id_banco`, `titular`, `agencia`, `numero_conta`) VALUES
(1, 3, 2, 'Emma Isabella', 'Sao Paulo', '3845860920480726322'),
(4, 3, 1, 'Genesis Cardozo', 'Sao Paulo', '8463010345484506855'),
(5, 3, 2, 'Stefano Daniel', 'Sao Paulo', '7560103646463202903'),
(6, 5, 2, 'Emma Isabella', 'Sao Paulo', '01340332583322138090'),
(7, 5, 2, 'Genesis Cardozo', 'Caracas', '3845860920480726322');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lx_module`
--

CREATE TABLE IF NOT EXISTS `lx_module` (
  `id_module` int(11) NOT NULL AUTO_INCREMENT,
  `name_module` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `sf_module` varchar(30) COLLATE latin1_spanish_ci DEFAULT NULL,
  `credential` varchar(30) COLLATE latin1_spanish_ci DEFAULT NULL,
  `status` set('0','1') COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `delete` set('1','0') COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `lx_module`
--

INSERT INTO `lx_module` (`id_module`, `name_module`, `sf_module`, `credential`, `status`, `id_parent`, `position`, `delete`) VALUES
(1, 'Pessoas Admin', '', '', '1', 0, NULL, '1'),
(2, 'Informações Pessoais', 'lxaccount', 'lx_account', '1', 1, 3, '1'),
(3, 'Trocar senha', 'lxchangePassword', 'lx_password', '1', 7, 6, '1'),
(4, 'Módulos', 'lxmodule', 'lx_module', '1', 7, NULL, '1'),
(5, 'Usuarios', 'lxuser', 'lx_user', '1', 1, 2, '1'),
(6, 'Perfil de Pessoas', 'lxprofile', 'lx_profile', '1', 7, 6, '1'),
(7, 'Administração', '', '', '1', 0, NULL, '0'),
(8, 'Usuários e Perfis', '', '', '0', 1, -1, '1'),
(9, 'Seções', 'lxsection', 'lx_section', '1', 7, NULL, '0'),
(13, 'Notícias', 'news', 'sf_news', '1', 7, 2, '1'),
(16, 'Permissões de usuário', 'lxuserpermission', 'lx_user_permission', '1', 8, NULL, '1'),
(18, 'Galeria', 'album', 'sf_album', '1', 7, 5, '0'),
(38, 'Informações Bancarias', 'infobancaria', 'infobancaria', '1', 1, 3, '1'),
(39, 'Informações Complementares', 'infocomplementaria', 'infocomplementaria', '1', 1, 4, '1'),
(40, 'Vínculo', 'vinculo', 'vinculo', '1', 1, 5, '1'),
(41, 'Subtipos', 'subtipo', 'subtipo', '1', 42, NULL, '1'),
(42, 'Propriedades do Sistema', 'home', 'home', '1', 0, NULL, '1'),
(43, 'Segurança', 'seguranca', 'seguranca', '1', 42, 2, '0'),
(44, 'Bancos', 'banco', 'banco', '1', 42, 3, '0'),
(45, 'Permissões', 'permisos', 'permisos', '1', 1, 8, '0'),
(46, 'Pessoas', '', '', '1', 0, NULL, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lx_privilege`
--

CREATE TABLE IF NOT EXISTS `lx_privilege` (
  `id_privilege` int(11) NOT NULL AUTO_INCREMENT,
  `privilege_name` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `sf_privilege` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `privilege_description` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_privilege`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `lx_privilege`
--

INSERT INTO `lx_privilege` (`id_privilege`, `privilege_name`, `sf_privilege`, `privilege_description`) VALUES
(1, 'Leitura', 'view', 'Privilege for view content'),
(2, 'Escrita', 'insert', 'Privilege for insert content'),
(3, 'Update', 'update', 'Privilege for update content'),
(4, 'Delete', 'delete', 'Privilege for delete content');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lx_profile`
--

CREATE TABLE IF NOT EXISTS `lx_profile` (
  `id_profile` int(11) NOT NULL AUTO_INCREMENT,
  `name_profile` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `permalink` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `status` set('0','1') COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `lx_profile`
--

INSERT INTO `lx_profile` (`id_profile`, `name_profile`, `permalink`, `status`) VALUES
(1, 'Root', '', '1'),
(2, 'Administrator', '', '1'),
(13, 'Gerente', 'contactoppal', '1'),
(14, 'Secretario', '', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lx_profile_module`
--

CREATE TABLE IF NOT EXISTS `lx_profile_module` (
  `id_profile_module` int(11) NOT NULL AUTO_INCREMENT,
  `id_privilege` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  PRIMARY KEY (`id_profile_module`),
  UNIQUE KEY `privilege_module` (`id_privilege`,`id_module`,`id_profile`),
  KEY `id_perfil` (`id_profile`),
  KEY `id_modulo` (`id_module`),
  KEY `id_privilege` (`id_privilege`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=350 ;

--
-- Volcado de datos para la tabla `lx_profile_module`
--

INSERT INTO `lx_profile_module` (`id_profile_module`, `id_privilege`, `id_profile`, `id_module`) VALUES
(1, 1, 1, 2),
(15, 1, 2, 2),
(2, 1, 1, 3),
(104, 4, 1, 16),
(3, 1, 1, 4),
(7, 1, 1, 5),
(99, 4, 2, 9),
(11, 1, 1, 6),
(25, 1, 1, 8),
(30, 1, 1, 9),
(103, 3, 1, 16),
(88, 1, 2, 14),
(53, 1, 1, 12),
(76, 1, 1, 13),
(4, 2, 1, 4),
(8, 2, 1, 5),
(98, 3, 2, 9),
(12, 2, 1, 6),
(26, 2, 1, 8),
(31, 2, 1, 9),
(91, 4, 2, 14),
(54, 2, 1, 12),
(77, 2, 1, 13),
(5, 3, 1, 4),
(9, 3, 1, 5),
(97, 2, 2, 9),
(13, 3, 1, 6),
(27, 3, 1, 8),
(32, 3, 1, 9),
(90, 3, 2, 14),
(55, 3, 1, 12),
(78, 3, 1, 13),
(6, 4, 1, 4),
(10, 4, 1, 5),
(96, 1, 2, 9),
(14, 4, 1, 6),
(28, 4, 1, 8),
(33, 4, 1, 9),
(89, 2, 2, 14),
(56, 4, 1, 12),
(79, 4, 1, 13),
(80, 1, 1, 14),
(81, 2, 1, 14),
(82, 3, 1, 14),
(83, 4, 1, 14),
(84, 1, 1, 15),
(85, 2, 1, 15),
(86, 3, 1, 15),
(87, 4, 1, 15),
(102, 2, 1, 16),
(101, 1, 1, 16),
(100, 1, 2, 3),
(337, 1, 3, 2),
(106, 1, 3, 3),
(107, 1, 4, 2),
(108, 1, 4, 3),
(109, 1, 3, 13),
(110, 3, 3, 13),
(111, 4, 3, 13),
(112, 2, 3, 13),
(113, 1, 3, 9),
(114, 2, 3, 9),
(115, 3, 3, 9),
(116, 4, 3, 9),
(117, 1, 3, 15),
(118, 2, 3, 15),
(119, 3, 3, 15),
(120, 4, 3, 15),
(332, 4, 1, 43),
(331, 3, 1, 43),
(330, 2, 1, 43),
(329, 1, 1, 43),
(125, 1, 1, 18),
(126, 2, 1, 18),
(127, 3, 1, 18),
(128, 4, 1, 18),
(129, 1, 8, 2),
(130, 1, 8, 3),
(131, 1, 8, 13),
(132, 2, 8, 13),
(133, 3, 8, 13),
(134, 4, 8, 13),
(135, 1, 8, 18),
(136, 2, 8, 18),
(137, 3, 8, 18),
(138, 4, 8, 18),
(139, 1, 8, 15),
(140, 2, 8, 15),
(141, 3, 8, 15),
(142, 4, 8, 15),
(328, 4, 1, 42),
(327, 3, 1, 42),
(326, 2, 1, 42),
(325, 1, 1, 42),
(163, 1, 8, 9),
(164, 2, 8, 9),
(165, 3, 8, 9),
(166, 4, 8, 9),
(167, 1, 3, 18),
(168, 2, 3, 18),
(169, 3, 3, 18),
(170, 4, 3, 18),
(179, 1, 10, 2),
(180, 1, 10, 3),
(181, 1, 9, 9),
(182, 2, 9, 9),
(183, 3, 9, 9),
(184, 4, 9, 9),
(185, 1, 9, 13),
(186, 2, 9, 13),
(187, 3, 9, 13),
(188, 4, 9, 13),
(189, 1, 9, 18),
(190, 2, 9, 18),
(191, 3, 9, 18),
(192, 4, 9, 18),
(205, 1, 10, 9),
(206, 2, 10, 9),
(207, 3, 10, 9),
(208, 4, 10, 9),
(209, 1, 10, 13),
(210, 2, 10, 13),
(211, 3, 10, 13),
(212, 4, 10, 13),
(213, 1, 10, 18),
(214, 2, 10, 18),
(215, 3, 10, 18),
(216, 4, 10, 18),
(229, 1, 9, 2),
(230, 1, 9, 3),
(267, 1, 11, 2),
(268, 1, 11, 3),
(269, 1, 12, 2),
(270, 1, 12, 3),
(313, 1, 1, 39),
(272, 1, 13, 3),
(343, 4, 1, 45),
(342, 3, 1, 45),
(341, 2, 1, 45),
(340, 1, 1, 45),
(339, 2, 3, 5),
(338, 1, 3, 5),
(336, 4, 1, 44),
(335, 3, 1, 44),
(334, 2, 1, 44),
(333, 1, 1, 44),
(324, 4, 1, 41),
(323, 3, 1, 41),
(322, 2, 1, 41),
(321, 1, 1, 41),
(320, 4, 1, 40),
(319, 3, 1, 40),
(318, 2, 1, 40),
(317, 1, 1, 40),
(316, 4, 1, 39),
(315, 3, 1, 39),
(314, 2, 1, 39),
(312, 4, 1, 38),
(311, 3, 1, 38),
(310, 2, 1, 38),
(309, 1, 1, 38),
(344, 1, 14, 2),
(345, 1, 14, 3),
(346, 1, 1, 46),
(347, 2, 1, 46),
(348, 3, 1, 46),
(349, 4, 1, 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lx_user`
--

CREATE TABLE IF NOT EXISTS `lx_user` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `id_profile` int(11) DEFAULT NULL,
  `id_tipo_cadastro` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `login` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `password` text COLLATE latin1_spanish_ci,
  `email` varchar(70) COLLATE latin1_spanish_ci NOT NULL,
  `photo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `last_access` datetime DEFAULT NULL,
  `status` set('0','1') COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_perfil` (`id_profile`),
  KEY `id_tipo_cadastro` (`id_tipo_cadastro`),
  KEY `id_tipo_usuario` (`id_tipo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `lx_user`
--

INSERT INTO `lx_user` (`id_user`, `id_profile`, `id_tipo_cadastro`, `id_tipo_usuario`, `codigo`, `login`, `password`, `email`, `photo`, `last_access`, `status`) VALUES
(1, 1, 1, 1, '', 'root', 'b8b42cb337d1fce718048937c32a81a0', 'igor@gallardodesigner.com.br', '1_conmiamor.png', '2013-03-18 15:43:06', '1'),
(2, 2, 1, 1, '', 'admin', 'b8b42cb337d1fce718048937c32a81a0', 'info@aberic.com', '', '2011-05-16 13:40:00', '1'),
(3, 13, 3, 2, '000001', 'hvallenilla', 'e10adc3949ba59abbe56e057f20f883e', 'henryvallenilla@gmail.com', '3_17956_301730357275_4.jpg', '2013-03-17 19:12:28', '1'),
(4, 3, 2, 2, '000002', 'gcardozo', 'fcea920f7412b5da7be0cf42b8c93759', 'genesis_cardozo@gmail.com', '4_us.jpg', '2013-02-12 20:32:25', '1'),
(5, 14, 2, 2, '000003', 'ecardozo', 'fcea920f7412b5da7be0cf42b8c93759', 'ecardozo@gmail.com', '5_9490_461036483961739.jpg', '2013-02-12 20:29:39', '1'),
(15, 13, 2, 2, '', 'igallardo', '8ce87b8ec346ff4c80635f667d1592ae', 'igallardo@gmail.com', '', NULL, '0'),
(16, 2, 2, 3, '', 'empresa1', '00cedcf91beffa9ee69f6cfe23a4602d', 'empresa1@hotmail.com', '', NULL, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lx_user_module`
--

CREATE TABLE IF NOT EXISTS `lx_user_module` (
  `id_user_module` int(11) NOT NULL AUTO_INCREMENT,
  `id_privilege` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  `type_vision` set('0','1','2') NOT NULL DEFAULT '0' COMMENT '1:Vision General; 2:Info Propia',
  PRIMARY KEY (`id_user_module`),
  KEY `id_user` (`id_user`),
  KEY `id_module` (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

--
-- Volcado de datos para la tabla `lx_user_module`
--

INSERT INTO `lx_user_module` (`id_user_module`, `id_privilege`, `id_user`, `id_module`, `type_vision`) VALUES
(172, 1, 3, 5, '2'),
(173, 2, 3, 5, '2'),
(174, 1, 3, 5, '1'),
(175, 2, 3, 5, '1'),
(176, 1, 3, 44, '0'),
(177, 2, 3, 44, '0'),
(178, 1, 3, 6, '2'),
(179, 1, 5, 38, '1'),
(180, 1, 5, 38, '2'),
(181, 1, 3, 38, '1'),
(182, 1, 3, 38, '2'),
(183, 2, 3, 38, '2'),
(189, 1, 4, 5, '1'),
(190, 1, 4, 5, '2'),
(191, 2, 4, 5, '2'),
(192, 2, 4, 5, '1'),
(194, 1, 3, 45, '1'),
(195, 1, 3, 45, '2'),
(196, 1, 3, 40, '2'),
(197, 1, 3, 40, '1'),
(198, 2, 3, 45, '1'),
(199, 2, 3, 40, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cadastro`
--

CREATE TABLE IF NOT EXISTS `tipo_cadastro` (
  `id_tipo_cadastro` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cadastro` varchar(20) NOT NULL,
  `sign_in` set('0','1') NOT NULL,
  PRIMARY KEY (`id_tipo_cadastro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipo_cadastro`
--

INSERT INTO `tipo_cadastro` (`id_tipo_cadastro`, `tipo_cadastro`, `sign_in`) VALUES
(1, 'Administrator', '1'),
(2, 'Cliente', '0'),
(3, 'Fornecedor', '0'),
(4, 'Funcionario', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_usuario` varchar(30) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `tipo_usuario`) VALUES
(1, 'Administrador'),
(2, 'Pessoa Física'),
(3, 'Pessoa Jurídica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_subtipo`
--

CREATE TABLE IF NOT EXISTS `user_subtipo` (
  `id_user_subtipo` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_subtipo` int(11) NOT NULL,
  PRIMARY KEY (`id_user_subtipo`),
  KEY `id_user` (`id_user`),
  KEY `id_subtipo` (`id_subtipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinculo_user`
--

CREATE TABLE IF NOT EXISTS `vinculo_user` (
  `id_vinculo_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_user_vinculo` int(11) NOT NULL,
  PRIMARY KEY (`id_vinculo_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `vinculo_user`
--

INSERT INTO `vinculo_user` (`id_vinculo_user`, `id_user`, `id_user_vinculo`) VALUES
(1, 3, 5),
(2, 5, 3),
(3, 3, 4),
(4, 4, 3),
(5, 3, 16),
(6, 16, 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `info_banco_user`
--
ALTER TABLE `info_banco_user`
  ADD CONSTRAINT `info_banco_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `lx_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `info_banco_user_ibfk_2` FOREIGN KEY (`id_banco`) REFERENCES `banco` (`id_banco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `lx_user`
--
ALTER TABLE `lx_user`
  ADD CONSTRAINT `lx_user_ibfk_1` FOREIGN KEY (`id_tipo_cadastro`) REFERENCES `tipo_cadastro` (`id_tipo_cadastro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lx_user_ibfk_2` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user_subtipo`
--
ALTER TABLE `user_subtipo`
  ADD CONSTRAINT `user_subtipo_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `lx_user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_subtipo_ibfk_2` FOREIGN KEY (`id_subtipo`) REFERENCES `subtipo_user` (`id_subtipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

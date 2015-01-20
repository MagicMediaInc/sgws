--
-- Estructura de tabla para la tabla `sf_seccion`
--

CREATE TABLE IF NOT EXISTS `sf_section` (
  `id` int(11) NOT NULL auto_increment,
  `id_parent` int(11) default '0',
  `position` int(11) default NULL,
  `control` char(1) collate latin1_spanish_ci default '0',
  `sw_menu` varchar(200) collate latin1_spanish_ci default NULL,
  `status` char(1) collate latin1_spanish_ci default '0',
  `home` char(1) collate latin1_spanish_ci default '0',
  `special_page` varchar(50) collate latin1_spanish_ci default NULL,
  `show_text` char(1) collate latin1_spanish_ci default '0',
  `only_complement` char(1) collate latin1_spanish_ci default '0',
  `delete` char(1) collate latin1_spanish_ci NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sw_menu` (`sw_menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=18 ;

--
-- Volcar la base de datos para la tabla `sf_seccion`
--

INSERT INTO `sf_section` (`id`, `id_parent`, `position`, `control`, `sw_menu`, `status`, `home`, `special_page`, `show_text`, `only_complement`, `delete`) VALUES
(3, 0, 1, '1', 'home', '2', '1', '', '1', '1', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_seccion_i18n`
--

CREATE TABLE IF NOT EXISTS `sf_section_i18n` (
  `name_section` varchar(50) collate latin1_spanish_ci default NULL,
  `descrip_section` text collate latin1_spanish_ci NOT NULL,
  `meta_title` varchar(200) collate latin1_spanish_ci default NULL,
  `meta_keyword` varchar(200) collate latin1_spanish_ci default NULL,
  `meta_description` varchar(200) collate latin1_spanish_ci default NULL,
  `id` int(11) NOT NULL,
  `language` varchar(7) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`,`language`),
  KEY `language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcar la base de datos para la tabla `sf_seccion_i18n`
--

INSERT INTO `sf_section_i18n` (`name_section`, `descrip_section`, `meta_title`, `meta_keyword`, `meta_description`, `id`, `language`) VALUES
('Home', '<p>home</p>', NULL, 'Brain Fitness and Brain Training', 'Brain Fitness and Brain Training', 1, 'en');
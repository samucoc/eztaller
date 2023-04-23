CREATE TABLE `menus` (
  `m_ncorr` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL,
  `icono` text NOT NULL,
  `link` text NOT NULL,
  `estado` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `usuario` text NOT NULL,
  PRIMARY KEY (`m_ncorr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
CREATE TABLE `menus_hijos` (
  `mh_ncorr` int(11) NOT NULL AUTO_INCREMENT,
  `m_ncorr` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL,
  `link` text NOT NULL,
  `icono` text NOT NULL,
  `estado` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL,
  `usuario` text NOT NULL,
  PRIMARY KEY (`mh_ncorr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
CREATE TABLE `movim` (
  `m_ncorr` int(11) NOT NULL AUTO_INCREMENT,
  `movim_tipo` int(11) NOT NULL,
  `movim_bodega` int(11) NOT NULL,
  `movim_bodega_trans` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `usuario` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`m_ncorr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
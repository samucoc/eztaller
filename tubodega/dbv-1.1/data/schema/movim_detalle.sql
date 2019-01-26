CREATE TABLE `movim_detalle` (
  `md_ncorr` int(11) NOT NULL AUTO_INCREMENT,
  `m_ncorr` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `descr` text NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`md_ncorr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
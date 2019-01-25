CREATE TABLE `perfiles_tienen_menus_hijos` (
  `ptm_ncorr` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` int(11) NOT NULL,
  `menu_hijo` int(11) NOT NULL,
  PRIMARY KEY (`ptm_ncorr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
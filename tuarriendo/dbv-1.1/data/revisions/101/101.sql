
DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `familia` int(11) NOT NULL,
  `subfamilia` int(11) NOT NULL,
  `descricpion` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `usuario` text NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

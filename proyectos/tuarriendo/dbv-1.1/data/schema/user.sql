CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `perfil` int(11) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `kind` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
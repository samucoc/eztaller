-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-01-2011 a las 08:04:15
-- Versión del servidor: 5.0.91
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `vigomaq`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arriendo`
--

CREATE TABLE IF NOT EXISTS `arriendo` (
  `cod_arriendo` int(9) NOT NULL auto_increment,
  `rut_cliente` text NOT NULL,
  `cod_obra` int(9) NOT NULL,
  `cod_tarifa` int(2) NOT NULL,
  `cod_personal` int(3) NOT NULL,
  `forma_pago` int(2) NOT NULL,
  `num_gd` int(6) NOT NULL,
  `num_oc` text NOT NULL,
  `tipo_garantia` int(2) NOT NULL,
  `fecha_inicio` varchar(255) NOT NULL,
  `fecha_vcmto` varchar(255) NOT NULL,
  `fecha_arr` varchar(255) NOT NULL,
  `hora_arr` text NOT NULL,
  `fecha_devol` varchar(255) NOT NULL,
  `hora_devol` text NOT NULL,
  `forma_entrega` int(2) NOT NULL,
  `monto_arriendo` int(9) NOT NULL,
  `tipo_oc` text NOT NULL,
  `vcmto_oc` text NOT NULL,
  `obs_devolucion` text NOT NULL,
  PRIMARY KEY  (`cod_arriendo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=299 ;

--
-- Volcar la base de datos para la tabla `arriendo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
  `cod_ciudad` int(2) NOT NULL auto_increment,
  `ciudad` text NOT NULL,
  PRIMARY KEY  (`cod_ciudad`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcar la base de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`cod_ciudad`, `ciudad`) VALUES
(12, 'ANTOFAGASTA '),
(11, 'ARICA'),
(10, 'VALPARAISO'),
(9, 'VIñA DEL MAR'),
(13, 'VILLA ALEMANA'),
(14, 'CON CON'),
(15, 'QUILPUÉ'),
(16, 'SAN ANTONIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `cod_cliente` int(8) NOT NULL auto_increment,
  `cod_ciudad` int(3) NOT NULL,
  `cod_comuna` int(3) NOT NULL,
  `cod_tipocli` int(3) NOT NULL,
  `rut_cliente` text NOT NULL,
  `dv_cliente` text NOT NULL,
  `raz_social` text NOT NULL,
  `giro_cliente` text NOT NULL,
  `cod_area` int(3) NOT NULL,
  `fono_cliente` int(8) NOT NULL,
  `movil_cliente` int(9) NOT NULL,
  `direcc_cliente` text NOT NULL,
  `nom_resp_emp1` text NOT NULL,
  `email_resp_emp1` text NOT NULL,
  `cargo_resp1` text NOT NULL,
  `movil_resp1` int(9) NOT NULL,
  `nom_resp_emp2` text NOT NULL,
  `email_resp_emp2` text NOT NULL,
  `cargo_resp2` text NOT NULL,
  `movil_resp2` int(9) NOT NULL,
  `nom_resp_emp3` text NOT NULL,
  `email_resp_emp3` text NOT NULL,
  `cargo_resp3` text NOT NULL,
  `movil_resp3` int(9) NOT NULL,
  `cond_env_fact` longtext NOT NULL,
  PRIMARY KEY  (`cod_cliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcar la base de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cod_cliente`, `cod_ciudad`, `cod_comuna`, `cod_tipocli`, `rut_cliente`, `dv_cliente`, `raz_social`, `giro_cliente`, `cod_area`, `fono_cliente`, `movil_cliente`, `direcc_cliente`, `nom_resp_emp1`, `email_resp_emp1`, `cargo_resp1`, `movil_resp1`, `nom_resp_emp2`, `email_resp_emp2`, `cargo_resp2`, `movil_resp2`, `nom_resp_emp3`, `email_resp_emp3`, `cargo_resp3`, `movil_resp3`, `cond_env_fact`) VALUES
(12, 9, 8, 11, '76.004.090-8', '0', 'EMPRESA CONSTRUCTORA ALBORADA LTDA', 'CONSTRUCTORA', 32, 2977571, 999, '5 NORTE 511', 'MICHAEL METZGER BOCAZ', 'JEFE DEPTO @ADQUISICIONES', 'JEFE DEPTO ADQUISICIONES', 99999999, 'GGGG', 'BBBBBB', 'GGG', 99999, 'GGGGGGG', 'HHHHHHHHHH', 'FFFFFFF', 9999, 'TODAS LAS FACTURAS DEBEN SER ENTREGADAS EN OFICINA CENTRAL UBICADA EN 5 NORTE 511, VIñA DEL MAR.\r\nADJUNTADO LA ORDEN DE COMPRA, DE LO CONTRARIO NO SERá RECEPCIONADA'),
(24, 16, 13, 13, '2.452.245-8', '0', 'FICTICIO', 'CONSTRUCCION', 35, 2233556, 95556852, 'LAS DICHAS 662', 'EL RESPONSABLE', 'RESPONSABLE', 'RESPONSABLE', 88651235, '.', '.', '.', 45645645, '.', '.', '.', 789456456, '.'),
(11, 9, 8, 11, '77.490.180-9', '0', 'SOC.CONSTRUCTORA RELMU LTDA', 'CONSTRUCCION', 32, 739367, 9999, 'LAS HIEDRAS N°1153 BOSQUES DE MONTEMAR', 'ALDO LUPPI RAMIREZ', 'ENCARGADO@VTR.NET', 'ENCARGADO', 9897, 'JULIO HURTADO', 'JULIOHURTADO@VTR.NET', 'SUBROGANTE ', 999999, 'ELISEO SEPULVEDA', 'ELISEO@VTR.NET', 'SUPERVISOR TERRENO', 98, 'ENVíA FACTURA POR CORREO CERTIFICADO, LOS DíAS 5 DE CADA MES'),
(22, 12, 10, 13, '78.597.110-8', '0', 'CONSTRUCTORA DEL PUERTO LTDA.', 'CONSTRUCTORA Y ARRIENDO DE MAQUINARIA', 35, 284538, 9, 'NUEVA PROVIDENCIA  209 LLOLLEO', 'PABLO NERUDA', 'ADMINISTRADOR', '1', 0, 'XXXX', 'XXXX', 'XXX', 1, 'XXXX', 'XXX', 'XXX', 1, 'XXXX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna`
--

CREATE TABLE IF NOT EXISTS `comuna` (
  `cod_comuna` int(2) NOT NULL auto_increment,
  `comuna` text NOT NULL,
  PRIMARY KEY  (`cod_comuna`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcar la base de datos para la tabla `comuna`
--

INSERT INTO `comuna` (`cod_comuna`, `comuna`) VALUES
(9, 'VILLA ALEMANA'),
(8, 'VIÑA DEL MAR '),
(7, 'VALPARAISO'),
(10, 'ARICA'),
(11, 'CON CON'),
(12, 'QUILPUE'),
(13, 'SAN ANTONIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condic_arriendo`
--

CREATE TABLE IF NOT EXISTS `condic_arriendo` (
  `cod_cond_arr` int(2) NOT NULL auto_increment,
  `condiciones` text NOT NULL,
  PRIMARY KEY  (`cod_cond_arr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `condic_arriendo`
--

INSERT INTO `condic_arriendo` (`cod_cond_arr`, `condiciones`) VALUES
(1, 'DIAS CORRIDOS'),
(2, 'DIAS HABILES  ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_eval`
--

CREATE TABLE IF NOT EXISTS `det_eval` (
  `cod_det_eval` int(9) NOT NULL auto_increment,
  `cod_eval_tecnica` int(6) NOT NULL,
  `cod_personal` int(3) NOT NULL,
  `hh` int(3) NOT NULL,
  `valorhora` int(10) NOT NULL,
  `concepto` text NOT NULL,
  PRIMARY KEY  (`cod_det_eval`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

--
-- Volcar la base de datos para la tabla `det_eval`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_factura`
--

CREATE TABLE IF NOT EXISTS `det_factura` (
  `num_factura` int(10) NOT NULL,
  `cod_equipo` int(6) NOT NULL,
  `dias_arriendo` int(6) NOT NULL,
  `tot_arriendo` int(7) NOT NULL,
  `dias_ajuste` int(2) NOT NULL,
  `otros_reparacion` text NOT NULL,
  `monto_otros` int(15) NOT NULL,
  `cod_repuesto` int(6) NOT NULL,
  `valor_unitario` int(9) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `total_rep` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `det_factura`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_gd`
--

CREATE TABLE IF NOT EXISTS `det_gd` (
  `num_gd` int(10) NOT NULL,
  `cod_equipo` int(8) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `precio` int(10) NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `det_gd`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_reparacion`
--

CREATE TABLE IF NOT EXISTS `det_reparacion` (
  `cod_reparacion` int(5) NOT NULL,
  `cod_repuesto` int(8) NOT NULL,
  `valor_unitario` int(8) NOT NULL,
  `cantidad` int(6) NOT NULL,
  `tot_rep` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `det_reparacion`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE IF NOT EXISTS `equipo` (
  `cod_equipo` int(8) NOT NULL auto_increment,
  `cod_estado_equipo` int(2) NOT NULL,
  `cod_proveedor` int(6) NOT NULL,
  `descrp_equipo` text NOT NULL,
  `codigo_fabrica` text NOT NULL,
  `procedencia_eq` text NOT NULL,
  `cod_unidad` int(3) NOT NULL,
  `ubicacion_equipo` text NOT NULL,
  `marca_equipo` text NOT NULL,
  `nombre_equipo` text NOT NULL,
  `fecha_compra` text NOT NULL,
  `valor_compra` int(8) NOT NULL,
  `vida_util` int(2) NOT NULL,
  `fecha_ingreso_arr` text NOT NULL,
  `valor_unidad_arr` int(9) NOT NULL,
  PRIMARY KEY  (`cod_equipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Volcar la base de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`cod_equipo`, `cod_estado_equipo`, `cod_proveedor`, `descrp_equipo`, `codigo_fabrica`, `procedencia_eq`, `cod_unidad`, `ubicacion_equipo`, `marca_equipo`, `nombre_equipo`, `fecha_compra`, `valor_compra`, `vida_util`, `fecha_ingreso_arr`, `valor_unidad_arr`) VALUES
(34, 1, 82, 'GRUPO GENERADOR', 'GRUPO GENERADOR', 'ITALIA', 6, 'BODEGA CASA MATRIZ', 'LONBARDINI', 'GRUPO GENERADOR', '01/12/2010', 500000, 2, '13/12/2010', 150000),
(33, 1, 82, 'GENERADOR AIRE CALIENTE', 'GENERADOR AIRE CALIENTE', 'USA', 6, 'BODEGA QUILLOTA', 'HONDA', 'GENERADOR AIRE CALIENTE', '17/11/2010', 200000, 3, '01/12/2010', 15000),
(32, 1, 82, 'ESMERIL ANGULAR 9"', 'ESMERIL ANGULAR 9', 'USA', 6, 'BODEGA CASA MATRIZ', 'MAKITA', 'ESMERIL ANGULAR 9', '15/11/2010', 150000, 3, '01/12/2010', 5000),
(30, 1, 82, 'COMPRESOR 24 LTS.', 'ACK 24-1,5', 'BRASIL', 6, 'BODEGA QUILLOTA', 'KRAFTER', 'COMPRESOR 24 LTS', '01/12/2010', 150000, 2, '13/12/2010', 8500),
(43, 1, 82, 'EQUIPO DE PRUEBA PARA IMAGEN', 'CA-09', 'USA', 9, 'BODEGA MOTORES', 'USA', 'RODILLO COMPACTADOR', '01/12/2010', 120000, 2, '01/12/2010', 5000),
(29, 1, 82, 'GENERADOR STE - 5500', 'STE - 5500', 'ALEMANIA', 6, 'BODEGA CASA MATRIZ', 'BOSH', 'GENERADOR STE - 5500', '08/11/2010', 1250000, 3, '13/12/2010', 12500),
(31, 1, 82, 'CHIPEADOR 13HP', 'CHIPEADOR 13HP', 'JAPON', 6, 'BODEGA CASA MATRIZ', 'HONDA', 'CHIPEADOR 13 HP', '01/12/2010', 1000000, 2, '13/12/2010', 15000),
(36, 1, 82, 'EQUIPO DE PRUEBA', 'SONDA VIBRADORA 60', 'ITALIA', 6, 'BODEGA CASA MATRIZ', 'OLI', 'SONDA VIBRADORA 60 MM', '01/12/2010', 120000, 2, '15/12/2010', 1200),
(37, 1, 82, 'EQUIPO DE PRUEBA', 'SONDA VIBRADORA 36', 'ITALIA', 6, 'BODEGA CASA MATRIZ', 'OLI', 'SONDA VIBRADORA 36 MM', '02/12/2010', 150000, 2, '13/12/2010', 1200),
(38, 1, 82, 'EQUIPO DE PRUEBA', 'SONDA VIBRADORA 60 MM', 'ITALIA', 6, 'BODEGA CASA MATRIZ', 'SB', 'SONDA VIBRADORA 60 MM', '01/12/2010', 150000, 2, '13/12/2010', 1200),
(39, 1, 82, 'EQUIPO DE PRUEBA', 'SV-001', 'ITALIA', 6, 'BODEGA CASA MATRIZ', 'SSSS', 'SONDA VIBRADORA 45 MM', '01/12/2010', 150000, 2, '15/12/2010', 1200),
(40, 1, 82, 'EQUIPO DE PRUEBA', 'XXX', 'USA', 6, 'BODEGA CENTRAL', 'EY', 'VIBRADOR BENCINERO EY-20', '01/12/2010', 150000, 1, '01/12/2010', 1900),
(41, 1, 82, 'EQUIPO PRUEBA', 'SI45', 'USA', 6, 'BODEGA CENTRAL', 'MAKITA', 'SONDA VIBRADORA 45 MM.', '01/12/2010', 120000, 2, '01/12/2010', 1200),
(42, 1, 82, 'EQUIPO PRUEBA', 'SI45', 'USA', 6, 'BODEGA CENTRAL', 'MAKITA', 'SONDA INMERSION 45 MM.', '01/12/2010', 120000, 2, '06/12/2010', 1200),
(44, 1, 83, 'EQUIPO PRUEBAS IMAGEN 2', 'SB-01', 'USA', 9, 'BODEGA MATRIZ', 'STIHL', ' XXXXXXXXXX', '08/12/2010', 100000, 2, '15/12/2010', 5500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_arriendo`
--

CREATE TABLE IF NOT EXISTS `equipos_arriendo` (
  `cod_arriendo` int(10) NOT NULL,
  `cod_equipo` int(8) NOT NULL,
  `cod_reclamo` int(9) NOT NULL,
  `arrendado_desde` varchar(255) NOT NULL,
  `hora_arr` text NOT NULL,
  `arrendado_hasta` varchar(255) NOT NULL,
  `hora_devol` text NOT NULL,
  `comentarios` text NOT NULL,
  `estado_equipo_arr` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `equipos_arriendo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_equipo`
--

CREATE TABLE IF NOT EXISTS `estado_equipo` (
  `cod_estado_equipo` int(2) NOT NULL auto_increment,
  `est_equipo` int(2) NOT NULL,
  `descripcion_estado` text NOT NULL,
  PRIMARY KEY  (`cod_estado_equipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `estado_equipo`
--

INSERT INTO `estado_equipo` (`cod_estado_equipo`, `est_equipo`, `descripcion_estado`) VALUES
(1, 1, 'OPERATIVO            '),
(2, 0, 'SERVICIO TECNICO              '),
(3, 0, 'ARRENDADO                  '),
(4, 0, 'MANTENCION        '),
(5, 0, 'EVALUACION TECNICA     '),
(6, 0, 'RESERVADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eval_tecnica`
--

CREATE TABLE IF NOT EXISTS `eval_tecnica` (
  `cod_eval_tecnica` int(6) NOT NULL auto_increment,
  `cod_equipo` int(8) NOT NULL,
  `cod_tipoeval` int(2) NOT NULL,
  `cod_formaeval` int(2) NOT NULL,
  `cod_estado_equipo` int(2) NOT NULL,
  `fecha_evaluacion` varchar(255) NOT NULL,
  `costo_evaluacion` int(6) NOT NULL,
  `tiempo_est_repar` text NOT NULL,
  `det_falla` text NOT NULL,
  PRIMARY KEY  (`cod_eval_tecnica`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Volcar la base de datos para la tabla `eval_tecnica`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `num_factura` int(10) NOT NULL,
  `cod_cliente` int(8) NOT NULL,
  `cod_arriendo` int(4) NOT NULL,
  `cod_obra` int(9) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `gd_rep` text NOT NULL,
  `estado` text NOT NULL,
  `observaciones` text NOT NULL,
  `valor_iva` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `factura`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia_rep`
--

CREATE TABLE IF NOT EXISTS `familia_rep` (
  `cod_familia` int(3) NOT NULL auto_increment,
  `familia_repuesto` text NOT NULL,
  `desc_familia` text NOT NULL,
  PRIMARY KEY  (`cod_familia`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Volcar la base de datos para la tabla `familia_rep`
--

INSERT INTO `familia_rep` (`cod_familia`, `familia_repuesto`, `desc_familia`) VALUES
(25, 'CAJA ', 'CAJA ENGRANAJE'),
(23, 'BUJIA', 'BUJIA CORTA'),
(24, 'BUJIA', 'BUJIA LARGA'),
(22, 'BROCA', 'BROCA'),
(21, 'BIELA', 'BIELA'),
(16, 'INTERRUPTORES ', 'INTERRUPTORES AUTOMATICOS '),
(17, 'ABRAZADERAS ', 'ABRAZADERA PLASTICA '),
(18, 'ACEITES', 'ACEITES LUBRICANTES'),
(19, 'ANILLOS ', 'ANILLO SELLO '),
(20, 'BATERIA', 'BATERIA'),
(15, 'SENSORES ', 'SENSOR DE ACEITE '),
(26, 'CAJA', 'CAJA MOTOR'),
(27, 'CORREAS', 'CORREAS DENTADA'),
(28, 'DISCOS', 'DISCOS DE CORTE DE METAL'),
(29, 'DISCOS', 'DISCOS DE APRIETE'),
(30, 'EJE', 'EJE CARBURADOR'),
(31, 'EJE', 'EJE EMBRAGUE'),
(32, 'ELEMENTO FILTRO AIRE', 'ELEMENTO FILTRO AIRE'),
(33, 'EMBRAGUES', 'EMBRAGUES CENTRIFUGO'),
(34, 'EMBRAGUES', 'EMBRAGUES DE PLACA'),
(35, 'EMPAQUETADURA', 'EMPAQUETADURA DE CULATA'),
(36, 'EMPAQUETADURA', 'EMPAQUETADURA DE ESCAPE'),
(37, 'FILTROS', 'FILTROS ACEITE'),
(38, 'FILTROS', 'FILTROS DE COMBUSTIBLE'),
(39, 'GOLILLA', 'GOLILLA PLANA'),
(40, 'MARIPOSA ACELERADOR', 'MARIPOSA ACELERADOR'),
(41, 'O`RING', 'O`RING'),
(42, 'PARTIDOR', 'PARTIDOR COMPLETO'),
(43, 'PARTIDOR', 'PARTIDOR S/CAMPANA'),
(44, 'PERNO', 'PERNO HEX.'),
(45, 'PIÑON', 'PIÑON TRANSMISION'),
(46, 'PIOLA', 'PIOLA DIRECCION'),
(47, 'PISTON', 'PISTON + ANILLOS'),
(48, 'RESORTE', 'RESORTE EMBRAGUE'),
(49, 'RESORTE', 'RESORTE MOTOR'),
(50, 'RETEN', 'RETEN ACEITE'),
(51, 'RETEN', 'RETEN VALVULA'),
(52, 'RODAMIENTO', 'RODAMIENTO'),
(53, 'SELLO', 'SELLO ACEITE '),
(54, 'SELLO', 'SELLO MECANICO'),
(55, 'TORNILLO', 'TORNILLO MANILLA'),
(56, 'TORNILLO', 'TORNILLO ROSCA'),
(57, 'TUERCA', 'TUERCA ACOPLE'),
(58, 'TUERCA', 'TUERCA DISCO'),
(59, 'VALVULAS', 'VALVULAS ADMISION'),
(60, 'VALVULAS', 'VALVULAS DE ESCAPE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_evaluacion`
--

CREATE TABLE IF NOT EXISTS `forma_evaluacion` (
  `cod_formaeval` int(2) NOT NULL auto_increment,
  `forma_evaluar` text NOT NULL,
  PRIMARY KEY  (`cod_formaeval`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `forma_evaluacion`
--

INSERT INTO `forma_evaluacion` (`cod_formaeval`, `forma_evaluar`) VALUES
(7, 'EXTERNA'),
(6, 'INTERNA ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE IF NOT EXISTS `forma_pago` (
  `cod_forma_pago` int(2) NOT NULL auto_increment,
  `forma_pago` text NOT NULL,
  PRIMARY KEY  (`cod_forma_pago`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`cod_forma_pago`, `forma_pago`) VALUES
(7, 'RED BANK'),
(4, 'CONTADO'),
(6, 'CREDITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gd`
--

CREATE TABLE IF NOT EXISTS `gd` (
  `num_gd` int(10) NOT NULL,
  `cod_cliente` int(8) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `tipo` text NOT NULL,
  `rut_cliente` text NOT NULL,
  `cod_obra` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `gd`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE IF NOT EXISTS `iva` (
  `cod_iva` int(11) NOT NULL auto_increment,
  `valor_iva` int(3) NOT NULL,
  PRIMARY KEY  (`cod_iva`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `iva`
--

INSERT INTO `iva` (`cod_iva`, `valor_iva`) VALUES
(1, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE IF NOT EXISTS `nota_credito` (
  `num_nota_cred` int(10) NOT NULL,
  `cod_cliente` int(8) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `referencias` text NOT NULL,
  `monto_nc` int(10) NOT NULL,
  `num_factura` int(10) NOT NULL,
  `codigo_eq_rep` int(10) NOT NULL,
  `nombre` text NOT NULL,
  `tipo_eqrep` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `nota_credito`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra`
--

CREATE TABLE IF NOT EXISTS `obra` (
  `cod_obra` int(9) NOT NULL auto_increment,
  `cod_cliente` int(8) NOT NULL,
  `cod_ciudad` int(3) NOT NULL,
  `cod_comuna` int(3) NOT NULL,
  `cod_personal` int(3) NOT NULL,
  `cod_condic` int(3) NOT NULL,
  `tipo_obra` text NOT NULL,
  `nombre_obra` text NOT NULL,
  `direcc_obra` text NOT NULL,
  `nom_adm` text NOT NULL,
  `fono_adm` int(8) NOT NULL,
  `movil_adm` int(9) NOT NULL,
  `email_adm` text NOT NULL,
  `num_contrato` int(9) NOT NULL,
  `girador` text NOT NULL,
  `nom_aut1` text NOT NULL,
  `cargo_aut1` text NOT NULL,
  `telefono_aut1` int(8) NOT NULL,
  `movil_aut1` int(9) NOT NULL,
  `email_aut1` text NOT NULL,
  `nom_aut2` text NOT NULL,
  `cargo_aut2` text NOT NULL,
  `telefono_aut2` int(8) NOT NULL,
  `movil_aut2` int(9) NOT NULL,
  `email_aut2` text NOT NULL,
  `nom_aut3` text NOT NULL,
  `cargo_aut3` text NOT NULL,
  `telefono_aut3` int(8) NOT NULL,
  `movil_aut3` int(9) NOT NULL,
  `email_aut3` text NOT NULL,
  `monto_vta_cred` int(9) NOT NULL,
  `descuento` int(2) NOT NULL,
  PRIMARY KEY  (`cod_obra`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Volcar la base de datos para la tabla `obra`
--

INSERT INTO `obra` (`cod_obra`, `cod_cliente`, `cod_ciudad`, `cod_comuna`, `cod_personal`, `cod_condic`, `tipo_obra`, `nombre_obra`, `direcc_obra`, `nom_adm`, `fono_adm`, `movil_adm`, `email_adm`, `num_contrato`, `girador`, `nom_aut1`, `cargo_aut1`, `telefono_aut1`, `movil_aut1`, `email_aut1`, `nom_aut2`, `cargo_aut2`, `telefono_aut2`, `movil_aut2`, `email_aut2`, `nom_aut3`, `cargo_aut3`, `telefono_aut3`, `movil_aut3`, `email_aut3`, `monto_vta_cred`, `descuento`) VALUES
(69, 11, 12, 10, 8, 1, '5', 'CUARTO SECTOR', 'AV.  BORGOñO 1243', 'JUAN PEREZ', 111111, 11111, 'JOSE@VTR.NET', 11, 'JUAN PEREZ', 'AUTORIZADO 1', 'SUPERVIRSOR 1', 2222, 3333, 'SUPERVISOR1@VTR.NET', 'AUTORIZAFO 2', 'SUPERVIRSOR 2', 44444, 55555, 'SUPERVISOR2@VTR.NET', 'AUTORIZADO 3', 'SUPERVIRSOR 3', 6666, 77777, 'SUPERVISOR3@VTR.NET', 5000000, 5),
(67, 11, 12, 10, 8, 1, '5', 'CUARTO SECTOR', 'REñACA 344', 'FELIPE ROJAS', 2222, 222222, 'FELIPE@VTR.NET', 123, 'FELIPE ROJAS', 'RUBEN CACERES', 'SUPERVISOR 1', 4444, 999, 'RUBENCACERES@VTR.NET', 'RAUL PUENTES', 'SUPERVISOR 2', 555, 9999, 'RAUL PUENTES@VRT.NET', 'CESAR MORENO', 'SUPERVISOR 3', 666777, 999999, 'CESAR MORENO@YAHOO.COM', 5000000, 10),
(68, 11, 9, 8, 18, 1, '5', 'SEGUNDO SECTOR', 'AV.  BORGOñO 1243', 'JUAN PEREZ', 111111, 0, 'JOSE@VTR.NET', 3333, 'JUAN PEREZ', 'AUTORIZADO 1', 'SUPERVIRSOR 1', 2222, 3333, 'SUPERVISOR1@VTR.NET', 'AUTORIZAFO 2', 'SUPERVIRSOR 2', 44444, 55555, 'SUPERVISOR2@VTR.NET', 'AUTORIZADO 3', 'SUPERVIRSOR 3', 6666, 77777, 'SUPERVISOR3@VTR.NET', 5000000, 5),
(112, 12, 12, 10, 8, 1, '5', 'EDIFICIO FORESTA DE MONTEMAR', 'AV. LOMAS DE MONTEMAR Nº 50', 'MICHAEL METZGER BOCAZ', 2975271, 999, 'MMETZGER @CONSTALBORADA.CL', 2, 'DDDDDDDD', 'MICHAEL METZGER BOCAZ', 'JEFE ADQUISIONES', 2975271, 999, 'MMETZGER @CONSTALBORADA.CL', 'NELSON VALENZUELA', 'HHHHH', 67787, 999, 'GGGGGG', 'GGGGGG', 'GGG', 777, 999, 'JJJJJJ', 5000000, 0),
(113, 12, 10, 7, 8, 2, '6', 'PLACERES', 'AV. MATA 111', 'XXXXXX', 111, 111, 'XXXXX', 1, 'XXXXX', 'XXXXXXXXXXXXXXXXX', 'XXXXXXXXX', 1111, 1111, 'XXXXXXX', 'XXXXXXXXX', 'XXXXXXXXXX', 1111, 1111, 'XXXXXXXXXX', 'XXXXXXXXXX', 'XXXXXXXXXX', 3333333, 33333333, 'XXXXXXXX', 5000000, 0),
(114, 24, 10, 7, 17, 1, '5', 'OBRA FICTICIA', 'DIRECC OBRA 1', 'ADM OBRA 1', 332211, 32132132, 'EMAIL@ADMIOBRA1.CL', 36912, 'GIRADOR1', 'AUT1', 'CARGO1', 3691215, 65465465, 'EMAIL@AUT1.CL', 'AUT2', 'CARGO2', 481216, 98798798, 'EMAIL@AUT2.CL', 'AUT3', 'CARGO3', 5101520, 14714714, 'EMAIL@AUT3.CL', 500000000, 2),
(110, 22, 12, 10, 18, 2, '5', 'OBRA SAN ANTONIO', 'XXXXXX', 'PATRICIO JARAQUEMADA', 999, 999, 'XXXXXXXX', 111, 'XXXXXXXX', 'XXXX', 'XXXXXX', 888, 888, 'XXXXXXXX', 'XXXXXXX', 'XXXXXXXX', 77, 77, 'XXXXXXX', 'XXXXXXX', 'XXXXXXXX', 333, 333, 'XXXXXXXX', 5000000, 0),
(111, 12, 12, 10, 8, 1, '5', 'LIMONARES', 'ISALA PICTON Nº 50 CANAL BEABLE', 'JULIO CASTILLO', 2875251, 999, 'JULIO CASTILLO', 1, 'HHHHH', 'JUAN PEREZ', 'GGGGG', 2124, 999, 'HHHHHH', 'PEDRO ALVAREZ', 'GGGGGGG', 1111, 999, 'GGGGGG', 'HHHHHH', 'HHHHHH', 3444, 999, 'JJJJJJ', 5000000, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otros_gastos`
--

CREATE TABLE IF NOT EXISTS `otros_gastos` (
  `cod_otros_gastos` int(3) NOT NULL auto_increment,
  `cod_repuesto` int(9) NOT NULL,
  `fecha_gasto` varchar(255) NOT NULL,
  `monto_gasto` int(9) NOT NULL,
  `Observaciones` text NOT NULL,
  PRIMARY KEY  (`cod_otros_gastos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `otros_gastos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otros_gastos_e`
--

CREATE TABLE IF NOT EXISTS `otros_gastos_e` (
  `cod_otros_gastos_e` int(3) NOT NULL auto_increment,
  `cod_equipo` int(6) NOT NULL,
  `fecha_gasto` varchar(255) NOT NULL,
  `monto_gasto` int(9) NOT NULL,
  `Observaciones` text NOT NULL,
  PRIMARY KEY  (`cod_otros_gastos_e`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Volcar la base de datos para la tabla `otros_gastos_e`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE IF NOT EXISTS `personal` (
  `cod_personal` int(3) NOT NULL auto_increment,
  `cod_tipo_pers` int(3) NOT NULL,
  `cod_ciudad` int(3) NOT NULL,
  `rut_personal` text NOT NULL,
  `ap_patpersonal` text NOT NULL,
  `ap_matpersonal` text NOT NULL,
  `nombres_personal` text NOT NULL,
  `fecha_nacpersonal` text NOT NULL,
  `valor_hh` int(6) NOT NULL,
  `fono` int(8) NOT NULL,
  `movil` int(9) NOT NULL,
  `direcc` text NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY  (`cod_personal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Volcar la base de datos para la tabla `personal`
--

INSERT INTO `personal` (`cod_personal`, `cod_tipo_pers`, `cod_ciudad`, `rut_personal`, `ap_patpersonal`, `ap_matpersonal`, `nombres_personal`, `fecha_nacpersonal`, `valor_hh`, `fono`, `movil`, `direcc`, `email`) VALUES
(18, 4, 12, '15.100.174-2', 'FOZ.', 'GLAVES', 'BORIS JUSEF', '04/01/2011', 1311, 99999999, 99999999, 'QUILPUE', 'GLAVES@VIGIMAQ.CL'),
(17, 2, 12, '08.393.694-0', 'COOK', 'URRIOLA', 'JUAN HUMBERTO', '21/09/1958', 1698, 62183591, 62183591, 'BELLOTO', 'JCOOK.VIGOMAQ@GMAIL.COM'),
(8, 2, 9, '12.450.399-k', 'VICENCIO', 'URRIOLA', 'KAREN JENNY ', '2010/12/17', 1417, 8888, 9999, 'SANTA JULIA ', 'KAREN JENNY '),
(21, 6, 13, '09.457.557-5', 'MADRIS', 'BUSTOS', 'EVANGELINA GIEZI', '17/01/2011', 1375, 990000, 990000, 'V. ALEMANA', 'EVANGELINA GIEZI@VIGOMAQ.CL'),
(22, 1, 12, '09.183.929-6', 'HURTADO', 'OLGUIN', 'JULIO', '12/02/2011', 111111, 1111, 111, 'GGGGGGGGGGGGGGGGGGGG', 'BBBBB@VTR.NET');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `cod_fabricante` int(6) NOT NULL auto_increment,
  `cod_ciudad` int(3) NOT NULL,
  `cod_comuna` int(3) NOT NULL,
  `raz_social` text NOT NULL,
  `Rut` text NOT NULL,
  `Dv` text NOT NULL,
  `Giro` text NOT NULL,
  `cod_area` int(3) NOT NULL,
  `fono` int(8) NOT NULL,
  `movil` int(9) NOT NULL,
  `Direcc` text NOT NULL,
  `email` text NOT NULL,
  `inst_pago` text NOT NULL,
  `contacto1` text NOT NULL,
  `fono_cont1` int(8) NOT NULL,
  `email_cont1` text NOT NULL,
  `contacto2` text NOT NULL,
  `fono_cont2` int(8) NOT NULL,
  `email_cont2` text NOT NULL,
  `contacto3` text NOT NULL,
  `fono_cont3` int(8) NOT NULL,
  `email_cont3` text NOT NULL,
  `observaciones` text NOT NULL,
  PRIMARY KEY  (`cod_fabricante`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Volcar la base de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`cod_fabricante`, `cod_ciudad`, `cod_comuna`, `raz_social`, `Rut`, `Dv`, `Giro`, `cod_area`, `fono`, `movil`, `Direcc`, `email`, `inst_pago`, `contacto1`, `fono_cont1`, `email_cont1`, `contacto2`, `fono_cont2`, `email_cont2`, `contacto3`, `fono_cont3`, `email_cont3`, `observaciones`) VALUES
(83, 12, 10, 'SEBTER CONSULTORES', '76.107.796-1', '', 'SISTEMA GESTIóN', 32, 2710100, 90762031, 'STRUGA 1825 ', 'JULIOHURTADO@VTR.NET', 'EFECTIVO', 'GUSTAVO', 9889, 'GUSTAVO@VTR.NET', 'FRANCISCO', 4335, 'FRANCISCO@VTR.NET', 'ELISEO', 1233, 'ELISEO@VTR.NET', 'ULTIMA COMPRA CON DESCUENTO 30%, 15-12-2010                                                                                  '),
(82, 14, 11, 'PEDRO HERNAN AGUILERA AGUILERA', '12.597.434-1', '', 'CONSTRUCCION', 32, 2977889, 77691241, 'PARCELACION DON MAXIMILIANO P2 ', 'JULIOHURTADO@VTR.NET', 'EFECTIVO', 'CONTACTO 1X', 1111, 'JULIOHURTADO@VTR.NET', 'CONTACTO 2', 2222, 'CONTACTO2@VTR.NET', 'CONTACTO 3', 33333, 'CONTACTO3@VTR.NET', 'EXIGE TRANSFERENCIA BANCARIA ANTES DE DESPACHAR PRODUCTOS                                       ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reclamo`
--

CREATE TABLE IF NOT EXISTS `reclamo` (
  `cod_reclamo` int(9) NOT NULL auto_increment,
  `cod_estado_equipo` int(2) NOT NULL,
  `cod_cliente` int(8) NOT NULL,
  `cod_equipo_dev` int(8) NOT NULL,
  `cod_equipo_entreg` int(8) NOT NULL,
  `det_falla` text NOT NULL,
  `fecha_reclamo` varchar(255) NOT NULL,
  `hora_reclamo` text NOT NULL,
  `num_gd_salida` int(9) NOT NULL,
  `num_gd_ingreso` int(9) NOT NULL,
  `resolucion_reclamo` text NOT NULL,
  PRIMARY KEY  (`cod_reclamo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Volcar la base de datos para la tabla `reclamo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rentabilidad`
--

CREATE TABLE IF NOT EXISTS `rentabilidad` (
  `cod_equipo` int(9) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `concepto` text NOT NULL,
  `ingreso` int(10) NOT NULL,
  `egreso` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `rentabilidad`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparacion_equipos`
--

CREATE TABLE IF NOT EXISTS `reparacion_equipos` (
  `cod_reparacion` int(6) NOT NULL auto_increment,
  `cod_arriendo` int(9) NOT NULL,
  `cod_equipo` int(8) NOT NULL,
  `cod_estado_equipo` int(2) NOT NULL,
  `detalle_reparacion` text NOT NULL,
  `valor_reparacion` int(9) NOT NULL,
  `fecha_reparacion` varchar(255) NOT NULL,
  `cod_personal` int(3) NOT NULL,
  `cant_hh` int(3) NOT NULL,
  PRIMARY KEY  (`cod_reparacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Volcar la base de datos para la tabla `reparacion_equipos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuesto`
--

CREATE TABLE IF NOT EXISTS `repuesto` (
  `cod_repuesto` int(6) NOT NULL auto_increment,
  `cod_familia` int(3) NOT NULL,
  `cod_fabricante` text NOT NULL,
  `cod_unidad` int(3) NOT NULL,
  `ubicacion_repuesto` text NOT NULL,
  `cod_proveedor` int(6) NOT NULL,
  `nombre_repuesto` text NOT NULL,
  `cantidad_repuestos` int(6) NOT NULL,
  `fecha_compra` text NOT NULL,
  `precio_costo` int(9) NOT NULL,
  `precio_bodega` int(9) NOT NULL,
  `precio_sala` int(9) NOT NULL,
  `porc_dscto` int(3) NOT NULL,
  `precio_costo_lista` int(9) NOT NULL,
  `obs_reposicion` text NOT NULL,
  PRIMARY KEY  (`cod_repuesto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcar la base de datos para la tabla `repuesto`
--

INSERT INTO `repuesto` (`cod_repuesto`, `cod_familia`, `cod_fabricante`, `cod_unidad`, `ubicacion_repuesto`, `cod_proveedor`, `nombre_repuesto`, `cantidad_repuestos`, `fecha_compra`, `precio_costo`, `precio_bodega`, `precio_sala`, `porc_dscto`, `precio_costo_lista`, `obs_reposicion`) VALUES
(11, 18, '', 12, 'BODEGA CENTRAL', 82, 'ACOPLE MOTOBOMBA 2"', 120, '20/12/2010', 15000, 19500, 38000, 7, 17000, 'YYYYYYYYHHHHHHHHJJJJJJ'),
(10, 19, '', 9, 'BODEGA CENTRAL', 82, 'ANILLO SELLO HP2050', 50, '06/12/2010', 100, 130, 260, 3, 110, 'ULTIMA COMPRA PROVEEDOR PRESENTO PROBLEMA DE DESPACHO'),
(9, 17, '', 6, 'BODEGA CENTRAL', 83, 'ABRAZADERA MANGO HM1201', 300, '01/12/2010', 1200, 1584, 3168, 10, 1320, 'EL PROVEEDOR ES MUY BUEN, LA ULTIMA COMPRA POR 300 UNIDADES NOS HIZO UN DSCTO DEL 30%'),
(6, 15, 'SB-01', 9, 'BODEGA CASA MATRIZ', 82, 'SENSOR AB1', 12, '2010/12/01', 18000, 20500, 25000, 20, 19500, 'úLTIMA COMPRA CON DESCUENTO 5% PAGO 30 DíAS  XXXXX'),
(7, 16, 'SB-I-12', 6, 'BODEGA QUILLOTA', 82, 'INTERRUPTOR SB', 10, '2010/12/07', 5000, 6000, 8000, 15, 6000, 'úLTIMA COMPRA CON DESCUENTO 50% PAGO CONTADO'),
(12, 21, '', 6, 'BODEGA CENTRAL', 83, 'BIELA ROBIN EX27', 7, '30/11/2010', 1000, 1300, 2600, 58, 1100, 'NNNNMMMMMHH\r\n\r\n888888899999999'),
(13, 24, '', 6, 'BODEGA CENTRAL', 82, 'BUJIA LARGA', 40, '16/12/2010', 500, 700, 1400, 4, 550, '8787878787 MMKKKKKK   \r\n\r\nOOOOOOOOO'),
(14, 28, '', 11, 'BODEGA CENTRAL', 83, 'DISCO DIAMANTADO CONTINUO ESTRIADO ', 4, '02/12/2010', 3000, 3800, 7600, 3, 3500, 'IIIIIIIMMMMMM 3333222'),
(15, 37, '', 10, 'BODEGA CENTRAL', 83, 'FILTRO COMBUSTIBLE LOMBARDINI 15LD3', 22, '14/09/2010', 4500, 5000, 10000, 5, 4700, 'GGGGGGGGGG  ññññññññññññ'),
(16, 42, '', 6, 'BODEGA CENTRAL', 82, 'PARTIDOR COMPLETO ROBIN EY15', 10, '30/09/2010', 8000, 8900, 17400, 7, 8500, 'TTTTTRRRRRR'),
(17, 44, '', 6, 'BODEGA CENTRAL', 83, 'PERNO HEX. 1/2"X2" G°5 COMPLETO', 100, '03/12/2010', 300, 350, 700, 3, 320, 'BBBBBBBBBBBBBBB   YYYYYYYY'),
(18, 54, '', 7, 'BODEGA CENTRAL', 82, 'SELLO MECANICO #14 BEUMONG', 500, '17/12/2010', 6000, 7200, 14400, 4, 6600, 'IIIII444444'),
(19, 59, '', 6, 'BODEGA CENTRAL', 82, 'VALVULA ESCAPE YANMAR L40', 40, '20/10/2010', 2500, 5400, 11000, 5, 2900, 'UUUUUUUUUU WWWWWWWWWW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE IF NOT EXISTS `sucursales` (
  `cod_sucursal` int(1) NOT NULL auto_increment,
  `sucursal` text NOT NULL,
  PRIMARY KEY  (`cod_sucursal`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcar la base de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`cod_sucursal`, `sucursal`) VALUES
(20, 'VIñA DEL MAR'),
(18, 'SUCURSAL QUILPUE'),
(16, 'SUCURSAL QUILLOTA'),
(15, 'CASA MATRIZ ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarifa_Despacho`
--

CREATE TABLE IF NOT EXISTS `Tarifa_Despacho` (
  `cod_tarifa` int(2) NOT NULL auto_increment,
  `lugar_despacho` text NOT NULL,
  `tarifa` int(9) NOT NULL,
  PRIMARY KEY  (`cod_tarifa`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcar la base de datos para la tabla `Tarifa_Despacho`
--

INSERT INTO `Tarifa_Despacho` (`cod_tarifa`, `lugar_despacho`, `tarifa`) VALUES
(18, 'VALPARAISO', 5000),
(17, 'CENTRO VIÑA  ', 2000),
(19, 'CON CON', 7000),
(20, 'SANTIAGO', 60000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `cod_tipocli` int(2) NOT NULL auto_increment,
  `tipo_cliente` text NOT NULL,
  PRIMARY KEY  (`cod_tipocli`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcar la base de datos para la tabla `tipo_cliente`
--

INSERT INTO `tipo_cliente` (`cod_tipocli`, `tipo_cliente`) VALUES
(10, 'PREFERENCIAL-PARTICULAR'),
(9, 'PREFERENCIAL-EMPRESA   '),
(8, 'PREMIUM-PARTICULAR'),
(7, 'PREMIUM-EMPRESA '),
(11, 'NORMAL-EMPRESA'),
(12, 'NORMAL-PARTICULAR'),
(13, 'BLOQUEADO POR IMPAGO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_evaluacion`
--

CREATE TABLE IF NOT EXISTS `tipo_evaluacion` (
  `cod_tipoeval` int(2) NOT NULL auto_increment,
  `tipo_evaluar` text NOT NULL,
  PRIMARY KEY  (`cod_tipoeval`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `tipo_evaluacion`
--

INSERT INTO `tipo_evaluacion` (`cod_tipoeval`, `tipo_evaluar`) VALUES
(6, 'MANTENCIÓN CORRECTIVA '),
(5, 'INSPECCIÓN OCULAR  '),
(7, 'MANTENCIÓN PREVENTIVA '),
(8, 'MEJORA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_garantia`
--

CREATE TABLE IF NOT EXISTS `tipo_garantia` (
  `cod_tipo_gar` int(2) NOT NULL auto_increment,
  `tipo_garantia` text NOT NULL,
  PRIMARY KEY  (`cod_tipo_gar`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `tipo_garantia`
--

INSERT INTO `tipo_garantia` (`cod_tipo_gar`, `tipo_garantia`) VALUES
(1, 'VALE VISTA'),
(2, 'CHEQUE'),
(3, 'PAGARE'),
(4, 'CONTRATO ESPECIAL'),
(5, 'SIN GARANTIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_obra`
--

CREATE TABLE IF NOT EXISTS `tipo_obra` (
  `cod_tipo_obra` int(3) NOT NULL auto_increment,
  `tipo_obra` text NOT NULL,
  PRIMARY KEY  (`cod_tipo_obra`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `tipo_obra`
--

INSERT INTO `tipo_obra` (`cod_tipo_obra`, `tipo_obra`) VALUES
(4, 'CONSTRUCCION CASAS'),
(3, 'VIALES'),
(5, 'CIVILES'),
(6, 'CONSTRUCCION EDIFICIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_personal`
--

CREATE TABLE IF NOT EXISTS `tipo_personal` (
  `cod_tipo_pers` int(2) NOT NULL auto_increment,
  `tipo_personal` text NOT NULL,
  PRIMARY KEY  (`cod_tipo_pers`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `tipo_personal`
--

INSERT INTO `tipo_personal` (`cod_tipo_pers`, `tipo_personal`) VALUES
(1, 'ADMINISTRATIVO '),
(2, 'VENDEDOR '),
(3, 'EJECUTIVO'),
(4, 'TECNICO 1'),
(5, 'SUPERVISOR'),
(6, 'SECRETARIA'),
(8, 'TECNICO 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE IF NOT EXISTS `transacciones` (
  `fecha` varchar(255) NOT NULL,
  `hora` text NOT NULL,
  `usuario` text NOT NULL,
  `tipo_documento` text NOT NULL,
  `folio` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `transacciones`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE IF NOT EXISTS `unidad` (
  `cod_unidad` int(3) NOT NULL auto_increment,
  `unidad` text NOT NULL,
  PRIMARY KEY  (`cod_unidad`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`cod_unidad`, `unidad`) VALUES
(9, 'PAR'),
(8, 'KILOGRAMOS'),
(7, 'METROS'),
(6, 'UNIDAD'),
(10, 'BOLSA'),
(12, 'KIT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `rut_usuario` text NOT NULL,
  `nombre_usuario` text NOT NULL,
  `contrasena` text NOT NULL,
  `tipo_usuario` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`rut_usuario`, `nombre_usuario`, `contrasena`, `tipo_usuario`) VALUES
('12.450.399-k', 'Admin', '123456', '0'),
('09.183.929-6', 'jhurtado', 'jho', '2'),
('15.100.174-2', 'bjusef', '123456', '1'),
('12.222.634-4', 'invitado', '123456', '1');

<?php
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("menu_superior.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Carga($data, $link){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("parent.frames['principal'].location='$link';");
	return $objResponse->getXML();
	} 

//CARGA LOS MENUES
$arrRegistros = array();
$arrRegistrosDet = array();

$perfil = $_SESSION["alycar_perfil"];

$sql = "select count(tper_ncorr) as tper_ncorr
                                            from menues 
        where tper_ncorr < ".$perfil."
            or tper_ncorr = ".$perfil."
        order by menu_orden as";
$res = mysql_query($sql, $conexion);
$line = mysql_fetch_assoc($res);
$contador = $line['tper_ncorr'];
$tamano = 100/($contador+1);

$miSmarty->assign('contador', $contador);
$miSmarty->assign('tamano', $tamano);

$sql = "select * 
        from menues 
        where tper_ncorr < ".$perfil."
            or tper_ncorr = ".$perfil."
        order by menu_orden asc";
$res = mysql_query($sql, $conexion);
while ($line = mysql_fetch_assoc($res)) {
	array_push($arrRegistros, array("menu_ncorr" => $line['menu_ncorr'], "descripcion" => $line['menu_desc']));
	
	$sql_1 = "select * 
                from menues_hijos 
                where (menu_ncorr = '".$line['menu_ncorr']."' 
                    and mhij_mostrar = 'SI' )
                order by mhij_orden";
	$res_1 = mysql_query($sql_1, $conexion);
	while ($line_1 = mysql_fetch_assoc($res_1)) {
		array_push($arrRegistrosDet, array("menu_ncorr" => $line['menu_ncorr'], 
											"mhij_desc" => $line_1['mhij_desc'], 
											"mhij_contr" => '', 
											"mhij_link" => $line_1['mhij_link']));
		}
	}

$miSmarty->assign('arrRegistrosDet', $arrRegistrosDet);
$miSmarty->assign('arrRegistros', $arrRegistros);
$xajax->registerFunction("Carga");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nombre_usuario', $_SESSION["alycar_nombreusuario"]);
$miSmarty->assign('anio', $_SESSION["sige_anio_escolar_vigente"]);


$miSmarty->display('menu_superior.tpl');

?>


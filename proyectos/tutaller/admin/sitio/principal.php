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

$xajax->setRequestURI("principal.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Carga($data, $link){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$objResponse->addScript("parent.frames['principal'].location='$link';");
	return $objResponse->getXML();
	} 

//CARGA LOS MENUES
$arrRegistros = array();
$arrRegistrosDet = array();
$arrRegistrosDet_1 = array();

$perfil = $_SESSION["alycar_perfil"];



if ($perfil=='99'){
	$sql = "select count(tper_ncorr) as tper_ncorr
	                                            from menues 
	        where tper_ncorr < ".$perfil."
	            or tper_ncorr = ".$perfil."
	        order by menu_orden asc";
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
			list($uno,$dos,$tres) = explode('&',$line_1['mhij_link']);
			list($titulo,$grupo) = explode('=',$dos);
			if (substr($line_1['mhij_link'], 0,4)!='menu'){ $grupo = '1';}
			array_push($arrRegistrosDet, array("menu_ncorr" => $line['menu_ncorr'], 
												"mhij_desc" => $line_1['mhij_desc'], 
												"mhij_contr" => $line_1['mhij_contr'], 
												"mhij_link" => $line_1['mhij_link'], 
												"menu_sub" => $grupo));
			if (substr($line_1['mhij_link'], 0,4)=='menu'){
				$sql_2 = "select * 
			                from menues_hijos 
			                where (menu_ncorr = '".$line['menu_ncorr']."' 
			                    and menu_sub = '".$grupo."')
			                order by mhij_orden";
				$res_2 = mysql_query($sql_2, $conexion);
				while ($line_2 = mysql_fetch_assoc($res_2)) {
					array_push($arrRegistrosDet_1, array("menu_ncorr" => $line['menu_ncorr'], 
														"mhij_desc" => $line_2['mhij_desc'], 
														"mhij_contr" => $line_2['mhij_contr'], 
														"mhij_link" => $line_2['mhij_link'], 
														"menu_sub" => $line_2['menu_sub']));
					}
				}
			}
		}
	}
else{
	$perf_ncorr 	= 	$_SESSION["alycar_perfil"];
	
	$sql = "SELECT b.mhij_desc, b.mhij_link, b.mhij_ncorr, a.menu_ncorr, c.menu_desc
			FROM usuarios_perfiles_menu a, menues_hijos b, menues c
			
			WHERE 
			a.tper_ncorr = '".$perf_ncorr."' and
			a.mhij_ncorr = b.mhij_ncorr and
			a.menu_ncorr = c.menu_ncorr
			GROUP BY a.menu_ncorr, a.mhij_ncorr
			ORDER BY a.menu_ncorr, a.upme_orden";

	$res = mysql_query($sql, $conexion) or die(mysql_error());
	$menu_ant = "";
	$contador = 0;
	while ($line = mysql_fetch_array($res)) {
			if ($menu_ant!= $line['menu_ncorr']){
				array_push($arrRegistros, array("menu_ncorr" => $line['menu_ncorr'], "descripcion" => $line['menu_desc']));
				$contador = $contador +1;
				}
			$menu_ant = $line['menu_ncorr'];
			$sql_1 = "select * 
                from menues_hijos 
                where (menu_ncorr = '".$line['menu_ncorr']."' 
                    and mhij_mostrar = 'SI' and mhij_ncorr = '".$line['mhij_ncorr']."')
                order by mhij_orden";
			$res_1 = mysql_query($sql_1, $conexion) or die(mysql_error());
			while ($line_1 = mysql_fetch_array($res_1)) {
				list($uno,$dos,$tres) = explode('&',$line_1['mhij_link']);
				list($titulo,$grupo) = explode('=',$dos);
				if (substr($line_1['mhij_link'], 0,4)!='menu'){ $grupo = '1';}
				array_push($arrRegistrosDet, array("menu_ncorr" => $line['menu_ncorr'], 
													"mhij_desc" => $line_1['mhij_desc'], 
													"mhij_contr" => $line_1['mhij_contr'], 
													"mhij_link" => $line_1['mhij_link'], 
													"menu_sub" => $grupo));
				if (substr($line_1['mhij_link'], 0,4)=='menu'){
					$sql_2 = "select * 
				                from menues_hijos 
				                where (menu_ncorr = '".$line['menu_ncorr']."' 
				                    and menu_sub = '".$grupo."')
				                order by mhij_orden";
					$res_2 = mysql_query($sql_2, $conexion);
					while ($line_2 = mysql_fetch_assoc($res_2)) {
						array_push($arrRegistrosDet_1, array("menu_ncorr" => $line['menu_ncorr'], 
															"mhij_desc" => $line_2['mhij_desc'], 
															"mhij_contr" => $line_2['mhij_contr'], 
															"mhij_link" => $line_2['mhij_link'], 
															"menu_sub" => $line_2['menu_sub']));
						}
					}
				}
			}
	$tamano = 100/($contador+1);

	$miSmarty->assign('contador', $contador);
	$miSmarty->assign('tamano', $tamano);

}
$miSmarty->assign('arrRegistrosDet_1', $arrRegistrosDet_1);
$miSmarty->assign('arrRegistrosDet', $arrRegistrosDet);
$miSmarty->assign('arrRegistros', $arrRegistros);
$xajax->registerFunction("Carga");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nombre_usuario', $_SESSION["alycar_nombreusuario"]);
//$miSmarty->assign('anio', $_SESSION["sige_anio_escolar_vigente"]);


$miSmarty->display('principal.tpl');

?>


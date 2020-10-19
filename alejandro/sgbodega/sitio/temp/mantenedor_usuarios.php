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
include "../includes/php/validaciones.php";

$xajax = new xajax();

$xajax->setRequestURI("mantenedor_usuarios.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_ncorr_oculto = $data["txtNcorrOculto"];
	$usu_login 		= $data["OBLI-txtLogin"];
	$usu_pass 		= $data["OBLI-txtPass"];
	$usu_nombre 	= strtoupper($data["OBLI-txtNombre"]);
	$sucu_ncorr 	= $data["OBLI-cboSucursal"];
	$tper_ncorr 	= $data["OBLI-cboPerfil"];
	$usu_celular 	= $data["txtCelular"];
	$usu_fono1 		= $data["txtFono1"];
	$usu_fono2 		= $data["txtFono2"];
	$usu_mail 		= $data["txtMail"];
	
	
	$ingresa = "SI";
	
	if ($ingresa == "SI"){
		
		$sql = "select usu_ncorr, usu_login from usuarios where usu_login = '".$usu_login."'";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			if (mysql_result($res,0,"usu_ncorr") == $v_ncorr_oculto){
				$objResponse->addScript("confirmacion = confirm('Se modificarán los datos del usuario, ¿ Desea Continuar ?');
				if (confirmacion == true)
				{
					xajax_Modificar(xajax.getFormValues('Form1'));
				}
				");
			}else{
				
				$objResponse->addScript("alert('El Login ya Existe.')");
			}	
		}else{	
		
			$sql = "INSERT INTO usuarios
					(usu_login, usu_pass, usu_nombre, sucu_ncorr, tper_ncorr, usu_celular, usu_fono1, usu_fono2, usu_mail)
		
					VALUES 
					('".$usu_login."', '".$usu_pass."', '".$usu_nombre."', '".$sucu_ncorr."', '".$tper_ncorr."', 
					'".$usu_celular."',	'".$usu_fono1."','".$usu_fono2."', '".$usu_mail."')";

					$res = mysql_query($sql, $conexion);

					$objResponse->addScript("alert('Registro Ingresado Correctamente.')");
	
					//$objResponse->addScript("location.href='contratos_paso1.php'");
	
					//INICIALIZA EL FORMULARIO
					$objResponse->addScript("window.document.Form1.submit();");
		}
	}
	
	return $objResponse->getXML();
}
function Modificar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_ncorr_oculto = $data["txtNcorrOculto"];
	$usu_login 		= $data["OBLI-txtLogin"];
	$usu_pass 		= $data["OBLI-txtPass"];
	$usu_nombre 	= strtoupper($data["OBLI-txtNombre"]);
	$sucu_ncorr 	= $data["OBLI-cboSucursal"];
	$tper_ncorr 	= $data["OBLI-cboPerfil"];
	$usu_celular 	= $data["txtCelular"];
	$usu_fono1 		= $data["txtFono1"];
	$usu_fono2 		= $data["txtFono2"];
	$usu_mail 		= $data["txtMail"];
	
	$sql = "UPDATE usuarios SET
		
			usu_login 		= '".$usu_login."',
			usu_pass 		= '".$usu_pass."',
			usu_nombre 		= '".$usu_nombre."',
			sucu_ncorr 		= '".$sucu_ncorr."',
			tper_ncorr 		= '".$tper_ncorr."',
			usu_celular 	= '".$usu_celular."',
			usu_fono1 		= '".$usu_fono1."',
			usu_fono2 		= '".$usu_fono2."',
			usu_mail 		= '".$usu_mail."'
		
			WHERE usu_ncorr = '".$v_ncorr_oculto."'";
	
	$res = mysql_query($sql, $conexion);

	$objResponse->addScript("alert('Registro Grabado Correctamente.')");
	
	//$objResponse->addScript("location.href='contratos_paso1.php'");
	
	//INICIALIZA EL FORMULARIO
	$objResponse->addScript("window.document.Form1.submit();");
	
	return $objResponse->getXML();
}

function BuscaCliente($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_cont_rut_cliente = $data["OBLI-txtRut"];
	
	$sql = "select GetNombreCliente(GetCodigoCliente($v_cont_rut_cliente)) as cliente";
	$res = mysql_query($sql, $conexion);
	$objResponse->addAssign("OBLI-txtNombre", "value", @mysql_result($res,0,"cliente"));
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga tipos de perfiles
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboPerfil','tipos_perfiles','','- - Seleccione - -','tper_ncorr', 'tper_desc')");
	
	$objResponse->addScript("document.getElementById('OBLI-txtLogin').focus();");
	
	
	return $objResponse->getXML();
}          

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla";
	if ($tabla == 'reg_ciu'){
		$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla where codigo = 'REG'";
	}
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		$objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("OBLI-txtLogin", "value", $campo1);
	$objResponse->addAssign("OBLI-txtNombre", "value", $campo2);
	
	$sql = "select * from usuarios where usu_login = '".$campo1."'";
	$res = mysql_query($sql, $conexion);	
	if (mysql_num_rows($res) > 0){
		$line = @mysql_fetch_assoc($res);
		
		
		$objResponse->addAssign("txtNcorrOculto", "value", $line['usu_ncorr']);
		$objResponse->addAssign("OBLI-txtPass", "value", $line['usu_pass']);
		
		$desc = BuscaDescripcionTabla('sucursales','sucu_ncorr','sucu_desc', $line['sucu_ncorr']);
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboSucursal','sucursales','".$line['sucu_ncorr']."','".$desc."','sucu_ncorr', 'sucu_desc')");
		
		$desc = BuscaDescripcionTabla('tipos_perfiles','tper_ncorr','tper_desc', $line['tper_ncorr']);
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboPerfil','tipos_perfiles','".$line['tper_ncorr']."','".$desc."','tper_ncorr', 'tper_desc')");
		
		$objResponse->addAssign("txtCelular", "value", $line['usu_celular']);
		$objResponse->addAssign("txtFono1", "value", $line['usu_fono1']);
		$objResponse->addAssign("txtFono2", "value", $line['usu_fono2']);
		$objResponse->addAssign("txtMail", "value", $line['usu_mail']);
	
	}
	
	return $objResponse->getXML();
}
function BuscaDescripcionTabla($tabla, $campo1, $campo2, $valor_campo1){
    global $conexion;
	
	$sql = "select $campo2 as descripcion from $tabla where $campo1 = $valor_campo1";
	$res = mysql_query($sql, $conexion);
	
	return @mysql_result($res,0,"descripcion");
	
}
$xajax->registerFunction("Grabar");
$xajax->registerFunction("BuscaCliente");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("Modificar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('mantenedor_usuarios.tpl');

?>


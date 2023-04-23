<?php ob_start(); 
session_start(); 


//conectamos a la base de datos 
//mysql_connect("localhost","root","sebterROOT9384"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
//mysql_select_db("vigomaq"); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
if (isset($_POST['SI'])){
	if ($_POST['SI']=='Registrar Pago'){
		include("classes/conex.php");
		$link = Conectarse();

		if(isset($_POST['fecha']))$fecha	= $_POST['fecha'];
		list($dia1,$mes1,$anio1) = explode('-', $fecha);
		$fecha 	= $anio1.'-'.$mes1.'-'.$dia1;
		if(isset($_POST['tipo_pago']))$tipo_pago		= $_POST['tipo_pago'];
		if(isset($_POST['monto']))$monto_cp	= $_POST['monto'];
		if(isset($_POST['saldo_pago']))$saldo_pago	= $_POST['saldo_pago'];
		if(isset($_POST['total_pago']))$total_pago	= $_POST['total_pago'];
		$arr_factura = explode(',',$_POST['facturas']);
		$arr_factura_cantidad = $_POST['seleccion'];
		$i=0;
		if ($total_pago==$monto_cp){
			echo $sql = "INSERT INTO `comprobante_pago` (`fecha_cp`, forma_pago, monto, `usuario`, fecha_dig) 
							VALUES ('".$fecha."','".$tipo_pago."','".$monto_cp."', 
									'".$_SESSION['usuario']."','".date("Y-m-d H:i:s")."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			$cp_ncorr = mysql_insert_id();
			if (($tipo_pago!='1')){

				if(isset($_POST['fecha_cheque']))$fecha_cheque	= $_POST['fecha_cheque'];
				list($dia1,$mes1,$anio1) = explode('-', $fecha_cheque);
				$fecha_cheque 	= $anio1.'-'.$mes1.'-'.$dia1;
				if(isset($_POST['banco_cheque']))$banco_cheque	= $_POST['banco_cheque'];
				if(isset($_POST['ctacte_cheque']))$ctacte_cheque	= $_POST['ctacte_cheque'];
				if(isset($_POST['nro_cheque']))$nro_cheque	= $_POST['nro_cheque'];
				if(isset($_POST['valor_cheque']))$valor_cheque	= $_POST['valor_cheque'];
					
				echo $sql = "INSERT INTO `factura_operaciones` (cp_ncorr, `fecha`, banco, ctacte, nrocheque, 
														valor, `usuario`, fecha_dig) 
								VALUES ('".$cp_ncorr."','".$fecha_cheque."',
										'".$banco_cheque."','".$ctacte_cheque."', 
										'".$nro_cheque."','".$valor_cheque."', 
										'".$_SESSION['usuario']."','".date("Y-m-d H:i:s")."')";
				$res=mysql_query($sql,$link) or die(mysql_error());
				
				}
			
			foreach ($arr_factura as $num_factura){
				$monto = $arr_factura_cantidad[$i];
				echo $num_factura;
				$sql_0 = "SELECT sum(tot_arriendo) as total ,sum(total_rep) as total_1
					FROM factura
						inner join det_factura
							on factura.num_factura = det_factura.num_factura
					where factura.num_factura = '".$num_factura."'
					group by factura.num_factura";			
				$res_0 = mysql_query($sql_0,$link) or die(mysql_error());
				$row_0 = mysql_fetch_array($res_0);
				
				$total = $row_0['total'];
				if ($total==0){
					$total = $row_0['total_1'];
					}
				if ($monto>0){
					$sql = "update factura
						set 	estado = 'ABONANDO'
						where num_factura = '".$num_factura."'";
					$res=mysql_query($sql,$link) or die(mysql_error());
					$obs = "Accion : Abonado || Nro. : ".$id." || Fecha : ".$fecha;
					$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) 
							VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','ABONANDO','".$_SESSION['usuario']."')";
					$res=mysql_query($sql,$link) or die(mysql_error());

					echo $sql = "INSERT INTO `factura_pagos`( `cp_ncorr`,  `tipo_pago`, `monto`, `fecha`, 
														`num_factura`, `usuario`, `fecha_dig`) 
							VALUES ('".$cp_ncorr."','".$tipo_pago."','".$monto."','".$fecha."','".$num_factura."',
									'".$_SESSION['usuario']."','".date("Y-m-d H:i:s")."')";
					$res=mysql_query($sql,$link) or die(mysql_error());

					$sql3="SELECT sum(monto) as monto
					from factura_pagos
					where num_factura = '".$num_factura."'";
					$res3 = mysql_query($sql3,$link) or die(mysql_error());
					$registro3 = mysql_fetch_array($res3);
					$abono = $registro3['monto'];

					if (!($total-$abono>0)){
						$sql = "update factura
							set 	estado = 'PAGADO'
							where num_factura = '".$num_factura."'";
						$res=mysql_query($sql,$link) or die(mysql_error());
						$obs = "Accion : Abonado || Nro. : ".$id." || Fecha : ".$fecha;
						$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','ABONANDO','PAGADO','".$_SESSION['usuario']."')";
						$res=mysql_query($sql,$link) or die(mysql_error());

						}

					$id = mysql_insert_id();
					$obs = "Accion : PAGO || Nro. : ".$id." || Fecha : ".$fecha;
					$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','PROCESO_PAGO','".$_SESSION['usuario']."')";
					$res=mysql_query($sql,$link) or die(mysql_error());

					}
				$i++;
				}
			$arr_factura = explode(',',$_POST['facturas']);
			$num_factura = $arr_factura[0];
			header("Location:cobranza_cuentas_corrientes.php?num_factura=".$num_factura);
			}
		else{
			echo "<script>alert('Saldo es distinto a cero. ".$_POST['monto']." -- ".$_POST['total_pago']."')</script>";
			$arr_factura = explode(',',$_POST['facturas']);
			$num_factura = $arr_factura[0];
			header("Location:cobranza_cuentas_corrientes.php?num_factura=".$num_factura."&error=1&var=".$_POST['monto']."_".$_POST['total_pago']."'");
			}
		}
	if ($_POST['SI']=='Registrar Evento'){
		include("classes/conex.php");
		$link = Conectarse();

		$arr_factura = explode(',',$_POST['facturas']);
		for ($i=0; $i<count($arr_factura);$i++){
			$num_factura = $arr_factura[$i];
			
			if(isset($_POST['txt_evento']))$fecha_evento	= $_POST['txt_evento'];
			list($dia1,$mes1,$anio1) = explode('-', $fecha_evento);
			$fecha_evento 	= $anio1.'-'.$mes1.'-'.$dia1;
			if(isset($_POST['hora_evento']))$hora_evento	= $_POST['hora_evento'];
			$fecha_evento = $fecha_evento.' '.$hora_evento;
			if(isset($_POST['tipo_evento']))$tipo_evento		= $_POST['tipo_evento'];
			if(isset($_POST['detalle_evento']))$detalle_evento	= $_POST['detalle_evento'];
			if(isset($_POST['tipo_diagnostico']))$tipo_diagnostico	= $_POST['tipo_diagnostico'];
			if(isset($_POST['txt_compromiso']))$fecha_compromiso	= $_POST['txt_compromiso'];
			list($dia1,$mes1,$anio1) = explode('-', $fecha_compromiso);
			$fecha_compromiso 	= $anio1.'-'.$mes1.'-'.$dia1;
			if(isset($_POST['tipo_compromiso']))$tipo_compromiso	= $_POST['tipo_compromiso'];

			$sql = "INSERT INTO `factura_eventos` (num_factura, `fecha_evento`, `tipo_evento`, `detalle`, `tipo_diagnostico`, `fecha_diag`, `tipo_compromiso`) VALUES ('".$num_factura."','".$fecha_evento."','".$tipo_evento."','".$detalle_evento."','".$tipo_diagnostico."','".$fecha_compromiso ."','".$tipo_compromiso."')";
			$res=mysql_query($sql,$link) or die(mysql_error());
			$id = mysql_insert_id();
			$obs = "Accion : Evento || Nro. : ".$id." || Fecha : ".$fecha_evento;
			$sql = "INSERT INTO `factura_logs` (`num_factura`, `fecha_log`, `observacion`, `estado_anterior`, `estado_posterior`, `usuario`) VALUES ('".$num_factura."','".date("Y-m-d H:i:s")."','".$obs."','PROCESO_PAGO','PROCESO_PAGO','".$_SESSION['usuario']."')";
			$res=mysql_query($sql,$link) or die(mysql_error());

			}
		$arr_factura = explode(',',$_POST['facturas']);
		$num_factura = $arr_factura[0];
		header("Location:cobranza_cuentas_corrientes.php?num_factura=".$num_factura);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>Sistema de Arriendo y Facturación - Vigomaq</title>
	<meta name="description"/>
	<meta name="keywords" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />


<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="shortcut icon" href="http://vigomaq.sebter.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
<style type="text/css">
<!--
.Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
.Estilo19 {	color: #999999;
	font-weight: bold;
}
.Estilo20 {color: #000000}
.Estilo6 {	font-size: large;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo7 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #666666;
	font-weight: bold;
	font-style: italic;
}
.ui-datepicker-trigger{
	width:32px;
	height:32px;
	}
.ui-datepicker-trigger img{
	float:left;
	}
#warp{
	padding-left:10%;
	width:80%;
	}
.div-busqueda{
	background-color:#06327D;
	color:#FF0;
	font-weight:bold;
	}
.div-busqueda a{
	padding:5px;
	}	
#spinner{
	display:none;
	top:50%;
	padding-top:10%;
	left:50%;
	padding-left:45%;
	}
-->
</style>

</head>
	<div id="div-cabecera">
	<?php 
		include('classes/cabecera.php'); //modulo cabecera
	?>
    </div>
	<div id="div-menu">
		<?php 
			include('classes/menu.php'); //modulo menu
		?>
	</div>
    <br />
    <br />
    <br />
    <br />
    <div id="warp">
    	<H4>Cuentas Corrientes Clientes</H4>
    	<h5 align="right">Fecha Corte : <?php 
                			include("classes/conex.php");
							$link = Conectarse();
							$sql = "select date_format(fecha,'%d-%m-%Y') as fecha from cierres";
							$res=mysql_query($sql,$link) or die(mysql_error());
							$row = mysql_fetch_array($res);
							echo $row['fecha']; 
							?>
		</h5>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Cliente
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
                <input name="cliente" type="text" id="cliente" value="" size="50" class="floatLeft" />
                <input name="id_cliente" type="hidden" id="id_cliente" value="" size="10" maxlength="10"/>
                <input name="num_factura" type="hidden" id="num_factura" value="" size="10" maxlength="10" value="<?php echo $_GET['num_factura']; ?>"/>
            </div>
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Tipo CLiente
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		<input type="text" name="tipo_cliente" id="tipo_cliente" />
		<input type="button" name="ver_ficha" id="ver_ficha" onclick="ver_ficha()" value="Ver Ficha"/>
		 
            </div>
            
		<?php 
			if ($_GET['error']=='1')
				echo "<script>alert('Saldo es distinto a cero.')</script>";
		?>           
	    <br class="clearFloat"/>
<!--	    <div  class="floatLeft" style="width:10%;padding:5px;">
		Contacto
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		<input type="text" name="contacto" id="contacto" />
            </div>
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Email
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		<input type="text" name="email" id="email" />
            </div>
	    <br class="clearFloat"/>
	    <div  class="floatLeft" style="width:10%;padding:5px;">
		Fono
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		<input type="text" name="fono" id="fono" />
            </div>
            <div  class="floatLeft" style="width:10%;padding:5px;">
                Movil
            </div>
            <div class="floatLeft" style="width:35%;padding:5px;">
		<input type="text" name="movil" id="movil" />
            </div>
	    <br class="clearFloat"/>
	    <div  class="floatLeft" style="width:10%;padding:5px;">
		Condiciones de Envio de Factura
            </div>
            <div class="floatLeft" style="width:80%;padding:5px;">
		<input type="text" name="cond_envio" id="cond_envio" size="60"/>
            </div>
            <br class="clearFloat"/>
-->	    
        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
	<div id="div-resultado" style="overflow:auto; width: 100%; height: 350px">
                
    </div>
	<div id="div-resultado-2" style="overflow:auto; width: 100%; height: 350px; display:none">
                
    </div>
	<div id="div-resultado-3" style="overflow:auto; width: 100%; height: 350px; display:none">
                
    </div>
	<div id="div-resultado-4" style="overflow:auto; width: 100%; height: 350px; display:none">
                
    </div>
	<hr />
	<div class="div-busqueda" id="div-dialog" style="background-color:#06327D;"> 
		<form method="post" name="frmDatos" id="frmDatos" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
		<div  class="floatLeft" style="width:10%;padding:5px;display:none">
			Facturas
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;display:none">
			<input type="text" id="facturas" name="facturas" readonly/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Pago
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="tipo_pago" id="tipo_pago">
				<?php 
				$sql_familias="select *
						from tipo_pagos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['tp_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div class="floatLeft" style="width:100%;padding:5px;display:none" id="banco_div">
			<div class="floatLeft" style="width:15%;padding:5px;">
				Fecha Operacion
				<input type="text" name="fecha_cheque" id="fecha_cheque" />
			</div>
			<div class="floatLeft" style="width:25%;padding:5px;">
					Banco
					<select name="banco_cheque" id="banco_cheque">
						<?php 
						$sql_familias="select *
								from bancos";
						$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
						while ($row_familia = mysql_fetch_array($res_familia)){
							echo "<option value='".$row_familia['banco_ncorr']."'>".$row_familia['nombre']."</option>";
							}
						?>
					</select>
			</div>
			<div class="floatLeft" style="width:15%;padding:5px;">
				Cuenta Corriente				
				<input type="text" name="ctacte_cheque" id="ctacte_cheque"/>
			</div>
			<div class="floatLeft" style="width:15%;padding:5px;">
				Nro Operacion 
				<input type="text" name="nro_cheque" id="nro_cheque"/>
			</div>
			<div class="floatLeft" style="width:15%;padding:5px;">
				Valor				
				<input type="text" name="valor_cheque" id="valor_cheque"/>
			</div>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha 
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="fecha" id="fecha" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Monto
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" id="monto" name="monto" onchange="sumar();" />
		</div>       
		<div id="div-facturas" class="floatLeft" style="width:100%;padding:5px;">

		</div>
		<br style="clear:both"/>	
		<input class="imprimir" type="submit" value="Registrar Pago" id="SI" name="SI"/>
	</form>
	</div>
	<!--
	|<div class="div-busqueda_0" id="div-dialog_1" style="background-color:#06327D;"> 	
		<form method="post" name="frmDatos_1" id="frmDatos_1">
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Facturas
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" id="facturas" name="facturas" readonly/>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha - Hora Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_evento" id="txt_evento" type="text" size="10" maxlength="10" /> 
			<input name="hora_evento" id="hora_evento" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="tipo_evento" id="tipo_evento">
				<?php 
				/*
				include("classes/conex.php");
				$link=Conectarse();
				$sql_familias="select *
						from tipo_eventos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['te_ncorr']."'>".$row_familia['nombre']."</option>";
					}
					*/
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Detalle Evento
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<textarea id="detalle_evento" name="detalle_evento" cols="75" rows="5"></textarea>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Diagnostico
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="tipo_diagnostico" id="tipo_diagnostico">
				<?php 
				/*
				$sql_familias="select *
						from tipo_diagnosticos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['td_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Fecha Compromiso
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_compromiso" id="txt_compromiso" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Tipo Compromiso
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<select name="tipo_compromiso" id="tipo_compromiso">
				<?php 
				$sql_familias="select *
						from tipo_compromisos";
				$res_familia = mysql_query($sql_familias,$link) or die(mysql_error());
				while ($row_familia = mysql_fetch_array($res_familia)){
					echo "<option value='".$row_familia['tc_ncorr']."'>".$row_familia['nombre']."</option>";
					}
				?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<!-- <input class="imprimir" type="submit" value="Registrar Evento" id="SI" name="SI"/>-->
		</form>
	</div><?php */?>
	-->
	<a href="#" id="asignar-vendedor" name="asignar-vendedor">Registrar Pago</a>
	<a href="#" id="registrar_evento" name="registrar_evento" class="link_registro_eventos">Registrar Evento</a>
	<a href="#" id="registrar_evento_bitacora" name="registrar_evento_bitacora" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only link_bitacora" role="button" style="padding: .4em 1em;" >Bitacora de Cobranza</a>
	<a href="#" id="exportar-excel" >Exportar TODO</a>
	<a href="#" id="exportar-excel-rojo" >Exportar IMPAGAS</a>
	<?php if ($_GET['volver']=='SI'){
		$sql_ins = "insert into factura_revision_log (cod_cliente,fecha_revision)
					values ('".$_GET["id_cliente"]."','".date("Y-m-d H:i:s")."')";
		$res_ins = mysql_query($sql_ins,$link) or die(mysql_error());
		?>
			<a class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" href="cobranza_prioridad_facturas.php?id_cliente=<?php if(isset($_GET["id_cliente"])) echo $_GET["id_cliente"]; ?>" id='volver' name="volver"><span class="ui-button-text">Volver</span></a>
	<?php }?>   
	</div>
	<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>

	<style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
	<script src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="js/i18n/jquery.ui.datepicker-es.js"></script>
    <script>
    	$(window).load(function(){
    		var num_factura = '<?php if(isset($_GET["num_factura"])) echo $_GET["num_factura"]; ?>';
    		if (num_factura!=''){
	    		$.ajax({
					url: 'classes/cobranza_cuentas_corrientes/buscar_facturas.php?num_factura='+num_factura,
					success: function(data){
						$("#div-resultado").html(data);
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_simpl.php?num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-3").html(data);
								}
							});
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_2.php?num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-2").html(data);
								}
							});
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_simpl_2.php?num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-4").html(data);
								}
							});
						$("#spinner").hide();
						}
					});
    			}
    		else{
    			var id_cliente = '<?php if(isset($_GET["id_cliente"])) echo $_GET["id_cliente"]; ?>';
    			document.getElementById("id_cliente").value = id_cliente;
    			if (id_cliente!=''){
					$.ajax({
						url: 'classes/cobranza_cuentas_corrientes/buscar_facturas.php?id_cliente='+id_cliente,
						success: function(data){
							$("#div-resultado").html(data);
							$.ajax({
								url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_simpl.php?id_cliente='+id_cliente,
								success: function(data){
									$("#div-resultado-3").html(data);
									}
								});
							$.ajax({
								url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_2.php?id_cliente='+id_cliente,
								success: function(data){
									$("#div-resultado-2").html(data);
									}
								});
							$.ajax({
								url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_simpl_2.php?id_cliente='+id_cliente,
								success: function(data){
									$("#div-resultado-4").html(data);
									}
								});
							$("#spinner").hide();
							}
						});
					}
    			}
    		});
    	$(document).ready(function() {
    		$("#tipo_pago").change(function(){
    			var id = $(this).val();
    			if ((id!=1)){
    				$("#banco_div").show();
    				}
    			else{
					$("#banco_div").hide();
    				}
    			});
		$( "#fecha, #fecha_cheque" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$(".buscar").click(function(){
			var id_cliente = $("#id_cliente").attr('value');
			$.ajax({
				url: 'classes/cobranza_cuentas_corrientes/buscar_facturas.php?id_cliente='+id_cliente,
				success: function(data){
					$("#div-resultado").html(data);
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_2.php?id_cliente='+rut+'&num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-2").html(data);
								}
							});
					}
				});
			});
		$("#cliente").autocomplete({
			source: "classes/cobranza_cuentas_corrientes/buscar_cliente.php",
			select: function(event, ui){
				var rut = ui.item.id;
				var num_factura = $("#num_factura").val();
				var tipo_cliente = ui.item.tipo_cliente;
				/*var resp = ui.item.resp;
				var email_resp = ui.item.email_resp;
				var fono_resp = ui.item.fono_resp;
				var movil_resp = ui.item.movil_resp;
				var cond_envio = ui.item.cond_envio;*/
				document.getElementById('id_cliente').value = rut;
				document.getElementById('tipo_cliente').value = tipo_cliente;
				/*document.getElementById('contacto').value = resp;
				document.getElementById('email').value = email_resp;
				document.getElementById('fono').value = fono_resp;
				document.getElementById('movil').value = movil_resp;
				document.getElementById('cond_envio').value = cond_envio;*/
				document.getElementById("facturas").value = '';
    			$.ajax({
					url: 'classes/cobranza_cuentas_corrientes/buscar_facturas.php?id_cliente='+rut+'&num_factura='+num_factura,
					success: function(data){
						$("#div-resultado").html(data);
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_simpl.php?id_cliente='+rut+'&num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-3").html(data);
								}
							});
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_2.php?id_cliente='+rut+'&num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-2").html(data);
								}
							});
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/buscar_facturas_simpl_2.php?id_cliente='+rut+'&num_factura='+num_factura,
							success: function(data){
								$("#div-resultado-4").html(data);
								}
							});
						}
					});
				}
			});
		$( "#div-dialog" ).dialog({
				autoOpen: false,
				height: 800,
				width: 1200,
				modal: true,
		        close: function() {
					var facturas = $("#facturas").val();	
					var arr_facturas = facturas.split(',');
					for (var i = 0; i<arr_facturas.length; i++){
	        			document.getElementById("factura_".arr_facturas[i]).checked = false;
						}			
        			document.getElementById("facturas").value = '';
      				}
			});
		$( "#div-dialog_1" ).dialog({
				autoOpen: false,
				height: 800,
				width: 1200,
				modal: true
			});
		$( "#asignar-vendedor" ).button().click(function() {
				$( "#div-dialog" ).dialog( "open" );
				var facturas = $("#facturas").val();
				$.ajax({
					url: 'classes/cobranza_cuentas_corrientes/generar_facturas.php?facturas='+facturas,
					success: function(data){
						$("#div-facturas").html(data);
						$.ajax({
							url: 'classes/cobranza_cuentas_corrientes/generar_montos_facturas.php?facturas='+facturas,
							success: function(data){
								$("#monto").val(data);
								$.ajax({
									url: 'classes/cobranza_cuentas_corrientes/generar_nros_facturas.php?facturas='+facturas,
									success: function(data){
										$("#facturas").val(data);
										}
									});
								}
							});
						
						}
					});
				
			});
		$( "#registrar_evento" ).button().click(function() {
				$( "#div-dialog_1" ).dialog( "open" );
			});
		$( "#exportar-excel" ).button().click(function() {
			var test = $('#div-resultado-3');
			window.open('data:application/vnd.ms-excel,' + 
				    encodeURIComponent(test[0].outerHTML));
			});
		$( "#exportar-excel-rojo" ).button().click(function() {
			var test = $('#div-resultado-4');
			window.open('data:application/vnd.ms-excel,' + 
				    encodeURIComponent(test[0].outerHTML));
			});
		$('.link_resumen').live('click', function() {
			var id = $(this).attr('id');
			showPopWin('classes/cobranza_gestion_cobranza/ver_logs.php?num_factura='+id, 'Historial Factura N° '+id, 1200, 600, null);
			});
		$('.link_bitacora').live('click', function() {
			var id = document.getElementById('id_cliente').value;
			showPopWin('classes/cobranza_cuentas_corrientes/bitacoras.php?num_factura='+id, 'Bitacoras de Cobranza', 1200, 600, null);
			});
		$('.link_registro_eventos').live('click', function() {
			var id = $("#facturas").val();
			showPopWin('classes/cobranza_cuentas_corrientes/registro_eventos.php?facturas='+id, 'Registrar Evento', 1200, 600, null);
			});
		$('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
		});
	function ver_ficha(){
		var id = document.getElementById('id_cliente').value;
		showPopWin('cliente.php?txt_rut='+id, 'Cliente N° '+id, 1200, 600, null);
		}

	function seleccionar(factura){
		if (document.getElementById(factura).checked == true){
		    factura = document.getElementById(factura).value;
		    if (document.getElementById("facturas").value!='') 
			document.getElementById("facturas").value = document.getElementById("facturas").value +','+factura;
		    else
			document.getElementById("facturas").value = factura;
		}
		else{
			var arr  = document.getElementById("facturas").value.split(",");
			var posBorrar = 0;
			for (var i = 0; i<arr.length; i++){
				var temp = factura;
				var factura_frase = temp.split('_');
				//alert(arr[i]+'  -  '+factura_frase[1]+'  -  '+factura);
				if (factura_frase[1]==arr[i]){
					posBorrar  = i;
					i = arr.length;
					}
				}
			//alert(posBorrar);
			arr.splice(posBorrar, 1);
			document.getElementById("facturas").value = arr.join(",");
		}
	}

    </script>
	<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
	<script type="text/javascript" src="submodal/common.js"></script>
	<script type="text/javascript" src="submodal/subModal.js"></script>

	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
	<script type="text/javascript">
        function sumar(){
			subtotales=document.getElementsByClassName('sumar_facturas');
			var sumatoria= 0;
			for (var i = 0; i < subtotales.length; i++) {
				sumatoria += parseInt(subtotales[i].value);
				}
			document.getElementById('total_pago').value = sumatoria;
			var monto = document.getElementById('monto').value;
			var saldo = monto - sumatoria;
			document.getElementById('saldo_pago').value = saldo;
			}
    </script>
</body>
</html>

<?php 
ob_start(); 
session_start(); 
if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
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
<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
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
    	<H4>Distribución de Facturas</H4>
        <div class="div-busqueda">
            <div  class="floatLeft" style="width:10%;padding:5px;">
		    Cliente
            </div>
            <div  class="floatLeft" style="width:50%;padding:5px;">
	 	<input name="cliente" type="text" id="cliente" value="" size="75"/>
                <input name="id_cliente" type="hidden" id="id_cliente" value="" size="10" maxlength="10"/>
            </div>
            <br class="clearFloat"/>
            <div  class="floatLeft" style="width:10%;padding:5px;">
		    Por vencer
            </div>
            <div  class="floatLeft" style="width:80%;padding:5px;">
		<input name="cant_dias"  class="floatLeft" type="text" id="cant_dias" size="3" maxlength="3" />
	    	<a href="#" class="buscar floatLeft"><img src="images/ver.png" title="Buscar"/></a>
            </div>
            <br class="clearFloat"/>
        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
	<div id="div-resultado" style="overflow:auto; width: 100%; height: 300px">
        
    </div>
	<hr />
	<div class="div-busqueda" id="div-dialog" style="background-color:#06327D;"> 
		<form method="post" name="frmDatos" id="frmDatos">
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Facturas
		</div>
		<div  class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" name="facturas" id="facturas" readonly="readonly" size="50"/>
		</div>
		<br style="clear:both"/>	
		<div  class="floatLeft" style="width:10%;padding:5px;">
			Quien recibe
		</div>       
		<div  class="floatLeft" style="width:50%;padding:5px;">
					<select name="vendedor" id="vendedor">
				<?php 
				include("classes/conex.php");
				$link = Conectarse();
				$sql = "SELECT * FROM personal	";
				$res=mysql_query($sql,$link) or die(mysql_error());
				while($registro=mysql_fetch_array($res)){ ?>
				<option value="<?php echo $registro['cod_personal']?>"><?php echo $registro['nombres_personal'].' '.$registro['ap_patpersonal'].' '.$registro['ap_patpersonal'] ?></option>

				<?php } ?>
			</select>
		</div>       
		<br style="clear:both"/>	
		<div class="floatLeft" style="width:10%;padding:5px;">
			Fecha Entrega
		</div>       
		<div class="floatLeft" style="width:50%;padding:5px;">
			<input name="txt_hasta" id="txt_hasta" type="text" size="10" maxlength="10" /> 
		</div>       
		<br style="clear:both"/>	
		<div class="floatLeft" style="width:10%;padding:5px;">
			Hora Entrega
		</div>       
		<div class="floatLeft" style="width:50%;padding:5px;">
			<input type="text" name="hora_entrega" id="hora_entrega"/>
		</div>       
		<br style="clear:both"/>	
		<div class="floatLeft" style="width:10%;padding:5px;">
			Quien entrega
		</div>       
		<div class="floatLeft" style="width:50%;padding:10px;">
			<input type="text" name="quien_entrega" id="quien_entrega" size="50"/>
		</div>       
		<br style="clear:both"/>	
		</form>
	</div>
	<a href="#" id="asignar-vendedor" name="asignar-vendedor">Asignar Vendedor</a>
	
   </div>
	<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
	<script type="text/javascript" src="jscalendar-1.0/lang/calendar-en.js"></script>

	<style type="text/css"> @import url("jscalendar-1.0/calendar-win2k-cold-1.css"); </style>
	<script src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="js/i18n/jquery.ui.datepicker-es.js"></script>

    <script>
    	$(document).ready(function() {
		$( "#txt_hasta" ).datepicker({
			dateFormat : "dd-mm-yy"
			});
		$(".buscar").click(function(){
			var id_cliente = $("#id_cliente").attr('value');
			var cant_dias = $("#cant_dias").attr('value');
			$.ajax({
				url: 'classes/cobranza_distr_facturas/buscar_facturas.php?id_cliente='+id_cliente+'&cant_dias='+cant_dias,
				success: function(data){
					$("#div-resultado").html(data);
					}
				});
			});
		$("#cliente").autocomplete({
			source: "classes/cobranza_cuentas_corrientes/buscar_cliente.php",
			select: function(event, ui){
				var rut = ui.item.id;
				document.getElementById('id_cliente').value = rut;
				}
			});
		$( "#div-dialog" ).dialog({
				autoOpen: false,
				height: 320,
				width: 550,
				modal: true,
				buttons: {
				"Asignar Vendedor": function() {
					var quien_entrega = document.getElementById('quien_entrega').value;
					var vendedor = document.getElementById('vendedor').value;
					var txt_hasta = document.getElementById('txt_hasta').value;
					var hora_entrega = document.getElementById('hora_entrega').value;
					var facturas = document.getElementById('facturas').value;
					$.ajax({
						url: 'classes/cobranza_distr_facturas/asignar_vendedor.php?quien_entrega='+quien_entrega+'&vendedor='+vendedor+'&txt_hasta='+txt_hasta+'&hora_entrega='+hora_entrega+'&facturas='+facturas,
						success : function(data){
							var id = data;
							showPopWin("classes/cobranza_distr_facturas/comprobante_gi.php?id="+
id, "Comprobante Guia Interna", 1200, 600, null);
							}
		
						});
					$( this ).dialog( "close" );
					},
				"Cerrar": function() {
					$( this ).dialog( "close" );
					}
				}
			});
		$( "#asignar-vendedor" ).button().click(function() {
				$( "#div-dialog" ).dialog( "open" );
			});
		$('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
		});
		function cambiar(){
			var todos = document.getElementById('seleccion').checked;
			var elementos = document.getElementsByName('facturar[]');
			var x=0;
			document.getElementById('facturas').value = '0';
			for (x=0 ; x < document.getElementsByName('facturar[]').length ; x++){
				if (todos==true){
					elementos[x].checked=true;
					}
				else{
					elementos[x].checked=false;
					}
				}
			var facturar = document.getElementsByName('facturar[]');
			for (y=0 ; y < document.getElementsByName('facturar[]').length ; y++){
				var monto = montos[y].value;
				if (todos==true){
					document.getElementById('facturas').value = parseInt(document.getElementById('facturas').value) + parseInt(monto);
					}
				else{
					document.getElementById('facturas').value = '0';
					}
				}
			}
	function seleccionar(factura){
		if (document.getElementById(factura).checked == true){
		    if (document.getElementById("facturas").value!='') 
			document.getElementById("facturas").value = document.getElementById("facturas").value +','+factura;
		    else
			document.getElementById("facturas").value = factura;
		}
		else{
			var arr  = document.getElementById("facturas").value.split(",");
			var posBorrar = 0;
			for (var i = 0; i<arr.length; i++){
				if (arr[i]==factura){
					posBorrar  = i;
					i = arr.length;
					}
				}			
			arr.splice(posBorrar, 1);
			document.getElementById("facturas").value = arr.join(",");
		}
	}

    </script>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">

        var menu=new menu.dd("menu");
        menu.init("menu","menuhover");
    </script>
</body>
</html>

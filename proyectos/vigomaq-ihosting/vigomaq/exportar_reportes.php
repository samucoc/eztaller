<?php ob_start(); 
session_start(); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false; 

if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Exportar Reportes</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="script.js"></script>
<style type="text/css">
<!--
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
	padding-left:2%;
	width:95%;
	}
#div-busqueda{
	background-color:#06327D;
	color:#FF0;
	font-weight:bold;
	}
#div-busqueda a{
	padding:10px;
	}	
.margen-10{
	margin-left:60px;
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
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
</head>
<body>
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
	<form action="classes/exportar_reportes/generar-excel/generador.php" method="post" >
    <div id="warp">
    	<H3>Exportar Reportes</H3>
        <div id="div-busqueda">
            <div  class="floatLeft texto_fecha">
                Desde
            </div>
            <div class="floatLeft control_fecha">
                <input name="fecha_inicio" type="text" id="fecha_inicio" value="" size="10" maxlength="10"/>
	        </div>	
            <div class="floatLeft texto_fecha">
                Hasta
            </div>
            <div class="floatLeft control_fecha">
                <input name="fecha_fin" type="text" id="fecha_fin" size="10" maxlength="10" />
    	    </div>
            <div class="floatLeft texto_fecha">
            	Tipo Reporte
            </div>
            <div class="floatLeft control_fecha">
            	<select name="tipo-reporte" id="tipo-reporte">
                	<option value="1">Guías de Arriendo</option>
                	<option value="6">Guías de Ventas</option>
                	<option value="2">Guías de Cambio</option>
                	<option value="8">Guías Nulas</option>
                	<option value="3">Guías v/s Facturas</option>
                	<option value="4">Facturas de Arriendo</option>
                	<option value="7">Facturas de Ventas</option>
                	<option value="9">Facturas Nulas</option>
                	<option value="5">Cliente - Obras</option>
                	<option value="10">Notas de Credito</option>
                </select>
            </div>
           <div class="floatLeft" style="margin-left:40px">
           	<a href="#" class="buscar floatLeft"><img src="images/ver.png" title="Buscar"/></a>
           </div>
           <div class="floatLeft">
           	<input type="submit" id="generar-excel" name="generar-excel" title="Generar Excel" style="background-image: url('images/page_excel.png'); width:16px; height:16px; padding-top:5px; margin-top:10px;" />
           </div>
           <br class="clearFloat"/>
        </div>
        <div id="spinner">
			<img src="images/loading.gif" alt="Loading" />
        </div>
        <style>
		#warp_1{
			width:100%;
			font-size:8px;
			}
		.floatLeft{
			float:left;
			
			width:100px;
			}
		.floatRight{
			float:right;
			}
		.clearFloat{
			clear:both;
			}
		</style>
        <div id="div-resultado">
        
        </div>
    </div>
    <input type="hidden" name="resultado" id="resultado"/>
    </form>
    <script src="js/jquery-1.6.2.min.js"></script>
    <script src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="js/i18n/jquery.ui.datepicker-es.js"></script>
    <script>
		$(document).ready(function() {
			var dates = $( "#fecha_inicio, #fecha_fin" ).datepicker({
				firstDay: 1,
				onSelect: function( selectedDate ) {
					var option = this.id == "fecha_inicio" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
					dates.not( this ).datepicker( "option", option, date );
				}
			});
			$( "#fecha_inicio, #fecha_fin" ).datepicker( "option",
					$.datepicker.regional[ "es" ] );
			$( "#fecha_inicio, #fecha_fin" ).datepicker( "setDate" , <?php echo date("m/d/Y");?> );
			$( "#fecha_inicio, #fecha_fin" ).datepicker( "option",	"dateFormat" , "dd-mm-yy"  );
			$("#tipo-reporte").click(function(){
				$("#div-resultado").html("");
				$("#div-resultado").hide();
				});
			$(".buscar").click(function(){
				$("#div-resultado").html("");
				$("#div-resultado").hide();
				var inicio = $("#fecha_inicio").attr('value');
				var fin = $("#fecha_fin").attr('value');
				var tipo =  $("#tipo-reporte").find(':selected').val();
				switch (tipo){
					case '1':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_1.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '2':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_2.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '3':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_3.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '4':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_4.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '5':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_clientes-obras.php',
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '6':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_ventas.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '7':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reporte_facturas_ventas.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '8':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reportes_gd_nulas.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '9':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reportes_fact_nulas.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					case '10':
						$.ajax({
							url: 'classes/exportar_reportes/generar_reportes_notas_credito.php?inicio='+inicio+'&fin='+fin,
							success: function(data){
								$("#div-resultado").html(data);
								$("#div-resultado").show();
								}
							});
						break;
					default:
						break;
					}
				});
			 $('#spinner').bind("ajaxSend", function() {
					$(this).show();
				}).bind("ajaxComplete", function() {
					$(this).hide();
				});
			$("#generar-excel").click(function(){
				$("#resultado").val( $("<div>").append( $("#div-resultado").eq(0).clone() ).html() );
				});
			});
    </script>
    <script type="text/javascript">
		var menu=new menu.dd("menu");
		menu.init("menu","menuhover");
	</script>
</body>

</html>
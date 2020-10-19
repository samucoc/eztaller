<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
			<script type="text/javascript" src="../includes_js/jquery-1.8.3.js"></script>
			<script type="text/javascript" src="../includes_js/jquery-ui-1.9.2.custom.js"></script>
			
			<script src="../includes_js/owl.carousel.js"></script>
			
			
		<!-- estilos -->
			<link href="../estilos/owl.carousel.css" rel="stylesheet">
   		    <link href="../estilos/owl.theme.css" rel="stylesheet">
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
     	
     	<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
      	<script type="text/javascript" src="submodal/common.js"></script>
      	<script type="text/javascript" src="submodal/subModal.js"></script>
 		
		<link href='../estilos/fullcalendar.css' rel='stylesheet' />
		<link href='../estilos/smoothness/jquery-ui-1.9.2.custom.css' rel='stylesheet' />
		<link href='../estilos/fullcalendar.print.css' rel='stylesheet' media='print' />
		<link rel="stylesheet" href="../../backup/pdfs/prettyLoader_compressed_1.0.1/prettyLoader/css/prettyLoader.css" type="text/css" media="screen" charset="utf-8" />
		<script src='../includes_js/moment.min.js'></script>
		<script src='../includes_js/fullcalendar.min.js'></script>
		<script src='../includes_js/lang-all.js'></script>
		<script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
		<script src="../../backup/pdfs/prettyLoader_compressed_1.0.1/prettyLoader//js/jquery.prettyLoader.js" type="text/javascript" charset="utf-8"></script>
		{literal}
		<script type="text/javascript">
			$(function($) { 
				$('#inicio_f, #fin_f').mask("99/99/9999");
				}
			); 		
		</script>		
		
			<script type="text/javascript">
				
			
				function cambiar (id, img) {

					document.images[id].src = img;

				}
				function reloj () {

					xajax_CargaPagina(xajax.getFormValues('Form1'));

				}
				function ImprimeDiv(id)
				{
				    // save current calendar width
					    w = $('#calendar').css('width');

					    // prepare calendar for printing
					    $('#calendar').css('width', '6.5in');
					    $('.fc-header').hide();  
					    $('#calendar').fullCalendar('render');

					    window.print();

					    // return calendar to original, delay so the print processes the correct width
					    window.setTimeout(function() {
					        $('.fc-header').show();
					        $('#calendar').css('width', w);
					        $('#calendar').fullCalendar('render');
					    }, 1000);
					
						
				}
			   


			</script>
			<style>
			    #divcontenedor .item{
			    display: block;
			    width: 100%;
			    height: auto;
			    }
			    .customNavigation{
					text-align: center;
					}
				//use styles below to disable ugly selection
				.customNavigation a{
					-webkit-user-select: none;
					-khtml-user-select: none;
					-moz-user-select: none;
					-ms-user-select: none;
					user-select: none;
					-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
				}
				.floatLeft{
					float:left;
					}
				.clearBoth{
					clear:Both;
					}
				.control{
					width:20%;
					}
				.texto{
					width:70%;
					}
				.btn {
					background: none repeat scroll 0 0 #869791;
				    border-radius: 30px;
				    color: #fff;
				    display: inline-block;
				    font-size: 12px;
				    margin: 5px;
				    opacity: 0.5;
				    padding: 3px 10px;
				
					}
			</style>
		{/literal}
	
	</HEAD>
	<body onload="xajax_Historial(xajax.getFormValues('Form1'));"style="background:#ffffff;">
				
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor"  class="owl-carousel owl-theme" align="left" >
			
				<div class="item">
				<table align='center' class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 94%; float: center; border: 3pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td align='center'>
							<table align='center' border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%; float: left;">
								<tr> 
									<td colspan="4" class="tabla-alycar-fila-informa-requerida-contrato">
									Intranet Comercial YONLEY
									</td> 
								</tr>
								<tr>
									<td onmouseover="this.style.background='#FFFF88'; cambiar('sist1', '../images/Cash-register-48.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema de Ventas');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist1', '../images/Cash-register-48.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="width: 25%" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '1');">
										<br>
										<img border='0' onMouseOver="cambiar('sist1', '../images/Cash-register-48.png');" onMouseOut="cambiar('sist1', '../images/Cash-register-48.png');" src="../images/Cash-register-48.png" name="sist1">
										<br><br>
										Sistema de Ventas
										<br><br>
									</td>
									<td onmouseover="this.style.background='#FFFF88'; cambiar('sist3', '../images/Bank-48.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema Tesoreria');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist3', '../images/Bank-48.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="width: 25%" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '3');">
										<br>
										<img onMouseOver="cambiar('sist3', '../images/Bank-48.png');" onMouseOut="cambiar('sist3', '../images/Bank-48.png');" src="../images/Bank-48.png" name="sist3">
										<br><br>
										Sistema Tesoreria
										<br><br>
									</td>
								<tr> 
									<td onmouseover="this.style.background='#FFFF88'; cambiar('sist12', '../images/deptocompras.jpg'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema de Compras');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist12', '../images/deptocompras.jpg'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '12');">
										<br>
										<img border='0' onMouseOver="cambiar('sist12', '../images/deptocompras.jpg');" onMouseOut="cambiar('sist12', '../images/deptocompras.jpg');" src="../images/deptocompras.jpg" name="sist12" width="48">
										<br><br>
										Sistema Compras<br><br>
									</td>
									<td onmouseover="this.style.background='#FFFF88'; cambiar('sist13', '../images/montacargas05.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema de Bodega');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist13', '../images/montacargas05.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '13');">
										<br>
										<img onMouseOver="cambiar('sist13', '../images/montacargas05.png');" onMouseOut="cambiar('sist13', '../images/montacargas05.png');" src="../images/montacargas05.png" name="sist13" width="48" height="48">
										<br><br>
										Sistema Bodega<br>
										<br>
									</td> 
									<td onmouseover="this.style.background='#FFFF88'; cambiar('sist10', '../images/Plus.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema Gerencia');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist10', '../images/Plus.png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '10');">
										<br>
										<img onMouseOver="cambiar('sist10', '../images/Plus.png');" onMouseOut="cambiar('sist10', '../images/Plus.png');" src="../images/Plus.png" name="sist10" width="48" height="48"/>
										<br><br>
										Sistema Gerencia
										<br><br>
									</td> 
								</tr>
								<tr> 
									<td colspan="1" onmouseover="this.style.background='#FFFF88'; cambiar('sist14', '../images/rrhh (1).png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema Recursos Humanos');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist14', '../images/rrhh (1).png'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '14');">
<br>
										<img onMouseOver="cambiar('sist14', '../images/rrhh (1).png');" onMouseOut="cambiar('sist14', '../images/rrhh (1).png');" src="../images/rrhh (1).png" name="sist14" width="48">
										<br><br>
										Sistema Recursos Humanos
										<br><br>
									</td>  
									<td colspan="1" onmouseover="this.style.background='#FFFF88'; cambiar('sist18', '../images/semaforo.jpg'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema Cuentas Criticas');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist18', '../images/semaforo.jpg'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '18');">
<br>
										<img onMouseOver="cambiar('sist18', '../images/semaforo.jpg');" onMouseOut="cambiar('sist18', '../images/semaforo.jpg');" src="../images/semaforo.jpg" name="sist18" width="48">
										<br><br>
										Sistema Cuentas Criticas
										<br><br>
									</td>  
									<td onmouseover="this.style.background='#FFFF88'; cambiar('sist15', '../images/03imagen copia.jpg'); xajax_Acceso(xajax.getFormValues('Form1'), 'Sistema Documental');" onmouseout="this.style.background='#F2F2F2'; cambiar('sist15', '../images/03imagen copia.jpg'); xajax_Acceso(xajax.getFormValues('Form1'), 'Seleccione un Acceso');" 
										align='center' class="tabla-alycar-label" style="" onclick="xajax_Ingresa(xajax.getFormValues('Form1'), '15');">
<br>
										<img onMouseOver="cambiar('sist15', '../images/03imagen copia.jpg');" onMouseOut="cambiar('sist15', '../images/03imagen copia.jpg');" src="../images/03imagen copia.jpg" name="sist15" width="48">
										<br><br>
										Sistema Documental 
										<br><br>
									</td>  
								</tr>
								<tr> 
									<td colspan="4" class="tabla-alycar-fila-informa-requerida-contrato">
									<div id='divacceso'>Seleccione un Acceso</div>
									</td> 
								</tr>
							
							</table>
						</td>
					</tr>
				</table>
				</div>
			</div>
		</form>
	</body>
</HTML>
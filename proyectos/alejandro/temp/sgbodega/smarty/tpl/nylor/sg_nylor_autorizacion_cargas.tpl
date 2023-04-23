<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Autorización de Cargas </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		{literal}
		<script type="text/javascript">
			$(function($) { 
				$('#OBLI-txtFechaInicio').mask("99/99/9999");
				$('#OBLI-txtFechaTermino').mask("99/99/9999");
				}
			); 		
		</script>
		
		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements['v_pivot_excel'].value=document.getElementById('pivot').innerHTML;
			document.getElementById(nombreformulario).target = 'iframe_pivot_excel'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById('pivot').innerHTML="";document.getElementById('pivot_filter').innerHTML="";document.getElementById('div_grafico').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
			
		</script> 
		{/literal}
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Autorización de Cargas</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Vendedor:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtCodVendedor" name="txtCodVendedor" value='{$COD_VENDEDOR}' onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'sgbodega.vendedores', 'VE_CODIGO', 'VE_VENDEDOR', 'txtCodVendedor', 'txtDescVendedor', '');" maxLength="10" size="10">
										<INPUT type="text" id="txtDescVendedor" name="txtDescVendedor" value='{$VENDEDOR}' maxLength="100" size="50" readonly>
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=21&obj1=txtCodVendedor&obj2=txtDescVendedor', 'Busca Vendedor', 550, 350, null);"></a>
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Rango de Fecha:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										
										<INPUT type="text" id="OBLI-txtFechaInicio" name="OBLI-txtFechaInicio" value='{$DESDE}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario1' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
										&nbsp;
										al
										&nbsp;
										<INPUT type="text" id="OBLI-txtFechaTermino" name="OBLI-txtFechaTermino" value='{$HASTA}' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10" size="10">
										<a href="#" style="cursor: hand;"><img  id='cmdCalendario2' src="../images/calendario.png" border=0 title="Click para ver calendario"></a>
									
										&nbsp;
										<label class="comentario">Filtro por Fecha de Emisión de Ventas</label>
									
									</td>
								</tr>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnBuscar" value="Buscar" class="boton" onClick="xajax_CargaListado(xajax.getFormValues('Form1'));"> 
									</td>
								</tr>
								
								<div align="left" style="display: none;">
									<input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
									<!--<input type='button' value='Excel' onclick="enviaPivotExcel('form1');" />!-->
									<iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
								</div>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
				
			</div>
		</form>
		<div id="calendar-container"></div>
	
		{literal}
		<!-- calendario 3-->
		<script type="text/javascript">
			Calendar.setup({inputField : "OBLI-txtFechaInicio",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario1",step: 1});
			Calendar.setup({inputField : "OBLI-txtFechaTermino",ifFormat : "%d/%m/%Y",showstime: true,button : "cmdCalendario2",step: 1});
		</script>
		{/literal}
	</body>
</HTML>
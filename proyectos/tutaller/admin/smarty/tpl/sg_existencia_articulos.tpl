<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Art�culos </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput-1.2.2.js"></script>
		
		{literal}
		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresi�n.");
				  
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
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Repuestos</td>
								</tr>
								<tr align="left">
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Codigo Interno:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtNcorr" name="txtNcorr" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="13" size="13" readonly>
											<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=articulo&obj1=txtNcorr&obj2=OBLI-txtDescripcion', 'Busca Art�culo', 550, 350, null);"></a>
										</td>
									</TR>
								</TR>
								<tr align="left">
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Codigo Asignado:</td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="txtCodArticulo" name="txtCodArticulo" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="13" size="13" readonly>
											<label class="comentario">El codigo se asignara automaticamente.</label>
										</td>
									</TR>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Marca:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<SELECT id="OBLI-cboMarca" name="OBLI-cboMarca" onKeyPress="return Tabula(this, event, 0)"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%">Descripcion:<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<INPUT type="text" id="OBLI-txtDescripcion" name="OBLI-txtDescripcion" onKeyPress="return Tabula(this, event, 0)" value='' maxLength="100" size="80">
										</td>
									</TR>
								</TR>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();"> 
										<input type="button" id="btnNuevo" name="btnNuevo" value="Nuevo" class="boton" onclick="xajax_Nueva(xajax.getFormValues('Form1'));">
									</td>
								</tr>
								
								<div align="left" style="display: none;">
									<input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
									<!--<input type='button' value='Excel' onclick="enviaPivotExcel('form1');" />!-->
									<iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
								</div>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
				
			</div>
		</form>
	</body>
</HTML>
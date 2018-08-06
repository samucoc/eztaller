<?php /* Smarty version 2.6.18, created on 2013-01-21 17:18:27
         compiled from sg_informe_movimientos_mensuales.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title> Toma Inventario </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<?php echo '

		<script type="text/javascript" > 
			function ImprimeDiv(id)
			{
                                var c, tmp;

                           c = document.getElementById(id);

                           tmp = window.open(" ","Impresión.");

                           tmp.document.open();
                           tmp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
                           tmp.document.write(c.innerHTML);
                           tmp.document.close();
                           tmp.print();
                           tmp.close();
			}
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements[\'v_pivot_excel\'].value=document.getElementById(\'pivot\').innerHTML;
			document.getElementById(nombreformulario).target = \'iframe_pivot_excel\'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
                         function enviaBuscar(nombreformulario)
                                {
                                document.getElementById(\'pivot\').innerHTML="";document.getElementById(\'pivot_filter\').innerHTML="";document.getElementById(\'div_grafico\').innerHTML="";
                                document.getElementById(nombreformulario).target =""; 
                                document.getElementById(nombreformulario).method="";
                                document.getElementById(nombreformulario).action="";
                                document.getElementById(nombreformulario).submit();
                                }
                        horas=0; minutos=0; segundos=0;
                        puntos=true;
                        function Tiempo() {
                            if(puntos) ++segundos;
                            if(segundos==60) { segundos=0; ++minutos }
                            if(minutos==60) { minutos=0; ++horas }
                            if(horas==24) horas=0;
                            cad="";
                            if(horas<10) cad+="0";
                            cad+=horas;
                            if(puntos) cad+=":"; else cad+=" ";
                            if(minutos<10) cad+="0";
                            cad=cad+minutos;
                            if(puntos) cad+=":"; else cad+=" ";
                            if(segundos<10) cad+="0";
                            cad=cad+segundos;
                            puntos=!puntos;
                            document.getElementById("crono").value=cad;
                            }
                        var id;
                        function sigue() { document.getElementById("crono").value="";horas=0; minutos=0; segundos=0; id=setInterval("Tiempo()",500) }
                        function para() { clearInterval(id);  }
		</script> 
		'; ?>

	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			
			<div id="divcontenedor" align="left" style="display: block; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr> 
									<td colspan="2" class="tabla-alycar-fila-informa-requerida-contrato">Informe Movimientos Mensuales</td>
								</tr>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Producto:</td>
								
									<td class="tabla-alycar-texto" style="width: 80%" align='left'>
										<INPUT type="text" id="OBLI-txtCodProducto" name="OBLI-txtCodProducto" value='' onchange="xajax_CargaDesc(xajax.getFormValues('Form1'), 'sgbodega.tallas', 'ta_ncorr', 'ta_descripcion', 'OBLI-txtCodProducto', 'OBLI-txtDescProducto', '');" maxLength="10" size="10">
										<INPUT type="text" id="OBLI-txtDescProducto" name="OBLI-txtDescProducto" value='' maxLength="100" size="50" readonly>
										<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda.php?entidad=4&obj1=OBLI-txtCodProducto&obj2=OBLI-txtDescProducto', 'Busca Art�culo', 550, 350, null);"></a>
									
									</td>
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Familia:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="cboFamilia" name="cboFamilia" onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CargaSubFamilias(xajax.getFormValues('Form1'));"></SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">SubFamilia:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="cboSubFamilia" name="cboSubFamilia" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>Todas</option>
										</SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Estado Producto:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="cboEstadoProducto" name="cboEstadoProducto" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value=''>Todos</option>
											<option value='0'>Inactivos</option>
											<option value='1'>Activos</option>
										</SELECT>
									</td>	
								</TR>
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 20%">Movimientos:<label class="requerido"> * </label></td>
									<td class="tabla-alycar-texto" style="width: 80%">
										<SELECT id="cboMovimientos" name="cboMovimientos" onKeyPress="return SoloNumeros(this, event, 0)">
											<option value='0'>Todos</option>
											<option value='1'>Ultimo mes</option>
											<option value='2'>Ultimos 3 meses</option>
											<option value='3'>Sin Movimiento ultimos 3 meses</option>
										</SELECT>
									</td>	
								</TR>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1')); sigue()" />
										Cronometro : <input type="text" id="crono" name="crono" value="" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td>
										<div id='divabonos'><div>
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
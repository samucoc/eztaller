<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
		
		{$xajax_js}
		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal_1.js"></script>
		
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
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>

			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
		
		{literal}
		
		<script type="text/javascript">
			$(document).ready(function() { 
                            $("#cboPersona").autocomplete({
                                source : 'busquedas/busqueda_persona.php',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById('txtCodCobrador').value = rut;
									}
                                });
                            }); 		
		</script>
		<script type="text/javascript" > 
			function verificaValor(temp){
                            if (temp==''){
                                document.getElementById('txtCodCobrador').value="";
                                }
                            }
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
			function exportar_excel(id_form, id_tabla)
			{
				 // Obtiene el contenido de la tabla indicada
				 var tabla = $("#" + id_tabla).html();
				 // Añade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el código en PHP
				 $("#" + id_form).submit();
			}
 		</script> 

		{/literal}
	
	</HEAD>
<body>
<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
<table cellpadding="2" cellspacing="2" class="curvar" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
  <tr>
    <td ><form id="Form1" name="Form1" method="post" runat="server">
		<br>
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
            <tr align="left" valign="middle">
                <td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
                <td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Ficha Resumen</label></td>
            </tr>
        </table>
        <br>
      <table class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
       <tr align="left">
            <td class="tabla-alycar-label" style="width: 15%">Trabajador<label class="requerido"> * </label></td>
            <td class="tabla-alycar-texto" style="width: 85%">
                <input name="cboPersona" id="cboPersona" value="" onchange="verificaValor(this.value)" size="50"/>
                <input type="hidden" name="txtCodCobrador" id="txtCodCobrador"></input>
            </td>	
        </tr>
        <tr align="left">
          <td colspan="2" class="tabla-alycar-fila-botones"><input type="button" name="btnGrabar" value="Buscar" class="boton" onclick="javascript: ValidaFormularioMantenedor();" />
            &nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</div>
		<div id="divlistado" align="left" style="display:block !important;margin-left:2px; padding: 2px;">
        		<table class="curvar" cellpadding="2" cellspacing="2" style="display:block !important;WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
                   <tr>
						<td>
                        <table cellpadding="0" cellspacing="0" class="tabla-alycar" style="width: 100%">
                          <tr align="left">
                            <td colspan="4" class="tabla-alycar-label" >Ficha Personal</td>
                          </tr>
                          <tr align="left">
                            <td width="20%" class="tabla-alycar-label" >Apellidos</td>
                            <td width="30%" class="tabla-alycar-texto" ><div name="OBLIape_pat" id="OBLIape_pat"></div>
                              <div name="OBLIape_mat" id="OBLIape_mat" /></td>
                            <td width="20%" class="tabla-alycar-label" >Nombres</td>
                            <td width="30%" class="tabla-alycar-texto" ><div name="OBLInombres" id="OBLInombres" ></div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Rut</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIrut" id="OBLIrut" maxlength="8" onkeypress="return SoloNumeros(this, event, 0)" ></div></td>
                            <td class="tabla-alycar-label" >Sexo</td>
                            <td class="tabla-alycar-texto" ><div id="sexo"></div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Direccion</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIdireccion" id="OBLIdireccion"></div></td>
                            <td class="tabla-alycar-label" >Ciudad</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIciudad" id="OBLIciudad" ></div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Telefono</td>
                            <td class="tabla-alycar-texto" ><div name="OBLItelefono" id="OBLItelefono" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Celular</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIcelular" id="OBLIcelular" onkeypress="return SoloNumeros(this, event, 0)" /></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Fecha Nacimiento</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIfecha_nac" id="OBLIfecha_nac" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Nacionalidad</td>
                            <td class="tabla-alycar-texto" ><div name="OBLInacionalidad" id="OBLInacionalidad" /></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Edad</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIedad" id="OBLIedad" onkeypress="return SoloNumeros(this, event, 0)" readonly="readonly" /></td>
                            <td class="tabla-alycar-label" >Estado Civil</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIestado_civil" id="OBLIestado_civil" ></div>
                              </td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Profesion / Estudios</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIprofesion" id="OBLIprofesion"/>
                              <div name="OBLIestudios" id="OBLIestudios" /></td>
                            <td class="tabla-alycar-label" >Total Cargas</td>
                            <td class="tabla-alycar-texto" ><div name="OBLItotal_cargas" id="OBLItotal_cargas" readonly="readonly"/>
                              </td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Contacto Emergencia</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIcont_eme" id="OBLIcont_eme"/></td>
                            <td class="tabla-alycar-label" >Fono Emergencia</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIfono_eme" id="OBLIfono_eme" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                          </tr>
                          <tr align="left">
                            <td colspan="4" class="tabla-alycar-label" >Cargas</td>
                          </tr>
                          <tr align="left">
                            <tr align="left">
										<td colspan='4'>
											<div id='divresultado'></div>
										</td>
							</TR>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >&nbsp;</td>
                            <td class="tabla-alycar-texto" >&nbsp;</td>
                            <td class="tabla-alycar-label" >&nbsp;</td>
                            <td class="tabla-alycar-texto" >&nbsp;</td>
                          </tr>
                          <tr align="left">
                            <td colspan="4" class="tabla-alycar-label" >Ficha Laboral</td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Cargo</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIcargo" id="OBLIcargo" size="75"/></td>
                            <td class="tabla-alycar-label" >Area</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIarea" id="OBLIarea"></div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Empresa</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIempresa" id="OBLIempresa"></div></td>
                            <td class="tabla-alycar-label" >Fecha Ingreso</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIfecha_ing" id="OBLIfecha_ing" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Fecha Contrato</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIfecha_cont" id="OBLIfecha_cont" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Fecha Termino Contrato</td>
                            <td class="tabla-alycar-texto" ><div name="fecha_ter_cont" id="fecha_ter_cont" onkeypress="return SoloNumeros(this, event, 0)" /></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Fecha Finiquito</td>
                            <td class="tabla-alycar-texto" ><div name="fecha_fin" id="fecha_fin" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Causa Finiquito</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIfiniquito" id="OBLIfiniquito" /></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Estado Empleado</td>
                            <td class="tabla-alycar-texto" ><div name="est_emp" id="est_emp"></div></td>
                            <td class="tabla-alycar-label" >Fecha Calculo Vacaciones</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIcal_vac" id="OBLIcal_vac" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Dias Vacaciones</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIdias_vacas" id="OBLIdias_vacas" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Asignacion Materiales</td>
                            <td class="tabla-alycar-texto" ><div id="OBLIasignacion" name="OBLIasignacion"></div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Tipo de Pago Remuneracion</td>
                            <td class="tabla-alycar-texto" ><div name="tipo_pr" id="tipo_pr">
                            </div></td>
                            <td class="tabla-alycar-label" >Monto Asignacion Materiales</td>
                            <td class="tabla-alycar-texto" ><div name="monto_asig_caja" id="monto_asig_caja">
                            </div></td>
                          </tr>
                          <tr align="left" class="oculto" style="display:none">
                            <td class="tabla-alycar-label" >Nro Cuenta</td>
                            <td class="tabla-alycar-texto" ><div name="nro_cuenta" id="nro_cuenta"/></td>
                            <td class="tabla-alycar-label" >Tipo Cuenta</td>
                            <td class="tabla-alycar-texto" ><div name="tipo_cuenta" id="tipo_cuenta">
                            </div></td>
                          </tr>
                          <tr align="left" class="oculto" style="display:none">
                            <td class="tabla-alycar-label" >Banco</td>
                            <td class="tabla-alycar-texto" ><div name="banco" id="banco">
                            </div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >&nbsp;</td>
                            <td class="tabla-alycar-texto" >&nbsp;</td>
                            <td class="tabla-alycar-label" >&nbsp;</td>
                            <td class="tabla-alycar-texto" >&nbsp;</td>
                          </tr>
                          <tr align="left">
                            <td colspan="4" class="tabla-alycar-label" >Ficha Previsional</td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >AFP</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIAfp" id="OBLIAfp">
                            </div></td>
                            <td class="tabla-alycar-label" >Institucion de Salud</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIsalud" id="OBLIsalud">
                            </div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Porcentaje Cotizacion</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIporc_cot" id="OBLIporc_cot" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Porcentaje Cotizacion</td>
                            <td class="tabla-alycar-texto" ><div name="OBLImonto_salud" id="OBLImonto_salud" /></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Porcentaje Cotizacion Adicional</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIporc_cot_adi" id="OBLIporc_cot_adi" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Monto plan UF</td>
                            <td class="tabla-alycar-texto" ><div id="plan_uf" name="plan_uf"/></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Monto Cotizacion Voluntaria</td>
                            <td class="tabla-alycar-texto" ><div name="OBLImonto_cot_vol" id="OBLImonto_cot_vol" onkeypress="return SoloNumeros(this, event, 0)"/></td>
                            <td class="tabla-alycar-label" >Monto plan pesos</td>
                            <td class="tabla-alycar-texto" ><div id="plan_pesos" name="plan_pesos"/></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >&nbsp;</td>
                            <td class="tabla-alycar-texto" >&nbsp;</td>
                            <td class="tabla-alycar-label" >&nbsp;</td>
                            <td class="tabla-alycar-texto" >&nbsp;</td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Ahorro Voluntario</td>
                            <td class="tabla-alycar-texto" ><div name="ahorro_vol" id="ahorro_vol"/>
                              &nbsp;</td>
                            <td class="tabla-alycar-label" >Caja Compensacion</td>
                            <td class="tabla-alycar-texto" ><div name="OBLIcaja_compensacion" id="OBLIcaja_compensacion">
                            </div></td>
                          </tr>
                          <tr align="left">
                            <td class="tabla-alycar-label" >Seguro Cesantia</td>
							<td class="tabla-alycar-texto" ><div name="seguro_cesantia" id="seguro_cesantia"/></td>
                            <td class="tabla-alycar-label" ></td>
                            <td class="tabla-alycar-texto" ></td>
                          </tr>
                        </table>
                        </td>
                        </tr>
                        
                        <tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divlistado');">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>

                        </table>
</div>

</body>
</html>
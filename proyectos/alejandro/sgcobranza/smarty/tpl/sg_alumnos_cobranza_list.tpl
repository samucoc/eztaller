<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Apoderado</td>
	<td class="grilla-tab-fila-campo" align='left'>
    	{$apoderado} - 
        {$telefono_apoderado} - 
        <a href="mailto:{$email_apoderado}" target="_top">{$email_apoderado}</a>
    </td>
    <td class="grilla-tab-fila-titulo" >
        Enviar Reporte Via Email
    </td>
    <td class="grilla-tab-fila-campo" align='left'>
        <select id="enviar_correo" name="enviar_correo" onchange="xajax_EnviarCorreoAlumno(xajax.getFormValues('Form1'),'{$curso}','{$alumno}','{$email_apoderado}');" >
            <option>Seleccione</option>
            <option value="1">Cartola</option>
            <option value="2">Pagos</option>
            <option value="3">Gestion Cobranza</option>
        </select>
    </td>
    
</tr>
</table>
		<div style="width:50%; float:left">

        <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
                <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
            </tr>
            {section name=registros loop=$arrRegistrosAlumnos}
            	{if $arrRegistrosAlumnos[registros].matriculado == '0'}        
            		<tr>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="#" onclick="showPopWin('sg_alumnos_matriculados.php?rut_alumno={$arrRegistrosAlumnos[registros].rut_alumno}', 'Ingresar Matricula', 800, 600, null)" >
                        	{$arrRegistrosAlumnos[registros].alumnos}
                        </a>
                    </td>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="#" onclick="showPopWin('sg_alumnos_matriculados.php?rut_alumno={$arrRegistrosAlumnos[registros].rut_alumno}', 'Ingresar Matricula', 800, 600, null)" >
                    		{$arrRegistrosAlumnos[registros].curso}
                    	</a>    
                    </td>
                    </tr>
            	
				{else}
                    <tr>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="sg_alumnos_cobranza.php?rut_alumno={$arrRegistrosAlumnos[registros].rut_alumno}">
                        	{$arrRegistrosAlumnos[registros].alumnos}
                        </a>
                    </td>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="sg_alumnos_cobranza.php?rut_alumno={$arrRegistrosAlumnos[registros].rut_alumno}">
	                        {$arrRegistrosAlumnos[registros].curso}
                    	</a>    
                    </td>
                    </tr>
            	{/if}
            {/section}
            <tr>
 	           <td class="grilla-tab-fila-campo" align='left' colspan="2">&nbsp;</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Alumno</td>
               <td class="grilla-tab-fila-campo" align='left'>
               		<a href="#" onclick="xajax_FichaAlumno(xajax.getFormValues('Form1'),{$rut_alumno});" >
		               	{$alumno}
                    </a>
               </td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Curso</td>
               <td class="grilla-tab-fila-campo" align='left'>{$curso}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Fecha Nacimiento</td>
               <td class="grilla-tab-fila-campo" align='left'>{$fecha_alumno|date_format:"%d/%m/%Y"}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Direccion</td>
               <td class="grilla-tab-fila-campo" align='left'>{$direccion}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Telefono</td>
               <td class="grilla-tab-fila-campo" align='left'>{$telefono}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Correo</td>
               <td class="grilla-tab-fila-campo" align='left'>{$email}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Tipo Beca</td>
               <td class="grilla-tab-fila-campo" align='left'>{$tipo_beca}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Beca Colegiatura 0</td>
               <td class="grilla-tab-fila-campo" align='left'>{$porc_beca_incor|number_format:0:".":","}</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Beca Colegiatura</td>
               <td class="grilla-tab-fila-campo" align='left'>{$porc_beca_colegiatura|number_format:0:".":","}</td>
            </tr>
        </table>
		</div>
		<div style="width:50%; float:left">
            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
                <td class="grilla-tab-fila-titulo" align='center'>Nro Cuota</td>
                <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pactado</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pagado</td>
                <td class="grilla-tab-fila-titulo" align='center'>Saldo</td>
                <td class="grilla-tab-fila-titulo" align='center'>Acciones</td>
            
                </tr>
                
            
            {section name=registros loop=$arrRegistros}
                    <tr>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}
                    >
                        {$arrRegistros[registros].codigo}</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}
                        >{$arrRegistros[registros].nro_cuota}</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}
                    >{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}
                    >{$arrRegistros[registros].pactado|number_format:0:".":","}</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}
                    >{$arrRegistros[registros].valorpagado|number_format:0:".":","}</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}
                    >{$arrRegistros[registros].saldo|number_format:0:".":","}</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        {if $arrRegistros[registros].cheque=='SI'}
                        style="background-color: #ffe6e6"
                        {else}

                        {/if}

                    >
                        <a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),{$arrRegistros[registros].id_ctacte})">
                        	<img src="../images/basicos/eliminar.png" title="Eliminar" alt="Eliminar" width="24" height="24"/>
                        </a>
                        <a href="#" onclick="xajax_Modificar(xajax.getFormValues('Form1'),{$arrRegistros[registros].id_ctacte})">
                        	<img src="../images/basicos/modificar.png" title="Modificar" alt="Modificar" width="24" height="24"/>
                        
                        </a>
                        <!--
                        {if $arrRegistros[registros].cheque=='SI'}
                        <a href="#" onclick="xajax_PagarMov(xajax.getFormValues('Form1'),{$arrRegistros[registros].boleta})">
                            <img src="../images/fin_comp/pago.png" title="Pagar Cheque" alt="Pagar Cheque" width="24" height="24"/>
                        </a>
                        {/if}
                        -->
                    </td>
                    </tr>
            {/section}
            </table>
            </div>
            <br style="clear:both"/>
            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="grilla-tab-fila-titulo" >Tipo</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="hidden" name="ctacte_ncorr" id="ctacte_ncorr"/>
                        <select id="tipo_pago" name="tipo_pago">
                            <option value="1">Incorporacion</option>
                            <option value="2">Colegiatura</option>
                        </select>
                    </td>
                    <td class="grilla-tab-fila-titulo" >Nro Cuenta</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="nro_cuenta" id="nro_cuenta"/>
                    </td>
                    <td class="grilla-tab-fila-titulo" >Fecha pago</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="fecha_pago" id="fecha_pago"/>
                    </td>
                </tr>
                <tr>
                    <td class="grilla-tab-fila-titulo" >Pactado</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="pactado" id="pactado"/>
                    </td>
                    <td class="grilla-tab-fila-titulo" >Pagado</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="pagado" id="pagado"/>
                    </td>
                    <td class="grilla-tab-fila-titulo" colspan="2">
                        <a href="#" name="btnGuardar" id="btnGuardar" onclick="xajax_GuardarPago(xajax.getFormValues('Form1'))">
                        	<img src="../images/basicos/agregar.png" title="Agregar Cuota" alt="Agregar Cuota" width="24" height="24"/>
                        </a>
                    </td>
                </tr>

            </table>
		</div>
</div>




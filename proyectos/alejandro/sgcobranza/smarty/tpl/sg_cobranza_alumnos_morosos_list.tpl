<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
            <a href="#" onclick="xajax_OrdenarRevision(xajax.getFormValues('Form1'),'saldo');">Saldo</a>
        </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
            <a href="#" onclick="xajax_OrdenarRevision(xajax.getFormValues('Form1'),'da');">
            Dias de Atraso
            </a>
        </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo" align="right">
            <input type="checkbox" name="todos"  id="todos" value='1' onchange="cambiar()"/>
            Cobranza
        </td>
        <td class="grilla-tab-fila-titulo" align="right">
            Cobranza Pre-Judicial
        </td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}');">{$arrRegistros[registros].alumno}</a>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}');">{$arrRegistros[registros].curso}</a>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}');">{$arrRegistros[registros].saldo|number_format:0:",":"."}</a>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}');">{$arrRegistros[registros].da}</a>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {if ($arrRegistros[registros].fecha_retirado =='NO')}
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}');">
                    <img src='../images/tick.png' width='24' title='Matriculado' />
                </a>
                {else}
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}');">
                    <img src='../images/stop.png' width='24' title='Retirado' />
                </a>
                {/if}
            </td>
            
            <td class="grilla-tab-fila-campo" align="right">
                <input type="checkbox" name="seleccion[]" id="{$arrRegistros[registros].rut_alumno}" value='{$arrRegistros[registros].rut_alumno}' />
                <a href="#" target="_self">
                    <img src="../../nmva/images/basicos/imprimir.png" border=0 title="Imprimir  Carta Cobranza"
                        onclick="xajax_ImprimePDF(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].fecha_buscar}');"
                        width="32">
                </a>
                <a href="#" target="_self">
                    <img src="../../nmva/images/basicos/email2.png" border=0 title="Enviar Carta Cobranza"
                        onclick="xajax_EnviarPDF(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].fecha_buscar}');"
                        width="32">
                </a>
            </td>
            <td class="grilla-tab-fila-campo" align="right">
                <a href="#" target="_self">
                    <img src="../../nmva/images/basicos/imprimir.png" border=0 title="Imprime Carta Cobranza Pre-judicial" 
                        onclick="xajax_ImprimePDF_2(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].fecha_buscar}');"
                        width="32">
                </a>
                <a href="#" target="_self">
                    <img src="../../nmva/images/basicos/email2.png" border=0 title="Enviar Carta Cobranza Pre-Judicial" 
                        onclick="xajax_EnviarPDF_2(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].fecha_buscar}');"
                        width="32">
                </a>
            </td>
	    </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
                <a href="#" target="_self">
                    <img src="../../sige/images/basicos/imprimir.png" border=0 title="Imprimir Informe Seleccionados" 
                        onclick="xajax_ImprimePDFSeleccionados(xajax.getFormValues('Form1'),'{$arrRegistros[registros].fecha_buscar}');"
                        width="32">
                </a>            
            <a href="#" target="_self" style="cursor: hand;"><img src="../../sige/images/basicos/email2.png" border=0 title="Enviar Correo Seleccionados" onclick="xajax_EnviarCorreoSeleccionados(xajax.getFormValues('Form1'),'{$arrRegistros[registros].fecha_buscar}');" width="32"></a>
        </td>
    </tr>
    </table>
</div>
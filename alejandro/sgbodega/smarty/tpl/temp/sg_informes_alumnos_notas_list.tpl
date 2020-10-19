<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-titulo' align='left'>
                Nro Matricula
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Nro Lista
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Alumno
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Acciones
            </td>
        </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].NroMatricula}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].NroLista}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <a href="#" target="_self">
                    <img src="../images/basicos/imprimir.png" border=0 title="Imprimir Informe" 
                        onclick="xajax_ImprimePDF(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].semestre}');"
                        width="32">
                </a>
                
            </td>
                
        </tr>
    {/section}
    </table>

    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td colspan='16' class="grilla-tab-fila-titulo">
                <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir Todo el Curso" onclick="xajax_ImprimePDFCurso(xajax.getFormValues('Form1'));" width="32"></a>
                <!--
                <a href="#" style="cursor: hand;"><img src="../images/basicos/email2.png" border=0 title="Enviar Todo el Curso" onclick="xajax_EnviarPDFCurso(xajax.getFormValues('Form1'));" width="32"></a>
                -->
            </td>
	    </tr>
    </table>
</div>
                

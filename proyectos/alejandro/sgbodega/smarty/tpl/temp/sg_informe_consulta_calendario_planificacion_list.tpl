<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td colspan="20" class="grilla-tab-fila-titulo" align='center'>
            Consulta y Seguimiento de Evaluaciones
        </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
        <td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
        <td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
        <td class="grilla-tab-fila-titulo" align='center'>Nota</td>
        <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
        <td class="grilla-tab-fila-titulo" align='center'>Descripci&oacute;n</td>
        <td class="grilla-tab-fila-titulo" align='center'>Tipo</td>
        <td class="grilla-tab-fila-titulo" align='center'>I</td>
        <td class="grilla-tab-fila-titulo" align='center'>S</td>
        <td class="grilla-tab-fila-titulo" align='center'>B</td>
        <td class="grilla-tab-fila-titulo" align='center'>MB</td>
    </tr>
    {section name=registros loop=$arrRegistros}
            <tr> 
                <td class="grilla-tab-fila-campo" align='left' >{$arrRegistros[registros].NombreCurso}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrRegistros[registros].Descripcion}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].profesor}</td>
                <td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].NumeroNota}</td>
                <td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].FechaPrueba}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].DescripcionPrueba}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].DescripcionPlazo}</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: white; background-color: #F01614">{$arrRegistros[registros].insuficiente} %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: orange">{$arrRegistros[registros].suficiente} %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: yellow">{$arrRegistros[registros].bueno} %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: #30C805">{$arrRegistros[registros].muy_bueno} %</td>
            </tr>
    {/section}
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>

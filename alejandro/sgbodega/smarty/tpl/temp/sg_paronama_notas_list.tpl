<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio">{$anio}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Semestre</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_semestre">{$semestre}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso">{$nombre_curso}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Profesor Jefe</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso">{$nombre_profe}</td>
    </tr>

    </table>
    <br />
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class="grilla-tab-fila-campo-pequenio" align="center">{$arrRegistros[registros].NroLista}</td>
            <td class="grilla-tab-fila-campo-pequenio" align="left">{$arrRegistros[registros].nombre_alumno}</td>
            {section name=registroNotas loop=$arrNotas}
                {if $arrRegistros[registros].rut_alumno == $arrNotas[registroNotas].rut_alumno}
                        {if $arrNotas[registroNotas].nota == 'XXX'}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' title="{$arrNotas[registroNotas].asignatura}" >{$arrNotas[registroNotas].CodigoRamo}</td>
                        {else}
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
                            {if $arrNotas[registroNotas].nota=='0'}

                            {else}
                                {if ($arrNotas[registroNotas].nota<'4') }
                                    {if $arrNotas[registroNotas].negro=='0'}
                                        <div style="color:red">
                                        {$arrNotas[registroNotas].nota}
                                        </div>
                                    {else}
                                        {$arrNotas[registroNotas].nota}
                                    {/if}
                                {else}
                                    {$arrNotas[registroNotas].nota}
                                {/if}
                            {/if}
                    </td>
                        {/if}
                {/if}
            {/section}
        </tr>
    {/section}
    </table>
    <br />
    <table id='tabla1' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
    </tr>
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
    </tr>
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
        <td class="grilla-tab-fila-campo-pequenio" align="left" style="border: 0px !important"></td>
    </tr>
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" style="border: 0px !important" colspan="3" align="center">Resumen del Curso</td>
    </tr>
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Codigo Ramo</td>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Descripcion</td>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Promedio</td>
    </tr>

        {section name=ramo loop=$arrRamos}
            <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
                <td class="grilla-tab-fila-campo-pequenio" align="left">{$arrRamos[ramo].CodigoRamo}</td>
                <td class="grilla-tab-fila-campo-pequenio" align="left">{$arrRamos[ramo].asignatura}</td>
                <td class="grilla-tab-fila-campo-pequenio" align="center">{$arrRamos[ramo].nota}</td>
            </tr>
        {/section}
    </table>
</div>
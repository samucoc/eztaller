<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio">{$anio}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso">{$nombre_curso}
        <small>(Incluye bonificaciones en casos que corresponda)</small></td>
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
                        <td class="grilla-tab-fila-campo-pequenio" {if $arrRegistros[registros].derecha} align="right" style="font-weight: bold"  {else} align="left" {/if}>{$arrRegistros[registros].nombre_alumno}</td>
                        {section name=registroNotas loop=$arrNotas}
                            {if $arrRegistros[registros].rut_alumno == $arrNotas[registroNotas].rut_alumno}
                                    {if $arrNotas[registroNotas].nota == 'XXX'}
                                        {if $arrNotas[registroNotas].CodigoRamo == 'Promedio' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Prom Insuf' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Rut' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Sexo' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Fecha Nacimiento' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Comuna' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Asis' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Atrasos' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'HV(-)' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'HV(+)' 
                                            }
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="{$arrNotas[registroNotas].asignatura}" style="font-weight: bold" >{$arrNotas[registroNotas].CodigoRamo}</td>
                                        {else}
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="{$arrNotas[registroNotas].asignatura}" style="font-weight: bold" colspan="3">{$arrNotas[registroNotas].CodigoRamo}</td>
                                        {/if}
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
                                                {if $arrNotas[registroNotas].CodigoRamo=='Prom Insuf'}
                                                    <div style="color:red">
                                                    {$arrNotas[registroNotas].nota}
                                                    </div>
                                                {else}
                                                    {$arrNotas[registroNotas].nota}
                                                {/if}
                                            {/if}
                                        {/if}
                                </td>
                                    {/if}
                            {/if}
                        {/section}
                    </tr>
        
    {/section}
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Codigo Ramo</td>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Descripcion</td>
    </tr>
        {section name=ramo loop=$arrRamos}
            <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
                <td class="grilla-tab-fila-campo-pequenio" align="left">{$arrRamos[ramo].CodigoRamo}</td>
                <td class="grilla-tab-fila-campo-pequenio" align="left">{$arrRamos[ramo].asignatura}</td>
            </tr>
        {/section}
    </table>
</div>
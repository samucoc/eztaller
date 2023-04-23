<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="10">ACTA DE CALIFICACIONES FINALES Y PROMOCION ESCOLAR</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Decreto Exento de Evaluaci&oacute;n que aprueba el reglamento de evaluaci&oacute;n y promoci&oacute;n escolar</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >{$decreto_planes}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">{$RegionEstablecimiento}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >{$ProvinciaEstablecimiento}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >Villa Alemana</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Decreto Exento o Resoluci&oacute; exenta de educaci&oacute;n que aprueba plan y programas de estudios</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >{$DecretoEvaluacion}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Region</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >Provincia</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >Comuna</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Documento que lo declara reconocido oficialmente por el ministerio de educaci&oacute;n de la rep&uacute;blica de Chile seg&uacute;n ley, decreto supremo, decreto, resoluci&oacute;n exenta de educaci&oacute;n</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >{$NumeroDecreto}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">{$RBD}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >{$nombre_curso}</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >{$anio}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" ></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Rol base de datos</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" >A&ntilde;o Escolar</td>
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
                                        {if $arrNotas[registroNotas].CodigoRamo == 'P Parcial' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Rut' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Sexo' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Fecha Nacimiento' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Comuna' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'P Final' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Prom Insuf' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Asis' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Sit Final' ||
                                            $arrNotas[registroNotas].CodigoRamo == 'Obs' 
                                            }
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="{$arrNotas[registroNotas].asignatura}" style="font-weight: bold" >{$arrNotas[registroNotas].CodigoRamo}</td>
                                        {else}
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="{$arrNotas[registroNotas].asignatura}" style="font-weight: bold" >{$arrNotas[registroNotas].CodigoRamo}</td>
                                        {/if}
                                    {else}
                                <td class='grilla-tab-fila-campo-pequenio' align='center' >
                                        {if $arrNotas[registroNotas].nota=='0'}
                                            ---
                                        {else}
                                            {if $arrNotas[registroNotas].nota<'4' }
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
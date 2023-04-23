<div id='pivot'>
    <table>
        <tr>
            <td colspan="4" align="right" style="background-image:url('{$Logo}');
                                                width:90px; height:90px;
                                                -webkit-print-color-adjust:exact;"></td>
        </tr>
    </table>
 	<br />    
    <br />    
    <br />    
    <br />  
       <h1 style="font-size: 36px" align="center">CERTIFICADO DE TRASLADO</h1>
    <br />    
    <br />  
    <table width="100%">
        <tr>
            <td align="right" width="25%">
            
            </td>
            <td align="right" width="25%">
                <img src="{$Foto}" width="200" style="-webkit-print-color-adjust:exact;"/>
            </td>
            <td align="right" width="25%">
            </td>
            <td align="right" width="25%">
            </td>
        </tr>
    </table>
    <p >
            <div style="padding-left: 12%; font-size: 14px; text-align: left">
            Villa Alemana a {$smarty.now|date_format:"%d-%m-%Y"}, se solicita traslado a Escuela Especial de Lenguaje del Alumno/a:
            </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">{$nombre_alumno}, R.U.N.: {$rut}</div>
        <br />
        <br />
           <div style="padding-left: 12%; font-size: 14px; text-align: left">Quien cursa {$nombre_curso} con el diagnostico de Trastorno Especifico de Lenguaje EXPRESIVO</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">Se hace entrega al apoderado la documentaci&oacute;n original, para hacer efetivo el traslado a contar de esta fecha.</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">
            Documentos entregados:
            </div>
        <br />
        <br />
            <ul>
                <li>
                    <input type="checkbox" name="cert_1" id="cert_1" value="1" checked/> Certificado de Nacimiento.
                </li>
                <li>
                    <input type="checkbox" name="cert_2" id="cert_2" value="1"  checked/> Autorizaci&oacute;n de Evaluaci&oacute;n
                </li>
                <li>
                    <input type="checkbox" name="cert_3" id="cert_3" value="1"  checked/> Anamnesis de ingreso
                </li>
                <li>
                    <input type="checkbox" name="cert_4" id="cert_4" value="1"  checked/> Informe Fonoaudiol&oacute;gico
                </li>
                <li>
                    <input type="checkbox" name="cert_5" id="cert_5" value="1"  checked/> Protocolos Fonoaudiol&oacute;gicos
                </li>
                <li>
                    <input type="checkbox" name="cert_6" id="cert_6" value="1"  checked/> Valoraci&oacute;n general de salud
                </li>
                <li>
                    <input type="checkbox" name="cert_7" id="cert_7" value="1"  checked/> Formulario &uacute;nico de ingreso
                </li>
                <li>
                    <input type="checkbox" name="cert_8" id="cert_8" value="1"  checked/> Formulario &uacute;nico de reevaluacion
                </li>
                <li>
                    <input type="checkbox" name="cert_9" id="cert_9" value="1"  checked/> Informa a la familia
                </li>
                <li>
                    <input type="checkbox" name="cert_0" id="cert_0" value="1"  checked/> Informe pedag&oacute;gico
                </li>
            </ul>    
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
            <div style="padding-left: 75%; font-size: 14px">Villa Alemana, {$smarty.now|date_format:"%d-%m-%Y"}</div>
    <!-- 
 	<table>
    	<tr>
    		<td colspan="4" align="right" style="background-image:url('{$Foto}');
        										width:200px; height:200px;
        										-webkit-print-color-adjust:exact;"></td>
  		</tr>
    	<tr>
        	<td colspan="4" align="right" >
            	{$Representante}
            </td>
        </tr>
    </table>
    -->
</div>
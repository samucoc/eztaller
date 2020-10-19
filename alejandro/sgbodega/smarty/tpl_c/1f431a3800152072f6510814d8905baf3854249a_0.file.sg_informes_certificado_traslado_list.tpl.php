<?php
/* Smarty version 3.1.33, created on 2020-04-15 19:51:39
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_informes_certificado_traslado_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5e979e0b8b7250_79006693',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1f431a3800152072f6510814d8905baf3854249a' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_informes_certificado_traslado_list.tpl',
      1 => 1586994696,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e979e0b8b7250_79006693 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id='pivot'>
    <table>
        <tr>
            <td colspan="4" align="right" style="background-image:url('<?php echo $_smarty_tpl->tpl_vars['Logo']->value;?>
');
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
                <img src="<?php echo $_smarty_tpl->tpl_vars['Foto']->value;?>
" width="200" style="-webkit-print-color-adjust:exact;"/>
            </td>
            <td align="right" width="25%">
            </td>
            <td align="right" width="25%">
            </td>
        </tr>
    </table>
    <p >
            <div style="padding-left: 12%; font-size: 14px; text-align: left">
            Villa Alemana a <?php echo smarty_modifier_date_format(time(),"%d-%m-%Y");?>
, se solicita traslado a Escuela Especial de Lenguaje del Alumno/a:
            </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left"><?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
, R.U.N.: <?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
</div>
        <br />
        <br />
           <div style="padding-left: 12%; font-size: 14px; text-align: left">Quien cursa <?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
 con el diagnostico de Trastorno Especifico de Lenguaje EXPRESIVO</div>
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
            <div style="padding-left: 75%; font-size: 14px">Villa Alemana, <?php echo smarty_modifier_date_format(time(),"%d-%m-%Y");?>
</div>
    <!-- 
 	<table>
    	<tr>
    		<td colspan="4" align="right" style="background-image:url('<?php echo $_smarty_tpl->tpl_vars['Foto']->value;?>
');
        										width:200px; height:200px;
        										-webkit-print-color-adjust:exact;"></td>
  		</tr>
    	<tr>
        	<td colspan="4" align="right" >
            	<?php echo $_smarty_tpl->tpl_vars['Representante']->value;?>

            </td>
        </tr>
    </table>
    -->
</div><?php }
}

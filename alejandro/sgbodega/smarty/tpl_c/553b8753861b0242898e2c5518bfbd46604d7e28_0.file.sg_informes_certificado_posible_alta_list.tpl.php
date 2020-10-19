<?php
/* Smarty version 3.1.33, created on 2020-06-20 11:37:08
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_informes_certificado_posible_alta_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5eee2d24507631_72215020',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '553b8753861b0242898e2c5518bfbd46604d7e28' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_informes_certificado_posible_alta_list.tpl',
      1 => 1592667425,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5eee2d24507631_72215020 (Smarty_Internal_Template $_smarty_tpl) {
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
    <h1 style="font-size: 36px" align="center">CERTIFICADO</h1>
    <br />    
    <br /> 
    <h2 style="font-size: 28px" align="center">POSIBLE ALTA FONOAUDIOL&Oacute;GICA</h2>
    <table width="100%">
        <tr>
            <td align="right" width="25%">
            
            </td>
            <td align="right" width="25%">
            </td>
            <td align="right" width="25%">
            </td>
            <td align="right" width="25%">
            </td>
        </tr>
    </table>
    <p >
    	    <div style="padding-left: 12%; font-size: 14px; text-align: left">
            La Fonoaudióloga que suscribe, certifica que <?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
, 
            </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">asiste a la Escuela Especial de Lenguaje "Arcoíris" en <?php echo $_smarty_tpl->tpl_vars['DescripcionLarga']->value;?>
</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">, con diagnóstico de <?php echo $_smarty_tpl->tpl_vars['diagnostico_alumno']->value;?>
, y se encuentra en situación</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">de POSIBLE ALTA de su trastorno específico de lenguaje.</div>
        <br />
        <br />
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">Durante los meses de Noviembre y Diciembre del presente año, se llevará a cabo el</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">proceso de reevaluación fonoaudiológica en que se determinará la situación final</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">del alumno(a).</div>
        <br />
        <br />
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">Se extiende el presente certificado a petición del apoderado para los fines que</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">estime conveniente.</div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
            <div style="padding-left: 75%; font-size: 14px">Villa Alemana, <?php echo smarty_modifier_date_format(time(),"%d-%m-%Y");?>
</div>
    </p>
    <br />  
    <br />    
 	<!--
    
    -->
</div><?php }
}

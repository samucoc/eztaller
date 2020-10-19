<?php
/* Smarty version 3.1.33, created on 2019-07-29 12:50:22
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_certificado_alumno_regular_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f23ce80af04_95683141',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91d296c7f70b780a78c3ee7363cef4f41aa08a43' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_certificado_alumno_regular_list.tpl',
      1 => 1563312323,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f23ce80af04_95683141 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id='pivot'>
    <table>
    	<tr>
    		<td colspan="4" align="right" style="background-image:url('<?php echo $_smarty_tpl->tpl_vars['Logo']->value;?>
');
        										width:100px; height:100px;
        										-webkit-print-color-adjust:exact;"></td>
  		</tr>
    </table>
    <br />    
    <br />    
    <br />    
    <br />  
    <h1 style="font-size: 36px" align="center">CERTIFICADO DE ALUMNO REGULAR</h1>
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
            MARCIA GONZ&Aacute;LEZ HENR&Iacute;QUEZ, Directora del <?php echo $_smarty_tpl->tpl_vars['nombre_colegio']->value;?>

            </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">de Villa Alemana,   RBD: <?php echo $_smarty_tpl->tpl_vars['RBD']->value;?>
, certifica que don (a)  <?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
,</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">R.U.T.: <?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
,  alumno (a) <?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
,</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">asiste regularmente a clases en nuestro establecimiento.  </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">Se extiende el presente certificado para </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left"><?php echo $_smarty_tpl->tpl_vars['observacion']->value;?>
 </div>
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

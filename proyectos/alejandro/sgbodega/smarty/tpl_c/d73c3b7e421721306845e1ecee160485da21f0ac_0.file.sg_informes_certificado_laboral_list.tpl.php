<?php
/* Smarty version 3.1.33, created on 2020-05-14 14:16:32
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_informes_certificado_laboral_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ebd8b00de5364_52288757',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd73c3b7e421721306845e1ecee160485da21f0ac' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/arcoiris/sgadministrativo/smarty/tpl/sg_informes_certificado_laboral_list.tpl',
      1 => 1589480190,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ebd8b00de5364_52288757 (Smarty_Internal_Template $_smarty_tpl) {
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
       <h1 style="font-size: 36px" align="center">CERTIFICADO LABORAL</h1>
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
            Josselyn Campos S&aacute;nchez, Directora del establecimiento educacional, <?php echo $_smarty_tpl->tpl_vars['nombre_colegio']->value;?>
, 
            </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">de Villa Alemana,   certifica que don (a)  <?php echo $_smarty_tpl->tpl_vars['nombre_profesor']->value;?>
,</div>
        <br />
        <br />
           <div style="padding-left: 12%; font-size: 14px; text-align: left">R.U.N.: <?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
, trabaja en nuestro establecimiento</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">como <?php echo $_smarty_tpl->tpl_vars['EspecialidadProfesor']->value;?>
 desde <?php echo $_smarty_tpl->tpl_vars['IngresoFuncionario']->value;?>
, </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">con un contrato de carácter indefinido.</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">Se extiende el presente certificado a petici&oacute;n del trabajador para </div>
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

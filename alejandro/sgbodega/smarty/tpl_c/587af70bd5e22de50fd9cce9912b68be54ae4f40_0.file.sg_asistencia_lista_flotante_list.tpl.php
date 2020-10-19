<?php
/* Smarty version 3.1.33, created on 2019-07-16 18:14:56
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_asistencia_lista_flotante_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d2e4c60a531f1_46028076',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '587af70bd5e22de50fd9cce9912b68be54ae4f40' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_asistencia_lista_flotante_list.tpl',
      1 => 1563312313,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d2e4c60a531f1_46028076 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="4">Lista Flotante Para Asistencia</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">Fecha</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Matricula</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Ingreso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Retiro</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
    </tr>
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['sexo_alumno'] == '0')) {?> 
                    style="color: blue !important;"
                <?php } else { ?>
                    style="color: red !important;"
                <?php }?>
            >
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_lista'] == '0') {?>

                <?php } else { ?>
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] == '0000-00-00') {?>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_lista'];?>

                    <?php } else { ?>
                        <strike>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_lista'];?>

                        </strike>
                    <?php }?>
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['sexo_alumno'] == '0')) {?> 
                    style="color: blue !important;"
                <?php } else { ?>
                    style="color: red !important;"
                <?php }?>
            >
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_matricula'] == '0') {?>

                <?php } else { ?>
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] == '0000-00-00') {?>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_matricula'];?>

                    <?php } else { ?>
                        <strike>
                            <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_matricula'];?>

                        </strike>
                    <?php }?>                    
                <?php }?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['sexo_alumno'] == '0')) {?> 
                    style="color: blue !important;"
                <?php } else { ?>
                    style="color: red !important;"
                <?php }?>
            >
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] == '0000-00-00') {?>
                        <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_ingreso'],"%d/%m/%Y");?>

                    <?php } else { ?>
                        <strike>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_ingreso'],"%d/%m/%Y");?>

                        </strike>
                    <?php }?>  
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] == '0000-00-00') {?>

                <?php } else { ?>
                        <strike>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'],"%d/%m/%Y");?>

                        </strike>
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'
                <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['sexo_alumno'] == '0')) {?> 
                    style="color: blue !important;"
                <?php } else { ?>
                    style="color: red !important;"
                <?php }?>
            >
                 <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] == '0000-00-00') {?>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'];?>

                    <?php } else { ?>
                        <strike>
                            <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'];?>

                        </strike>
                    <?php }?>  


            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'
                <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['sexo_alumno'] == '0')) {?> 
                    style="color: blue !important;"
                <?php } else { ?>
                    style="color: red !important;"
                <?php }?>
            >
                 <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_retiro'] == '0000-00-00') {?>
                         <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

                    <?php } else { ?>
                        <strike>
                             <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

                        </strike>
                    <?php }?>  
               
            </td>
        </tr>
    <?php
}
}
?>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Hombres</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $_smarty_tpl->tpl_vars['hombre']->value;?>
</td>
        </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Mujeres</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $_smarty_tpl->tpl_vars['mujer']->value;?>
</td>
        </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Total</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</td>
        </tr>

    </table>
</div><?php }
}

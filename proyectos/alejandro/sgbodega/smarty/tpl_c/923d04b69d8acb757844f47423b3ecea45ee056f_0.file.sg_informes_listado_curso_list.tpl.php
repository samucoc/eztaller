<?php
/* Smarty version 3.1.33, created on 2019-07-29 12:37:14
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_listado_curso_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f20ba71f679_43972961',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '923d04b69d8acb757844f47423b3ecea45ee056f' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_listado_curso_list.tpl',
      1 => 1563312324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f20ba71f679_43972961 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>

            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo-pequenio' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['nombre_profe']->value;?>

            </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Orden</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Retiro</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Sexo</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Nacimiento</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Email Apoderado</td>
    </tr>
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"' 
             <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaRetiro'] != '0000-00-00') {?> style="text-decoration:line-through;" <?php }?>>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['item'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['item'] != '----') {?>
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['matriculado'] == '1') {?>
                        <img src='../images/tick.png' width='24' title='Matriculado'  alt='Matriculado' />
                    <?php } else { ?>
                        <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['matriculado'] == '0') {?>
                        <img src='../images/stop.png' width='24' title='No Matriculado'   alt='No Matriculado'  />
                        <?php } else { ?>
                            <img src='../images/stop.png' width='24' title='Retirado' alt='Retirado'/>
                        <?php }?>
                    <?php }?>
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaRetiro'] != '0000-00-00') {?>
                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaRetiro'],'%d/%m/%Y');?>

                <?php } else { ?>
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['item'] != '----') {?>
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['sexo_alumno'] == 0) {?>
    					Masculino
    				<?php } else { ?>
    					Femenino
    				<?php }?>
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha_nacimiento'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['EMailApoderado'];?>

            </td>
        </tr>
    <?php
}
}
?>

    </table>
</div><?php }
}

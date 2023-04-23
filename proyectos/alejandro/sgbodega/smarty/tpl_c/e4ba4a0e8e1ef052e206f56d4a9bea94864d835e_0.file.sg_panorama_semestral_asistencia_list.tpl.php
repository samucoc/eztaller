<?php
/* Smarty version 3.1.33, created on 2019-12-17 20:18:30
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_panorama_semestral_asistencia_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5df96246e46a68_73454725',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e4ba4a0e8e1ef052e206f56d4a9bea94864d835e' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_panorama_semestral_asistencia_list.tpl',
      1 => 1576624704,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df96246e46a68_73454725 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio"><?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Días del Periodo</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_semestre"><?php echo $_smarty_tpl->tpl_vars['semestre']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Profesor Jefe</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso"><?php echo $_smarty_tpl->tpl_vars['nombre_profe']->value;?>
</td>
    </tr>
    </table>
    <br />
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class="grilla-tab-fila-campo-pequenio" align="center"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NroLista'];?>
</td>
            <td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>
</td>
            <?php
$__section_registroNotas_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrNotas']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registroNotas_1_total = $__section_registroNotas_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registroNotas'] = new Smarty_Variable(array());
if ($__section_registroNotas_1_total !== 0) {
for ($__section_registroNotas_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] = 0; $__section_registroNotas_1_iteration <= $__section_registroNotas_1_total; $__section_registroNotas_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']++){
?>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'] == $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['rut_alumno']) {?>
                        <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'] == 'XXX') {?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['asignatura'];?>
" ><?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'];?>
</td>
                        <?php } else { ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
                            <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'] == '0') {?>

                            <?php } else { ?>
                                <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['negro'] == '0') {?>
                                    <div style="color:red">
                                    <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                    </div>
                                <?php } else { ?>
                                    <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                <?php }?>
                            <?php }?>
                    </td>
                        <?php }?>
                <?php }?>
            <?php
}
}
?>
        </tr>
    <?php
}
}
?>
    </table>
</div><?php }
}

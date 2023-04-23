<?php
/* Smarty version 3.1.33, created on 2019-09-24 20:29:16
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_paronama_anual_periodo_resumen_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d8aa6cc224783_21320120',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '66fec968e646dcdf076fd352aeebf70cb2e4bcd2' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_paronama_anual_periodo_resumen_list.tpl',
      1 => 1569367671,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d8aa6cc224783_21320120 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio"><?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
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
                        <td class="grilla-tab-fila-campo-pequenio" <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['derecha']) {?> align="right" style="font-weight: bold"  <?php } else { ?> align="left" <?php }?>><?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['tachado'] == 1) {?><del><?php }
echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];
if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['tachado'] == 1) {?></del><?php }?></td>
                        <?php
$__section_registroNotas_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrNotas']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registroNotas_1_total = $__section_registroNotas_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registroNotas'] = new Smarty_Variable(array());
if ($__section_registroNotas_1_total !== 0) {
for ($__section_registroNotas_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] = 0; $__section_registroNotas_1_iteration <= $__section_registroNotas_1_total; $__section_registroNotas_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']++){
?>
                            <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'] == $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['rut_alumno']) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'] == 'XXX') {?>
                                        <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Promedio' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Prom Insuf' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Rut' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Sexo' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Fecha Nacimiento' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Comuna' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Inasis' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Atrasos' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'HV(-)' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'HV(+)' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Gestión del docente / equipo aula' || $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Plan de acción') {?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['asignatura'];?>
" style="font-weight: bold" ><?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'];?>
</td>
                                        <?php } else { ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['asignatura'];?>
" style="font-weight: bold" ><?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'];?>
</td>
                                        <?php }?>
                                    <?php } else { ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' >
                                        <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'] == '0') {?>

                                        <?php } else { ?>
                                            <?php if (($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'] < '4')) {?>
                                                <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['negro'] == '0') {?>
                                                    <div style="color:red">
                                                    <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                    </div>
                                                <?php } else { ?>
                                                    <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                <?php }?>
                                            <?php } else { ?>
                                                <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Prom Insuf') {?>
                                                    <div style="color:red">
                                                    <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                    </div>
                                                <?php } else { ?>
                                                    <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                <?php }?>
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

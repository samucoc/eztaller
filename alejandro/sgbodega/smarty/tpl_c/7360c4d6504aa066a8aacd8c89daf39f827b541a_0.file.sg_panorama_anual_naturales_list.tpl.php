<?php
/* Smarty version 3.1.33, created on 2019-12-17 20:25:02
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_panorama_anual_naturales_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5df963ce1be452_63483646',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7360c4d6504aa066a8aacd8c89daf39f827b541a' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_panorama_anual_naturales_list.tpl',
      1 => 1576625094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df963ce1be452_63483646 (Smarty_Internal_Template $_smarty_tpl) {
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
                        <td class="grilla-tab-fila-campo-pequenio" <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['derecha']) {?> align="right" style="font-weight: bold"  <?php } else { ?> align="left" <?php }?>><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>
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
                                        <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Biologia') {?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['asignatura'];?>
" style="font-weight: bold" colspan="<?php echo $_smarty_tpl->tpl_vars['maximo']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'];?>
</td>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Fisica') {?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['asignatura'];?>
" style="font-weight: bold" colspan="<?php echo $_smarty_tpl->tpl_vars['maximo_1']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'];?>
</td>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Quimica') {?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['asignatura'];?>
" style="font-weight: bold" colspan="<?php echo $_smarty_tpl->tpl_vars['maximo_2']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'];?>
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
                                                <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['promedio'] == '1') {?>
                                                    <div style="font-weight: bold">
                                                    <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['negro'] == '0') {?>
                                                        <div style="color:red">
                                                        <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                        </div>
                                                    <?php } else { ?>
                                                        <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                    <?php }?>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['negro'] == '0') {?>
                                                        <div style="color:red">
                                                        <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                        </div>
                                                    <?php } else { ?>
                                                        <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                    <?php }?>
                                                <?php }?>
                                            <?php } else { ?>
                                                <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['promedio'] == '1') {?>
                                                    <div style="font-weight: bold">
                                                    <?php if ($_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['CodigoRamo'] == 'Prom Insuf') {?>
                                                        <div style="color:red">
                                                        <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                        </div>
                                                    <?php } else { ?>
                                                        <?php echo $_smarty_tpl->tpl_vars['arrNotas']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registroNotas']->value['index'] : null)]['nota'];?>

                                                    <?php }?>
                                                    </div>
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
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Codigo Ramo</td>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Descripcion</td>
    </tr>
        <?php
$__section_ramo_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRamos']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_ramo_2_total = $__section_ramo_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_ramo'] = new Smarty_Variable(array());
if ($__section_ramo_2_total !== 0) {
for ($__section_ramo_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_ramo']->value['index'] = 0; $__section_ramo_2_iteration <= $__section_ramo_2_total; $__section_ramo_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_ramo']->value['index']++){
?>
            <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
                <td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $_smarty_tpl->tpl_vars['arrRamos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_ramo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_ramo']->value['index'] : null)]['CodigoRamo'];?>
</td>
                <td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $_smarty_tpl->tpl_vars['arrRamos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_ramo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_ramo']->value['index'] : null)]['asignatura'];?>
</td>
            </tr>
        <?php
}
}
?>
    </table>
</div><?php }
}

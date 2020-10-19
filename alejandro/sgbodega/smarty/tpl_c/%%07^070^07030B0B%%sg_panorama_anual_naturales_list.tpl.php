<?php /* Smarty version 2.6.18, created on 2018-01-02 10:05:33
         compiled from sg_panorama_anual_naturales_list.tpl */ ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio"><?php echo $this->_tpl_vars['anio']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td>
    </tr>
    </table>
    <br />
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <?php unset($this->_sections['registros']);
$this->_sections['registros']['name'] = 'registros';
$this->_sections['registros']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registros']['show'] = true;
$this->_sections['registros']['max'] = $this->_sections['registros']['loop'];
$this->_sections['registros']['step'] = 1;
$this->_sections['registros']['start'] = $this->_sections['registros']['step'] > 0 ? 0 : $this->_sections['registros']['loop']-1;
if ($this->_sections['registros']['show']) {
    $this->_sections['registros']['total'] = $this->_sections['registros']['loop'];
    if ($this->_sections['registros']['total'] == 0)
        $this->_sections['registros']['show'] = false;
} else
    $this->_sections['registros']['total'] = 0;
if ($this->_sections['registros']['show']):

            for ($this->_sections['registros']['index'] = $this->_sections['registros']['start'], $this->_sections['registros']['iteration'] = 1;
                 $this->_sections['registros']['iteration'] <= $this->_sections['registros']['total'];
                 $this->_sections['registros']['index'] += $this->_sections['registros']['step'], $this->_sections['registros']['iteration']++):
$this->_sections['registros']['rownum'] = $this->_sections['registros']['iteration'];
$this->_sections['registros']['index_prev'] = $this->_sections['registros']['index'] - $this->_sections['registros']['step'];
$this->_sections['registros']['index_next'] = $this->_sections['registros']['index'] + $this->_sections['registros']['step'];
$this->_sections['registros']['first']      = ($this->_sections['registros']['iteration'] == 1);
$this->_sections['registros']['last']       = ($this->_sections['registros']['iteration'] == $this->_sections['registros']['total']);
?>
                    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
                        <td class="grilla-tab-fila-campo-pequenio" align="center"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NroLista']; ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['derecha']): ?> align="right" style="font-weight: bold"  <?php else: ?> align="left" <?php endif; ?>><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>
</td>
                        <?php unset($this->_sections['registroNotas']);
$this->_sections['registroNotas']['name'] = 'registroNotas';
$this->_sections['registroNotas']['loop'] = is_array($_loop=$this->_tpl_vars['arrNotas']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registroNotas']['show'] = true;
$this->_sections['registroNotas']['max'] = $this->_sections['registroNotas']['loop'];
$this->_sections['registroNotas']['step'] = 1;
$this->_sections['registroNotas']['start'] = $this->_sections['registroNotas']['step'] > 0 ? 0 : $this->_sections['registroNotas']['loop']-1;
if ($this->_sections['registroNotas']['show']) {
    $this->_sections['registroNotas']['total'] = $this->_sections['registroNotas']['loop'];
    if ($this->_sections['registroNotas']['total'] == 0)
        $this->_sections['registroNotas']['show'] = false;
} else
    $this->_sections['registroNotas']['total'] = 0;
if ($this->_sections['registroNotas']['show']):

            for ($this->_sections['registroNotas']['index'] = $this->_sections['registroNotas']['start'], $this->_sections['registroNotas']['iteration'] = 1;
                 $this->_sections['registroNotas']['iteration'] <= $this->_sections['registroNotas']['total'];
                 $this->_sections['registroNotas']['index'] += $this->_sections['registroNotas']['step'], $this->_sections['registroNotas']['iteration']++):
$this->_sections['registroNotas']['rownum'] = $this->_sections['registroNotas']['iteration'];
$this->_sections['registroNotas']['index_prev'] = $this->_sections['registroNotas']['index'] - $this->_sections['registroNotas']['step'];
$this->_sections['registroNotas']['index_next'] = $this->_sections['registroNotas']['index'] + $this->_sections['registroNotas']['step'];
$this->_sections['registroNotas']['first']      = ($this->_sections['registroNotas']['iteration'] == 1);
$this->_sections['registroNotas']['last']       = ($this->_sections['registroNotas']['iteration'] == $this->_sections['registroNotas']['total']);
?>
                            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno'] == $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['rut_alumno']): ?>
                                    <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota'] == 'XXX'): ?>
                                        <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo'] == 'Biologia'): ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['asignatura']; ?>
" style="font-weight: bold" colspan="<?php echo $this->_tpl_vars['maximo']; ?>
"><?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo']; ?>
</td>
                                        <?php elseif ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo'] == 'Fisica'): ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['asignatura']; ?>
" style="font-weight: bold" colspan="<?php echo $this->_tpl_vars['maximo_1']; ?>
"><?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo']; ?>
</td>
                                        <?php elseif ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo'] == 'Quimica'): ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['asignatura']; ?>
" style="font-weight: bold" colspan="<?php echo $this->_tpl_vars['maximo_2']; ?>
"><?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo']; ?>
</td>
                                        <?php else: ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' title="<?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['asignatura']; ?>
" style="font-weight: bold" ><?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo']; ?>
</td>
                                        <?php endif; ?>
                                    <?php else: ?>
                                <td class='grilla-tab-fila-campo-pequenio' align='center' >
                                        <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota'] == '0'): ?>

                                        <?php else: ?>
                                            <?php if (( $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota'] < '4' )): ?>
                                                <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['promedio'] == '1'): ?>
                                                    <div style="font-weight: bold">
                                                    <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['negro'] == '0'): ?>
                                                        <div style="color:red">
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                    <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['negro'] == '0'): ?>
                                                        <div style="color:red">
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['promedio'] == '1'): ?>
                                                    <div style="font-weight: bold">
                                                    <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo'] == 'Prom Insuf'): ?>
                                                        <div style="color:red">
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                    <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <?php if ($this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['CodigoRamo'] == 'Prom Insuf'): ?>
                                                        <div style="color:red">
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <?php echo $this->_tpl_vars['arrNotas'][$this->_sections['registroNotas']['index']]['nota']; ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                
                                            <?php endif; ?>
                                        <?php endif; ?>
                                </td>
                                    <?php endif; ?>
                            <?php endif; ?>
                        <?php endfor; endif; ?>
                    </tr>
        
    <?php endfor; endif; ?>
    <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Codigo Ramo</td>
        <td class="grilla-tab-fila-campo-pequenio" align="left">Descripcion</td>
    </tr>
        <?php unset($this->_sections['ramo']);
$this->_sections['ramo']['name'] = 'ramo';
$this->_sections['ramo']['loop'] = is_array($_loop=$this->_tpl_vars['arrRamos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ramo']['show'] = true;
$this->_sections['ramo']['max'] = $this->_sections['ramo']['loop'];
$this->_sections['ramo']['step'] = 1;
$this->_sections['ramo']['start'] = $this->_sections['ramo']['step'] > 0 ? 0 : $this->_sections['ramo']['loop']-1;
if ($this->_sections['ramo']['show']) {
    $this->_sections['ramo']['total'] = $this->_sections['ramo']['loop'];
    if ($this->_sections['ramo']['total'] == 0)
        $this->_sections['ramo']['show'] = false;
} else
    $this->_sections['ramo']['total'] = 0;
if ($this->_sections['ramo']['show']):

            for ($this->_sections['ramo']['index'] = $this->_sections['ramo']['start'], $this->_sections['ramo']['iteration'] = 1;
                 $this->_sections['ramo']['iteration'] <= $this->_sections['ramo']['total'];
                 $this->_sections['ramo']['index'] += $this->_sections['ramo']['step'], $this->_sections['ramo']['iteration']++):
$this->_sections['ramo']['rownum'] = $this->_sections['ramo']['iteration'];
$this->_sections['ramo']['index_prev'] = $this->_sections['ramo']['index'] - $this->_sections['ramo']['step'];
$this->_sections['ramo']['index_next'] = $this->_sections['ramo']['index'] + $this->_sections['ramo']['step'];
$this->_sections['ramo']['first']      = ($this->_sections['ramo']['iteration'] == 1);
$this->_sections['ramo']['last']       = ($this->_sections['ramo']['iteration'] == $this->_sections['ramo']['total']);
?>
            <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
                <td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $this->_tpl_vars['arrRamos'][$this->_sections['ramo']['index']]['CodigoRamo']; ?>
</td>
                <td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $this->_tpl_vars['arrRamos'][$this->_sections['ramo']['index']]['asignatura']; ?>
</td>
            </tr>
        <?php endfor; endif; ?>
    </table>
</div>
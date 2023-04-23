<?php /* Smarty version 2.6.18, created on 2013-10-07 14:12:42
         compiled from sg_informe_presupuesto_cargas_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
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
    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['desc'] != ''): ?>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Empresa</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['desc']; ?>
</td>
        <td class="grilla-tab-fila-campo" width="20%"></td>
        <td class="grilla-tab-fila-campo" width="20%"></td>
        <td class="grilla-tab-fila-campo" width="20%"></td>
            
    </tr>
        <tr>
            <td class="grilla-tab-fila-campo" align='center' ></td>
            <td class="grilla-tab-fila-campo" align='center' >93</td>
            <td class="grilla-tab-fila-campo" align='center' >95</td>
            <td class="grilla-tab-fila-campo" align='center' >97</td>
            <td class="grilla-tab-fila-campo" align='center' >DIESEL</td>
        </tr>
            <?php unset($this->_sections['detalle']);
$this->_sections['detalle']['name'] = 'detalle';
$this->_sections['detalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_detalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['detalle']['show'] = true;
$this->_sections['detalle']['max'] = $this->_sections['detalle']['loop'];
$this->_sections['detalle']['step'] = 1;
$this->_sections['detalle']['start'] = $this->_sections['detalle']['step'] > 0 ? 0 : $this->_sections['detalle']['loop']-1;
if ($this->_sections['detalle']['show']) {
    $this->_sections['detalle']['total'] = $this->_sections['detalle']['loop'];
    if ($this->_sections['detalle']['total'] == 0)
        $this->_sections['detalle']['show'] = false;
} else
    $this->_sections['detalle']['total'] = 0;
if ($this->_sections['detalle']['show']):

            for ($this->_sections['detalle']['index'] = $this->_sections['detalle']['start'], $this->_sections['detalle']['iteration'] = 1;
                 $this->_sections['detalle']['iteration'] <= $this->_sections['detalle']['total'];
                 $this->_sections['detalle']['index'] += $this->_sections['detalle']['step'], $this->_sections['detalle']['iteration']++):
$this->_sections['detalle']['rownum'] = $this->_sections['detalle']['iteration'];
$this->_sections['detalle']['index_prev'] = $this->_sections['detalle']['index'] - $this->_sections['detalle']['step'];
$this->_sections['detalle']['index_next'] = $this->_sections['detalle']['index'] + $this->_sections['detalle']['step'];
$this->_sections['detalle']['first']      = ($this->_sections['detalle']['iteration'] == 1);
$this->_sections['detalle']['last']       = ($this->_sections['detalle']['iteration'] == $this->_sections['detalle']['total']);
?>
        		<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa'] == $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['empresa']): ?>
                <tr>
                    <td 
                    	<?php if (( ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'presupuesto' ) || ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'diferencia' ) )): ?>
                    		class="grilla-tab-fila-titulo" style="font-weight:bolder"
                        <?php else: ?>
                    		class="grilla-tab-fila-campo" 
                         <?php endif; ?>
                        align='left'><?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo']; ?>
</td>
                    <td 
                    	<?php if (( ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'presupuesto' ) || ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'diferencia' ) )): ?>
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        <?php else: ?>
                    		class="grilla-tab-fila-campo" 
                         <?php endif; ?>
                        align='right'>
                        <?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'extras'): ?>
                            <input type="text" name="t_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_93_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['primero']; ?>
"   style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
						<?php else: ?>
                        	<label id="lbl_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_93_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
"><?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['primero']; ?>
</label>
                            <input type="hidden" name="t_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_93_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['primero']; ?>
"  />
                        <?php endif; ?>
                    </td>
                    <td 
                    	<?php if (( ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'presupuesto' ) || ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'diferencia' ) )): ?>
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        <?php else: ?>
                    		class="grilla-tab-fila-campo" 
                         <?php endif; ?>
                        align='right'>
                        <?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'extras'): ?>
                        	<input type="text" name="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_95_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['segundo']; ?>
"   style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
						<?php else: ?>
                        	<label id="lbl_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_95_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
"><?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['segundo']; ?>
</label>
                            <input type="hidden" name="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_95_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['segundo']; ?>
"  />
                        <?php endif; ?>
                    </td>
                    <td 
                    	<?php if (( ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'presupuesto' ) || ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'diferencia' ) )): ?>
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        <?php else: ?>
                    		class="grilla-tab-fila-campo" 
                         <?php endif; ?>
                        align='right'>
                        <?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'extras'): ?>
                        	<input type="text" name="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_97_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tercero']; ?>
" style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
						<?php else: ?>
                        	<label id="lbl_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_97_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
"><?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tercero']; ?>
</label>
                            <input type="hidden" name="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_97_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tercero']; ?>
"  />
                        <?php endif; ?>
                    </td>
                    <td 
                    	<?php if (( ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'presupuesto' ) || ( $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'diferencia' ) )): ?>
                    		class="grilla-tab-fila-titulo"  style="font-weight:bolder"
                        <?php else: ?>
                    		class="grilla-tab-fila-campo" 
                         <?php endif; ?>
                        align='right'>
                        <?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto'] == 'extras'): ?>
                        	<input type="text" name="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_DIESEL_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['cuarto']; ?>
"   style="text-align:right" onKeyPress="return SoloNumeros(this, event, 0)"/>
                        <?php else: ?>
                        	<label id="lbl_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_DIESEL_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
"><?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['cuarto']; ?>
</label>
                            <input type="hidden" name="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
[]" class="cambio_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
" id="txt_<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo_corto']; ?>
_DIESEL_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_empresa']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['cuarto']; ?>
"  />
                        <?php endif; ?>
                    </td>
                </tr>
		        <?php endif; ?>
            <?php endfor; endif; ?>
	<?php endif; ?>
<?php endfor; endif; ?>

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">-->
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



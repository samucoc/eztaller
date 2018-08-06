<?php /* Smarty version 2.6.18, created on 2016-04-22 11:49:13
         compiled from sg_informe_estado_cuenta_list.tpl */ ?>
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
        <td class="grilla-tab-fila-campo" colspan="3"></td>
            
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Tipo Compra Combustible</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['boleta']; ?>
</td>
        <td class="grilla-tab-fila-campo" colspan="3"></td>
            
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' width="20%">Periodo</td>
        <td class="grilla-tab-fila-titulo" align='center' width="20%" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['mes']; ?>
 - <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
</td>
        <td class="grilla-tab-fila-campo" colspan="3"></td>
            
    </tr>
        <tr>
            <td class="grilla-tab-fila-campo" align='center' width="20%" ></td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >93</td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >95</td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >97</td>
            <td class="grilla-tab-fila-campo" align='center' width="20%" >PD</td>
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
                    <td class="grilla-tab-fila-campo" 
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] == 'Totales'): ?>
                    	
                    	<?php endif; ?>
                    align='left'>
						<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo']; ?>

                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] == 'Totales'): ?>
                    	
                    	<?php endif; ?>
                    align='left'>
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
    	                    <a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo']; ?>
&depto=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['depto']; ?>
&empresa=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['empresa']; ?>
&octanaje=93&inicio=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['inicio']; ?>
&fin=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['fin']; ?>
', 'Muestra Detalle', 800, 600, null);">
                        <?php endif; ?>
                        <?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['primero']; ?>

                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
	                        </a>
                        <?php endif; ?>
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] == 'Totales'): ?>
                    	
                    	<?php endif; ?>
                    align='left'>
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
	                    	<a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo']; ?>
&depto=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['depto']; ?>
&empresa=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['empresa']; ?>
&octanaje=95&inicio=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['inicio']; ?>
&fin=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['fin']; ?>
', 'Muestra Detalle', 800, 600, null);">
						<?php endif; ?>
						<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['segundo']; ?>

                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
                        	</a>
						<?php endif; ?>
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] == 'Totales'): ?>
                    	
                    	<?php endif; ?>
                    align='left'>
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
                    	<a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo']; ?>
&depto=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['depto']; ?>
&empresa=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['empresa']; ?>
&octanaje=97&inicio=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['inicio']; ?>
&fin=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['fin']; ?>
', 'Muestra Detalle', 800, 600, null);">
						<?php endif; ?>
						<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tercero']; ?>

                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
                        	</a>
						<?php endif; ?>
                    </td>
                    <td class="grilla-tab-fila-campo" 
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] == 'Totales'): ?>
                    	
                    	<?php endif; ?>
                    align='left'>
                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
                    	<a href="#" onclick="showPopWin('sg_estado_cuenta_detalle.php?tipo=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo']; ?>
&depto=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['depto']; ?>
&empresa=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['empresa']; ?>
&octanaje=PD&inicio=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['inicio']; ?>
&fin=<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['fin']; ?>
', 'Muestra Detalle', 800, 600, null);">
						<?php endif; ?>
						<?php echo $this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['cuarto']; ?>

                    	<?php if ($this->_tpl_vars['arrRegistros_detalle'][$this->_sections['detalle']['index']]['tipo'] != 'Totales'): ?>
                        	</a>
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
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto; text-align: center;"></iframe>
    </td>
</tr>
</table>
</div>



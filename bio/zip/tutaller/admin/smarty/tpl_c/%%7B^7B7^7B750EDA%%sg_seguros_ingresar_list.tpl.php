<?php /* Smarty version 2.6.18, created on 2014-10-14 16:13:49
         compiled from sg_seguros_ingresar_list.tpl */ ?>
<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='left'>Patente</td>
        <td class="grilla-tab-fila-titulo" align='left'>Nro Poliza</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2">Octubre</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Noviembre</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Diciembre</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Enero</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Febrero</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Marzo</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Abril</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Mayo</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Junio</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Julio</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Agosto</td>
        <td class="grilla-tab-fila-titulo" align='left' colspan="2" >Septiembre</td>
        <td class="grilla-tab-fila-titulo" align='left'>Total</td>
                <td class="grilla-tab-fila-titulo" align='left'>Vehiculo</td>
                <td class="grilla-tab-fila-titulo" align='left'>A&ntilde;o</td>
                <td class="grilla-tab-fila-titulo" align='left'>Modelo</td>
            </tr>
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
    <tr>
        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
</td>
        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['poliza']; ?>
</td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),10,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="10_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_oct']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),10,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="10_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_oct']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),11,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="11_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_nov']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  
       onclick="xajax_Traevalor(xajax.getFormValues('Form1'),11,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" 
       					<?php endif; ?>  id="11_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_nov']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),12,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="12_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_dic']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  
       onclick="xajax_Traevalor(xajax.getFormValues('Form1'),12,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" 
       					<?php endif; ?>  id="12_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_dic']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'><a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?> onclick="xajax_Traevalor(xajax.getFormValues('Form1'),1,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?> id="1_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_ene']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),1,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="1_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_ene']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'><a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?> onclick="xajax_Traevalor(xajax.getFormValues('Form1'),2,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="2_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_feb']; ?>
 </a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),2,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="2_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_feb']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),3,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="3_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_mar']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),3,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="3_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_mar']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#"  <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?> onclick="xajax_Traevalor(xajax.getFormValues('Form1'),4,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="4_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_abr']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),4,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="4_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_abr']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#"  <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?> onclick="xajax_Traevalor(xajax.getFormValues('Form1'),5,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="5_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_may']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),5,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="5_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_may']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),6,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="6_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_jun']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),6,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="6_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_jun']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),7,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="7_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_jul']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),7,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="7_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_jul']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),8,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="8_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_ago']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),8,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="8_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_ago']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'>	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>   onclick="xajax_Traevalor(xajax.getFormValues('Form1'),9,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="9_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto_pagado_sep']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='left'>	
        	<a href="#" <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente'] != 'Totales'): ?>  onclick="xajax_Traevalor(xajax.getFormValues('Form1'),9,'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
')" <?php endif; ?>  id="9_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
">	
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura_sep']; ?>

			</a>
		</td>
        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['total']; ?>
</td>
		        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['vehiculo']; ?>
</td>
		        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
</td>
		        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['modelo']; ?>
</td>
	</tr>
<?php endfor; endif; ?>
<tr>
	<td colspan='32' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


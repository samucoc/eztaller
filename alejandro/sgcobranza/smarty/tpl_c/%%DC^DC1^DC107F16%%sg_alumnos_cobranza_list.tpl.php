<?php /* Smarty version 2.6.18, created on 2017-03-15 21:06:16
         compiled from sg_alumnos_cobranza_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_alumnos_cobranza_list.tpl', 79, false),array('modifier', 'number_format', 'sg_alumnos_cobranza_list.tpl', 99, false),)), $this); ?>
<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Apoderado</td>
	<td class="grilla-tab-fila-campo" align='left'>
    	<?php echo $this->_tpl_vars['apoderado']; ?>
 - 
        <?php echo $this->_tpl_vars['telefono_apoderado']; ?>
 - 
        <a href="mailto:<?php echo $this->_tpl_vars['email_apoderado']; ?>
" target="_top"><?php echo $this->_tpl_vars['email_apoderado']; ?>
</a>
    </td>
    <td class="grilla-tab-fila-titulo" >
        Enviar Reporte Via Email
    </td>
    <td class="grilla-tab-fila-campo" align='left'>
        <select id="enviar_correo" name="enviar_correo" onchange="xajax_EnviarCorreoAlumno(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['curso']; ?>
','<?php echo $this->_tpl_vars['alumno']; ?>
','<?php echo $this->_tpl_vars['email_apoderado']; ?>
');" >
            <option>Seleccione</option>
            <option value="1">Cartola</option>
            <option value="2">Pagos</option>
            <option value="3">Gestion Cobranza</option>
        </select>
    </td>
    
</tr>
</table>
		<div style="width:50%; float:left">

        <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
                <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
            </tr>
            <?php unset($this->_sections['registros']);
$this->_sections['registros']['name'] = 'registros';
$this->_sections['registros']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosAlumnos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            	<?php if ($this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['matriculado'] == '0'): ?>        
            		<tr>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="#" onclick="showPopWin('sg_alumnos_matriculados.php?rut_alumno=<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['rut_alumno']; ?>
', 'Ingresar Matricula', 800, 600, null)" >
                        	<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['alumnos']; ?>

                        </a>
                    </td>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="#" onclick="showPopWin('sg_alumnos_matriculados.php?rut_alumno=<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['rut_alumno']; ?>
', 'Ingresar Matricula', 800, 600, null)" >
                    		<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['curso']; ?>

                    	</a>    
                    </td>
                    </tr>
            	
				<?php else: ?>
                    <tr>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="sg_alumnos_cobranza.php?rut_alumno=<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['rut_alumno']; ?>
">
                        	<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['alumnos']; ?>

                        </a>
                    </td>
                    <td class="grilla-tab-fila-campo" align='left'>
                    	<a href="sg_alumnos_cobranza.php?rut_alumno=<?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['rut_alumno']; ?>
">
	                        <?php echo $this->_tpl_vars['arrRegistrosAlumnos'][$this->_sections['registros']['index']]['curso']; ?>

                    	</a>    
                    </td>
                    </tr>
            	<?php endif; ?>
            <?php endfor; endif; ?>
            <tr>
 	           <td class="grilla-tab-fila-campo" align='left' colspan="2">&nbsp;</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Alumno</td>
               <td class="grilla-tab-fila-campo" align='left'>
               		<a href="#" onclick="xajax_FichaAlumno(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['rut_alumno']; ?>
);" >
		               	<?php echo $this->_tpl_vars['alumno']; ?>

                    </a>
               </td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Curso</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['curso']; ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Fecha Nacimiento</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['fecha_alumno'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Direccion</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['direccion']; ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Telefono</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['telefono']; ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Correo</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['email']; ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Tipo Beca</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['tipo_beca']; ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Beca Colegiatura 0</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['porc_beca_incor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
            </tr>
            <tr>
 	           <td class="grilla-tab-fila-titulo" align='left'>Beca Colegiatura</td>
               <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['porc_beca_colegiatura'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
            </tr>
        </table>
		</div>
		<div style="width:50%; float:left">
            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
                <td class="grilla-tab-fila-titulo" align='center'>Nro Cuota</td>
                <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pactado</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pagado</td>
                <td class="grilla-tab-fila-titulo" align='center'>Saldo</td>
                <td class="grilla-tab-fila-titulo" align='center'>Acciones</td>
            
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
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>
                    >
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>
                        ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_cuota']; ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>
                    ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>
                    ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['pactado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>
                    ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valorpagado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>
                    ><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['saldo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
                    <td class="grilla-tab-fila-campo" align='left'
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        style="background-color: #ffe6e6"
                        <?php else: ?>

                        <?php endif; ?>

                    >
                        <a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['id_ctacte']; ?>
)">
                        	<img src="../images/basicos/eliminar.png" title="Eliminar" alt="Eliminar" width="24" height="24"/>
                        </a>
                        <a href="#" onclick="xajax_Modificar(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['id_ctacte']; ?>
)">
                        	<img src="../images/basicos/modificar.png" title="Modificar" alt="Modificar" width="24" height="24"/>
                        
                        </a>
                        <!--
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque'] == 'SI'): ?>
                        <a href="#" onclick="xajax_PagarMov(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['boleta']; ?>
)">
                            <img src="../images/fin_comp/pago.png" title="Pagar Cheque" alt="Pagar Cheque" width="24" height="24"/>
                        </a>
                        <?php endif; ?>
                        -->
                    </td>
                    </tr>
            <?php endfor; endif; ?>
            </table>
            </div>
            <br style="clear:both"/>
            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="grilla-tab-fila-titulo" >Tipo</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="hidden" name="ctacte_ncorr" id="ctacte_ncorr"/>
                        <select id="tipo_pago" name="tipo_pago">
                            <option value="1">Incorporacion</option>
                            <option value="2">Colegiatura</option>
                        </select>
                    </td>
                    <td class="grilla-tab-fila-titulo" >Nro Cuenta</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="nro_cuenta" id="nro_cuenta"/>
                    </td>
                    <td class="grilla-tab-fila-titulo" >Fecha pago</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="fecha_pago" id="fecha_pago"/>
                    </td>
                </tr>
                <tr>
                    <td class="grilla-tab-fila-titulo" >Pactado</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="pactado" id="pactado"/>
                    </td>
                    <td class="grilla-tab-fila-titulo" >Pagado</td>
                    <td class="grilla-tab-fila-titulo" >
                        <input type="text" name="pagado" id="pagado"/>
                    </td>
                    <td class="grilla-tab-fila-titulo" colspan="2">
                        <a href="#" name="btnGuardar" id="btnGuardar" onclick="xajax_GuardarPago(xajax.getFormValues('Form1'))">
                        	<img src="../images/basicos/agregar.png" title="Agregar Cuota" alt="Agregar Cuota" width="24" height="24"/>
                        </a>
                    </td>
                </tr>

            </table>
		</div>
</div>



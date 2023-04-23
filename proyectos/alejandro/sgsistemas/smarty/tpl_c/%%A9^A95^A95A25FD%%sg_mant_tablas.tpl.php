<?php /* Smarty version 2.6.18, created on 2011-01-19 16:20:28
         compiled from sg_mant_tablas.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			
	</HEAD>
	<body onload="xajax_CargaPagina(xajax.getFormValues('Form1'));" style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			
			<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 85%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left" valign="middle">
									<td style="width: 7%" align='right'><img src="../images/Database-Add-48.png"></td>
									<td style="width: 93%">
										<label class="form-titulo">
											&nbsp;&nbsp; <?php echo $this->_tpl_vars['TITULO_TABLA']; ?>

											<INPUT type="hidden" id="txtTabla" name="txtTabla" value='<?php echo $this->_tpl_vars['TABLA']; ?>
'>
										</label>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								
								<tr align="left">
									<td class="tabla-alycar-label" style="width: 30%">Código:</td>
									<td class="tabla-alycar-texto" style="width: 70%">
										<INPUT type="text" id="txtNcorr" name="txtNcorr" size="10" readonly>
										&nbsp;
										<label class="comentario">Se Asignará Automáticamente</label>
									</td>
								</tr>
								
								<?php unset($this->_sections['campos']);
$this->_sections['campos']['name'] = 'campos';
$this->_sections['campos']['loop'] = is_array($_loop=$this->_tpl_vars['arrCampos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['campos']['show'] = true;
$this->_sections['campos']['max'] = $this->_sections['campos']['loop'];
$this->_sections['campos']['step'] = 1;
$this->_sections['campos']['start'] = $this->_sections['campos']['step'] > 0 ? 0 : $this->_sections['campos']['loop']-1;
if ($this->_sections['campos']['show']) {
    $this->_sections['campos']['total'] = $this->_sections['campos']['loop'];
    if ($this->_sections['campos']['total'] == 0)
        $this->_sections['campos']['show'] = false;
} else
    $this->_sections['campos']['total'] = 0;
if ($this->_sections['campos']['show']):

            for ($this->_sections['campos']['index'] = $this->_sections['campos']['start'], $this->_sections['campos']['iteration'] = 1;
                 $this->_sections['campos']['iteration'] <= $this->_sections['campos']['total'];
                 $this->_sections['campos']['index'] += $this->_sections['campos']['step'], $this->_sections['campos']['iteration']++):
$this->_sections['campos']['rownum'] = $this->_sections['campos']['iteration'];
$this->_sections['campos']['index_prev'] = $this->_sections['campos']['index'] - $this->_sections['campos']['step'];
$this->_sections['campos']['index_next'] = $this->_sections['campos']['index'] + $this->_sections['campos']['step'];
$this->_sections['campos']['first']      = ($this->_sections['campos']['iteration'] == 1);
$this->_sections['campos']['last']       = ($this->_sections['campos']['iteration'] == $this->_sections['campos']['total']);
?>
									<tr align="left">
										<td class="tabla-alycar-label" style="width: 30%"><?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['titulo']; ?>
<label class="requerido"> * </label></td>
										<td class="tabla-alycar-texto" style="width: 70%">
											<?php if (( $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['objeto'] == 'SELECT' )): ?>
												<SELECT id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" onKeyPress="return Tabula(this, event, 0)"></SELECT>
											<?php else: ?>
												<INPUT type="text" id="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" name="OBLI<?php echo $this->_tpl_vars['arrCampos'][$this->_sections['campos']['index']]['campo']; ?>
" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" size="50">
											<?php endif; ?>

										
										</td>
									</tr>
								
								<?php endfor; endif; ?>
								
								<tr align="left">
									<td colspan="6" class="tabla-alycar-fila-botones">
										<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="javascript: ValidaFormularioMantenedor();">
										<input type="button" name="btnNuevo" value="Nuevo" class="boton" onClick="javascript: document.Form1.submit();" > 
										&nbsp;&nbsp;&nbsp;&nbsp;<label class="requerido"> (*) </label>Informacion Obligatoria
									</td>
								</tr>
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'><div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>
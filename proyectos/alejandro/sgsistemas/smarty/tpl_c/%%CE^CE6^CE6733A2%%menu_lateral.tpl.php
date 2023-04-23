<?php /* Smarty version 2.6.18, created on 2010-08-13 20:15:52
         compiled from menu_lateral.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<?php echo $this->_tpl_vars['xajax_js']; ?>

	
	<title>Menu</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body onload="xajax_CargaInicial(xajax.getFormValues('Form1'));"style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">

		<div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
		
			<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
				<tr>
					<td>
						<table border="0" class="tabla-alycar-menu" cellpadding="0" cellspacing="0" style="width: 100%">
							<tr align="left">
								<td class="tabla-alycar-fila-informa-requerida-contrato-cabecera">
									<div style="cursor: pointer" onclick="xajax_Link(xajax.getFormValues('Form1'));"><?php echo $this->_tpl_vars['TITULO_MENU']; ?>
</div>
								</td>
							</tr>
						</table>
						<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
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
								<tr align="left">		
									<td class="tabla-alycar-label" style="width: 30%"><a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['link']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>
								</tr>
							<?php endfor; endif; ?>
						</table>
					</td>
				</tr>
			</table>
			
		</div>
	</form>
		

</body>
</html>
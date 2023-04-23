<?php /* Smarty version 2.6.18, created on 2016-04-11 20:43:41
         compiled from menu_superior.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<?php echo $this->_tpl_vars['xajax_js']; ?>

	
	<title>Menu</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">
		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
			<tr>
				<td>
					<table border="0" class="tabla-alycar-menu" cellpadding="0" cellspacing="0" style="width: 100%">
						<tr align="left">
							<td colspan="<?php echo $this->_tpl_vars['contador']; ?>
">
								<?php echo '
								<style>
			                        #menu_gral ul li {
			                            width: 10% !important;
			                            }
			                        #menu_gral ul li ul li:hover, #menu_gral ul li ul li{
			                            width: 100% !important;
			                            }
			                            a.disabled {
										  pointer-events: none;
										}

										a:hover {
										  color: #000000;
										}

										a {
										  color: #000000;
										  font-size: 15px;
										}
										a:hover{
										  background-color: #C3E7F2;
										}

										.side-nav li a:not(.button) {
										  color: #447CAD;
										}

										.side-nav li a:not(.button):hover {
										  color: #447CAD;
										}
										* {
										    margin: 0;
										    padding: 0;
										    border: none;
										    position: relative;
										}
										#menu_gral {
										    font-family: sans-serif;
										    width: 100%;
										    margin: 1.5rem auto;
										    height: 30px;
										}
										#menu_gral ul {
										    list-style-type: none; 
										    text-align:center;
										    font-size: 0;
										}
										#menu_gral > ul li {
										    display: inline-block;
										    width: 16.6%;
										    position: relative;
										    background: #E7ECF1;

										}
										#menu_gral li a {
										  background:#447CAD;
										    display: block;
										    width: 100%;
										    text-decoration: none;
										    padding-left: 10px;
										    padding-right: 10px;
										    color: #ffffff;
										}
										#menu_gral ul li ul li a {
										  background:#447CAD;
										    display: block;
										    width: 300%;
										    text-decoration: none;
										    padding-left: 10px;
										    padding-right: 10px;
										    color: #ffffff!important;
										    text-align: left;
										}
										#menu_gral li:hover a, #menu_gral li a:focus {
										  /* color de cada menu al poner el mouse encima*/
										    width: 100%;
										    background: #E7ECF1;
										    color:#1B4978;
										}

										#menu_gral li ul {
										    position: absolute;
										    width: 0;
										    overflow: hidden;
										}
										#menu_gral li:hover ul, #menu_gral li:focus ul {
										  /* es el fondo de color debajo de los submenus*/
										    width: 129%;
										    margin: 0 -4rem -4rem -4rem;
										    padding: 0 4rem 0rem 4rem;
										    z-index: 5;
										}
										#menu_gral li li {
										    display: block;
										    width: 300%;
										    background-color: #000;
										}
										#menu_gral li:hover li a, #menu_gral li:focus li a {
										    width: 100%;
										    font-family: sans-serif;
										    font-size: .9rem;
										    line-height: 1.7rem;
										    border-top: 1px solid #e5e5e5;
										    background: #447CAD;
										}
										#menu_gral li li a:hover, #menu_gral li li a:focus {
										  color: #1B4978!important;
										    width: 100%;
										    background: #E7ECF1; 
										}
			                    </style>
			                    '; ?>

			                    <div id="menu_gral" style="margin-top: 10px !important;">
				                    <ul>
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
										<li>
		                				<a href='#' ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a>
		                					<ul>
		                				<?php unset($this->_sections['registrosDet']);
$this->_sections['registrosDet']['name'] = 'registrosDet';
$this->_sections['registrosDet']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDet']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDet']['show'] = true;
$this->_sections['registrosDet']['max'] = $this->_sections['registrosDet']['loop'];
$this->_sections['registrosDet']['step'] = 1;
$this->_sections['registrosDet']['start'] = $this->_sections['registrosDet']['step'] > 0 ? 0 : $this->_sections['registrosDet']['loop']-1;
if ($this->_sections['registrosDet']['show']) {
    $this->_sections['registrosDet']['total'] = $this->_sections['registrosDet']['loop'];
    if ($this->_sections['registrosDet']['total'] == 0)
        $this->_sections['registrosDet']['show'] = false;
} else
    $this->_sections['registrosDet']['total'] = 0;
if ($this->_sections['registrosDet']['show']):

            for ($this->_sections['registrosDet']['index'] = $this->_sections['registrosDet']['start'], $this->_sections['registrosDet']['iteration'] = 1;
                 $this->_sections['registrosDet']['iteration'] <= $this->_sections['registrosDet']['total'];
                 $this->_sections['registrosDet']['index'] += $this->_sections['registrosDet']['step'], $this->_sections['registrosDet']['iteration']++):
$this->_sections['registrosDet']['rownum'] = $this->_sections['registrosDet']['iteration'];
$this->_sections['registrosDet']['index_prev'] = $this->_sections['registrosDet']['index'] - $this->_sections['registrosDet']['step'];
$this->_sections['registrosDet']['index_next'] = $this->_sections['registrosDet']['index'] + $this->_sections['registrosDet']['step'];
$this->_sections['registrosDet']['first']      = ($this->_sections['registrosDet']['iteration'] == 1);
$this->_sections['registrosDet']['last']       = ($this->_sections['registrosDet']['iteration'] == $this->_sections['registrosDet']['total']);
?>
		                					<?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['menu_ncorr'] == $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['menu_ncorr'] )): ?>
		                						<li>
												<?php if (( $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_contr'] == 'fancybox' )): ?>
						                            <a href='<?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_link']; ?>
' class='menu_link fancybox.iframe'><?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_desc']; ?>
</a>
						                        <?php else: ?>
						                        	<a href='<?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_link']; ?>
'><?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_desc']; ?>
</a>
						                        <?php endif; ?>
						                        </li>
											<?php endif; ?>								
										<?php endfor; endif; ?>
											</ul>
										</li>
									<?php endfor; endif; ?>
										<li>
				       						<img  src="../images/user.png" border='0'><?php echo $this->_tpl_vars['nombre_usuario']; ?>
 - <?php echo $this->_tpl_vars['anio']; ?>
 - (Financiamiento Compartido)
		            					</li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				<td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="bloque" style="WIDTH: 100%; height:500px ; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
						<iframe name="principal"  id="principal" src="portada.php" frameborder="0" WIDTH="100%" height="600px"></iframe>
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
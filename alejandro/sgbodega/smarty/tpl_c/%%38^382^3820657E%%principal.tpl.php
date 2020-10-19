<?php /* Smarty version 2.6.18, created on 2018-03-14 21:04:38
         compiled from principal.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<?php echo $this->_tpl_vars['xajax_js']; ?>

	
	<title>Sistema Academico - GESCOL</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../../sgcobranza/includes_js/jquery/jquery-1.9.0.min.js"></script>
		<link rel="icon" href="../images/ficha-alumno.ico" type="image/x-icon" />	

</head>

<body style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">
		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
			<tr>
				<td colspan="<?php echo $this->_tpl_vars['contador']; ?>
">
					<?php echo '
					<style>
	                    #menu_gral ul li {
	                '; ?>

	                        width: <?php echo $this->_tpl_vars['tamano']; ?>
% !important;
	                <?php echo '
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
						  font-size: 12px;

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
						/*
						* {
						    margin: 0;
						    padding: 0;
						    border: none;
						    position: relative;
						}
						#menu_gral {
						    width: 100%;
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
						    padding-top: 3px;
						    padding-bottom: 3px;
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
						    line-height: 1.7rem;
						    border-top: 1px solid #e5e5e5;
						    background: #447CAD;
						}
						#menu_gral li li a:hover, #menu_gral li li a:focus {
						  color: #1B4978!important;
						    width: 100%;
						    background: #E7ECF1; 
						}
						#menu_gral li:hover > ul {
						    visibility: visible;
						    opacity: 1;
						    -webkit-transform: translateY(0px);
						    -moz-transform: translateY(0px);
						    -o-transform: translateY(0px);
						    -ms-transform: translateY(0px);
						    transform: translateY(0px);
						    -webkit-transition: all 0.3s ease-out;   
						    -moz-transition: all 0.3s ease-out;
						    -o-transition: all 0.3s ease-out;
						    -ms-transition: all 0.3s ease-out;
						    transition: all 0.3s ease-out;
						}
						#menu_gral li ul li {
						    position: relative;
						}
						#menu_gral li ul li ul {
						    right: -275px;
							}
						#menu_gral a.login{
							color:#000;
							background: #fff; 
							font-size:7px; 
							padding-left:20px;
							}
						*/

							* {
								margin:0px;
								padding:0px;
							}
							
							#menu_gral {
								margin:auto;
								width:100%;
								font-family:Arial, Helvetica, sans-serif;
								text-align: left;
							}
							
							ul, ol {
								list-style:none;
							}
							
							.nav > li {
								float:left;
							}
							
							.nav li a {
								background-color:#447CAD;
								color:#fff;
								text-decoration:none;
								padding:10px 12px;
								display:block;
							}
							
							.nav li a:hover {
								background-color:#434343;
							}
							
							.nav li ul {
								display:none;
								position:absolute;
								min-width:275px;
							}
							
							.nav li:hover > ul {
								display:block;
							}
							
							.nav li ul li {
								position:relative;
							}
							
							.nav li ul li ul {
								right:-275px;
								top:0px;
							}
							
						@media (min-width: 1900px) {
						    #principal {
						    	height: 900px;
						    }
						  }
						@media (min-width: 1600px) and (max-width: 1900px) {
						    #principal {
						    	height: 850px;
						    }
						  }
						@media (min-width: 1440px) and (max-width: 1600px) {
						    #principal {
						    	height: 780px;
						    }
						  }
						@media (min-width: 1360px) and (max-width: 1440px) {
						    #principal {
						    	height: 715px;
						    }
						  }
						@media (min-width: 1280px) and (max-width: 1360px) {
						    #principal {
						    	height: 650px;
						    }
						  }
						@media (min-width: 800px) and (max-width: 1280px) {
						    #principal {
						    	height: 575px;
						    }
						  }
	                </style>
	                '; ?>


	                <div id="menu_gral" >
	                    <ul class="nav">
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
			                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_link']; ?>
')" class='menu_link fancybox.iframe'>
			                            <?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_desc']; ?>
</a>
			                           	
			                           	<?php unset($this->_sections['registrosDet_1']);
$this->_sections['registrosDet_1']['name'] = 'registrosDet_1';
$this->_sections['registrosDet_1']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDet_1']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDet_1']['show'] = true;
$this->_sections['registrosDet_1']['max'] = $this->_sections['registrosDet_1']['loop'];
$this->_sections['registrosDet_1']['step'] = 1;
$this->_sections['registrosDet_1']['start'] = $this->_sections['registrosDet_1']['step'] > 0 ? 0 : $this->_sections['registrosDet_1']['loop']-1;
if ($this->_sections['registrosDet_1']['show']) {
    $this->_sections['registrosDet_1']['total'] = $this->_sections['registrosDet_1']['loop'];
    if ($this->_sections['registrosDet_1']['total'] == 0)
        $this->_sections['registrosDet_1']['show'] = false;
} else
    $this->_sections['registrosDet_1']['total'] = 0;
if ($this->_sections['registrosDet_1']['show']):

            for ($this->_sections['registrosDet_1']['index'] = $this->_sections['registrosDet_1']['start'], $this->_sections['registrosDet_1']['iteration'] = 1;
                 $this->_sections['registrosDet_1']['iteration'] <= $this->_sections['registrosDet_1']['total'];
                 $this->_sections['registrosDet_1']['index'] += $this->_sections['registrosDet_1']['step'], $this->_sections['registrosDet_1']['iteration']++):
$this->_sections['registrosDet_1']['rownum'] = $this->_sections['registrosDet_1']['iteration'];
$this->_sections['registrosDet_1']['index_prev'] = $this->_sections['registrosDet_1']['index'] - $this->_sections['registrosDet_1']['step'];
$this->_sections['registrosDet_1']['index_next'] = $this->_sections['registrosDet_1']['index'] + $this->_sections['registrosDet_1']['step'];
$this->_sections['registrosDet_1']['first']      = ($this->_sections['registrosDet_1']['iteration'] == 1);
$this->_sections['registrosDet_1']['last']       = ($this->_sections['registrosDet_1']['iteration'] == $this->_sections['registrosDet_1']['total']);
?>
			                           	<?php if (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['menu_ncorr'] == $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['menu_ncorr'] ) && ( $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['menu_sub'] == $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['menu_sub'] ) )): ?>
		                						<li>
												<?php if (( $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_contr'] == 'fancybox' )): ?>
						                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_link']; ?>
')" class='menu_link fancybox.iframe'><?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_desc']; ?>
</a>
						                        <?php else: ?>
						                        	<a href='<?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_link']; ?>
'><?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_desc']; ?>
</a>
						                        <?php endif; ?>
						                        </li>
											<?php endif; ?>								
										<?php endfor; endif; ?>

			                        <?php else: ?>
			                        	<a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_link']; ?>
')"><?php echo $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['mhij_desc']; ?>
</a>
			                        	<ul>
			                        	<?php unset($this->_sections['registrosDet_1']);
$this->_sections['registrosDet_1']['name'] = 'registrosDet_1';
$this->_sections['registrosDet_1']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDet_1']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDet_1']['show'] = true;
$this->_sections['registrosDet_1']['max'] = $this->_sections['registrosDet_1']['loop'];
$this->_sections['registrosDet_1']['step'] = 1;
$this->_sections['registrosDet_1']['start'] = $this->_sections['registrosDet_1']['step'] > 0 ? 0 : $this->_sections['registrosDet_1']['loop']-1;
if ($this->_sections['registrosDet_1']['show']) {
    $this->_sections['registrosDet_1']['total'] = $this->_sections['registrosDet_1']['loop'];
    if ($this->_sections['registrosDet_1']['total'] == 0)
        $this->_sections['registrosDet_1']['show'] = false;
} else
    $this->_sections['registrosDet_1']['total'] = 0;
if ($this->_sections['registrosDet_1']['show']):

            for ($this->_sections['registrosDet_1']['index'] = $this->_sections['registrosDet_1']['start'], $this->_sections['registrosDet_1']['iteration'] = 1;
                 $this->_sections['registrosDet_1']['iteration'] <= $this->_sections['registrosDet_1']['total'];
                 $this->_sections['registrosDet_1']['index'] += $this->_sections['registrosDet_1']['step'], $this->_sections['registrosDet_1']['iteration']++):
$this->_sections['registrosDet_1']['rownum'] = $this->_sections['registrosDet_1']['iteration'];
$this->_sections['registrosDet_1']['index_prev'] = $this->_sections['registrosDet_1']['index'] - $this->_sections['registrosDet_1']['step'];
$this->_sections['registrosDet_1']['index_next'] = $this->_sections['registrosDet_1']['index'] + $this->_sections['registrosDet_1']['step'];
$this->_sections['registrosDet_1']['first']      = ($this->_sections['registrosDet_1']['iteration'] == 1);
$this->_sections['registrosDet_1']['last']       = ($this->_sections['registrosDet_1']['iteration'] == $this->_sections['registrosDet_1']['total']);
?>
			                           	<?php if (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['menu_ncorr'] == $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['menu_ncorr'] ) && ( $this->_tpl_vars['arrRegistrosDet'][$this->_sections['registrosDet']['index']]['menu_sub'] == $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['menu_sub'] ) )): ?>
		                						<li>
												<?php if (( $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_contr'] == 'fancybox' )): ?>
						                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_link']; ?>
')" class='menu_link fancybox.iframe'><?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_desc']; ?>
</a>
						                        <?php else: ?>
						                        	<a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_link']; ?>
')"><?php echo $this->_tpl_vars['arrRegistrosDet_1'][$this->_sections['registrosDet_1']['index']]['mhij_desc']; ?>
</a>
						                        <?php endif; ?>
						                        </li>
											<?php endif; ?>								
										<?php endfor; endif; ?>
										</ul>
			                        <?php endif; ?>
			                        </li>
								<?php endif; ?>								
							<?php endfor; endif; ?>
								</ul>
							</li>
						<?php endfor; endif; ?>
						<li>
							<?php if ($this->_tpl_vars['nombre_usuario'] == 'SIGE'): ?>
			            		<!--<a href='sg_cambio_sgcobranza.php' style='color:black; background-color:white; float: left; width:3%'>
			            			<img src="../images/fin_comp/pago-voluntario.png" width="16" title="Financiamiento Compartido">
			            		</a>-->		
			            		<a href='#' style='color:black; background-color:white; float: left; width:65%; margin: 0 !important; padding: 8px !important;' onclick="xajax_Carga(xajax.getFormValues('Form1'),'portada.php')">
					            		<?php echo $this->_tpl_vars['nombre_usuario']; ?>
 - <?php echo $this->_tpl_vars['anio']; ?>

					            </a>				            		
			            	<?php else: ?>
				            	<a href='#' style='color:black; background-color:white; ' onclick="xajax_Carga(xajax.getFormValues('Form1'),'portada.php')">
				            		<?php echo $this->_tpl_vars['nombre_usuario']; ?>
 - <?php echo $this->_tpl_vars['anio']; ?>

				            	</a>
				            <?php endif; ?>
			            </li>
						</ul>
					</div>
				<td>
			</tr>
			<tr>
				<td colspan="<?php echo $this->_tpl_vars['contador']; ?>
">
					<div id="bloque" style="WIDTH: 100%; height: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
						<iframe name="principal"  id="principal" src="portada.php" frameborder="0" WIDTH="100%" ></iframe>
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
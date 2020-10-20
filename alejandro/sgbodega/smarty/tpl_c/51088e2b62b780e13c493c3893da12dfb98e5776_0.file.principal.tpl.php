<?php
/* Smarty version 3.1.33, created on 2020-10-19 12:21:45
  from 'C:\xampp\htdocs\eztaller\eztaller\alejandro\sgbodega\smarty\tpl\principal.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5f8daf097d0635_63884277',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '51088e2b62b780e13c493c3893da12dfb98e5776' => 
    array (
      0 => 'C:\\xampp\\htdocs\\eztaller\\eztaller\\alejandro\\sgbodega\\smarty\\tpl\\principal.tpl',
      1 => 1603077408,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f8daf097d0635_63884277 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<?php echo $_smarty_tpl->tpl_vars['xajax_js']->value;?>

	
	<title>Portal Prototipo</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		<?php echo '<script'; ?>
 type="text/javascript" src="../../sgcobranza/includes_js/jquery/jquery-1.9.0.min.js"><?php echo '</script'; ?>
>
		<link rel="icon" type="image/x-icon" sizes="32x32" rel="shortcut icon" href="../images/favicon.ico">

</head>

<body style="background:#ffffff;" onload="__set_timeout_timer();"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">
		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
			<tr>
				<td colspan="<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
">
					
					<style>
	                    #menu_gral ul li {
	                
	                        width: <?php echo $_smarty_tpl->tpl_vars['tamano']->value;?>
% !important;
	                
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
					<?php echo '<script'; ?>
 type="text/javascript">
						var _lock_timer;
						var __light_logger;

						__set_timeout_timer = function() {
						clearTimeout(_lock_timer);
						if(typeof(__light_logger)=='undefined' || __light_logger==null)
						  _lock_timer = setTimeout( bloquear_ventana , 1800000 ); // milisegundos
						  // por defecto 1800000 [ms] (15 minutos)
						}

						document.onmousemove = __set_timeout_timer;		

						bloquear_ventana = function() {
						    location.href='../';
						}

					<?php echo '</script'; ?>
>
	                

	                <div id="menu_gral" >
	                    <ul class="nav">
						<?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
							<li>
	        				<a href='#' ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['descripcion'];?>
</a>
	        					<ul>
	        				<?php
$__section_registrosDet_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDet']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDet_1_total = $__section_registrosDet_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDet'] = new Smarty_Variable(array());
if ($__section_registrosDet_1_total !== 0) {
for ($__section_registrosDet_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] = 0; $__section_registrosDet_1_iteration <= $__section_registrosDet_1_total; $__section_registrosDet_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']++){
?>
            					<?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['menu_ncorr'] == $_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['menu_ncorr'])) {?>
            						<li>
									<?php if (($_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['mhij_contr'] == 'fancybox')) {?>
			                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['mhij_link'];?>
')" class='menu_link fancybox.iframe'>
			                            <?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['mhij_desc'];?>
</a>
			                           	
			                           	<?php
$__section_registrosDet_1_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDet_1_2_total = $__section_registrosDet_1_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1'] = new Smarty_Variable(array());
if ($__section_registrosDet_1_2_total !== 0) {
for ($__section_registrosDet_1_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] = 0; $__section_registrosDet_1_2_iteration <= $__section_registrosDet_1_2_total; $__section_registrosDet_1_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']++){
?>
			                           	<?php if ((($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['menu_ncorr'] == $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['menu_ncorr']) && ($_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['menu_sub'] == $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['menu_sub']))) {?>
		                						<li>
												<?php if (($_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_contr'] == 'fancybox')) {?>
						                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['mhij_link'];?>
')" class='menu_link fancybox.iframe'><?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_desc'];?>
</a>
						                        <?php } else { ?>
						                        	<a href='<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_link'];?>
'><?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_desc'];?>
</a>
						                        <?php }?>
						                        </li>
											<?php }?>								
										<?php
}
}
?>

			                        <?php } else { ?>
			                        	<a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['mhij_link'];?>
')"><?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['mhij_desc'];?>
</a>
			                        	<ul>
			                        	<?php
$__section_registrosDet_1_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDet_1_3_total = $__section_registrosDet_1_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1'] = new Smarty_Variable(array());
if ($__section_registrosDet_1_3_total !== 0) {
for ($__section_registrosDet_1_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] = 0; $__section_registrosDet_1_3_iteration <= $__section_registrosDet_1_3_total; $__section_registrosDet_1_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']++){
?>
			                           	<?php if ((($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['menu_ncorr'] == $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['menu_ncorr']) && ($_smarty_tpl->tpl_vars['arrRegistrosDet']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet']->value['index'] : null)]['menu_sub'] == $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['menu_sub']))) {?>
		                						<li>
												<?php if (($_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_contr'] == 'fancybox')) {?>
						                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_link'];?>
')" class='menu_link fancybox.iframe'><?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_desc'];?>
</a>
						                        <?php } else { ?>
						                        	<a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_link'];?>
')"><?php echo $_smarty_tpl->tpl_vars['arrRegistrosDet_1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDet_1']->value['index'] : null)]['mhij_desc'];?>
</a>
						                        <?php }?>
						                        </li>
											<?php }?>								
										<?php
}
}
?>
										</ul>
			                        <?php }?>
			                        </li>
								<?php }?>								
							<?php
}
}
?>
								</ul>
							</li>
						<?php
}
}
?>
						<li>
			            	<a href='#' style='color:black; background-color:white; ' onclick="xajax_Carga(xajax.getFormValues('Form1'),'portada.php')">
			            		<?php echo $_smarty_tpl->tpl_vars['nombre_usuario']->value;?>
 
			            	</a>
			            </li>
						</ul>
					</div>
				<td>
			</tr>
			<tr>
				<td colspan="<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
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
<?php }
}

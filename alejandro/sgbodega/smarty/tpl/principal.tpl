<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	{$xajax_js}
	
	<title>Portal Prototipo</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../../sgcobranza/includes_js/jquery/jquery-1.9.0.min.js"></script>
		<link rel="icon" type="image/x-icon" sizes="32x32" rel="shortcut icon" href="../images/favicon.ico">

</head>

<body style="background:#ffffff;" onload="__set_timeout_timer();"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">
		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
			<tr>
				<td colspan="{$contador}">
					{literal}
					<style>
	                    #menu_gral ul li {
	                {/literal}
	                        width: {$tamano}% !important;
	                {literal}
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
					<script type="text/javascript">
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

					</script>
	                {/literal}

	                <div id="menu_gral" >
	                    <ul class="nav">
						{section name=registros loop=$arrRegistros}
							<li>
	        				<a href='#' >{$arrRegistros[registros].descripcion}</a>
	        					<ul>
	        				{section name=registrosDet loop=$arrRegistrosDet}
            					{if ($arrRegistros[registros].menu_ncorr==$arrRegistrosDet[registrosDet].menu_ncorr)}
            						<li>
									{if ($arrRegistrosDet[registrosDet].mhij_contr=='fancybox')}
			                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistrosDet[registrosDet].mhij_link}')" class='menu_link fancybox.iframe'>
			                            {$arrRegistrosDet[registrosDet].mhij_desc}</a>
			                           	
			                           	{section name=registrosDet_1 loop=$arrRegistrosDet_1}
			                           	{if (($arrRegistros[registros].menu_ncorr==$arrRegistrosDet_1[registrosDet_1].menu_ncorr) &&($arrRegistrosDet[registrosDet].menu_sub==$arrRegistrosDet_1[registrosDet_1].menu_sub))}
		                						<li>
												{if ($arrRegistrosDet_1[registrosDet_1].mhij_contr=='fancybox')}
						                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistrosDet[registrosDet].mhij_link}')" class='menu_link fancybox.iframe'>{$arrRegistrosDet_1[registrosDet_1].mhij_desc}</a>
						                        {else}
						                        	<a href='{$arrRegistrosDet_1[registrosDet_1].mhij_link}'>{$arrRegistrosDet_1[registrosDet_1].mhij_desc}</a>
						                        {/if}
						                        </li>
											{/if}								
										{/section}

			                        {else}
			                        	<a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistrosDet[registrosDet].mhij_link}')">{$arrRegistrosDet[registrosDet].mhij_desc}</a>
			                        	<ul>
			                        	{section name=registrosDet_1 loop=$arrRegistrosDet_1}
			                           	{if (($arrRegistros[registros].menu_ncorr==$arrRegistrosDet_1[registrosDet_1].menu_ncorr) &&($arrRegistrosDet[registrosDet].menu_sub==$arrRegistrosDet_1[registrosDet_1].menu_sub))}
		                						<li>
												{if ($arrRegistrosDet_1[registrosDet_1].mhij_contr=='fancybox')}
						                            <a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistrosDet_1[registrosDet_1].mhij_link}')" class='menu_link fancybox.iframe'>{$arrRegistrosDet_1[registrosDet_1].mhij_desc}</a>
						                        {else}
						                        	<a href='#' onclick="xajax_Carga(xajax.getFormValues('Form1'),'{$arrRegistrosDet_1[registrosDet_1].mhij_link}')">{$arrRegistrosDet_1[registrosDet_1].mhij_desc}</a>
						                        {/if}
						                        </li>
											{/if}								
										{/section}
										</ul>
			                        {/if}
			                        </li>
								{/if}								
							{/section}
								</ul>
							</li>
						{/section}
						<li>
			            	<a href='#' style='color:black; background-color:white; ' onclick="xajax_Carga(xajax.getFormValues('Form1'),'portada.php')">
			            		{$nombre_usuario} 
			            	</a>
			            </li>
						</ul>
					</div>
				<td>
			</tr>
			<tr>
				<td colspan="{$contador}">
					<div id="bloque" style="WIDTH: 100%; height: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
						<iframe name="principal"  id="principal" src="portada.php" frameborder="0" WIDTH="100%" ></iframe>
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	{$xajax_js}
	
	<title>Tu Taller - v1</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../../sgcobranza/includes_js/jquery/jquery-1.9.0.min.js"></script>
		<link rel="icon" href="../images/ficha-alumno.ico" type="image/x-icon" />	
</head>

<body style="background:#ffffff;"> 
					
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
			            	<a href='#' style='color:black; background-color:white' onclick="xajax_Carga(xajax.getFormValues('Form1'),'portada.php')">
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

            <ul class="menu" id="menu">
                <li><a href="principal.php" class="menulink">Inicio</a>
                    <ul>
                       <?php if ($_SESSION['tipo_usuario']=="0") { ?>
                        <li>
                            <a href="#" class="sub">Parámetros AVR</a>
                            <ul>
                                <li class="topline"><a href="sucursales.php" target="_parent">Sucursales Vigomaq</a></li>
                               <li><a href="familia_rep.php" target="_parent">Familia Repuestos</a></li>
                               <li><a href="familia_equipo.php" target="_parent">Familia Equipos</a></li>
                               <li><a href="estado_equipo.php" target="_parent">Estado Equipo</a></li>
                               <li><a href="tipo_eval.php" target="_parent">Tipo Evaluación</a></li>
                               <li><a href="forma_eval.php" target="_parent">Forma Evaluación</a></li>
                               <li><a href="tarifas.php" target="_parent">Tarifa Despacho</a></li>
                               <li><a href="tipo_cliente.php" target="_parent">Tipo Cliente</a></li>
                               <li><a href="personal.php" target="_parent">Personal</a></li>
                               <li><a href="comuna.php" target="_parent">Comunas</a></li>
                               <li><a href="ciudad.php" target="_parent">Ciudades</a></li>
                               <li><a href="unidades.php" target="_parent">Unidades de medida</a></li>
                               <li><a href="condic_arri.php" target="_parent">Condiciones Arriendo</a></li>
                               <li><a href="tipo_obra.php" target="_parent">Tipo Obra</a></li>
                               <li><a href="tipo_personal.php" target="_parent">Tipo Personal</a></li>
                               <li><a href="forma_pago.php" target="_parent">Forma de Pago</a></li>
                               <li><a href="tipo_garantia.php" target="_parent">Tipo de Garantia</a></li>
                               <li><a href="folios_dte.php" target="_parent">Folios DTE</a></li>
                               <li class="topline"><?php if ($_SESSION['tipo_usuario']=="0") { ?><a href="iva.php">IVA</a><?php } ?></li>
                            </ul>
                       </li>
                    <?php } ?>
                      <li>
                            <a href="#" class="sub">Usuarios AVR</a>
                            <ul>
                            <li class="topline"><?php if ($_SESSION['tipo_usuario']=="0") { ?><a href="listado_us.php">Listado Usuarios</a><?php }else{ ?> <a href="usuario.php">Usuario</a><?php } ?></li>
                            <li class="topline"><?php if ($_SESSION['tipo_usuario']=="0") { ?><a href="list_transacc.php">Listado Transacciones</a><?php } ?></li> 
                          </ul>
                      </li>
                        
                </ul>
                </li>
                <li>
                    <a href="#" class="menulink">Archivos AVR</a>
                    <ul>
                         <li><a href="cliente.php" target="_parent">Clientes/Obra</a></li>
                         <li><a href="proveedor.php" target="_parent">Proveedores</a></li>
                         <li><a href="equipo.php" target="_parent">Inventario Equipos</a></li>
                         <li><a href="repuesto.php" target="_parent">Inventario Repuestos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menulink">Servicios</a>
                    <ul>
                         <li>
                          <a href="#" class="sub">Arriendos</a>
                            <ul>
                               <li class="topline"><a href="arriendo_cliente.php" target="_parent">Arriendo con DTE</a></li>
                               <li><a href="arriendo_cliente_manual.php" target="_parent">Arriendo con GD Manual</a></li>
                               <li><a href="reclamo.php" target="_parent">Reclamo/Cambio Equipo con DTE</a></li>
                               <li><a href="reclamo_manual.php" target="_parent">Reclamo/Cambio Equipo con GD Manual</a></li>
                               <li><a href="evaluacion.php" target="_parent">Evaluación Técnica</a></li>
                               <li><a href="reparar_equipo.php" target="_parent">Reparacion Equipo</a></li>
                              <li><a href="arriendo_devolver.php" target="_parent">Devolver Arriendo</a></li>
                              <li><a href="arriendo_no_devolver.php" target="_parent">Eliminar Devolucion Arriendo</a></li>
                            </ul>
                        <li><a href="factura.php">Ventas</a>
                    </ul>
                    
              <li><a href="#" class="menulink">Facturación</a>
                      <ul>
                         <li><a href="arriendos_fact.php">Equipos por Facturar</a></li>
                         <li><a href="facturas_abiertas.php">Facturas Abiertas</a></li>
                         <li><a href="facturar.php">Emitir Factura</a></li>
                         <li><a href="eliminar_factura.php">Eliminar Factura</a></li>
                         <li><a href="anular.php">Registro Facturas Nulas</a></li>
                         <li><a href="nc.php" target="_parent">Nota de Crédito</a></li>
                         <li><a href="nc_nd.php" target="_parent">Nota de Crédito anula NDB</a></li>
                         <li><a href="eliminar_nc.php">Eliminar Nota de Crédito</a></li>
                         <li><a href="nd.php" target="_parent">Nota de Débito</a></li>
                         <li><a href="nd_nc.php" target="_parent">Nota de Débito anula NCR</a></li>
                         <li><a href="#">Eliminar Nota de Débito</a></li>
                         <li><a href="gd.php">Guia de Despacho con DTE</a></li>
                         <li><a href="gd_nofacturable.php">Guia de Despacho DTE No Facturable</a></li>
                         <li><a href="gd-manual.php">Guia de Despacho Manual</a></li>
                         <li><a href="eliminar_gd.php">Eliminar Guia de Despacho</a></li>
                         <li><a href="anular_gd.php">Registro Guia de Despacho Nulas</a></li>
                      </ul>
              </li>
               <li>
                    <a href="#" class="menulink">Gestión AVR</a>
                    <ul>
                        <li>
                          <a href="#" class="sub">Consultas</a>
                        	<ul>
                            	<li><a href="busca_equipo.php">Consulta Equipos</a></li>
                                <li><a href="busca_rep.php">Consulta Repuestos</a></li>
                                <li><a href="busca_cliente.php">Consulta Clientes</a></li>
                                <li><a href="busca_proveed.php">Consulta Proveedores</a></li>
                                <li><a href="consulta_gd.php" target="_parent">Consulta Guia Despacho</a></li>
                                <li><a href="consulta_eva_tec.php">Consulta Evaluación Técnica</a></li>
                                <li><a href="consulta_repa.php">Consulta Reparación</A></li>
                                <li><a href="consulta_cli_ob_eq.php">Consulta Equipos por Cliente/Obras</A></li>
                                <li><a href="consulta_nc.php">Consulta Notas Crédito</a></li>
                                <li><a href="consulta_nd.php">Consulta Notas Debito</a></li>
                          	</ul>
                    	</li>
                       	<li><a href="hoja_arriendo.php" target="_parent">Hoja de Arriendo</a></li>
                        <li><a href="rentabilidad.php">Rentabilidad Equipos</a></li>
                        <li><a href="otros_gastos_e.php" target="_parent">Ajuste Rentabilidad Equipos</a></li>
                        <li><a href="listado_vtas.php" target="_parent">Ventas por Cliente</a></li>
                        <li><a href="equipos_devueltos_no_facturados.php">Equipos Devueltos No Facturados</a></li>
                        <li><a href="arriendos_pendientes.php">Arriendos O/C Pendiente o Vencida</a></li>
                        <li><a href="cierre_mes.php">Cierre de Mes</a></li>
               		</ul>     
				</li>              
                    <li><a href="#" class="menulink">Reportes</a>		 
                        <ul> 
                            <li><a href="listado_rep.php">Listado Repuestos</a></li>
                            <li><a href="listado_proveed.php">Listado Proveedores</a></li>
                            <li><a href="listado_clientes.php">Listado Clientes</a></li>
                    				<li><a href="listado_personal.php">Listado Personal</a></li>
                            <li><a href="listado_obras.php">Listado Obras</a></li>
                    				<li><a href="listado_equipos.php">Listado Equipos</a></li>
                            <li><a href="exportar_reportes.php">Exportar Datos</a></li>
                        </ul>
                    </li>
                    <li>
                   	<a href="#" class="menulink">Cobranzas</a>
                    	<ul>
                        <li><a href="cobranza_prioridad_facturas.php">Prioridad Cobranza</a></li>
                				<li>
		                    <a href="#" class="sub">Mantenedores</a>
		                    <ul>
		                    	<li><a href="cobranza_tipo_eventos.php">Tipo de Eventos</a></li>
		                    	<li><a href="cobranza_tipo_diagnostico.php">Tipo de Diagn&oacute;stico</a></li>
		                    	<li><a href="cobranza_tipo_compromisos.php">Tipo de Compromisos</a></li>
		                    	<li><a href="cobranza_tipo_documentos.php">Tipo de Documentos</a></li>
		                    	<li><a href="cobranza_tipo_pagos.php">Tipo de Pagos</a></li>
		                    	<li><a href="cobranza_bancos.php">Bancos</a></li>
                          <li><a href="cobranza_lugar_entrega.php">Lugar Entrega</a></li>
    		                  <li><a href="fecha_cierre.php">Fechas Corte</a></li>
                          </ul>
    		                </li>
                				<li>
                					<a href="#" class="sub">Garant&iacute;as</a>
                					<ul>
                						<li><a href="cobranza_documentos_garantia.php">Consulta Garant&iacute;as</a></li>
                					</ul>
                				</li>
                        <li>
                          <a href="#" class="sub">Informes</a>
                          <ul>
                            <li><a href="cobranza_informe_segui_factura.php">Consulta Seguimiento Factura</a></li>
                            <li><a href="cobranza_distr_facturas_buscar_gi.php">Consulta Guias Internas - Distribucion de Facturas</a></li>
                            <li><a href="cobranza_cambio_estado.php">Cambio Estado Factura</a></li>
                            <li><a href="cobranza_informe_pagos.php">Informe de Pagos</a></li>
                          </ul>
                        </li>
                    		<!--<li><a href="cobranza_distr_facturas.php">Distribuci&oacute;n de Facturas</a></li>
                    		<li><a href="cobranza_copia_factura.php">Entrega 4° Copia Factura</a></li>
                    		<li><a href="cobranza_facturas_proceso_pago.php">Gestión de Facturas en Proceso de Pago</a></li>-->
                				<li><a href="cobranza_gestion_cobranza.php">Gesti&oacute;n Cobranza</a></li>
                        <li><a href="cobranza_cuentas_corrientes.php">Gesti&oacute;n Cuentas Corrientes</a></li>
                        <li><a href="cobranza_libro_compras.php">Libro Compras</a></li>
                        <li><a href="cobranza_libro_ventas.php">Libro Ventas</a></li>
                        

                    	</ul>
                    </li>
                    <li><a href="#" class="menulink">Cerrar Sesión</a>
                      <ul>
                         <li><a href="aut_logout.php" target="_parent" class="menu_top">Salir</a></li>
                      </ul>
                    </li>
            </ul>  

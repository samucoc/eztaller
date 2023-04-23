
function showToolbar()
{

	menu = new Menu();
	menu.addItem("Inicio", "Inicio", "Inicio", "principal.php", "_parent");
	menu.addItem("Arriendos", "Arriendos", null, null);
	menu.addItem("Consultas", "Consultas", null, null);
	menu.addItem("Clientes", "Clientes", null, null);
	menu.addItem("Proveedores", "Proveedores", null, null);
	menu.addItem("Maquinaria", "Maquinaria", null, null);
	menu.addItem("Configuracion", "Configuracion", null, null);
	menu.addItem("Seguridad", "Seguridad", null, null);
	menu.addItem("Cerrar Sesion", "Cerrar Sesion", null, null);


	menu.addSubItem("Arriendos", "Arriendo", "Arriendo", "arriendo_equipo.php", "_parent");
	menu.addSubItem("Arriendos", "cambio Equipo", "Cambio Equipo",  "cambio_equipo.php", "_parent");
	menu.addSubItem("Arriendos", "Evaluacion", "Evaluacion", "evaluacion.php", "_parent");
	menu.addSubItem("Arriendos", "Reclamo", "Reclamo", "reclamo.php" , "_parent");
	menu.addSubItem("Arriendos", "Reparaciones", "Reparaciones",  "repar_equipo.php", "_parent");
	menu.addSubItem("Arriendos", "Factura", "Factura",  "factura.php", "_parent");
	menu.addSubItem("Arriendos", "G.D.", "Emitir G.D.",  "gd.php", "_parent");
	menu.addSubItem("Arriendos", "N.C.", "Emitir N.C.",  "nc.php", "_parent");
	
	menu.addSubItem("Consultas", "Equipos Disponibles", "Equipos Disponibles",  "equipo_disponible.php", "_parent");
	menu.addSubItem("Consultas", "Repuestos", "Repuestos",  "http://", "");
	menu.addSubItem("Consultas", "Ventas por Cliente", "Ventas por Cliente",  "http://", "");
	menu.addSubItem("Consultas", "Obras por Vendedor", "Obras por Vendedor",  "http://", "");

	menu.addSubItem("Clientes", "Ingreso", "Ingreso", "cliente.php", "_parent");
	menu.addSubItem("Clientes", "Buscar", "Buscar", "busca_cliente.php", "_parent");
	menu.addSubItem("Clientes", "Listar", "Listar", "http://", "");

	menu.addSubItem("Proveedores", "Ingreso", "Ingreso",  "proveedor.php", "_parent");
	menu.addSubItem("Proveedores", "Buscar", "Buscar",  "http://", "");
	menu.addSubItem("Proveedores", "Listar Proveedores", "Listar Proveedores", "http://", "");
	
	menu.addSubItem("Maquinaria", "Equipos", "Equipos",  "equipo.php", "_parent");
	menu.addSubItem("Maquinaria", "Repuestos", "Repuestos",  "repuesto.php", "_parent");
	
	menu.addSubItem("Configuracion", "Familia Repuestos", "Familia Repuestos",  "familia_rep.php", "_parent");
	menu.addSubItem("Configuracion", "Estado Equipos", "Estado Equipos",  "estado_equipo.php", "_parent");
	menu.addSubItem("Configuracion", "Tarifas Despacho", "Tarifas Despacho",  "tarifas.php", "_parent");
	menu.addSubItem("Configuracion", "Ciudad", "Ciudad",  "ciudad.php", "_parent");
	menu.addSubItem("Configuracion", "Comuna", "Comuna",  "comuna.php", "_parent");
	menu.addSubItem("Configuracion", "Forma Evaluación", "Forma Evaluación",  "forma_eval.php", "_parent");
	menu.addSubItem("Configuracion", "Tipo Evaluación", "Tipo Evaluación",  "tipo_eval.php", "_parent");
	menu.addSubItem("Configuracion", "Tipo Cliente", "Tipo Cliente",  "tipo_cliente.php", "_parent");

menu.addSubItem("Seguridad", "Usuarios", "Usuarios",  "http://", "");
	menu.addSubItem("Seguridad", "2", "2",  "http://", "");
	menu.showMenu();
}
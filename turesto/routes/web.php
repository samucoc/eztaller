<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Menu;
use Yajra\Datatables\Datatables;
 
Route::get('/', function () {
	return view('welcome');
});


//ingrese todas las rutas dentro de el grupo de middlewere
//esto para evitar ingresos a secciones a personas que no se encuentre logueadas en el sistema
Route::group(['middleware' => 'auth'], function () {
	//Route::get('/link1', function ()    {
	// Uses Auth Middleware
	//});
   	
	//rutas para realizar busquedas de autocompletado
	route::get('buscar_productos','BusquedasController@productos');//buscar producto
	route::get('buscar_tproductos','BusquedasController@tproductos');//buscar tipo de producto
	route::get('buscar_modelos','BusquedasController@modelos');//buscar modelo
	route::get('buscar_clientes','BusquedasController@clientes');//busca los clientes
	route::get('buscar_trabajador','BusquedasController@trabajador');//busca trabajadores
	route::get('buscar_cobrador','BusquedasController@cobrador');//busca trabajadores
	route::get('buscar_supervisor','BusquedasController@supervisor');//busca trabajadores
	route::get('buscar_sector','BusquedasController@sectores');//busca el sector
	route::get('buscar_afp','BusquedasController@Afp');//busca el sector
	route::get('buscar_ips','BusquedasController@Ips');//busca el sector

	///////////////////////////////////////////////////////
	////////////////  rutas ficha ///////////////////////
	/////////////////////////////////////////////////////

	//fichaglobal
	route::get('fichas/fichaglobal','TrabajadoresController@index');//vista
	route::get('fichas/fichaglobal/listar','TrabajadoresController@getTrabajadores');//trae todas las bancos
	route::get('fichas/fichaglobal/editar/{id}','TrabajadoresController@editar');//edita una empresa en particular
	route::get('fichas/fichaglobal/eliminar/{id}','TrabajadoresController@eliminar');//elimina una empresa en particular
	route::get('fichas/fichaglobal/guardar','TrabajadoresController@guardar');//elimina una empresa en particular
	route::post('fichas/fichaglobal/crear','TrabajadoresController@crear');//elimina una empresa en particular
	route::get('fichas/informefichatrabajadores','TrabajadoresController@informeFichaTrabajadores');//elimina una empresa en particular



	///////////////////////////////////////////////////////
	////////////////  rutas configuracion /////////////
	/////////////////////////////////////////////////////

	//menues
	route::get('configuracion/menues','MenuController@index');//vista
	route::get('configuracion/menues/listar','MenuController@getmenues');//trae todas las bancos
	route::get('configuracion/menues/editar/{id}','MenuController@editar');//edita una empresa en particular
	route::get('configuracion/menues/eliminar/{id}','MenuController@eliminar');//elimina una empresa en particular
	route::get('configuracion/menues/guardar','MenuController@guardar');//elimina una empresa en particular
	route::post('configuracion/menues/crear','MenuController@crear');//elimina una empresa en particular

	//menuhijos
	route::get('configuracion/menuhijos','MenuesHijosController@index');//vista
	route::get('configuracion/menuhijos/listar','MenuesHijosController@getsubmenues');//trae todas las bancos
	route::get('configuracion/menuhijos/editar/{id}','MenuesHijosController@editar');//edita una empresa en particular
	route::get('configuracion/menuhijos/eliminar/{id}','MenuesHijosController@eliminar');//elimina una empresa en particular
	route::get('configuracion/menuhijos/guardar','MenuesHijosController@guardar');//elimina una empresa en particular
	route::post('configuracion/menuhijos/crear','MenuesHijosController@crear');//elimina una empresa en particular

	///////////////////////////////////////////////////////
	////////////////  rutas mantenedores /////////////////
	/////////////////////////////////////////////////////

	//empresas
	route::get('mantenedores/empresas','EmpresasController@index');//vista
	route::get('mantenedores/empresas/listar','EmpresasController@getEmpresas');//trae todas las empresas
	route::get('mantenedores/empresas/editar/{id}','EmpresasController@editar');//edita una empresa en particular
	route::get('mantenedores/empresas/eliminar/{id}','EmpresasController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/empresas/guardar','EmpresasController@guardar');//modificar una empresa en particular
	route::post('mantenedores/empresas/crear','EmpresasController@crear');//crear una empresa en particular

	//bancos
	route::get('mantenedores/bancos','bancosController@index');//vista
	route::get('mantenedores/bancos/listar','bancosController@getbancos');//trae todas las bancos

	//regiones
	route::get('mantenedores/regiones','RegionesController@index');//vista
	route::get('mantenedores/regiones/listar','RegionesController@getregion');//trae todas las bancos
	route::get('mantenedores/regiones/editar/{id}','RegionesController@editar');//edita una empresa en particular
	route::get('mantenedores/regiones/eliminar/{id}','RegionesController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/regiones/guardar','RegionesController@guardar');//elimina una empresa en particular
	route::post('mantenedores/regiones/crear','RegionesController@crear');//elimina una empresa en particular

	//provincias
	route::get('mantenedores/provincias','ProvinciasController@index');//vista
	route::get('mantenedores/provincias/listar','ProvinciasController@getprovincia');//trae todas las bancos
	route::get('mantenedores/provincias/editar/{id}','ProvinciasController@editar');//edita una empresa en particular
	route::get('mantenedores/provincias/eliminar/{id}','ProvinciasController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/provincias/guardar','ProvinciasController@guardar');//elimina una empresa en particular
	route::post('mantenedores/provincias/crear','ProvinciasController@crear');//elimina una empresa en particular

	//comunas
	route::get('mantenedores/comunas','ComunasController@index');//vista
	route::get('mantenedores/comunas/listar','ComunasController@getcomuna');//trae todas las bancos
	route::get('mantenedores/comunas/editar/{id}','ComunasController@editar');//edita una empresa en particular
	route::get('mantenedores/comunas/eliminar/{id}','ComunasController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/comunas/guardar','ComunasController@guardar');//elimina una empresa en particular
	route::post('mantenedores/comunas/crear','ComunasController@crear');//elimina una empresa en particular

	//sexo
	route::get('mantenedores/sexo','SexoController@index');//vista
	route::get('mantenedores/sexo/listar','SexoController@getSexo');//trae todas las bancos
	route::get('mantenedores/sexo/editar/{id}','SexoController@editar');//edita una empresa en particular
	route::get('mantenedores/sexo/eliminar/{id}','SexoController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/sexo/guardar','SexoController@guardar');//elimina una empresa en particular
	route::post('mantenedores/sexo/crear','SexoController@crear');//elimina una empresa en particular

	//tipoperfiles
	route::get('mantenedores/tipoperfiles','TipoPerfilesController@index');//vista
	route::get('mantenedores/tipoperfiles/listar','TipoPerfilesController@getperfiles');//trae todas las bancos

	//sexo
	route::get('mantenedores/tiposcuentas','TiposCuentasController@index');//vista
	route::get('mantenedores/tiposcuentas/listar','TiposCuentasController@getTiposCuentas');//trae todas las bancos
	route::get('mantenedores/tiposcuentas/editar/{id}','TiposCuentasController@editar');//edita una empresa en particular
	route::get('mantenedores/tiposcuentas/eliminar/{id}','TiposCuentasController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/tiposcuentas/guardar','TiposCuentasController@guardar');//elimina una empresa en particular
	route::post('mantenedores/tiposcuentas/crear','TiposCuentasController@crear');//elimina una empresa en particular

	//areas
	route::get('mantenedores/areas','AreasController@index');//vista
	route::get('mantenedores/areas/listar','AreasController@getAreas');//trae todas las bancos
	route::get('mantenedores/areas/editar/{id}','AreasController@editar');//edita una empresa en particular
	route::get('mantenedores/areas/eliminar/{id}','AreasController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/areas/guardar','AreasController@guardar');//elimina una empresa en particular
	route::post('mantenedores/areas/crear','AreasController@crear');//elimina una empresa en particular

	//estadoempleado
	route::get('mantenedores/estadoempleado','EstadoEmpleadoController@index');//vista
	route::get('mantenedores/estadoempleado/listar','EstadoEmpleadoController@getEstadoEmpleado');//trae todas las bancos
	route::get('mantenedores/estadoempleado/editar/{id}','EstadoEmpleadoController@editar');//edita una empresa en particular
	route::get('mantenedores/estadoempleado/eliminar/{id}','EstadoEmpleadoController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/estadoempleado/guardar','EstadoEmpleadoController@guardar');//elimina una empresa en particular
	route::post('mantenedores/estadoempleado/crear','EstadoEmpleadoController@crear');//elimina una empresa en particular

	//afp
	route::get('mantenedores/afp','AfpController@index');//vista
	route::get('mantenedores/afp/listar','AfpController@getAfp');//trae todas las bancos
	route::get('mantenedores/afp/editar/{id}','AfpController@editar');//edita una empresa en particular
	route::get('mantenedores/afp/eliminar/{id}','AfpController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/afp/guardar','AfpController@guardar');//elimina una empresa en particular
	route::post('mantenedores/afp/crear','AfpController@crear');//elimina una empresa en particular

	//ips
	route::get('mantenedores/ips','IpsController@index');//vista
	route::get('mantenedores/ips/listar','IpsController@getIps');//trae todas las bancos
	route::get('mantenedores/ips/editar/{id}','IpsController@editar');//edita una empresa en particular
	route::get('mantenedores/ips/eliminar/{id}','IpsController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/ips/guardar','IpsController@guardar');//elimina una empresa en particular
	route::post('mantenedores/ips/crear','IpsController@crear');//elimina una empresa en particular

	//salud
	route::get('mantenedores/salud','SaludController@index');//vista
	route::get('mantenedores/salud/listar','SaludController@getSalud');//trae todas las bancos
	route::get('mantenedores/salud/editar/{id}','SaludController@editar');//edita una empresa en particular
	route::get('mantenedores/salud/eliminar/{id}','SaludController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/salud/guardar','SaludController@guardar');//elimina una empresa en particular
	route::post('mantenedores/salud/crear','SaludController@crear');//elimina una empresa en particular

	//salud
	route::get('mantenedores/intsahorrovol','IntsAhorroVolController@index');//vista
	route::get('mantenedores/intsahorrovol/listar','IntsAhorroVolController@getIntsAhorroVol');//trae todas las bancos
	route::get('mantenedores/intsahorrovol/editar/{id}','IntsAhorroVolController@editar');//edita una empresa en particular
	route::get('mantenedores/intsahorrovol/eliminar/{id}','IntsAhorroVolController@eliminar');//elimina una empresa en particular
	route::get('mantenedores/intsahorrovol/guardar','IntsAhorroVolController@guardar');//elimina una empresa en particular
	route::post('mantenedores/intsahorrovol/crear','IntsAhorroVolController@crear');//elimina una empresa en particular

		
	
	//obtenemos los cumpleaños del mes
	route::get('cumpleanos', 'CumpleanosController@getCumpleanos');
	//vistas de prueba
	route::get('vistas','EmpresasController@vistas');
	route::get('pdf','EmpresasController@pdf');//quitar
	route::get('completar', 'EmpresasController@autocompletar');//quitar
	
});//fin del route group

//ruta para cargar el menu del sistema
Route::get('menu',function(){
	$menues = Menu::orderby('menu_orden')->where('menu_mostrar', '=', 'SI')->get();
	return view('adminlte::layouts.partials.menu')->with('menues', $menues);
});


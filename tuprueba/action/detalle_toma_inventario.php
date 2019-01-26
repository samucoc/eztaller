<style>
	table { 
	  width: 100%; 
	  border-collapse: collapse; 
	}
	/* Zebra striping */
	tr:nth-of-type(odd) { 
	  background: #eee; 
	}
	th { 
	  background: #333; 
	  color: white; 
	  font-weight: bold; 
	}
	td, th { 
	  padding: 6px; 
	  border: 1px solid #ccc; 
	  text-align: left; 
	}

	/* 
	Max width before this PARTICULAR table gets nasty
	This query will take effect for any screen smaller than 760px
	and also iPads specifically.
	*/
	@media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	}

</style>
<?php	
	include_once "../config/config.php";//Contiene funcion que conecta a la base de datos
    global $con;
	session_start();

	ini_set('display_errors', 1); 
	//error_reporting(E_ALL);
	error_reporting( error_reporting() & ~E_NOTICE );

	$q1 = $_GET['fecha1'];
	$q2 = $_GET['fecha2'];

	list($d,$m,$a) = explode('-',$q1);
	$q1 = $a.'-'.$m.'-'.$d;
	list($d,$m,$a) = explode('-',$q2);
	$q2 = $a.'-'.$m.'-'.$d;

	$and_codigo = '';
	$q1!='' && $q2!='' ? $and_codigo = "where fecha between '".$q1."' and '".$q2."' " :  '';

	$arr_toma_inventario = [];

	$arr_toma_inventario[0]['fecha']='Fecha';
	$arr_toma_inventario[0]['bodega']='Bodega';
	$arr_toma_inventario[0]['nombre_tipo']='Tipo Movimiento';
	$arr_toma_inventario[0]['codigo']='Código';
    $arr_toma_inventario[0]['descr']='Descripción';
    $arr_toma_inventario[0]['cantidad']='Cantidad';
    $arr_toma_inventario[0]['observacion']='Observación';
    

    $query=mysqli_query($con,"select movim_detalle.md_ncorr, fecha, bodegas.nombre as nombre_bodega, 
    								movim_tipos.nombre as nombre_tipo, mt_ncorr , 
    								codigo, descr, cantidad, observacion
								from movim
									inner join movim_detalle
										on movim.m_ncorr = movim_detalle.m_ncorr
									inner join bodegas
										on movim.movim_bodega = bodegas.b_ncorr
									inner join movim_tipos 
										on movim_tipos.mt_ncorr	= movim.movim_tipo	
							 $and_codigo");
    while ($row=mysqli_fetch_array($query)) {
    	list($d,$m,$a) = explode('-',$row['fecha']);
		$row['fecha'] = $a.'-'.$m.'-'.$d;
		$arr_toma_inventario[$row['md_ncorr']]['fecha']=$row['fecha'];
		$arr_toma_inventario[$row['md_ncorr']]['nombre_bodega']=$row['nombre_bodega'];
		$arr_toma_inventario[$row['md_ncorr']]['nombre_tipo']=$row['nombre_tipo'];
		$arr_toma_inventario[$row['md_ncorr']]['codigo']=$row['codigo'];
	    $arr_toma_inventario[$row['md_ncorr']]['descr']=$row['descr'];
	   	$row['mt_ncorr']=='1' || $row['mt_ncorr']=='3' || $row['mt_ncorr']=='4' ?
		    $arr_toma_inventario[$row['md_ncorr']]['cantidad']=$row['cantidad'] : 
		    $arr_toma_inventario[$row['md_ncorr']]['cantidad']=$row['cantidad'] *(-1) ;
	    $arr_toma_inventario[$row['md_ncorr']]['observacion']=$row['observacion'];
    }	



	echo "<table>";
	foreach($arr_toma_inventario as $producto){
    	echo "<tr>";
    	foreach($producto as $producto_by_bodega){
    		echo "<td>".$producto_by_bodega."</td>";
    		}
    	echo "</tr>";
    }
	echo "</table>";
    


?>
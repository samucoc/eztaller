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

	$q = $_GET['codigo'];
	$and_codigo = '';
	$q!='' ? $and_codigo = "and codigo = '".$q."'" : '';

	$arr_toma_inventario = [];

	$query=mysqli_query($con,"select b_ncorr, nombre
								from bodegas
								order by b_ncorr");
	$arr_toma_inventario[0]['codigo']='Código';
    $arr_toma_inventario[0]['descr']='Descripción';
    while ($row=mysqli_fetch_array($query)) {
    	$arr_toma_inventario[0][$row['b_ncorr']] = $row['nombre'] ;
    }

	$query_1=mysqli_query($con,"select b_ncorr
								from bodegas
								order by b_ncorr");
	while ($row_1=mysqli_fetch_array($query_1)) {
		$query_2=mysqli_query($con,"select codigo, descricpion	
								from productos
								where 1 $and_codigo
								order by codigo");
		while ($row_2=mysqli_fetch_array($query_2)) {
			for($m=1;$m<=7;$m++){
				$query=mysqli_query($con,"select COALESCE(sum(cantidad),0) as cant
											from movim
												inner join movim_detalle
													on movim.m_ncorr = movim_detalle.m_ncorr
										  where movim_tipo = '".$m."' and 
										  		movim_bodega = '".$row_1['b_ncorr']."' and 
										  		codigo = '".$row_2['codigo']."' ");
			    while ($row=mysqli_fetch_array($query)) {
			    	$arr_toma_inventario[$row_2['codigo']]['codigo']=$row_2['codigo'];
			    	$arr_toma_inventario[$row_2['codigo']]['descr']=$row_2['descr'];
			    	$m=='1' || $m=='3' || $m=='4' ?	$arr_toma_inventario[$row_2['codigo']][$row_1['b_ncorr']] += $row['cant'] : 	$arr_toma_inventario[$row_2['codigo']][$row_1['b_ncorr']] -= $row['cant'] ;
			    }	
			}
		}
	}

	echo "<table>";
	foreach($arr_toma_inventario as $producto){
    	echo "<tr>";
    	foreach($producto as $producto_by_bodega){
    		echo "<td>".($producto_by_bodega)."</td>";
    		}
    	echo "</tr>";
    }
	echo "</table>";
    


?>
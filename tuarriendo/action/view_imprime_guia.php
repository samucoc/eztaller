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

	$q = isset($_POST['m_ncorr']) ? $_POST['m_ncorr']: '' ;
	
	//encabezado
	$query=mysqli_query($con,"select fecha, 
									vendedor,
									bodegas.nombre as nombre_bodega, 
    								movim_tipos.nombre as nombre_tipo, 
    								observacion
								from movim
									inner join bodegas
										on movim.movim_bodega = bodegas.b_ncorr
									inner join movim_tipos 
										on movim_tipos.mt_ncorr	= movim.movim_tipo
							  where m_ncorr = '".$q."'  ");
    echo "<table>";
	while ($row=mysqli_fetch_array($query)) {
		echo "<tr>";
    		echo "<td>Nro. Guía</td><td>".$q."</td>";
    	echo "</tr>";
		echo "<tr>";
    		echo "<td>Fecha</td><td>".$row['fecha']."</td>";
    	echo "</tr>";
		echo "<tr>";
    		echo "<td>Bodega</td><td>".($row['nombre_bodega'])."</td>";
    	echo "</tr>";
		echo "<tr>";
    		echo "<td>Tipo Movimiento</td><td>".($row['nombre_tipo'])."</td>";
    	echo "</tr>";
		echo "<tr>";
    		echo "<td>Vendedor</td><td>".($row['vendedor'])."</td>";
    	echo "</tr>";
		echo "<tr>";
    		echo "<td>Observación</td><td>".$row['observacion']."</td>";
    	echo "</tr>";
    }
	echo "</table>";

    //detalle
	$query=mysqli_query($con,"select codigo, descr, cantidad
											from movim_detalle
										  where m_ncorr = '".$q."'  ");

	echo "<table>";
		echo "<tr>";
    		echo "<td>Código</td><td>Descripción</td><td>Cantidad</td>";
    	echo "</tr>";
	
    while ($row=mysqli_fetch_array($query)) {
		echo "<tr>";
    		echo "<td>".$row['codigo']."</td><td>".$row['descr']."</td><td>".$row['cantidad']."</td>";
    	echo "</tr>";

    }
	echo "</table>";




?>
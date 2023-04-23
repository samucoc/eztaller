<?php

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';
include('conf_bd.php');

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
	die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
	$timezone = new DateTimeZone($_GET['timezone']);
}

// Read and parse our events JSON file into an array of event data arrays.
//$json = file_get_contents(dirname(__FILE__) . 'events.json');

$data = array();

$sql = "SELECT *
FROM calendario";
$res = mysql_query($sql, $conexion) or die(mysql_error());
$i=0;
//mysql_query('SET NAMES utf8');
while ($row = mysql_fetch_assoc($res)) {
	$id_proveedor = $row['calendario_ncorr'];
	$titulo = $row['titulo'];
	$url = $row['url'];
	$start = $row['inicio'];
	$end = $row['fin'];
	$color = $row['color'];
	$responsable = $row['responsable'];
	$descripcion = $row['descripcion'];
	
	$data[$i] = array(	'tarea' => $id_proveedor,
						'title' => utf8_encode($titulo),
						'url' 	=> $url,
						'start' => $start,
						'color' => utf8_encode($color),
						'responsable' 	=> $responsable,
						'descripcion' 	=> $descripcion,
						'end' 	=> $end);
	$i++;

}

//$input_arrays = json_decode($data, true);
$input_arrays = $data;
//var_dump($input_arrays);
// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($input_arrays as $array) {

	// Convert the input array into a useful Event object
	$event = new Event($array, $timezone);

	// If the event is in-bounds, add it to the output
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
	}
}

// Send JSON to the client.
echo str_replace('\u00c3\u0091','Ñ',json_encode($output_arrays));
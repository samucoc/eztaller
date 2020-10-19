<?php
ini_set('display_errors', 1); 
//error_reporting(E_ALL);
error_reporting( error_reporting() & ~E_NOTICE  & ~E_WARNING );

//coneccion local bd en mysql
$servidor = "localhost";
$usuario = "root";
$pass = "";
//$pass = "";
$bd = "eztaller_tubodega";

date_default_timezone_set('America/Santiago');

$conexion = mysqli_connect($servidor, $usuario, $pass);
mysqli_select_db($conexion,$bd);


if (!function_exists('mysql_connect')) {
	function mysql_connect($host, $username, $password, $db) {
	    return mysqli_connect($host, $username, $password, $db);
	}

	function mysql_select_db($db,$link) {
		return(mysqli_select_db($link,$db));
	}

	function mysql_query($query,$link=false) {
		if($link==false) {
			$link=mysqli_connect("localhost","root","","eztaller_tubodega"); 
			mysqli_select_db($link,"eztaller_tubodega"); 
		}
		return(mysqli_query($link,$query));
	}

	function mysql_error($link) {
		return(mysqli_error($link));
	}

	function mysql_errno($conexion) {
		return(mysqli_errno($conexion));
	}

	function mysql_fetch_array($res) {
		return(mysqli_fetch_array($res));
	}

	function mysql_fetch_assoc($res) {
		return(mysqli_fetch_assoc($res));
	}

	function mysql_free_result($l) {
		return(mysqli_free_result($l));
	}

	function mysql_close($l) {
		if(!isset($l)) return(false);
		return(mysqli_close($l));
	}

	function mysql_num_rows($res) {
		return(mysqli_num_rows($res));
	}

	function mysql_fetch_row($res) {
		return(mysqli_fetch_row($res));
	}

	function mysql_result($res, $row, $field=0) { 
	    $res->data_seek($row); 
	    $datarow = $res->fetch_array(); 
	    return $datarow[$field]; 
	}

	function mysql_insert_id($link){
		return mysqli_insert_id($link);
	}

	function split($exp,$arr){
		return preg_split($exp,$arr);
	}

	function save_sql_access($sSqlQuery){

        GLOBAL $servidor, $bd, $usuario, $pass;
       
        $conexion = mysqli_connect($servidor, $usuario, $pass);
		mysqli_select_db($conexion,$bd);

        $sSqlQuery = str_replace("'", '"',$sSqlQuery);
        
        $iFuncID  = isset($_SESSION['alycar_usuario']) ? $_SESSION['alycar_usuario'] : 0;
        $sIp  = get_client_ip();
        
        $sUrl = $_SERVER['PHP_SELF'];

        $query = "INSERT INTO logs_sql_access (lse_id, func_id, fecha, ip, ruta, query) 
        				VALUES (DEFAULT, '$iFuncID', CURRENT_TIMESTAMP, '$sIp', '$sUrl', '$sSqlQuery');";
        if (mysqli_query($conexion,$query)){

        }
        else{
        echo "<pre>";
            print_r(mysql_error($conexion));
        echo "</pre>";	
        }
    }
	
	function save_sql_errors($sSqlQuery, $sSqlError){

		GLOBAL $servidor, $bd, $usuario, $pass;
       
        $conexion = mysqli_connect($servidor, $usuario, $pass);
		mysqli_select_db($conexion,$bd);


        $sSqlQuery = str_replace("'", '"',$sSqlQuery);
        $sSqlError = str_replace("'", '"',$sSqlError);
        
        $iFuncID  = isset($_SESSION['alycar_usuario']) ? $_SESSION['alycar_usuario'] : 0;
        $sIp  = get_client_ip();

        $sUrl = $_SERVER['PHP_SELF'];

        $query = "INSERT INTO logs_sql_error (lse_id, func_id, fecha, ip, ruta, query, error) 
        				VALUES (DEFAULT, '$iFuncID', CURRENT_TIMESTAMP, '$sIp', '$sUrl', '$sSqlQuery', '$sSqlError');";
 		if (mysqli_query($conexion,$query)){

        }
        else{
        echo "<pre>";
            print_r(mysql_error($conexion));
        echo "</pre>";	
        }

    }
	function get_client_ip(){
	    // Nothing to do without any reliable information
	    if (!isset($_SERVER['REMOTE_ADDR'])) {
	        return NULL;
	    }
	    
	    // Header that is used by the trusted proxy to refer to
	    // the original IP
	    $proxy_header = "HTTP_X_FORWARDED_FOR";

	    // List of all the proxies that are known to handle 'proxy_header'
	    // in known, safe manner
	    //$trusted_proxies = array("2001:db8::1", "192.168.50.1");

	    //if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {
	        
        // Get IP of the client behind trusted proxy
        if (array_key_exists($proxy_header, $_SERVER)) {

            // Header can contain multiple IP-s of proxies that are passed through.
            // Only the IP added by the last proxy (last IP in the list) can be trusted.
            $client_ip = trim(end(explode(",", $_SERVER[$proxy_header])));

            // Validate just in case
            if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                return $client_ip;
            } else {
                // Validation failed - beat the guy who configured the proxy or
                // the guy who created the trusted proxy list?
                // TODO: some error handling to notify about the need of punishment
            }
        }
	    //}

	    // In all other cases, REMOTE_ADDR is the ONLY IP we can trust.
	    return $_SERVER['REMOTE_ADDR'];
	}

}

?>

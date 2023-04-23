<?php
ini_set('display_errors', 1); 
//error_reporting(E_ALL);
error_reporting( error_reporting() & ~E_NOTICE  & ~E_WARNING );

class Conexion{
	static public function conectar(){
		try {
			$link = new PDO("mysql:host=localhost;dbname=eztaller_tuventa","root","");
			$link->exec("set names utf8");
			return $link;
		} catch (PDOException $e){
			echo "Error: Favor contactarse con Sistemas.";
		    save_sql_errors('Conexion a BD', $e->getMessage());
		    return null;
		}
	}
}

function save_sql_errors($sSqlQuery, $sSqlError){

		$servidor = 'localhost';
		$bd = 'eztaller_tuventa';
		$usuario = 'root';
		$pass = '';
       
        $conexion = mysqli_connect($servidor, $usuario, $pass);
		mysqli_select_db($conexion,$bd);


        $sSqlQuery = str_replace("'", '"',$sSqlQuery);
        $sSqlError = str_replace("'", '"',$sSqlError);
        
        $iFuncID  = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;
        $sIp  = get_client_ip();

        $sUrl = $_SERVER['PHP_SELF'];

        $query = "INSERT INTO logs_sql_error (lse_id, func_id, fecha, ip, ruta, query, error) 
        				VALUES (DEFAULT, '$iFuncID', CURRENT_TIMESTAMP, '$sIp', '$sUrl', '$sSqlQuery', '$sSqlError');";
 		mysqli_query($conexion,$query);

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
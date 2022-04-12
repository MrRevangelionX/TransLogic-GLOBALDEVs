<?php
	date_default_timezone_set('America/El_Salvador');

	// BASE DE PRODUCCION
    // $server ="192.168.21.2";
    // $username ="sr2008";
    // $password ="2008";
    // $database ="negocios_g";

	// BASE DE LOCAL
    $server =".";
    $username ="Desarrollo";
    $password ="123";
    $database ="negocios_g";
    
    global $conexion;
	$conexion = new PDO("sqlsrv:server=$server;database=$database", $username, $password);
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function Query($query){
		global $conexion;
		if ($resultSet = $conexion->query($query)) {
			return $resultSet;
		}
		else{
			return false;
		}
	}

	function countQuery($query){
		$data = Query($query);	
		$i = 0;
		foreach ($data as $row) {
			$i++;
		}
		return $i; 
	}
?>
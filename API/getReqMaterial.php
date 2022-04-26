<?php
    // error_reporting(0);
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./loginReq.txt');
    $data = json_decode($json, TRUE);

    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("MaterialReq.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);

    require_once('../cfg/db.php');

    $empresa = '9';
    $sucursal = '32';
    $bodega = '242';
    $transa = '1';
    $orden = $_REQUEST['reqMaterial'];

    global $conexion;
	$spc = $conexion -> prepare("exec p_inv_rpt_despacho ?,?,?,?,?");
	$spc->bindParam(1, $empresa);
	$spc->bindParam(2, $sucursal);
	$spc->bindParam(3, $bodega);
	$spc->bindParam(4, $transa);
	$spc->bindParam(5, $orden);
	$spc->execute();

	$response = array();

	while($resultSet = $spc->fetch(PDO::FETCH_ASSOC)){
		array_push($response, array("codempresa" => $resultSet['codempresa'],
                                    "codsucursal" => $resultSet['codsucursal'],
                                    "codbodega" => $resultSet['codbodega'],
                                    "correlativo" => $resultSet['correlativo'],
                                    "linea" => $resultSet['linea'],
                                    "codproducto" => $resultSet['codproducto'],
                                    "descripcionlinea" => $resultSet['descripcionlinea'],
                                    "codproyecto" => $resultSet['codproyecto'],
                                    "poligono" => $resultSet['poligono'],
                                    "lote" => $resultSet['lote'],
                                    "numpre" => $resultSet['numpre'],
                                    "codetapa" => $resultSet['codetapa'],
                                    "codfase" => $resultSet['codfase'],
                                    "codproceso" => $resultSet['codproceso'],
                                    "codactividad" => $resultSet['codactividad'],
                                    "cantidad" => $resultSet['cantidad'],
                                    "preciounitario" => $resultSet['preciounitario'],
                                    "existenciaanterior" => $resultSet['existenciaanterior'],
                                    "codunidadmedida" => $resultSet['codunidadmedida'],
                                    "estado" => $resultSet['estado'],
                                    "codusuario" => $resultSet['codusuario'],
                                    "iva" => $resultSet['iva'],
                                    "impuesto" => $resultSet['impuesto'],
                                    "subtotal" => $resultSet['subtotal'],
                                    "devolucion" => $resultSet['devolucion'],
                                    "costoanterior" => $resultSet['costoanterior'],
                                    "cantidaddevolucion" => $resultSet['cantidaddevolucion'],
                                    "numeroreferencia" => $resultSet['numeroreferencia'],
                                    "nomproducto" => $resultSet['nomproducto'],
                                    "nombodega" => $resultSet['nombodega'],
                                    "nomtipomovimiento" => $resultSet['nomtipomovimiento'],
                                    "nomtipodocumento" => $resultSet['nomtipodocumento'],
                                    "nomusuario" => $resultSet['nomusuario'],
                                    "numerodocumento" => $resultSet['numerodocumento'],
                                    "fecha" => $resultSet['fecha'],
                                    "Total" => $resultSet['Total'],
                                    "nomproyecto" => $resultSet['nomproyecto'],
                                    "codcontratista" => $resultSet['codcontratista'],
                                    "concepto" => $resultSet['concepto'],
                                    "nomempleado1" => $resultSet['nomempleado1'],
                                    "nomproceso" => $resultSet['nomproceso'],
                                    "nompre" => $resultSet['nompre'],
                                    "descripcion" => $resultSet['descripcion'],
                                    "nomunidadmedida" => $resultSet['nomunidadmedida']
		));
	}

    echo json_encode(array("material" => $response));
?>
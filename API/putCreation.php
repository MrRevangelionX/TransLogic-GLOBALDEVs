<?php
    error_reporting(0);
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./asignaBodega.txt');
    $data = json_decode($json, TRUE);

    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("asignaBodega.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);

    require_once('../cfg/db.php');
    require_once('./Printer/ThermalPrinter.php');

    $nOrder = $data['nOrder'];
    $nTransporte = $data['nTransporte'];
    $uCreation = $data['uCreation'];

    $insertar = "INSERT INTO wapp_proceso_translogic (nOrden,
                                                     nTransporte,
                                                     dtCreacion,
                                                     uCreacion,
                                                     dtLastChange)
                                            VALUES   ('".$nOrder."',
                                                     '".$nTransporte."',
                                                     GETDATE(),
                                                     '".$uCreation."',
                                                     GETDATE());";

    // echo $insertar;
    // exit;

    $resultado = Query($insertar);

    $consulta = "select * from inv_transaccion_det
                 where correlativo = '".$nOrder."';";
                 
    $rs = Query($consulta);

    $asignacion['asignacion'] = array();

    if($resultado){
        array_push($asignacion['asignacion'], array( "orden_material" => $nOrder,
                                                     "transporte_asignado" => $nTransporte,
                                                     "fecha_asignado" => $aFecha
                                                    ));

//SET TICKETS PARAMS QR AND BODY
$qrCode= $nOrder.",".$nTransporte;
foreach($rs as $row){
    $lista .= $row['cantidad']. " - " .$row['descripcionlinea']. " \n";
};
$body = "

Requerimiento de Materiales
N°: ".$nOrder."


Asignada correctamente al transporte
N°: ".$nTransporte."


";

    // Se manda a imprimir el Ticket
    // getTicket($qrCode, $body, $lista);

    }else{
        array_push($asignacion['asignacion'], array( "orden_material" => "ERROR",
                                                     "transporte_asignado" => "ERROR",
                                                     "fecha_asignado" => "Please Try Again!"
                                                    ));
    }

    echo json_encode($asignacion);

?>
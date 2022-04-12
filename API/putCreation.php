<?php
    // error_reporting(0);
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

    $asignacion['asignacion'] = array();
    $aFecha = date('d-M-y H:i:s');

    if($resultado){
        array_push($asignacion['asignacion'], array( "orden_material" => $nOrder,
                                                     "transporte_asignado" => $nTransporte,
                                                     "fecha_asignado" => $aFecha
                                                    ));
$body = "



Requerimiento de Materiales
N°: ".$nOrder."

        

Asignada correctamente al transporte
N°: ".$nTransporte."




".$aFecha."


";
        getTicket($nOrder, $body);
    }else{
        array_push($asignacion['asignacion'], array( "orden_material" => "ERROR",
                                                     "transporte_asignado" => "ERROR",
                                                     "fecha_asignado" => "Please Try Again!"
                                                    ));
    }

    echo json_encode($asignacion);

?>
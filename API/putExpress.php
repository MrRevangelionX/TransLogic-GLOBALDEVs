<?php
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./Express.txt');
    $data = json_decode($json, TRUE);

    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("Express.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);

    require_once('../cfg/db.php');
    require_once('./Printer/ThermalPrinter.php');

    $tDescription = $data['tDescription'];
    $nTransporte = $data['nTransporte'];
    $uCreation = $data['uCreation'];

    $insertar = "INSERT INTO wapp_proceso_translogicEXP (nTransporte,
                                                     dtCreacion,
                                                     uCreacion,
                                                     tDescripcion,
                                                     dtLastChange)
                                            VALUES   ('".$nTransporte."',
                                                     GETDATE(),
                                                     '".$uCreation."',
                                                     '".$tDescription."',
                                                     GETDATE());";

    // echo $insertar;
    // exit;

    $resultado = Query($insertar);

    if($resultado){

        $aFecha = date('d-M-y H:i:s');
        $lista = "";
        $asignacion['asignacion'] = array();

        array_push($asignacion['asignacion'], array( "transporte_asignado" => $nTransporte,
                                                     "fecha_asignado" => $aFecha
                                                    ));

            $qrCode = "Viaje Express";
            
            $body = "
            
            Viaje Express
            Asignada correctamente al transporte
            N°: ".$nTransporte."
            
            Descripcion del Viaje:
            ".$tDescription."
            
            ";

        // Se manda a imprimir el Ticket
        // getTicket($qrCode, $body, $lista);

    }else{
        array_push($asignacion['asignacion'], array( "transporte_asignado" => "ERROR",
                                                     "fecha_asignado" => "Please Try Again!"
                                                    ));
    }

    echo json_encode($asignacion);

?>
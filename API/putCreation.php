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

    // $nOrder = '517708';
    // $nTransporte = 'P943332';
    // $uCreation = 'MrRX';

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

    if($resultado){

        $consulta = "select * from inv_transaccion_det det
                 inner join gen_proyecto p on det.codproyecto = p.codproyecto
                 where correlativo = '".$nOrder."';";
                 
        $rs = Query($consulta);
        $aFecha = date('d-M-y H:i:s');
        $lista = "";
        $asignacion['asignacion'] = array();

        array_push($asignacion['asignacion'], array( "orden_material" => $nOrder,
                                                     "transporte_asignado" => $nTransporte,
                                                     "fecha_asignado" => $aFecha
                                                    ));


            $qrCode = $nOrder.",".$nTransporte;

            foreach($rs as $row){
                $lista .= $row['cantidad']. " - " .$row['codproducto']. " - " .$row['descripcionlinea']. " \n";
                $Proyecto ="Proyecto: ".$row['nomproyecto'];
                $Poligono ="Poligono: ".$row['poligono'];
                $Lote ="Lote: ".$row['lote'];
            };
            
            $body = "
            
            Requerimiento de Materiales
            N°: ".$nOrder."
            
            Asignada correctamente al transporte
            N°: ".$nTransporte."
            
            Ubicación de Destino:
            ".$Proyecto."
            ".$Poligono."
            ".$Lote."
            
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
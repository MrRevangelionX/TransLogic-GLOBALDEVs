<?php
    // error_reporting(0);
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./checkLocation.txt');
    $data = json_decode($json, TRUE);

    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("checkLocation.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);

    require_once('../cfg/db.php');

    $nOrder = $data['nOrder'];
    $uCreation = $data['uCreation'];

    $actualizar = "";

    // echo $actualizar;
    // exit;

    $resultado = Query($actualizar);

    $location['check'] = array();

    if($resultado){
        array_push($location['check'], array( "orden_material" => $nOrder,
                                             "fecha_check" => date('d-M-y H:i:s')
                                          ));
    }else{
        array_push($location['check'], array( "orden_material" => "ERROR",
                                             "fecha_check" => "Please Try Again!"
                                          ));
    }

    echo json_encode($location);

?>
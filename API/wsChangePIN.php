<?php
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./PIN.txt');
    $data = json_decode($json,true);
    
    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("PIN.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);
    
    $contratista = $data['contratista'];
    $pin = $data['pin'];

    require_once('../cfg/db.php');

    $update = "update app_contratista
                set PIN='" . md5($pin) . "'
                where codcontratista='" . $contratista . "'";

    // echo $update;
    // exit;

    $result = Query($update);

    if($result){
        echo "OK";
    }
?>
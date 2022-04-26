<?php
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./PIN.txt');

    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("PIN.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);
    
    $ws = explode("&", $json);
    $cont = explode("=",$ws[0]);
    $cont1 = explode("=",$ws[1]);

    $contratista = $cont[1];
    $pin = $cont1[1];

    // echo '<hr>';
    // echo ($contratista);
    // echo '<br>';
    // echo ($pin);
    // echo '<hr>';
    // exit;

    require_once('../cfg/db.php');

    $update = "update app_contratista
                set PIN='" . md5($pin) . "'
                where codcontratista='" . $contratista . "'";

    // echo $update;
    // exit;

    $result = Query($update);

    if($result){
        echo "Cambio Realizado Correctamente";
    }else{
        echo "Hubo un problema al realizar el cambio";
    }
?>
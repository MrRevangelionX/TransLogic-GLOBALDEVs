<?php
    error_reporting(0);
    $json = file_get_contents('php://input');
    // $json = file_get_contents('./loginReq.txt');
    $data = json_decode($json, TRUE);

    // DUMP HACIA UN ARCHIVO JSON
    // $myfile = fopen("loginReq.txt", "w");
    // fwrite($myfile, $json);
    // fclose($myfile);

    require_once("../CFG/db.php");

    $uID = $data['uID'];
    $uPD = md5($data['uPD']);

    $consulta = "SELECT TOP 1 *
                FROM sg_usuario
                WHERE estado = '1' AND codusuario = '".$uID."' AND claveweb = '".$uPD."'";

    $existe = countQuery($consulta);
    
    $response['login'] = array();

    if($existe > 0){
        $rs = Query($consulta);
        foreach($rs as $row){
            array_push($response['login'], array("user"=>$row['codusuario'], "name"=>$row['nomusuario'], "exist"=>true));
        }
    }else{
        array_push($response['login'], array("user"=>"ERROR", "name"=>"ERROR", "exist"=>false));
    }

    echo json_encode($response);
?>
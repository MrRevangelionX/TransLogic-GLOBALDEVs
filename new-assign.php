<?php

    error_reporting(0);
      
    if(!isset($_POST['orden']) or !isset($_POST['placa']) or empty($_POST['orden']) or empty($_POST['placa'])) {
        echo '<div class="alert alert-dismissible alert-danger"><center>';
        echo '<h4 class="alert-heading">ALTO!</h4>';
        echo '<p class="mb-0">HUBO UN ERROR EN ESA ASIGNACION!, INTENTALO DE NUEVO</p>';
        echo '</center></div>';
        include_once('./asignar.php');
    }else{

        session_start();
        require_once('./cfg/db.php');
        
        $nOrder = $_POST['orden'];
        $nTransporte = $_POST['placa'];
        $uCreation = $_SESSION['usuario'];

        try {
            $insertar="INSERT INTO wapp_proceso_translogic (nOrden, nTransporte, dtCreacion, uCreacion, dtLastChange)
                        VALUES   ('".$nOrder."','".$nTransporte."',GETDATE(),'".$uCreation."',GETDATE());";

            $result = Query($insertar);

            if ($result){
                echo '<div class="alert alert-dismissible alert-success"><center>';
                echo '<h4 class="alert-heading">ÉXITO!</h4>';
                echo '<p class="mb-0">ASIGNACION COMPLETADA!</p>';
                echo '</center></div>';
                include_once('./asignar.php');
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
        
    }
?>
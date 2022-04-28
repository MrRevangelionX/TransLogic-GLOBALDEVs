<?php
     
    if(!isset($_POST['txtDescripcion']) or !isset($_POST['placa']) or empty($_POST['txtDescripcion']) or empty($_POST['placa'])) {
        echo '<div class="alert alert-dismissible alert-danger"><center>';
        echo '<h4 class="alert-heading">ALTO!</h4>';
        echo '<p class="mb-0">HUBO UN ERROR EN ESA ASIGNACION!, INTENTALO DE NUEVO</p>';
        echo '</center></div>';
        include_once('./express.php');
    }else{

        session_start();
        require_once('./cfg/db.php');
        
        $tDesc = $_POST['txtDescripcion'];
        $nTransporte = $_POST['placa'];
        $uCreation = $_SESSION['usuario'];

        try {
            $insertar="INSERT INTO wapp_proceso_translogicEXP (nTransporte, dtCreacion, uCreacion, tDescripcion, dtLastChange)
                        VALUES   ('".$nTransporte."',GETDATE(),'".$uCreation."','".$tDesc."',GETDATE());";

            // echo $insertar;
            // exit;

            $result = Query($insertar);

            if ($result){
                echo '<div class="alert alert-dismissible alert-success"><center>';
                echo '<h4 class="alert-heading">ÉXITO!</h4>';
                echo '<p class="mb-0">ASIGNACION COMPLETADA!</p>';
                echo '</center></div>';
                include_once('./express.php');
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
        
    }
?>
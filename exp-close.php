<?php
    session_start();
    require_once('./cfg/db.php');

    if(!isset($_GET['id']) or empty($_GET['id'])){
        echo '<div class="alert alert-dismissible alert-danger"><center>';
        echo '<h4 class="alert-heading">ALERTA!</h4>';
        echo '<p class="mb-0">LOS CAMPOS NO PUEDEN ESTAR VACIOS</p>';
        echo '</center></div>';
        include_once('./express.php');
    }else{
        $id = $_GET['id'];
        $usuario = $_SESSION['usuario'];

        $update = "update wapp_proceso_translogicEXP
                    set dtCheckCompletado = GETDATE(), uCheckCompletado = '" .$usuario. "'
                    where uID = '" . $id . "'";

        $result = Query($update);

        if($result){
            echo '<div class="alert alert-dismissible alert-success"><center>';
            echo '<h4 class="alert-heading">ÉXITO!</h4>';
            echo '<p class="mb-0">LA TAREA SE COMPLETÓ CORRECTAMENTE</p>';
            echo '</center></div>';
            include_once('./express.php');
        }else{
            echo '<div class="alert alert-dismissible alert-danger"><center>';
            echo '<h4 class="alert-heading">ALTO!</h4>';
            echo '<p class="mb-0">NO SE PUDO COMPLETAR LA TAREA, FAVOR INTENTE NUEVAMENTE MAS TARDE</p>';
            echo '</center></div>';
            include_once('./express.php');
        }
    }

?>
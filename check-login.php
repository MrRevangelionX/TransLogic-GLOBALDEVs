<?php
date_default_timezone_set('America/El_Salvador');
    if(!isset($_POST["usuario"]) || !isset($_POST["pass"]) || (empty($_POST["usuario"]) || empty($_POST["pass"]))){
        echo '<div class="alert alert-dismissible alert-danger"><center>';
        echo '<h4 class="alert-heading">ALERTA!</h4>';
        echo '<p class="mb-0">LOS CAMPOS USUARIO Y CONTRASEÑA NO PUEDEN ESTAR VACIOS</p>';
        echo '</center></div>';
        include_once('./index.php');
    }else{
        $usuario = $_POST['usuario'];
        $pass = md5($_POST['pass']);

        require_once('./cfg/db.php');

        $consulta = "Select TOP 1 *
                    from sg_usuario
                    where codusuario = '" . $usuario . "'
                    and claveweb = '" . $pass . "'
                    and estado = 1;";

        // echo $consulta;
        // exit;

        $rs = Query($consulta);
        $existe = $rs->rowCount();

        // var_dump($row);
        // echo $existe;
        // exit;

        if($existe != 0){
            session_start();
            
            foreach($rs as $row){

                $_SESSION['nombre'] = $row['nomusuario'];
                $_SESSION['usuario'] = $row['codusuario'];

            }

            // echo 'Listo para pasar!';
            // exit;

            header('location: ./main.php');

        }else{
            echo '<div class="alert alert-dismissible alert-danger"><center>';
            echo '<h4 class="alert-heading">ALERTA!</h4>';
            echo '<p class="mb-0">USUARIO O CONTRASEÑA NO SON CORRECTOS</p>';
            echo '</center></div>';
            include_once('./index.php');
        }
    }
?>
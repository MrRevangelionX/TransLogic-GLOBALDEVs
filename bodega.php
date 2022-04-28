<?php
    session_start();
    if(!isset($_SESSION['usuario']) or empty($_SESSION['usuario'])){
        header('location: check-logout.php');
    }else{
    require_once('./cfg/db.php');

    $consulta = "select * from wapp_proceso_translogic trans
                inner join inv_transaccion_enc enc on trans.nOrden = enc.correlativo
                inner join app_contratista cont on cont.codcontratista = enc.codcontratista
                where dtCheckBodega is null
                order by dtCreacion asc";

    $rs = Query($consulta);

    $consulta2 = "select TOP 1000
                    CONVERT(DATE,a.fecha) as Fecha,
                    b.nomempresa as Empresa,
                    a.codsucursal,
                    c.nomsucursal as Sucursal,
                    d.nombodega as Bodega,
                    a.correlativo as Correlativo,
                    a.numerodocumento as Documento,
                    a.codproyecto,
                    e.nomproyecto as Proyecto
                from inv_transaccion_enc a
                inner join gen_empresa b on a.codempresa = b.codempresa
                inner join gen_sucursal c on a.codsucursal = c.codsucursal
                inner join gen_bodega d on a.codbodega = d.codbodega
                full join gen_proyecto e on a.codproyecto = e.codproyecto
                where a.fechadespacho is null and a.impresa = 1
                and a.codtipomovimiento = 6 and a.codtipodoc = 8
                --and fecha between CAST( GETDATE() - 30 AS Date ) and CAST( GETDATE() AS Date )
                order by fecha desc, a.correlativo asc";

    $rs2 = Query($consulta2);

    $consulta3 = "select * from wapp_proceso_translogic trans
                inner join inv_transaccion_enc enc on trans.nOrden = enc.correlativo
                inner join app_contratista cont on cont.codcontratista = enc.codcontratista
                where dtCheckCompletado is not null";

    $rs3 = Query($consulta3);
    
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Trasporte y Logística para Global Developers SA de CV">
    <meta name="author" content="MrRX">
    <title>Global Developers | Sistema de Transporte y Logística</title>
    <link rel="shortcut icon" href="./img/Icono.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/r-2.2.9/datatables.min.css"/>
 
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-hard-hat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">TransLogic</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li id="mnuDashboard" class="nav-item">
                <a class="nav-link" href="main.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li id="mnuAsignacion" class="nav-item active">
                <a class="nav-link" href="bodega.php">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Asignacion Bodega</span></a>
            </li>
            <li id="mnuAsignacion" class="nav-item">
                <a class="nav-link" href="express.php">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Asignacion Express</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Main -->
            <li id="mnuContratistas" class="nav-item">
                <a class="nav-link" href="./contratistas.php">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Contratistas</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input hidden type="text" class="form-control bg-light border-0 small" placeholder="Buscar..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button hidden class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo($_SESSION['nombre']); ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" onclick="closeSession();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                    <!-- Assign Trip -->
                    <form action="bod-assign.php" method="POST">
                        <div class="input-group">
                            <input  type="text" class="form-control bg-light small" id="txtOrden" name="orden" placeholder="Orden de Materiales..." aria-label="Orden" aria-describedby="basic-addon2">
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <input  type="text" class="form-control bg-light small" id="txtPlaca" name="placa" placeholder="Placa de Transportista..." aria-label="Placa" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                    <i class="fa-solid fa-circle-plus"></i><span> Asignar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                   
                    <hr class="sidebar-divider d-none d-md-block">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Viajes de Bodega SIN ASIGNAR</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTablePlugin" name="acarreosTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Bodega</th>
                                            <th>Proyecto</th>
                                            <th>Correlativo</th>
                                            <th>Documento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($rs2 as $row2){ ?>
                                        <tr>
                                            <td><?=$row2['Fecha']; ?></td>
                                            <td><?=$row2['Bodega']; ?></td>
                                            <td><?=$row2['Proyecto']; ?></td>
                                            <td><?=$row2['Correlativo']; ?></td>
                                            <td><?=$row2['Documento']; ?></td>
                                            <td><button class="btn btn-block btn-success" onclick="asignar(<?=$row2['Correlativo']; ?>)"><i class="fa-solid fa-circle-plus"></i><span> Asignar</span></button></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Viajes de Bodega Asignados SIN FINALIZAR</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Fecha Asignado</th>
                                            <th>Documento</th>
                                            <th>Contratista</th>
                                            <th>Placa Transportista</th>
                                            <th>Asignado por:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($rs as $row){ ?>
                                        <tr>
                                            <td><?=$row['dtCreacion']; ?></td>
                                            <td><?=$row['numerodocumento']; ?></td>
                                            <td><?=$row['nombre']; ?></td>
                                            <td><?=$row['nTransporte']; ?></td>
                                            <td><?=$row['uCreacion']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Viajes de Bodega FINALIZADOS</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTablePlugin" name="acarreosTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Correlativo</th>
                                            <th>N° Documento</th>
                                            <th>Contratista</th>
                                            <th>Transportista</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($rs3 as $row3){ ?>
                                        <tr>
                                            <td><?=$row3['dtCreacion']; ?></td>
                                            <td><?=$row3['dtCheckCompletado']; ?></td>
                                            <td><?=$row3['nOrden']; ?></td>
                                            <td><?=$row3['numerodocumento']; ?></td>
                                            <td><?=$row3['nombre']; ?></td>
                                            <td><?=$row3['nTransporte']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MrRX 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/r-2.2.9/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/App.js"></script>
</body>
</html>
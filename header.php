<?php
require_once "Conexion.php";
include_once "funciones.php";

session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $tittle; ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">

  <!-- Font Awesone CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link href="css/addons-pro/cards-extended.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">

  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png"/>

  <link rel="stylesheet" href="css/mis_estilos.css"/>
  

</head>

<body onload="mueveReloj()">


  <?php if (!empty($_SESSION['nombre_u']) or !empty($_SESSION['user_name']) and !empty($_SESSION['id'])) {

    $usu = $_SESSION['id'];

    $consulta = $base_de_datos->query("SELECT * FROM permisos_users WHERE user = '$usu' ");

    while ($permisos = $consulta->fetch()) {

      if ($permisos['permiso'] == '101') {
        $estado1001 = $permisos['estado_user'];
      }

      if ($permisos['permiso'] == '102') {
        $estado1002 = $permisos['estado_user'];
      }

      if ($permisos['permiso'] == '103') {
        $estado1003 = $permisos['estado_user'];
      }

      if ($permisos['permiso'] == '104') {
        $estado1004 = $permisos['estado_user'];
      }

      if ($permisos['permiso'] == '105') {
        $estado1005 = $permisos['estado_user'];
      }
    }

  ?>
    <?php

    date_default_timezone_set('America/Bogota');

    $fecha = date("Y-m-d");



    $fechayhora = date("d-m-Y");

    ?>

    ?>
    <div class="container-scroller" style="margin-top: -19px;">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
          <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="index.php"><img src="images/logo.svg" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/logo-mini.svg" alt="logo" /></a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-sort-variant"></span>
            </button>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown mr-5">
              <form name="form_reloj" class="mt-3">

                <div class="input-group row">
                  <input class="text-black form-control-plaintext input-lg negrita col-md-8" size="49" type="text" value="La Virginia, Risaralda / <?php echo $fechayhora.' -';?>">
                  <input class="form-control text-black negrita mt-2 text-center col-md-4 mr-5" style="height: 10px; width: 1em;" type="text" id="reloj" readonly>
                </div>

              </form>

            </li>
            <li class="nav-item dropdown mr-4">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell mx-0"></i>
                <span class="count"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notificaciones</p>
                <a class="dropdown-item">
                  <div class="item-thumbnail">
                    <div class="item-icon bg-info">
                      <i class="mdi mdi-account-box mx-0"></i>
                    </div>
                  </div>
                  <div class="item-content">
                    <h6 class="font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <img src="images/foto_perfil.png" alt="profile" />
                <span class="nav-profile-name"><?php echo $_SESSION['nombre_u'] . " " . $_SESSION['apellido_u']; ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <?php if ($estado1001 == 'Habilitado') { ?>

                  <a class="dropdown-item" href="permisos.php">
                    <i class="mdi mdi-settings text-primary"></i>
                    Permisos
                  </a>

                <?php } ?>
                <a class="dropdown-item" href="cerrar_sesion.php">
                  <i class="mdi mdi-logout text-primary"></i>
                  Cerrar Sesión
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <i class="fas fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="cliente.php">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Clientes</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="fas fa-file-invoice-dollar menu-icon"></i>
                <span class="menu-title">Factura</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="factura.php"> Ver Facturas </a></li>
                  <li class="nav-item"> <a class="nav-link" href="nueva_factura.php"> Nueva Factura</a></li>

                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="productos.php">
                <i class="fas fa-box menu-icon"></i>
                <span class="menu-title">Productos</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="proveedores.php">
                <i class="fas fa-user-tie menu-icon"></i>
                <span class="menu-title">Proveedores</span>
              </a>
            </li>
            <?php if ($estado1001 == 'Habilitado') { ?>
              <li class="nav-item">
                <a class="nav-link" href="usuarios.php">
                  <i class="fas fa-user menu-icon"></i>
                  <span class="menu-title">Usuarios</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="documentation/documentation.html">
                  <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                  <span class="menu-title">Documentation</span>
                </a>
              </li>
            <?php } ?>

          </ul>
        </nav>
        <!-- partial -->


      <?php } else {

      header("Location: login.php");
    } ?>
<?php
 require_once "Conexion.php"; 
 include_once "funciones.php";

 session_start();

 
 if(!empty($_SESSION['nombre_u']) OR !empty($_SESSION['user_name']) AND !empty($_SESSION['id']) )  {
    
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

<div class="container-scroller">
  <!-- partial:partials/_navbar.html -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
        <a class="navbar-brand brand-logo" href="index.php"><img src="images/logo.svg" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/logo-mini.svg" alt="logo"/></a>
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-sort-variant"></span>
        </button>
      </div>  
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown mr-1">
          <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
            <i class="mdi mdi-message-text mx-0"></i>
            <span class="count"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
            <p class="mb-0 font-weight-normal float-left dropdown-header">Mensajes</p>
            
            <a class="dropdown-item">
              <div class="item-thumbnail">
                  <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
              </div>
              <div class="item-content flex-grow">
                <h6 class="ellipsis font-weight-normal"> Johnson
                </h6>
                <p class="font-weight-light small-text text-muted mb-0">
                  Upcoming board meeting
                </p>
              </div>
            </a>
          </div>
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
            <img src="images/faces/face5.jpg" alt="profile"/>
            <span class="nav-profile-name"><?php echo $_SESSION['nombre_u']." ".$_SESSION['apellido_u']; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <?php if ($estado1001 == 'Habilitado'): ?>

            <a class="dropdown-item" href="permisos.php">
              <i class="mdi mdi-settings text-primary"></i>
              Permisos 
            </a>

            <?php endif ?>

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
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cliente.php">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Clientes</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="factura.php">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Nueva Factura</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">
            <i class="fas fa-box menu-icon"></i>
            <span class="menu-title">Productos</span>
          </a>
        </li>
        <?php if ($estado1001 == 'Habilitado'){ ?>
        <li class="nav-item">
          <a class="nav-link" href="usuarios.php">
            <i class="mdi mdi-account menu-icon"></i>
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


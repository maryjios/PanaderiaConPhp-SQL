<?php

$tittle = "Inicio";
include_once "header.php";

?>

<?php if (!empty($_SESSION['nombre_u']) or !empty($_SESSION['user_name']) and !empty($_SESSION['id'])) { ?>


  <?php

  if (!empty($_POST['titulo'])) {

    $usuario = $_SESSION['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fech = $fecha;


    $sqls = $base_de_datos->prepare("INSERT INTO tareas_temp(titulo, descripcion, usuario, fecha) VALUES(:titulo, :descripcion, :usuario, :fecha)");

    $sqls->bindParam(':titulo', $titulo);
    $sqls->bindParam(':descripcion', $descripcion);
    $sqls->bindParam(':usuario', $usuario);
    $sqls->bindParam(':fecha', $fech);


    $resultado = $sqls->execute();
  }

  ?>

  <!-- Modal agregar nueva tarea -->
  <div class="modal fade right" id="agregar_tarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="t`rue">
    <div class="modal-dialog modal-notify modal-danger modal-side modal-top-right" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <h5 class="heading texy-center">Agregar Nueva Tarea</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>
        <form METHOD="POST">

          <!--Body-->
          <div class="modal-body">

            <div class="mb-3">
              <label for="titulo" class="form-label">Titulo</label>
              <input type="text" class="form-control" name="titulo" aria-describedby="emailHelp" placeholder="Escribe un titulo">
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea type="text" class="form-control" name="descripcion" placeholder="Agrega una descripción"></textarea>
            </div>

          </div>

          <!--Footer-->
          <div class="modal-footer justify-content-center">
            <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancelar</a>
            <button type="submit" class="btn btn-success">Agregar</button>
          </div>
        </form>
      </div>
      <!--/.Content-->
    </div>
  </div>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
              <div class="mr-md-3 mr-xl-5">
                <h2>Bienvenido</h2>
                <p class="mb-md-0">ADMIN.</p>
              </div>
              <div class="d-flex">
                <i class="mdi mdi-home text-muted hover-cursor"></i>
                <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                <p class="text-primary mb-0 hover-cursor">Analytics</p>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-end flex-wrap">
              <button type="button" class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block ">
                <i class="mdi mdi-download text-muted"></i>
              </button>
              <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                <i class="mdi mdi-clock-outline text-muted"></i>
              </button>
              <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                <i class="mdi mdi-plus text-muted"></i>
              </button>
              <button class="btn btn-primary mt-2 mt-xl-0">Generate report</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <?php if ($_SESSION['tipo_u'] == 'Admin') { ?>

          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body dashboard-tabs p-0">


                <div class="tab-content py-0 px-0">

                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <div class="d-flex flex-wrap justify-content-xl-between">
                      <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class="mdi mdi-archive mr-3 icon-lg text-warning"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <?php
                          $query_procutos = $base_de_datos->query("SELECT COUNT(id) AS productos FROM producto");
                          if ($productos = $query_procutos->fetch()) { ?>
                            <small class="mb-1 text-muted">PRODUCTOS</small>
                            <h5 class="mr-2 mb-0 text-center"><?php echo $productos['productos']; ?></h5>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class="mdi mdi-currency-usd mr-3 icon-lg text-success"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <?php
                          $query_fecha = $base_de_datos->query("SELECT SUM(total) as totalcito FROM factura WHERE fecha LIKE'%$fecha%' ");
                          if ($fechita = $query_fecha->fetch()) { ?>
                            <small class="mb-1 text-muted">TOTAL VENTAS</small>
                            <h5 class="mr-2 mb-0 text-center"><?php echo intval($fechita['totalcito']); ?></h5>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class="mdi mdi-account-multiple mr-3 icon-lg text-primary"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <?php
                          $query_clientes = $base_de_datos->query("SELECT COUNT(id) AS clientes FROM cliente");
                          if ($clientes = $query_clientes->fetch()) { ?>
                            <small class="mb-1 text-muted">CLIENTES</small>
                            <h5 class="mr-2 mb-0 text-center"><?php echo $clientes['clientes']; ?></h5>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                        <i class="mdi mdi-account mr-3 icon-lg text-danger"></i>
                        <div class="d-flex flex-column justify-content-around">
                          <?php
                          $query_usuarios = $base_de_datos->query("SELECT COUNT(id) AS usuarios FROM usuario");
                          if ($usuarios = $query_usuarios->fetch()) { ?>
                            <small class="mb-1 text-muted">USUARIOS</small>
                            <h5 class="mr-2 mb-0 text-center"><?php echo $usuarios['usuarios']; ?></h5>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="row">

        <div class="col-md-5 grid-margin stretch-card">
          <!-- Card -->
          <div class="card">

            <!-- Card image -->
            <div class="view overlay">
              <img class="card-img-top" src="images/bg.png" alt="Card image cap" height="200px">
              <a>
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <!-- Button -->
            <button type="button" class="btn-floating ml-auto btn btn-success btn-rounded btn-icon mr-3" style="margin-top: -20px;" data-toggle="modal" data-target="#agregar_tarea">
              <i class="mdi mdi-plus"></i>
            </button>
            <h2 class="card-title text-center">Agregar una nota</h2>
            <hr>

            <div class="card-body">
              <?php

              $usuar = $_SESSION['id'];
              $consulta = $base_de_datos->query("SELECT * FROM tareas_temp WHERE usuario = '$usuar'");

              while ($datos = $consulta->fetch()) {
                $id = $datos['id'];
                $titulo = $datos['titulo'];
                $descripcion = $datos['descripcion'];
                $fechaa = $datos['fecha'];

              ?>
                <!-- Title -->
                <div class="row">
                  <p class="mr-5"><?php echo $titulo; ?></p>
                  <li class="list-inline-item pr-2 white-text ml-5"><i class="far fa-clock pr-1"></i><?php echo $fechaa ?></li>
                </div>

                <div class="row">


                  <p class="card-text text-muted col-md-8 mt-3"><?php echo $descripcion  ?></p>
                  <form action="" method="POST" align="right">
                    <input type="hidden" class="" name="id_tarea" value="<?php echo $id; ?>">
                    <button type="submit" id="tarea_enviada" class="btn btn-danger btn-rounded btn-icon ml-5">
                      <i class="fa fa-trash" style="font-size: 15px;"></i>
                    </button>
                  </form>
                </div>
                <hr>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->

    <?php if (!empty($_POST['id_tarea'])) {
      $id = $_POST['id_tarea'];
      $sql_delete = $base_de_datos->query("DELETE FROM tareas_temp WHERE id = '$id'");

      if ($sql_delete) {
        echo '<meta http-equiv="refresh" content="0;url=login.php">';
      }
    } ?>

    <?php include_once "footer.php"; ?>


  <?php } else {

  header("Location: login.php");
} ?>
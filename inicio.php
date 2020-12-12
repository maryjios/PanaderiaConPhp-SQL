<?php

include_once "factura_controller.php";
$tittle = "Inicio";

include_once "header.php" ?>

<?php if (!empty($_SESSION['nombre_u']) or !empty($_SESSION['user_name']) and !empty($_SESSION['id'])) { ?>

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
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body dashboard-tabs p-0">
              <ul class="nav nav-tabs px-4" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                </li>
              </ul>
              <div class="row">


              </div>
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
                          <small class="mb-1 text-muted">VENTAS</small>
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
      </div>
      <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
          <!-- Card -->
          <div class="card map-card">

            <!--Google map-->
            <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 100px">
              <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>

            <!-- Card content -->
            <div class="card-body closed px-0">

              <div class="button px-2 mt-3">
                <a class="btn-floating btn-lg living-coral float-right"><i class="fas fa-bicycle"></i></a>
              </div>

              <div class="white px-4 pb-4 pt-3-5">

                <!-- Title -->
                <h5 class="card-title h5 living-coral-text">Central Park Zoo</h5>

                <div class="d-flex justify-content-between living-coral-text">
                  <h6 class="card-subtitle font-weight-light">A place to relax</h6>
                  <h6 class="font-small font-weight-light mt-n1">25 min</h6>
                </div>

                <hr>

                <div class="d-flex justify-content-between pt-2 mt-1 text-center text-uppercase living-coral-text">
                  <div>
                    <i class="fas fa-phone fa-lg mb-3"></i>
                    <p class="mb-0">Call</p>
                  </div>
                  <div>
                    <i class="fas fa-cat fa-lg mb-3"></i>
                    <p class="mb-0">Love</p>
                  </div>
                  <div>
                    <i class="far fa-grin-beam-sweat fa-lg mb-3"></i>
                    <p class="mb-0">Smile</p>
                  </div>
                </div>

                <hr>

                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <th scope="row" class="px-0 pb-3 pt-2">
                        <i class="fas fa-map-marker-alt living-coral-text"></i>
                      </th>
                      <td class="pb-3 pt-2">East 64th Street, New York, NY 10021, US</td>
                    </tr>
                    <tr class="mt-2">
                      <th scope="row" class="px-0 pb-3 pt-2">
                        <i class="far fa-clock living-coral-text"></i>
                      </th>
                      <td class="pb-3 pt-2"><span class="deep-purple-text mr-2"> Closed</span> Opens 10 AM</td>
                    </tr>
                    <tr class="mt-2">
                      <th scope="row" class="px-0 pb-3 pt-2">
                        <i class="fas fa-cloud-moon living-coral-text"></i>
                      </th>
                      <td class="pb-3 pt-2">Sunny weather tomorrow</td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>

          </div>
          <!-- Card -->
        </div>

  <?php } else {

  header("Location: login.php");
} ?>          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->


    <?php include_once "footer.php"; ?>


  <?php } else {

  header("Location: login.php");
} ?>
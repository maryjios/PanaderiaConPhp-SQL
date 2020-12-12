  <!-- incluyendo el controlador de la factura -->
  <?php


  $tittle = "panaderia | nueva factura";

  include_once "header.php" ?>

  <?php if (!empty($_SESSION['nombre_u']) or !empty($_SESSION['user_name']) and !empty($_SESSION['id'])) { ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 stretch-card">
            <div class="card">
              <div class="card-header bg-primary text-white">
                <i class="fas fa-edit mr-2"></i>Nueva Factura
              </div>
              <div class="card-body" style="margin-top: -45px">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <a href="#" class="btn btn-primary btn_new_cliente mt-5 ml-4"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
                      </div>
                      <div class="card border-0">
                        <div class="card-body">
                          <h4 class="mb-4">Datos del Cliente:</h4>
                          <form method="post" name="form_registrar_cliente" id="form_registrar_cliente">
                            <input type="hidden" name="action" value="agregar_client">
                            <div class="row">
                              <div class="col-lg-2">
                                <div class="form-group">
                                  <label>Cedula</label>
                                  <input type="number" name="id_cliente" id="id_cliente" class="form-control form-control-sm el_cliente">
                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label>Nombre</label>
                                  <input type="text" name="nom_cliente" id="nom_cliente" class="form-control form-control-sm el_cliente" disabled required>
                                </div>
                              </div>

                              <div class="col-lg-2">
                                <div class="form-group">
                                  <label>Teléfono</label>
                                  <input type="number" name="tel_cliente" id="tel_cliente" class="form-control form-control-sm el_cliente" disabled required>
                                </div>
                              </div>
                              <div class="col-lg-2">
                                <div class="form-group">
                                  <label>Dirrección</label>
                                  <input type="text" name="dir_cliente" id="dir_cliente" class="form-control form-control-sm el_cliente" disabled required>
                                </div>
                              </div>

                              <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Correo Electronico</label>
                                   <input type="email" name="email_cliente" id="email_cliente" class="form-control form-control-sm" disabled required>
                                 </div>
                               </div>

                              <div id="agregar_cliente">
                                <button type="submit" class="btn btn-primary mb-5">Guardar</button>
                              </div>
                            </div>
                          </form>

                          <h4 class="mb-4">Datos de la Factura:</h4>
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Vendedor:</label>
                                <input type="hidden" id="token_usuario" value="<?php echo md5($_SESSION['id']); ?>">
                                <input type="text" name="nom_clienete" id="nom_clienete" class="form-control form-control-sm" disabled value="<?php echo $_SESSION['nombre_u'] . " " . $_SESSION['apellido_u']; ?>">
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Fecha:</label>
                                <input type="text" name="fecha" id="fecha" class="form-control form-control-sm" value="<?php echo $fecha ?>" disabled>
                              </div>
                            </div>

                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Metodo de Pago</label>
                                <input type="number" name="tel_cliente" id="tel_cliente" class="form-control form-control-sm" required>
                              </div>
                            </div>
                          </div>

                          <!-- ------------ -->
                          <div class="table-responsive">
                            <table class="table table-hover table_items" id="detalle_factura">
                              <thead>
                                <tr>
                                  <th class="th">Código</th>
                                  <th class="th">Producto.</th>
                                  <th class="th">Stock</th>
                                  <th class="th">Cantidad</th>
                                  <th class="textright th">Precio Unit.</th>
                                  <th class="textright th">Subtotal</th>
                                  <th class="th">Acciones</th>
                                </tr>
                                <tr>
                                  <td><input type="text" name="cod_producto" id="cod_producto" class="cod_producto datos_items"></td>
                                  <td id="txt_descripcion">-</td>
                                  <td id="txt_existencia">-</td>
                                  <td><input size="4" type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                                  <td id="txt_precio" class="textright">0.00</td>
                                  <td id="txt_precio_total" class="txtright datos_items">0.00</td>
                                  <td><a href="#" id="agregar_a_factura" class="btn btn-dark">Agregar</a></td>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <div class="table-wrapper">
                            <table class="table table-fixed table_items">
                              <tr>
                                <th class="th">Código</th>
                                <th class="th">Producto</th>
                                <th class="th">Cantidad</th>
                                <th class="textright th">Precio Unit.</th>
                                <th class="textright th">Subtotal</th>
                                <th class="th" colspan="2">Acciones</th>
                              </tr>

                              <tbody class="detalle_venta" id="detalle_venta">

                              </tbody>
                            </table>
                          </div>
                          
                          <div class="table-responsive">
                            <table id="detalle_totales" class="table table-hover detalle_totales table_items">
                            </table>
                          </div>

                          <!-- Boton generar factura de venta -->
                          <hr>
                          <div class="container my-3 mr-5">
                            <button class="btn btn-success float-right" id="generarFactura">Generar Factura</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

          </div>
        </div>
      </div>
    </div>
    </div>
    <!-- Modal proceso generar factura exitoso -->

    <div class="modal fade" id="modalFacturaExitosa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-notify modal-success" role="document">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <p class="heading lead">FACTURA REGISTRADA</p>

            <button type="button" class="close btnFacturaRegistrar" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>

          <!--Body-->
          <div class="modal-body">
            <div class="text-center">
              <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
              <p>Factura generada con exito</p>
            </div>
          </div>

          <!--Footer-->
          <div class="modal-footer justify-content-center">
            <a type="button" class="btn btn-outline-success waves-effect btnFacturaRegistrar" data-dismiss="modal">OK</a>
          </div>
        </div>
        <!--/.Content-->
      </div>
    </div>
    <!-- content-wrapper ends -->
  <?php
    include_once "footer.php";
  } else {

    header("Location: login.php");
  } ?>
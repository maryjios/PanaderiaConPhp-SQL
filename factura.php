<?php

$tittle = "panaderia | permisos";

include_once "header.php";
if ($estado1005 == '1') { ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-header">
              <h4>Consultar Factura</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="recent-purchases-listing" class="table">
                  <thead>
                    <tr class="text-center">
                      <th size="2">Codigo</th>
                      <th>Cliente</th>
                      <th>Vendedor</th>
                      <th>Fecha</th>
                      <th>Total</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Consultar Clientes
                    $consulta = $base_de_datos->query("SELECT factura.codigo as codigo, cliente.nombre as cliente, cliente.telefono as tel_c, cliente.direccion as direc_c, usuario.nombre AS vendedor_nom, usuario.apellido AS vendedor_ape, factura.fecha AS fecha, factura.total AS total, factura.estado_factura AS estado FROM factura JOIN cliente ON factura.id_cliente = cliente.id JOIN usuario ON factura.id_vendedor = usuario.id");

                    while ($datos = $consulta->fetch()) {

                      $codigo = $datos['codigo'];
                      $cliente = $datos['cliente'];
                      $vendedor = $datos['vendedor_nom'] . ' ' . $datos['vendedor_ape'];
                      $fecha = $datos['fecha'];
                      $total = $datos['total'];
                      $estado = $datos['estado'];
                      $telefono_c = $datos['tel_c'];
                      $direccion_c = $datos['direc_c'];



                    ?>
                      <tr>
                        <td><?php echo $codigo; ?></td>
                        <td><?php echo $cliente; ?></td>
                        <td><?php echo $vendedor; ?></td>
                        <td><?php echo $fecha; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                          <?php if ($estado == 'Activa') { ?>

                            <button type="button" class="btn btn-success btn-icon-text">
                              <i class="mdi mdi-check btn-icon-prepend"></i><?php echo $estado; ?>
                            </button>

                          <?php } else { ?>

                            <button type="button" class="btn btn-danger btn-icon-text">
                              <i class="mdi mdi-close btn-icon-prepend"></i><?php echo $estado; ?>
                            </button>

                          <?php } ?>
                        </td>

                        <td>
                          <div class="row">
                            <div class="col-md-9 col-md-offset-9 col-xs-12 text-right">
                              <div class="btn-group" role="group">

                                <button class="btn text-white" type="button" data-toggle="modal" data-target="#ver_factura<?php echo $datos['codigo']; ?>" style="background: skyblue;">
                                  <i class="fa fa-eye"></i>
                                </button>


                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_factura<?php echo $datos['codigo']; ?>">
                                  <i class="fa fa-edit"></i>
                                </button>

                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>

                      <!-- Modal editar permisos -->
                      <div class="modal fade" id="editar_factura<?php echo $datos['codigo']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                        <form action="" method="POST">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Factura</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">

                                <input type="hidden" name="permiso_edit" value="<?php echo $codigo ?>">

                                <select name="estado_edit" class="custom-select" data-style="btn btn-info">
                                  <option value="<?php echo $estado ?>" selected><?php echo $estado ?></option>
                                  <?php if ($estado == "Activa") { ?>

                                    <option value="Inactiva">Inactiva</option>

                                  <?php } else { ?>

                                    <option value="Activa">Activa</option>

                                  <?php } ?>
                                </select>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" class="btn btn-primary" value="Guardar">
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>

                      <!-- Modal editar usuario -->
                      <div class="modal fade" id="ver_factura<?php echo $datos['codigo']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                        <form action="" method="POST">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h5 class="modal-title" id="exampleModalLabel">Factura De Venta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">

                                <div align="right">
                                  <div class="col-lg-2">
                                    <div class="form-group">
                                      <label>Num. Factura</label>
                                      <input type="number" name="id_cliente" id="id_cliente" class="form-control-plaintext form-control-sm el_cliente" value="<?php echo $codigo ?>">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-lg-3">
                                    <div class="form-group">
                                      <label>Cliente</label>
                                      <input type="text" name="nom_cliente" id="nom_cliente" class="form-control form-control-sm el_cliente" disabled required value="<?php echo $cliente ?>">
                                    </div>
                                  </div>

                                  <div class="col-lg-2">
                                    <div class="form-group">
                                      <label>Teléfono</label>
                                      <input type="number" name="tel_cliente" id="tel_cliente" class="form-control form-control-sm el_cliente" disabled value="<?php echo $telefono_c ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-2">
                                    <div class="form-group">
                                      <label>Dirrección</label>
                                      <input type="text" name="dir_cliente" id="dir_cliente" class="form-control form-control-sm el_cliente" disabled required value="<?php echo $direccion_c ?>">
                                    </div>
                                  </div>


                                  <!-- <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                      </tr>
                                      <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                      </tr>
                                      <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                      </tr>
                                    </tbody>
                                  </table> -->

                                </div> 
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                  <input type="submit" class="btn btn-primary" value="Guardar">
                                </div>
                              </div>
                            </div>
                        </form>
                      </div>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>


  <?php include_once "footer.php"; ?>


<?php
} else {


  $refresh = '<meta http-equiv="refresh" content="0;url=403.php">';
  echo $refresh;
} ?>
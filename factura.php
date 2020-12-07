<?php

$tittle = "panaderia | permisos";

include_once "header.php";
if ($estado1005 == 'Habilitado') { ?>

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
                    $consulta = $base_de_datos->query("SELECT factura.codigo as codigo, cliente.nombre as cliente, usuario.nombre AS vendedor_nom, usuario.apellido AS vendedor_ape, factura.fecha AS fecha, factura.total AS total, factura.estado_factura AS estado FROM factura JOIN cliente ON factura.id_cliente = cliente.id JOIN usuario ON factura.id_vendedor = usuario.id");

                    while ($datos = $consulta->fetch()) {

                      $codigo = $datos['codigo'];
                      $cliente = $datos['cliente'];
                      $vendedor = $datos['vendedor_nom'] . ' ' . $datos['vendedor_ape'];
                      $fecha = $datos['fecha'];
                      $total = $datos['total'];
                      $estado = $datos['estado'];


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


                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_permiso<?php echo $datos['codigo']; ?>">
                                  <i class="fa fa-edit"></i>
                                </button>

                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>

                      <!-- Modal editar permisos -->
                      <div class="modal fade" id="editar_permiso<?php echo $datos['codigo']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                        <form action="" method="POST">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Cliente</h5>
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

                      <div class="modal fade bd-example-modal-lg" id="ver_factura<?php echo $codigo ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <input type="hidden" name="permiso_edit" value="<?php echo $codigo ?>">
                            <?php

                            $query_items = $base_de_datos->query("SELECT * FROM item_factura WHERE cod_factura = '$codigo' ");

                            ?>
                            <select name="estado_edit" class="custom-select" data-style="btn btn-info">
                              <option value="<?php echo $estado ?>" selected><?php echo $estado ?></option>
                              <?php if ($estado == "Activa") { ?>

                                <option value="Inactiva">Inactiva</option>

                              <?php } else { ?>

                                <option value="Activa">Activa</option>

                              <?php } ?>
                            </select>
                          </div>
                        </div>
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


  <!-- Modal registrar nuevo cliente -->
  <div class="modal" id="nuevo_cliente" tabindex="-1" role="dialog">
    <form action="" method="POST">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Registrar Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="id" class="form-control-label mb-1">Identificacion:</label>
              <input id="id" name="id" type="number" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="nombre" class="form-control-label mb-1">Nombre:</label>
              <input id="nombre" name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="apellido" class="form-control-label mb-1">Apellido</label>
              <input id="apellido" name="apellido" type="text" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="telefono" class="form-control-label mb-1">Telefono:</label>
              <input id="telefono" name="telefono" type="number" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="direccion" class="form-control-label mb-1">Dirección:</label>
              <input id="direccion" name="direccion" type="text" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="correo" class="form-control-label mb-1">Correo Electronico:</label>
              <input id="correo" name="correo" type="email" class="form-control" aria-required="true" aria-invalid="false">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <input class="btn btn-primary" type="submit" value="Guardar" name="nuevo_cliente">
          </div>
        </div>
      </div>
    </form>
  </div>

  <?php include_once "footer.php"; ?>


<?php
} else {


  $refresh = '<meta http-equiv="refresh" content="0;url=403.php">';
  echo $refresh;
} ?>
<?php

$tittle = "panaderia | permisos";

include_once "header.php"; 
if ($estado1001 == 'Habilitado') { ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-header">
              <h4>Permisos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="recent-purchases-listing" class="table">
                  <thead>
                    <tr>
                      <th>Permiso</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Consultar Clientes
                    $consulta = $base_de_datos->query("SELECT permisos_users.cod, permisos_users.permiso, permisos_users.user, permisos_users.estado_user, permisos.nombre AS per, CONCAT(usuario.nombre,' ',usuario.apellido) AS usu FROM permisos_users JOIN permisos ON permisos_users.permiso = permisos.id JOIN usuario ON permisos_users.user = usuario.id");

                    while ($datos = $consulta->fetch()) {

                      $cod = $datos['cod'];
                      $id_permiso = $datos['permiso'];
                      $permiso = $datos['per'];
                      $usuario = $datos['usu'];
                      $estado = $datos['estado_user'];

                    ?>
                      <tr>
                        <td><?php echo $permiso; ?></td>
                        <td><?php echo $usuario; ?></td>

                        <?php if ($estado == 'Habilitado') { ?>
                          <td>

                            <button type="button" class="btn btn-success btn-icon-text">
                              <i class="mdi mdi-check btn-icon-prepend"></i><?php echo $estado; ?>
                            </button>
                          <td>
                          <?php } else { ?>

                          <td>

                            <button type="button" class="btn btn-danger btn-icon-text">
                              <i class="mdi mdi-close btn-icon-prepend"></i><?php echo $estado; ?>
                            </button>
                          <td>

                          <?php } ?>


                          <div class="row">
                            <div class="col-md-9 col-md-offset-9 col-xs-12 text-right">
                              <div class="btn-group" role="group">

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_permiso<?php echo $datos['cod']; ?>">
                                  <i class="fa fa-edit"></i>
                                </button>


                                <button class="btn bg-danger text-white" type="button" data-toggle="modal" data-target="#eliminar_producto<?php echo $datos['cod']; ?>"><i class="fa fa-trash"></i></button>

                              </div>
                            </div>
                          </div>
                          </td>
                      </tr>

                      <!-- Modal editar permisos -->
                      <div class="modal fade" id="editar_permiso<?php echo $datos['cod']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
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

                                <input type="hidden" name="permiso_edit" value="<?php echo $id ?>">
                                <input type="hidden" name="usuario_edit" value="<?php echo $usuario ?>">

                                <select name="estado_edit" class="custom-select" data-style="btn btn-info">
                                  <option value="<?php echo $estado ?>" selected><?php echo $estado ?></option>
                                  <?php if ($estado == "Habilitado") { ?>

                                    <option data-target="" value="Inhabilitado">Inhabilitado</option>

                                  <?php } else { ?>

                                    <option value="Habilitado">Habilitado</option>


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
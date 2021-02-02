<?php
$tittle = "Clientes";

include_once "header.php" ?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="row">
          <div class="col-md-12 stretch-card">
            <div class="card">
              <div class="card-body">
                <div align="right">
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#nuevo_usuario">Agregar Nuevo <i class="mdi mdi-account-plus"></i></button>
                </div>
                <p class="card-title">Recent Purchases</p>
                <div class="table-responsive">
                  <table id="recent-purchases-listing" class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Telefono</th>
                        <th>Dirección</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                      </tr>
                    </thead>


                    <?php

                    $contador = 0;

                    // Registrar usuarios
                    if (!empty($_POST['nombre']) and !empty($_POST['id']) and !empty($_POST['usuario']) and !empty($_POST['contrasena'])) {

                      $id = $_POST['id'];
                      $nombre = $_POST['nombre'];
                      $apellido = $_POST['apellido'];
                      $usuario = $_POST['usuario'];
                      $con = $_POST['contrasena'];
                      $telefono = $_POST['telefono'];
                      $direccion = $_POST['direccion'];
                      $tipo = $_POST['tipo'];


                      $consulta_tipo = $base_de_datos->query("SELECT id FROM tipo_user");

                      while ($array_id = $consulta_tipo->fetch()) {
                        $el_tipo = $array_id['id'];
                      }


                      $habilitado = "1";
                      $inhabilitado = "2";


                      $sql = $base_de_datos->query("SELECT * FROM usuario WHERE id = '$id' ");

                      while ($array = $sql->fetch()) {

                        $contador++;
                      }


                      if ($contador != 0) {

                        echo mensajes('El usuario ya existe<br>', 'amarillo');
                      } else {

                        $contrasena = password_hash($con, PASSWORD_DEFAULT);

                        $consulta = $base_de_datos->prepare("INSERT INTO usuario (id, nombre, apellido, usuario, contrasena, telefono, direccion, tipo_usuario) VALUES (:id, :nom, :ape, :usu, :con, :tel, :direc, :tipo)");


                        $consulta->bindParam(':id', $id);
                        $consulta->bindParam(':nom', $nombre);
                        $consulta->bindParam(':ape', $apellido);
                        $consulta->bindParam(':usu', $usuario);
                        $consulta->bindParam(':con', $contrasena);
                        $consulta->bindParam(':tel', $telefono);
                        $consulta->bindParam(':direc', $direccion);
                        $consulta->bindParam(':tipo', $el_tipo);

                        $resultado = $consulta->execute();


                        $sql_permisos = $base_de_datos->query("SELECT * FROM permisos");

                        if ($tipo == 'Admin') {

                          while ($row = $sql_permisos->fetch()) {

                            $permiso = $row['id'];

                            $sql_p_users = $base_de_datos->prepare("INSERT INTO permisos_users(permiso,user,estado_user) VALUES (:permiso, :usuario, :estado);");

                            $sql_p_users->bindParam(':permiso', $permiso);
                            $sql_p_users->bindParam(':usuario', $id);
                            $sql_p_users->bindParam(':estado', $habilitado);

                            $resultado_insertp = $sql_p_users->execute();
                          }
                        } // fin de condiciones para permisos del usuario

                        if ($tipo == 'Cajero') {

                          while ($row = $sql_permisos->fetch()) {

                            $permiso = $row['id'];

                            if ($permiso == '101' or $permiso == '103' or $permiso == '104') {

                              $sql_p_users = $base_de_datos->prepare("INSERT INTO permisos_users(permiso,user,estado_user) VALUES (:permiso, :usuario, :estado);");

                              $sql_p_users->bindParam(':permiso', $permiso);
                              $sql_p_users->bindParam(':usuario', $id);
                              $sql_p_users->bindParam(':estado', $inhabilitado);

                              $resultado_insertp = $sql_p_users->execute();
                            } else {

                              $sql_p_users = $base_de_datos->prepare("INSERT INTO permisos_users(permiso,user,estado_user) VALUES (:permiso, :usuario, :estado);");

                              $sql_p_users->bindParam(':permiso', $permiso);
                              $sql_p_users->bindParam(':usuario', $id);
                              $sql_p_users->bindParam(':estado', $habilitado);

                              $resultado_insertp = $sql_p_users->execute();
                            }
                          }
                        } // fin de condiciones para permisos del empleado

                        if ($resultado) {
                          $mensaje = mensajes('Usuario Satisfactoriamente Creado<br>', 'verde');
                        } else {
                          $mensaje =  mensajes('Ops! el usuario no se pudo registrar<br>', 'rojo');
                        }
                      }
                    } ?>

                    <tbody>
                      <?php

                      // Consultar Usuarios

                      $consulta = $base_de_datos->query("SELECT usuario.*, tipo_user.nombre AS tipo FROM usuario JOIN tipo_user ON usuario.tipo_usuario = tipo_user.id ");
                      $contadorsito = 0;

                      while ($datos = $consulta->fetch()) {
                        $contadorsito++;
                        $id = $datos['id'];
                        $nombre = $datos['nombre'];
                        $apellido = $datos['apellido'];
                        $usuario = $datos['usuario'];
                        $telefono = $datos['telefono'];
                        $direccion = $datos['direccion'];
                        $estado = $datos['estado'];
                        $tipo = $datos['tipo'];

                      ?>

                        <tr>
                          <td><?php echo $contadorsito; ?></td>
                          <td><?php echo $id; ?></td>
                          <td><?php echo $nombre; ?></td>
                          <td><?php echo $apellido; ?></td>
                          <td><?php echo $usuario; ?></td>
                          <td><?php echo $telefono; ?></td>
                          <td><?php echo $direccion; ?></td>
                          <td><?php echo $tipo; ?></td>
                          <td>
                            <button type="button" class="btn btn-success btn-icon-text">
                              <i class="mdi mdi-check btn-icon-prepend"></i> <?php echo $estado; ?></td>
                          </button>
                          <td>

                            <div class="btn-group" role="group" aria-label="Basic example">
                              <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#ver_usuario<?php echo $datos['id']; ?>" style="background: skyblue; border-color: skyblue;"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_usuario<?php echo $datos['id']; ?>"><i class="fa fa-edit"></i></button>
                            </div>

                          </td>
                        </tr>
                        <!-- Modal editar usuario -->
                        <div class="modal fade" id="editar_usuario<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                          <form action="" method="POST">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header text-center">
                                  <h5 class="modal-title" id="exampleModalLabel">Modificar Usuario</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">

                                  <div class="form-group">
                                    <label for="id" class="form-control-label mb-1">Id:</label>
                                    <input name="id_edit" type="number" class="form-control" aria-required="true" aria-invalid="false" readonly value="<?php echo $datos['id']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                                    <input name="nombre_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['nombre']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="apellido" class="form-control-label mb-1">Apellido:</label>
                                    <input name="apellido_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['apellido']; ?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="direccion" class="form-control-label mb-1">Direccion:</label>
                                    <input type="text" name="direccion_edit" min="1" step="1" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['direccion']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="telefono" class="form-control-label mb-1">Telefono:</label>
                                    <input type="text" name="telefono_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['telefono']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="correo" class="form-control-label mb-1">Telefono:</label>
                                    <input type="text" name="correo_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['tipo']; ?>">
                                  </div>

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <input type="submit" class="btn btn-primary" value="Guardar">
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>

                        <!-- Modal ver usuario -->
                        <div class="modal fade" id="ver_usuario<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                          <form action="" method="POST">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header text-center">
                                  <h5 class="modal-title" id="exampleModalLabel">Ver Usuario</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">

                                  <div class="form-group">
                                    <label for="id" class="form-control-label mb-1">Id:</label>
                                    <input name="id_edit" type="number" class="form-control" aria-required="true" aria-invalid="false" readonly value="<?php echo $datos['id']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                                    <input name="nombre_edit" type="text" class="form-control" readonly value="<?php echo $datos['nombre']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="apellido" class="form-control-label mb-1">Apellido:</label>
                                    <input name="apellido_edit" type="text" class="form-control" readonly aria-invalid="false" value="<?php echo $datos['apellido']; ?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="direccion" class="form-control-label mb-1">Direccion:</label>
                                    <input type="text" name="direccion_edit" readonly class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['direccion']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="telefono" class="form-control-label mb-1">Telefono:</label>
                                    <input type="text" name="telefono_edit" readonly class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['telefono']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label for="correo" class="form-control-label mb-1">Tipo:</label>
                                    <input type="text" name="correo_edit" readonly class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['tipo']; ?>">
                                  </div>

                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    </div>
    <!-- content-wrapper ends -->
  </div>


  <!-- Modal registrar nuevo cliente -->
  <div class="modal" id="nuevo_usuario" tabindex="-1" role="dialog">
    <form action="" method="POST">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Registrar Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="id" class="form-control-label">Identificacion</label>
              <input type="number" id="id" name="id" class="form-control">
            </div>
            <div class="form-group">
              <label for="nombre" class=" form-control-label">Nombre:</label>
              <input type="text" id="nombre" name="nombre" class="form-control">
            </div>

            <div class="form-group">
              <label for="apellido" class=" form-control-label">Apellido</label>
              <input type="text" id="apellido" name="apellido" class="form-control">
            </div>

            <div class="form-group">
              <label for="usuario" class=" form-control-label">Usuario</label>
              <input type="text" id="usuario" name="usuario" class="form-control">
            </div>


            <div class="form-group">
              <label for="contrasena" class=" form-control-label">Contraseña</label>
              <input type="password" id="contrasena" name="contrasena" class="form-control">
            </div>

            <div class="form-group">
              <label for="telefono" class=" form-control-label">Telefono</label>
              <input type="number " id="telefono" name="telefono" class="form-control">
            </div>
            <div class="form-group">
              <label for="direccion" class=" form-control-label">Direccion</label>
              <input type="text" id="direccion" name="direccion" class="form-control">
            </div>

            <div class="form-group">
              <select name="tipo" class="custom-select" data-style="btn btn-info">
                <option disabled selected>Seleccione un tipo</option>
                <option value="Admin" selected>Admin</option>
                <option value="Cajero" selected>Cajero</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <input class="btn btn-primary" type="submit" value="Guardar" name="nuevo_usuario">
          </div>
        </div>
      </div>
    </form>
  </div>


  <?php include_once "footer.php"; ?>
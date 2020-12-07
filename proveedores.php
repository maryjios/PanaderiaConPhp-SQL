<?php

$tittle = "Clientes";

include_once "header.php" ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>Proveedores</h4>
                    </div>
                    <div class="card-body">
                        <div align="right">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#nuevo_cliente">Agregar Nuevo <i class="mdi mdi-account-plus"></i></button>
                        </div>
                        <div class="table-responsive">
                            <table id="recent-purchases-listing" class="table">
                                <thead>
                                    <!-- Modificar Cliente -->
                                    <?php

                                    if (
                                        !empty($_POST["id_edit"])
                                        || !empty($_POST["nombre_edit"])
                                        || !empty($_POST["telefono_edit"])
                                    ) {

                                        $id = ($_POST["id_edit"]);
                                        $nombre = ($_POST["nombre_edit"]);
                                        $telefono = ($_POST["telefono_edit"]);
                                        $direccion = ($_POST["direccion_edit"]);
                                        $correo = ($_POST["correo_edit"]);


                                        $sql = $base_de_datos->prepare("UPDATE cliente SET nombre = :nom, telefono = :tel, direccion = :direc, correo = :email WHERE id = :id ");

                                        $sql->bindParam(':nom', $nombre);
                                        $sql->bindParam(':tel', $telefono);
                                        $sql->bindParam(':direc', $direccion);
                                        $sql->bindParam(':email', $correo);
                                        $sql->bindParam(':id', $id);



                                        $resultado = $sql->execute();

                                        if ($resultado) {

                                            $mensaje_edit = "<script> alert('Modificación Exitosa'); </script>";

                                            echo $mensaje_edit;
                                        }
                                    } ?>

                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Telefono 2</th>
                                        <th>Correo Electronico</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>

                                <!-- Registrar Cliente -->
                                <?php
                                $mensaje = '';
                                if (!empty($_POST['nombre']) and !empty($_POST['telefono'])) {

                                    $nombre = $_POST['nombre'];
                                    $telefono = $_POST['telefono'];
                                    $telefono2 = $_POST['telefono2'];
                                    $correo = $_POST['correo'];




                                    $consulta = $base_de_datos->prepare("INSERT INTO proveedor(nombre, telefono, telefono2, correo) VALUES(:nom, :tel, :tel2, :email)");


                                    $consulta->bindParam(':nom', $nombre);
                                    $consulta->bindParam(':tel', $telefono);
                                    $consulta->bindParam(':tel2', $telefono2);
                                    $consulta->bindParam(':email', $correo);

                                    $resultado = $consulta->execute();
                                } ?>

                                <tbody>

                                    <?php
                                    // Consultar Clientes
                                    $consulta = $base_de_datos->query("SELECT * FROM proveedor");
                                    $contador = 0;

                                    while ($datos = $consulta->fetch()) {
                                        $contador++;
                                        $id = $datos['id'];
                                        $nombre = $datos['nombre'];
                                        $telefono = $datos['telefono'];
                                        $telefono2 = $datos['telefono2'];
                                        $correo = $datos['correo'];

                                    ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $nombre; ?></td>
                                            <td><?php echo $telefono; ?></td>
                                            <td><?php echo $telefono2; ?></td>
                                            <td><?php echo $correo; ?></td>


                                            <td>

                                                <div class="row">
                                                    <div class="col-md-9 col-md-offset-9 col-xs-12 text-right">
                                                        <div class="btn-group" role="group">

                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_proveedor<?php echo $datos['id']; ?>">
                                                                <i class="fa fa-edit"></i>
                                                            </button>


                                                            <button class="btn bg-danger text-white" type="button" data-toggle="modal" data-target="#eliminar_proveedor<?php echo $datos['id']; ?>"><i class="mdi mdi-account-remove"></i></button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Modal editar cliente-->
                                            <div class="modal fade" id="editar_proveedor<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_proveedor" aria-hidden="true">
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


                                                                <input id="id" name="id_edit" type="hidden" readonly value="<?php echo $datos['id']; ?>">

                                                                <div class="form-group">
                                                                    <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                                                                    <input id="nombre" name="nombre_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['nombre']; ?>">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="direccion" class="form-control-label mb-1">Telefono:</label>
                                                                    <input id="direccion" type="text" name="telefono_edit" min="1" step="1" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['telefono']; ?>">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="telefono" class="form-control-label mb-1">Telefono 2:</label>
                                                                    <input id="telefono" type="text" name="telefono2_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['telefono2']; ?>">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="correo" class="form-control-label mb-1">Telefono:</label>
                                                                    <input id="correo" type="text" name="correo_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['correo']; ?>">
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
                                        <?php } ?>
                                        </tr>
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
                    <h5 class="modal-title">Registrar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                        <input id="nombre" name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false">
                    </div>

                    <div class="form-group">
                        <label for="telefono" class="form-control-label mb-1">Telefono:</label>
                        <input id="telefono" name="telefono" type="number" class="form-control" aria-required="true" aria-invalid="false">
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="form-control-label mb-1">Telefono 2:</label>
                        <input id="direccion" name="telefono2" type="text" class="form-control" aria-required="true" aria-invalid="false">
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
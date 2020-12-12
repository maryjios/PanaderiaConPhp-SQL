<?php

$tittle = "Gastos";

include_once "header.php" ?>

<?php if (!empty($_SESSION['nombre_u']) or !empty($_SESSION['user_name']) and !empty($_SESSION['id'])) { ?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header">
            <h4>Gastos</h4>
          </div>
          <div class="card-body">
            <div align="right">
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#nuevo_gasto">Agregar Nuevo <i class="mdi mdi-account-plus"></i></button>
            </div>
            <div class="table-responsive">
              <table id="recent-purchases-listing" class="table">
                <thead>
                  <!-- Modificar Cliente -->
                  <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Total</th>
                    <th>Acciones</th>

                  </tr>
                </thead>

                <!-- Registrar Cliente -->
                <?php
                $mensaje = '';
                if (!empty($_POST['titulo']) and !empty($_POST['descripcion']) and !empty($_POST['total'])) {

                  $titulo = $_POST['titulo'];
                  $descripcion = $_POST['descripcion'];
                  $total = $_POST['total'];
                  
                  $consulta = $base_de_datos->prepare("INSERT INTO gastos(titulo, descripcion, total) VALUES(:titulo, :descrip, :total)");

                  $consulta->bindParam(':titulo', $titulo);
                  $consulta->bindParam(':descrip', $descripcion);
                  $consulta->bindParam(':total', $total);
                  

                  $resultado = $consulta->execute();

                } ?>

                <tbody>

                  <?php
                  // Consultar Clientes
                  $consulta = $base_de_datos->query("SELECT * FROM gastos");
                  $contador = 0;

                  while ($datos = $consulta->fetch()) {
                    $contador++;
                    $id = $datos['id'];
                    $titulo = $datos['titulo'];
                    $descripcion = $datos['descripcion'];
                    $total = $datos['total'];

                  ?>
                    <tr>
                      <td><?php echo $contador; ?></td>
                      <td><?php echo $titulo; ?></td>
                      <td><?php echo $descripcion; ?></td>
                      <td><?php echo $total; ?></td>


                      <td>

                        <div class="row">
                          <div class="col-md-9 col-md-offset-9 col-xs-12 text-right">
                            <div class="btn-group" role="group">

                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_cliente<?php echo $datos['id']; ?>">
                                <i class="fa fa-edit"></i>
                              </button>


                              <button class="btn bg-danger text-white" type="button" data-toggle="modal" data-target="#eliminar_cliente<?php echo $datos['id']; ?>"><i class="mdi mdi-account-remove"></i></button>

                            </div>
                          </div>
                        </div>
                      </td>
                      <!-- Modal editar cliente-->
                      <div class="modal fade" id="editar_cliente<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                        <form action="" method="POST">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header text-center">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Gasto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">

                                <div class="form-group">
                                  <label for="id" class="form-control-label mb-1">Codigo:</label>
                                  <input id="id" name="id_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" readonly value="<?php echo $datos['id']; ?>">
                                </div>

                                <div class="form-group">
                                  <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                                  <input id="nombre" name="nombre_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['nombre']; ?>">
                                </div>

                                <div class="form-group">
                                  <label for="direccion" class="form-control-label mb-1">Descripcio:</label>
                                  <input id="direccion" type="text" name="direccion_edit" min="1" step="1" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['direccion']; ?>">
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


<!-- Modal registrar nuevo gasto -->
<div class="modal" id="nuevo_gasto" tabindex="-1" role="dialog">
  <form action="" method="POST">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar Gasto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="titulo" class="form-control-label mb-1">Titulo:</label>
            <input id="titulo" name="titulo" type="text" class="form-control" aria-required="true">
          </div>

          <div class="form-group">
            <label for="descripcion" class="form-control-label mb-1">Descripción:</label>
            <textarea id="descripcion" name="descripcion" type="text" class="form-control" aria-required="true"></textarea>
          </div>

          <div class="form-group">
            <label for="total" class="form-control-label mb-1">Valor Total:</label>
            <input id="total" name="total" type="number" class="form-control" aria-required="true">
          </div>

        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <input class="btn btn-primary" type="submit" value="Guardar" name="nuevo_gasto">
        </div>
      </div>
    </div>
  </form>
</div>


<?php include_once "footer.php"; 

} else{

header("Location: login.php");
} ?>
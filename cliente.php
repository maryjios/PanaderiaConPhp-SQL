
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registrar Clientes</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
 
  <!-- Font Awesone  CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <!-- endinject -->

  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>

  <?php include_once "header.php" ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Usuario</h4>
                <div align="right">
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#nuevo_cliente">Agregar Nuevo <i class="mdi mdi-account-plus"></i></button>
                </div>
                <div class="table-responsive">
                  <table id="recent-purchases-listing" class="table">
                    <thead>
                        <!-- Modificar Cliente -->
                        <?php 
                        
                        if (!empty($_POST["id_edit"]) 
                          || !empty($_POST["nombre_edit"]) 
                          || !empty($_POST["telefono_edit"])) 
                        {

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

                        <tr>
                          <th>#</th>
                          <th>Cedula</th>
                          <th>Nombre</th>
                          <th>Telefono</th>
                          <th>Direccion</th>
                          <th>Correo Electronico</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>

                      <!-- Registrar Cliente -->
                      <?php  
                      $mensaje = '';
                      if (!empty($_POST['nombre']) AND !empty($_POST['id']) AND !empty($_POST['telefono']) ){

                        $id = $_POST['id']; 
                        $nombre = $_POST['nombre'];
                        $apellido = $_POST['apellido'];
                        $telefono = $_POST['telefono'];
                        $direccion = $_POST['direccion'];
                        $correo = $_POST['correo'];


                        
                        $consulta = $base_de_datos->prepare("INSERT INTO cliente(id, nombre, telefono, direccion, correo) VALUES(:id, :nom, :tel, :direc, :email)");

                        

                        $consulta->bindParam(':id', $id);
                        $consulta->bindParam(':nom', $nombre);
                        $consulta->bindParam(':tel', $telefono);
                        $consulta->bindParam(':direc', $direccion);
                        $consulta->bindParam(':email', $correo);

                        $resultado = $consulta->execute();

                        } ?>

                        <tbody>

                          <?php 
                          // Consultar Clientes
                          $consulta = $base_de_datos->query("SELECT * FROM cliente");
                          $contador = 0;

                          while ($datos = $consulta->fetch()) {
                            $contador++;
                            $id=$datos['id'];
                            $nombre=$datos['nombre'];
                            $telefono=$datos['telefono'];
                            $direccion=$datos['direccion'];
                            $correo=$datos['correo'];

                          ?>
                          <tr>
                            <td><?php echo $contador; ?></td>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nombre; ?></td>
                            <td><?php echo $direccion; ?></td>
                            <td><?php echo $telefono; ?></td>
                            <td><?php echo $correo; ?></td>


                            <td>
                                
                              <div class="row">
                                <div class="col-md-9 col-md-offset-9 col-xs-12 text-right" >
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
                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Cliente</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">

                                    <div class="form-group">
                                      <label for="id" class="form-control-label mb-1">Codigo:</label>
                                      <input id="id" name="id_edit" type="number" class="form-control" aria-required="true" aria-invalid="false" readonly value="<?php echo $datos['id']; ?>">
                                    </div>

                                    <div class="form-group">
                                      <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                                      <input id="nombre" name="nombre_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['nombre']; ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                      <label for="direccion" class="form-control-label mb-1">Direccion:</label>
                                      <input id="direccion" type="text" name="direccion_edit" min="1" step="1" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['direccion']; ?>">
                                    </div>

                                    <div class="form-group">
                                      <label for="telefono" class="form-control-label mb-1">Telefono:</label>
                                      <input id="telefono" type="text" name="telefono_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['telefono']; ?>">
                                    </div>

                                    <div class="form-group">
                                      <label for="correo" class="form-control-label mb-1">Telefono:</label>
                                      <input id="correo" type="text" name="correo_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['correo']; ?>">
                                    </div>

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" class="btn btn-primary" value="Guardar" >
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
              <label for="nombre" class="form-control-label mb-1">Nombre Completo:</label>
              <input id="nombre" name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false">
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

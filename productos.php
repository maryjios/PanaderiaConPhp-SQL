
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Usuarios</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
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
              <h4 class="card-title">Usuarios</h4>
              <div align="right">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#nuevo_producto">Agregar Nuevo <i class="mdi mdi-account-plus"></i></button>
              </div>
              <div class="table-responsive">
                <table id="recent-purchases-listing" class="table">
                   <!-- Modificar Producto -->
                  <?php 

                  if (!empty($_POST["id_edit"]) 
                    || !empty($_POST["nombre_edit"]) 
                    || !empty($_POST["cantidad_edit"])
                    || !empty($_POST["precio_edit"])) 
                  {

                    $id = ($_POST["id_edit"]);
                    $nombre = ($_POST["nombre_edit"]);
                    $cantidad = ($_POST["cantidad_edit"]);
                    $descripcion = ($_POST["descripcion_edit"]);
                    $precio = ($_POST["precio_edit"]);

                    $sql = $base_de_datos->prepare("UPDATE producto SET nombre= :nom, cantidad = :cant, descripcion = :descrip, precio = :precio WHERE id = :id ");

                    $sql->bindParam(':id', $id);
                    $sql->bindParam(':nom', $nombre);
                    $sql->bindParam(':cant', $cantidad);
                    $sql->bindParam(':descrip', $descripcion);
                    $sql->bindParam(':precio', $precio);


                    $resultado = $sql->execute();

                    if ($resultado) {

                      $mensaje_edit = "<script> alert('Modificación Exitosa'); </script>";

                      echo $mensaje_edit;
                    }

                  } ?>

                  <?php 

                  if (!empty($_POST["id_eliminar"])) {

                    $id_e = ($_POST["id_eliminar"]);


                    $sql = $base_de_datos->prepare("DELETE FROM producto WHERE id = :id ");

                    $sql->bindParam(':id', $id_e);

                    $res = $sql->execute();

                  } ?>


                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Descripcion</th>                    
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <?php  

                  $mensaje = '';
                  if (!empty($_POST['nombre']) AND !empty($_POST['precio']) AND !empty($_POST['descripcion']) AND !empty($_POST['cantidad']) ){

                    $id = $_POST['id'];
                    $nombre = $_POST['nombre'];
                    $descripcion = $_POST['descripcion'];
                    $precio = $_POST['precio'];
                    $cantidad = $_POST['cantidad'];



                    $consulta = $base_de_datos->prepare("INSERT INTO producto(id, nombre, descripcion, precio, cantidad) VALUES(:id, :nom, :descrip, :precio, :cant)");

                    $consulta->bindParam(':id', $id);
                    $consulta->bindParam(':nom', $nombre);
                    $consulta->bindParam(':descrip', $descripcion);
                    $consulta->bindParam(':precio', $precio);
                    $consulta->bindParam(':cant', $cantidad);

                    $resultado = $consulta->execute();



                  } ?>



                    <tbody>
                      <!-- Consultar Clientes -->
                      <?php

                      $consulta = $base_de_datos->query("SELECT * FROM producto");

                      while ($datos = $consulta->fetch()) {
                        $id=$datos['id'];
                        $nombre=$datos['nombre'];
                        $descripcion=$datos['descripcion'];
                        $cantidad=$datos['cantidad'];
                        $precio=$datos['precio'];


                        ?>
                        <tr>
                          <td><?php echo $id; ?></td>
                          <td><?php echo $nombre; ?></td>
                          <td><?php echo $descripcion; ?></td>
                          <td><?php echo "$".intval($precio); ?></td>
                          <td><?php echo $cantidad; ?></td>
                          <td>

                            <div class="row">
                              <div class="col-md-9 col-md-offset-9 col-xs-12 text-right" >
                                <div class="btn-group" role="group">

                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_producto<?php echo $datos['id']; ?>">
                                   <i class="fa fa-edit"></i>
                                 </button>


                                 <button class="btn bg-danger text-white" type="button" data-toggle="modal" data-target="#eliminar_producto<?php echo $datos['id']; ?>"><i class="fa fa-trash"></i></button>

                               </div>  
                             </div>
                           </div>
                         </td>
                       </tr>

                       <!-- Modal editar usuario-->

                       <div class="modal fade" id="editar_usuario<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
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
                                   <label for="id" class="form-control-label mb-1">Id:</label>
                                   <input id="id" name="id_edit" type="number" class="form-control" aria-required="true" aria-invalid="false" readonly value="<?php echo $datos['id']; ?>">
                                 </div>

                                 <div class="form-group">
                                   <label for="nombre" class="form-control-label mb-1">Nombre:</label>
                                   <input id="nombre" name="nombre_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['nombre']; ?>">
                                 </div>

                                 <div class="form-group">
                                   <label for="apellido" class="form-control-label mb-1">Apellido:</label>
                                   <input id="apellido" name="apellido_edit" type="text" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['apellido']; ?>">
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
                       <!-- Modal editar producto-->
                       <div class="modal fade" id="editar_producto<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar_producto" aria-hidden="true">
                         <form action="" method="POST">
                           <div class="modal-dialog" role="document">
                             <div class="modal-content">
                               <div class="modal-header text-center">
                                 <h5 class="modal-title" id="exampleModalLabel">Modificar Producto</h5>
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
                                   <label for="apellido" class="form-control-label mb-1">Descripcion</label>
                                   <textarea name="descripcion_edit" class="form-control"><?php echo $datos['descripcion']; ?></textarea>
                                 </div>

                                 <div class="form-group">
                                   <label for="cantidad" class="form-control-label mb-1">Cantidad:</label>
                                   <input type="hidden" id="cant_producto_actual"value="<?php echo $datos['cantidad']; ?>">

                                   <input id="cant_producto" type="number" name="cantidad_edit" min="1" step="1" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['cantidad']; ?>">
                                 </div>

                                 <div class="form-group">
                                   <label for="precio" class="form-control-label mb-1">Precio:</label>
                                   <input id="precio" type="text" name="precio_edit" class="form-control" aria-required="true" aria-invalid="false" value="<?php echo $datos['precio']; ?>">
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

                       <!-- Modal eliminar -->
                       <div class="modal fade right" id="eliminar_producto<?php echo $datos['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="t`rue">
                         <form action="" method="POST">                  
                           <div class="modal-dialog modal-notify modal-danger modal-side modal-top-right" role="document">
                             <!--Content-->
                             <div class="modal-content">
                               <!--Header-->
                               <div class="modal-header">
                                 <p class="heading">Eliminar Producto</p>

                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true" class="white-text">&times;</span>
                                 </button>
                               </div>
                               <!--Body-->
                               <div class="modal-body">
                                 <input type="hidden" id="id_eliminar"value="<?php echo $datos['id']; ?>">
                                 <div align="center">
                                   <div class="col-9">
                                     <p>¿ Seguro que deseas eliminar el producto <strong><?php echo $datos['nombre']; ?></strong></p>
                                   </div>
                                 </div>
                               </div>
                               <div class="modal-footer justify-content-center">
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                 <input type="submit" class="btn btn-danger" value="Eliminar" >
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

   <!-- Modal registrar nuevo producto -->
   <div class="modal" id="nuevo_producto" tabindex="-1" role="dialog">
    <form action="" method="POST">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Registrar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            <div class="form-group">
              <label for="id" class="form-control-label mb-1">Codigo:</label>
              <input id="id" name="id" type="number" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="nombre" class="form-control-label mb-1">Nombre:</label>
              <input id="nombre" name="nombre" type="text" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="apellido" class="form-control-label mb-1">Descripcion</label>
              <textarea name="descripcion" class="form-control">
                
              </textarea>
            </div>

            <div class="form-group">
              <label for="cantidad" class="form-control-label mb-1">Cantidad:</label>
              <input id="cantidad" type="number" name="cantidad" class="form-control" aria-required="true" aria-invalid="false">
            </div>

            <div class="form-group">
              <label for="precio" class="form-control-label mb-1">Precio:</label>
              <input id="precio" type="text" name="precio" class="form-control" aria-required="true" aria-invalid="false">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" type="submit" value="Guardar" name="nuevo_cliente">
          </div>
        </div>
      </div>
    </form>
   </div>

  <?php include_once "footer.php"; ?>

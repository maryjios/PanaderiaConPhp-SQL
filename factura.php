   <?php

    $tittle = "Nueva Factura";
    include_once "Conexion.php";

    session_start();
    if (!empty($_POST)) {

      if ($_POST['action'] == 'BuscarCliente') {

        if (!empty($_POST['cliente'])) {
          $id = $_POST['cliente'];

          $sentencia = $base_de_datos->query("SELECT * FROM cliente WHERE id LIKE '$id'");

          $result = $sentencia->rowCount();

          $datos_cliente = '';

          if ($result > 0) {

            $datos_cliente = $sentencia->fetch(PDO::FETCH_OBJ);
          } else {

            $datos_cliente = 0;
          }

          echo json_encode($datos_cliente, JSON_UNESCAPED_UNICODE);
        }

        exit();
      }

      if ($_POST['action'] == 'agregar_client') {

        $id = $_POST['id_cliente'];
        $nombre = $_POST['nom_cliente'];
        $telefono = $_POST['tel_cliente'];
        $direccion = $_POST['dir_cliente'];
        $correo = $_POST['email_cliente'];

        // $cliente = $_POST['action'];
        $consulta = $base_de_datos->prepare("INSERT INTO cliente(id, nombre, telefono, direccion, correo) VALUES(:id, :nom, :tel, :direc, :email)");



        $consulta->bindParam(':id', $id);
        $consulta->bindParam(':nom', $nombre);
        $consulta->bindParam(':tel', $telefono);
        $consulta->bindParam(':direc', $direccion);
        $consulta->bindParam(':email', $correo);

        $resultado = $consulta->execute();

        if ($resultado) {
          $mensaje = 'Bien';
        } else {
          $mensaje = 'error';
        }

        echo $mensaje;
      }


      if ($_POST['action'] == 'DatosProducto') {

        if (!empty($_POST['producto'])) {

          $id = $_POST['producto'];

          $sentencia2 = $base_de_datos->query("SELECT * FROM producto WHERE id LIKE '$id'");

          $result2 = $sentencia2->rowCount();

          $datos_producto = '';

          if ($result2 > 0) {

            $datos_producto = $sentencia2->fetch(PDO::FETCH_OBJ);
          } else {

            $datos_producto = 0;
          }

          echo json_encode($datos_producto, JSON_UNESCAPED_UNICODE);
        }
        exit();
      }

      // agregar producto a detalle temporal
      if ($_POST['action'] == 'AgregarProductoDetalle') {
        if (empty($_POST['producto']) || empty($_POST['cantidad'])) {

          echo 'error';
        } else {

          $codigo = $_POST['producto'];
          $cantidad = $_POST['cantidad'];

          $token = md5($_SESSION['id']);

          $query_detalle_temp = $base_de_datos->query("CALL add_detalle_temp ($codigo, $cantidad,'$token')");

          $detalleTabla = '';
          $total = 0;


          if ($query_detalle_temp) {

            $detalleTabla = $query_detalle_temp->fetchAll(PDO::FETCH_OBJ);


            echo json_encode($detalleTabla, JSON_UNESCAPED_UNICODE);
          } else {

            echo 'error';
          }
        }
        exit;
      }

      if ($_POST['action'] == 'EliminarItemTabla') {
        if (empty($_POST['item'])) {

          echo 'error';
        } else {

          $itemTemp = $_POST['item'];

          $tokenn = md5($_SESSION['id']);

          $sql_deletexquery = $base_de_datos->query("CALL eliminar_item_detalle ($itemTemp, '$tokenn')");

          $detalleTabla2 = '';

          if ($sql_deletexquery) {

            $detalleTabla2 = $sql_deletexquery->fetchAll(PDO::FETCH_OBJ);


            echo json_encode($detalleTabla2, JSON_UNESCAPED_UNICODE);
            
          } else {

            echo 'error';
          }
        }
        exit;
      }
    } ?>

   <!-- incluyendo el heder al documentofactura -->
   <?php include_once "header.php" ?>

   <?php if (!empty($_SESSION['nombre_u']) or !empty($_SESSION['user_name']) and !empty($_SESSION['id'])) { ?>

     <div class="main-panel">
       <div class="content-wrapper">
         <div class="row">
           <div class="col-md-12 stretch-card">
             <div class="card">
               <div class="card-header bg-primary text-white">
                 <i class="fas fa-edit mr-2"></i>Nueva Factura
               </div>
               <div class="card-body">
                 <!-- Begin Page Content -->
                 <div class="container-fluid">
                   <div class="row">
                     <div class="col-lg-12">
                       <div class="form-group">
                         <?php
                          $query = $base_de_datos->prepare("SELECT * FROM cliente");
                          $query->execute();

                          $resultado = $query->rowCount();
                          if ($resultado > 0) {
                            $data = $query->fetchAll(PDO::FETCH_OBJ);
                          }
                          ?>
                         <a href="#" class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
                       </div>
                       <div class="card">
                         <div class="card-body">
                           <h4 class="mb-4">Datos del Cliente:</h4>
                           <form method="post" name="form_registrar_cliente" id="form_registrar_cliente">
                             <input type="hidden" name="action" value="agregar_client">
                             <div class="row">
                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Cedula</label>
                                   <input type="number" name="id_cliente" id="id_cliente" class="form-control form-control-sm">
                                 </div>
                               </div>
                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Nombre</label>
                                   <input type="text" name="nom_cliente" id="nom_cliente" class="form-control form-control-sm" disabled required>
                                 </div>
                               </div>

                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Teléfono</label>
                                   <input type="number" name="tel_cliente" id="tel_cliente" class="form-control form-control-sm" disabled required>
                                 </div>
                               </div>
                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Dirreción</label>
                                   <input type="text" name="dir_cliente" id="dir_cliente" class="form-control form-control-sm" disabled required>
                                 </div>
                               </div>

                               <!-- <div class="col-lg-4">
                                 <div class="form-group">
                                   <label>Correo Electronico</label>
                                   <input type="email" name="email_cliente" id="email_cliente" class="form-control form-control-sm" disabled required>
                                 </div>
                               </div> -->

                               <div id="agregar_cliente">
                                 <button type="submit" class="btn btn-primary">Guardar</button>
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
                             <table class="table table-hover table_items">
                               <thead>
                                 <tr>
                                   <th class="th" width="100px">Código</th>
                                   <th class="th">Producto.</th>
                                   <th class="th">Stock</th>
                                   <th class="th">Cantidad</th>
                                   <th class="textright th">Precio Unit.</th>
                                   <th class="textright th">Subtotal</th>
                                   <th class="th">Acciones</th>
                                 </tr>
                                 <tr>
                                   <td><input type="number" name="cod_producto" id="cod_producto" class="cod_producto"></td>
                                   <td id="txt_descripcion">-</td>
                                   <td id="txt_existencia">-</td>
                                   <td><input class="input_cant" type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                                   <td id="txt_precio" class="textright">0.00</td>
                                   <td id="txt_precio_total" class="txtright">0.00</td>
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
                             <button class="btn btn-success float-right">Generar Factura</button>
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
     <!-- content-wrapper ends -->


     <?php include_once "footer.php"; ?>


   <?php } else {

      header("Location: login.php");
    } ?>
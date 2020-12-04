   <?php

    $tittle = "Nueva Factura";
    include_once "Conexion.php";

    if (!empty($_POST)) {
      session_start();

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

          $sentencia2 = $base_de_datos->query("SELECT * FROM producto WHERE id LIKE '$id' OR nombre LIKE '$id'");

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

      if ($_POST['action'] == 'GenerarFactura') {

        if (!empty($_POST['cliente'])) {

          $acum_total = 0;

          $cliente = $_POST['cliente'];

          $vendedor = $_SESSION['id'];

          $token = md5($_SESSION['id']);

          // mensaje ajax
          $mensaje = "";


          $query = $base_de_datos->query("SELECT correlativo, codproducto, cantidad, precio_venta FROM detalle_temp WHERE token_user = '$token'; ");


          if ($query) {

            $num_factu = $base_de_datos->query("SELECT MAX(codigo)+1 AS numero_factura FROM factura");

            $query = $base_de_datos->query("SELECT * FROM detalle_temp WHERE token_user = '$token'");

            $num_factu = $num_factu->fetch(PDO::FETCH_ASSOC);
            if ($num_factu) {
              $n_factura = $num_factu['numero_factura'];
            }

            $query_total = $base_de_datos->query("SELECT SUM(cantidad*precio_venta) AS totalcito FROM detalle_temp WHERE token_user  = '$token'; ");

            $query_total = $query_total->fetch(PDO::FETCH_ASSOC);
            if ($query_total) {
              $total = $query_total['totalcito'];
            }

            date_default_timezone_set('America/Bogota');
            $fechayhora = date("Y-m-d H:i:s");


            $consulta = $base_de_datos->prepare("INSERT INTO factura(codigo, id_cliente, id_vendedor, fecha, total, estado_factura) VALUES(:num_factu, :cliente, :vendedor, :fecha, :total, :estado)");

            $consulta->bindParam(':num_factu', $n_factura);
            $consulta->bindParam(':cliente', $cliente);
            $consulta->bindParam(':vendedor', $vendedor);
            $consulta->bindParam(':fecha', $fechayhora);
            $consulta->bindParam(':total', $total);
            $estado = 'Activa';
            $consulta->bindParam(':estado', $estado);


            $resultado = $consulta->execute();

            if ($resultado) {
              while ($datos = $query->fetch()) {

                $correlativo = $datos['correlativo'];
                $producto = $datos['codproducto'];
                $cantidad = $datos['cantidad'];
                $subtotal = $datos['cantidad'] * $datos['precio_venta'];


                $insert_item_factura = $base_de_datos->query("INSERT INTO item_factura(cod_factura, id_producto, cantidad, subtotal, estado_factura) VALUES('$n_factura', '$producto', '$cantidad', '$subtotal', 'Activa')");

                if ($insert_item_factura) {
                  $delete_item = $base_de_datos->query("DELETE FROM detalle_temp WHERE correlativo  = '$correlativo'; ");
                }
              }
            }
            $mensaje =  "true";
          }
          echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);

        } else {

          $mensaje = "false";
        }
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
                                   <input type="number" name="id_cliente" id="id_cliente" class="form-control form-control-sm el_cliente">
                                 </div>
                               </div>
                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Nombre</label>
                                   <input type="text" name="nom_cliente" id="nom_cliente" class="form-control form-control-sm el_cliente" disabled required>
                                 </div>
                               </div>

                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Teléfono</label>
                                   <input type="number" name="tel_cliente" id="tel_cliente" class="form-control form-control-sm el_cliente" disabled required>
                                 </div>
                               </div>
                               <div class="col-lg-3">
                                 <div class="form-group">
                                   <label>Dirreción</label>
                                   <input type="text" name="dir_cliente" id="dir_cliente" class="form-control form-control-sm el_cliente" disabled required>
                                 </div>
                               </div>

                               <!-- <div class="col-lg-4">
                                 <div class="form-group">
                                   <label>Correo Electronico</label>
                                   <input type="email" name="email_cliente" id="email_cliente" class="form-control form-control-sm" disabled required>
                                 </div>
                               </div> -->

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
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

      $sentencia2 = $base_de_datos->query("SELECT * FROM producto WHERE id = '$id' OR nombre LIKE '%' '$id' '%';");

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

  // agregar producto a detalle temporals
  if ($_POST['action'] == 'AgregarProductoDetalle') {
    if (empty($_POST['producto']) || empty($_POST['cantidad'])) {

      echo 'error';
    } else {

      $cod = $_POST['producto'];
      $cantidad = $_POST['cantidad'];

      $vendedor = $_SESSION['id'];

  
      $sentencias = $base_de_datos->query("SELECT id FROM producto WHERE id = '$cod' OR nombre LIKE '%' '$cod' '%';");

      $result2 = $sentencias->fetch(PDO::FETCH_ASSOC);

      $codigo = $result2["id"];

      $query_detalle_temp = $base_de_datos->query("CALL add_detalle_temp ($codigo, $cantidad,'$vendedor')");

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

      $vendedor = $_SESSION['id'];

      $sql_deletexquery = $base_de_datos->query("CALL eliminar_item_detalle ($itemTemp, '$vendedor')");

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

      $vendedor = $_SESSION['id'];

      // mensaje ajax
      $mensaje = "";


      $query = $base_de_datos->query("SELECT correlativo, codproducto, cantidad, precio_venta FROM detalle_temp WHERE vendedor = '$vendedor'; ");


      if ($query) {

        $num_factu = $base_de_datos->query("SELECT MAX(codigo)+1 AS numero_factura FROM factura");

        $query = $base_de_datos->query("SELECT * FROM detalle_temp WHERE vendedor = '$vendedor'");

        $num_factu = $num_factu->fetch(PDO::FETCH_ASSOC);
        if ($num_factu) {
          $n_factura = $num_factu['numero_factura'];
        }

        $query_total = $base_de_datos->query("SELECT SUM(cantidad*precio_venta) AS totalcito FROM detalle_temp WHERE vendedor  = '$vendedor'; ");

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

?>
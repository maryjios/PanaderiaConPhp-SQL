
<?php
 require_once "Conexion.php"; 
 include_once "funciones.php";

session_start();
if (isset($_SESSION["user_name"])) {
    header("Location: inicio.php");
}

?>

<?php 

if(!empty($_POST['usuario']) && !empty($_POST['contrasena'])){ 

    $usu = $_POST['usuario'];
    $con = $_POST['contrasena'];

    $sql = $base_de_datos->query("SELECT usuario.nombre AS nombre_usu, usuario.apellido AS apellido_usu, usuario.usuario AS usuario_usu, usuario.contrasena AS contrasena,  usuario.id AS id_usu ,  tipo_user.nombre AS tipo, tipo_user.id AS id_tipo FROM usuario JOIN tipo_user ON usuario.tipo_usuario = tipo_user.id  WHERE usuario.usuario ='$usu'"); 

    $contador = 0;

    while($row = $sql->fetch()){


        if (password_verify($con, $row['contrasena']) ){
            $mensaje = " "; 
            $contador++;
            $_SESSION['id'] = $row['id_usu'];
            $_SESSION['tipo_u'] = $row['tipo'];
            $_SESSION['user_name'] = $row['usuario_usu'];
            $_SESSION['nombre_u'] = $row['nombre_usu'];
            $_SESSION['apellido_u'] = $row['apellido_usu'];

        }

    }

    if ($contador>0) {

        header("Location: inicio.php");

    }else{

        $mensaje =  mensajes('Usuario o Contraseña Incorrecto<br>','rojo');

    }

} ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Iniciar Sesión</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
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


  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <h4>Hola! Bienvenido</h4>
              <form class="pt-3" method="POST">

                <div class="form-group">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                      </div>
                      <input type="text" class="form-control form-control-lg" id="usuario" name="usuario" placeholder="Usuario">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                      </div>
                      <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="contrasena" placeholder="Contraseña">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <?php if (!empty($mensaje)): 
                    echo $mensaje;

                   endif ?>
                <div class="mt-3" align="center">
                  <input type="submit" class="btn btn-primary btn-lg"  value="Ingresar" id="btnLogin"/> 
                </div>
               
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/data-table.js"></script>
  <script src="js/jquery.dataTables.js"></script>
  <script src="js/dataTables.bootstrap4.js"></script>
  <!-- End custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>


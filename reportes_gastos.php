<?php

$tittle = "Clientes";

include_once "header.php";
if ($estado1001 == 'Habilitado') { ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <h4>Reporte de Gastod</h4>
                        </div>
                        <div class="card-body">
                            <br>
                            <br>
                            <div class="py-3" style="background: #E7EEF3 ;">
                                <form class="row g-3 pl-4" method="POST">
                                    <div class="col-auto mt-2">
                                        Desde:
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="fecha_inicial">

                                    </div>

                                    <div class="col-auto mt-2">
                                        Hasta:
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" class="form-control" name="fecha_final">
                                    </div>
                                    <div class="col-auto">
                                        <input type="submit" class="form-control btn btn-success" name="btn_buscar" value="Buscar">
                                    </div>
                                    <div class="col-auto">
                                        <a href="" type="button" class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                                    </div>
                                </form>
                            </div>

                            <br>
                            <div class="table-responsive">
                                <table id="recent-purchases-listing" class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vendedor</th>
                                            <th>Subtotal</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Registrar Cliente -->
                                        <?php
                                        if (!empty($_POST['btn_buscar'])) {

                                            $inicial = $_POST['fecha_inicial'];
                                            $final = $_POST['fecha_final'];

                                            $consulta = $base_de_datos->query("SELECT id_cliente, id_vendedor, fecha, total, estado_factura FROM factura WHERE fecha BETWEEN '$inicial' AND '$final'");


                                            $contador = 0;

                                            while ($datos = $consulta->fetch()) {
                                                $contador++;
                                                $cliente = $datos['id_cliente'];
                                                $vendedor = $datos['id_vendedor'];
                                                $total_factu = $datos['total'];
                                                $fechas = $datos['fecha'];
                                                $estado = $datos['estado_factura'];

                                        ?>

                                                <tr>
                                                    <td><?php echo $contador; ?></td>
                                                    <td><?php echo $cliente; ?></td>
                                                    <td><?php echo $vendedor; ?></td>
                                                    <td><?php echo $total_factu; ?></td>
                                                    <td><?php echo $fechas; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-icon-text btn-sm">
                                                            <i class="mdi mdi-check btn-icon-prepend"></i><?php echo $estado; ?>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <?php } else {

                                            $consulta = $base_de_datos->query("SELECT id_cliente, id_vendedor, fecha, total, estado_factura FROM factura WHERE fecha LIKE '%' '$fecha' '%'");


                                            $contador = 0;

                                            while ($datos = $consulta->fetch()) {
                                                $contador++;
                                                $cliente = $datos['id_cliente'];
                                                $vendedor = $datos['id_vendedor'];
                                                $total_factu = $datos['total'];
                                                $fecha = $datos['fecha'];
                                                $estado = $datos['estado_factura'];


                                            ?>

                                                <tr>
                                                    <td><?php echo $contador; ?></td>
                                                    <td><?php echo $cliente; ?></td>
                                                    <td><?php echo $vendedor; ?></td>
                                                    <td><?php echo $total_factu; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-icon-text">
                                                            <i class="mdi mdi-close btn-icon-prepend"></i><?php echo $estado; ?>
                                                        </button>
                                                    </td>
                                                    <td><?php echo $fecha; ?></td>
                                                </tr>
                                            <?php } ?>
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




<?php include_once "footer.php";
} else {

    $refresh = '<meta http-equiv="refresh" content="0;url=403.php">';
    echo $refresh;
} ?>
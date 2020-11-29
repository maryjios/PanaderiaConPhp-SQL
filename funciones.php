<?php 

	require "Conexion.php";

	function mensajes($mensaje,$tipo){

		if($tipo=='verde'){
			$tipo='alert alert-success';
		}elseif($tipo=='rojo'){
			$tipo='alert alert-danger';
		}elseif($tipo=='azul'){
			$tipo='alert alert-info';
		}
		elseif($tipo=='amarrillo'){
			$tipo='alert alert-warning';
		}
		return '<div class="'.$tipo.'" align="center">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>'.$mensaje.'</strong>
		</div>';
	}



	// function permiso($usu,$id){
	// 	$estado = "Habilitado";

	// 	$consulta=$base_de_datos->prepare("SELECT * FROM permisos_users WHERE user = :usu AND permiso = :id AND estado_user = :estado");


	// 	$consulta->bindParam(':user', $usu);
	// 	$consulta->bindParam(':id', $id);
	// 	$consulta->bindParam(':estado', $estado);
		

	// 	$resultado = $consulta->execute();

	// 	if($v=$resultado->fetch()){

	// 		return TRUE;

	// 	}else{
			
	// 		return FALSE;
	// 	}
	// }

?>
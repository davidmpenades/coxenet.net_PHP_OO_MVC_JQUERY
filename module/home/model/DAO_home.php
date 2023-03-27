<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V10/';
	include($path . "/model/connect.php");
    
	class DAO_home {
		function select_brand() {
			$sql= "SELECT * FROM `marca` ORDER BY cod_marca ASC LIMIT 30;";

			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion);

			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = $row;
				}
			}
			return $retrArray;
		}

		function select_categories() {
		// 	echo json_encode('hola1');
        //   exit;
			$sql= "SELECT * FROM categoria";

			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion);

			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = $row;
				}
			}
			return $retrArray;
		}

		function select_type_motor() {
			$sql= "SELECT * FROM combustible ORDER BY cod_combustible DESC";

			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion);

			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = $row;
				}
			}
			return $retrArray;
		}
		function select_type_carroceria() {
			$sql= "SELECT *FROM carroceria ORDER BY cod_carroceria DESC";

			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion);

			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = $row;
				}
			}
			return $retrArray;
		}
		function select_visitas(){
			$sql= "SELECT distinct cod_modelo,img_car FROM car ORDER BY visitas DESC limit 4";

			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion);

			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = $row;
				}
			}
			return $retrArray;
		}
		
	}
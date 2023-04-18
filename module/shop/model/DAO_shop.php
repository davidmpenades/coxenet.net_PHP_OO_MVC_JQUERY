<?php 
	$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V10/';
    include($path . "/model/connect.php");

class DAO_shop{
	function select_all_cars($total_prod,$items_page){
		// echo json_encode($total_prod);
		// exit;

		$sql = "SELECT c.id_car,m.cod_marca marca,c.km,c.puertas,c.color,c.city ciudad,c.f_mat,m.descripcion modelo, c.num_matricula, c.precio,c.observaciones,f.img_car,
		        ca.descripcion carroceria,cat.nombre_cat,ci.descripcion cilindrada,e.descripcion etiqueta,c.lon,c.lat
                FROM car c, modelo m,fotos f,carroceria ca,categoria cat,cilindrada ci,combustible co,etiqueta e
                WHERE c.cod_modelo=m.cod_modelo AND c.num_bastidor=f.num_bastidor AND f.img_car like '%\pr-%' 
				AND c.carroceria=ca.cod_carroceria AND c.categoria=cat.cod_categoria AND c.cod_combustible=co.cod_combustible
				AND c.cod_cil=ci.cod_cilindrada AND c.cod_etiqueta=e.cod_etiqueta ORDER BY c.visitas DESC
				LIMIT $total_prod,$items_page;";
				// return $sql;
		$connection = connect::con();
		$res = mysqli_query($connection, $sql);
		connect::close($connection);

		$retrArray = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
	}
	function count_all_cars(){
		// echo json_encode($total_prod);
		// exit;

		$sql = "SELECT COUNT(*) n_prod
                FROM car c, modelo m,fotos f,carroceria ca,categoria cat,cilindrada ci,combustible co,etiqueta e
                WHERE c.cod_modelo=m.cod_modelo AND c.num_bastidor=f.num_bastidor AND f.img_car like '%\pr-%' 
				AND c.carroceria=ca.cod_carroceria AND c.categoria=cat.cod_categoria AND c.cod_combustible=co.cod_combustible
				AND c.cod_cil=ci.cod_cilindrada AND c.cod_etiqueta=e.cod_etiqueta ORDER BY c.visitas DESC;";
		$connection = connect::con();
		// echo json_encode($sql);
		// exit;
		$res = mysqli_query($connection, $sql);
		connect::close($connection);

		$retrArray = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
	}
	function select_visitas($id_car){
		
		$sql = "UPDATE car c SET c.visitas = (c.visitas + 1) WHERE c.id_car = '$id_car'";

		$connection = connect::con();

		$res = mysqli_query($connection, $sql);
		connect::close($connection);
		return $res;
	}
	function select_car($id_car)
	{

		$sql = "SELECT c.id_car,m.cod_marca marca,c.km,c.puertas,c.color,c.city ciudad,c.f_mat,m.descripcion modelo, c.num_matricula, c.precio,c.observaciones,f.img_car,
		        ca.descripcion carroceria,cat.nombre_cat categoria,ci.descripcion cilindrada,e.descripcion etiqueta,c.lon,c.lat
                FROM car c, modelo m,fotos f,carroceria ca,categoria cat,cilindrada ci,combustible co,etiqueta e
                WHERE c.id_car=$id_car AND c.cod_modelo=m.cod_modelo AND c.num_bastidor=f.num_bastidor AND f.img_car like '%\pr-%' 
				AND c.carroceria=ca.cod_carroceria AND c.categoria=cat.cod_categoria AND c.cod_combustible=co.cod_combustible
				AND c.cod_cil=ci.cod_cilindrada AND c.cod_etiqueta=e.cod_etiqueta;";

		$connection = connect::con();

		$res = mysqli_query($connection, $sql)->fetch_object();
		connect::close($connection);
		return $res;
	}
	function select_img($img_car)
	{
		// echo json_encode("hola img");
		// exit;

		$sql = "SELECT *
                FROM car c, fotos f
                WHERE  id_car='$img_car' and c.num_bastidor=f.num_bastidor ";
		//    echo json_encode($sql);
		// 	exit;
		$connection = connect::con();
		$res = mysqli_query($connection, $sql);
		connect::close($connection);

		$retrArray = array();
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
	}
	function print_filters()
	{
		// echo json_encode("hola print filters");
		// exit;
		$select = "SELECT * FROM car";
		$conexion = connect::con();
		$res = mysqli_query($conexion, $select);
		connect::close($conexion);

		$retrArray = array();
		if ($res->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
	}
	function filters($filter,$total_prod,$items)
	{
		// echo json_encode($total_prod);
		// exit;
		$consulta = "SELECT c.*					
					FROM (SELECT c.id_car,c.km,c.num_matricula,c.cod_combustible,c.categoria,c.observaciones,c.puertas,c.precio,c.cod_etiqueta,c.f_mat,c.color,c.city,c.cod_modelo,m.descripcion modelo, f.img_car,  
					co.descripcion combustible, m.cod_marca marca,carr.descripcion carroceria,c.lon,c.lat,c.visitas
					FROM car c INNER JOIN fotos f INNER JOIN categoria ca INNER JOIN combustible co INNER JOIN modelo m INNER JOIN carroceria carr
					ON c.num_bastidor = f.num_bastidor AND f.img_car LIKE '%\pr-%' AND c.categoria = ca.cod_categoria AND c.cod_combustible = co.cod_combustible 
					AND c.cod_modelo =m.cod_modelo AND c.carroceria= carr.cod_carroceria) AS c";

		for ($i = 0; $i < count($filter); $i++) {
			if ($i == 0) {
				if ($filter[$i][0] == 'order'){
                        $consulta.= " ORDER BY " . $filter[$i][1] . " ASC";

				} else {
					$consulta .= " WHERE c." . $filter[$i][0] . '= "' . $filter[$i][1] . '"';
				}
			} else {
				if ($filter[$i][0] == 'order') {
					$consulta .= " ORDER BY " . $filter[$i][1] . " ASC";

				} else {
					$consulta .= " AND c." . $filter[$i][0] . '= "' . $filter[$i][1] . '"';
				}
			}
		}
		$consulta.=" LIMIT " . $total_prod . "," . $items ;
		// echo json_encode($consulta);
		// exit;

		$conexion = connect::con();
		$res = mysqli_query($conexion, $consulta);
		connect::close($conexion);

		$retrArray = array();
		if ($res->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
	}
		function count_pagination($filter){
			// echo json_encode($filter);
			// exit;
			// return $filter;
			$consulta = "SELECT COUNT(c.id_car) n_prod
					FROM (SELECT c.id_car,c.km,c.num_matricula,c.cod_combustible,c.categoria,c.observaciones,c.puertas,c.precio,c.cod_etiqueta,c.f_mat,c.color,c.city,c.cod_modelo,m.descripcion modelo, f.img_car,  
					co.descripcion combustible, m.cod_marca marca,carr.descripcion carroceria,c.lon,c.lat,c.visitas
					FROM car c INNER JOIN fotos f INNER JOIN categoria ca INNER JOIN combustible co INNER JOIN modelo m INNER JOIN carroceria carr
					ON c.num_bastidor = f.num_bastidor AND f.img_car LIKE '%\pr-%' AND c.categoria = ca.cod_categoria AND c.cod_combustible = co.cod_combustible 
					AND c.cod_modelo =m.cod_modelo AND c.carroceria= carr.cod_carroceria) AS c";
			
		for ($i = 0; $i < count($filter); $i++) {
			if ($i == 0) {
				if ($filter[$i][0] == 'order'){
                        $consulta.= " ORDER BY " . $filter[$i][1] . " ASC";

				} else {
					$consulta .= " WHERE c." . $filter[$i][0] . '= "' . $filter[$i][1] . '"';
				}
			} else {
				if ($filter[$i][0] == 'order') {
					$consulta .= " ORDER BY " . $filter[$i][1] . " ASC";

				} else {
					$consulta .= " AND c." . $filter[$i][0] . '= "' . $filter[$i][1] . '"';
				}
			}
		}

		$conexion = connect::con();
		$res = mysqli_query($conexion, $consulta);
		connect::close($conexion);

		$retrArray = array();
		if ($res->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$retrArray[] = $row;
			}
		}
		return $retrArray;
		}
		function select_cars_related($marca, $items){
		// echo json_encode($marca);
		// echo json_encode($total);
		// echo json_encode($items);
		// exit;
		$sql = "SELECT *,m.descripcion, ca.nombre_cat
		FROM car c, modelo m, categoria ca
		WHERE c.cod_modelo = m.cod_modelo AND c.categoria = ca.cod_categoria 
				AND m.cod_marca = '$marca'
				LIMIT $items,3;";
		// echo json_encode($sql);
		// exit;
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
		function count_more_cars_related($marca){

		$sql = "SELECT COUNT(*) AS n_prod
				FROM car c, modelo m
				WHERE c.cod_modelo = m.cod_modelo AND m.cod_marca = '$marca'";
		
		
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
	function select_load_likes($username){
        $sql = "SELECT l.id_car FROM likes l WHERE l.id_user = (SELECT u.id_user FROM users u WHERE u.username = '$username')";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function select_likes($id_car, $username){
        $sql = "SELECT l.id_car FROM likes l
				WHERE l.id_user = (SELECT u.id_user FROM users u WHERE u.username = '$username')
				AND l.id_car = '$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }
	function like($id_car, $username){
        $sql = "INSERT INTO likes (id_user, id_car) VALUES ((SELECT  u.id_user FROM users u WHERE u.username= '$username') ,'$id_car');";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function dislike($id_car, $username){
        $sql = "DELETE FROM likes WHERE id_car='$id_car' AND id_user=(SELECT  u.id_user FROM users u WHERE u.username= '$username')";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }
}
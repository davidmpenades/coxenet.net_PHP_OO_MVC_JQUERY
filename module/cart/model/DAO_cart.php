<?php

    $path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V11/';
    include($path . "model/connect.php");

class DAO_Cart{

    function select_product($username, $id_car){
        $sql = "SELECT * FROM cart WHERE username='$username' AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function insert_product($username, $id_car){
        $sql = "INSERT INTO cart (username, id_car, quanty) VALUES ('$username','$id_car', '1')";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function update_product($username, $id_car){
        
        $sql = "UPDATE cart SET quanty = quanty+1 WHERE username='$username' AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function select_user_cart($username){
        $sql = "SELECT * FROM cart c, car ca, fotos f, modelo m  
        WHERE c.id_car=ca.id_car AND ca.num_bastidor = f.num_bastidor AND f.img_car LIKE '%pr%' 
        AND m.cod_modelo=ca.cod_modelo AND username='$username' ";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function update_qty($username, $id_car, $quanty){
        
        $sql = "UPDATE cart SET quanty = $quanty WHERE username='$username' AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }
    
    function delete_cart($username, $id_car){
        $sql = "DELETE FROM cart WHERE username='$username' AND id_car='$id_car'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function checkout($data, $username){
        // $username = md5($username);
        $date = date("Ymd");
        foreach($data as $fila){
            // $cod_ped = $username;
            $id_car = $fila["id_car"];
            $precio = $fila["precio"];
            $total_precio = $fila["precio"]*$fila["quanty"];

            $sql = "INSERT INTO `pedidos`( `username`, `id_car`, `precio`, `precio_total`, `fecha`) 
                    VALUES ('$username','$id_car','$precio','$total_precio','$date')";
            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion); 
        }
        return $res;
    }

}

?>
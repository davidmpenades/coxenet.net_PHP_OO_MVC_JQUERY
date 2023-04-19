<?php

    $path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V11/';
    include($path . "model/connect.php");

class DAOCart{

    function select_product($user, $id){
        $sql = "SELECT * FROM cart WHERE user='$user' AND codigo_producto='$id'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function insert_product($user, $id){
        $sql = "INSERT INTO cart (user, codigo_producto, qty) VALUES ('$user','$id', '1')";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function update_product($user, $id){
        $sql = "UPDATE cart SET qty = qty+1 WHERE user='$user' AND codigo_producto='$id'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function select_user_cart($user){
        $sql = "SELECT p.codigo_producto, p.nombre, p.precio, p.images, p.talla, c.qty FROM cart c, producto p WHERE c.codigo_producto=p.codigo_producto AND user='$user'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function update_qty($user, $id, $qty){
        $sql = "UPDATE cart SET qty = $qty WHERE user='$user' AND codigo_producto='$id'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }
    
    function delete_cart($user, $id){
        $sql = "DELETE FROM cart WHERE user='$user' AND codigo_producto='$id'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function checkout($data, $user){
        $name = md5($user);
        $date = date("Ymd");
        foreach($data as $fila){
            $cod_ped = $user;
            $cod_prod = $fila["codigo_producto"];
            $talla = $fila["talla"];
            $cantidad = $fila["qty"];
            $precio = $fila["precio"];
            $total_precio = $fila["precio"]*$fila["qty"];

            $sql = "INSERT INTO `pedidos`(`cod_ped`, `user`, `cod_prod`, `talla`, `cantidad`, `precio`, `total_precio`, `fecha`) 
                    VALUES ('$cod_ped','$user','$cod_prod','$talla','$cantidad','$precio','$total_precio','$date')";
            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion); 
        }
        return $res;
    }

}

?>
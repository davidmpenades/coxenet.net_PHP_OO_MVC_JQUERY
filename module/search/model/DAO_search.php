<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V10';
include($path . "/model/connect.php");

class DAO_search {
    function search_marca(){
        // echo json_encode("hola dao");
        // exit;
        $select="SELECT * FROM marca";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }

        return $retrArray;
    }

    function search_categoria_null(){
        $select="SELECT DISTINCT * FROM categoria";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function search_categoria($marca){

        $select="SELECT DISTINCT cat.nombre_cat, cat.cod_categoria
        FROM car c, modelo m, categoria cat
        WHERE c.cod_modelo = m.cod_modelo AND c.categoria = cat.cod_categoria and m.cod_marca  LIKE '$marca'";
         
       

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
      
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function select_only_marca($city, $marca){

        $select="SELECT ma.cod_marca, c.city
                FROM car c, modelo m, marca ma
                WHERE c.cod_modelo = m.cod_modelo AND m.cod_marca = ma.descripcion AND c.city LIKE '$city%' 
                AND ma.descripcion LIKE '$marca'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function select_marca_categoria($categoria, $marca, $city){
        // echo json_encode($categoria);
        // exit;
        $select="SELECT c.*, cat.nombre_cat , ma.cod_marca
        FROM car c, categoria cat, modelo mo, marca ma
        WHERE c.categoria = cat.cod_categoria AND mo.cod_modelo = c.cod_modelo 
        AND mo.cod_marca = ma.descripcion  AND ma.descripcion = '$marca' AND
        cat.cod_categoria LIKE '$categoria' AND c.city LIKE '$city%'";
        // echo json_encode($select);
        // exit;
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }


    function select_only_categoria($categoria, $city ){
        // echo json_encode($categoria);
        // exit;
        $select="SELECT c.city, cat.nombre_cat 
        FROM car c, categoria cat  
        WHERE c.categoria = cat.cod_categoria AND cat.cod_categoria LIKE '$categoria' AND c.city LIKE '$city%'";
        // echo json_encode($select);
        // exit;
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function select_city($city){
        $select="SELECT *
        FROM car c
        WHERE c.city LIKE '$city%'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }
}
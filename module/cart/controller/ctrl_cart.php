<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V11/';
        include($path . "module/cart/model/DAO_cart.php");
        include($path . "model/middleware_auth.php");

        switch($_GET['op']){
            case 'view';
                include("module/cart/view/cart.html");
                break;
                    
            case 'insert_cart';    
            //  echo json_encode("hola car.js");
            //  exit;
                $token = $_POST['token'];
                $id_car = $_POST['id_car'];
                try{
                    // echo json_encode($id_car);
                    // exit;
                    $json = decode_token($token);  
                    $dao = new DAO_Cart();
                    $rdo = $dao->select_product($json['username'], $id_car);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                $dinfo = array();
                foreach ($rdo as $row) {
                    array_push($dinfo, $row);
                }
                if(!$dinfo){
                    $dao = new DAO_Cart();
                    $rdo = $dao->insert_product($json['username'], $id_car);
                    echo json_encode("insert");
                    exit;
                }else{
                    $dao = new DAO_Cart();
                    $rdo = $dao->update_product($json['username'], $id_car);
                    echo json_encode("update");
                    exit;
                }
                break; 
        
            case 'delete_cart';  
                 $token = $_POST['token'];
            
                try{
                    $json = decode_token($token);  
                    
                    $dao = new DAO_Cart();
                    $rdo = $dao->delete_cart($json['username'], $_POST['id_car']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
                }else{
                    echo json_encode("delete");
                    exit;
                }
                break;         

            case 'load_cart';   
            //   echo json_encode("hola javascript");
            //   exit; 
                try{
           
                    $token = $_POST['token'];
    
                    $json = decode_token($token);  
                    // echo json_encode($json);
                    // exit;
                    $dao = new DAO_Cart();
                    $rdo = $dao->select_user_cart($json['username']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
                }else{
                    $dinfo = array();
                    foreach ($rdo as $row) {
                        array_push($dinfo, $row);
                    }
                    echo json_encode($dinfo);
                    exit;
                }
                break; 

            case 'update_qty'; 

                    $token = $_POST['token'];
                    $quanty = $_POST['quanty'];
                    $id_car = $_POST['id_car']; 
                   
                try{
                                       
                    $json = decode_token($token);                     
                    $dao = new DAO_Cart();
                    $rdo = $dao->update_qty($json['username'], $id_car, $quanty);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
                }else{
                    echo json_encode("update");
                    exit;
                }
                break; 

            case 'checkout';    
                try{
                  
                    $token = $_POST['token'];
    
                    $json = decode_token($token); 
                    $dao = new DAO_Cart();
                    $rdo = $dao->select_user_cart($json['username']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
                }else{
                    $dinfo = array();
                    foreach ($rdo as $row) {
                        array_push($dinfo, $row);
                    }
                    $dao = new DAO_cart();
                    $res = $dao->checkout($dinfo, $json['username']);
                    echo json_encode($res);
                    // echo json_encode("checkout realizado");
                    exit;
                }
                break; 
                    
            default;
                include("view/inc/error404.php");
                break;
                
        }
    
?>

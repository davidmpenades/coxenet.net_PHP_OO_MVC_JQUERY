<?php
        $path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V11/';
        include($path . "/module/home/model/DAO_cart.php");
        include($path . "model/middleware_auth.php");

        switch($_GET['op']){
            case 'view';
                include("module/cart/view/cart.html");
                break;
                    
            case 'insert_cart';    
                try{
                    $token = $_GET['user'];
                    $secret = 'maytheforcebewithyou';
    
                    $JWT = new JWT;
                    $json = $JWT->decode($token, $secret);  
                    $json = json_decode($json, TRUE);
                    
                    $dao = new DAOCart();
                    $rdo = $dao->select_product($json['name'], $_GET['id']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                $dinfo = array();
                foreach ($rdo as $row) {
                    array_push($dinfo, $row);
                }
                if(!$dinfo){
                    $dao = new DAOCart();
                    $rdo = $dao->insert_product($json['name'], $_GET['id']);
                    echo json_encode("insert");
                    exit;
                }else{
                    $dao = new DAOCart();
                    $rdo = $dao->update_product($json['name'], $_GET['id']);
                    echo json_encode("update");
                    exit;
                }
                break; 
        
            case 'delete_cart';    
                try{
                    $token = $_GET['user'];
                    $secret = 'maytheforcebewithyou';
    
                    $JWT = new JWT;
                    $json = $JWT->decode($token, $secret);  
                    $json = json_decode($json, TRUE);
                    
                    $dao = new DAOCart();
                    $rdo = $dao->delete_cart($json['name'], $_GET['id']);
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
                try{
                    $token = $_GET['user'];
                    $secret = 'maytheforcebewithyou';
    
                    $JWT = new JWT;
                    $json = $JWT->decode($token, $secret);  
                    $json = json_decode($json, TRUE);
                    
                    $dao = new DAOCart();
                    $rdo = $dao->select_user_cart($json['name']);
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
                }
                break; 

            case 'update_qty';    
                try{
                    $token = $_GET['user'];
                    $secret = 'maytheforcebewithyou';
    
                    $JWT = new JWT;
                    $json = $JWT->decode($token, $secret);  
                    $json = json_decode($json, TRUE);
                    
                    $dao = new DAOCart();
                    $rdo = $dao->update_qty($json['name'], $_GET['id'],$_GET['qty']);
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
                    $token = $_GET['user'];
                    $secret = 'maytheforcebewithyou';
    
                    $JWT = new JWT;
                    $json = $JWT->decode($token, $secret);  
                    $json = json_decode($json, TRUE);
                    
                    $dao = new DAOCart();
                    $rdo = $dao->select_user_cart($json['name']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
                }else{
                    $dao = new DAOCart();
                    $res = $dao->checkout($rdo, $json['name']);
                    echo json_encode("checkout");
                    exit;
                }
                break; 
                    
            default;
                include("view/inc/error404.php");
                break;
                
        }
    
?>

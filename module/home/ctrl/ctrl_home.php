<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V11/';
    include($path . "/module/home/model/DAO_home.php");
    include($path . "model/middleware_auth.php");

    @session_start();
    if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
    }
    switch ($_GET['op']) {
        case 'list';
            include ('module/home/view/home.html');
        break;
        case 'Carrousel_Brand';
            try{
                $daohome = new DAO_Home();
                $SelectBrand = $daohome->select_brand();
            } catch(Exception $e){
                echo json_encode("error");
            }
            
            if(!empty($SelectBrand)){
                echo json_encode($SelectBrand); 
            }
            else{
                echo json_encode("error");
            }
        break;

        case 'homePageCategory';
        //   echo json_encode("hola2");
        //   exit;
            try{
                $daohome = new DAO_home();
                $SelectCategory = $daohome->select_categories();
            } catch(Exception $e){
                echo json_encode("error");
            }
            
            if(!empty($SelectCategory)){
                echo json_encode($SelectCategory); 
            }
            else{
                echo json_encode("error");
            }
        break;

        case 'homePageType';
            try{
                $daohome = new DAO_Home();
                $SelectType = $daohome->select_type_motor();
            } catch(Exception $e){
                echo json_encode("error");
            }
            
            if(!empty($SelectType)){
                echo json_encode($SelectType); 
            }
            else{
                echo json_encode("error");
            }
        break;

        
        case 'homePageCarroceria';
            try{
                $daohome = new DAO_Home();
                $SelectCarroceria = $daohome->select_type_carroceria();
            } catch(Exception $e){
                echo json_encode("error");
            }
            
            if(!empty($SelectCarroceria)){
                echo json_encode($SelectCarroceria); 
            }
            else{
                echo json_encode("error");
            }
        break;

        case 'homevisitas';
            try{
                $daohome = new DAO_Home();
                $SelectVisitas = $daohome->select_visitas();
            } catch(Exception $e){
                echo json_encode("error");
            }
            
            if(!empty($SelectVisitas)){
                echo json_encode($SelectVisitas); 
            }
            else{
                echo json_encode("error");
            }
        break;

        default;
            include("module/exceptions/views/pages/error404.php");
        break;
     }
?>
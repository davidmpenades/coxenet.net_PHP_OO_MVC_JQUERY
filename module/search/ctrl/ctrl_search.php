<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V11/';
include($path . '/module/search/model/DAO_search.php');

switch ($_GET['op']) {
    case 'search_marca';
        // echo json_encode("hola");
        // exit;
        $homeQuery = new DAO_search();
        $selSlide = $homeQuery -> search_marca();
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

    case 'search_categoria_null';
       
        
        $homeQuery = new DAO_search();
        $selSlide = $homeQuery -> search_categoria_null();
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

    case 'search_categoria';
        // echo json_encode("hola categoria");
      
        $homeQuery = new DAO_search();
        $selSlide = $homeQuery -> search_categoria($_POST['marca']);        
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

    case 'autocomplete';
        try {
            // echo json_encode("hola autocomplete");
            // exit;
            $dao = new DAO_search();
            if (!empty($_POST['marca']) && empty($_POST['categoria'])) {

                $rdo = $dao->select_only_marca($_POST['city'], $_POST['marca']);

            } else if (!empty($_POST['marca']) && !empty($_POST['categoria'])) {

                $rdo = $dao->select_marca_categoria($_POST['categoria'], $_POST['marca'], $_POST['city']);
                // echo json_encode($rdo);
                // exit;
            } else if (empty($_POST['marca']) && !empty($_POST['categoria'])) {
               
                $rdo = $dao->select_only_categoria($_POST['categoria'], $_POST['city']);
                //  echo json_encode($rdo);
                // EXIT;
            } else {
                $rdo = $dao->select_city($_POST['city']);
            }
        }catch (Exception $e){
        echo json_encode("catch");
        exit;
    }
    if(!$rdo){
        echo json_encode("rdo!!!");
        exit;
    }else{
        $dinfo = array();
        foreach ($rdo as $row) {
            array_push($dinfo, $row);
        }
        echo json_encode($dinfo);
    }
    break; 
}

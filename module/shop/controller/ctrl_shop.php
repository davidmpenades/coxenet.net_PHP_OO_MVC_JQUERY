<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V9/';
	include ($path . '/module/shop/model/DAO_shop.php');

	switch ($_GET['op']) {
	    case 'list_shop':
		    // echo json_encode("hola lista ");
			// exit;
			include("module/shop/view/list_shop.html");	
			break;
			
		case 'all_cars':
			// echo json_encode("hola lista op");
			// exit;
			 try{
                $daoshop = new DAO_shop();
                $container_shop = $daoshop->select_all_cars();
            } catch(Exception $e){
                echo json_encode("error");
            }
            
            if(!empty($container_shop)){
                echo json_encode($container_shop); 
            }
            else{
                echo json_encode("error");
            }
        break;

	case 'one_car':
		// echo json_encode("hola");
		// exit;
			
				$daoshopVisitas = new DAO_shop();
				$visitas = $daoshopVisitas->select_visitas($_GET['id']);
			
			try {
				$daoshop = new DAO_shop();
				$Date_car = $daoshop->select_car($_GET['id']);
			} catch (Exception $e) {
				echo json_encode("error");
			}
			try {
				$daoshop_img = new DAO_shop();
				$Date_images = $daoshop_img->select_img($_GET['id']);
			} catch (Exception $e) {
				echo json_encode("error");
			}
		
			if (!empty($Date_car || $Date_images)) {
				$rdo = array();
				$rdo[0] = $Date_car;
				$rdo[1][] = $Date_images;
				echo json_encode($rdo);
			} else {
				echo json_encode("error");
			}
			break;
		

   	    case 'filter';
		// echo json_encode("hola filter");
		// exit;
			
				$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
				
	case 'filter_marca';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;

	case 'filter_carro';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
				
	case 'filter_tipo';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
				
	case 'filter_comb';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
	case 'filter_search';

			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;      
	}

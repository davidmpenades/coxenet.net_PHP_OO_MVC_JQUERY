<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V10/';
	include ($path . '/module/shop/model/DAO_shop.php');
    // include($path . "model/middleware_auth.php");

	@session_start();
	if (isset($_SESSION["tiempo"])) {  
		$_SESSION["tiempo"] = time(); //Devuelve la fecha actual
	}
	switch ($_GET['op']) {
	    case 'list_shop':
		    // echo json_encode("hola lista ");
			// exit;
			include("module/shop/view/list_shop.html");	
			break;
			
		case 'all_cars':
			// echo json_encode("hola lista op");
			// exit;
			$prod = $_POST['total_prod'];
			$items = $_POST['items'];
			// echo json_encode("productos ".$prod." items ".$items);
			// exit;
			 try{
                $daoshop = new DAO_shop();
                $container_shop = $daoshop->select_all_cars($prod, $items);
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
		// echo json_encode($_POST['filter']);
		// exit;
			
				$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter'], $_POST['total_prod'], $_POST['items']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;

	case 'count_all';
				$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> count_all_cars();
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
	case 'count_filters'; 
	// echo json_encode("hola count filters");
	// exit;   
				$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> count_pagination($_POST['filter']);
				// echo json_encode($selSlide);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;			
	case 'filter_marca';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter'], $_POST['total_prod'], $_POST['items']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;

	case 'filter_carro';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter'], $_POST['total_prod'], $_POST['items']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
				
	case 'filter_tipo';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter'], $_POST['total_prod'], $_POST['items']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
				
	case 'filter_comb';
			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter'], $_POST['total_prod'], $_POST['items']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
	case 'filter_search';

			$homeQuery = new DAO_shop();
				$selSlide = $homeQuery -> filters($_POST['filter'], $_POST['total_prod'], $_POST['items']);
				if (!empty($selSlide)) {
					echo json_encode($selSlide);
				}
				else {
					echo "error";
				}
				break;
	case 'cars_related':
		// echo json_encode("hola");
		// exit;
        $marca = $_POST['marca'];
		// echo json_encode($marca);
		// exit;
        
        $items =  $_POST['items'];
		// echo json_encode($items);
		// exit;
        try {
            $dao = new DAO_Shop();
            $rdo = $dao->select_cars_related($marca, $items);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;
	case 'count_cars_related';
		// echo json_encode("hola php");
		// exit;
	    $marca = $_POST['marca'];
		// echo json_encode($_POST['marca']);
		// exit;
        try {
            $dao = new DAO_Shop();
            $rdo = $dao->count_more_cars_related($marca);
			// echo json_encode($rdo);
			// exit;
        }catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
		break;
		
		case 'control_likes':
        $token = $_POST['token'];
        $id_car = $_POST['id_car'];

        try {
            $json = decode_token($token);
            $dao = new DAO_shop();
            $rdo = $dao->select_likes($id_car, $json['username']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            if (count($dinfo) === 0) {
                $dao = new DAO_shop();
                $rdo = $dao->like($id_car, $json['username']);
                echo json_encode("like");
            } else {
                $dao = new DAO_shop();
                $rdo = $dao->dislike($id_car, $json['username']);
                echo json_encode("dislike");
            }
        }
        break;
		case 'load_likes_user';
        try {
            $json = decode_token($_POST['token']);
            $dao = new DAO_shop();
            $rdo = $dao->select_load_likes($json['username']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;
	}

<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/MVC_cars_V10/';
include($path . "/module/login/model/DAO_login.php");
include($path . "model/middleware_auth.php");
session_start();

switch ($_GET['op']) {
    
    case 'login-register_view';
   
        include("module/login/view/login_register.html");
        break;

    case 'register':
        // echo json_encode("hola case register");
        // exit;
    //     // Comprobar que la email no exista
    // echo json_encode($_POST['email_reg']);
    //         exit;
        try {
            $daoLog = new DAOLogin();
            $check = $daoLog->control_registro_mail($_POST['email_reg']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        try {
            $daoLog = new DAOLogin();
            $check1 = $daoLog->control_registro_user($_POST['username_reg']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        // echo json_encode($check);
        // exit;
        if ($check || $check1) {
            $check_control = false;
        } else {
            // echo json_encode("error_email");
            $check_control = true;
        }

        // Si no existe el email creará el usuario
        if ($check_control == true) {
            try {
                $daoLog = new DAOLogin();
                $rdo = $daoLog->insert_user($_POST['username_reg'], $_POST['email_reg'], $_POST['passwd1_reg']);
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }
            if (!$rdo) {
                echo json_encode("error_user");
                exit;
            } else {
                echo json_encode("ok");
                exit;
            }
        } 
        // else {
        //     echo json_encode("error_email");
        //     exit;
        // }
        if($check){
            echo json_encode("error_email");
            exit;
        }else if($check1){
            echo json_encode("error_user");
            exit;
        }
        break;
    
    case 'login':
        // echo json_encode("hola case login");
        // exit;
        try {
            $daoLog = new DAOLogin();
            $rdo = $daoLog->seleccionar_usuario($_POST['username_log']);
            // echo json_encode($rdo);
            // exit;
            if ($rdo == "error_user") {
                echo json_encode("error_user");
                exit;
            } else {
                           
                if (password_verify($_POST['passwd_log'], $rdo['password'])) {
                    // echo json_encode($rdo);
                    $token= create_token($_POST['username_log']);
                    // exit;
                    // $_SESSION['username'] = $rdo['username']; //Guardamos el usuario 
                    // $_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
                    echo json_encode($token);
                    exit;
                } 
                else {
                    echo json_encode("error_passwd");
                    exit;
                }
            }
               
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        break;

    // case 'logout':
    //     unset($_SESSION['username']);
    //     unset($_SESSION['tiempo']);
    //     session_destroy();

    //     echo json_encode('Done');
    //     break;

    case 'data_user':
        $json = decode_token($_POST['token']);
        $daoLog = new DAOLogin();
        $rdo = $daoLog->select_data_user($json['username']);
        // echo json_encode($rdo);
        // exit;
        break;

    // case 'actividad':
    //     if (!isset($_SESSION["tiempo"])) {
    //         echo json_encode("inactivo");
    //         exit();
    //     } else {
    //         if ((time() - $_SESSION["tiempo"]) >= 1800) { //1800s=30min
    //             echo json_encode("inactivo");
    //             exit();
    //         } else {
    //             echo json_encode("activo");
    //             exit();
    //         }
    //     }
    //     break;

    // case 'controluser':
    //     $token_dec = decode_token($_POST['token']);

    //     if ($token_dec['exp'] < time()) {
    //         echo json_encode("Wrong_User");
    //         exit();
    //     }

    //     if (isset($_SESSION['username']) && ($_SESSION['username']) == $token_dec['username']) {
    //         echo json_encode("Correct_User");
    //         exit();
    //     } else {
    //         echo json_encode("Wrong_User");
    //         exit();
    //     }
    //     break;

    // case 'refresh_token':
    //     $old_token = decode_token($_POST['token']);
    //     $new_token = create_token($old_token['username']);
    //     echo json_encode($new_token);
    //     break;

    // case 'refresh_cookie':
    //     session_regenerate_id();
    //     echo json_encode("Done");
    //     exit;
    //     break;

    default;
        include("module/views/inc/error404.php");
        break;
}

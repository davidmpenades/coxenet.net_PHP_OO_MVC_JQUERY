<?php
	class connect{
		public static function con(){
			$host = 'localhost';  
    		$user = "root";                     
    		$pass = "";                             
    		$db = "cotxenet";                      
    		$port = 3306;                           
    		
    		
    		$conexion = mysqli_connect($host, $user, $pass, $db, $port)or die();
			return $conexion;
		}
		public static function close($conexion){
			mysqli_close($conexion);
		}
	}
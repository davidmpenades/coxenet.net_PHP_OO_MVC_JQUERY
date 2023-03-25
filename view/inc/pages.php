<?php
if(isset($_GET['page'])){
	switch($_GET['page']){
		case "homepage";
			include("module/home/view/home.html");
			break;
		case "ctrl_home";
			include("module/home/ctrl/".$_GET['page'].".php");
			break;
		case "ctrl_shop";
		    include("module/shop/controller/".$_GET['page'].".php");
			break;
		case "ctrl_login";
			include("module/login/ctrl/".$_GET['page'].".php");
			break;
		case "services";
			include("module/services/".$_GET['page'].".html");
			break;
		case "aboutus";
			include("module/aboutus/".$_GET['page'].".php");
			break;
		case "contactus";
			include("module/contact/".$_GET['page'].".html");
			break;
		case "404";
			include("error".$_GET['page'].".php");
			break;
		case "503";
			include("error".$_GET['page'].".php");
			break;
		default;
			include("module/home/view/home.html");
			break;
	}
}else{
	include("module/home/view/home.html");
}
?>


 <div class="navbar navbar-inverse navbar-fixed-top" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="view/img/header.jpg"  height="50"></a><br>
            </div>
            
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?page=ctrl_home&op=list">HOME</a></li>   
                    <li><a href="index.php?page=ctrl_shop&op=list_shop">SHOP</a></li>                  
                    <li><a href="index.php?page=controller_cars&op=list">Coches</a></li>
                    <li><a href="index.php?page=services">Servicios</a></li>
                    <li><a href="index.php?page=aboutus">Conocenos</a></li>
                    <li><a href="index.php?page=contactus">Contacto</a></li>                    
                    <li><a  id="button_login" href="index.php?page=ctrl_login&op=login-register_view">REGISTER-LOGIN</a></li>
                    <li><div id="user_info"></div></li>
                    <li><div  class="log-icon" ></div></li>                    
                </ul>
            </div>
        </div><br>
        
        <div class="container bg-white pt-3 px-lg-5 d-flex justify-content-center">
            <div class="row mx-n2">
                <div class="col-xl-3 col-lg-3 col-md-6 px-2">
                    <select class="custom-select px-4 mb-3 search_marca" style="height: 50px; width: 100%"></select>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 px-2">
                    <select class="custom-select px-4 mb-3 search_categoria" style="height: 50px; width: 100%"></select>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 px-2">
                    <input class="form-control" type="text" id="autocom" placeholder="City" autocomplete="off" style="height: 50px;" />
                    <div id="search_auto" style="color:white"></div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 px-2">
                    <button class="btn btn-primary btn-block mb-3 btna third" type="submit" style="height: 50px;" id="search-btn">Search</button>
                </div>
            </div>
        </div>
    </div>
   <!--/.NAVBAR END-->
    
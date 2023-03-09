function carousel_Brands() {
    ajaxPromise('module/home/ctrl/ctrl_home.php?op=Carrousel_Brand','GET', 'JSON')
    .then(function(data) {
            for (row in data) {
                $('<div></div>').attr('class', "carousel__elements click_marca").attr('id', data[row].descripcion).appendTo(".carousel__list").html(
                    "<img class='carousel__img' id='' src='" + data[row].img_marca + "' alt='' >"
                )
            }
        new Glider(document.querySelector('.carousel__list'), {
            slidesToShow: 5,
            slidesToScroll: 5,
            draggable: true,
            dots: '.dots',
            arrows: {
                prev: '.glider-prev',
                next: '.glider-next'
            }
        });

        })
        .catch(function() {
            window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Carrusel_Brands HOME";
        });


}


function loadCategories() {
    ajaxPromise('module/home/ctrl/ctrl_home.php?op=homePageCategory', 'GET', 'JSON')
        .then(function (data) {
            // console.log(data);
            for (row in data) {
                $('<div></div>').attr('class', "card click_cat").attr({ 'id': data[row].cod_categoria }).appendTo('#containerCategories')
                    .html(
                        "<div class='card_image'>" +
                        "<img src=" + data[row].img_cat + " />" +
                        "</div>" +
                        "<br>" +
                        "<div class='card_title title-black'>" +
                        "<p>" + data[row].nombre_cat + "</p>" +
                        "</div>"
                    )
            }
        }).catch(function () {
            // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        });
}


function loadCatTypes() {
    ajaxPromise('module/home/ctrl/ctrl_home.php?op=homePageType','GET', 'JSON')
    .then(function(data) {
        for (row in data) {
            $('<div></div>').attr('class', "card click_comb").attr({ 'id': data[row].cod_combustible }).appendTo('#containerTypecar')
                .html(
                    "<div class='card_image'>" +
                    "<img src=" + data[row].img_comb + " />" +
                    "</div>" +
                    "<br>" +
                    "<div class='card_title title-black'>" +
                    "<p>" + data[row].descripcion + "</p>" +
                    "</div>"
                )

        }
    }).catch(function() {
        window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
    });
}
function loadCarroceria() {
    ajaxPromise('module/home/ctrl/ctrl_home.php?op=homePageCarroceria', 'GET', 'JSON')
        .then(function (data) {
            for (row in data) {
                $('<div></div>').attr('class', "card click_carro ").attr({ 'id': data[row].descripcion }).appendTo('#containerTypecarroceria')
                    .html(
                        "<div class='card_image '>" +
                        "<img src=" + data[row].img_carroceria + " />" +
                        "</div>" +
                        "<br>" +
                        "<div class='card_title title-black'>" +
                        "<p>" + data[row].descripcion + "</p>" +
                        "</div>"
                    )

            }
        }).catch(function () {
            window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
        });
}
function loadvisitas() {
    ajaxPromise('module/home/ctrl/ctrl_home.php?op=homevisitas', 'GET', 'JSON')
        .then(function (data) {
            for (row in data) {
                $('<div></div>').attr('class', "card click_visitas ").attr({ 'id': data[row].cod_modelo }).appendTo('#containervisitas')
                    .html(
                        "<div class='card_image '>" +
                        "<img src=" + data[row].img_car + " />" +
                        "</div>" +
                        "<br>" 
                    )

            }
        }).catch(function () {
            window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
        });
}

function clicks() {
    //borramos los filtros
    localStorage.removeItem("home_marca");
    localStorage.removeItem("home_carro");
    localStorage.removeItem("home_comb");
    localStorage.removeItem("home_cat");
    localStorage.removeItem("filter_combustible");
    localStorage.removeItem("filter_categoria");
    localStorage.removeItem("filter_marca");
    localStorage.removeItem("filter_carroceria");
    localStorage.removeItem("filter");
  

    //marca______________________________________________
    $(document).on("click", '.click_marca', function () {
      localStorage.removeItem("filter");//borramos los filtros
    // console.log($('.click_carro').attr('id'));
   
      var filters = [];
      filters.push(['marca',this.getAttribute('id')]);
        localStorage.setItem('home_marca', JSON.stringify(filters)); 
        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
        }, 500);  
    });

    //categoria_________________________________________
    $(document).on("click", '.click_cat', function () {//detectamos el click
      localStorage.removeItem("filter");//borramos los filtros
    // console.log($('.click_carro').attr('id'));
      var filters = [];
      filters.push(['categoria',this.getAttribute('id')]);//almacenamos carroceria y el atributo en el array
        localStorage.setItem('home_cat', JSON.stringify(filters)); //lo almacenamos 
        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';//redireccionamos a shop
        }, 500);  
    });
    //combustible_________________________________________
     $(document).on("click", '.click_comb', function () {
      localStorage.removeItem("filter");//borramos los filtros
    // console.log($('.click_carro').attr('id'));
      var filters = [];
      filters.push(['cod_combustible',this.getAttribute('id')]);
        localStorage.setItem('home_comb', JSON.stringify(filters)); 
        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
        }, 500);  
     });
    
    // //carroceria_________________________________________
    $(document).on("click", '.click_carro', function () {
      localStorage.removeItem("filter");//borramos los filtros
    // console.log($('.click_carro').attr('id'));
      var filters = [];
      filters.push(['carroceria',this.getAttribute('id')]);
        localStorage.setItem('home_carro', JSON.stringify(filters)); 
        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
        }, 500);  
    });
        // //visitas_________________________________________
    $(document).on("click", '.click_visitas', function () {
      localStorage.removeItem("filter");//borramos los filtros
    // console.log($('.click_carro').attr('id'));
      var filters = [];
      filters.push(['cod_modelo',this.getAttribute('id')]);
        localStorage.setItem('homevisitas', JSON.stringify(filters)); 
        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
        }, 500);  
    });
  } 

$(document).ready(function () {
    clicks();
    carousel_Brands();
    loadCategories();
    loadCatTypes();
    loadCarroceria();
    loadvisitas();
    // console.log("hola");
});
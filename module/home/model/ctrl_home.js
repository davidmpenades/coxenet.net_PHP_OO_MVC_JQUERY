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
        // localStorage.setItem('filter_pag', JSON.stringify(filters));
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
        // localStorage.setItem('filter_pag', JSON.stringify(filters));
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
        // localStorage.setItem('filter_pag', JSON.stringify(filters));

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
        // localStorage.setItem('filter_pag', JSON.stringify(filters));

        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
        }, 500);  
    });
        // //visitas_________________________________________
    $(document).on("click", '.click_visitas', function () {
      localStorage.removeItem("filter");//borramos los filtros
      var filters = [];
      filters.push(['cod_modelo',this.getAttribute('id')]);
        localStorage.setItem('homevisitas', JSON.stringify(filters)); 
        // console.log(this.getAttribute('id'));
        setTimeout(function(){ 
          window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
        }, 500);  
    });
  } 
function loadSugerencias() {
    var limit = 3;

    $(document).on("click", '#btn-more-books', function() {
        limit = limit + 3;
        $('.books_car').remove();
        $('#load_more_books').remove();
        
        ajaxPromise('https://www.googleapis.com/books/v1/volumes?q=Cars','GET', 'JSON')
            .then(function(data) {
                if (limit === 9) {
                    $('<button class="no-results" id="">No hay mas libros disponibles....</button></br>').appendTo('.btn-more-books');
                } else {
                    $('<button class="load_more_button" id="load_more_books">LOAD MORE</button>').appendTo('.btn-more-books');
                }

                for (i = 0; i < limit; i++) {
                    $('<div></div>').attr({ id: 'books_car', class: 'books_car' }).appendTo('.containerbooks')
                        .html(
                        '<div  style="border: 1px solid black; display: flex; align-items: auto;">' +
                        '<img src="' + data.items[i].volumeInfo.imageLinks.thumbnail + '" +  alt="example image" style="flex: 1; width: 30%; margin-right: 1rem;">' +
                        '<div style="flex: 1;">' +
                            '<h2 style="font-size: 1.5rem; margin-bottom: 1rem;">' + data.items[i].volumeInfo.title + '</h2>' +
                            '<p style="margin-bottom: 1rem;">' +data.items[i].volumeInfo.publishedDate + '</p>' +
                            '<a href=' + data.items[i].volumeInfo.infoLink + ' target="_blank" class="btn btn-danger btn-block btn-lg adjust-border-radius">MORE INFO</a>' +
                        '</div>' +
                        '</div>' +
                        '<br>'
                        );
                }
            }).catch(function() {
                // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=News cars HOME";
            });
    })
}

function getSugerencias() {
    limit = 3;

    ajaxPromise('https://www.googleapis.com/books/v1/volumes?q=Cars','GET', 'JSON')
        .then(function(data) {
            data.items.length = limit;
            $('<h2 class="cat"></h2>').appendTo('.containerbooks');
            $('<button class="load_more_button" id="load_more_books">LOAD MORE</button>').appendTo('.btn-more-books');
            
            for (i = 0; i < data.items.length; i++) {
                $('<div></div>').attr({ id: 'books_car', class: 'books_car' }).appendTo('.containerbooks')
                    .html(
                        '<div  style="border: 1px solid black; display: flex; align-items: auto;">' +
                        '<img src="' + data.items[i].volumeInfo.imageLinks.thumbnail + '" +  alt="example image" style="flex: 1; width: 200px; margin-right: 1rem;">' +
                        '<div style="flex: 1;">' +
                            '<h2 style="font-size: 1.5rem; margin-bottom: 1rem;">' + data.items[i].volumeInfo.title + '</h2>' +
                            '<p style="margin-bottom: 1rem;">' +data.items[i].volumeInfo.publishedDate + '</p>' +
                            '<a href=' + data.items[i].volumeInfo.infoLink + ' target="_blank" class="btn btn-danger btn-block btn-lg adjust-border-radius">MORE INFO</a>' +
                        '</div>' +
                        '</div>' +
                        '<br>'
                        );
            }
        }).catch(function() {
            // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=News cars HOME";
        });
    loadSugerencias();
}
$(document).ready(function () {
    clicks();
    carousel_Brands();
    loadCategories();
    loadCatTypes();
    loadCarroceria();
    loadvisitas();
    getSugerencias()
});
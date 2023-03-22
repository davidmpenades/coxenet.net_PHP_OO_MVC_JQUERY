
function ajaxForSearch(url, filter, total_prod, items) {
  ajaxPromise(url, "POST", "JSON", { 'filter': filter, 'total_prod': total_prod,'items':items })
    .then(function (data) {
      console.log(data);

      $("#all_cars").empty();
      if (filter === "error") {
        
        $("<div></div>")
          .appendTo("#all_cars")
          .html(
            "<h3>¡No se encuentran resultados con los filtros aplicados!</h3>"
          );
      } else {
        for (row in data) {
          $("<div></div>")
            .attr("class", "card")
            .attr({ id: data[row].id_car })
            .appendTo("#all_cars")
            .html(
              "<div class='container mt-5 mb-5'>" +
                "<div class='d-flex justify-content-center row'>" +
                "<div class='col-md-10'>" +
                "<div class='row p-2 bg-white border rounded mt-2'>" +
                "<div class='col-md-3 mt-1'><img class='img-fluid img-responsive rounded product-image' src=" +
                data[row].img_car +
                "></div>" +
                "<div class='col-md-6 mt-1'>" +
                "<h3>" +
                data[row].marca +
                " " +
                data[row].modelo +
                "</h3>" +
              "<div class='d-flex flex-row'>" +
              "<h3>" +
                data[row].categoria + " , " + data[row].observaciones +
                "</h3>" +
                "</div>" +
                "</div>" +
                "<div class='align-items-center align-content-center col-md-3 border-left mt-1'>" +
                "<div class=d-flex flex-row align-items-center'>" +
                "<h4 class='mr-1'>" +
                data[row].precio +
                "€" +
                "</h4>" +
                "<button id='" +
                data[row].id_car +
                "' class='more_info_list button-info' >Mas informacion</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<br>"
            );
        }
      }
      mapBox_all(data);
    }).catch(function (e) {
      $("#all_cars").empty();
      $("#map").empty();
      $("<div></div>")
        .appendTo("#all_cars")
        .html("<h1>No hay coches con estos filtros</h1>");
    });
}

function loadListCar(total_prod=0,items=3) {
  //filtro contiene el valor de filter almacenado en localstorage, con .getitem lo recogemos
  //parse, elimina el encapsulado del stringify
    // console.log(filter);
  
  var filtro = JSON.parse(localStorage.getItem("filter")) || false;
  var home_carro = JSON.parse(localStorage.getItem("home_carro")) || false;
  var home_tipo = JSON.parse(localStorage.getItem("home_cat")) || false;
  var home_marca = JSON.parse(localStorage.getItem("home_marca")) || false;
  var home_comb = JSON.parse(localStorage.getItem("home_comb")) || false;
  var search = JSON.parse(localStorage.getItem("filters_search")) || false;
  var homevisitas = JSON.parse(localStorage.getItem("homevisitas")) || false;
  // var order = JSON.parse(localStorage.getItem("homeorder")) || false;

  // console.log(search);
  // console.log(filtro);

  //comprobamos si filtro tiene valor para apuntar a ajaxForSearch
  if (filtro != false) {
    // console.log("hola1persi");
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter", filtro,total_prod,items);
    localStorage.setItem('filter_pag',JSON.stringify(filtro));
  } else if (home_carro != false) {
    console.log("hola2persi");
        
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter_carro", home_carro,total_prod,items);
    localStorage.setItem('filter_pag',JSON.stringify(home_carro));
    remove(filtro);
  }
  else if (home_tipo != false) {
    console.log("hola3persi");
   
   
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter_tipo", home_tipo,total_prod,items);
    localStorage.setItem('filter_pag',JSON.stringify(home_tipo));

    remove(filtro);
  } 
  else if (home_marca != false) {
    console.log("hola4persi");
    
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter_marca", home_marca,total_prod,items);
    localStorage.setItem('filter_pag',JSON.stringify(home_marca));
    remove(filtro);
  }
  else if (home_comb != false) {
   console.log("hola5");
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter_comb", home_comb,total_prod,items);
    localStorage.setItem('filter_pag',JSON.stringify(home_comb));
    remove(filtro);
  }
  else if (search != false) {
    
    console.log(search);
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter", search,total_prod,items);
    localStorage.setItem('filter_pag', JSON.stringify(search));
    // localStorage.removeItem("filters_search");
  }
  else if (homevisitas != false) {
   
    // console.log("hola search");
  
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter", homevisitas);
    localStorage.removeItem("homevisitas");
  }
//     else if (homeorder != false) {
   
//     // console.log(homeorder);
  
//     ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter_order", homeorder);
//     localStorage.removeItem("homeorder");
// }
  else {
 
    ajaxForSearch("module/shop/controller/ctrl_shop.php?op=all_cars",undefined,total_prod,items);
    
  }
}

function clicks() {
  $(document).on("click", ".more_info_list", function () {
    var num_matricula = this.getAttribute("id");
    // console.log(num_matricula);
    loadDetails(num_matricula);
  });
}

function loadDetails(id_car) {
  // console.log(id_car);
  ajaxPromise(
    "module/shop/controller/ctrl_shop.php?op=one_car&id=" + id_car,"GET","JSON")
    .then(function (data) {
      // console.log(data);
      $("#all_cars").empty();
      $("#show_paginator").empty();
      $(".date_img_dentro").empty();
      $(".date_car_dentro").empty();
      $(".filters").empty();
      for (row in data[1][0]) {
        $("<div></div>")
          .attr({ id: data[1][0].img_car, class: "date_img_dentro" })
          .appendTo(".date_img")
          .html(
            "<br>" +
              "<div class='content-img-details'>" +
              "<img src= '" + data[1][0][row].img_car + "'" + "</img>" +
              "</div>"
          );
      }

      $("<div></div>").attr({ id: data[0].id_car, class: "carousel__elements" }).appendTo(".date_car")
        .html(
          "<div class='list_product_details'>" +
            "<div class='product-info_details'>" +
            "<div class='product-content_details'>" +
            "<br><br><br>" +
            "<h1><b>" +
            data[0].marca +
            "  " +
            data[0].modelo +
            "</b></h1>" +
            "<hr class=hr-shop>" +
            "<table id='table-shop'> <tr>" +
            "<td> <i id='col-ico' class='fa-solid fa-road fa-2xl'></i> &nbsp;" +
            "Kilometros: " +
            data[0].km +
            "KM" +
            "</td>" +
            "<td> <i id='col-ico' class='fa-solid fa-person fa-2xl'></i> &nbsp;" +
            "Matricula: " +
            data[0].num_matricula +
            "</td>  </tr>" +
            "<td> <i id='col-ico' class='fa-solid fa-car fa-2xl'></i> &nbsp;" +
            "Estado: " +
            data[0].categoria +
            "</td>" +
            "<td> <i id='col-ico' class='fa-solid fa-door-open fa-2xl'></i> &nbsp;" +
            "Numero de puertas: " +
            data[0].puertas +
            "</td>  </tr>" +
            "<td> <i id='col-ico' class='fa-solid fa-gas-pump fa-2xl'></i> &nbsp;" +
            "Etiqueta ambiental: " +
            data[0].etiqueta +
            "</td>" +
            "<td> <i id='col-ico' class='fa-solid fa-calendar-days fa-2xl'></i> &nbsp;" +
            "fecha de matriculación: " +
            data[0].f_mat +
            "</td>  </tr>" +
            "<td> <i id='col-ico' class='fa-solid fa-palette fa-2xl'></i> &nbsp;" +
            "Color: " +
            data[0].color +
            "</td>" +
            "<td> <i class='fa-solid fa-location-dot fa-2xl'></i> &nbsp;" +
            "Ciudad: " +
            data[0].ciudad +
            "</td> </tr>" +
            "</table>" +
            "<hr class=hr-shop>" +
            "<h3><b>" +
            "Mas Information:" +
            "</b></h3>" +
            "<p>Este vehículo tiene 2 años de garantia</p>" +
            "<div class='buttons_details'>" +
            "<a class='button add' href='#'>Add to Cart</a>" +
            "<a class='button buy' href='#'>Buy</a>" +
            "<span class='button' id='price_details'>" +
            data[0].precio +
            "€" +
            "<a class='details__heart' id='" +
            data[0].id_car +
            "'><i id=" +
            data[0].id_car +
            " class='fa-solid fa-heart fa-lg'></i></a>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>"           
      )
   
      
      new Glider(document.querySelector(".date_img"), {
        slidesToShow: 1,
        dots: "#dots",
        draggable: true,
        arrows: {
          prev: ".glider-prev",
          next: ".glider-next",
        },
      });
      mapBox(data[0]);

        more_cars_related(data[0].marca);
      
    })
    .catch(function () {
      // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Load_Details SHOP";
    });
}
function more_cars_related(marca) {
  // console.log(marca);
    var marca = marca;
    var items = 0;
    ajaxPromise('module/shop/controller/ctrl_shop.php?op=count_cars_related', 'POST', 'JSON', { 'marca': marca })
      .then(function (data) {
          // console.log(data);
        var total_items = data[0].n_prod;
        // console.log(total_items);
        cars_related(0, marca, total_items);
        
            $(document).on("click", '.load_more_button', function() {
                items = items + 3;
                // $('.more_car__button').empty();
                cars_related(items, marca, total_items);
            });
        }).catch(function() {
            console.log('error total_items');
        });
}
function cars_related(items, marca, total_items) {
  // console.log(marca);

    ajaxPromise("module/shop/controller/ctrl_shop.php?op=cars_related", 'POST', 'JSON', { 'marca': marca, 'total_items': total_items, 'items': items })
      .then(function (data) {
        console.log(data.length);
        $('.title_content').empty();
        
           if (items === total_items-1) {
                    $('<button class="no-results" id="">No hay mas coches disponibles....</button></br>').appendTo('.title_content');
                } else {
                    $('<button class="load_more_button" id="load_more_button">LOAD MORE</button>').appendTo('.title_content');
                }

                for (i = 0; i < data.length; i++) {
                    $('<div></div>').attr({ id: data[i].id_car, class: 'title_content' }).appendTo('.results')
                        .html(
                               "<li class='portfolio-item'>" +
                                "<div class='item-main'>" +
                                "<div class='portfolio-image'>" +
                                "<img src = " + data[i].img_car + " alt='imagen car' </img> " +
                                "</div>" +
                                "<h5>" + data[i].cod_marca + "  " + data[i].cod_modelo + "</h5>" +
                                "</div>" +
                                "</li>"
                        );
                }
        }).catch(function() {
            console.log("error pero paciencia");
        });
}
function load_pagination() {
  
  // console.log("filter");
  
  if (localStorage.getItem('filter_pag') != undefined) {
    console.log("hola filter_pag");
    var url = "module/shop/controller/ctrl_shop.php?op=count_filters";
    var filter = JSON.parse(localStorage.getItem("filter_pag"));
    console.log(filter);
} else {
    var url = "module/shop/controller/ctrl_shop.php?op=count_all";
    var filter = undefined;
}
  ajaxPromise(url, 'POST', 'JSON', {'filter':filter})
          .then(function(data) {
            console.log(data);
              var total_prod = data[0].n_prod;
              console.log(total_prod);

              if (total_prod >= 3) {
                  total_pages = Math.ceil(total_prod / 3)
              } else {
                  total_pages = 1;
              }
            $('#show_paginator').bootpag({
              total: total_pages,
              page: 1,
              maxVisible: 3
          }).on('page', function(event, num)
          {
            localStorage.setItem('page', num);
            total_prod = 3 * (num - 1);
            loadListCar(total_prod, 3);
            //  $("#dynamic_content").html("Page " + num); // or some ajax content loading...
          });
          })
  }
function print_filters() {
  $('<div class="div-filters"></div>').appendTo(".filters")
    .html(
        
        '<label for="combustible"> Combustible: </label>' +
        "    " +
        '<select class="filter_combustible">' +
        '<option value="electrico">Electrico</option>' +
        '<option value="hibrido">Hibrido</option>' +
        '<option value="diesel">Diesel</option>' +
        '<option value="gasolina">Gasolina</option>' +
        "</select>" +
        "   " +
        '<label for="categoria"> Categoria: </label>' +
        "   " +
        '<select class="filter_categoria">' +
        '<option value="km0">KM0</option>' +
        '<option value="2mano">2mano</option>' +
        '<option value="nuevo">Nuevo</option>' +
        "</select>" +
        "   " +
        '<label for="marca" >Marca: </label>' +
        " " +
        '<select class="filter_marca">' +
        '<option value="alfa_romeo">Alfa Romeo</option>' +
        '<option value="audi">Audi</option>' +
        '<option value="bmw">Bmw</option>' +
        '<option value="chevrolet">Chevrolet</option>' +
        '<option value="citroen">Citroen</option>' +
        '<option value="ford">Ford</option>' +
        '<option value="honda">Honda</option>' +
        '<option value="hyundai">Hyundai</option>' +
        '<option value="kia">Kia</option>' +
        '<option value="mazda">Mazda</option>' +
        '<option value="merche">Mercedes</option>' +
        '<option value="mini">Mini</option>' +
        '<option value="mitsu">Mitsubishi</option>' +
        '<option value="opel">Opel</option>' +
        '<option value="peugeot">Peugeot</option>' +
        '<option value="porsche">Porsche</option>' +
        '<option value="renault">renault</option>' +
        '<option value="seat">Seat</option>' +
        '<option value="suzuki">Suzuki</option>' +
        '<option value="vw">VW</option>' +
        "</select>" +
        "   " +
        '<label for="carroceria"> Carrocería: </label>' +
        "   " +
        '<select class="filter_carroceria">' +
        '<option value="suv">4x4/SUV</option>' +
        '<option value="pickup">Pick-up</option>' +
        '<option value="monovolumen">Monovolumen</option>' +
        '<option value="familiar">Familiar</option>' +
        '<option value="coupe">Coupe</option>' +
        '<option value="cabrio">Cabrio</option>' +
        '<option value="berlina">Berlina</option>' +
        "</select>" +
        "    " +
        '<label for="filter_order"> Ordenar por: </label>' +
        '<select class="filter_order">' +
        '<option value="precio">menor precio</option>' +
        '<option value="km">menos km</option>' +
        '<option value="visitas">menos visitados</option>' +
        "</select>" +
        "  " +
        '<button class="filter_button button-filtro" id="filter_button">Filtro</button>' +
        '<button class="filter_remove button-borrar" id="Remove_filter">Borrar</button>' +
        
        "    " +
        '<div id="overlay">' +
        '<div class= "cv-spinner" >' +
        '<span class="spinner"></span>' +
        "</div >" +
        "</div > " +
        "</div>" +
        "</div>" 
        
    );
}
function filter_button() {
  // console.log("hola");
  // Filtro combustible

  $(".filter_combustible").change(function () {
    localStorage.setItem("filter_combustible", this.value);
  });
  if (localStorage.getItem("filter_combustible")) {
    $(".filter_combustible").val(localStorage.getItem("filter_combustible"));
  }

  // Filtro categoria

  $(".filter_categoria").change(function () {
    localStorage.setItem("filter_categoria", this.value);
  });
  if (localStorage.getItem("filter_categoria")) {
    $(".filter_categoria").val(localStorage.getItem("filter_categoria"));
  }

  //Filtro marca

  $(".filter_marca").change(function () {
    localStorage.setItem("filter_marca", this.value);
  });
  if (localStorage.getItem("filter_marca")) {
    $(".filter_marca").val(localStorage.getItem("filter_marca"));
  }

  //filtro carroceria

  $(".filter_carroceria").change(function () {
    localStorage.setItem("filter_carroceria", this.value);
  });
  if (localStorage.getItem("filter_carroceria")) {
    $(".filter_carroceria").val(localStorage.getItem("filter_carroceria"));
  }
  //ordenar

  $(".filter_order").change(function () {

    localStorage.setItem("filter_order", this.value);
  });
  if (localStorage.getItem("filter_order")) {
    $(".filter_order").val(localStorage.getItem("filter_order"));
  }

  $(document).on("click", ".filter_button", function () {
    var filter = [];
    
    if (localStorage.getItem("filter_combustible")) {
      filter.push(["combustible", localStorage.getItem("filter_combustible")]);
    }
    if (localStorage.getItem("filter_categoria")) {
      filter.push(["categoria", localStorage.getItem("filter_categoria")]);
    }
    if (localStorage.getItem("filter_marca")) {
      filter.push(["marca", localStorage.getItem("filter_marca")]);
    }
    if (localStorage.getItem("filter_carroceria")) {
      filter.push(["carroceria", localStorage.getItem("filter_carroceria")]);
    }
    if (localStorage.getItem("filter_order")) {
      filter.push(["order", localStorage.getItem("filter_order")]);
    }
    // if (localStorage.getItem("filter_pag")) {
    //   filter.push(["filter_pag", localStorage.getItem("filter_pag")]);
    // }
    // console.log(filter);
    //con .stringify convierte en array filter, o dicho de otra forma lo encapsula
    localStorage.setItem("filter", JSON.stringify(filter));
       console.log(filter);
    if (filter) {
      console.log(filter);
      // location.reload();
      // localStorage.setItem("filter_pag", json.stringify(filter));
      // ajaxForSearch("module/shop/controller/ctrl_shop.php?op=filter", filter);
      loadListCar();
      load_pagination();
      
      
    } else {
      ajaxForSearch("module/shop/controller/ctrl_shop.php?op=all_cars");
    }
    // highlight(filter);
  });
}
function remove() {
  $(document).on("click", ".filter_remove", function () {
    localStorage.removeItem("filter_combustible");
    localStorage.removeItem("filter_categoria");
    localStorage.removeItem("filter_marca");
    localStorage.removeItem("filter_carroceria");
    localStorage.removeItem("filter");
    localStorage.removeItem("filter_order");
    location.reload();
  });
}
function mapBox_all(data) {
    mapboxgl.accessToken = 'pk.eyJ1IjoiMjBqdWFuMTUiLCJhIjoiY2t6eWhubW90MDBnYTNlbzdhdTRtb3BkbyJ9.uR4BNyaxVosPVFt8ePxW1g';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-0.61667, 38.83966492354664], // starting position [lng, lat]
        zoom: 7 // starting zoom
    });

    for (row in data) {
        const marker = new mapboxgl.Marker()
        const minPopup = new mapboxgl.Popup()
        minPopup.setHTML('<h3 style="text-align:center;">' + data[row].marca + '</h3><p style="text-align:center;">Modelo: <b>' + data[row].modelo + '</b></p>' +
            '<p style="text-align:center;">Precio: <b>' + data[row].precio + '€</b></p>' +
            '<img style="width: 120px;margin:auto;" src=" ' + data[row].img_car + '"/>' +
            "<button id='" +
                data[row].id_car +
                "' class='more_info_list button-info' >Mas informacion</button>")
        marker.setPopup(minPopup)
            .setLngLat([data[row].lon, data[row].lat])
            .addTo(map);
    }
}
function mapBox(id) {
    mapboxgl.accessToken = 'pk.eyJ1IjoiMjBqdWFuMTUiLCJhIjoiY2t6eWhubW90MDBnYTNlbzdhdTRtb3BkbyJ9.uR4BNyaxVosPVFt8ePxW1g';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [id.lon, id.lat], // starting position [lng, lat]
        zoom: 10 // starting zoom
    });
    const markerOntinyent = new mapboxgl.Marker()
    const minPopup = new mapboxgl.Popup()
    minPopup.setHTML('<h4>' + id.marca + '</h4><p>Modelo: ' + id.modelo + '</p>' +
        '<p>Precio: ' + id.precio + '€</p>' +
        '<img style="width: 120px;" src=" ' + id.img_car + '"/>')
    markerOntinyent.setPopup(minPopup)
        .setLngLat([id.lon, id.lat])
        .addTo(map);
}

$(document).ready(function () {
  loadListCar();
  clicks();
  print_filters();
  filter_button();
  load_pagination();
  remove();
});

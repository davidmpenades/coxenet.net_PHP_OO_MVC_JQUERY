function load_marcas() {

    ajaxPromise('module/search/ctrl/ctrl_search.php?op=search_marca', 'POST', 'JSON')
        .then(function (data) {

            $('<option>Marca</option>').attr('selected', true).attr('disabled', true).appendTo('.search_marca')
            for (row in data) {
            //  console.log(data);
                $('<option value="' + data[row].descripcion + '">' + data[row].descripcion + '</option>').appendTo('.search_marca')
            }
        }).catch(function () {
            window.location.href = "index.php?modules=exception&op=503&error=fail_load_marca&type=503";
        });
}

function load_categoria(marca) {
    // console.log(marca);
    $('.search_categoria').empty();

    if (marca === undefined) {
        ajaxPromise('module/search/ctrl/ctrl_search.php?op=search_categoria_null', 'POST', 'JSON')
            .then(function (data) {
                
                $('<option>Categoria</option>').attr('selected', true).attr('disabled', true).appendTo('.search_categoria')
                for (row in data) {
                    // console.log(data);
                    $('<option value="' + data[row].cod_categoria + '">' + data[row].nombre_cat + '</option>').appendTo('.search_categoria')
                }
            }).catch(function () {
                window.location.href = "index.php?module=exception&op=503&error=fail_load_categoria&type=503";
            });
    }
    else {
        ajaxPromise('module/search/ctrl/ctrl_search.php?op=search_categoria', 'POST', 'JSON', marca)
            .then(function (data) {
                // console.log(data);
                $('<option>Categoria</option>').attr('selected', true).attr('disabled', true).appendTo('.search_categoria')
                for (row in data) {
                    $('<option value="' + data[row].cod_categoria + '">' + data[row].nombre_cat + '</option>').appendTo('.search_categoria')
                }
            }).catch(function () {
                window.location.href = "index.php?module=exception&op=503&error=fail_load_categoria_2&type=503";
            });
    }
}

function launch_search() {

    load_marcas();
    load_categoria();
    $(document).on('change', '.search_marca', function () {
        let marca = $(this).val();
        if (marca === 0) {
            load_categoria();
        } else {
            load_categoria({marca});
        }
    });
}

function autocompleto() {
    $("#autocom").on("keyup", function () {
        
        let sdata = { city: $(this).val() };
        

        if (($('.search_marca').val() != 0)) {
            sdata.marca = $('.search_marca').val();
            if (($('.search_marca').val() != 0) && ($('.search_categoria').val() != 0)) {
                sdata.categoria = $('.search_categoria').val();
            }
        }
        if (($('.search_marca').val() == 0) && ($('.search_categoria').val() != 0)) {
            sdata.categoria = $('.search_categoria').val();
        }
 

        ajaxPromise('module/search/ctrl/ctrl_search.php?op=autocomplete', 'POST', 'JSON', sdata)
            .then(function (data) {
        // console.log(data);

                $('#search_auto').empty();
                $('#search_auto').fadeIn(10000000);
                for (row in data) {
                    $('<div></div>').appendTo('#search_auto').html(data[row].city).attr({ 'class': 'searchElement', 'id': data[row].city });
                }
                $(document).on('click', '.searchElement', function () {
                    $('#autocom').val(this.getAttribute('id'));
                    $('#search_auto').fadeOut(1000);
                });
                $(document).on('click scroll', function (event) {
                    if (event.target.id !== 'autocom') {
                        // $('#search_auto').fadeOut(1000);
                        $('#search_auto').empty();
                    }
                });
            }).catch(function () {
                $('#search_auto').fadeOut(500);
            });
    });
}

function button_search() {
    $('#search-btn').on('click', function () {
        // removeItem.localStorage("filters_search");
        var search = [];
        
        if ($('.search_marca').val() != 0 && $('.search_marca').val() != null) {
            search.push(["marca", $('.search_marca').val()])
            if ($('.search_categoria').val() != 0 && $('.search_categoria').val() != null) {
                search.push([ "categoria", $('.search_categoria').val() ])
            }
            if ($('#autocom').val() != 0) {
                search.push([ "city", $('#autocom').val() ])
            }
        } else if ($('.search_marca').val() == null) {
            if ($('.search_categoria').val() != 0 && $('.search_categoria').val() != null) {
                search.push([ "categoria", $('.search_categoria').val() ])
            }
            if ($('#autocom').val() != 0 ) {
                search.push([ "city", $('#autocom').val() ])
            }
        }
        localStorage.removeItem('filter');
        if (search.length != 0) {
            console.log(search);
            localStorage.setItem('filters_search', JSON.stringify(search));
            localStorage.setItem('filter_pag', JSON.stringify(search));
        }
        window.location.href = 'index.php?page=ctrl_shop&op=list_shop';
    });
}

$(document).ready(function () {
    
    launch_search();
    autocompleto();
    button_search();
});
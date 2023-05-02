function ajaxPromise(sUrl, sType, sTData, sData = undefined) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData
        }).done((data) => {
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            reject(errorThrow);
        });
    });
}
//================LOAD-HEADER================
function load_menu() {
// console.log('hola1');

    var token = localStorage.getItem('token');
    if (token) {
        ajaxPromise('module/login/ctrl/ctrl_login.php?op=data_user', 'POST', 'JSON', { 'token': token })
            .then(function(data) {
                // console.log(data);
                // if (data.type_user == "client") {
                //     console.log("Client loged");
                //     $('.opc_CRUD').empty();
                //     $('.opc_exceptions').empty();
                // } else {
                //     console.log("Admin loged");
                //     $('.opc_CRUD').show();
                //     $('.opc_exceptions').show();
                // }
        
                    // Si el token existe en localStorage, mostrar los divs para usuario logueado
                    $('#button_login').hide();
                    $('#button_login').empty();
                    $('.log-icon').empty();
                    $('#user_info').empty();
                    $('<img style="width:40px; border-radius:6px" src="' + data.avatar + '"alt="Robot">').appendTo('.log-icon');
                    $('<p></p>').attr({ 'id': 'user_info' }).appendTo('#user_info')
                        .html(
                            '<a>' + data.username + '<a/>'  +
                            '<a id="logout"><i class="fa fa-sign-out">LOGOUT</i></a>'                                                       
                        );
                        
            }).catch(function() {
                console.log("Error al cargar los datos del user");
            });
    } else {
        console.log("No hay token disponible");
        $('.opc_CRUD').empty();
        $('.opc_exceptions').empty();
        $('#user_info').empty();
        $('#user_info').hide();
        $('.log-icon').empty();
        $('.log-icon').hide();
        $('#button_cart').hide();
        $('.buy').hide();
        $('.add').hide();
        $('<a href="index.php?module=ctrl_login&op=login-register_view"><i id="col-ico" class="fa-solid fa-user fa-2xl"></i></a>').appendTo('.log-icon');
    }
}


//================CLICK-LOGIUT================
function click_logout() {
    $(document).on('click', '#logout', function() {
        localStorage.removeItem('total_prod');
        toastr.success("Logout succesfully");
        setTimeout('logout(); ', 1000);
    });
}

//================LOG-OUT================
function logout() {
    ajaxPromise('module/login/ctrl/ctrl_login.php?op=logout', 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('token');
            setTimeout(' window.location.href = "index.php?page=ctrl_home&op=list"; ', 1000);
        }).catch(function() {
            console.log('Something has occured');
        });
}

// Remove localstorage('page') with click in shop
function click_shop() {
    $(document).on('click', '#opc_shop', function() {
        localStorage.removeItem('page');
        localStorage.removeItem('total_prod');
    });
}

$(function() {
    // console.log('hola');
    load_menu();
    click_logout();
    // click_shop();
});
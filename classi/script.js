$(document).ready(function() {
    $('#password, #passwordConfirm').on('keyup', function() {
        if ($('#password').val() == $('#passwordConfirm').val()) {
            $('#registerMessage').html('Le password corrispondono').css('color', 'green');
            $('#registerButton').removeClass("disabled");
        } else {
            $('#registerMessage').html('Le password non corrispondono').css('color', 'red');
            $('#registerButton').addClass("disabled");
        }
    });
});

$(document).ready(function() {
    $('#newPassword, #checkNewPassword, #oldPassword').on('keyup', function() {
        if ($('#newPassword').val() == $('#checkNewPassword').val()) {
            $('#passwordMessage').html('Le password corrispondono').css('color', 'green');
            $('#confirmPassword').removeClass("disabled");
        } else {
            $('#passwordMessage').html('Le password non corrispondono').css('color', 'red');
            $('#confirmPassword').addClass("disabled");
        }
    });
});

$(document).ready(function() {
    $('#newMail, #checkNewMail').on('keyup', function() {
        if ($('#newMail').val() == $('#checkNewMail').val()) {
            $('#mailMessage').html('Le mail corrispondono').css('color', 'green');
            $('#confirmMail').removeClass("disabled");
        } else {
            $('#mailMessage').html('Le mail non corrispondono').css('color', 'red');
            $('#confirmMail').addClass("disabled");
        }
    });
});

function generaNotifiche(notifiche) {
    let result = '<div class="container-xl">';
    if (notifiche.length > 0) {
        for (let i = 0; i < notifiche.length; i++) {
            let articolo = `
                <div class="row mx-0">
                    <div class="col py-4">
                        <h3 class=" text-start pb-2">
                        Notifica n: ${notifiche[i]["id"]}
                        </h3>
                        <div class="bg-light border border-dark p-2">
                            <h4 class="text-start">
                                ${notifiche[i]["data"]}
                            </h4>
                            <p class="text-start">
                                ${notifiche[i]["testo"]}
                            </p>
                            <button class="btn btn-danger id="notifica${notifiche[i]["id"]} onclick="elimina_notifica(${notifiche[i]["id"]})" >Cancella notifica</button>
                        </div>
                    </div>
                </div>`;
            result += articolo;
        }
    } else {
        result += `<div class="row mx-0">
            <div class="col py-4">
                <h2 class=" text-center pb-2">
                    Nessuna notifica
                </h2>
            </div>`
    }
    result += "</div>";
    return result;
}

function checkNotifiche(notifiche) {
    return notifiche.length > 0 ? true : false;
}

function generaOrdini(ordini, stato) {
    let result = `
    <div class="container-xl">
        <div class="row mx-0">
            <div class="col text-center">
                <h2 class="text-capitalize pt-5 pb-2">`;
    if (stato == "preparazione") {
        if (ordini.length > 0) {
            result += "Ordini in preparazione";
        } else {
            result += "Nessun ordine in preparazione";
        }
    } else if (stato == "spediti") {
        if (ordini.length > 0) {
            result += "Ordini spediti";
        } else {
            result += "Nessun ordine spedito";
        }
    }

    result += ` </h2>
            </div>
        </div>
    </div>
    <div class="container-xl">`;
    if (ordini.length > 0) {
        for (let i = 0; i < ordini.length; i++) {
            let articolo = `
                <div class="row mx-0">
                    <div class="col text-capitalize py-4">
                        <h3 class=" text-start pb-2">
                            Spedizione n: ${ordini[i]["sid"]} 
                        </h3>
                        <div class="bg-light border border-dark p-2">
                            <h4 class="text-start">
                                ${ordini[i]["stato"]} 
                            </h4>
                            <h5 class="text-start">
                                ${ordini[i]["incasso"]} 
                            </h5>
                            <h5 class="text-start">
                                ${ordini[i]["data"]} 
                            </h5>
                            <h5 class="text-start">
                                N. prodotti: ${ordini[i]["n_prodotti"]} 
                            </h5>
            
                            <a class="btn btn-primary" href="shipping.php?shippingId=${ordini[i]["sid"]}">Dettagli</a>
                        </div>
                    </div>
                </div>`;
            result += articolo;
        }
    }
    result += "</div>";
    return result;
}

function updateHeader() {
    $.getJSON("api-notifica.php", function(data) {
        let articoli = checkNotifiche(data);
        if (articoli) {
            $("#notifyicon").css("color", "red");
            $("#menuicon").css("color", "red");
        } else {
            $("#notifyicon").css("color", "white");
            $("#menuicon").css("color", "white");
        }
    })
    $.getJSON("api-cartcount.php", function(data) {
        $("#cartCount").html("(" + data + ")");
    })
}

function generaLista(prodotti) {
    result = '';
    if (prodotti.length > 0) {
        for (let i = 0; i < prodotti.length; i++) {
            let articolo = `
            <li><a class="dropdown-item" href="product.php?productId=${prodotti[i]["id"]}">${prodotti[i]["nome"]}</a></li>`;
            result += articolo;
        }
    }
    return result;
}

function searchProducts() {
    input = document.getElementById('productName');
    filter = input.value.toUpperCase();
    if (filter.length > 0) {
        $.getJSON("api-search.php", {
            productName: filter
        }, function(data) {
            let lista = generaLista(data);
            $("#productList").html(lista);
        })
    }
}

function carica(status) {
    $.getJSON("api-ordini.php", {
        stato: status
    }, function(data) {
        let articoli = generaOrdini(data, status);
        if (status == "spediti") {
            $("#delivered_order").html(articoli);
        } else if (status == "preparazione") {
            $("#progress_order").html(articoli);
        }
    })
}

function carica_notifica() {
    $.getJSON("api-notifica.php", function(data) {
        let articoli = generaNotifiche(data);
        const main = $("#notifiche");
        main.html(articoli);
    })
}

function elimina_notifica(id) {
    $(".row").html = "ciao";
    $.ajax({
        url: 'removeNotify.php',
        type: 'POST',
        data: {
            deleteId: id
        },
        success: function() {
            carica();
            updateHeader();
        }
    })
}
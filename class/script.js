//Passrword checker for register
$(document).ready(function () {
    $('#password, #passwordConfirm').on('keyup', function () {
        if ($('#password').val() == $('#passwordConfirm').val()) {
            $('#registerMessage').html('Le password corrispondono').css('color', 'green');
            $('#registerButton').removeClass("disabled");
        } else {
            $('#registerMessage').html('Le password non corrispondono').css('color', 'red');
            $('#registerButton').addClass("disabled");
        }
    });
});

//password checker for password update
$(document).ready(function () {
    $('#newPassword, #checkNewPassword, #oldPassword').on('keyup', function () {
        if ($('#newPassword').val() == $('#checkNewPassword').val()) {
            $('#passwordMessage').html('Le password corrispondono').css('color', 'green');
            $('#confirmPassword').removeClass("disabled");
        } else {
            $('#passwordMessage').html('Le password non corrispondono').css('color', 'red');
            $('#confirmPassword').addClass("disabled");
        }
    });
});


// mail checker for mail update
$(document).ready(function () {
    $('#newMail, #checkNewMail').on('keyup', function () {
        if ($('#newMail').val() == $('#checkNewMail').val()) {
            $('#mailMessage').html('Le mail corrispondono').css('color', 'green');
            $('#confirmMail').removeClass("disabled");
        } else {
            $('#mailMessage').html('Le mail non corrispondono').css('color', 'red');
            $('#confirmMail').addClass("disabled");
        }
    });
});


// genera le notifiche restituite via ajax
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

// controlla se sono disponibili nuove notifiche
function checkNotifiche(notifiche) {
    return notifiche.length > 0 ? true : false;
}


//genera e formatta gli ordini restituiti via ajax
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

    } else if (stato == "consegnato") {
        if (ordini.length > 0) {
            result += "Ordini consegnati";
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


//aggiorna l'header dinamicamente in base alla presenza o meno di nuove notifiche e dei prodotti nel carrello
function updateHeader() {
    $.getJSON("api-notifica.php", function (data) {
        let articoli = checkNotifiche(data);
        if (articoli) {
            $("#notifyicon").css("color", "red");
            $("#menuicon").css("color", "red");
        } else {
            $("#notifyicon").css("color", "white");
            $("#menuicon").css("color", "white");
        }
    })
    $.getJSON("api-cartcount.php", function (data) {
        $("#cartCount").html("(" + data + ")");
    })
}


//genera la lista di prodotti cercati da mettere nel dropdown
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


//cerca prodotti dinamicamente via ajax per i suggerimenti nella searchbar
function searchProducts() {
    input = document.getElementById('productName');
    filter = input.value.toUpperCase();
    if (filter.length > 0) {
        $.getJSON("api-search.php", {
            productName: filter
        }, function (data) {
            let lista = generaLista(data);
            $("#productList").html(lista);
        })
    }
}


//funzione chiamata con polling di 20 secondi per caricare i nuovi ordini di ogni venditore via ajax
function carica(status) {
    $.getJSON("api-ordini.php", {
        stato: status
    }, function (data) {
        let articoli = generaOrdini(data, status);
        if (status == "spediti") {
            $("#shipped_order").html(articoli);
        } else if (status == "preparazione") {
            $("#progress_order").html(articoli);
        } else if (status == "consegnato") {
            $("#delivered_order").html(articoli);
        }
    })
}


//funzione che carica nuove notifiche con polling di 20 secondi
function carica_notifica() {
    $.getJSON("api-notifica.php", function (data) {
        let articoli = generaNotifiche(data);
        const main = $("#notifiche");
        main.html(articoli);
    })
}


//elimina una notifica via ajax
function elimina_notifica(id) {
    $(".row").html = "ciao";
    $.ajax({
        url: 'removeNotify.php',
        type: 'POST',
        data: {
            deleteId: id
        },
        success: function () {
            carica_notifica();
            updateHeader();
        }
    })
}


//funzione utilizzata nei input form password
function showPwd(input, icon) {
    if (input.type == "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}


//cambia dinamicamente il form per la registrazione
function changeRegisterForm(userType) {
    var label = document.getElementById('cfLabel');
    var pIVA = document.getElementById('cf');
    var nameForm = document.getElementById('nameForm');

    if (userType.value == "venditore") {
        label.innerText = "Partita Iva";
        pIVA.pattern = "[0-9]{11}$";
        nameForm.classList.replace("d-none", "d-block");
        nameForm.setAttribute("required", "");
    } else {
        label.innerText = "Codice fiscale";
        pIVA.setAttribute("pattern", "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$");
        nameForm.classList.replace("d-block", "d-none");
        nameForm.removeAttribute("required");
    }
}

//aggiunge i trattini all'inserimento del codice di carta di credito
function ccAddDot(input) {
    if (input.value.length > 0 && input.value.length < 18) {
        if (((input.value.length+1) % 5) == 0) {
            input.value += "-";
        }
    }
}


//calcola dinamicamente il costo totale del collo
function priceCalculator(qty, price){
    priceLabel = document.getElementById('price');
    priceLabel.innerHTML= "€ " + (Math.round((qty.value*price) * 100) / 100).toFixed(2);
}
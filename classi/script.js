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
    let result = "";

    for (let i = 0; i < notifiche.length; i++) {
        let articolo = `
    
            <section>
            <h2>${notifiche[i]["id"]}</h2>

            <p>${notifiche[i]["testo"]}</p>
            <p>${notifiche[i]["data"]}</p>
            </section>

        `;
        result += articolo;
    }
    return result;
}
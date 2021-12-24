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
                        </div>
                    </div>
                </div>`;
        result += articolo;
    }
    result += "</div>";
    return result;
}
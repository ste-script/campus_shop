<div class="row my-5 mx-0">
    <div class="col-7 col-md-4 mx-auto">
        <form action="#" method="POST">
            <fieldset class="mb-3">
                <legend class="h3">Selezionare Tipo Utente:</legend>
                <input type="radio" id="cliente" name="registerType" value="cliente" onclick="changeRegisterForm(this)" required checked>
                <label class="fs-5 ms-1" for="cliente">Cliente</label><br>
                <input type="radio" id="venditore" name="registerType" value="venditore" onclick="changeRegisterForm(this)">
                <label class="fs-5 ms-1" for="venditore">Venditore</label><br>
            </fieldset>
            <div class="mb-3 d-none" id="nameForm">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" minlength="1" name="name">
            </div>
            <div class="mb-3">
                <label for="registerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="registerEmail" name="registerEmail" required>
            </div>
            <div class="mb-3">
                <label for="cf" class="form-label" id="cfLabel">Codice fiscale</label>
                <input type="text" class="form-control" id="cf" name="cf" pattern="^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="password" minlength="4" name="password" autocomplete="on" required>
                    <div class="input-group-append">
                        <button class="btn btn-lg btn-outline-secondary fa fa-eye" type="button" onclick="showPwd(document.getElementById('password'), this)" id="iconPwd1"></button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="passwordConfirm" class="form-label">Conferma password</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="passwordConfirm" minlength="4" name="passwordConfirm" autocomplete="on" required>
                    <div class="input-group-append">
                        <button class="btn btn-lg btn-outline-secondary fa fa-eye" type="button" onclick="showPwd(document.getElementById('passwordConfirm'), this)" id="iconPwd2"></button>
                    </div>
                </div>
                <span id='registerMessage'></span>
            </div>

            <button type="submit" id="registerButton" class="btn btn-success">Registrati</button>
        </form>
    </div>

    <!-- Allert Modal -->
    <div class="modal fade" id="allertModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title text-danger">Errore Durante La Registrazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row my-5 mx-0">
    <div class="col-6 mx-auto">
        <?php
        if (isset($templateParams["erroreLogin"])) {
            echo "<script type='text/javascript'>
                        $(document).ready(function(){
                        $('#allertModal').modal('show');
                        });
                    </script>";
        }
        ?>
    </div>
</div>
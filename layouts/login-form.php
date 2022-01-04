<div class="row my-5 mx-0">
    <div class="col-5 mx-auto">
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="clientEmail" class="h3">Inserire Email</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail" placeholder="Email">
            </div>
            <label for="clientPassword" class="h3">Inserire Password</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control col-3" id="clientPassword" name="clientPassword" placeholder="Password" autocomplete="on">
                <div class="input-group-append">
                    <button class="btn btn-lg btn-outline-secondary fa fa-eye" type="button" onclick="showPwd()" id="iconPwd"></button>
                </div>
            </div>
            <fieldset class="mb-3">
                <legend class="h3">Selezionare Tipo Utente:</legend>
                <input type="radio" id="cliente" name="loginType" value="cliente" required checked>
                <label class="fs-5 ms-1" for="cliente">Cliente</label><br>
                <input type="radio" id="venditore" name="loginType" value="venditore">
                <label class="fs-5 ms-1" for="venditore">Venditore</label><br>
            </fieldset>
            <div class="col text-start">
                <button type="submit" class="btn btn-primary fs-5">Accedi</button>
            </div>
        </form>
    </div>
</div>

<div class="row my-5 mx-0">
    <div class="col-6 mx-auto">
        <?php
        if (isset($templateParams["erroreLogin"])) {
            echo "<p class='text-danger'>" . $templateParams["erroreLogin"] . "</p>";
        }
        ?>
    </div>
</div>
<div class="row my-5 mx-0">
    <div class="col-6 mx-auto">
        <form action="#" method="POST">
            <label class="form-label">Accedi come:</label>
            <div class="mb-3">
                <input type="radio" id="cliente" name="loginType" value="cliente" required checked>
                <label for="cliente">Cliente</label><br>
                <input type="radio" id="venditore" name="loginType" value="venditore">
                <label for="cliente">Venditore</label><br>
            </div>
            <div class="mb-3">
                <label for="clientEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail">
            </div>
            <div class="mb-3">
                <label for="clientPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="clientPassword" name="clientPassword" autocomplete="on">
            </div>
            <button type="submit" class="btn btn-primary">Accedi</button>
        </form>
        <form action="register.php" method="POST" class="py-5">
            <button type="submit" class="btn btn-success">Registrati</button>
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
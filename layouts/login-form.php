<div class="row my-5">
    <div class="col-6 mx-auto">
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="clientEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail">
            </div>
            <div class="mb-3">
                <label for="clientPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="clientPassword" name="clientPassword" autocomplete="on">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<div class="row my-5">
    <div class="col-6 mx-auto">
        <?php
        if (isset($templateParams["erroreLogin"])) {
            echo "<p class='text-danger'>" . $templateParams["erroreLogin"] . "</p>";
        }
        ?>
    </div>
</div>
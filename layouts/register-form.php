<script type="text/javascript">
    $(document).ready(function() {
        $('#clientPassword, #clientPasswordConfirm').on('keyup', function() {
            if ($('#clientPassword').val() == $('#clientPasswordConfirm').val()) {
                $('#message').html('Le password corrispondono').css('color', 'green');
                $('#registrati').removeClass("disabled");
            } else {
                $('#message').html('Le password non corrispondono').css('color', 'red');
                $('#registrati').addClass("disabled");
            }
        });
    });
</script>

<div class="row my-5 mx-0">
    <div class="col-6 mx-auto">
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="clientEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail">
            </div>
            <div class="mb-3">
                <label for="cf" class="form-label">Codice fiscale</label>
                <input type="text" class="form-control" id="cf" name="cf" pattern="^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" required="required">
            </div>
            <div class="mb-3">
                <label for="clientPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="clientPassword" name="clientPassword" autocomplete="on">
            </div>
            <div class="mb-3">
                <label for="clientPasswordConfirm" class="form-label">Conferma password</label>
                <input type="password" class="form-control" id="clientPasswordConfirm" name="clientPasswordConfirm" autocomplete="on">
                <span id='message'></span>
            </div>
            <button type="submit" id="registrati" class="btn btn-success">Registrati</button>
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
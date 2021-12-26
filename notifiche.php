<?php
require_once 'bootstrap.php';
$templateParams["titolo"] = "Campus Shop - Login";
if (!isUserLoggedIn() && !isVendorLoggedIn()) {
    header("Location: index.php");
    exit;
}
require('./layouts/header.php');
?>
<script>
    $(document).ready(function() {
        function carica() {
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
                    id: deleteid
                }
            });
            carica();
        }
        carica();
        setInterval(carica, 20000);
    });
</script>

<div id="notifiche" class="row mx-0">
</div>
<?php
require('./layouts/footer.php');

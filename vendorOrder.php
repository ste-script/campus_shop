<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Ordini";
include("./layouts/header.php");
if (!isVendorLoggedIn()) {
    header("Location: login.php");
    exit;
} ?>
<script>
    $(document).ready(function() {
        carica("spediti");
        carica("preparazione");
        setInterval(carica, 20000, "spediti");
        setInterval(carica, 20000, "preparazione");
    });

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
</script>


<div id="progress_order" class="row mx-0">
</div>
<div id="delivered_order" class="row mx-0">
</div>
<?php
require('./layouts/footer.php');

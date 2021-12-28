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
        //carica("ordinati");
        setInterval(carica, 20000, "spediti");
       // setInterval(carica, 20000, "ordinati");
    });

    function carica($status) {
        $.getJSON("api-ordini.php", {
            stato: $status
        }, function(data) {
            let articoli = generaOrdini(data);
            const main = $("#ordini");
            main.html(articoli);
        })
    }
</script>


<div id="ordini" class="row mx-0">
</div>
<?php
require('./layouts/footer.php');

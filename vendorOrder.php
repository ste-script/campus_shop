<?php
require_once("./bootstrap.php");

$templateParams["titolo"] = "Campus Shop - Ordini";
include("./layouts/header.php");
if (!isVendorLoggedIn()) {
    header("Location: login.php");
    exit;
} ?>
<script>
    //polling 20 sec
    $(document).ready(function() {
        carica("spediti");
        carica("preparazione");
        carica("consegnato");
        setInterval(carica, 20000, "spediti");
        setInterval(carica, 20000, "preparazione");
        setInterval(carica, 20000, "consegnato");
    });
</script>


<div id="progress_order" class="row mx-0">
</div>
<div id="shipped_order" class="row mx-0">
</div>
<div id="delivered_order" class="row mx-0">
</div>
<?php
require('./layouts/footer.php');

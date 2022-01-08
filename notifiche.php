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
    //polling di 20 sec
    $(document).ready(function() {
        carica_notifica();
        setInterval(carica_notifica, 20000);
    });
</script>

<div id="notifiche" class="row mx-0">
</div>
<?php
require('./layouts/footer.php');

<?php
require('bootstrap.php');
if (isset($_POST["quantitaOrdinata"]) && is_numeric($_POST["quantitaOrdinata"])) {
    $dbh->orderProduct($_POST["productId"], $_POST["quantitaOrdinata"], $_SESSION["userId"]);
}
header("Location: product.php?productId=" . $_POST["productId"]. "&ordered=1");

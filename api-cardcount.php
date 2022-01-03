<?php
require_once 'bootstrap.php';
if (isUserLoggedIn()) {
    $notifiche = count($dbh->getCartProductsByClientId($_SESSION["userId"]));
} else {
    $notifiche = "";
}
header('Content-Type: application/json');
echo json_encode($notifiche);

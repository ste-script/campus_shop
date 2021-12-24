<?php
require_once 'bootstrap.php';
if (isUserLoggedIn()) {
    $notifiche = $dbh->getNotifyFromClient($_SESSION["userId"]);
}
else if (isVendorLoggedIn()) {
    $notifiche = $dbh->getNotifyFromVendor($_SESSION["userId"]);
} else {
    $notifiche = "";
}
header('Content-Type: application/json');
echo json_encode($notifiche);

<?php
require_once 'bootstrap.php';
$id = 0;
if (isset($_POST['id']) && is_numeric($_POST['id'])) {

    if (isUserLoggedIn()) {
        $notifiche = $dbh->deleteNotifyFromClient($_POST['id']);
    } else if (isVendorLoggedIn()) {
        $notifiche = $dbh->deleteNotifyFromVendor($_POST['id']);
    } else {
        $notifiche = "";
    }
}

<?php
require_once 'bootstrap.php';
if (isset($_POST['deleteId']) && is_numeric($_POST['deleteId'])) {

    if (isUserLoggedIn()) {
        $notifiche = $dbh->deleteNotifyFromClient($_POST['deleteId']);
    } else if (isVendorLoggedIn()) {
        $notifiche = $dbh->deleteNotifyFromVendor($_POST['deleteId']);
    } else {
        $notifiche = "";
    }
}

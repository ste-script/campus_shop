<?php
require_once 'bootstrap.php';
$notifiche = $dbh->getNotifyFromClient($_SESSION["userId"]);
header('Content-Type: application/json');
echo json_encode($notifiche);
?>
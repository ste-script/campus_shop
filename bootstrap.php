<?php
session_start();
require_once("./class/db.php");
require_once("./class/utils.php");
$dbh = new DatabaseHelper("localhost", "root", "", "campus_shop", 3306);
define("UPLOAD_DIR", "./img/");
define("CAROUSEL_ITEM_NUMBER", 4);
?>


<?php
    require_once("./bootstrap.php");
    $dbh->newCategory($_POST["categoryName"]);
    include("index.php");
?>
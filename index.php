<?php
require_once("bootstrap.php");

foreach ($dbh->showProducts() as $nomeprodotto){
    echo $nomeprodotto["nome"];
}

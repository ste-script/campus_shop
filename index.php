<?php
require_once("bootstrap.php");

foreach ($dbh->showProducts(3) as $nomeprodotto){
    echo $nomeprodotto["nome"];
    
    //echo $nomeprodotto["foto"];
    echo $dbh->getImgFromId($nomeprodotto["id"]);
    echo $dbh->getCategoriesFromId($nomeprodotto["id"]);
    echo $nomeprodotto["descrizione"];
}

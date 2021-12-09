<?php
require_once("bootstrap.php");

/*
//TEST
foreach ($dbh->showProducts(3) as $nomeprodotto){
    echo $nomeprodotto["nome"];
    
    //echo $nomeprodotto["foto"];
    echo $dbh->getImgFromId($nomeprodotto["id"]);
    echo $dbh->getCategoriesFromId($nomeprodotto["id"]);
    echo $nomeprodotto["descrizione"];
}


//TEST
foreach ($dbh->getProductsFromCategories("uficio") as $nomeprodotto){
    echo $nomeprodotto["nome"];
    
    //echo $nomeprodotto["foto"];
    echo $dbh->getImgFromId($nomeprodotto["id"]);
    echo $dbh->getCategoriesFromId($nomeprodotto["id"]);
    echo $nomeprodotto["descrizione"];
}


foreach ($dbh->getProductsFromVendor(4) as $nomeprodotto){
    echo $nomeprodotto["nome"];
    
    //echo $nomeprodotto["foto"];
    echo $dbh->getImgFromId($nomeprodotto["id"]);
    echo $dbh->getCategoriesFromId($nomeprodotto["id"]);
    echo $nomeprodotto["descrizione"];
}*/

echo $dbh->orderProduct(5) ? "true" : "false";
//TEST
/*
echo $dbh->getProductFromId(3)["nome"];
*/
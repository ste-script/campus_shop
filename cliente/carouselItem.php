<button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
    <img src="..\img\1.jpg"width="70%"/>
    <h5>price</h5>
</button>         
<button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
    <img src="..\img\1.jpg"width="70%"/>
    <h5>price</h5>
</button>
<button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
    <img src="..\img\1.jpg"width="70%"/>
    <h5>price</h5>
</button> 
<button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
    <img src="..\img\1.jpg"width="70%"/>
    <h5>price</h5>
</button>

<?php
    foreach ($dbh->getProductsFromCategories("uficio") as $nomeprodotto){
        echo $nomeprodotto["nome"];
        
        //echo $nomeprodotto["foto"];
        echo $dbh->getImgFromId($nomeprodotto["id"]);
        echo $dbh->getCategoriesFromId($nomeprodotto["id"]);
        echo $nomeprodotto["descrizione"];
    }
?>
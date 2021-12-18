<?php
for ($i = $index; $i < count($prod) && $i < $index + CAROUSEL_ITEM_NUMBER; $i++) : ?>
    <a class=" btn btn-default align-top" href="product.php?productId=<?php echo $prod[$i]["id"] ?>">
        <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "/>"; ?>
        <div class="text-capitalize fs-6 pt-3">
            <p> <?php echo  $prod[$i]["nome"]; ?></p>
            <p class="fw-bold"> <?php echo "€" . $prod[$i]["prezzo"]; ?></p>
        </div>
    </a>
<?php
endfor;
$index = $i;
?>
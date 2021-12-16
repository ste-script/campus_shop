<?php
for($i=$index; $i<count($prod) && $i<$index+CAROUSEL_ITEM_NUMBER; $i++):?>
    <button class="btn btn-default align-top" style="max-height: 20%; max-width: 20%;"> <!-- CSS -->
        <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "width='70%'/>"; ?>
        <div class="text-capitalize fs-6 pt-3">
            <p> <?php echo  $prod[$i]["nome"]; ?></p>
            <p class="fw-bold"> <?php echo "€" . $prod[$i]["prezzo"]; ?></p>
        </div>
    </button>
<?php
    endfor;
    $index = $i;
?>
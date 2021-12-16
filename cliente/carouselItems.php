<?php
for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>

    <button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
        <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "width='70%'/>"; ?>
        <h5> <?php echo  $prod[$i]["nome"]; ?></h5>
        <h5> <?php echo "€" . $prod[$i]["prezzo"]; ?></h5>
    </button>

<?php
endfor;
$index = $i;
?>
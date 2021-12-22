<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
$shippingStatus = $templateParams["shippingStatus"];
?>
<div class="container-xl">
    <div class="row mx-0">
        <div class="col text-center">
            <h3 class="text-capitalize pt-5 pb-2">
                <?php echo $gridTitle; ?>
            </h3>
            <h4 class="text-capitalize pb-5">
                <?php echo $shippingStatus; ?>
            </h4>
        </div>
    </div>
</div>

<div class="container-xl">
    <?php while ($index < count($prod)) : ?>
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4">
            <?php
            for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>
                <div class="col">
                    <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "/>"; ?>
                    <h5> <?php echo  $prod[$i]["nome"]; ?></h5>
                    <p class="h6 fw-bold">Quantità: <?php echo $prod[$i]["quantita_prodotto"] ?></p>
                    <p class="h6">€<?php echo $prod[$i]['prezzo']; ?></p>
                    <p class="h6 fw-bold">TOT €<?php printf("%.2f" ,$prod[$i]['prezzo'] * $prod[$i]["quantita_prodotto"]); ?></p>

                </div>
            <?php
            endfor;
            $index = $i;
            ?>
        </div>
    <?php endwhile ?>
</div>
<?php require_once("./bootstrap.php");
$index = 0;
$shipping = $dbh->getShippingFromId($_GET["shippingId"]);
$prod = $dbh->getProductsFromShipping($shipping['id']);
if ($shipping["id_venditore"] != $_SESSION["userId"]) {
    header("Location: vendor.php");
    exit;
}
$shippingId = $shipping["id"];
$shippingStatus = $shipping["stato"];
$shippingIncome = $shipping["incasso"];
$shippingDate = $shipping["data"];
$templateParams["titolo"] = "Campus Shop - Spedizione N." . $shippingId;
include("layouts/header.php");
?>
<div class="container-xl">
    <div class="row mx-0">
        <div class="col text-capitalize py-4">
            <h3 class=" text-start pb-2">
                <?php echo "Spedizione n: " . $shippingId ?>
            </h3>
            <div class="bg-light border border-dark p-2">
                <h4 class="text-start">
                    <?php echo $shippingStatus; ?>
                </h4>
                <h5 class="text-start">
                    <?php echo $shippingIncome; ?>
                </h5>
                <h5 class="text-start">
                    <?php echo $shippingDate; ?>
                </h5>
                <h5 class="text-start">
                    <?php echo "N. prodotti: " .  count($prod) ?>
                </h5>
                <a class="btn btn-primary" href="#">Spedisci</a>
            </div>
        </div>
    </div>
</div>

<div class="container-xl">
    <?php while ($index < count($prod)) : ?>
        <div class=" row row-cols-2 row-cols-sm-2 row-cols-md-4">
            <?php
            for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>
                <div class="col text-capitalize text-center">
                    <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "/>"; ?>
                    <h5 class="mt-3"> <?php echo  $prod[$i]["nome"]; ?></h5>
                    <p class="h6 fw-bold">Quantità: <?php echo $prod[$i]["quantita_prodotto"] ?></p>
                    <p class="h6">€<?php echo $prod[$i]['prezzo']; ?></p>
                    <p class="h6 fw-bold">TOT €<?php printf("%.2f", $prod[$i]['prezzo'] * $prod[$i]["quantita_prodotto"]); ?></p>
                </div>
            <?php
            endfor;
            $index = $i;
            ?>
        </div>
    <?php endwhile ?>
</div>

<?php
include("layouts/footer.php");
?>
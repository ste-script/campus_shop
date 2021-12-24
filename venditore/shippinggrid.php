<?php require_once("./bootstrap.php");
$prod = $templateParams["products"];
$shippingId = $templateParams["shippingId"];
$shippingStatus = $templateParams["shippingStatus"];
$shippingIncome = $templateParams["shippingIncome"];
$shippingDate = $templateParams["shippingDate"];
$_SESSION["templateParams"] = $templateParams;
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

                <a class="btn btn-primary" href="shipping.php?shippingId=<?php echo $shippingId ?>">Dettagli</a>
            </div>
        </div>
    </div>
</div>
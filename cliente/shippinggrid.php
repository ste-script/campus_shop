<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
$shippingStatus = $templateParams["shippingStatus"];
$shippingIncome = $templateParams["shippingIncome"];
$shippingDate = $templateParams["shippingDate"];
?>
<div class="container-xl">
    <div class="row mx-0">
        <div class="col text-capitalize py-4">
            <h3 class=" text-start pb-2">
                <?php echo $gridTitle; ?>
            </h3>
            <div class="bg-light border border-dark">
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
            </div>
        </div>
    </div>
</div>
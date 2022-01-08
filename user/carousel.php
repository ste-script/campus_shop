<?php
require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$carouselTitle = $templateParams["carouselTitle"];

if (isVendorLoggedIn()) {
    $link = "vendorProducts.php?vendorId=" . $_SESSION["userId"];
} elseif (isUserLoggedIn() && $carouselTitle == "Carrello") {
    $link = "cart.php";
} else {

    $link = "categoryGrid.php?categoryId=" . $categories[$categoryIndex]['id'];
}
?>


<!-- CAROUSEL BTN -->
<div class="row mx-0">
    <div class="col mx-3 mt-4 mb-1 h-auto w-auto">
        <a class="btn btn-outline-dark text-capitalize" href="<?php echo $link ?>">
            <?php echo $carouselTitle; ?>
        </a>
    </div>
</div>

<!-- CAROUSEL -->
<div id="carouselControls<?php echo $carouselTitle; ?>" class="carousel carousel-dark slide" data-interval="false">
    <div class="carousel-inner mt-1 text-center">
        <div class="carousel-item active">
            <?php include("carouselItems.php"); ?>
        </div>
        <?php
        for ($carouselItemIndex = CAROUSEL_ITEM_NUMBER; $carouselItemIndex < count($prod); $carouselItemIndex += CAROUSEL_ITEM_NUMBER) : ?>
            <div class="carousel-item mt-1">
                <?php include("carouselItems.php"); ?>
            </div>
        <?php endfor;
        ?>
    </div>
    <button class="carousel-control-prev" data-bs-target="#carouselControls<?php echo $carouselTitle; ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </button>
    <button class="carousel-control-next" data-bs-target="#carouselControls<?php echo $carouselTitle; ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </button>
</div>
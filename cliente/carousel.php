<?php
    require_once("./bootstrap.php"); 
    $index=0;
?>

<!-- CAROUSEL BTN -->
<div class="row mx-1">
    <div class="col mt-4" style="max-height: 20%; max-width: 20%;">
        <button type="button" class="btn btn-outline-dark text-capitalize" style="font-size:2vmax">
            <?php echo $category["nome"];?>
        </button>
    </div>
</div>

<!-- CAROUSEL -->
<?php $prod=$dbh->getProductsFromCategories($category["nome"]);
$prod = array_merge($prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod);
?>
<div id="carouselControls<?php echo $category["nome"];?>" class="carousel carousel-dark slide" data-interval="false">
    <div class="carousel-inner mt-1 text-center">
        <div class="carousel-item active">
            <?php include("carouselItems.php"); ?>
        </div>
        <?php 
            for($carouselItemIndex=CAROUSEL_ITEM_NUMBER; $carouselItemIndex<count($prod); $carouselItemIndex+=CAROUSEL_ITEM_NUMBER):?>
                <div class="carousel-item mt-1">
                    <?php include("carouselItems.php");?>
                </div>
            <?php endfor;
        ?>
    </div>
    <button class="carousel-control-prev" data-bs-target="#carouselControls<?php echo $category["nome"];?>" data-bs-slide="prev" >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </button>
    <button class="carousel-control-next" data-bs-target="#carouselControls<?php echo $category["nome"];?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true" ></span>
        <span class="sr-only">Next</span>
    </button>
</div>
    

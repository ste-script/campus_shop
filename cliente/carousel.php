<?php
    require_once("./bootstrap.php"); 
    $index=0;
?>
<div class="row">
    <div class="col mx-3 mt-4" style="max-height: 20%; max-width: 20%;">
        <button type="button" class="btn btn-outline-primary">
            <?php echo $category["nome"];?>
        </button>
    </div>
</div>

<!-- CAROUSEL -->
<?php $prod=$dbh->getProductsFromCategories($category["nome"]); ?>
<div id="carouselControls<?php echo $category["nome"];?>" class="carousel slide" data-interval="false">
    <div class="carousel-inner mx-5 mt-1">
        <div class="carousel-item active">
            <?php include("carouselItems.php"); ?>
        </div>
        <?php 
            for($x=4; $x<count($prod); $x+=4):?>
                <div class="carousel-item ">
                    <?php include("carouselItems.php");?>
                </div>
            <?php endfor;
        ?>
    </div>
    <a class="carousel-control-prev float-left" href="#carouselControls<?php echo $category["nome"];?>" role="button"  data-slide="prev" >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next float-right" href="#carouselControls<?php echo $category["nome"];?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true" ></span>
        <span class="sr-only">Next</span>
    </a>
</div>
    

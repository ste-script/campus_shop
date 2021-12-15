<?php require_once("../bootstrap.php"); ?>
<div class="row">
    <div class="col mx-3 mt-4" style="max-height: 20%; max-width: 20%;">
        <button type="button" class="btn btn-outline-primary">
            <?php echo $category["nome"];?>
        </button>
    </div>
</div>

<div id="carouselControls" class="carousel slide" data-interval="false">
    <div class="carousel-inner mx-5 mt-1">
        <div class="carousel-item active">
            <?php
                $prod=$dbh->getProductsFromCategories($category["nome"]);
                for($i=0; $i<count($prod) && $i<4; $i++):?>
                    <button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
                        <img src=""width="70%"/>
                        <?php
                            echo $dbh->getImgFromId($prod[$i]["id"])."width='70%'/>";
                            echo "<h5>".$prod[$i]["prezzo"]."€</h5>";
                        ?>
                    </button> 
                <?php endfor;?>
        </div>
        <div class="carousel-item ">
            <button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
                <img src="..\img\1.jpg"width="70%"/>
                <h5>price</h5>
            </button>         
            <button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
                <img src="..\img\1.jpg"width="70%"/>
                <h5>price</h5>
            </button>
            <button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
                <img src="..\img\1.jpg"width="70%"/>
                <h5>price</h5>
            </button> 
            <button class="btn btn-default" style="max-height: 20%; max-width: 20%;">
                <img src="..\img\1.jpg"width="70%"/>
                <h5>price</h5>
            </button> 
        </div>
    </div>
    <a class="carousel-control-prev float-left" href="#carouselControls" role="button"  data-slide="prev" >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next float-right" href="#carouselControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true" ></span>
        <span class="sr-only">Next</span>
    </a></div>
    

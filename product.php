<?php
require('bootstrap.php');
if (!isset($_GET["productId"]) || !is_numeric($_GET["productId"])) {
    header("Location: index.php");
    exit;
}
$prod = $dbh->getProductFromId($_GET["productId"]);
$templateParams["titolo"] = "Campus Shop - " . $prod["nome"];
include("./isLogged.php");
include('./layouts/headerCostumer.php');

?>
<div class="single_product">
    <div class="row mx-0">
        <div class="col">
            <?php echo $dbh->getImgFromId($prod['id']) . ">"; ?>
        </div>
        <div class="col-lg-6 order-3">
            <div class="product_description">
                <div class="product_name"> <?php echo $prod["nome"]; ?></div>
                <div> <span class="product_category"><?php echo $dbh->getProductCategories($prod['id']); ?></div>
                <div> <?php echo $dbh->getVendorName($prod['id_venditore']); ?></div>
                <hr class="singleline">
                <div> <?php echo $prod['descrizione'] ?></div>

                <hr class="singleline">
                <div class="row">
                    <form action="addorder.php" method="POST">
                        <div class="col-xs-6">
                            <div class="product_quantity"> <span>Quantita: </span> <input id="quantitaOrdinata" name="quantitaOrdinata" type="text" pattern="[0-9]*" value="1"></div>
                        </div>
                        <div class="col-xs-6 my-2"> <button type="submit" class="btn btn-primary shop-button">Aggiungi al carrello</button></div>
                        <input type="hidden" value="<?php echo  $_GET["productId"]; ?>" name="productId">
                    </form>
                </div>
                <?php
                if (isset($_GET["ordered"])) {
                    echo "<p class='text-success'> Prodotto aggiunto al carrello </p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include('./layouts/footer.php');
?>
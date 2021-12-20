<?php
require('bootstrap.php');
if (!isset($_GET["productId"]) || !is_numeric($_GET["productId"])) {
    header("Location: index.php");
    exit;
}
$prod = $dbh->getProductFromId($_GET["productId"]);
$templateParams["titolo"] = "Campus Shop - " . $prod["nome"];
include('./layouts/headerCostumer.php');

?>
<div class="row justify-content-center mx-0">
    <div class="col-md-5 p-5">
        <?php echo $dbh->getImgFromId($prod['id']) . ">"; ?>
    </div>
    <div class="col-md-5 mt-5">
        <h1 class="display-5 fw-bolder"><?php echo $prod["nome"]; ?></h1>
        <div class="h3">
        <?php foreach ($dbh->getProductCategories($prod['id']) as $category): ?>
            <a class="text-capitalize text-decoration-none text-muted" href="categoryGrid.php?categoryName=<?php echo $category;?>"><?php echo $category;?>, <a>
        <?php endforeach;?>
        </div>
        <a class="h3 text-capitalize text-decoration-none text-muted" href="vendorGrid.php?vendorName=<?php echo $dbh->getVendorName($prod['id_venditore']);?>"><?php echo $dbh->getVendorName($prod['id_venditore']);?><a>
        
        <p class="lead my-2"><?php echo $prod['descrizione'] ?></p>
        <hr class="singleline">
        <div class="row">
            <form action="addorder.php" method="POST">
                <div class="my-3">
                    <span class="h3">Quantita: </span> 
                    <input type="number" required="required" name="quantity" min="1" value="1" max="<?php echo $prod["quantita_disponibile"]?>">
                    <span class="h3 fw-bold ms-5">€ <?php echo $prod['prezzo']; ?></span>
                </div>
                <div class="col-xs-2 my-2">
                    <input type="submit" class="btn btn-primary" value="Aggiungi al carrello"></input>
                </div>
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
<?php
include('./layouts/footer.php');
?>
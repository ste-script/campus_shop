<?php
    require_once("./bootstrap.php");

    $templateParams["titolo"] = "Campus Shop - Carte";
    $templateParams['gridTitle'] = "Carte";
    $templateParams['products'] = $dbh->getCardsFromIdClient($_SESSION["userId"]);
    require('./layouts/headerCostumer.php');
?>

<div class="row mx-0">
    <div class="col col-lg-auto h1 text-capitalize my-4 mx-3">
        <?php echo $templateParams['gridTitle']; ?>
    </div>
    <div class="col text-end p-3 my-4 mx-3">
        <form action="" method="POST">
        <div class="col">
            <input type="submit" class="btn btn-primary btn-lg " value="Aggiungi Carta"></input>
        </div>
        <input type="hidden" value="<?php echo  $p["id"] ?>" name="productId">
        <input type="hidden" value="1" name="removeProduct">
        </form>
    </div>
</div>

    
<div class="row mx-0">
    <?php
    $cardIndex=1; 
    foreach($templateParams['products'] as $card):?>
        <h2 class="mt-2">Carta #<?php echo $cardIndex++ ?></h2>
        <div class="col col-lg-auto border-dark bg-secondary text-white rounded p-3 m-2">
            <h3>Numero di Carta: <?php echo $card["codice"]?></h3>
            <h3 class="date">Data di scadenza: <?php echo $card["scadenza"]?></h3>
        </div>
        <div class="col col-lg-auto p-3 m-2">
            <form action="<?php $dbh->deleteCard($card["codice"])?>" method="POST">
            <div class="col">
                <input type="submit" class="btn btn-danger" value="Rimuovi Carta"></input>
            </div>
            <input type="hidden" value="<?php echo  $p["id"] ?>" name="productId">
            <input type="hidden" value="1" name="removeProduct">
            </form>
        </div>
    <?php endforeach; ?>
</div>
<?php
    require('./layouts/footer.php');

?>
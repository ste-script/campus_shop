<?php
    require_once("./bootstrap.php");
?>

<div class="container-xl">
  <div class="row mx-0">
    <div class="col col-lg-auto h1 text-capitalize my-4">
        <?php echo $templateParams['gridTitle']; ?>
    </div>
    <div class="col text-end p-3 my-4 mx-3">
      <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success">Aggiungi Carta</input>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Nuova Carta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="#" method="POST">
                <div class="row">
                    <div class="col-8">
                        <input type="text" class="form-control" size="10" required placeholder="Numero Carta" name="Card" id="card" pattern="[0-9]{3}">
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-6">
                    <input placeholder="Date" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.value == '' ? this.type='text' : this.type='date')" id="date">
                    </div>
                    <div class="col-3 text-end">
                        <input type="text" class="form-control" size="3" required placeholder="CVV" name="cvv" id="cvv" pattern="[0-9]{3}">
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-success" value="Conferma">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
    
<div class="row mx-0">
    <?php
    $cardIndex=1; 
    foreach($templateParams['products'] as $card):?>
        <h2 class="mt-2">Carta #<?php echo $cardIndex++ ?></h2>
        <div class="col col-lg-auto border-dark bg-secondary text-white rounded p-3 m-3">
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
<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
?>
<div class="container-xl">
  <div class="row mx-0">
    <div class="col text-center">
      <h1 class="text-capitalize p-5">
        <?php echo $gridTitle; ?>
      </h1>
    </div>
    <div class="col text-center p-5">
      <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success">Ordina Carrello</input>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Scegli carta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form action="#" method="POST">
              <label for="browser">Scegli la carta con cui pagare l'ordine:</label>
              <div class="row">
                <div class="col-8">
                  <input list="cardsList" class="form-control" required name="cards" id="cards">
                  <datalist id="cardsList">
                    <?php foreach ($dbh->getCardsFromIdClient($_SESSION["userId"]) as $card) : ?>
                      <option value="<?php echo $card["codice"] ?>">
                  </datalist>
                <?php endforeach ?>
                </div>
              </div>
          </div>
          <div class="row my-1">
            <div class="col-3">
              <input type="text" class="form-control" size="3" required placeholder="CVV"  name="cvv" id="cvv" pattern="[0-9]{3}">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chudi</button>
          <input type="submit" class="btn btn-success" value="Conferma">
        </div>
        </form>
      </div>
    </div>
  </div>

  <?php foreach ($prod as $p) : ?>
    <div class="row mx-0">
      <div class="col-6 text-center">
        <?php echo $dbh->getImgFromId($p["id"]) . "/>"; ?>
        <h5> <?php echo  $p["nome"]; ?></h5>
        <h5> <?php echo "€" . $p["prezzo"]; ?></h5>
      </div>
      <div class="col-6 text-center">
        <form action="#" method="POST">
          <div class="my-3">
            <span class="h3">Quantita: </span>
            <input type="number" class="form-control" required="required" name="quantity" min="1" value="<?php echo $p["quantita_prodotto"] ?>">
            <span class="h3 fw-bold ms-5">€ <?php echo $p['prezzo']; ?></span>
          </div>
          <div class="col my-2">
            <input type="submit" class="btn btn-primary" value="Modifica Quantit&agrave"></input>
          </div>
          <input type="hidden" value="<?php echo  $p["id"] ?>" name="productId">
          <input type="hidden" value="0" name="removeProduct">
        </form>
        <form action="#" method="POST">
          <div class="col my-2">
            <input type="submit" class="btn btn-danger" value="Rimuovi prodotto"></input>
          </div>
          <input type="hidden" value="<?php echo  $p["id"] ?>" name="productId">
          <input type="hidden" value="1" name="removeProduct">
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>
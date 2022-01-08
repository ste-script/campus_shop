<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
$cost = $templateParams["cost"];
?>
<div class="container-xl">
  <div class="row mx-0">
    <div class="col text-center">
      <div class="text-capitalize my-3 p-3 h1">
        <?php echo $gridTitle; ?>
      </div>
      <?php if (!empty($prod)) : ?>
        <div class="text-capitalize p-1 h4">
          Totale: €<?php echo $cost; ?>
        </div>
      <?php endif ?>
    </div>
    <?php if (!empty($prod)) : ?>
      <div class="col text-center p-5">
        <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success">Ordina Carrello</button>
      </div>
    <?php endif ?>
  </div>
  <?php if (empty($prod)) : ?>
    <div class="row mx-0">
      <div class="col text-center">
        <h4 class="text-capitalize p-5">
          Nessun prodotto nel carrello
        </h4>
      </div>
    </div>
  <?php endif ?>

  <hr class="solid my-5">
  
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Scegli carta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $cards = $dbh->getCardsFromIdClient($_SESSION["userId"]);
        if (!empty($cards)) : ?>
          <form action="#" method="POST">
            <div class="modal-body">
              <div class="row">

                <label for="cards">Scegli la carta con cui pagare l'ordine:</label>
                <div class="row">
                  <div class="col-8">
                    <select id="cardsList" class="form-control" required name="cards" id="cards">
                      <?php foreach ($cards as $card) : ?>
                        <option value="<?php echo $card["codice"]; ?>"><?php echo $card["codice"]; ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

              </div>
              <div class="row my-1">
                <div class="col-3">
                  <label class="ps-1 fs-5" for="cvv">Codice di Sicurezza </label>
                  <input type="text" class="form-control" size="3" required placeholder="CVV" name="cvv" id="cvv" pattern="[0-9]{3}">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-success" value="Conferma">
            </div>
          </form>
        <?php else : ?>
          <p class="mt-5 mx-auto"> Nessuna carta disponibile </p>
          <a class="btn btn-primary mx-auto mb-5" href="card.php">Gestisci carte</a>
        <?php endif ?>
      </div>
    </div>
  </div>

  <?php foreach ($prod as $p) : ?>
    <div class="row mx-0 my-5">
      <div class="col-6 text-center">
        <div class="col-md-6">
        <?php echo $dbh->getImgFromId($p["id"]) . "/>"; ?>
        <h5> <?php echo  $p["nome"]; ?></h5>
        </div>
      </div>
      <div class="col-6 align-top text-end">
        <form action="#" method="POST">
          <div class="col">
            <label class="h3" for="quantity">Quantità: </label>
            <div class="col-6 ms-auto mb-3 col-md-2">
              <input type="number" class="form-control " required="required" name="quantity" id="quantity" min="1" value="<?php echo $p["quantita_prodotto"] ?>">
              </div>
              <div class="h4 fw-bold">TOT. € <?php echo $p['prezzo'] * $p['quantita_prodotto']; ?></div>
              <div class="h6 fw-bold">CAD. € <?php echo $p['prezzo']; ?></div>
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
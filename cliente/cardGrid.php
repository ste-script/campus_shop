<?php
require_once("./bootstrap.php");
?>

<div class="container-xl">
  <div class="row mx-0">
    <div class="col col-lg-auto h1 text-capitalize my-4">
      <?php echo $templateParams['gridTitle']; ?>
    </div>
    <div class="col text-end p-3 my-4 mx-3">
      <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-success">Aggiungi Carta</button>
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
        <form action="#" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-8">
                <label class="ps-1 fs-5" for="card">Inserire Numero Carta </label>
                <input type="text" class="form-control" size="10" required placeholder="Numero Carta" name="card" id="card" pattern="[0-9]{10}">
              </div>
            </div>
            <div class="row my-1">
              <div class="col-6">
                <label class="ps-1 fs-5" for="date">Inserire Data Scadenza </label>
                <input id="date" name="date" placeholder="Date" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.value == '' ? this.type='text' : this.type='date')" id="date" name="date">
              </div>
              <div class="col-6">
                <label class="ps-1 fs-5" for="cvv">Codice di Sicurezza </label>
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

<?php
$cardIndex = 1;
if (!empty($templateParams['products'])) :
  foreach ($templateParams['products'] as $card) : ?>
    <div class="row mx-0">
      <h2 class="mt-2">Carta #<?php echo $cardIndex++ ?></h2>
      <div class="col col-lg-auto border-dark bg-secondary text-white rounded p-3 m-3">
        <h3>Numero di Carta: <?php echo $card["codice"] ?></h3>
        <h3 class="date">Data di scadenza: <?php echo $card["scadenza"] ?></h3>
      </div>
      <div class="col col-lg-auto p-3 m-2">
        <form action="#" method="POST">
          <div class="col">
            <input type="submit" class="btn btn-danger" value="Rimuovi Carta">
          </div>
          <input type="hidden" value="<?php echo  $card["codice"] ?>" name="cardId">
          <input type="hidden" value="1" name="removeProduct">
        </form>
      </div>
    </div>
  <?php endforeach;
else : ?>
  <div class="row mx-0">
    <div class="col text-center">
      <p class="my-5 h3"> Nessuna carta disponibile </p>
    </div>
  </div>
<?php endif ?>
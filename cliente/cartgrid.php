<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
?>
<div class="container-xl">
  <div class="row">
    <div class="col text-center">
      <h1 class="text-capitalize p-5">
        <?php echo $gridTitle; ?>
      </h1>
    </div>
    <div class="col text-center p-5">
      <form action="#" method="POST">
        <input type="submit" class="btn btn-success" value="Ordina Carrello"></input>
        <input type="hidden" value="1" name="orderCart">
      </form>
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
    <?php endforeach; ?>
    </div>
</div>
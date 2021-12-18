<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
?>
<div class="container-xl">
  <div class="roq">
    <div class="col">
      <button type="button" class="btn btn-outline-dark text-capitalize my-3">
        <?php echo $gridTitle; ?>
      </button>
    </div>
  </div>
  <?php while ($index < count($prod)) : ?>
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4">
      <?php
      for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>
        <div class="col">
          <a class="btn btn-default" href="product.php?productId=<?php echo $prod[$i]["id"] ?>">
            <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "/>"; ?>
            <h5> <?php echo  $prod[$i]["nome"]; ?></h5>
            <h5> <?php echo "€" . $prod[$i]["prezzo"]; ?></h5>
          </a>
        </div>
      <?php
      endfor;
      $index = $i;
      ?>
    </div>
  <?php endwhile ?>
</div>
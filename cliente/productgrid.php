<?php require_once("./bootstrap.php");
require_once("./layouts/headerCostumer.php");
//mobile 6 col-xl-3 colonne, desktop 8
$prod = $dbh->getProductsFromCategories("ufficio");
$prod = array_merge($prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod, $prod);
$index = 0;
?>

<div class="container-xl">
  <?php while ($index < count($prod)) : ?>
    <div class="row">
      <div class="col-6">
        <div class="row">
          <?php
          for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>
            <div class="col-xs-6 col-xl-3">
              <button class="btn btn-default">
                <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "width='50%'/>"; ?>
                <h5> <?php echo  $prod[$i]["nome"]; ?></h5>
                <h5> <?php echo "€" . $prod[$i]["prezzo"]; ?></h5>
              </button>
            </div>
          <?php
          endfor;
          $index = $i;
          ?>
        </div>
      </div>
      <div class="col-6">
        <div class="row">
          <?php
          for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>
            <div class="col-xs-6 col-xl-3">
              <button class="btn btn-default">
                <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "width='50%'/>"; ?>
                <h5> <?php echo  $prod[$i]["nome"]; ?></h5>
                <h5> <?php echo "€" . $prod[$i]["prezzo"]; ?></h5>
              </button>
            </div>
          <?php
          endfor;
          $index = $i;
          ?>
        </div>
      </div>
    </div>
  <?php endwhile ?>
</div>
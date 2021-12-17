<?php require_once("./bootstrap.php");
$index = 0;
$prod = $templateParams["products"];
$gridTitle = $templateParams["gridTitle"];
?>
<div class="container-xl">
  <div class="roq">
    <div class="col">
      <button type="button" class="btn btn-outline-dark text-capitalize my-3" style="font-size:2vmax">
        <!-- CSS -->
        <?php echo $gridTitle; ?>
      </button>
    </div>
  </div>
  <?php while ($index < count($prod)) : ?>
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4">
      <?php
      for ($i = $index; $i < count($prod) && $i < $index + 4; $i++) : ?>
        <div class="col">
          <a href="product.php?productId=<?php echo $prod[$i]["id"] ?>">
            <button class="btn btn-default">
              <?php echo $dbh->getImgFromId($prod[$i]["id"]) . "width='50%'/>"; ?>
              <h5> <?php echo  $prod[$i]["nome"]; ?></h5>
              <h5> <?php echo "€" . $prod[$i]["prezzo"]; ?></h5>
            </button>
          </a>
        </div>
      <?php
      endfor;
      $index = $i;
      ?>
    </div>
  <?php endwhile ?>
</div>
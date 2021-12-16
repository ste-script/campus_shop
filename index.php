<?php
    require_once("./bootstrap.php");
    include('./layouts/headerCostumer.php');
    
    $categories=$dbh->getCategories();
    for($categoryIndex=0; $categoryIndex<4 && $categoryIndex<count($categories); $categoryIndex++){
        $category = $categories[$categoryIndex];
        include('.\cliente\carousel.php');
    }

    
    include('./layouts/footer.php');
?>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
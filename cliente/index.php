<?php
    require_once("../bootstrap.php");
    include('../layouts/headerCostumer.php');
    
    foreach($dbh->getCategories() as $category){
        include('..\cliente\carousel.php');
    }

?>   

</body>
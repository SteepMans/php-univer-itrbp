<?php


include("./product.php");
include("./digit_product.php");
include("./physical_product.php");
include("./weight_product.php");

$products_array = array(new PhysicalProduct(100, 2), new DigitProduct(300), new WeightProduct(250, 2.0));

$sum = 0;

foreach ($products_array as $item) 
{
    $sum = $sum + $item->get_price();
}

echo $sum;
<?php
require('products_db.php');
require('components/header.php');

$items = get_products();
$filters = get_filters();
$type = $_GET['product_type'];


require('components/products_list.php');
require('components/footer.php');
?>

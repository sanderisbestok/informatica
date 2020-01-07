<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         categorieen.php
Description;  Specification page of a certain category. Category is selected by GET method.
Usage;        n/a
-->
<?php
  include_once('./globalUI/globalConnect.php');
  include_once('./stools/cartTools.php');

  $category_id = $_GET['category_id'];
  /* Get information about this category from ./stools/productTools.php */
  $category = getCategoryName($category_id);
  if(empty($category)) {
    header("Location: 404.php");
  }
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Categorieën</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/product.css" />
  </head>
  <body>
    <?php include('./globalUI/header.php'); ?>
    <div id="includedTop"></div>
    <div class="container">
      <div class="content">
        <?php
          echo "<h1>$category[category_name]</h1>";
        ?>
        <div class="listing">
          <?php
            /* Load the id's of the products in this category */
            $products = getCategoryProducts($category_id);

            foreach($products as $product_id) {
              /* Get all the information about the product that is loaded*/
              $product = getProductAll($product_id['product_id']);

              /* Convert price from cents to price in euro and cents (with tax) */
              $price = calculatePrice($product['price']);

              /* Redirect to self parameter. */
              $parameter = "category_id=$category_id";

              /* Generates products list. */
              include('./stools/genProds.php');
            }
          ?>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

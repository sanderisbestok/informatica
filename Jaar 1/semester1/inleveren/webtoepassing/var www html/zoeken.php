<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         zoeken.php
Description;  Search page containing the results typed in header search form.
Usage;        n/a
-->
<?php
  include_once('./globalUI/globalConnect.php');
  include_once('./stools/cartTools.php');
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Zoekresultaten</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/product.css" />
  </head>
  <body>
    <?php include('./globalUI/header.php'); ?>
    <div id="includedTop"></div>
    <div class="container">
      <div class="content">
        <?php
        $stmt = $globalDB ->prepare("
            SELECT product_id
              FROM products
            WHERE name
            LIKE ?
          ");
          $stmt->bindValue(1, "%" . $_GET['q'] . "%", PDO::PARAM_STR);
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

          echo "<h1>Zoekresultaten</h1>
                <div class='listing'>";

          if (sizeof($results) > 0) {
            foreach ($results as $row) {

              /* Get all the information about the product that is loaded*/
              $product = getProductAll($row['product_id']);

              /* Convert price from cents to price in euro and cents (with tax) */
              $price = calculatePrice($product['price']);

              /* Redirect to self parameter. */
              $parameter = "q=$_GET[q]";

              /* Generates products list. */
              include('./stools/genProds.php');
            }
          } else {
            echo "<h2>Niets gevonden</h2>";
          }
        ?>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

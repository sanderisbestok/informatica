<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         product.php
Description;  Specification page of a certain product. Product is selected by GET method.
Usage;        n/a
-->
<?php
  include_once('./globalUI/globalConnect.php');
  include_once('./stools/cartTools.php');

  $product_id = $_GET['product_id'];

  /* If product does not exist redirect to 404*/
  if(!doesProductExist($product_id)) {
      header('Location: 404.php');
      die();
  }

  /* Get all the information of the product from ./sTools/cartTools.php */
  $product = getProductAll($product_id);
  $spec_id = getSpecId($product_id);
?>

<!DOCTYPE html>
<html lang="nl">
  <head>
    <?php include('./globalUI/globalReqs.php'); ?>
    <title><?php print($product['name']); ?></title>
    <link rel="stylesheet" href="style/product.css" />
  </head>

  <body>
    <?php include('./globalUI/header.php');?>

    <!-- All the information of the product is received from the functions getProductAll
    we can use this with the variable $product['info_name']-->
    <div class="container">
      <div class="content">
        <?php echo " <a href='categorieen.php?category_id=$product[category_id]'><h1>$product[category_name]</a> > $product[name]</h1>"; ?>
        <div class="product row">
          <div class="product-image c-4">
            <?php echo "<img src='$product[path]' alt='$product[alt]' height='200px' />"; ?>
          </div>

          <div class="fix-align product-info c-8">
            <?php
            /* Convert price in cents to price in euro and cents with (tax) */
              $price = calculatePrice($product['price']);

                /* If submit button is pushed product will be added to cart and a special cart button will apear with the amount of this product is added to the cart */
                echo "<p class='product-price'>&euro;<span class='cartUpdatable cart eur'>".$price['price_eur']."</span>,</span class='cartUpdatable cart cent'>".$price['price_cent']."</span></p>";
                /* If product is not in stock, add to cart button dissapears*/
                if ($product['supply'] > 0) {
                  echo "
                    <form action='./stools/addtocart.php?redirect=$_SERVER[PHP_SELF]?product_id=$product[product_id]' method='post'>
                      <div class='bbWrap'>
                  ";
                  $inCart = inCart($product["product_id"]);
                  /* Addes side button if more then 0 of the product is in cart */
                  if($inCart > 0){
                    echo "
                      <div class='compositeButton'>
                        <button type='submit' name='addtocart' class='green start' value='$product[product_id]'>Voeg toe</button>
                        <a href='winkelwagen.php' class='green incart end' value='$product[product_id]'>$inCart</button></a>
                      </div>
                    ";
                  } else {
                    echo "
                      <button type='submit' name='addtocart' class='addtocart' value='$product[product_id]'>Voeg toe</button>
                    ";
                  }
                  echo "
                      </div>
                    </form>
                  ";
                }
                echo "
                  <p>Artikelnummer ".$product['serial_number']."</p>
                ";
            ?>

            <?php
              /* Check if product is in stock*/
              if ($product['supply'] > 0) {
                echo "<p class=stock>Op voorraad</p>";
              } else {
                echo "<p class=not-in-stock>Niet op voorraad</p>";
              }
            ?>
          </div>
        </div>

        <div class="product-description row">
          <div class="c-12">
            <h2>Beschrijving</h2>
            <?php echo "<p>$product[description]</p>"; ?>
          </div>
        </div>

        <div class="product-specification row">
          <div class="c-12">
            <h2>Specificaties</h2>
            <table>
              <?php
                foreach ($spec_id as $i) {
                  /* Load each spec and place them in a table, $spec_id's are received getSpecId() in ./stools/cartTools.php */
                  $i = $i[0];

                  $spec = getSpec($i);
                  echo "<tr><td>$spec[spec_name]</td><td>$spec[spec_value]</td></tr>";
                }
              ?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

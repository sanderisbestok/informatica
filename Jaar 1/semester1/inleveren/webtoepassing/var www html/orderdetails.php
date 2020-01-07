<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         orderdetails.php
Description;  Gives details of a certain order.
Usage;        n/a
-->
<!-- Make connection to the database -->
<?php
  include_once('./globalUI/globalConnect.php');
  include_once('./stools/orderTools.php');

  $order_id = $_GET['order_id'];

  /* Check if current user is the user who placed this order */
  if(empty($_SESSION["user_id"])){
    header("Location: index.php");
    die();
  } else if(userCheck(($_SESSION["user_id"]), $order_id)){
    header("Location: orderhistorie.php");
    die();
  }

  /* If order is canceled execute following function in ./stools/orderTools.php*/
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    changeOrderStatus($order_id);
  }
?>

<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Order details</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/product.css" />
    <link rel="stylesheet" href="style/order.css" />
  </head>

  <body>
    <!-- Header loaded from separate file -->
    <?php include('./globalUI/header.php'); ?>
    <div class="container">
      <div class="content order-details">

        <?php
          /* Get orderinfo from ./stools/orderTools.php */
          $order_info = getOrder($order_id);
          echo "
            <h1><a href='orderhistorie.php' class='backtohistory'>Bestelgeschiedenis</a> > Bestelnummer ".$order_id." van ".$order_info['date']."</h1>
            <h2>".$order_info['state']."</h2>
          ";
        ?>
        <div class="row">
          <div class="c12">
            <table>
              <thead>
                <tr>
                  <th>Artikel</th>
                  <th>Aantal</th>
                  <th>Artikelnummer</th>
                  <th>Prijs</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $order_products = getOrderProducts($order_id);

                  /* For each product get product details from ./stools/cartTools.php */
                  foreach($order_products as $order_product) {
                    $order_product_info = getProductAll($order_product['product_id']);
                    $order_product_amount = getOrderProductAmount($order_product['product_id'], $order_id);
                    $price = calculatePrice($order_product_amount['price']);
                    echo "
                      <tr>
                        <td data-label='Artikel'><a href=product.php?product_id=".$order_product_info['product_id'].">".$order_product_info['name']."</a></td>
                        <td data-label='Aantal'>".$order_product_amount['amount']."</td>
                        <td data-label='Artikelnummer'>".$order_product_info['serial_number']."</td>
                        <td data-label='Prijs'>&euro;".$price['price_eur'].",".$price['price_cent']."</td>
                      </tr>
                    ";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php
          /* Calculate price inclusive TAX from ./stools/cartTools.php */
          $total_price = calculatePrice($order_info['price']);
          echo "
              <p>Totaal bedrag: <span class='order-details-price'>&euro;".$total_price['price_eur'].",".$total_price['price_cent']."</span></p>";
          if ($order_info['canbecanceled']) {
            echo "
              <form action=".htmlspecialchars($_SERVER['PHP_SELF'])."?order_id=".$order_id." method='POST'>
                <button type='submit' class='cancelorder'>Annuleer bestelling</button>
              </form>
            ";
          }
          echo "
            <p><a href='facturen/factuur".$order_id.".pdf' target=_'blank'>Download factuur van deze bestelling</a></p>
          ";
        ?>
      </div>
    </div>
    <?php
      include('./globalUI/footer.php');
    ?>
  </body>
</html>

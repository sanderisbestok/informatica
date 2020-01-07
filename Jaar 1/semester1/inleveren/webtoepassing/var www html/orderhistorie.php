<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         orderhistorie.php
Description;  Page will return all orders with the total price and amount of products.
Usage;        n/a
-->
<!-- Make connection to the database -->
<?php
  include_once('./globalUI/globalConnect.php');
  include_once('./stools/cartTools.php');
  include_once('./stools/orderTools.php');

  /* Check if someone is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: index.php");
    die();
  }
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Bestelgeschiedenis</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/product.css" />
    <link rel="stylesheet" href="style/order.css" />
  </head>

  <body>
    <!-- Header loaded from separate file -->
    <?php include('./globalUI/header.php'); ?>
    <div class="container">
      <div class="content order-history">
        <h1>Mijn Bestelgeschiedenis</h1>
        <p>Hier kunt u uw bestelgeschiedenis bekijken. Bestellingen kunnen zolang ze
        in behandeling zijn worden geannuleerd in de detailweergave.</p>
        <div class="row">
          <div class="c12">
            <table>
              <thead>
                <tr>
                  <th>Bestelnummer</th>
                  <th>Datum</th>
                  <th>Aantal artikelen</th>
                  <th>Bedrag</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  /* Get all orders or current user */
                  $orders = getOrders($user_id);

                  /* For each order, print information */
                  foreach($orders as $order) {
                    unset($order_info);
                    $order_info = getOrder($order['order_id']);
                    /* Convert price from cents to price in euro and cents (with tax) */
                    $total_price = calculatePrice($order_info['price']);
                    echo "<tr class='orderrow' onclick=window.location.href='orderdetails.php?order_id=".$order['order_id']."'>";
                    echo "<td data-label=Bestelnummer>".$order['order_id']."</td>";
                    echo "<td data-label=Datum>".$order_info['date']."</td>";
                    echo "<td data-label=Aantal artikelen>".$order_info['amount']."</td>";
                    echo "<td data-label=Bedrag>&euro;".$total_price['price_eur'].",".$total_price['price_cent']."</td>";
                    echo "<td data-label=Status>".$order_info['state']."</td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer loaded from separate file -->
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

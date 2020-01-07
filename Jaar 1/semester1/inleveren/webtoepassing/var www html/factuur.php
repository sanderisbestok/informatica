<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         factuur.php
Description;  Set ups an invoice with the given order_id
Usage;        n/a
-->
<?php
  include_once('./globalUI/globalConnect.php');
  include_once('./stools/orderTools.php');
  include_once('stools/cartTools.php');

  $order_id = $_GET['order_id'];

?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Factuur</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/factuur.css" />
  </head>
  <div class="factuur">
    <div class="factuurLogo">
      <img src="resources/blue.png">
    </div>
    <div class="adresInfo">
        <div class="stuffzInfo">
          <p>
            Stuffz </br>
            Science Park 904 </br>
            1098XH Amsterdam </br></br>
            Voor meer informatie kunt u </br>
            terecht op: www.stuffz.nl
          </p>
        </div>
        <div class="klantInfo">
          <?php
            /* Get adress and name from ./stools/orderTools.php */
            $address = getAddress($order_id);
            $name = getName($order_id);
            echo "
              <p>".$name['first_name']."
            ";
            if(isset($name['prefix'])) {
              echo
                $name['prefix']."
              ";
            }
            echo
              $name['surname']."</br>
              ".$address['street']." ".$address['number']
            ;
            if(isset($address['addition'])) {
              echo " ".$address['addition'];
            }
            echo "
              </br>
              ".$address['postcode']." ".$address['city']."</br>
              </p>
            ";
          ?>
        </div>
      </div>
    <div class="factuurInfo">
      <h2>Factuur</h2>
      <p>
        <?php
          /* Get order info from ./stools/orderTools.php */
          $order_info = getOrder($order_id);
          echo "
            Datum: ".$order_info['date']."</br>
            Bestelnummer: ".$order_id." </br>
          ";
        ?>
      </p>
    </div>
    <?php
      echo "
        <h3>Uw bestelling van ".$order_info['date']."</h3>
      ";
    ?>
    <table>
      <thead>
        <tr>
          <th class="factuurLinks">Artikel</th>
          <th class="factuurRechts">Aantal</th>
          <th class="factuurRechts">Artikelnummer</th>
          <th class="factuurRechts">Prijs incl. BTW</th>
        </tr>
      </thead>
      <tbody>
        <?php
          /* Gets the products of the order from ./stools/orderTools.php */
          $order_products = getOrderProducts($order_id);

          foreach($order_products as $order_product) {
            /* Gets the product information of a product from ./stools/cartTools.php */
            $order_product_info = getProductAll($order_product['product_id']);
            $order_product_amount = getOrderProductAmount($order_product['product_id'], $order_id);
            /* Calculates price with BTW from ./stools/cartTools.php */
            $price = calculatePrice($order_product_amount['price']);
            echo "
              <tr>
                <td class='factuurLinks' data-label='Artikel'><a href=product.php?product_id=".$order_product_info['product_id'].">".$order_product_info['name']."</a></td>
                <td class='factuurRechts' data-label='Aantal'>".$order_product_amount['amount']."</td>
                <td class='factuurRechts' data-label='Artikelnummer'>".$order_product_info['serial_number']."</td>
                <td class='factuurRechts' data-label='Prijs incl. BTW'>&euro;".$price['price_eur'].",".$price['price_cent']."</td>
              </tr>
            ";
          }
        ?>
      </tbody>
    </table>
    <div class="factuurTotaalBedrag">
      <?php
        /* Calculates price with BTW from ./stools/cartTools.php */
        $total_price = calculatePrice($order_info['price']);
        echo "
            <p>Totaal bedrag: &euro; ".$total_price['price_eur'].",".$total_price['price_cent']."</p>";
      ?>
    </div>
  </div>
  </body>
</html>

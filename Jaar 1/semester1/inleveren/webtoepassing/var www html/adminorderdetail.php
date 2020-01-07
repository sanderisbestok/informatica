<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         adminorderdetail.php
Description;  Information about an order
Usage;        Change the status and have a look at the information
-->

<?php include('./globalUI/globalConnect.php'); ?>
<?php include('./stools/orderTools.php'); ?>
<?php
  /* Checks if the user is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
    die();
  }
  /* Checks if the user has the required privilege level */
  $sqlpriv = "SELECT privilege_level FROM users WHERE user_id = '$_SESSION[user_id]'";
  $querypriv = $globalDB->prepare($sqlpriv);
  $querypriv->execute();
  $priv = $querypriv->fetch();
  $privlevel = $priv[0];
  if(intval($privlevel) < 4){
    header("Location: index.php");
    die();
  } else if (empty($_GET["order_id"])) {
    header("Location:".$_SESSION["last_visited"]);
    die();
  } else {
    $order_id = $_GET["order_id"];
  }
  $order_info = getOrder($order_id);
  /* If order doesn't exist, redirect to adminorders */
  if(empty($order_info)) {
    header("Location: adminorders.php");
  }
  /* Changes order status */
  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["state"])) {
    changeOrderStatusSelect($order_id, $_POST["state"]);
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
          /* Retrieves information about the order */
          $order_info = getOrder($order_id);
          $user = getShortUser($order_info["user_id"]);

          echo ("
            <h1>Bestelnummer ".$order_id." van ".$order_info['date']." door <a href='admingegevens.php?user_id=".$order_info["user_id"]."'>".$user["title"]." ".$user["initials"]." ".$user["prefix"]." ".$user["surname"]."</a></h1>
            <h2>Status</h2>
            <form action=".htmlspecialchars($_SERVER['PHP_SELF'])."?order_id=".$order_id." method='POST''>
              <select name='state' class='standardInput select'>");
              foreach($orderStates as $value=>$name) {
                echo("<option value='$value'");
                if($order_info["raw_state"] == $value) {
                  echo(" selected='selected'");
                }
                echo(">$name</option>");
              }

          echo "   </select>
              <input type='submit' class='green' value='Bevestig' />
            </form>
          ";
        ?>
        <h2>Adres</h2>
        <div class="row">
          <div class="c-12">
            <table class="c-12">
              <thead>
                <tr>
                  <th>Woonplaats</th>
                  <th>Postcode</th>
                  <th>Straat</th>
                  <th>Nummer</th>
                  <th>Toevoeging</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  /* Retrieves address where the order was delivered */
                  $address = getAddress($order_id);
                  $city = $address["city"];
                  $postcode = $address["postcode"];
                  $street = $address["street"];
                  $number = $address["number"];
                  if(!empty($address["addition"])){
                    $addition = $address["addition"];
                  } else {
                    $addition = "nvt";
                  }
                  echo "
                    <tr>
                      <td data-label='Woonplaats'>$city</td>
                      <td data-label='Postcode'>$postcode</td>
                      <td data-label='Straat'>$street</td>
                      <td data-label='Nummer'>$number</td>
                      <td data-label='Toevoeging'>$addition</td>
                    </tr>
                  ";
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <h2>Artikelen</h2>
        <div class="row">
          <div class="c-12">
            <table class="c-12">
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
                  /* Retrieves information about the products that were ordered */
                  $order_products = getOrderProducts($order_id);

                  foreach($order_products as $order_product) {
                    $order_product_info = getProductAll($order_product['product_id']);
                    $order_product_amount = getOrderProductAmount($order_product['product_id'], $order_id);
                    $price = calculatePrice($order_product_amount['price']);
                    echo "
                      <tr>
                        <td data-label='Artikel'><a href=product.php?product_id=".$order_product_info['product_id'].">".$order_product_info['name']."</a></td>
                        <td data-label='Aantal'>".$order_product_amount['amount']."</td>
                        <td data-label='Artielnummer'>".$order_product_info['serial_number']."</td>
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
          $total_price = calculatePrice($order_info['price']);
          /* Link to go to the pdf version of the order */
          echo "
              <p>Totaal bedrag: <span class='order-details-price'>&euro;".$total_price['price_eur'].",".$total_price['price_cent']."</span></p>
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

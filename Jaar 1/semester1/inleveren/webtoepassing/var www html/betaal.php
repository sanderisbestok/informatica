<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         bestelgegevens.php
Description;  Look at your orderinformation
Usage;        Go to the next page or choose deliveryaddress
-->

<?php include('./globalUI/globalConnect.php'); ?>
<?php include('./stools/cartTools.php'); ?>
<?php include('./factuurTools/maakFactuur.php'); ?>
<?php
  /* Checks if the user is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
    die();
  }
?>
<?php
  /* Checks if the last visited page is correct and checks if the address is filled in */
  if (($_SESSION['last_visited'] != 'afrekenen.php' &&
      $_SESSION['last_visited'] != 'betaal.php') ||
      !isset($_SESSION['city']) ||
      !isset($_SESSION['zip']) ||
      !isset($_SESSION['street']) ||
      !isset($_SESSION['address'])
      ) {
        header("Location: winkelwagen.php");
        die();
      }
 ?>
 <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $curuser_id = $_SESSION["user_id"];
    $cart = $_SESSION["cart"];

    /* Adds the order address to the database */
    $sqlid = "SELECT address_id FROM users WHERE user_id = '$curuser_id'";
    $queryid = $globalDB->prepare($sqlid);
    $queryid->execute();
    $addressid = $queryid->fetch();
    $addressvalue = $addressid[0];
    $addresssql = "INSERT INTO addresses (street, number, addition, postcode, city)
                VALUES (:street, :address, :affix, :zip, :city)";
    $addressquery = $globalDB->prepare($addresssql);
    $addressquery->execute(array(
      ':street' => $_SESSION['street'],
      ':address' => $_SESSION['address'],
      ':affix' => $_SESSION['affix'],
      ':zip' => $_SESSION['zip'],
      ':city' => $_SESSION['city']
    ));

    /* Adds the order to the database */
    $ordersql = "INSERT INTO orders (tax_rate, date, user_id, address_id, state)
                VALUES ('21', (NOW()), '$curuser_id', (SELECT address_id FROM addresses WHERE address_id = LAST_INSERT_ID()), 'prep')";
    $orderquery = $globalDB->prepare($ordersql);
    $orderquery->execute(array());

    $order_idsql = "SELECT order_id
                      FROM orders
                    WHERE order_id = LAST_INSERT_ID()";
    $order_idquery = $globalDB->prepare($order_idsql);
    $order_idquery->execute();
    $order_id_factuur = $order_idquery->fetch(PDO::FETCH_ASSOC);

    /* Adds each ordered item to the database */
    foreach($cart as $item){
      $pricesql = "SELECT price_id FROM prices WHERE product_id = '$item[id]'";
      $pricequery = $globalDB->prepare($pricesql);
      $pricequery->execute();
      $price = $pricequery->fetch();
      $pricevalue = $price[0];
      $productordersql = "INSERT INTO products_orders (product_id, order_id, price_id, amount)
              VALUES (:productid, (SELECT order_id FROM orders WHERE order_id = LAST_INSERT_ID()), :price, :amount)";
      $productorderquery = $globalDB->prepare($productordersql);
      $productorderquery->execute(array(
        ':productid' => $item['id'],
        ':price' => $pricevalue,
        ':amount' => $item['amount']
      ));

      /* Changes the supply from the ordered product */
      $sqlsupply = "SELECT supply FROM products WHERE product_id = '$item[id]'";
      $querysupply = $globalDB->prepare($sqlsupply);
      $querysupply->execute();
      $supply = $querysupply->fetch();
      $supplyvalue = $supply[0];
      $rem = intval($supplyvalue) - intval($item['amount']);
      if ($rem < 0) {
        $sqlproduct = "UPDATE products SET supply = :supply
                        WHERE product_id='$item[id]' LIMIT 1";
        $queryproduct = $globalDB->prepare($sqlproduct);
        $queryproduct->execute(array(
          ':supply' => 0
        ));
      } else {
        $sqlproduct = "UPDATE products SET supply = :supply
                        WHERE product_id='$item[id]' LIMIT 1";
        $queryproduct = $globalDB->prepare($sqlproduct);
        $queryproduct->execute(array(
          ':supply' => $rem
        ));
      }
    }

    /* Does a request to make version of the order which can be turned into a pdf */
    maakFactuur($order_id_factuur['order_id']);
    unset($_SESSION['cart']);
    header("Location: orderhistorie.php");
    die();
  }
  ?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Betalen</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/buttons.css" />
    <link rel="stylesheet" href="style/payment.css" />
  </head>

  <body>
    <?php
      include ('./globalUI/header.php');
    ?>

    <div class="container">
      <div class="content">
        <h1>Betalen</h1>
        <!-- Buttons to cancel order and to order -->
        <table>
          <tr>
            <td><a class="cancelorder" href="winkelwagen.php">Transactie afbreken</a></td>
            <td>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="submit" class="order" value="Betaal" />
              </form>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

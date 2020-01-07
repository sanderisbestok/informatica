<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         winkelwagen.php
Description;  View you cart and edit the number of products in it and go to the payment process
Usage;        Check your cart, choose to collect or to deliver and start the payment process
-->

<?php include('./globalUI/globalConnect.php') ?>
<?php include_once("./stools/cartTools.php") ?>
<?php
  /* Redirects to bestelgegevens and puts the collect session id to false */
  function redirectdel() {
    $_SESSION['collect'] = FALSE;
    header("Location: bestelgegevens.php");
    die();
  }

  /* Redirects to bestelgegevens and puts the addres session id's to Science Park's address */
  function redirectcol() {
    $_SESSION['city'] = "Amsterdam";
    $_SESSION['zip'] = "1098XH";
    $_SESSION['street'] = "Science Park";
    $_SESSION['address'] = "904";
    $_SESSION['affix'] = "";
    $_SESSION['collect'] = TRUE;
    header("Location: bestelgegevens.php");
    die();
  }

  /* Santizes the input */
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $order = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Tests if the cart is not empty */
    if (count($_SESSION["cart"]) > 0) {
      if (!empty($_POST["order"])) {
        $order = test_input($_POST["order"]);
        if ($order == "deliver") {
          redirectdel();
        } else {
          redirectcol();
        }
      }
    }
  }
 ?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Winkelmandje</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/cart.css" />
    <link rel="stylesheet" href="style/buttons.css" />
    <script src="./scripts/cart.js"></script>
  </head>

  <body>

    <?php include('./globalUI/header.php'); ?>

    <div class="container">
      <div class="content">
        <h1>Winkelwagen</h1>
        <div id="cart">
          <div class="row">
            <div class="shoppingcart c-12">
              <table class="orderedproducts">
                <h2>Uw producten</h2>
                <span class="continueshopping"><a href="index.php" class="pagelink">Verder winkelen</a></span>
                <?php
                  /* Adds all the products in the cart to the table */
                  if(isset($_SESSION["cart"]) && (count($_SESSION["cart"]) > 0)) {
                    foreach(getCart($_SESSION["cart"]) as $item){
                      print('<tr class="cartUpdatable product" id="item'.$item["product_id"].'">');
                      generateCartItem($item);
                      print('</tr>');
                    }
                  } else {
                    print('Winkelwagen bevat geen artikelen');
                  }
                 ?>
              </table>
            </div>
          </div>
          <div id="cartFooter">
            <?php
              /* Tests if the cart is not empty */
              if(!$cart_empty){
                generateCartFooter();
              }
             ?>
          </div>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

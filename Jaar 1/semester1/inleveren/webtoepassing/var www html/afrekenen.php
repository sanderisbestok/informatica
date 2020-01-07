<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         afrekenen.php
Description;  Look at your orderinformation and go to the payment page
Usage;        Go to the next page to pay
-->

<?php include('./globalUI/globalConnect.php') ?>
<?php
  /* Checks if the user is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
    die();
  }
?>
<?php
  /* Checks if the last page is correct and all addressinformation is filled in */
  if (($_SESSION['last_visited'] != 'wijzigadres.php' &&
      $_SESSION['last_visited'] != 'afrekenen.php' &&
      $_SESSION['last_visited'] != 'bestelgegevens.php') ||
      !isset($_SESSION['city']) ||
      !isset($_SESSION['zip']) ||
      !isset($_SESSION['street']) ||
      !isset($_SESSION['address'])
      ) {
        header("Location: winkelwagen.php");
        die();
      }
 ?>
<!-- Retrieves the information about the user and order -->
<?php
  $curuser_id = $_SESSION["user_id"];
  $stmt = $globalDB->prepare("SELECT sex FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $sex = $stmt->fetch(PDO::FETCH_NUM);
  if ($sex[0] == "male") {
    $sexvalue = "Dhr. ";
  } else {
    $sexvalue = "Mevr. ";
  }

  $stmt = $globalDB->prepare("SELECT first_name FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $firstname = $stmt->fetch(PDO::FETCH_NUM);
  $firstnamevalue = $firstname[0];

  $stmt = $globalDB->prepare("SELECT prefix FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $prefix = $stmt->fetch(PDO::FETCH_NUM);
  $prefixvalue = $prefix[0];

  $stmt = $globalDB->prepare("SELECT surname FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $surname = $stmt->fetch(PDO::FETCH_NUM);
  $surnamevalue = $surname[0];

  $stmt = $globalDB->prepare("SELECT city FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $city = $stmt->fetch(PDO::FETCH_NUM);
  $cityvalue = $city[0];

  $stmt = $globalDB->prepare("SELECT postcode FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $zip = $stmt->fetch(PDO::FETCH_NUM);
  $zipvalue = $zip[0];

  $stmt = $globalDB->prepare("SELECT street FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $street = $stmt->fetch(PDO::FETCH_NUM);
  $streetvalue = $street[0];

  $stmt = $globalDB->prepare("SELECT number FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $address = $stmt->fetch(PDO::FETCH_NUM);
  $addressvalue = $address[0];

  $stmt = $globalDB->prepare("SELECT addition FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $affix = $stmt->fetch(PDO::FETCH_NUM);
  $affixvalue = $affix[0];

  if (empty($prefixvalue)){
    $deliveryname = "" . $sexvalue . $firstnamevalue . " " . $surnamevalue;
  } else {
    $deliveryname = "" . $sexvalue . $firstnamevalue . " " . $prefixvalue . " " . $surnamevalue;
  }
  $deliveryaddress = "" . $_SESSION['street'] . " " . $_SESSION['address'] . " " . $_SESSION['affix'];
  $deliveryzip = "" . $_SESSION['zip'] . " " . $_SESSION['city'] ;
  if (empty($prefixvalue)){
    $billname = "" . $sexvalue . $firstnamevalue . " " . $surnamevalue;
  } else {
    $billname = "" . $sexvalue . $firstnamevalue . " " . $prefixvalue . " " . $surnamevalue;
  }
  $billaddress = "" . $streetvalue . " " . $addressvalue . " " . $affixvalue;
  $billzip = "" . $zipvalue . " " . $cityvalue;

 ?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Afrekenen</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/buttons.css" />
    <link rel="stylesheet" href="style/payment.css" />
    <link rel="stylesheet" href="style/cart.css" />
  </head>

  <body>
    <?php
      include ('./globalUI/header.php');
    ?>

    <div class="container">
      <div class="content">
        <h1>Afrekenen</h1>
        <div class="addressrow">
          <div class="row">
            <div class="deliveryaddress c-6">
              <h2>Bezorgadres</h2>
              <!-- Retrieves order address -->
              <ul class="addresses" style="list-style-type: none;">
                <li><?php echo $deliveryname; ?></li>
                <li><?php echo $deliveryaddress; ?></li>
                <li><?php echo $deliveryzip; ?></li>
                <!-- Not displayed when the user chooses to collect it -->
                <li><a class="pagelink" href="wijzigadres.php" <?php echo ($_SESSION['collect']=='TRUE')?'hidden':'' ?>>Wijzig</a></li>
              </ul>
            </div>
            <div class="billingaddress c-6">
              <h2>Factuuradres</h2>
              <!-- Retrieves billing address -->
              <ul style="list-style-type: none;" class="addresses">
                <li><?php echo $billname; ?></li>
                <li><?php echo $billaddress; ?></li>
                <li><?php echo $billzip; ?></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="orderedproducts c-12">
            <table>
              <h2>Uw producten</h2>
              <?php
                $i = 0;
                /* Sets all products into a table */
                foreach($cart as $item){
                  $i++;
                  $price = calculatePrice($item['price'] * $item["amount"]);
                  print('
                    <tr class="product" id="product'.$i.'">
                      <td class="imgcol"><img src="'.$item["path"].'" alt="'.$item["alt"].'"></td>
                      <td class="namecol">'.$item["name"].'</td>
                      <td class="numbercol">'.$item["amount"].'</td>
                      <td class="pricecol">&euro;'.$price["price_eur"].','.$price["price_cent"].'</td>
                    </tr>
                  ');
                }
                $supplyErr = "display: none;";
                /* Checks if one of the items ordered more than we have in the store */
                foreach($cart as $item) {
                  $stmt = $globalDB->prepare("SELECT supply FROM products WHERE name = '$item[name]'");
                  $stmt->execute();
                  $supplyin = $stmt->fetch(PDO::FETCH_NUM);
                  $supply = $supplyin[0];
                  if ($item["amount"] > $supply) {
                    $supplyErr = "";
                  }
                }
                print('
                <tr>
                  <td colspan="4"><span class="supplyErr" style="'.$supplyErr.'">Sommige producten zijn niet op voorraad</span></td>
                </tr>
                ');
               ?>
            </table>
          </div>
        </div>
        <table>
          <tr>
            <!-- Buttons to switch between pages -->
            <td><a class="cancelorder inline" href="winkelwagen.php">Bestelling annuleren</a></td>
            <td><a class="order inline" href="betaal.php">Door naar betalen</a></td>
          </tr>
        </table>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

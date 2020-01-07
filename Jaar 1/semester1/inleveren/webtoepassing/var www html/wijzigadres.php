<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         wijzigadres.php
Description;  Edit the address of the user
Usage;        Fill the input fields with the requested data and press the submit button
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
  /* Checks if the last visited page is correct */
  if (($_SESSION['last_visited'] != 'wijzigadres.php' &&
      $_SESSION['last_visited'] != 'bestelgegevens.php' &&
      $_SESSION['last_visited'] != 'afrekenen.php') ||
      $_SESSION['collect'] == TRUE
      ) {
        header("Location: winkelwagen.php");
        die();
      }
 ?>
<?php
  /* Sets the php variables */
  $city = $zip = $street = $address = $affix = "";
  $cityErr = $zipErr = $streetErr = $addressErr = $affixErr = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cityErr = $zipErr = $streetErr = $addressErr = $affixErr = false;
    $allcorrect = True;

    /* Checks if the cityname is valid */
    if (empty($_POST["city"])) {
      $allcorrect = False;
      $cityErr = true;
    } else {
      $city = test_input($_POST["city"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$city)) {
        $allcorrect = False;
        $cityErr = true;
      }
    }

    /* Checks if the zip is valid */
    if (empty($_POST["zip"])) {
      $allcorrect = False;
      $zipErr = true;
    } else {
      $zip = test_input($_POST["zip"]);
      if (!preg_match("/^[1-9][0-9]{3}[\s]?[a-zA-Z]{2}$/i", $zip)) {
        $allcorrect = False;
        $zipErr = true;
      }
    }

    /* Checks if the streetname is valid */
    if (empty($_POST["street"])) {
      $allcorrect = False;
      $streetErr = true;
    } else {
      $street = test_input($_POST["street"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$street)) {
        $allcorrect = False;
        $streetErr = true;
      }
    }

    /* Checks if the housenumber is valid */
    if (empty($_POST["address"])) {
      $allcorrect = False;
      $addressErr = true;
    } else {
      $address = test_input($_POST["address"]);
      if (!preg_match("/^[0-9]*$/", $address)) {
        $allcorrect = False;
        $addressErr = true;
      }
    }

    /* Checks if the affix is valid */
    if (empty($_POST["affix"])) {
      $affix = "";
    } else {
      $affix = test_input($_POST["affix"]);
    }

    if($allcorrect) {
      /* Puts the address into session variables */
      $_SESSION['city'] = $city;
      $_SESSION['zip'] = $zip;
      $_SESSION['street'] = $street;
      $_SESSION['address'] = $address;
      $_SESSION['affix'] = $affix;
      redirect();
    }
  }

  /* Santizes the input */
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /* Redirects the user when the address is put into the session variables */
  function redirect() {
    header("Location: afrekenen.php");
    die();
  }
 ?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Wijzig afleveradres</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/buttons.css" />
    <link rel="stylesheet" href="style/payment.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>

  <!-- Sets the javascript errors -->
  <body onload="seterrorsaddress()">
    <?php
      include ('./globalUI/header.php');
    ?>
    <div class="container">
      <div class="content">
        <h1>Afleveradres</h1>
        <form class="changeaddress" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <ul style="list-style-type: none;">
            <li><label for="city">Woonplaats*</label></li>
            <!-- Input field for the city -->
            <li><input type="text" name="city" class="standardInput" id="city" size="13" value="<?php echo $city; ?>" onkeyup="cityValid()" onclick="cityValid()" onchange="cityValid()"/></li>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <li class="errorstyle" style="display: none;" id="cityErr">Ongeldige woonplaats</li>
            <li class="errorstyle" style="<?php if($cityErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige woonplaats</li>

            <li><label for="zip">Postcode*</label></li>
            <!-- Input field for the zip -->
            <li><input type="text" name="zip" class="standardInput" id="zip" placeholder="1234 AB" maxlength="7" size="13" value="<?php echo $zip; ?>" onkeyup="zipValid()" onclick="zipValid()" onchange="zipValid()"/></li>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <li class="errorstyle" style="display: none;" id="zipErr">Ongeldige postcode</li>
            <li class="errorstyle" style="<?php if($zipErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige postcode</li>

            <li><label for="city">Straat*</label></li>
            <!-- Input field for the streetname -->
            <li><input type="text" name="street" class="standardInput" id="street" size="13" value="<?php echo $street; ?>" onkeyup="streetValid()" onclick="streetValid()" onchange="streetValid()"/></li>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <li class="errorstyle" style="display: none;" id="streetErr">Ongeldige straatnaam</li>
            <li class="errorstyle" style="<?php if($streetErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige straatnaam</li>
            <table>
              <tr>
                <td>Huisnummer*</td>
                <td>Toevoeging</td>
              </tr>
              <tr>
                <!-- Input fields for the housenumber and the affix -->
                <td><input type="text" name="address" class="standardInput" id="address" size="13" value="<?php echo $address; ?>" onkeyup="addressValid()" onclick="addressValid()" onchange="addressValid()"/></td>
                <td><input type="text" name="affix" class="standardInput" id="affix" size="13" maxlength="8" value="<?php echo $affix; ?>" onkeyup="affixValid()" onclick="affixValid()" onchange="affixValid()"/></td>
              </tr>
            </table>
            <!-- Rows with possible errors (Javascript and PHP) for the input fields -->
            <li class="errorstyle" style="display: none;" id="addressErr">Ongeldig huisnummer</li>
            <li class="errorstyle" style="display: none;" id="affixErr">Ongeldige toevoeging</li>
            <li class="errorstyle" style="<?php if($addressErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig huisnummer</li>
            <li class="errorstyle" style="<?php if($affixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige toevoeging</li>
            <table>
              <tr>
                <!-- Buttons to ga back or futher in the payment process -->
                <td><a class="tocart" href="winkelwagen.php">Betaling annuleren</a></td>
                <td><input type="submit" value="Afrekenen" id="register" class="order" onclick="editaddressvalidator()"></td>
              </tr>
            </table>
            </ul>
        </form>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

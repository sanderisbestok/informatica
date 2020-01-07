<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         bestelgegevens.php
Description;  Look at your orderinformation
Usage;        Go to the next page or choose deliveryaddress
-->

<?php include('./globalUI/globalConnect.php'); ?>
<?php
  /* Checks if the user is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php?redirect=$_SERVER[PHP_SELF]");
    die();
  }
?>
<?php
  /* Checks if the last visited page is correct */
  if (($_SESSION['last_visited'] != 'winkelwagen.php' &&
      $_SESSION['last_visited'] != 'bestelgegevens.php') ||
      !isset($_SESSION['collect'])
      ) {
        header("Location: winkelwagen.php");
        die();
      }
 ?>
 <?php
  /* Gets the information about the user */
   $curuser_id = $_SESSION["user_id"];
   $stmt = $globalDB->prepare("SELECT sex FROM users WHERE user_id = '$curuser_id'");
   $stmt->execute();
   $sex = $stmt->fetch(PDO::FETCH_NUM);
   if ($sex[0] == "male") {
     $sexvalue = "Man";
   } else {
     $sexvalue = "Vrouw";
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

   $stmt = $globalDB->prepare("SELECT date_birth FROM users WHERE user_id = '$curuser_id'");
   $stmt->execute();
   $birthday = $stmt->fetch(PDO::FETCH_NUM);
   $dateparts = explode('-', $birthday[0]);
   $birthdayvalue = "" . $dateparts[2] . "-" . $dateparts[1] . "-" . $dateparts[0];

   $stmt = $globalDB->prepare("SELECT phone FROM users WHERE user_id = '$curuser_id'");
   $stmt->execute();
   $tel = $stmt->fetch(PDO::FETCH_NUM);
   $telvalue = $tel[0];

   $stmt = $globalDB->prepare("SELECT email FROM users WHERE user_id = '$curuser_id'");
   $stmt->execute();
   $email = $stmt->fetch(PDO::FETCH_NUM);
   $emailvalue = $email[0];
  ?>
<?php
  /* Sets address */
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['city'] = $cityvalue;
    $_SESSION['zip'] = $zipvalue;
    $_SESSION['street'] = $streetvalue;
    $_SESSION['address'] = $addressvalue;
    $_SESSION['affix'] = $affixvalue;
    header("Location: afrekenen.php");
    die();
  }

 ?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Gegevens</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/buttons.css" />
    <link rel="stylesheet" href="style/payment.css" />
    <link rel="stylesheet" href="style/userdata.css" />
  </head>

  <body>
    <?php
      include ('./globalUI/header.php');
    ?>

    <div class="container">
      <div class="content">
        <h1>Persoonlijke gegevens</h1>
        <!-- Displays userdetails -->
        <h3>Persoonsgegevens</h3>
        <table>
          <tr>
            <td class="dataname">Naam:</td>
            <td class="data"><?php echo $firstnamevalue ?> <?php echo $prefixvalue ?> <?php echo $surnamevalue ?></td>
          </tr>
          <tr>
            <td class="dataname">Geslacht</td>
            <td class="data"><?php echo $sexvalue ?></td>
          </tr>
          <tr>
            <td class="dataname">Geboortedatum:</td>
            <td class="data"><?php echo $birthdayvalue ?></td>
          </tr>
        </table>
        <h3>Locatiegegevens</h3>
        <table>
          <tr>
            <td class="dataname">Woonplaats:</td>
            <td class="data"><?php echo $cityvalue ?></td>
          </tr>
          <tr>
            <td class="dataname">Postcode:</td>
            <td class="data"><?php echo $zipvalue ?></td>
          </tr>
          <tr>
            <td class="dataname">Straatnaam:</td>
            <td class="data"><?php echo $streetvalue ?></td>
          </tr>
          <tr>
            <td class="dataname">Huisnummer:</td>
            <td class="data"><?php echo $addressvalue ?> <?php echo $affixvalue ?></td>
          </tr>
        </table>
        <h3>Contactgegevens</h3>
        <table>
          <tr>
            <td class="dataname">E-mailadres:</td>
            <td class="data"><?php echo $emailvalue ?></td>
          </tr>
          <tr>
            <td class="dataname">Telefoonnummer:</td>
            <td class="data"><?php echo $telvalue ?></td>
          </tr>
        </table>
        <!-- Checks which buttons should be displayed -->
        <table>
          <tr <?php echo ($_SESSION['collect']==TRUE)?'hidden':'' ?>>
            <td><a class="change inline" href="wijzigadres.php">Wijzig afleveradres</a></td>
          </tr>
          <tr <?php echo ($_SESSION['collect']==TRUE)?'hidden':'' ?>>
            <td>
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <button type="sumbit" class="savechanges move2 inline" href="afrekenen.php">Thuis afleveren</button>
              </form>
            </td>
          </tr>
          <tr <?php echo ($_SESSION['collect']==FALSE)?'hidden':'' ?>>
            <td><a class="continue move3 inline" href="afrekenen.php">Doorgaan</a></td>
          </tr>
          <tr>
            <td><a class="tocart inline" href="winkelwagen.php">Betaling annuleren</a></td>
          </tr>
        </table>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

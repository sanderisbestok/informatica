<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         gebruiker.php
Description;  Page shown when a user wants to see his data.
Usage; n/a
-->

<!-- Make connection with database. -->
<?php include('./globalUI/globalConnect.php') ?>
<!-- If the user is not logged in, he/she will be redirected to login page. -->
<?php
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
  }
?>
<!-- Begin html-page. -->
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Gebruiker gegevens</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/userdata.css" />
  </head>

  <body>
    <?php
      include('./globalUI/header.php');
    ?>
    <div class="container">
      <div class="content">
        <div class="row">
          <div class="userdata c-12">
            <!-- Gather data of user from database. -->
            <?php
              $curuser_id = $_SESSION["user_id"];
              $stmt = $globalDB->prepare("SELECT sex FROM users WHERE user_id = '$curuser_id'");
              $stmt->execute();
              $sex = $stmt->fetch(PDO::FETCH_NUM);
              #Because sex is of a different type in the database, a test must be done,
              #Next the result of the test will be converted into usefull text.
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
            <h1>Persoonlijke gegevens</h1>
            <!-- All data is revealed, ordered by type of information.-->
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
            <table>
                <!-- Buttons to change page. -->
                <tr>
                  <td><a class="editpersonaldata inline" href="wijziggegevens.php">Wijzig gegevens</a></td>
                </tr>
                <tr>
                  <td><a href="wijzigwachtwoord.php" class="editpersonaldata move inline">Wijzig wachtwoord</a></td>
                </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php
      include('./globalUI/footer.php');
    ?>
  </body>
</html>

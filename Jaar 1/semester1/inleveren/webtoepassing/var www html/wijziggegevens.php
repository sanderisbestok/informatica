<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         wijziggegevens.php
Description;  Page is used to edit data of a user.
Usage; n/a
-->

<!-- Makes connection with the database. -->
<?php include('./globalUI/globalConnect.php') ?>
<!-- Test if the user is logged on. -->
<?php
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
  }
?>
<!-- Gets all necessary user data from database. -->
<?php
  $curuser_id = $_SESSION["user_id"];
  $stmt = $globalDB->prepare("SELECT sex FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $sexin = $stmt->fetch(PDO::FETCH_NUM);
  $sex = $sexin[0];

  $stmt = $globalDB->prepare("SELECT first_name FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $firstnamein = $stmt->fetch(PDO::FETCH_NUM);
  $firstname = $firstnamein[0];

  $stmt = $globalDB->prepare("SELECT prefix FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $prefixin = $stmt->fetch(PDO::FETCH_NUM);
  $prefix = $prefixin[0];

  $stmt = $globalDB->prepare("SELECT surname FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $surnamein = $stmt->fetch(PDO::FETCH_NUM);
  $surname = $surnamein[0];

  $stmt = $globalDB->prepare("SELECT city FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $cityin = $stmt->fetch(PDO::FETCH_NUM);
  $city = $cityin[0];

  $stmt = $globalDB->prepare("SELECT postcode FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $zipin = $stmt->fetch(PDO::FETCH_NUM);
  $zip = $zipin[0];

  $stmt = $globalDB->prepare("SELECT street FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $streetin = $stmt->fetch(PDO::FETCH_NUM);
  $street = $streetin[0];

  $stmt = $globalDB->prepare("SELECT number FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $addressin = $stmt->fetch(PDO::FETCH_NUM);
  $address = $addressin[0];

  $stmt = $globalDB->prepare("SELECT addition FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $affixin = $stmt->fetch(PDO::FETCH_NUM);
  $affix = $affixin[0];

  $stmt = $globalDB->prepare("SELECT date_birth FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $birthdayin = $stmt->fetch(PDO::FETCH_NUM);
  $parts = explode('-', $birthdayin[0]);
  $birthday = "" . $parts[2] . "-" . $parts[1] . "-" . $parts[0];

  $stmt = $globalDB->prepare("SELECT phone FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $telin = $stmt->fetch(PDO::FETCH_NUM);
  $tel = $telin[0];

  $stmt = $globalDB->prepare("SELECT email FROM users WHERE user_id = '$curuser_id'");
  $stmt->execute();
  $emailin = $stmt->fetch(PDO::FETCH_NUM);
  $email = $emailin[0];
?>
<!-- Function to make the userinput usefull. -->
<!-- Functie om de gebruiker terug te sturen naar gebruiker.php. -->
<?php
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  #Function to redirect user to gebruiker.php.
  function redirect() {
    header("Location: gebruiker.php");
    die();
  }
?>
<?php
#Necessary variables are created.
 $emailErr = "";
 $firstnameErr = $prefixErr = $surnameErr = $cityErr = $zipErr = false;
 $streetErr = $addressErr = $affixErr = $birthdayErr = $telErr = false;
 $mailErr = $levelErr = false;
 #Function that is used when the submit button is pressed.
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $firstnameErr = $prefixErr = $surnameErr = $cityErr = $zipErr = false;
   $streetErr = $addressErr = $affixErr = $birthdayErr = $telErr = false;
   $mailErr = $levelErr = false;
   $allcorrect = True;
   #Test if the sex in filled.
   if (empty($_POST["sex"])) {
     $allcorrect = False;
   } else {
     $sex = test_input($_POST["sex"]);
   }
   #Test if the firstname is of wanted format.
   if (empty($_POST["firstname"])) {
     $allcorrect = False;
   } else {
     $firstname = test_input($_POST["firstname"]);
     if (!preg_match("/^([^0-9]*)$/", $firstname) || strlen($firstname) < 2) {
       $allcorrect = False;
       $firstnameErr = true;
     }
   }
   #Test if the prefix is of wanted format.
   if (empty($_POST["prefix"])) {
     $prefix = test_input($_POST["prefix"]);
   } else {
     $prefix = test_input($_POST["prefix"]);
     if (!preg_match("/^([^0-9]*)$/", $prefix) && strlen($prefix) > 0) {
       $allcorrect = False;
       $prefixErr = true;
     }
   }
   #Test if the surname is of wanted format.
   if (empty($_POST["surname"])) {
     $allcorrect = False;
     $surnameErr = true;
   } else {
     $surname = test_input($_POST["surname"]);
     if (!preg_match("/^([^0-9]*)$/", $surname) || strlen($surname) < 2) {
       $allcorrect = False;
       $surnameErr = true;
     }
   }
   #Test if the city is of wanted format.
   if (empty($_POST["city"])) {
     $allcorrect = False;
     $cityErr = true;
   } else {
     $city = test_input($_POST["city"]);
     if (!preg_match("/^([^0-9]*)$/", $city) || strlen($city) < 2) {
       $allcorrect = False;
       $cityErr = true;
     }
   }
   #Test if the zipcode is of wanted format.
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
   #Test if the streetname is of wanted format.
   if (empty($_POST["street"])) {
     $allcorrect = False;
     $streetErr = true;
   } else {
     $street = test_input($_POST["street"]);
     if (!preg_match("/^([^0-9]*)$/", $street) || strlen($street) < 2) {
       $allcorrect = False;
       $streetErr = true;
     }
   }
   #Test if the address is of wanted format.
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
   #Test if the affix is of wanted format.
   if (!empty($_POST["affix"])) {
     $affix = test_input($_POST["affix"]);
   } else {
      $affix = "";
   }
   #Test if the birthday is of wanted format.
   if (empty($_POST["birthday"])) {
     $allcorrect = False;
     $birthdayErr = true;
   } else {
     $birthday = test_input($_POST["birthday"]);
     $test_arr = explode('-', $birthday);
     if (count($test_arr) == 3){
       if (!checkdate($test_arr[1], $test_arr[0], $test_arr[2])) {
         $allcorrect = False;
         $birthdayErr = true;
       } else {
         $birthdaychecked = "" . $test_arr[2] . "-" . $test_arr[1] . "-" . $test_arr[0];
       }
     } else {
       $allcorrect = False;
       $birthdayErr = true;
     }
   }
   #Test if the phone number is of wanted format.
   if (empty($_POST["tel"])) {
     $allcorrect = False;
     $telErr = true;
   } else {
     $tel = test_input($_POST["tel"]);
     if (!preg_match("/^(((0)[1-9]{2}[0-9][-]?[1-9][0-9]{5})|((\\+31|0|0031)[1-9][0-9][-]?[1-9][0-9]{6}))$/", $tel)
         && !preg_match("/^(((\\+31|0|0031)6){1}[1-9]{1}[0-9]{7})$/i", $tel)) {
       $allcorrect = False;
       $telErr = true;
     }
   }
   #Test if the email address is of wanted format.
   if (empty($_POST["email"])) {
     $allcorrect = False;
     $mailErr = true;
   } else {
     $email = test_input($_POST["email"]);
     if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
       $testemailquery = $globalDB->prepare("SELECT email FROM users WHERE user_id = '$curuser_id'");
       $testemailquery->execute();
       $testemailin = $testemailquery->fetch(PDO::FETCH_NUM);
       $testemail = $testemailin[0];
       $emailquery = $globalDB->prepare('SELECT email FROM users WHERE email = :email');
       $emailquery->execute(array(':email' => $_POST['email']));
       $row = $emailquery->fetch(PDO::FETCH_ASSOC);
       if(!empty($row['email'])){
         if ($_POST["email"] != $testemail) {
           $emailErr = "Dit e-mailadres is al in gebruik";
           $allcorrect = False;
         } else {
           $emailErr = "";
         }
       }
     } else {
       $emailErr = "";
       $allcorrect = False;
       $mailErr = true;
     }
   }
   #If every test above is checked, then the data of the user will be updated in the database.
   if($allcorrect) {
     $sqluser = "UPDATE users SET first_name = :firstname,
                             surname = :surname,
                             prefix = :prefix,
                             date_birth = :birthday,
                             sex = :sex,
                             email = :email,
                             phone = :tel
                             WHERE user_id='$curuser_id' LIMIT 1";
    $queryuser = $globalDB->prepare($sqluser);
    $queryuser->execute(array(
      ':firstname' => $firstname,
      ':surname' => $surname,
      ':prefix' => $prefix,
      ':birthday' => $birthdaychecked,
      ':sex' => $sex,
      ':email' => $email,
      ':tel' => $tel
    ));
    $sqlid = "SELECT address_id FROM users WHERE user_id = '$curuser_id'";
    $queryid = $globalDB->prepare($sqlid);
    $queryid->execute();
    $addressid = $queryid->fetch();
    $sqladdress = "UPDATE addresses SET street = :street,
                                        number = :address,
                                        addition = :affix,
                                        postcode = :zip,
                                        city = :city
                                        WHERE address_id='$addressid[0]' LIMIT 1";
    $queryaddress = $globalDB->prepare($sqladdress);
    $queryaddress->execute(array(
      ':street' => $street,
      ':address' => $address,
      ':affix' => $affix,
      ':zip' => $zip,
      ':city' => $city
    ));
    redirect();
  }
}
?>
<!-- Begin html page. -->
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Wijzig gegevens</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/editdata.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>
  <body onload="seterrorsedit2()">
    <?php include('./globalUI/header.php'); ?>
    <div class="container">
      <div class="content">
        <h1>Wijzig gegevens</h1>
        <form name="addaptdata" class="addaptdataform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <!-- All inputs are made here, ordered by type of information.-->
          <!-- The data that is gathered from the database will be filled in the inputs.-->
          <!-- Under every input there is a errormessage that will appear if the input does not meet the requirements. -->
          <table>
            <tr>
              <td width="60" height="40"><h3>Persoonsgegevens</h3></td>
            </tr>
            <tr>
              <td height="20" class="toplist">Geslacht:</td>
              <td>De heer: <input type="radio" name="sex" value="male" <?php echo ($sex=='male')?'checked':'' ?> required="sex"/>
                Mevrouw: <input type="radio" name="sex" value="female" <?php echo ($sex=='female')?'checked':'' ?> required="sex"/></td>
            </tr>
            <tr>
              <td height="20">Voornaam:</td>
              <td><input type="text" name="firstname" class="standardInput" id="firstname" value="<?php echo $firstname ?>" onkeyup="fnameValid()" onchange="fnameValid()" onclick="fnameValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="firstnameErr">Ongeldige voornaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($firstnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige voornaam</td>
            </tr>
            <tr>
              <td height="20">Tussenvoegsel:</td>
              <td><input type="test" name="prefix" class="standardInput" id="prefix" value="<?php echo $prefix ?>" onkeyup="pfixValid()" onclick="pfixValid()" onchange="pfixValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="prefixErr">Ongeldig tussenvoegsel</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($prefixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig tussenvoegsel</td>
            </tr>
            <tr>
              <td height="20">Achternaam:</td>
              <td><input type="text" name="surname" class="standardInput" id="surname" value="<?php echo $surname ?>" onkeyup="snameValid()" onclick="snameValid()" onchange="snameValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="surnameErr">Ongeldige achternaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($surnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige achternaam</td>
            </tr>
            <tr>
              <td height="20">Geboortedatum:</td>
              <td><input type="text" name="birthday" class="standardInput" id="birthday" placeholder="dd-mm-jjjj" value="<?php echo $birthday ?>" onkeyup="dateValid()" onclick="dateValid()" onchange="dateValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="birthdayErr">Ongeldige geboortedatum</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($birthdayErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige geboortedatum</td>
            </tr>
            <tr>
              <td height="40"><h3>Locatiegegevens</h3></td>
            </tr>
            <tr>
              <td height="20" class="toplist">Woonplaats:</td>
              <td><input type="text" name="city" class="standardInput" id="city" value="<?php echo $city ?>" onkeyup="cityValid()" onclick="cityValid()" onchange="cityValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="cityErr">Ongeldige woonplaats</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($cityErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige woonplaats</td>
            </tr>
            <tr>
              <td height="20">Postcode:</td>
              <td><input type="text" name="zip" class="standardInput" id="zip" placeholder="1234 AB" value="<?php echo $zip ?>" onkeyup="zipValid()" onclick="zipValid()" onchange="zipValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="zipErr">Ongeldige postcode</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($zipErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige postcode</td>
            </tr>
            <tr>
              <td height="20">Straat:</td>
              <td><input type="text" name="street" class="standardInput" id="street" value="<?php echo $street ?>" onkeyup="streetValid()" onclick="streetValid()" onchange="streetValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="streetErr">Ongeldige straatnaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($streetErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige straatnaam</td>
            </tr>
            <tr>
              <td height="20">Huisnummer:</td>
              <td><input type="text" name="address" class="standardInput" id="address" value="<?php echo $address ?>" onkeyup="addressValid()" onclick="addressValid()" onchange="addressValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="addressErr">Ongeldig huisnummer</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($addressErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig huisnummer</td>
            </tr>
            <tr>
              <td height="20">Huisnummer toevoeging:</td>
              <td><input type="text" name="affix" class="standardInput" id="affix" maxlength="8" value="<?php echo $affix ?>" onkeyup="affixValid()" onclick="affixValid()" onchange="affixValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="affixErr">Ongeldige toevoeging</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($affixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige toevoeging</td>
            </tr>
            <tr>
              <td height="40"><h3>Contactgegevens</h3></td>
            </tr>
            <tr>
              <td height="20" class="toplist">E-mailadres:</td>
              <td><input type="email" name="email" class="standardInput" id="email" placeholder="jan.beentjes@gmail.com" value="<?php echo $email ?>" onkeyup="mailValid()" onclick="mailValid()" onchange="mailValid()" <?php echo ($emailErr!='')?'autofocus':'' ?>/></td>
            </tr>
            <tr>
              <td class="errorstyle"><?php echo $emailErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="mailErr">Ongeldig e-mailadres</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($mailErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig e-mailadres</td>
            </tr>
            <tr>
              <td height="20">Telefoonnummer:</td>
              <td><input type="text" class="standardInput" name="tel" id="tel" placeholder="0612345678" value="<?php echo $tel ?>" onkeyup="telValid()" onclick="telValid()" onchange="telValid()"/></td>
            </tr>
            <tr>
              <td class="errorstyle" style="display: none;" id="telErr">Ongeldig telefoonnummer</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($telErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig telefoonnummer</td>
            </tr>
            <tfoot>
              <tr>
                <td colspan="2"><br><br><br>
                  <!-- Buttons to change page. -->
                  <button class="savechanges inline" type="submit" id="register" onclick="editdatavalidator()">Sla gegevens op</button>
                  <a class="discardchanges inline" href="gebruiker.php">Annuleer</a>
                </td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

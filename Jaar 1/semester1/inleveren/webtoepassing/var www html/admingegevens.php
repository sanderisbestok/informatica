<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         admingegevens.php
Description;  Change the information about a user
Usage;        Fill in the input fields and press submit to change the information about a user
-->

<?php include('./globalUI/globalConnect.php'); ?>
<?php
  /* Checks if the user is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
    die();
  }

  /* Checks if the privilege level of the user is high enough */
  $sqlpriv = "SELECT privilege_level FROM users WHERE user_id = '$_SESSION[user_id]'";
  $querypriv = $globalDB->prepare($sqlpriv);
  $querypriv->execute();
  $priv = $querypriv->fetch();
  $privlevel = $priv[0];
  if(intval($privlevel) < 9){
    header("Location: index.php");
  }

  /* Gets the id of the user the admin wants to change and saves it in the session */
  $user_id = "";
  if(!isset($_GET['user_id'])) {
    if(empty($_SESSION['user_to_change'])) {
      header('Location: admingebruiker.php');
      die();
    } else {
      $user_id = $_SESSION['user_to_change'];
      $id2query = $globalDB->prepare('SELECT user_id FROM users WHERE user_id = :user_id');
      $id2query->execute(array(':user_id' => $_SESSION['user_to_change']));
      $row2 = $id2query->fetch(PDO::FETCH_ASSOC);
      if (empty($row2['user_id'])) {
        header('Location: admingebruiker.php');
        die();
      }
    }
  } else {
    $user_id = $_GET['user_id'];
    $idquery = $globalDB->prepare('SELECT user_id FROM users WHERE user_id = :user_id');
    $idquery->execute(array(':user_id' => $_GET['user_id']));
    $row = $idquery->fetch(PDO::FETCH_ASSOC);
    if (!empty($row['user_id'])) {
      $_SESSION['user_to_change'] = $user_id;
    } else {
      header('Location: admingebruiker.php');
      die();
    }
  }

?>

<!-- Gets all the information about a user from the database -->
<?php
  $stmt = $globalDB->prepare("SELECT sex FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $sexin = $stmt->fetch(PDO::FETCH_NUM);
  $sex = $sexin[0];

  $stmt = $globalDB->prepare("SELECT first_name FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $firstnamein = $stmt->fetch(PDO::FETCH_NUM);
  $firstname = $firstnamein[0];

  $stmt = $globalDB->prepare("SELECT prefix FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $prefixin = $stmt->fetch(PDO::FETCH_NUM);
  $prefix = $prefixin[0];

  $stmt = $globalDB->prepare("SELECT surname FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $surnamein = $stmt->fetch(PDO::FETCH_NUM);
  $surname = $surnamein[0];

  $stmt = $globalDB->prepare("SELECT city FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$user_id'");
  $stmt->execute();
  $cityin = $stmt->fetch(PDO::FETCH_NUM);
  $city = $cityin[0];

  $stmt = $globalDB->prepare("SELECT postcode FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$user_id'");
  $stmt->execute();
  $zipin = $stmt->fetch(PDO::FETCH_NUM);
  $zip = $zipin[0];

  $stmt = $globalDB->prepare("SELECT street FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$user_id'");
  $stmt->execute();
  $streetin = $stmt->fetch(PDO::FETCH_NUM);
  $street = $streetin[0];

  $stmt = $globalDB->prepare("SELECT number FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$user_id'");
  $stmt->execute();
  $addressin = $stmt->fetch(PDO::FETCH_NUM);
  $address = $addressin[0];

  $stmt = $globalDB->prepare("SELECT addition FROM users INNER JOIN addresses ON users.address_id = addresses.address_id WHERE user_id = '$user_id'");
  $stmt->execute();
  $affixin = $stmt->fetch(PDO::FETCH_NUM);
  $affix = $affixin[0];

  $stmt = $globalDB->prepare("SELECT date_birth FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $birthdayin = $stmt->fetch(PDO::FETCH_NUM);
  //$birthdayvalue = $birthday[0];
  $parts = explode('-', $birthdayin[0]);
  $birthday = "" . $parts[2] . "-" . $parts[1] . "-" . $parts[0];

  $stmt = $globalDB->prepare("SELECT phone FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $telin = $stmt->fetch(PDO::FETCH_NUM);
  $tel = $telin[0];

  $stmt = $globalDB->prepare("SELECT email FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $emailin = $stmt->fetch(PDO::FETCH_NUM);
  $email = $emailin[0];

  $stmt = $globalDB->prepare("SELECT privilege_level FROM users WHERE user_id = '$user_id'");
  $stmt->execute();
  $levelin = $stmt->fetch(PDO::FETCH_NUM);
  $level = $levelin[0];
?>
<?php
  /* Sanitizes the input */
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /* Redirects the user when the information is updated */
  function redirect() {
    header("Location: admingebruiker.php");
    die();
  }
?>
<?php
/* Sets all error variables */
$emailErr = "";
$firstnameErr = $prefixErr = $surnameErr = $cityErr = $zipErr = false;
$streetErr = $addressErr = $affixErr = $birthdayErr = $telErr = false;
$mailErr = $levelErr = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstnameErr = $prefixErr = $surnameErr = $cityErr = $zipErr = false;
  $streetErr = $addressErr = $affixErr = $birthdayErr = $telErr = false;
  $mailErr = $levelErr = false;
  $allcorrect = True;

  /* Checks if the sex is chosen */
  if (empty($_POST["sex"])) {
    $allcorrect = False;
  } else {
    $sex = test_input($_POST["sex"]);
  }

  /* Checks if the firstname is valid */
  if (empty($_POST["firstname"])) {
    $allcorrect = False;
  } else {
    $firstname = test_input($_POST["firstname"]);
    if (!preg_match("/^([^0-9]*)$/", $firstname) || strlen($firstname) < 2) {
      $allcorrect = False;
      $firstnameErr = true;
    }
  }

  /* Checks if the prefix is valid, when it's filled in */
  if (empty($_POST["prefix"])) {
    $prefix = test_input($_POST["prefix"]);
  } else {
    $prefix = test_input($_POST["prefix"]);
    if (!preg_match("/^([^0-9]*)$/", $prefix) && strlen($prefix) > 0) {
      $allcorrect = False;
      $prefixErr = true;
    }
  }

  /* Checks if the surname is valid */
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

  /* Checks if the cityname is valid */
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
    if (!preg_match("/^([^0-9]*)$/", $street) || strlen($street) < 2) {
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

  /* Check for the affix */
  if (!empty($_POST["affix"])) {
    $affix = test_input($_POST["affix"]);
  } else {
    $affix = "";
  }

  /* Check if the birthday is valid */
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
        $birthdayvalue = "" . $test_arr[2] . "-" . $test_arr[1] . "-" . $test_arr[0];
      }
    } else {
      $allcorrect = False;
      $birthdayErr = true;
    }
  }

  /* Checks if the telephone number is valid */
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

  /* Checks if the email is valid */
  if (empty($_POST["email"])) {
    $allcorrect = False;
    $mailErr = true;
  } else {
    $email = test_input($_POST["email"]);
    if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
      $testemailquery = $globalDB->prepare("SELECT email FROM users WHERE user_id = '$user_id'");
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
  /* Checks if the privilege level is valid */
  if (empty($_POST["level"])) {
    $allcorrect = False;
    $levelErr = true;
  } else {
    $level = test_input($_POST["level"]);
    if ($level <= 0 && $level >= 9) {
      $allcorrect = False;
      $levelErr = true;
    }
  }

  if($allcorrect) {
    /* Updates data in users table */
    $sqluser = "UPDATE users SET first_name = :firstname,
                             surname = :surname,
                             prefix = :prefix,
                             date_birth = :birthday,
                             sex = :sex,
                             email = :email,
                             phone = :tel,
                             privilege_level = :level
                             WHERE user_id='$user_id' LIMIT 1";
    $queryuser = $globalDB->prepare($sqluser);
    $queryuser->execute(array(
      ':firstname' => $firstname,
      ':surname' => $surname,
      ':prefix' => $prefix,
      ':birthday' => $birthdayvalue,
      ':sex' => $sex,
      ':email' => $email,
      ':tel' => $tel,
      ':level' => $level
    ));

    /* Updates data in address table */
    $sqlid = "SELECT address_id FROM users WHERE user_id = '$user_id'";
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
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Gegevens wijzigen</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/editdata.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>

  <!-- Sets display of javascript errors to none -->
  <body onload="seterrorsedit()">
    <?php
      include ('./globalUI/header.php');
    ?>

    <div class="container">
      <div class="content">
        <form name="addaptdata" class="addaptdataform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <table>
            <tr>
              <td width="60" height="40"><h3>Persoonsgegevens</h3></td>
            </tr>
            <!-- Radio buttons to choose gender -->
            <tr>
              <td height="20">Geslacht:</td>
              <td>De heer: <input type="radio" name="sex" value="male" <?php echo ($sex=='male')?'checked':'' ?> />
                Mevrouw: <input type="radio" name="sex" value="female" <?php echo ($sex=='female')?'checked':'' ?> /></td>
            </tr>
            <!-- Input field for first name -->
            <tr>
              <td height="20">Voornaam:</td>
              <td><input type="text" name="firstname" id="firstname" value="<?php echo $firstname ?>" onkeyup="fnameValid()" onchange="fnameValid()" onclick="fnameValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="firstnameErr">Ongeldige voornaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($firstnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige voornaam</td>
            </tr>
            <!-- Input field for prefix -->
            <tr>
              <td height="20">Tussenvoegsel:</td>
              <td><input type="test" name="prefix" id="prefix" value="<?php echo $prefix ?>" onkeyup="pfixValid()" onclick="pfixValid()" onchange="pfixValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="prefixErr">Ongeldig tussenvoegsel</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($prefixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig tussenvoegsel</td>
            </tr>
            <!-- Input field for surname -->
            <tr>
              <td height="20">Achternaam:</td>
              <td><input type="text" name="surname" id="surname" value="<?php echo $surname ?>" onkeyup="snameValid()" onclick="snameValid()" onchange="snameValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="surnameErr">Ongeldige achternaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($surnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige achternaam</td>
            </tr>
            <!-- Input field for day of birth -->
            <tr>
              <td height="20">Geboortedatum:</td>
              <td><input type="text" name="birthday" id="birthday" placeholder="dd-mm-jjjj" value="<?php echo $birthday ?>" onkeyup="dateValid()" onclick="dateValid()" onchange="dateValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="birthdayErr">Ongeldige geboortedatum</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($birthdayErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige geboortedatum</td>
            </tr>
            <tr>
              <td height="40"><h3>Locatiegegevens</h3></td>
            </tr>
            <!-- Input field for cityname -->
            <tr>
              <td height="20">Woonplaats:</td>
              <td><input type="text" name="city" id="city" value="<?php echo $city ?>" onkeyup="cityValid()" onclick="cityValid()" onchange="cityValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="cityErr">Ongeldige woonplaats</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($cityErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige woonplaats</td>
            </tr>
            <!-- Input field for zip -->
            <tr>
              <td height="20">Postcode:</td>
              <td><input type="text" name="zip" id="zip" placeholder="1234 AB" value="<?php echo $zip ?>" onkeyup="zipValid()" onclick="zipValid()" onchange="zipValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="zipErr">Ongeldige postcode</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($zipErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige postcode</td>
            </tr>
            <!-- Input field for streetname -->
            <tr>
              <td height="20">Straat:</td>
              <td><input type="text" name="street" id="street" value="<?php echo $street ?>" onkeyup="streetValid()" onclick="streetValid()" onchange="streetValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="streetErr">Ongeldige straatnaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($streetErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige straatnaam</td>
            </tr>
            <!-- Input field for home number -->
            <tr>
              <td height="20">Huisnummer:</td>
              <td><input type="text" name="address" id="address" value="<?php echo $address ?>" onkeyup="addressValid()" onclick="addressValid()" onchange="addressValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="addressErr">Ongeldig huisnummer</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($addressErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig huisnummer</td>
            </tr>
            <!-- Input field for affix -->
            <tr>
              <td height="20">Huisnummer toevoeging:</td>
              <td><input type="text" name="affix" id="affix" maxlength="8" value="<?php echo $affix ?>" onkeyup="affixValid()" onclick="affixValid()" onchange="affixValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="affixErr">Ongeldige toevoeging</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($affixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige toevoeging</td>
            </tr>
            <tr>
              <td height="40"><h3>Contactgegevens</h3></td>
            </tr>
            <!-- Input field for email -->
            <tr>
              <td height="20">E-mailadres:</td>
              <td><input type="email" name="email" id="email" placeholder="jan.beentjes@gmail.com" value="<?php echo $email ?>" onkeyup="mailValid()" onclick="mailValid()" onchange="mailValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle"><?php echo $emailErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" id="mailErr">Ongeldig e-mailadres</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($mailErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig e-mailadres</td>
            </tr>
            <!-- Input field for telephone number -->
            <tr>
              <td height="20">Telefoonnummer:</td>
              <td><input type="text" name="tel" id="tel" placeholder="0612345678" value="<?php echo $tel ?>" onkeyup="telValid()" onclick="telValid()" onchange="telValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="telErr">Ongeldig telefoonnummer</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($telErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig telefoonnummer</td>
            </tr>
            <!-- Input field for privilege level -->
            <tr>
              <td height="20">Privilege level:</td>
              <td><input type="number" name="level" id="level" value="<?php echo $level ?>" onkeyup="levelValid()" onclick"levelValid()" onchange="levelValid()"/></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="levelErr">Ongeldig privilege level</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($levelErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig privilege level</td>
            </tr>
            <tfoot>
              <tr>
                <td colspan="2"><br><br><br>
                  <!-- Buttons to submit or go back -->
                  <button class="savechanges" type="submit" id="register" onclick="editadminvalidator()">Sla gegevens op</button>
                  <a class="discardchanges" href="admingebruiker.php">Annuleer</a>
                </td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

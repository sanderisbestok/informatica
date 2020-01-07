<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         registreren.php
Description;  Page is used to register a new user.
Usage; n/a
-->

<!-- Makes the connection with the database. -->
<?php include('./globalUI/globalConnect.php'); ?>
<?php
  if(!empty($_SESSION["user_id"])){
    header("Location: gebruiker.php");
    die();
  }
?>
<?php
  #Necessary variables are created.
  $sex = $firstname = $prefix = $surname = $city = "";
  $zip = $street = $address = $affix = $birthday = "";
  $tel = $email = $password = $repassword = "";
  $emailErr = "";

  $firstnameErr = $prefixErr = $surnameErr = $cityErr = $zipErr = false;
  $streetErr = $addressErr = $affixErr = $birthdayErr = $telErr = false;
  $mailErr = $passwordErr = $repasswordErr = false;
  #Function used when the submit button is pressed.
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #Necessary variables are set to false.
    $firstnameErr = $prefixErr = $surnameErr = $cityErr = $zipErr = false;
    $streetErr = $addressErr = $affixErr = $birthdayErr = $telErr = false;
    $mailErr = $passwordErr = $repasswordErr = false;
    $allcorrect = True;
    #Test if the sex input is filled.
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
    #Test if the city name is of wanted format.
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
    #Test if the street name is of wanted format.
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
      if (!preg_match("/^[a-zA-Z ]*$/",$affix)) {
        $allcorrect = False;
        $affixErr = true;
      }
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
          $birthdayvalue = "" . $test_arr[2] . "-" . $test_arr[1] . "-" . $test_arr[0];
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
        $emailquery = $globalDB->prepare('SELECT email FROM users WHERE email = :email');
        $emailquery->execute(array(':email' => $_POST['email']));
        $row = $emailquery->fetch(PDO::FETCH_ASSOC);
        if(!empty($row['email'])){
          $emailErr = "Dit e-mailadres is al in gebruik";
          $allcorrect = False;
        }
      } else {
        $emailErr = "";
        $allcorrect = False;
        $mailErr = true;
      }
    }
    #Test if the password is of wanted format.
    if (empty($_POST["password"])) {
      $allcorrect = False;
      $passwordErr = true;
    } else {
      $password = test_input($_POST["password"]);
      $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
    }
    #Test if the confirmation password is of wanted format and correct.
    if (empty($_POST["repassword"])) {
      $allcorrect = False;
      $repasswordErr = true;
    } else {
      $repassword = test_input($_POST["repassword"]);
      if ($password != $repassword) {
        $allcorrect = False;
        $repasswordErr = true;
      }
    }
    #If every test above is checked, then the data of the user will be inserted in the database.
    if($allcorrect) {
      $addresssql = "INSERT INTO addresses (street, number, addition, postcode, city)
                  VALUES (:street, :address, :affix, :zip, :city)";
      $addressquery = $globalDB->prepare($addresssql);
      $addressquery->execute(array(
        ':street' => $street,
        ':address' => $address,
        ':affix' => $affix,
        ':zip' => $zip,
        ':city' => $city
      ));
      $usersql = "INSERT INTO users (first_name,surname,prefix,date_birth,sex,email,phone,address_id,passwd_hash)
              VALUES (:firstname, :surname, :prefix, :birthday, :sex, :email, :tel, (SELECT address_id FROM addresses WHERE address_id = LAST_INSERT_ID()), :password)";
      $userquery = $globalDB->prepare($usersql);
      $userquery->execute(array(
        ':firstname' => $firstname,
        ':surname' => $surname,
        ':prefix' => $prefix,
        ':birthday' => $birthdayvalue,
        ':sex' => $sex,
        ':email' => $email,
        ':tel' => $tel,
        ':password' => $hashedpassword
      ));
      $message = "De registratie is voltooid";
      echo "<script type='text/javascript'>alert('$message');</script>";
      redirect();
    }
  }
  #Function used to make input data usable for testing.
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  #Function used to redirect user to login page.
  function redirect() {
    header("Location: inlogpagina.php");
    die();
  }
 ?>
<!-- Begin document. -->
<!DOCTYPE html>

<html lang="en">
  <head>
    <title>Registreren</title>
    <!-- Necessary files are imported here. -->
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/forms.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>
  <!-- Makes sure that when page is loaded, the error message are off. -->
  <body onload="seterrors()">
    <?php include('./globalUI/header.php'); ?>
    <div class="container">
      <div class="content">
        <h1>Accountgegevens</h1>
        <div class="row">
          <div class="reg_form c-12">
            <!-- Start of the registration form. -->
            <form name="registration" class="registrationform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <ul class="enter_data" style="list-style-type: none;">
                <h2>Persoonlijke gegevens</h2>
                <!-- Button to have the user go back to login page. -->
                <span class="backtologin"><a href="inlogpagina.php" class="pagelink">Terug naar login pagina</a></span>
                <!-- This is where the user's gender must be confirmed. -->
                <li><label for="sex">Aanhef*</label></li>
                <li>
                  <input type="radio" name="sex" value="male" id="male" <?php if (isset($sex) && $sex=="male") echo "checked";?> required="sex"/> De heer
                  <input type="radio" name="sex" value="female" id="female" <?php if (isset($sex) && $sex=="female") echo "checked";?> required="sex"/> Mevrouw
                </li>
                <table>
                  <!-- This is where the rest of the information must be put in. -->
                  <!-- Each input has it's own errormessage right underneath. -->
                  <thead>
                    <tr>
                      <th>Voornaam*</th>
                      <th>Tussenvoegsel</th>
                      <th>Achternaam*</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td data-label="Voornaam*"><input type="text" name="firstname" id="firstname" size="13" class="moveinput standardInput" value="<?php echo $firstname; ?>" onkeyup="fnameValid()" onchange="fnameValid()" onclick="fnameValid()"/></td>
                      <td data-label="Tussenvoegsel"><input type="text" name="prefix" id="prefix" size="13" class="moveinput standardInput" value="<?php echo $prefix; ?>" onkeyup="pfixValid()" onclick="pfixValid()" onchange="pfixValid()"/></td>
                      <td data-label="Achternaam*"><input type="text" name="surname" id="surname" size="13" class="moveinput standardInput" value="<?php echo $surname; ?>" onkeyup="snameValid()" onclick="snameValid()" onchange="snameValid()"/></td>
                    </tr>
                  </tbody>
                </table>
                <li class="errorstyle" style="display: none;" id="firstnameErr">Ongeldige voornaam</li>
                <li class="errorstyle" style="display: none;" id="prefixErr">Ongeldig tussenvoegsel</li>
                <li class="errorstyle" style="display: none;" id="surnameErr">Ongeldige achternaam</li>
                <li class="errorstyle" style="<?php if($firstnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige voornaam</li>
                <li class="errorstyle" style="<?php if($prefixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig tussenvoegsel</li>
                <li class="errorstyle" style="<?php if($surnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige achternaam</li>
                <li><label for="city">Woonplaats*</label></li>
                <li class="move"><input type="text" name="city" class="standardInput" id="city" size="13" value="<?php echo $city; ?>" onkeyup="cityValid()" onclick="cityValid()" onchange="cityValid()"/></li>
                <li class="errorstyle" style="display: none;" id="cityErr">Ongeldige woonplaats</li>
                <li class="errorstyle" style="<?php if($cityErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige woonplaats</li>
                <li><label for="zip">Postcode*</label></li>
                <li class="move"><input type="text" name="zip" class="standardInput" id="zip" placeholder="1234 AB" maxlength="7" size="13" value="<?php echo $zip; ?>" onkeyup="zipValid()" onclick="zipValid()" onchange="zipValid()"/></li>
                <li class="errorstyle" style="display: none;" id="zipErr">Ongeldige postcode</li>
                <li class="errorstyle" style="<?php if($zipErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige postcode</li>
                <table>
                  <thead>
                    <tr>
                      <th>Straatnaam*</th>
                      <th>Huisnummer*</th>
                      <th>Toevoeging</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td data-label="Straatnaam*"><input type="text" name="street" id="street" size="13" class="moveinput standardInput" value="<?php echo $street; ?>" onkeyup="streetValid()" onclick="streetValid()" onchange="streetValid()"/></td>
                      <td data-label="Huisnummer*"><input type="text" name="address" id="address" size="13" class="moveinput standardInput" value="<?php echo $address; ?>" onkeyup="addressValid()" onclick="addressValid()" onchange="addressValid()"/></td>
                      <td data-label="Toevoeging"><input type="text" id="affix" name="affix" maxlength="8" size="13" class="moveinput standardInput" value="<?php echo $affix; ?>" onkeyup="affixValid()" onclick="affixValid()" onchange="affixValid()"/></td>
                    </tr>
                  </tbody>
                </table>
                <li class="errorstyle" style="display: none;" id="streetErr">Ongeldige straatnaam</li>
                <li class="errorstyle" style="display: none;" id="addressErr">Ongeldig huisnummer</li>
                <li class="errorstyle" style="display: none;" id="affixErr">Ongeldige toevoeging</li>
                <li class="errorstyle" style="<?php if($streetErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige straatnaam</li>
                <li class="errorstyle" style="<?php if($addressErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig huisnummer</li>
                <li class="errorstyle" style="<?php if($affixErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige toevoeging</li>
                <li><label for="birthday">Geboortedatum*</label></li>
                <li class="move"><input type="text" name="birthday" class="standardInput" id="birthday" placeholder="dd-mm-jjjj" size="13" value="<?php echo $birthday; ?>" onkeyup="dateValid()" onclick="dateValid()" onchange="dateValid()"/></li>
                <li class="errorstyle" style="display: none;" id="birthdayErr">Ongeldige geboortedatum</li>
                <li class="errorstyle" style="<?php if($birthdayErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige geboortedatum</li>
                <li><label for="tel">Telefoonnummer*</label></li>
                <li class="move"><input type="text" name="tel" class="standardInput" id="tel" placeholder="0612345678" size="13" value="<?php echo $tel; ?>" onkeyup="telValid()" onclick="telValid()" onchange="telValid()"/></li>
                <li class="errorstyle" style="display: none;" id="telErr">Ongeldig telefoonnummer</li>
                <li class="errorstyle" style="<?php if($telErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig telefoonnummer</li>
                <hr class="separator" />
                <h2>Inloggegevens</h2>
                <div style="height: 40px; color: red;"><?php echo $emailErr; ?></div>
                <li><label for="email">E-mailadres*</label></li>
                <li class="moveemail"><input type="email" name="email" class="standardInput" id="email" placeholder="jan.beentjes@gmail.com" size="17" value="<?php echo $email; ?>" onkeyup="mailValid()" onclick="mailValid()" onchange="mailValid()"/></li>
                <li class="errorstyle" style="display: none;" id="mailErr">Ongeldig e-mailadres</li>
                <li class="errorstyle" style="<?php if($mailErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig e-mailadres</li>
                <li><label for="password">Wachtwoord*</label></li>
                <li class="movepasswd1"><input type="password" name="password" class="standardInput" id="password" placeholder="Minimaal 8 tekens" size="13" value="<?php echo $password; ?>" onkeyup="passValid()" onclick="passValid()" onchange="passValid()"/></li>
                <li class="errorstyle" style="display: none;" id="passwordErr">Ongeldig wachtwoord</li>
                <li class="errorstyle" style="<?php if($passwordErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig wachtwoord</li>
                <li><label for="repassword">Herhaal wachtwoord*</label></li>
                <li class="movepasswd2"><input type="password" name="repassword" class="standardInput" id="repassword" size="10" value="<?php echo $repassword; ?>" onkeyup="samePasswd()" onclick="samePasswd()" onchange="samePasswd()"/></li>
                <li class="errorstyle" style="display: none;" id="repasswordErr">Uw wachtwoorden zijn niet gelijk</li>
                <li class="errorstyle" style="<?php if($repasswordErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Uw wachtwoorden zijn niet gelijk</li>
                <li><button type="submit" name="register" class="register" id="register" onclick="regvalidator()">Registreer</button></li>
              </ul>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         wijzigwachtwoord.php
Description;  Page shown when a user wants to change his password.
Usage; n/a
-->

<!-- Make connection with database. -->
<?php include('./globalUI/globalConnect.php') ?>
<!-- Test if the user is logged in, if not he/she will be redirected to the login page. -->
<?php
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
  }
?>
<?php
#User id and password is gathered.
$curuser_id = $_SESSION["user_id"];
$stmt = $globalDB->prepare("SELECT passwd_hash FROM users WHERE user_id = '$curuser_id'");
$stmt->execute();
$origpassww = $stmt->fetch(PDO::FETCH_NUM);
$origpasswwvalue = $origpassww[0];
#Necessary variables are created.
$passErr = $password = $repassword = $old_password = "";
$passwordErr = $repasswordErr = false;
#Function that is used when the submit button is pressed.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $passwordErr = $repasswordErr = false;
  $allcorrect = True;
  #Test if the password is of wanted format..
  if (empty($_POST["password"])) {
    $allcorrect = False;
    $passwordErr = true;
  } else {
    $password = test_input($_POST["password"]);
    if(strlen($password) < 8) {
      $passwordErr = true;
    }
  }
  #Test if new password is the same as confirm password.
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
  #Test if old password is indeed the old password.
  if (empty($_POST["old_password"])) {
    $allcorrect = False;
  } else {
    $old_password = test_input($_POST["old_password"]);
  }
  if (!password_verify($old_password, $origpasswwvalue)){
    $allcorrect = False;
    $passErr = "Verkeerd wachtwoord";
  } else {
    $passErr = "";
  }
  #If all tests above are confirmed, the password will be updated in the database.
  if($allcorrect) {
    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET passwd_hash='$hashedpassword' WHERE user_id='$curuser_id' LIMIT 1";
    $stmt = $globalDB->prepare($sql);
    $stmt->execute();
    redirect();
  }
}
#Function used to redirect user.
function redirect() {
  header("Location: index.php");
  die();
}
#This function is used to make user input usable.
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!-- Begin document. -->
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Wijzig wachtwoord</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/editdata.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>

  <body onload="seterrorspasswd()">

    <?php include('./globalUI/header.php'); ?>

    <div class="container">
      <div class="content">
        <h1>Wijzig wachtwoord</h1>
        <form name="addaptpasww" class="addaptdataform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <table>
            <tr>
              <!-- This is where the old password must come. -->
              <td width="240" height="20">Oud wachtwoord:</td>
              <td><input type="password" class="standardInput" name="old_password" required value="<?php echo $old_password; ?>"/></td>
            </tr>
            <tr>
              <!-- Possible errormessage is displayed here. -->
              <td class="errorstyle"><?php echo $passErr; ?></td>
            </tr>
            <tr>
              <!-- This is where the new password must come. -->
              <td height="20">Nieuw wachtwoord:</td>
              <td><input type="password" name="password" class="standardInput" value="<?php echo $password; ?>" required id="password" onkeyup="passValid()" onclick="passValid()" onchange="passValid()"/></td>
            </tr>
            <tr>
              <!-- Possible errormessage is displayed here. -->
              <td class="errorstyle" id="passwordErr">Ongeldig wachtwoord</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($passwordErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig wachtwoord</td>
            </tr>
            <tr>
              <!-- This is where the confirmation password must come. -->
              <td height="20">Bevestig wachtwoord:</td>
              <td><input type="password" name="repassword" class="standardInput" value="<?php echo $repassword; ?>" required id="repassword" onkeyup="samePasswd()" onclick="samePasswd()" onchange="samePasswd()"/></td>
            </tr>
            <tr>
              <!-- Possible errormessage is displayed here. -->
              <td class="errorstyle" id="repasswordErr">Uw wachtwoorden zijn niet gelijk</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($repasswordErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Uw wachtwoorden zijn niet gelijk</td>
            </tr>
            <tfoot>
              <tr>
                <td colspan="2"><br><br><br>
                  <!-- Buttons used to change page. -->
                  <button class="savechangepassword inline" type="submit" id="register" onclick="editwwvalidator()">Wijzig wachtwoord</button>
                  <a class="discardchangepassword inline" href="gebruiker.php">Annuleer</a><br><br>
                  <a class="forgotpassword inline" href="wachtwoordvergeten.php">Wachtwoord vergeten</a>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

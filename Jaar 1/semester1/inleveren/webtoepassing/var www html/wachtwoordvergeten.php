<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         wachtwoordvergeten.php
Description;  Page is used to edit password of a user when he/she forgot it.
Usage; n/a
-->

<!-- Makes the connection with the database. -->
<?php include('./globalUI/globalConnect.php') ?>

<?php
#Function to edit input to make it usable for testing.
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
#Necessary variables are created.
$email = $emailErr = $emailFound = "";
$mailErr = false;
#Function that is used when the submit button is pressed.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mailErr = false;
  $emailErr = $emailFound = "";
  #Test to see if the emailaddress is valid.
  if (empty($_POST["email"])) {
    $mailErr = true;
  } else {
    $email = test_input($_POST["email"]);
    #Below the email address will be tested if it is of the wanted format.
    if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
      $emailquery = $globalDB->prepare('SELECT email FROM users WHERE email = :email');
      $emailquery->execute(array(':email' => $email));
      $row = $emailquery->fetch(PDO::FETCH_ASSOC);
      #Firstly, a new random password is made.
      #Next, the old password will be removed and the new password comes in place.
      #In the end, the new password is send to the right user using an email.
      if(!empty($row['email'])){
        $emailFound = "Het wachtwoord is gewijzigd, het nieuwe wachtwoord is naar uw email-verstuurd";
        $newpassww = generateRandomString();
        $hashedpassword = password_hash($newpassww, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET passwd_hash='$hashedpassword' WHERE email='$_POST[email]' LIMIT 1";
        $stmt = $globalDB->prepare($sql);
        $stmt->execute();

        #Below is used to get information about the specific user to make the mail formal.
        $stmt = $globalDB->prepare("SELECT first_name FROM users WHERE email='$_POST[email]' LIMIT 1");
        $stmt->execute();
        $firstnamein = $stmt->fetch(PDO::FETCH_NUM);
        $firstname = $firstnamein[0];

        $stmt = $globalDB->prepare("SELECT prefix FROM users WHERE email='$_POST[email]' LIMIT 1");
        $stmt->execute();
        $prefixin = $stmt->fetch(PDO::FETCH_NUM);
        $prefix = $prefixin[0];

        $stmt = $globalDB->prepare("SELECT surname FROM users WHERE email='$_POST[email]' LIMIT 1");
        $stmt->execute();
        $surnamein = $stmt->fetch(PDO::FETCH_NUM);
        $surname = $surnamein[0];

        #Below is used to set up mail and to send it.
        $message ="Geachte $firstname $prefix $surname ,\r\n\r\n
        Er is een verzoek verstuurd om uw wachtwoord te wijzigen.\r\n
        Dit is uw nieuwe wachtwoord:\r\n
        $newpasww\r\n\r\n
        Wij verzoeken u hiermee in te loggen en zo snel mogelijk het wachtwoord te wijzigen naar iets van eigen keuze.\r\n
        Een fijne dag gewenst verder.\r\n\r\n
        Het Stuffz team.";
        $message = wordwrap($message, 70, "\r\n");
        $emailto =$_POST[email];
        $subject ="Wachtwoord wijzig verzoek";
        $headers = 'From: no-reply@stuffz.nl';
        mail($emailto, $subject, $message, $headers);
      } else {
        $emailErr = "Dit e-mailadres is niet in gebruik";
      }
    } else {
      $mailErr = true;
    }
  }
}
#Function taken from: http://stackoverflow.com/questions/4356289/php-random-string-generator.
function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<!-- Begin document -->
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Wachtwoord vergeten</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/editdata.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>

  <body onload="seterrorsmail()">

    <?php include('./globalUI/header.php'); ?>

    <div class="container">
      <div class="content">
        <h1>Wachtwoord vergeten</h1>
        <form name="forgotpasww" class="addaptdataform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <table>
            <tr>
              <!-- Below is the input for the email address. -->
              <td width="120" height="20">E-mailadres:</td>
              <td><input type="email" name="email" class="standardInput" id="email" placeholder="jan.beentjes@gmail.com" value="<?php echo $email; ?>" onkeyup="mailValid()" onclick="mailValid()" onchange="mailValid()"/></td>
            </tr>
          </table>
              <!-- Below is where possible error messages are placed. -->
          <table>
            <tr>
              <td class="errorstyle"><?php echo $emailErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle"><?php echo $emailFound; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" id="mailErr" style="display: none;" >Ongeldig e-mailadres</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($mailErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig e-mailadres</td>
            </tr>
          </table>
          <table>
              <!-- Buttons to change page. -->
            <tr>
              <td><button class="sendnewpassword" type="submit" id="register" onclick="emailvalidator()">Verstuur nieuw wachtwoord</button></td>
            </tr>
            <tr>
              <td><a class="discardsendnewpassword" href="wijzigwachtwoord.php">Annuleer</a></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

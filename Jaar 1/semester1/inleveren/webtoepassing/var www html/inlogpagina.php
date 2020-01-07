<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         inlogpagina.php
Description;  Page is used by the user to log in.
Usage; n/a
-->

<!-- Makes the connection with the database. -->
<?php include('./globalUI/globalConnect.php'); ?>
<?php
  #Test if the user is already logged in.
  if(!empty($_SESSION["user_id"])){
    header("Location: gebruiker.php");
    die();
  }
  #Below is used to redirect user to the destination page.
  if(!empty($_GET["redirect"]) && preg_match("/([A-Za-z0-9]*\/)[A-Za-z0-9]*.\.[A-Za-z0-9]*/", $_GET["redirect"])) {
    $_SESSION["goal"] = $_GET["redirect"];
  } else if(empty($_SESSION["goal"])){
    $_SESSION["goal"] = "index.php";
  }
?>
<?php
  #Test if email input is filled.
  if(!empty($_POST["email"])){
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $authenticated = FALSE;

      #fetch password hash from database
      $stmt = $globalDB->prepare("SELECT user_id, passwd_hash FROM users WHERE email=?");
      $stmt->bindValue(1, $_POST["email"]);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_NUM);
      #Test if password is indeed the password that belongs to that e-mailadres.
      if($result){
        if(password_verify($_POST["password"], $result[1])){
          #Necessary variables are created.
          $authenticated = TRUE;
          $_SESSION["auth"] = TRUE;
          $_SESSION["user_id"] = $result[0];
          #Below is used to make sure the user is redirected to the right page.
          if(!empty($_SESSION["goal"])){
            $goal = $_SESSION["goal"];
            unset($_SESSION["goal"]);
            print($goal);
            header("Location:".$goal);
          } else {
            $goal = "index.php";
            header("Location:".$goal);
          }
        }
      }
      #Errormessage when email is incorrect.
    } else {
      $emailErr = "Ongeldig e-mailadres.";
    }

  }

?>
<!-- Begin document. -->
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Inlogpagina</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/forms.css" />
  </head>

  <body>
    <?php
      include('./globalUI/header.php');
    ?>
    <div class="container">
      <div class="content">
        <h1>Aanmelden</h1>
        <div class="loginrow">
          <div class="row">
            <div class="login c-6">
              <form class="loginform" method="post" action="<?php print htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <ul style="list-style-type:none">
                  <!-- Below are all the input fields. -->
                  <li><label for="email">E-mailadres</label></li>
                  <li><input type="email" class="standardInput" name="email" value="<?php if(isset($_POST['email'])) print htmlspecialchars($_POST['email']); ?>"></li>
                  <li><label for="password">Wachtwoord</label></li>
                  <li><input type="password" class="standardInput" name="password"></li>
                  <!-- Error messages are displayed here. -->
                  <?php if(!empty($_POST['email'])) { print
                    "<li class='loginerror'><span class='warning'>Onbekend e-mailadres en/of onjuist wachtwoord.</span></li>";
                  } else if(isset($_POST['email'])) { print
                    "<li class='loginerror'><span class='warning'>Voer een e-mailadres in.</span></li>";
                  }?>
                  <!-- Submit button -->
                  <li><button type="submit" name="submit" class="login">Inloggen</button></li>
                </ul>
              </form>
              <!-- Button to use if user forgot his/her password -->
              <a href="wachtwoordvergeten.php" class="pagelink">Wachtwoord vergeten?</a>
            </div>
            <div class="register c-6">
              <h3>Nog geen account, registreer je nu</h3>
              <form action="registreren.php">
                <button type="submit" class="register">Registreren</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      include('./globalUI/footer.php');
    ?>
  </body>
</html>

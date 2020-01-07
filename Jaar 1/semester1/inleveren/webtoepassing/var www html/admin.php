<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         admin.php
Description;  Menu for admin users
Usage;        n/a
-->
<?php
  include_once('./globalUI/globalConnect.php');
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php?redirect=admin.php");
    die();
  }
  /* Set privilege level variable and check if user has privilege to visit admin.php */
  $sqlpriv = "SELECT privilege_level FROM users WHERE user_id = '$_SESSION[user_id]'";
  $querypriv = $globalDB->prepare($sqlpriv);
  $querypriv->execute();
  $priv = $querypriv->fetch();
  $privlevel = $priv[0];
  if(intval($privlevel) < 1){
    header("Location: index.php");
  }
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Admin</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/admin.css" />
  </head>

  <body>
    <?php include('./globalUI/header.php'); ?>
    <div id="includedTop"></div>
    <div class="container">
      <div class="content">
        <h1>Admin</h1>
        <div class="panel">
          <a href="admingebruiker.php">
            <div class="adminOptions">
              <h3>Gebruikers</h3>
              <div class="adminImage" style="background-image:url('resources/login.svg')"></div>
            </div>
          </a>
          <a href="adminorders.php">
            <div class="adminOptions">
              <h3>Bestellingen</h3>
              <div class="adminImage" style="background-image:url('resources/cart.svg')"></div>
            </div>
          </a>
          <a href="addproduct.php">
            <div class="adminOptions">
              <h3>Product toevoegen</h3>
              <div class="adminImage" style="background-image:url('resources/prodsadd.svg')"></div>
            </div>
          </a>
          <a href="adminproducten.php">
            <div class="adminOptions">
              <h3>Producten</h3>
              <div class="adminImage" style="background-image:url('resources/prods.svg')"></div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>

</html>

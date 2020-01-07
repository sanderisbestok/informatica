<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         404.php
Description;  Page shown when page is not found.
Usage; n/a
-->
<?php
  include_once('./globalUI/globalConnect.php');
?>

<!DOCTYPE html>
<html lang="nl">
  <head>
    <?php include('./globalUI/globalReqs.php'); ?>
    <title>404 Pagina niet gevonden</title>
    <link rel="stylesheet" href="style/product.css" />
  </head>

  <body>
    <?php include('./globalUI/header.php');?>

    <div class="container">
      <div class="content">
        <h1>Pagina niet gevonden</h1>
        <p>De pagina die u zocht kon helaas niet worden gevonden.</p>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>

</html>

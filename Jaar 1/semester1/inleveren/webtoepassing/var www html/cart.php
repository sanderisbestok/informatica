<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         cart.php
Description;  Menu for users without javascript
Usage;        Use one of the options in the menu
-->

<?php include_once("./globalUI/globalConnect.php") ?>
<?php include_once("./stools/cartTools.php") ?>

<html lang="nl">
  <head>
    <title>Stuffz</title>
    <?php include('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/frontpage.css" />
    <link rel="stylesheet" href="style/product.css" />
    <link rel="stylesheet" href="style/slider.css" />
  </head>

  <body>
    <?php include('./globalUI/header.php'); ?>
    <div class="container">
      <div class="content">

        <div id="userPopup" class="popOver permanent">
          <div id="popCart">
            <ul class="popCart">

            <?php
                /* Gets cart */
                genHCart();
             ?>
           </ul>
           </div>
           <div class="popOptions">
               <ul class="popOList">
                   <li>
                <a href="winkelwagen.php">
                  <div class="actionElem popOItem cart">
                    <span class="popListIText">Winkelwagen</span>
                  </div>
                </a>
              </li>
              <?php
                /* Gets the options that should be shown for the user in this menu */
                if($user_didLogin){
                  echo"
                  <li>
                    <a href='orderhistorie.php'>
                      <div class='actionElem popOItem hist'>
                        <span class='popListIText'>Bestellingen</span>
                      </div>
                    </a>
                  </li>";
                }
                if($user_didLogin){
                  echo "
                  <li>
                    <a href='gebruiker.php'>
                      <div class='actionElem popOItem acc'>
                        <span class='popListIText'>Account</span>
                      </div>
                    </a>
                  </li>";
                }
                if(intval($privlevel) > 0){
                  echo "
                    <li><a href='admin.php'>
                      <div class='actionElem popOItem acc'>
                        <span class='popListIText'>Admin</span>
                      </div>
                    </a></li>";
                }
              ?>
              <?php loginLogout(); ?>
            </ul>
          </div>
      </div>
    </div>
  </div>
  <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         admingebruiker.php
Description;  List of all the registrated users
Usage;        Press next or previous page to switch between pages of the list or
              type the surname of the person you are looking for in the search field
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
  if(intval($privlevel) < 4){
    header("Location: index.php");
  }

  /* Counter for setting the users displayed on a page */
  $sqlcount = "SELECT COUNT(user_id) FROM users";
  $querycount = $globalDB->prepare($sqlcount);
  $querycount->execute();
  $countin = $querycount->fetch();
  $count = $countin[0];
  $usersperpage = 20;
  $userstart = 0;
  $pagecount = ceil($count / $usersperpage);
  $next = false;
  $previous = false;
  $nextpage = 1;
  $previouspage = 1;
  /* Checks if the current page has a previous or next page and redirects users
     when pages the don't exist are requested */
  if(isset($_GET['page'])) {
    $page = intval(htmlspecialchars($_GET['page']));
    if ($pagecount < $page) {
      header("Location: admingebruiker.php?page=$pagecount");
      die();
    } else if ($page < 1) {
      header("Location: admingebruiker.php?page=1");
      die();
    } else {
      $userstart = ($page - 1) * $usersperpage;
      if($page < $pagecount) {
        $next = true;
        $nextpage = $page + 1;
      }
      if($page > 1) {
        $previous = true;
        $previouspage = $page - 1;
      }
      if($page >= $pagecount) {
        $next = false;
      }
      if($page <= 1) {
        $previous = false;
      }
    }
  } else {
    header("Location: admingebruiker.php?page=1");
    die();
  }
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Gebruikersgegevens</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/product.css" />
    <link rel="stylesheet" href="style/adminuser.css" />

  </head>

  <body>
    <?php
      include ('./globalUI/header.php');
    ?>

    <!-- Link to script for the search field -->
    <script src="scripts/search.js"></script>

    <div class="container">
      <div class="content order-history">
        <h1>Gebruikers</h1>
        <a href="admin.php" class="backtoadmin">Terug</a>
        <!-- form with input field for searches -->
        <form name="search" id="search" class="searchnames" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          Zoek op achternaam: <input type="text" id="searchSurnames" class="searchnames" name="searchSurnames" onkeyup="getNames(this.value)" onchange="getNames(this.value)" />
        </form>
          <!-- Table with the users that should be displayed on the current page -->
          <table class="orderedproducts">
            <thead>
              <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Geboortedatum</th>
                <th>Geslacht</th>
                <th>Adres</th>
                <th>E-mailadres</th>
                <th>Telefoonnummer</th>
                <th>Level</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $sql = "SELECT user_id, first_name, prefix, surname, date_birth, sex, email, phone, privilege_level, address_id FROM users ORDER BY user_id LIMIT $userstart, $usersperpage";
                  $query = $globalDB->prepare($sql);
                  $query->execute();
                  $data = $query->fetchAll();
                  foreach($data as $user){
                    $name = "";
                    if (empty($user[2])) {
                      $name = "" . $user[1] . " " . $user[3];
                    } else {
                      $name = "" . $user[1] . " " . $user[2] . " " . $user[3];
                    }
                    $sqladd = "SELECT street, number, addition, postcode, city FROM addresses WHERE address_id = '$user[9]'";
                    $queryadd = $globalDB->prepare($sqladd);
                    $queryadd->execute();
                    $address = $queryadd->fetch();
                    $addressvalue = "";
                    if (empty($address[2])) {
                      $addressvalue = "" . $address[0] . " " . $address[1] . ", " . $address[3] . " " . $address[4];
                    } else {
                      $addressvalue = "" . $address[0] . " " . $address[1] . " " . $address[2] . ", " . $address[3] . " " . $address[4];
                    }
                    $parts = explode('-', $user[4]);
                    $birthday = "" . $parts[2] . "-" . $parts[1] . "-" . $parts[0];
                    if ($user[5] == "male") {
                      $sex = "Man";
                    } else {
                      $sex = "Vrouw";
                    }
                    /* Prints the rows with information about the user */
                    print('
                      <tr class="table-row" name="user_rowall" onclick=window.location.href="admingegevens.php?user_id='.$user[0].'">
                        <td data-label=ID>'.$user[0].'</td>
                        <td data-label=Naam>'.$name.'</td>
                        <td data-label=Geboortedatum>'.$birthday.'</td>
                        <td data-label=Geslacht>'.$sex.'</td>
                        <td data-label=Adres>'.$addressvalue.'</td>
                        <td data-label=E-mailadres>'.$user[6].'</td>
                        <td data-label=Telefoonnumer>'.$user[7].'</td>
                        <td data-label=Level>'.$user[8].'</td>
                      </tr>
                    ');
                  }

              ?>
            </tbody>
            <tbody class="searchNames"></tbody>
          </table>
        <div class="row">
          <!-- Links to switch between pages -->
          <div class="c-12" id="switchpage">
            <a class="previous" <?php echo ($previous==false)?'hidden':'' ?> href="admingebruiker.php?page=<?php echo $previouspage; ?>">Vorige pagina</a>
            <a class="next" <?php echo ($next==false)?'hidden':'' ?> href="admingebruiker.php?page=<?php echo $nextpage; ?>">Volgende pagina</a>
          </div>
        </div>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

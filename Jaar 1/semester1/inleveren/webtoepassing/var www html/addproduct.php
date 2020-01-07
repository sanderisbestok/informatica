<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         addproduct.php
Description;  Add new products to the database
Usage;        Fill the input fields with the required data and press the submit button when you're done
-->

<?php include('./globalUI/globalConnect.php'); ?>

<?php
  /* Checks if the user is logged in */
  if(empty($_SESSION["user_id"])){
    header("Location: inlogpagina.php");
    die();
  }

  /* Checks if the user has the right privilege level */
  $sqlpriv = "SELECT privilege_level FROM users WHERE user_id = '$_SESSION[user_id]'";
  $querypriv = $globalDB->prepare($sqlpriv);
  $querypriv->execute();
  $priv = $querypriv->fetch();
  $privlevel = $priv[0];
  if(intval($privlevel) < 9){
    header("Location: index.php");
  }
?>

<?php
  /* Tests the input from the user */
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /* Redirects the user when the product is added to the database */
  function redirect() {
    header("Location: admin.php");
    die();
  }
?>
<?php
  /* Gives values to the php variables */
  $catinput = $productname = $descrip = $spec = $spec2 = $spec3 = $specvalue = $specvalue2 = $specvalue3 = $price = "";
  $catinputErr = $productnameErr = $descripErr = $specErr = $specvalueErr = $priceErr = false;
  $visible = 0;
  $numberOfSpecs = 0;
  $specCount = 0;
  $choosecat = "";
  $prodErr = $newcatErr = "";
  $imageErr1 = $imageErr3 = $imageErr4 = $imageErr5 = "";

/* Starts when submit button is clicked */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $allcorrect = True;
  $catinputErr = $productnameErr = $descripErr = $specErr = $specvalueErr = false;
  $specErr2 = $specvalueErr2 = $specErr3 = $specvalueErr3 = $priceErr = false;
  $prodErr = $newcatErr = "";

  /* Checks if the new category is valid */
  $choosecat = test_input($_POST["choosecat"]);
  if ($choosecat == 'newcat') {
    $catinput = test_input($_POST["catinput"]);
    if (strlen($catinput) < 2) {
        $allcorrect = False;
        $catinputErr = true;
    } else {
      /* Checks if the category already exists */
      $catquery = $globalDB->prepare('SELECT category_name FROM categories WHERE category_name = :category_name');
      $catquery->execute(array(':category_name' => $catinput));
      $row = $catquery->fetch(PDO::FETCH_ASSOC);
      if(!empty($row['category_name'])){
        $newcatErr = "Deze categorie bestaat al";
        $allcorrect = False;
      }
    }
  }

  /* Checks if visible is valid */
  if (empty($_POST["visible"])) {
    $allcorrect = False;
  } else {
    if($_POST["visible"] === 1 || $_POST["visible"] === 0) {
      $visible = $_POST["visible"];
    }
  }

  /* Checks if the productname is valid */
  if (strlen($_POST["productname"]) < 2) {
    $productname = test_input($_POST["productname"]);
    $allcorrect = False;
    $productnameErr = true;
  } else {
    $productname = test_input($_POST["productname"]);
    /* Checks if the productname already exists */
    $prodquery = $globalDB->prepare('SELECT name FROM products WHERE name = :name');
    $prodquery->execute(array(':name' => $productname));
    $row = $prodquery->fetch(PDO::FETCH_ASSOC);
    if(!empty($row['name'])){
      $prodErr = "Dit product bestaat al";
      $allcorrect = False;
    }
  }

  /* Checks if the description is valid */
  if (strlen($_POST["descrip"]) < 2) {
    $descrip = test_input($_POST["descrip"]);
    $allcorrect = False;
    $descripErr = true;
  } else {
    $descrip = test_input($_POST["descrip"]);
  }

  /* Checks if all the specs are valid */
  $specCount = test_input($_POST["numberOfSpecs"]);
  for ($i = 0; $i < $specCount; $i++) {
    $spec = test_input($_POST["spec".$i]);
    if (strlen($spec) < 2) {
      $allcorrect = False;
    }
    $specvalue = test_input($_POST["specvalue".$i]);
    if (strlen($specvalue) < 2) {
      $allcorrect = False;
    }
  }

  /* Checks if the price is valid */
  if (strlen($_POST["price"]) < 4) {
    $price = test_input($_POST["price"]);
    $allcorrect = False;
    $priceErr = true;
  } else {
    $price = test_input($_POST["price"]);
    if (!preg_match("/^\d+(,\d{2})?$/", $price)) {
      $allcorrect = False;
      $priceErr = true;
    }
  }
  
  $imageErr1 = $imageErr3 = $imageErr4 = $imageErr5 = "";
  $oldimage = false;
  if (empty($_FILES)) {
    $allcorrect = False;
    $imageErr5 = "U heeft nog geen afbeelding gekozen";
  } else {
    /* Set the path for the image */
    $target_dir = "resources/products/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    /* Checks if the image file is a actual image or fake image */
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $imageErr1 = "Dit is geen afbeelding";
        $uploadOk = 0;
        $allcorrect = False;
    }
    /* Checks if the file already exists */
    if (file_exists($target_file)) {
        $oldimage = true;
    }
    /* Checks the file size */
    if ($_FILES["fileToUpload"]["size"] > 300000) {
        $imageErr3 = "Deze afbeelding is te groot";
        $uploadOk = 0;
        $allcorrect = False;
    }
    /* Allows certain file formats */
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $imageErr4 = "Alleen JPG, JPEG, PNG en GIF bestanden zijn toegestaan";
        $uploadOk = 0;
        $allcorrect = False;
    }
    /* Checks if $uploadOk is set to 0 by an error */
    if ($uploadOk == 0) {
      $allcorrect = False;
    }
  }

  /* Starts putting the data into the database if no errors occured */
  if ($allcorrect) {
    $cat_id = 1;

    /* Inserts new category and gets the id */
    if ($choosecat == "newcat") {
      $sqlcat = "INSERT INTO categories (category_name)
                  VALUES (:name)";
      $querycat = $globalDB->prepare($sqlcat);
      $querycat->execute(array(
        ':name' => $catinput
      ));
      $sqlid = "SELECT category_id FROM categories WHERE category_id = LAST_INSERT_ID()";
      $queryid = $globalDB->prepare($sqlid);
      $queryid->execute();
      $catidvalue = $queryid->fetch();
      $cat_id = $catidvalue[0];
    /* Gets the id of an already existing category */
    } else {
      $sqlcatid = "SELECT category_id FROM categories WHERE category_name = :category_name";
      $querycatid = $globalDB->prepare($sqlcatid);
      $querycatid->execute(array(':category_name' => $choosecat));
      $categidvalue = $querycatid->fetch();
      $cat_id = $categidvalue[0];
    }

    /* Inserts data into the products table */
    $productsql = "INSERT INTO products (name, description, category_id, visible, supply)
                VALUES (:name, :description, :category_id, :visible, :supply)";
    $productquery = $globalDB->prepare($productsql);
    $productquery->execute(array(
      ':name' => $productname,
      ':description' => $descrip,
      ':category_id' => $cat_id,
      ':visible' => $visible,
      ':supply' => 100
    ));

    /* Gets the id of the product */
    $sqlprodid = "SELECT product_id FROM products WHERE product_id = LAST_INSERT_ID()";
    $queryprodid = $globalDB->prepare($sqlprodid);
    $queryprodid->execute();
    $prodidvalue = $queryprodid->fetch();
    $product_id = $prodidvalue[0];

    /* Updates the serialnumber to the value of the product_id */
    $sersql = "UPDATE products SET serial_number = '$product_id' WHERE product_id = '$product_id' LIMIT 1";
    $serquery = $globalDB->prepare($sersql);
    $serquery->execute();

    /* Inserts all the specs */
    for ($i = 0; $i < $specCount; $i++) {
      $spec = test_input($_POST["spec$i"]);
      $specvalue = test_input($_POST["specvalue$i"]);

      /* Checks if the spec already exists */
      $sqlspecid = "SELECT spec_id FROM specs WHERE spec_name = :spec_name";
      $queryspecid = $globalDB->prepare($sqlspecid);
      $queryspecid->execute(array(':spec_name' => $spec));
      $specidvalue = $queryspecid->fetch();

      /* Only inserts the specvalue when the spec already exists */
      if (!empty($specidvalue[0])) {
        $spec_id = $specidvalue[0];
        $loadvalsql = "INSERT INTO spec_values (value_char)
                    VALUES (:value_char)";
        $loadvalquery = $globalDB->prepare($loadvalsql);
        $loadvalquery->execute(array(':value_char' => $specvalue));

        $specprodssql = "INSERT INTO products_specs (product_id, spec_id, value_id, visible)
                          VALUES (:product_id, :spec_id, (SELECT value_id FROM spec_values WHERE value_id = LAST_INSERT_ID()))";
        $specprodquery = $globalDB->prepare($specprodssql);
        $specprodquery->execute(array(
          ':product_id' => $product_id,
          ':spec_id' => $spec_id
        ));
      /* Inserts the spec value and the spec */
      } else {
        $loadsql = "INSERT INTO specs (spec_name)
                    VALUES (:spec_name)";
        $loadquery = $globalDB->prepare($loadsql);
        $loadquery->execute(array(':spec_name' => $spec));

        $sqlnewspecid = "SELECT spec_id FROM specs WHERE spec_id = LAST_INSERT_ID()";
        $querynewspecid = $globalDB->prepare($sqlnewspecid);
        $querynewspecid->execute();
        $newspecidvalue = $querynewspecid->fetch();
        $newspecid = $newspecidvalue[0];

        $loadvalsql = "INSERT INTO spec_values (value_char)
                    VALUES (:value_char)";
        $loadvalquery = $globalDB->prepare($loadvalsql);
        $loadvalquery->execute(array(':value_char' => $specvalue));

        $specprodssql = "INSERT INTO products_specs (product_id, spec_id, value_id)
                          VALUES (:product_id, :spec_id, (SELECT value_id FROM spec_values WHERE value_id = LAST_INSERT_ID()))";
        $specprodquery = $globalDB->prepare($specprodssql);
        $specprodquery->execute(array(
          ':product_id' => $product_id,
          ':spec_id' => $newspecid
        ));
      }
    }

    /* Changes price from euros to eurocents and inserts it into the prices table */
    $pricewithdot = str_replace(',', '.', $price);
    $newprice = intval($pricewithdot * 100);
    $pricesql = "INSERT INTO prices (price, time_set, product_id)
                VALUES (:price, (NOW()), :product_id)";
    $pricequery = $globalDB->prepare($pricesql);
    $pricequery->execute(array(
      ':price' => $newprice,
      ':product_id' => $product_id
    ));

    if ($oldimage == true) {
      /* Inserts path to the uploaded image into the media table */
      $mediasql = "INSERT INTO media (path, name)
                  VALUES (:path, :name)";
      $mediaquery = $globalDB->prepare($mediasql);
      $mediaquery->execute(array(
        ':path' => $target_file,
        ':name' => $productname
      ));

      /* Links media table with products table */
      $prodmedsql = "INSERT INTO products_media (product_id, media_id)
                  VALUES (:product_id, (SELECT media_id FROM media WHERE name = '$productname'))";
      $prodmedquery = $globalDB->prepare($prodmedsql);
      $prodmedquery->execute(array(
        ':product_id' => $product_id
      ));
    } else {
      /* Add uploaded images */
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

      /* Inserts path to the uploaded image into the media table */
      $mediasql = "INSERT INTO media (path, name)
                  VALUES (:path, :name)";
      $mediaquery = $globalDB->prepare($mediasql);
      $mediaquery->execute(array(
        ':path' => $target_file,
        ':name' => $productname
      ));

      /* Links media table with products table */
      $prodmedsql = "INSERT INTO products_media (product_id, media_id)
                  VALUES (:product_id, (SELECT media_id FROM media WHERE name = '$productname'))";
      $prodmedquery = $globalDB->prepare($prodmedsql);
      $prodmedquery->execute(array(
        ':product_id' => $product_id
      ));

    }

    redirect();
  }
}
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Producten toevoegen</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/adminproduct.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>

  <!-- Sets display of javascript errors to none -->
  <body onload="setaddproduct()">
    <?php
      include ('./globalUI/header.php');
    ?>

    <div class="container">
      <div class="content">
        <h1>Product toevoegen</h1>
        <form name="addproduct" class="addproductform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
          <h3>Categorie</h3>
          <table>
            <tr>
              <td>Kies een categorie:
                <select name="choosecat" id="choosecat" onclick="opencatinput()" onchange="opencatinput()">
                  <?php
                  /* Retrieves all the categories and puts them into options */
                  $sql = "SELECT category_name FROM categories";
                  $query = $globalDB->prepare($sql);
                  $query->execute();
                  $data = $query->fetchAll();
                  foreach($data as $cat) {
                    $selected = "";
                    if($choosecat==$cat[0]){
                      $selected = "selected";
                    }
                    print ('<option '.$selected.' value="'.$cat[0].'">'.$cat[0].'</option>');
                  }
                   ?>

                  <option <?php if($choosecat == "newcat") {echo 'selected';} ?> value="newcat">Nieuwe categorie</option>
                </select>
              </td>
            </tr>
            <tr>
              <!-- Input field that only appears when the option 'new category' is chosen -->
              <td><input class="catinput" style="<?php if($choosecat == "newcat") {echo 'display: block;';} else {echo 'display: none;';} ?>" value="<?php echo $catinput; ?>" id="catinput" type="text" name="catinput" onkeyup="catValid()" onclick"catValid()" onchange="catValid()" /></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle"><?php echo $newcatErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" id="catinputErr">Ongeldige categorienaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($catinputErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige categorienaam</td>
            </tr>
          </table>
          <h3>Zichtbaarheid</h3>
            <input type="radio" name="visible" value="1" <?php if($visible == 1) {echo 'checked="checked"';} ?> />Zichtbaar <br/>
            <input type="radio" name="visible" value="0" <?php if($visible == 0) {echo 'checked="checked"';} ?> />Onzichtbaar <br/>
          <h3>Product</h3>
          <table>
            <tr>
              <td class="dataname">Naam</td>
            </tr>
            <!-- Input field for the product name -->
            <tr>
              <td><input value="<?php echo $productname; ?>" id="productname" type="text" name="productname" onkeyup="productnameValid()" onclick"productnameValid()" onchange="productnameValid()" /></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle"><?php echo $prodErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" id="productnameErr">Ongeldige productnaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($productnameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige productnaam</td>
            </tr>
            <tr>
              <td class="dataname">Beschrijving</td>
            </tr>
            <!-- Input field for the description -->
            <tr>
              <td><textarea rows="20" cols="37" class="descrip" id="descrip" type="text" name="descrip" value="<?php echo $descrip; ?>" onkeyup="descripValid()" onclick"descripValid()" onchange="descripValid()"><?php echo $descrip; ?></textarea></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="descripErr">Ongeldige beschrijving</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($descripErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige beschrijving</td>
            </tr>
            <tr>
              <td class="dataname">Specificaties</td>
            </tr>
          </table>
          <!-- Table with variable number of specs -->
          <table class="specsTable" id="specsTable">
            <?php
            for($i = 0; $i < 3; $i++) {
              $numberOfSpecs++;
              /* Inputfields for specs and specvalues and the errormessaging rows for each input field */
              print ('
              <tr>
                <td><input class="movespecs2" id="spec'.$i.'" name="spec'.$i.'" type="text" placeholder="Dichtheid kg*m^-3" onkeyup="newspecValid('.$i.')" onclick"newspecValid('.$i.')" onchange="newspecValid('.$i.')" /></td>
                <td><input class="movespecs" id="specvalue'.$i.'" name="specvalue'.$i.'" type="text" placeholder="12,55" onkeyup="newspecvalueValid('.$i.')" onclick"newspecvalueValid('.$i.')" onchange="newspecvalueValid('.$i.')" /></td>
              </tr>
              <tr>
                <td class="errorstyle" style="display: none;" id="specErr'.$i.'">Ongeldige specificatie</td>
              </tr>
              <tr>
                <td class="errorstyle" style="display: none;" id="specvalueErr'.$i.'">Ongeldige specificatiewaarde</td>
              </tr>
              ');
            }
            print ('
              <tr>
                <input type="text" style="display: none;" name="numberOfSpecs" id="numberOfSpecs" value="'.$numberOfSpecs.'" />
              </tr>
            ')
             ?>
            <!-- Links to delete and add rows -->
            <tr class="changespecsrow">
              <td><a class="addspec green" onclick="addInput()">+</a></td>
              <td><a class="removespec red" onclick="removeInput()">-</a></td>
            </tr>
          </table>
          <table>
            <tr>
              <td class="dataname">Prijs</td>
            </tr>
            <!-- Input field for the price -->
            <tr>
              <td><input value="<?php echo $price; ?>" type="text" id="price" name="price" placeholder="19,99" onkeyup="priceValid()" onclick"priceValid()" onchange="priceValid()" /></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="priceErr">Ongeldige prijs</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($priceErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige prijs</td>
            </tr>
            <tr>
              <td>Afbeelding</td>
            </tr>
            <!-- Upload field for images -->
            <tr>
              <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle"><?php echo $imageErr1; ?></td>
            </tr>
            <tr>
              <td class="errorstyle"><?php echo $imageErr3; ?></td>
            </tr>
            <tr>
              <td class="errorstyle"><?php echo $imageErr4; ?></td>
            </tr>
            <tr>
              <td class="errorstyle"><?php echo $imageErr5; ?></td>
            </tr>
          </table>
          <!-- Submit and cancel button -->
          <table>
              <tr>
                <td><a class="discardchanges" href="admin.php">Annuleer</a></td>
                <td><button class="savechanges" type="submit" id="register" onclick="addproductvalidator()">Voeg toe</button></td>
              </tr>
          </table>
        </form>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

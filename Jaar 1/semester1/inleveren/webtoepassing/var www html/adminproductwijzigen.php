<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         adminproductwijzigen.php
Description;  Change the information about a product
Usage;        Fill in the input fields and press submit to change the information about a product
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
  $product_id = "";
  /* Checks which product should be changed and saves it in the session */
  if(!isset($_GET['product_id'])) {
    if(empty($_SESSION['product_to_change'])) {
      header('Location: adminproducten.php');
      die();
    } else {
      $product_id = $_SESSION['product_to_change'];
      $id2query = $globalDB->prepare('SELECT product_id FROM products WHERE product_id = :product_id');
      $id2query->execute(array(':product_id' => $_SESSION['product_to_change']));
      $row2 = $id2query->fetch(PDO::FETCH_ASSOC);
      if (empty($row2['product_id'])) {
        header('Location: adminproducten.php');
        die();
      }
    }
  } else {
    $product_id = $_GET['product_id'];
    $idquery = $globalDB->prepare('SELECT product_id FROM products WHERE product_id = :product_id');
    $idquery->execute(array(':product_id' => $_GET['product_id']));
    $row = $idquery->fetch(PDO::FETCH_ASSOC);
    if (!empty($row['product_id'])) {
      $_SESSION['product_to_change'] = $product_id;
    } else {
      header('Location: adminproducten.php');
      die();
    }
  }

?>
<!-- Gets the information about a product from the database -->
<?php
  $stmt = $globalDB->prepare("SELECT serial_number FROM products WHERE product_id = '$product_id'");
  $stmt->execute();
  $serialnumberin = $stmt->fetch(PDO::FETCH_NUM);
  $serial_number = $serialnumberin[0];

  $stmt = $globalDB->prepare("SELECT visible FROM products WHERE product_id = '$product_id'");
  $stmt->execute();
  $visiblein = $stmt->fetch(PDO::FETCH_NUM);
  $visible = $visiblein[0];

  $stmt = $globalDB->prepare("SELECT name FROM products WHERE product_id = '$product_id'");
  $stmt->execute();
  $namein = $stmt->fetch(PDO::FETCH_NUM);
  $name = $namein[0];

  $stmt = $globalDB->prepare("SELECT description FROM products WHERE product_id = '$product_id'");
  $stmt->execute();
  $descin = $stmt->fetch(PDO::FETCH_NUM);
  $description = $descin[0];

  $stmt = $globalDB->prepare("SELECT supply FROM products WHERE product_id = '$product_id'");
  $stmt->execute();
  $supplyin = $stmt->fetch(PDO::FETCH_NUM);
  $supply = $supplyin[0];

  $stmt = $globalDB->prepare("SELECT category_name FROM products INNER JOIN categories ON products.category_id = categories.category_id WHERE product_id = '$product_id'");
  $stmt->execute();
  $catin = $stmt->fetch(PDO::FETCH_NUM);
  $category_name = $catin[0];

  $stmt = $globalDB->prepare("SELECT price FROM prices WHERE product_id = '$product_id'");
  $stmt->execute();
  $pricein = $stmt->fetch(PDO::FETCH_NUM);
  $dataprice = $pricein[0];
  $euros = floor($dataprice / 100);
  $cents = substr($dataprice, -2);
  $price = "" . $euros . "," . $cents;

  $stmt = $globalDB->prepare("SELECT spec_id, value_id FROM products_specs WHERE product_id = '$product_id'");
  $stmt->execute();
  $allspecs = $stmt->fetchAll();
?>
<?php
  /* Sanitizes the input */
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /* Redirects the user when the information is changed in the database */
  function redirect() {
    header("Location: adminproducten.php");
    die();
  }
?>
<?php
/* Sets errorvariables */
$serialErr = $nameErr = $descErr = $supplyErr = $catinputErr = $priceErr = false;
$serErr = $productnameErr = $newcatErr = "";
$imageErr1 = $imageErr3 = $imageErr4 = $imageErr5 = "";
$catinput = "";
$numberOfSpecs = 0;
$specCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $serialErr = $nameErr = $descErr = $supplyErr = $catinputErr = $priceErr = false;
  $allcorrect = True;
  $serErr = $productnameErr = $newcatErr = "";

  /* Checks if the serial number is valid */
  if (empty($_POST["serial_number"])) {
    $allcorrect = False;
    $serialErr = true;
  } else {
    $serial_number = test_input($_POST["serial_number"]);
    $stmt = $globalDB->prepare("SELECT serial_number FROM products WHERE product_id = '$product_id'");
    $stmt->execute();
    $serialtestin = $stmt->fetch(PDO::FETCH_NUM);
    $serialtest = $serialtestin[0];
    if ($serial_number != $serialtest) {
      $serquery = $globalDB->prepare('SELECT serial_number FROM products WHERE serial_number = :serial_number');
      $serquery->execute(array(':serial_number' => $serial_number));
      $serrow = $serquery->fetch(PDO::FETCH_ASSOC);
      if(!empty($serrow['serial_number'])){
          $serErr = "Dit artikelnummer is al in gebruik";
          $allcorrect = False;
      }
    }
  }

  /* Checks if the productname is valid */
  if (empty($_POST["name"])) {
    $allcorrect = False;
    $nameErr = true;
  } else {
    $name = test_input($_POST["name"]);
    if (strlen($name) < 2) {
      $allcorrect = False;
      $serialErr = true;
    } else {
      $stmt = $globalDB->prepare("SELECT name FROM products WHERE product_id = '$product_id'");
      $stmt->execute();
      $nametestin = $stmt->fetch(PDO::FETCH_NUM);
      $nametest = $nametestin[0];
      if ($name != $nametest) {
        $prodquery = $globalDB->prepare('SELECT name FROM products WHERE name = :name');
        $prodquery->execute(array(':name' => $productname));
        $namerow = $prodquery->fetch(PDO::FETCH_ASSOC);
        if(!empty($namerow['name'])){
          $productnameErr = "Dit product bestaat al";
          $allcorrect = False;
        }
      }
    }
  }

  /* Checks if visible is valid */
  if (!isset($_POST["visible"])) {
    $allcorrect = False;
  } else {
    if($_POST["visible"] == 1 || $_POST["visible"] == 0) {
      $visible = $_POST["visible"];
    }
  }

  /* Checks if the description is valid */
  if (strlen($_POST["description"]) < 2) {
    $description = test_input($_POST["description"]);
    $allcorrect = False;
    $descErr = true;
  } else {
    $description = test_input($_POST["description"]);
  }

  /* Checks if the supply is valid */
  if (empty($_POST["supply"])) {
    $allcorrect = False;
    $supplyErr = true;
  } else {
    $supply = test_input($_POST["supply"]);
    if (!preg_match("/^[0-9]*$/", $supply)) {
      $allcorrect = False;
      $supplyErr = true;
    }
  }

  /* Checks if the category name is valid */
  $category_name = test_input($_POST["category_name"]);
  if ($category_name == 'newcat') {
    $catinput = test_input($_POST["catinput"]);
    if (strlen($catinput) < 2) {
        $allcorrect = False;
        $catinputErr = true;
    } else {
      $catquery = $globalDB->prepare('SELECT category_name FROM categories WHERE category_name = :category_name');
      $catquery->execute(array(':category_name' => $catinput));
      $row = $catquery->fetch(PDO::FETCH_ASSOC);
      if(!empty($row['category_name'])){
        $newcatErr = "Deze categorie bestaat al";
        $allcorrect = False;
      }
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

  $imageErr1 = $imageErr3 = $imageErr4 = $imageErr5 = "";
  $newimage = true;
  $oldimage = false;
  if (empty($_FILES)) {
    $newimage = false;
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

  /* If no errors occured the data is put into the database */
  if($allcorrect) {
    $category_id = 1;

    /* Add new image and add link to that image */
    if ($newimage == true) {
      $sqlimage = "DELETE FROM media WHERE name = :name";
      $queryimage = $globalDB->prepare($sqlimage);
      $queryimage->execute(array(':name' => $name));
      /* Add uploaded images */
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

      /* Inserts path to the uploaded image into the media table */
      $mediasql = "UPDATE media SET path = :pathtoimage WHERE name = '$name'";
      $mediaquery = $globalDB->prepare($mediasql);
      $mediaquery->execute(array(
        ':pathtoimage' => $target_file
      ));
    }
    /* Adds link to image that already exists */
    if ($oldimage == true) {
      $sqlimage = "DELETE FROM media WHERE name = :name";
      $queryimage = $globalDB->prepare($sqlimage);
      $queryimage->execute(array(':name' => $name));
      /* Inserts path to the uploaded image into the media table */
      $mediasql = "UPDATE media SET path = :pathtoimage WHERE name = '$name'";
      $mediaquery = $globalDB->prepare($mediasql);
      $mediaquery->execute(array(
        ':pathtoimage' => $target_file
      ));
    }


    $choosecat = test_input($_POST["category_name"]);
    /* Makes new category and gets the id */
    if ($choosecat == "newcat") {
      $catinput = test_input($_POST["catinput"]);
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
      $category_id = $catidvalue[0];
      /* Gets the id of an already existing category */
    } else {
      $sqlcatid = "SELECT category_id FROM categories WHERE category_name = :category_name";
      $querycatid = $globalDB->prepare($sqlcatid);
      $querycatid->execute(array(':category_name' => $category_name));
      $categidvalue = $querycatid->fetch();
      $category_id = $categidvalue[0];
    }

    /* Updates information about the product */
    $sqlprod = "UPDATE products SET serial_number = :serial_number,
                             name = :name,
                             description = :description,
                             category_id = :category_id,
                             supply = :supply,
                             visible = :visible
                             WHERE product_id='$product_id' LIMIT 1";
    $queryprod = $globalDB->prepare($sqlprod);
    $queryprod->execute(array(
      ':serial_number' => $serial_number,
      ':name' => $name,
      ':description' => $description,
      ':category_id' => $category_id,
      ':supply' => $supply,
      ':visible' => $visible
    ));

    /* Updates price in database */
    $pricewithdot = str_replace(',', '.', $price);
    $newprice = intval($pricewithdot * 100);
    $sqlprice = "UPDATE prices SET price = :price,
                                        time_set = (NOW())
                                        WHERE product_id='$product_id' LIMIT 1";
    $queryprice = $globalDB->prepare($sqlprice);
    $queryprice->execute(array(
      ':price' => $newprice
    ));

    $sqlgetid = "SELECT value_id FROM products_specs WHERE product_id = :product_id";
    $querygetid = $globalDB->prepare($sqlgetid);
    $querygetid->execute(array(':product_id' => $product_id));
    $getidvalue = $querygetid->fetchAll();

    /* Deletes old specvalues */
    foreach ($getidvalue as $row) {
      $sqldel2 = "DELETE FROM spec_values WHERE value_id = :value_id";
      $querydel2 = $globalDB->prepare($sqldel2);
      $querydel2->execute(array(':value_id' => $row[0]));
    }

    /* Add specs and spec values to database */
    for ($i = 0; $i < $specCount; $i++) {
      $spec = test_input($_POST["spec$i"]);
      $specvalue = test_input($_POST["specvalue$i"]);

      $sqlspecid = "SELECT spec_id FROM specs WHERE spec_name = :spec_name";
      $queryspecid = $globalDB->prepare($sqlspecid);
      $queryspecid->execute(array(':spec_name' => $spec));
      $specidvalue = $queryspecid->fetch();

      /* Only inserts specvalue when spec already exists */
      if (!empty($specidvalue[0])) {
        $spec_id = $specidvalue[0];
        $loadvalsql = "INSERT INTO spec_values (value_char)
                    VALUES (:value_char)";
        $loadvalquery = $globalDB->prepare($loadvalsql);
        $loadvalquery->execute(array(':value_char' => $specvalue));

        $specprodssql = "INSERT INTO products_specs (product_id, spec_id, value_id)
                          VALUES (:product_id, :spec_id, (SELECT value_id FROM spec_values WHERE value_id = LAST_INSERT_ID()))";
        $specprodquery = $globalDB->prepare($specprodssql);
        $specprodquery->execute(array(
          ':product_id' => $product_id,
          ':spec_id' => $spec_id
        ));
      /* Inserst both specvalue and spec when the spec doesn't already exist */
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

    redirect();
  }
}
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Productgegevens wijzigen</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/adminproduct.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
  </head>

  <!-- Sets display of javascript errors to none -->
  <body onload="seteditproduct()">
    <?php
      include ('./globalUI/header.php');
    ?>

    <div class="container">
      <div class="content">
        <h1>Productgegevens wijzigen</h1>
        <form name="editproduct" class="addproductform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <h3>Categorie</h3>
          <table>
            <tr>
              <td>Kies een categorie:
                <select name="category_name" id="choosecat" onclick="opencatinput()" onchange="opencatinput()">
                  <?php
                  /* Retrieves all categories */
                  $stmt = $globalDB->prepare("SELECT category_name FROM products INNER JOIN categories ON products.category_id = categories.category_id WHERE product_id = '$product_id'");
                  $stmt->execute();
                  $catin = $stmt->fetch(PDO::FETCH_NUM);
                  $category_name = $catin[0];
                  $sql = "SELECT category_name FROM categories";
                  $query = $globalDB->prepare($sql);
                  $query->execute();
                  $data = $query->fetchAll();
                  foreach($data as $cat) {
                    $selected = "";
                    if($cat[0] == $category_name){
                      $selected = "selected";
                    } else {
                      $selected = "";
                    }
                    print ('<option '.$selected.' value="'.$cat[0].'">'.$cat[0].'</option>');
                  }
                   ?>
                  <option <?php if($category_name == "newcat") {echo 'selected';} ?> value="newcat">Nieuwe categorie</option>
                </select>
              </td>
            </tr>
            <!-- Input field that only opens when 'new category' is chosen -->
            <tr>
              <td><input class="catinput" style="<?php if($category_name == "newcat") {echo 'display: block;';} else {echo 'display: none;';} ?>" value="<?php echo $catinput; ?>" id="catinput" type="text" name="catinput" onkeyup="catValid()" onclick"catValid()" onchange="catValid()" /></td>
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
            <!-- Input field for productname -->
            <tr>
              <td><input value="<?php echo $name; ?>" id="productname" type="text" name="name" onkeyup="productnameValid()" onclick"productnameValid()" onchange="productnameValid()" /></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle"><?php echo $productnameErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" id="productnameErr">Ongeldige productnaam</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($nameErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige productnaam</td>
            </tr>
            <tr>
              <td class="dataname">Artikelnummer</td>
            </tr>
            <!-- Input field for serial number -->
            <tr>
              <td><input value="<?php echo $serial_number; ?>" id="serial_number" type="text" name="serial_number" onkeyup="serialValid()" onclick"serialValid()" onchange="serialValid()" /></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle"><?php echo $serErr; ?></td>
            </tr>
            <tr>
              <td class="errorstyle" id="serialnumberErr">Ongeldig artikelnummer</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($serialErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldig artikelnummer</td>
            </tr>
            <tr>
              <td class="dataname">Beschrijving</td>
            </tr>
            <!-- Input field for description -->
            <tr>
              <td><textarea rows="20" cols="37" class="description" id="descrip" type="text" name="description" value="<?php echo $description; ?>" onkeyup="descripValid()" onclick"descripValid()" onchange="descripValid()"><?php echo $description; ?></textarea></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="descripErr">Ongeldige beschrijving</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($descErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige beschrijving</td>
            </tr>
            <tr>
              <td class="dataname">Specificaties</td>
            </tr>
          </table>
          <table class="specsTable" id="specsTable">
            <?php
            $i = 0;
            /* Sets all specs into inputfields */
            foreach($allspecs as $row) {
              $numberOfSpecs++;
              $sqlid = "SELECT spec_name FROM specs WHERE spec_id = '$row[0]'";
              $queryid = $globalDB->prepare($sqlid);
              $queryid->execute();
              $specnamein = $queryid->fetch();
              $specname = $specnamein[0];

              $sqlid = "SELECT value_char FROM spec_values WHERE value_id = '$row[1]'";
              $queryid = $globalDB->prepare($sqlid);
              $queryid->execute();
              $specvaluein = $queryid->fetch();
              $specvalue = $specvaluein[0];

              /* Sets specs, specvalues and errors into rows */
              print ('
              <tr>
                <td><input class="movespecs2" value="'.$specname.'" id="spec'.$i.'" name="spec'.$i.'" type="text" placeholder="Dichtheid kg*m^-3" onkeyup="newspecValid('.$i.')" onclick"newspecValid('.$i.')" onchange="newspecValid('.$i.')" /></td>
                <td><input class="movespecs" value="'.$specvalue.'" id="specvalue'.$i.'" name="specvalue'.$i.'" type="text" placeholder="12,55" onkeyup="newspecvalueValid('.$i.')" onclick"newspecvalueValid('.$i.')" onchange="newspecvalueValid('.$i.')" /></td>
              </tr>
              <tr>
                <td class="errorstyle" style="display: none;" id="specErr'.$i.'">Ongeldige specificatie</td>
              </tr>
              <tr>
                <td class="errorstyle" style="display: none;" id="specvalueErr'.$i.'">Ongeldige specificatiewaarde</td>
              </tr>
              ');
              $i++;
            }
            /* Saves number of spec rows */
            print ('
              <tr>
                <input type="text" style="display: none;" name="numberOfSpecs" id="numberOfSpecs" value="'.$numberOfSpecs.'" />
              </tr>
            ')
             ?>
            <!-- Buttons to change number of spec input fields -->
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
              <td class="dataname">Voorraad</td>
            </tr>
            <!-- Input field for the supply -->
            <tr>
              <td><input value="<?php echo $supply; ?>" type="text" id="supply" name="supply" placeholder="100" onkeyup="supplyValid()" onclick"supplyValid()" onchange="supplyValid()" /></td>
            </tr>
            <!-- Rows with possible errors (Javascript and PHP) for the input field -->
            <tr>
              <td class="errorstyle" id="supplyErr">Ongeldige voorraad</td>
            </tr>
            <tr>
              <td class="errorstyle" style="<?php if($supplyErr == true) {echo 'display: block;';} else {echo 'display: none;';} ?>">Ongeldige voorraad</td>
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
          <table>
              <tr>
                <!-- Buttons to submit or go back -->
                <td><a class="discardchanges" href="adminproducten.php">Annuleer</a></td>
                <td><button class="savechanges" type="submit" id="register" onclick="editproductvalidator()">Wijzig</button></td>
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

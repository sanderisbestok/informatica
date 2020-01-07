<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         adminproducten.php
Description;  List of products
Usage;        Look at the products and click on them to change the details of that product
-->

<?php include_once('./globalUI/globalConnect.php');
      include_once('./stools/cartTools.php');
?>

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

  /* Count products to be able to switch between pages */
  $sqlcount = "SELECT COUNT(product_id) FROM products";
  $querycount = $globalDB->prepare($sqlcount);
  $querycount->execute();
  $countin = $querycount->fetch();
  $count = $countin[0];
  $productsperpage = 20;

  include("stools/pagingTools.php");
  $productstart = pagingSetup($pagecount, $count, $next, $previous, $nextpage, $previouspage, $page, $productsperpage, $_SERVER["REQUEST_URI"]);
?>

<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Producten</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/product.css" />
    <link rel="stylesheet" href="style/adminuser.css" />
  </head>

  <body>
    <?php
      include ('./globalUI/header.php');
    ?>
    <script src="scripts/search.js"></script>
    <div class="container">
      <div class="content order-history">
        <?php
        /* Retrieves the products that should be displayed */
        $sql = "SELECT product_id, category_id
                  FROM products
                ORDER BY serial_number * 1
                LIMIT $productstart, $productsperpage";
        $query = $globalDB->prepare($sql);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table class="orderedproducts">
          <h1>Producten</h1>
          <a href="admin.php" class="backtoadmin">Terug</a>
          <form name="search" id="search" class="searchnames" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Zoek op productnaam: <input type="text" id="searchSurnames" class="searchnames" name="searchSurnames" onkeyup="getProducts(this.value)" onchange="getProducts(this.value)" />
          </form>
          <thead>
            <tr>
              <th>Artikelnummer</th>
              <th>Naam</th>
              <th>Beschrijving</th>
              <th>Prijs</th>
              <th>Categorie</th>
              <th>Voorraad</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($data as $product){
                $product_info = getProductAll($product['product_id']);
                $visible = $product_info["visible"];
                $orange = "";
                if($visible == 0) {
                  $orange = "invisible";
                }
                $price = calculatePrice($product_info['price']);
                $category_name = getCategoryName($product['category_id']);
                $short_desc = substr($product_info['description'], 0, 65);
                /* Show more information about each product in a row */
                echo "
                  <tr class='table-row $orange' name='product_rowall' onclick=window.location.href='adminproductwijzigen.php?product_id=".$product['product_id']."'>
                    <td data-label=Artikelnummer>".$product_info['serial_number']."</td>
                    <td data-label=Naam>".$product_info['name']."</td>
                    <td data-label=Beschrijving>".$short_desc."...</td>
                    <td data-label=Prijs>&euro;".$price['price_eur'].",".$price['price_cent']."</td>
                    <td data-label=Categorie>".$category_name['category_name']."</td>
                    <td data-label=Voorraad>".$product_info['supply']."</td>
                  </tr>
                ";
              }
             ?>
          </tbody>
          <tbody class="searchProducts"></tbody>
        </table>
        <div class="row">
          <div class="c-12" id="switchpage">
            <!-- Links to switch between pages -->
            <a class="previous" <?php echo ($previous==false)?'hidden':'' ?> href="adminproducten.php?page=<?php echo $previouspage; ?>">Vorige pagina</a>
            <a class="next" <?php echo ($next==false)?'hidden':'' ?> href="adminproducten.php?page=<?php echo $nextpage; ?>">Volgende pagina</a>
          </div>
        </div>
      </div>
    </div>
    <?php
      include ('./globalUI/footer.php');
    ?>
  </body>
</html>

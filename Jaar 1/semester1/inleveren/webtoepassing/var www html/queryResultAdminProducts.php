<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         queryResultAdminProducts.php
Description;  Searches products matching user input typed in admin panel products search form.
Usage;        n/a
-->
<?php
include("globalUI/globalConnect.php");
include_once('./stools/cartTools.php');

  /* Searches for products that match the query */
  $stmt = $globalDB->prepare("SELECT product_id, category_id
                              FROM products
                              WHERE name
                              LIKE ?
                              ORDER BY name");
  $stmt->bindValue(1, "%" . $_GET['q'] . "%", PDO::PARAM_STR);
  $stmt->execute();
  $results = $stmt->fetchAll();

  if (sizeof($results) > 0) {
    foreach($results as $product){
      $product_info = getProductAll($product['product_id']);
      $price = calculatePrice($product_info['price']);
      $category_name = getCategoryName($product['category_id']);
      $short_desc = substr($product_info['description'], 0, 65);
      /* Makes a row with all the requested information */
      echo "
        <tr class='table-row' name='product_rowsel' onclick=window.location.href='adminproductwijzigen.php?product_id=".$product['product_id']."'>
          <td data-label=Artikelnummer>".$product_info['serial_number']."</td>
          <td data-label=Naam>".$product_info['name']."</td>
          <td data-label=Beschrijving>".$short_desc."...</td>
          <td data-label=Prijs>&euro;".$price['price_eur'].",".$price['price_cent']."</td>
          <td data-label=Categorie>".$category_name['category_name']."</td>
          <td data-label=Voorraad>".$product_info['supply']."</td>
        </tr>
      ";
    }
  }
?>

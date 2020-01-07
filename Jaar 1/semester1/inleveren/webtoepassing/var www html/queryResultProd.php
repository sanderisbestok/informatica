<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         queryResultProd.php
Description;  Searches products matching user input typed in header search form.
Usage;        n/a
-->
<?php
include("globalUI/globalConnect.php");

$stmt = $globalDB ->prepare("
    SELECT products.product_id, products.name, media.path
      FROM products
    INNER JOIN products_media
      ON products.product_id = products_media.product_id
    INNER JOIN media
      ON products_media.media_id = media.media_id
    WHERE products.name
    LIKE ? AND visible = 1
    LIMIT 20
  ");
  $stmt->bindValue(1, "%" . $_GET['q'] . "%", PDO::PARAM_STR);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (sizeof($results) > 0) {
    foreach ($results as $row) {
    echo "
    <li>
      <a href=product.php?product_id=$row[product_id]>
        <div class='row'>
        <div class='categoryListing actionElem ch-12'>
          <img class='popSearch' src='$row[path]' alt='$row[name]' class='c-4'/>
          $row[name]
        </div>
        </div>
      </a>
    </li>";
    }
  } else {
    echo "<p>Geen resultaten</p>";
  }
?>

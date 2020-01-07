<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         cat.php
Description;  List of categories for people without javascript
Usage;        Look at the categories and click on them to go to that category
-->

<?php include_once("./globalUI/globalConnect.php") ?>

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

        <div id="catPopup">
          <ul>
          <?php
          /* Gets all categories */
          $stmt = $globalDB->prepare('SELECT category_id, category_name
            FROM categories ORDER BY category_id');
          $stmt->execute();

          $product_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

          /* Puts each category in the list */
          foreach($product_category as $i) {
            $categories=$i["category_id"];
            $category_name=$i["category_name"];
            echo "<li><a href=categorieen.php?category_id=$categories><div class='categoryListing actionElem'>$category_name</div></a></li>";
          }
          ?>
          </ul>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

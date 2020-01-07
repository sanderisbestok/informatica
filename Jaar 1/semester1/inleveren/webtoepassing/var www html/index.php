<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         index.php
Description;  Home page.
Usage;        n/a
-->
<?php include("globalUI/globalConnect.php"); ?>
<!DOCTYPE html>
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

        <h1>Uitgelicht</h1>
        <div class="hi">
          <div class="row">
            <?php
              /* Fetch random product from database */
              $product = $globalDB->query("
              SELECT products.product_id, products.name, products.description, media.name, media.path
              FROM products
              INNER JOIN products_media ON products.product_id = products_media.product_id
              INNER JOIN media ON products_media.media_id = media.media_id
              WHERE visible = 1
              ORDER BY RAND()
              LIMIT 1
              ")->fetch(PDO::FETCH_ASSOC);

              echo "
              <a href='product.php?product_id=$product[product_id]'>
                <img src='$product[path]' alt='$product[name]' class='c-4'/>
              </a>
              <span class='c-8'>
                <a href='product.php?product_id=$product[product_id]'>
                  <h2 class='hiHeader'>$product[name]</h2>
                </a>
                <p>$product[description]</p>
                <a href='product.php?product_id=$product[product_id]'>
                  <button type='button' class='more'>Meer info...</button>
                </a>
              </span>";
            ?>
          </div>
        </div>

        <h1>Nieuw</h1>
        <div class="slider">
          <ul>
            <?php
              /* Fetch last added products to database */
              $product = $globalDB->query("
              SELECT products.product_id, products.name, products.supply, prices.price, products.description, media.name, media.path
              FROM products
              INNER JOIN products_media
              ON products.product_id = products_media.product_id
              INNER JOIN media
              ON products_media.media_id = media.media_id
              INNER JOIN prices
              ON products.product_id = prices.product_id
              WHERE visible = 1
              ORDER BY products.product_id
              DESC
              LIMIT 8
              ")->fetchAll(PDO::FETCH_ASSOC);

              /* Show first sentence of descritpion for each product */
              foreach ($product as $row) {
                $short_description = preg_replace('/([^?!.]*.).*/', '\\1', $row['description']);

                echo "
                <a href='product.php?product_id=$row[product_id]'>
                  <li>
                    <div>
                        <img src='$row[path]' alt='$row[name]'>
                    </div>";

                    /* Determine supply for product */
                    if ($row['supply'] > 0) {
                      echo "<p class=stock>Op voorraad</p>";
                    } else {
                      echo "<p class=not-in-stock>Niet op voorraad</p>";
                    }
                    echo "
                    <p class='listing-short-description'>$short_description</p>
                  </li>
                </a>";
              }
            ?>
          </ul>
        </div>

        <h1>Bestverkocht</h1>
        <div class='top'>
          <?php
            /* Show most ordered products by using occurence of product_id in *
             * orders */
            $product = $globalDB->query("
            SELECT products_orders.product_id, count(products_orders.product_id) as count, media.name, media.path
            FROM products_orders
            INNER JOIN products_media
            ON products_orders.product_id = products_media.product_id
            INNER JOIN media
            ON products_media.media_id = media.media_id
            INNER JOIN products
            ON products.product_id = products_orders.order_id
            WHERE products.visible = 1
            GROUP BY products_orders.product_id
            ORDER BY count
            DESC
            LIMIT 5
            ")->fetchAll(PDO::FETCH_ASSOC);

            $rank=0;

            foreach ($product as $row) {
              $rank = ($rank + 1);

              echo "
              <span class='listing-product listing-product-fp'>
                <a href='product.php?product_id=$row[product_id]'>
                  <h2 class='topHeader'>$rank. </h2>
                  <h3 class='topHeader'>$row[name]</h3>
                  <img class='topImg' src='$row[path]' alt='$row[name]'>
                </a>
              </span>
              ";
            }
          ?>
        </div>
      </div>
    </div>
    <?php include('./globalUI/footer.php'); ?>
  </body>
</html>

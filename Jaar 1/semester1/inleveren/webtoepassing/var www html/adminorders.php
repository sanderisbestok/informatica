<!--
Authors;      Jens Kalshoven, Rico Hoegee, Pim Hordijk, Frederick Kreuk en Sander Hansen
Name;         adminorders.php
Description;  List of orders
Usage;        Look at the orders and click on them to get more details on that order
-->

<?php include('./globalUI/globalConnect.php'); ?>
<?php include('./stools/orderTools.php'); ?>
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
  if(intval($privlevel) < 4){
    header("Location: index.php");
    die();
  }

  /* Gets the count for the pages */
  $sqlcount = "SELECT COUNT(order_id) FROM orders";
  $querycount = $globalDB->prepare($sqlcount);
  $querycount->execute();
  $countin = $querycount->fetch();
  $count = $countin[0];
  $perpage = 20;
  $start = 0;
  include("stools/pagingTools.php");
  $start = pagingSetup($pagecount, $count, $next, $previous, $nextpage, $previouspage, $page, $perpage, $_SERVER["REQUEST_URI"]);
  $pagecount = ceil($count / $perpage);
  $next = false;
  $previous = false;
  $nextpage = 1;
  $previouspage = 1;
  if(isset($_GET['page'])) {
    $page = intval(htmlspecialchars($_GET['page']));
    if ($pagecount < $page) {
      header("Location: adminorders.php?page=$pagecount");
      die();
    } else if ($page < 1) {
      header("Location: adminorders.php?page=1");
      die();
    } else {
      $start = ($page - 1) * $perpage;
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
    header("Location: adminorders.php?page=1");
    die();
  }
  /* Retrieves orders */
  $getOrders = "SELECT order_id, date FROM orders ORDER BY date DESC LIMIT $start, $perpage";
  $stmtOrders = $globalDB->prepare($getOrders);
  $stmtOrders->execute();
  $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
  foreach($orders as $order){
    $orderinfo[$order["order_id"]] = getOrder($order["order_id"]);
  }
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <title>Orders</title>
    <?php include ('./globalUI/globalReqs.php'); ?>
    <link rel="stylesheet" href="style/search.css" />
    <link rel="stylesheet" href="style/adminuser.css" />
    <link rel="stylesheet" href="style/adminproduct.css" />
    <link rel="stylesheet" href="style/order.css" />
    <link rel="stylesheet" href="style/product.css" />
    <script type="text/javascript" src="scripts/registervalidation.js" ></script>
    <script type="text/javascript" src="scripts/orders.js" ></script>
  </head>

  <?php include ('./globalUI/header.php'); ?>

  <div class="container">
    <div class="content">
      <h1>Bestellingen</h1>
      <div id="mainView" class="row">
        <div id="params" class="c-3">
          <!-- Filter for the orders -->
          <form id="select" action="<?php print(htmlspecialchars($_SERVER["PHP_SELF"])); ?>" method="POST">
            <input type="text" name="search" class="bodSearch" onkeyup="queryOrders()" placeholder="zoek gebruiker" /><br /><br />
            <input type="checkbox" name="pay" onchange="queryOrders()"/> Betaling<br />
            <input type="checkbox" name="prep" onchange="queryOrders()"/> Voorbereiden<br />
            <input type="checkbox" name="preps" onchange="queryOrders()"/> Verzending voorbereiden<br />
            <input type="checkbox" name="sent" onchange="queryOrders()"/> Verzonden<br />
            <input type="checkbox" name="del" onchange="queryOrders()"/> Afgeleverd<br />
            <input type="checkbox" name="canc" onchange="queryOrders()"/> Geannuleerd<br />
            <input type="submit" name="Filter" class="grey noJS" />
          </form>
        </div>
        <div id="content" class="c-8">
          <table class="orders c-12">
            <thead>
              <tr>
                <th>Nummer</th>
                <th>Belasting</th>
                <th>Aantal</th>
                <th>Prijs</th>
                <th>Datum</th>
                <th>Status</th>
                <th>Gebruiker</th>
              </tr>
            </thead>
            <tbody id="orderRows">
              <?php
                foreach($orderinfo as $orderId => $order){
                  $tax = $order["tax_rate"];
                  $amount = $order["amount"];
                  $date = $order["date"];
                  $price = calculatePrice($order["price"]);
                  $user = getShortUser($order["user_id"]);
                  $state = $order["state"];
                  /* Puts the information about an order into a row */
                  echo "
                    <tr class='table-row' onclick=window.location.href='adminorderdetail.php?order_id=".$orderId."'>
                      <td data-label=Bestelnummer>".$orderId."</td>
                      <td data-label=Belasting>".$tax."</td>
                      <td data-label=Aantal>".$amount."</td>
                      <td data-label=Prijs>&euro;".$price["price_eur"].",".$price["price_cent"]."</td>
                      <td data-label=Datum>".$date."</td>
                      <td data-label=Status>".$state."</td>
                      <td data-label=Gebruiker>".$user["title"]." ".$user["initials"]." ".$user["surname"]."</td>
                    </tr>
                  ";
                }
               ?>
            </tbody>
          </table>
          <div class="row">
            <div class="c-12">
              <!-- Links to switch between pages -->
              <a class="previous" <?php echo ($previous==false)?'hidden':'' ?> href="adminorders.php?page=<?php echo $previouspage; ?>">Vorige pagina</a>
              <a class="next" <?php echo ($next==false)?'hidden':'' ?> href="adminorders.php?page=<?php echo $nextpage; ?>">Volgende pagina</a>
            </div>
          </div>
        </div>
      </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    include ('./globalUI/footer.php');
  ?>
  </body>
</html>

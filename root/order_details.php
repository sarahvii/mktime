<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    session_start();
    include('include/head.php');
    include('include/navbar.php');
    ?>
  </head>

  <body>
    <div class="container">
<!-- Content here -->
  <?php
 
        //connect to db
        require('connect_db.php');
	  
	    // get order id from URL
		$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		// fetch order details
    $sql = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = mysqli_query($link, $sql);

	  echo'<h1>Order Details</h1>';
	  
	    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
	  echo '	<h5 class="card-title">Order # '.$row["order_id"].'</h5>
				<p class="card-text">Order date: '.$row["order_date"].'</p>
				<p class="card-text">Total Cost: £'.$row["total"].'</p>
				<h6 class"card-title">Items Ordered:</h6>';
				
$sql_items = "SELECT oc.*, p.product_name, p.product_img, p.product_price 
              FROM order_contents oc
              JOIN products p ON oc.product_id = p.product_id
              WHERE oc.order_id = $order_id";
            $result_items = mysqli_query($link, $sql_items);

            if (mysqli_num_rows($result_items) > 0) {
				echo '<div class="row">';
                while ($row_items = mysqli_fetch_assoc($result_items)) {
                echo '<div class="col-md-3 d-flex justify-content-center">
						<div class="card" style="width: 18rem; margin: 5px;">
						<p class="card-text"><strong>' . $row_items["product_name"] . '</strong></p>
						<p class="card-text">Quantity: ' . $row_items["quantity"] . '</p>
						<p class="card-text">Price: £' . $row_items["product_price"] . '</p>
						<img src="' . $row_items["product_img"] . '" alt="' . $row_items["product_name"] . '" width="50" height="50">
						</p>
						</div>
						</div>
					'; }			
            } else {
                echo '<p class="card-text">No items found in this order.</p>
				</div>';
				   }
			
    } else {
      echo "Order not found.";
    }
	
    mysqli_close($link);
    ?>
	</div>
	</div>
   <?php include('include/footer.php'); ?>
 
  </body>
</html>

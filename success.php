<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Success</title>
<link href="main.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>

<h2>Din ordre er modtaget!</h2>


<div class="container" style="border-width: 1px;border-style: solid;border-color:black;">
<h4>Kvittering</h4>
<hr>
<?php

require_once('db_con.php');
	
	// henter order_id fra vores session 
$order_id = $_SESSION['order_id'];
	
$sql = 
	'SELECT product.id, product.name, product.price, order_items.order_id, order_items.product_id, order_items.quantity
	FROM order_items, product 
	WHERE product.id = order_items.product_id AND '.$order_id.' = order_items.order_id';
	
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->bind_result($pid, $name, $price, $oioid, $oipid, $quantity);
	
while ($stmt->fetch()){
		echo 'Produkt: ';
		echo $name ;
		echo ' Pris: ';
		echo $price;
		echo 'DKK';
		echo ' Antal: ';
		echo $quantity ;
		echo '<hr>';
	
		
}
?>

<?php 
	
	// ganger antal og pris
	$sql = 'SELECT sum(order_items.quantity * product.price)
			FROM order_items, product WHERE product.id = order_items.product_id AND '.$order_id.' = order_items.order_id';
	
	$stmt = $con->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($total);
	
while ($stmt->fetch()){
	echo 'Total : ';
	echo $total;
	echo 'DKK';
	echo '<br /><br />';
}
	?>

<a href="index.php"><button>Tilbage</button></a>
</div>
</body>
</html>
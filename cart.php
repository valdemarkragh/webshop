<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="main.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<title>Kurv</title>
</head>

<body>


<h2>Kurv</h2>

<div class="container" style="border-width: 1px;border-style: solid;border-color:black;">

<?php

require_once('db_con.php');

	// Hvis session er tom -> return false
if($_SESSION['cart'] == null)
{
	
	echo '<br />';
	echo 'Kurven er tom';
	echo '<br /><br />';
	echo '<a href="index.php"><button>Tilbage</button></a>';
	return FALSE;
	
}	

if(filter_input(INPUT_GET, 'new_order')) {
		
	$sql = 'INSERT INTO orders (id) VALUES (NULL)';
	$stmt = $con->prepare($sql);
	$stmt->execute();
	$order_id = $con->insert_id;
	
	// hvis order_id er set
	if(isset($order_id)) {
		// kører vores session igennem foreach løkke
		foreach($_SESSION['cart'] as $val) {
			
			$sql = 'INSERT INTO order_items (order_id, product_id, quantity) VALUES (?,?,?)';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iii', $order_id, $val['id'], $val['quantity']);
			$stmt->execute();
			
			
		}
		
		// redirecter til success.php
		
		echo "<script type=\"text/javascript\"> setTimeout(function () {
   				window.location.href= 'success.php';
				}, 0); </script>"; 
		
		$_SESSION['cart'] = null;
		$_SESSION['order_id'] = $order_id;
	}
		
	
}
	

  // hvis delete -> unset valgt id fra session
if(filter_input(INPUT_GET, 'delete')) {
		unset($_SESSION['cart'][$_GET['id']]);
}
						  
if(filter_input(INPUT_GET, 'update')) {
	
		$quantity = 'quantity' . $_GET['id'];
		$_SESSION['cart'][$_GET['id']]['quantity'] = $_POST[$quantity];
};


    
    foreach ($_SESSION['cart'] as $val){
			$id = $val['id'];
		
			$sql = "SELECT name, price FROM product WHERE id='$id'";
			$stmt = $con->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($name, $price);
	
			while($stmt->fetch());
		
			echo '<form method="POST" action="cart.php?id='.$id.'&update=yes">';
			echo '<br />'  . $name . ' Antal: ' . '<input name="quantity' . $id . '" type="text" value="' . $val['quantity'] . '"/>';
			echo '<button name="update" type="submit" value="update">Opdater</button>';
			echo '<a href="cart.php?id='.$id.'&delete=yes"><button name="Delete" type="button" value="delete">Fjern</button></a>';
			echo ' Pris:';
			$sum_total =  $price * $val ['quantity'];
			echo $sum_total;
			echo '<br />';
			echo '<br />';
			echo '</form>';
			
	}	
?>
<?php 
	
	// hvis price og antal = 0 -> sæt 0
	if (empty($price)) $price =''; 
	if (empty($val['quantity'])) $val['quantity'] ='';  
?>


 
<a href="cart.php?new_order=yes"><button name="submit" id="indsend" value="indsend">Send ordre</button></a>
<a href="index.php"><button>Tilbage</button></a>
</div>
</body>
</html>

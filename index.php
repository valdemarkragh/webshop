<?php session_start(); ?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Produkter</title>
<link href="main.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>


<h2>Produkter</h2>
<div class="container">
<?php 
require_once('db_con.php');

// select * fra product table

$sql = 'SELECT id, name, thumbnail, price FROM product';
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $name, $thumbnail, $price);
	
	while($stmt->fetch()){ 
?>	


<table border="2">
<tr><th><?php echo $name; ?></th></tr>
<tr><th><img src="images/<?php echo $thumbnail; ?>" width="300" height="200" /></th></tr>
<tr><th>Pris: <?php echo $price; ?>.-</th></tr>

<tr><th><a href="index.php?id=<?php echo $id; ?>&add=yes"><button name="add" type="submit" value="add">Tilføj Produkt</button></th></tr>


<?php
}
?>
<?php
	// hvis array er tomt = 0
if (empty($_SESSION['cart'])) $_SESSION['cart'] ='';


if(filter_input(INPUT_GET, 'add')) {
	
	// henter id fra url
	$_SESSION['cart'][$_GET['id']]['id'] = $_GET['id'];
	
	// tilføjer 1 til quantity
	if(!isset($_SESSION['cart'][$_GET['id']]['quantity'])) { 
		$_SESSION['cart'][$_GET['id']]['quantity'] = 1;
	} else {
		$_SESSION['cart'][$_GET['id']]['quantity'] += 1;
	}

}
	// reset session hvis clear cart
if(filter_input(INPUT_GET, 'clear_cart')) {
	$_SESSION['cart'] = null;
}
?>

<div class="cart"><h4>Kurv</h4>

<hr>

<div class="cartvarity"
<?php
	

	// Kører $_SESSION array hvis det er et array 
	if(is_array($_SESSION['cart'])){
	// viser alle vare i session array 
    foreach ($_SESSION['cart'] as $val) 
	echo '<hr>' . 'Produktnr: ' . $val['id'] . ' Antal: ' . $val['quantity'];
	echo '<hr>';
	
	}
?>
 </div>
<div class="cartbuttons">

<a href="cart.php"><button>Se Kurv</button></a>
<a href="index.php?id=<?php echo $id; ?>&clear_cart=yes"><button name="clear_cart" type="submit" value="clear_cart">Tøm Kurv</button></a>
</div>

	
	</div>
</div>
	</div>
</body>
</html>
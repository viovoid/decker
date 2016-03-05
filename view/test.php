<html>
<title>Decker</title>
<body>
<?php
echo "Test!";
$_controller = new Controller();
$pool = $_controller->getPool();
print_r($cards);
foreach($pool as $index => $card) {
	echo $index . $card->name . "<br>";
}
?>

</body>
</html>

<?php
echo "Deck size: " . $size . "<br>";
echo "Colors: ";
foreach($colors as $color) {
	echo $color;
}
echo "<br>Cards in pool in color:<br>";
foreach($colorPool as $index => $card) {
	echo $index+1 . " " . $card->name . "<br>";
}
?>

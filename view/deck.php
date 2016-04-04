<font color="white">
<?php
echo "Deck size: " . $size . "<br>";
echo "Colors: ";
foreach($colors as $color) {
	echo $color;
}
echo "<br>Deck list:<br>";
foreach($deck as $index => $card) {
	echo $index+1 . " " . $card->name . "<br>";
}
?>
</font>

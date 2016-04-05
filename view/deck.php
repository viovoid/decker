<font color="white">
<table border="1" bgcolor="#808080">
	<tr
<?php
echo "<tr><td>Deck size:</td><td>" . $size . "</td></tr>";
echo "<tr><td>Colors:</td><td>";
foreach($colors as $color) {
	echo $color;
}
?>
</td></tr>
</table>
<table border="1" bgcolor="#808080">
	<tr>
		<th colspan="2">Deck list</th>
	</tr>

<?php
foreach($deck as $index => $card) {
	echo "<tr>
			<td>" . ($index+1) . "</td>
			<td>" . $card->name . "</td>
		</tr>";
}
?>
</table>
</font>

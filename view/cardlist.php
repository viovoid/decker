<html>
<head></head>

<body>

<form name="deckForm" method="post" action="deck.php">
<div style="overflow: auto; width:420px; height:700px; float:left"><table>
	<tr><td>In Pool</td><td>Index</td><td>Name</td><td>Mana Cost</td></tr>
	<?php 

		foreach ($cards as $index => $card)
		{
			echo '<tr>';
			echo '<td><select name="selectCount">'
					.'<option selected="selected" value="0">0</option>'
					.'<option value="1">1</option>'
					.'<option value="2">2</option>'
					.'<option value="3">3</option>'
					.'<option value="4">4</option>'
					.'<option value="5">5</option>'
					.'<option value="6">6</option>'
					.'<option value="7">7</option>'
					.'<option value="8">8</option>'
					.'<option value="9">9</option>'
					.'<option value="10">10</option>'
					.'<option value="11">11</option>'
					.'<option value="12">12</option>'
				.'</select></td>';
			echo '<td align="right">'.$card->index.'</td><td><a href="index.php?card='.$card->name.'">'.$card->name.'</a></td>';
			echo '<td>'.$card->manaCost.'</td></tr>';
		}

	?>
</table></div>

<div style="float:left">
Deck size<br>
<input type="radio" name="size" value="40" checked>40<br>
<input type="radio" name="size" value="60" checked>60<br>
<br>Colors<br>
<input type="checkbox" name="colors" value="W">W<br>
<input type="checkbox" name="colors" value="U">U<br>
<input type="checkbox" name="colors" value="B">B<br>
<input type="checkbox" name="colors" value="R">R<br>
<input type="checkbox" name="colors" value="G">G<br>
<br>
<input type="submit" value="Deck!">
</div>
</form>

</body>
</html>
